# APMO ERP (v32) — New & Remaining Bugs Report

> Scope: Static code review of **apmoerpv32.zip** (Laravel **12.44.0**, Livewire **4.0.1**).
> Database/seeders not analyzed (per request), except when needed to reason about runtime behavior.

## Quick summary (what you’ll find)

- **3 critical data-integrity / correctness risks** (inventory & numbering) that can create **silent corruption** (wrong stock totals, duplicate document numbers).
- **1 high-impact finance/reporting issue**: Branch P&L uses `created_at` instead of business dates, which makes period reports wrong for backdated transactions.
- Several **medium** issues around **float usage for quantities/money** and **reporting logic** (stock aging).

---

## Framework versions

- **Laravel**: `12.44.0` (from `composer.lock`)
- **Livewire**: `4.0.1` (from `composer.lock`) ✅ *Project is upgraded to Livewire v4.0.1.*
  - As of mid‑January 2026, `v4.0.1` is also the latest tagged release upstream (per Livewire’s GitHub releases).

---

## Regression check (previous bugs appear fixed)

These items were explicitly checked and **do not appear** in v32 as code-level regressions:

- Branch route model binding no longer breaks middleware branch resolution (middleware now accepts either ID or model).
  - `app/Http/Middleware/SetBranchContext.php`
- Branch context leakage via API webhooks mitigated by clearing context middleware and/or terminable middleware.
  - `bootstrap/app.php`, `routes/api.php`, `app/Http/Middleware/AuthenticateStoreToken.php`
- API stock update no longer overwrites total `products.stock_quantity` with warehouse-specific numbers.
  - `app/Http/Controllers/Api/V1/InventoryController.php`

> Note: The list above is only a regression sanity-check. The rest of this report lists **new bugs and/or still-unfixed bugs** found in v32.

---

# Bugs (new + still-unfixed)

Severity scale: **CRITICAL / HIGH / MEDIUM / LOW**


## CRITICAL

### V32-CRIT-01 — Stock movements created via StockService do NOT update products.stock_quantity cache

**File(s):** `app/Services/StockService.php; used by app/Services/SalesReturnService.php, app/Services/StockTransferService.php`

**Line(s):** StockService.php:L251–L295; SalesReturnService.php:L331–L363; StockTransferService.php:L267–L278

**Problem**

`StockService::adjustStock()` creates `StockMovement` directly (Eloquent create) and does **not** call `StockMovementRepository::updateProductStockCache()` (nor is there a StockMovement observer that updates the cache).

However, the system clearly depends on `products.stock_quantity` as a denormalized cache (the repository updates it). This creates inconsistency between flows that use the repository and flows that use StockService (notably: **stock transfers** and **sales return restocking**).

**Impact**

- **Silent stock mismatch**: `products.stock_quantity` becomes stale after transfers/returns done via StockService.
- **Low stock alerts / dashboards / API responses** can be wrong.
- Integrity checks will report mismatches and operators will lose trust in inventory numbers.

**Recommended fix**

Refactor so all writes go through one path:
- Option A (preferred): Inject `StockMovementRepositoryInterface` into `StockService` and replace `StockMovement::create()` with `$repo->create(...)` (with direction/qty mapping).
- Option B: Add an Eloquent `created` observer on `StockMovement` that recomputes product cache (be careful with performance; may need batching/debouncing).
- Option C: After creating the movement, explicitly call a shared `updateProductStockCache($productId)` method.

---

### V32-CRIT-02 — No validation that warehouse belongs to the same branch as the product (cross-branch inventory corruption)

**File(s):** `app/Repositories/StockMovementRepository.php`

**Line(s):** StockMovementRepository.php:L120–L183

**Problem**

`StockMovementRepository::create()` validates that the **warehouse exists** but does **not** validate the **relationship** between entities (e.g., product.branch_id vs warehouse.branch_id).

In a multi-branch ERP, allowing a stock movement for a product in a warehouse belonging to another branch will corrupt stock totals, aging, reports, and audit trails.

**Impact**

- Stock can be added/removed from the wrong branch’s warehouse for the same product ID.
- Branch stock reports become unreliable.
- Hard-to-debug accounting/inventory discrepancies across branches.

**Recommended fix**

Before creating the movement, load both entities (or join) and enforce integrity:
- If `products.branch_id` is not null → require `warehouses.branch_id == products.branch_id`.
- If products can be “global” (branch_id null), define and enforce the rule explicitly.
Also consider DB-level constraints where possible (composite constraints via triggers or application-level invariants).

---

### V32-CRIT-03 — Document number generators use lockForUpdate() without ensuring an outer DB::transaction (duplicates possible)

**File(s):** `Multiple models (creating hooks)`

**Line(s):** See files/lines below

**Problem**

Several entities generate sequential document/reference numbers in `creating` hooks using `lockForUpdate()`.

**Problem:** If the caller is not already inside an explicit `DB::transaction()`, the `SELECT ... FOR UPDATE` is executed under autocommit and does **not** protect the subsequent `INSERT` from a race where two requests compute the same next sequence.

Affected examples (non-exhaustive):
- `app/Models/SalesReturn.php` (L67–L98)
- `app/Models/PurchaseReturn.php` (L74–L105)
- `app/Models/CreditNote.php` (L68–L107)
- `app/Models/DebitNote.php` (L73–L106)
- `app/Models/GoodsReceivedNote.php` (L46–L62)
- `app/Models/StockTransfer.php` (L105–L139)

**Impact**

- Duplicate document numbers under concurrency (POS, API sync bursts, multi-user approvals).
- Downstream reconciliation breaks (accounting references, external integrations, audit logs).
- Hard failures if a unique index exists / or silent duplicates if not.

**Recommended fix**

Hardening options:
- Ensure all creates of these models are wrapped in a `DB::transaction()` at service/controller level (and keep number generation inside that transaction).
- Prefer a dedicated **sequence table** per document type and use atomic `UPDATE ... SET seq = seq + 1` returning the new value.
- Add a DB **unique index** on the number column and retry on conflict (optimistic locking approach).

---


## HIGH

### V32-HIGH-01 — Branch P&L uses created_at instead of business dates (sale_date / purchase_date)

**File(s):** `app/Http/Controllers/Branch/ReportsController.php`

**Line(s):** ReportsController.php:L60–L85

**Problem**

`pnl()` filters by `whereDate('created_at', ...)` for both `sales` and `purchases`.

In ERP, reports must use the **business transaction date** (`sale_date`, `purchase_date`, `invoice_date`, etc.) otherwise backdated / corrected postings appear in the wrong period.

**Impact**

- Period P&L becomes wrong whenever transactions are created later than their posting date.
- Finance reconciliation across branches becomes inconsistent (especially month-end close).

**Recommended fix**

Switch the report filters to the correct business date columns (e.g., `sale_date` for sales, `purchase_date` for purchases).
If multiple date semantics exist (created vs posted), define explicitly which one finance reports use.

---

### V32-HIGH-02 — StockService adjustStock() has race condition when no stock_movements rows exist (no lock anchor)

**File(s):** `app/Services/StockService.php`

**Line(s):** StockService.php:L263–L295

**Problem**

`adjustStock()` locks `stock_movements` rows via `lockForUpdate()->sum('quantity')`.

If there are **no rows** yet for (product_id, warehouse_id), there is nothing to lock, so two concurrent transactions can both see stock_before=0 and write conflicting movements.

Also, `adjustStock()` does not validate warehouse existence (unlike the repository which fails fast).

**Impact**

- Incorrect stock_before/stock_after under concurrency (first movement race).
- Potential crashes or foreign-key failures if warehouse_id is invalid.

**Recommended fix**

Mirror the repository hardening:
- Lock the **warehouse row** first as a deterministic lock anchor.
- Fail fast if the warehouse doesn’t exist.
- Consider reusing `StockMovementRepository::create()` to centralize this logic.

---

### V32-HIGH-03 — Model method uses auth()->id() directly (breaks CLI/queue or system actions)

**File(s):** `app/Models/StockTransfer.php`

**Line(s):** StockTransfer.php:L331–L342

**Problem**

`StockTransfer::complete()` uses `auth()->id()` directly when recording status history.
If this method is called from a queued job / console command / webhook context without an authenticated user, `auth()->id()` becomes null and audit fields may be wrong or fail DB constraints.

**Impact**

- Missing or incorrect audit trail for transfer completion.
- Possible runtime exception if `created_by` (or equivalent) is non-nullable.

**Recommended fix**

Change signature to accept `$userId` explicitly (or default to a system user), and never read auth state from inside models.

---


## MEDIUM

### V32-MED-01 — API stock “set” mode uses float math and may create micro stock movements / drift

**File(s):** `app/Http/Controllers/Api/V1/InventoryController.php`

**Line(s):** InventoryController.php:L108–L146 and L301–L316

**Problem**

`calculateCurrentStock()` returns a float from SUM(quantity), and `updateStock()` computes `$difference` using floats.

With decimal quantities (casts are `decimal:4`), float conversion can produce tiny differences (e.g., 1.0000 vs 0.999999999). The code then creates a movement for any `actualQty > 0`, even if the difference is rounding noise.

**Impact**

- Extra “noise” movements in stock ledger.
- Small drift accumulates and complicates reconciliation.
- Hard to audit real vs rounding adjustments.

**Recommended fix**

Use string decimals / bcmath for qty math, and add a tolerance for “set” operations, e.g.:
- If `abs(difference) < 0.0001` → treat as no-op.
Also consider storing quantities as integer minor units where feasible.

---

### V32-MED-02 — Stock aging report logic likely inaccurate (uses MIN(created_at) across all movement types)

**File(s):** `app/Http/Controllers/Branch/ReportsController.php`

**Line(s):** ReportsController.php:L36–L58

**Problem**

`stockAging()` calculates `first_move = MIN(DATE(m.created_at))` and `qty = SUM(m.quantity)` over **all** movements.

This can be wrong because:
- Outgoing movements can set `first_move` earlier than the first inbound that created current stock.
- Aging typically needs FIFO/LIFO batches or at least inbound-only timestamps, not global MIN across signed movements.

**Impact**

- Aging buckets and slow-moving inventory decisions become misleading.
- Can over/understate how long current on-hand inventory has been in stock.

**Recommended fix**

At minimum, compute aging using inbound-only movements (`quantity > 0`) and/or maintain batch/lot tables (FIFO layers) and compute on-hand age from remaining layers.

---

### V32-MED-03 — Inventory math uses floats while DB columns are decimal:4 (rounding / precision risk)

**File(s):** `app/Repositories/StockMovementRepository.php`

**Line(s):** StockMovementRepository.php:L135–L173 and L195–L213

**Problem**

The repository casts quantities and balances to `(float)` before persisting `stock_before`, `stock_after`, and `products.stock_quantity`.

But `StockMovement` casts these as `decimal:4`. Mixing float math with decimal storage introduces rounding/truncation and can cause small mismatches that later appear as “integrity errors”.

**Impact**

- Precision drift over time (especially when quantities have 3–4 decimals).
- Periodic reconciliation required more often; false positives in integrity checks.

**Recommended fix**

Keep quantities as strings and use bcmath (or do arithmetic at DB level with DECIMAL) before persisting.
If performance is a concern, use fixed-point integers (e.g., quantity * 10000).

---


## LOW

### V32-LOW-01 — Console integrity command uses raw SQL composition (low risk but harden if expanded)

**File(s):** `app/Console/Commands/CheckDatabaseIntegrity.php`

**Line(s):** CheckDatabaseIntegrity.php:L226–L269

**Problem**

Some SQL strings are composed dynamically (e.g., `SHOW INDEX FROM {$table}` and raw WHERE fragments).
Currently inputs appear internal, but if later exposed to user-provided table names/conditions, it becomes injection-prone.

**Impact**

- Low risk today, but potential injection footgun if future options accept arbitrary input.

**Recommended fix**

Keep table names from a whitelist only, and avoid concatenating raw WHERE fragments from user input.

---


## Notes

- This is a static review; runtime-only issues (configuration, infra, external services) may exist but can’t be proven without executing flows/tests.
- If you want, I can also generate an automated checklist for QA to reproduce the high/critical cases under concurrency (two parallel requests) to confirm the race conditions.
