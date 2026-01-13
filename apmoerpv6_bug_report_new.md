# APMO ERP (apmoerpv6) — New & Unfixed Bugs Report

**Scope:** Static code review for the project extracted from `apmoerpv6.zip` (Laravel 12 + Livewire 4 beta).

**As requested:** database + seeders were not analyzed, but I still flag issues that will *definitely* break or corrupt data once the app runs (e.g., unbalanced journal entries, nullable warehouse_id in stock movements).

**This report includes ONLY:**
- **New bugs found in v6**, and
- **Bugs from the previous report(s) that are still present (unfixed)**.

---

## Critical

### V6-CRITICAL-01 — BCMath is used widely but **not required** (can hard-crash production)
**Status:** ✅ New in v6 report (dependency risk is not handled)

**Where**
- `composer.json` does **not** require `ext-bcmath` (require section around lines 8–21).
- BCMath functions are used in core paths, for example:
  - `app/Services/POSService.php` (uses `bc*` heavily; e.g. lines 171–205)
  - `app/Services/PurchaseService.php` (e.g. lines 126–142)
  - `app/Helpers/helpers.php` (e.g. `money()` uses `bcadd` at line 106; `percent()` uses `bcadd` at line 116)

**What / Why it’s a bug**
If PHP on the server does not have BCMath enabled, calls like `bcadd()` will throw a **fatal error** (`Call to undefined function bcadd()`), crashing core modules (POS, purchases, returns, jobs, helper formatting).

**Fix**
- Add to `composer.json` → `require`:
  - `"ext-bcmath": "*"`
- Ensure deployment images install/enable BCMath.

---

### V6-CRITICAL-02 — `warehouse_id` is nullable in core flows → stock movements can be created with `NULL` warehouse
**Status:** 🟠 Unfixed (was already a concern in earlier versions)

**Where**
- POS sale creation allows null warehouse:
  - `app/Services/POSService.php` lines 65–81 (`'warehouse_id' => $payload['warehouse_id'] ?? null`)
- Purchase store request allows null warehouse:
  - `app/Http/Requests/PurchaseStoreRequest.php` line 23 (`warehouse_id` is `nullable|exists:warehouses,id`)
- Stock adjustment service supports `?int $warehouseId` and writes it directly:
  - `app/Services/StockService.php` lines 134–161 (`warehouse_id` can be null and is persisted)

**Impact (ERP-critical)**
A `stock_movements` record with `warehouse_id = NULL` will:
- affect “global stock” calculations (warehouse null), but
- be ignored in per-warehouse stock calculations.

That breaks warehouse inventory accuracy and reconciliation.

**Fix**
- Make warehouse mandatory in all stock-moving flows (POS checkout, purchases, transfers, returns).
- Enforce at validation + service layer (resolve default warehouse or return 422).

---

### V6-CRITICAL-03 — Two sources of truth for stock: `products.stock_quantity` vs `stock_movements` (still drifting)
**Status:** 🟠 Unfixed

**Where**
- Dashboards/alerts rely on `products.stock_quantity`:
  - `app/Services/Dashboard/DashboardDataService.php` lines 198–224
- Sale & purchase listeners create `stock_movements` but do **not** update `products.stock_quantity`:
  - `app/Listeners/UpdateStockOnSale.php` lines 76–87
  - `app/Listeners/UpdateStockOnPurchase.php` lines 54–65

**Impact**
Inventory screens/reports that compute from movements can disagree with dashboard alerts / “low stock” warnings. This can cause overselling or over-ordering.

**Fix (choose one)**
1) Make `stock_movements` the single source of truth (compute stock everywhere).  
2) Or dual-write and update `products.stock_quantity` whenever a stock movement is created (plus reconciliation job).

---

### V6-CRITICAL-04 — Accounting journal generation can produce **unbalanced entries** (shipping/discount/partial payments)
**Status:** 🟠 Unfixed

**Where**
- Sale journal entry generation:
  - `app/Services/AccountingService.php` lines 56–152
  - Missing a line for `shipping_amount` (if sales include shipping)
- Purchase journal entry generation:
  - `app/Services/AccountingService.php` lines 166–234
  - Credits `total_amount` but debits only subtotal + tax → can be unbalanced when shipping/discount exists

**Impact**
Unbalanced journal entries break GL integrity and auditing.

**Fix**
- Add explicit lines for shipping and discounts (with configured accounts).
- Call `validateBalancedJournalEntry()` inside both `generateSaleJournalEntry()` and `generatePurchaseJournalEntry()`.

---

### V6-CRITICAL-05 — Sale return flow adjusts `Sale.paid_amount` directly without creating refund/payment reversal
**Status:** 🟠 Unfixed

**Where**
- `app/Services/SaleService.php` lines 113–118 reduces `paid_amount` directly.

**Why it’s a bug**
`Sale::updatePaymentStatus()` recalculates `paid_amount` from payment records and persists it. Without creating a negative payment/refund transaction, future recalculation will overwrite the manual value.

**Fix**
Create explicit refund payments/transactions and derive totals from them.

---

### V6-CRITICAL-06 — External order id inconsistency (API orders vs store sync) → duplicates + unreliable retrieval
**Status:** 🟠 Unfixed

**Where**
- API Orders uses `reference_number` as external_id:
  - `OrdersController` idempotency check: lines 129–144
  - `OrdersController` creates sale with `reference_number = external_id`: line 222
  - `OrdersController::byExternalId()` searches `reference_number`: lines 282–287
- Store sync uses `external_reference`:
  - `app/Services/Store/StoreSyncService.php` (e.g. `where('external_reference', ...)` around lines 305–338)

**Impact**
Same external order can be duplicated depending on ingestion path. The “get by external id” endpoint misses orders created via store sync.

**Fix**
Pick ONE canonical field for external ids and use it consistently in all flows, or add a mapping table/resolver.

---

### V6-CRITICAL-07 — Sales return module has refund validation holes + accounting integration is broken
**Status:** ✅ New in v6 report

**Where**
- Refund processing allows `amount` to be 0 and does not cap over-refund:
  - `app/Services/SalesReturnService.php` lines 183–212 (validation: `amount ... min:0`)
- Accounting entry creation passes wrong payload keys to `AccountingService::createJournalEntry()`:
  - `app/Services/SalesReturnService.php` lines 398–418 (passes `date/type/lines` instead of `entry_date/items/...`)
  - Also uses `account_id => null` placeholders (lines 404–416)

**Impact**
- Refunds can be completed with **0 amount**.
- Refunds can exceed the approved `refund_amount` (over-refund).
- Accounting entry silently fails (caught + logged) → books inconsistent.

**Fix**
- Require `amount > 0` for refund processing.
- Enforce `amount <= return.refund_amount` and `<= remaining refundable`.
- Fix accounting payload shape and map real account IDs.

---

### V6-CRITICAL-08 — Sequential document number generation is race-prone (duplicates possible)
**Status:** ✅ New in v6 report (new modules added with unsafe numbering)

**Where (examples)**
- `app/Models/SalesReturn.php` (generateReturnNumber without locking; lines **77–95**)
- `app/Models/CreditNote.php` (generateCreditNoteNumber; lines **86–104**)
- `app/Models/DebitNote.php` (generateDebitNoteNumber; lines **90–103**)
- `app/Models/PurchaseReturn.php` (generateReturnNumber; lines **88–101**; also not properly scoped by branch)

**Impact**
Under concurrency (multi cashiers / APIs / queue bursts), duplicate numbers can be generated.

**Fix**
Generate numbers inside DB transaction + `lockForUpdate()` on a sequence source, or move to dedicated per-branch/date sequence table.

---

## High

### V6-HIGH-01 — Branch global scope is skipped when there is no authenticated user
**Status:** 🟠 Unfixed

**Where**
- `app/Models/Scopes/BranchScope.php` lines 91–95: returns early if no authenticated user.

**Impact**
Queue jobs / scheduled runs / token-based endpoints can run without branch isolation → cross-branch reads/writes possible.

**Fix**
Introduce a branch context for non-auth execution (job payload branch_id, system user, or explicit context setter).

---

### V6-HIGH-02 — Stock movement duplicate guard is too coarse (can skip valid movements)
**Status:** 🟠 Unfixed

**Where**
- `app/Listeners/UpdateStockOnSale.php` lines 59–73 (checks only sale_id + product_id + negative quantity)
- `app/Listeners/UpdateStockOnPurchase.php` lines 26–40 (checks only purchase_id + product_id + positive quantity)

**Impact**
If the same product appears multiple times in the same document (different batches/UoM/prices), later lines may be skipped → incorrect stock.

**Fix**
Use `sale_item_id/purchase_item_id` or include `warehouse_id` and item identity in the uniqueness check (or enforce uniqueness at input level).

---

### V6-HIGH-03 — Voiding a sale does not reverse stock nor accounting
**Status:** 🟠 Unfixed

**Where**
- `app/Services/SaleService.php` lines 134–149 only sets `status = 'void'`.

**Impact**
Stock remains deducted and journal entries remain posted.

**Fix**
Implement reversal logic (stock + journal reversing entries) and enforce state machine rules.

---

### V6-HIGH-04 — Purchase payments are not recorded as payment records (only `paid_amount` is mutated)
**Status:** ✅ New in v6 report

**Where**
- `app/Services/PurchaseService.php` lines 198–233 updates `paid_amount`/`payment_status` but never creates a `PurchasePayment` record.

**Impact**
No audit trail / payment method breakdown, and accounting cannot post partial payments properly.

**Fix**
Create `PurchasePayment` records and derive totals from them (like sales).

---

### V6-HIGH-05 — SetBranchContext middleware does not verify user access to chosen branch (security)
**Status:** ✅ New in v6 report

**Where**
- `app/Http/Middleware/SetBranchContext.php` lines 29–83 loads branch from route/header/payload and sets `req.branch_id`, but never checks that the user is allowed to operate on that branch.

**Impact**
If any service uses the request branch context for writes, users could write to branches they shouldn’t access.

**Fix**
After loading branch, enforce access via policy/permission/BranchAccessService.

---

## Medium

### V6-MEDIUM-01 — Orders API allows `customer_id` from any branch (cross-branch linkage)
**Status:** ✅ New in v6 report

**Where**
- `app/Http/Controllers/Api/V1/OrdersController.php` validation only checks `exists:customers,id` (line 67).

**Impact**
A store/branch can create orders linked to customers from another branch.

**Fix**
Validate customer belongs to store branch (or filter by branch when fetching customer).

---

### V6-MEDIUM-02 — POS daily closing job sums all sales regardless of status
**Status:** ✅ New in v6 report

**Where**
- `app/Jobs/ClosePosDayJob.php` lines 28–33: no status filter.

**Impact**
Cancelled/void/refunded sales can be included in daily closing totals.

**Fix**
Filter only revenue statuses (or explicitly exclude `cancelled/void/returned`).

---

### V6-MEDIUM-03 — BCMath “rounding” via `bcdiv(x,'1',2)` truncates (tax can be understated)
**Status:** ✅ New in v6 report

**Where**
- `app/Services/POSService.php` lines 175–183: comment says “round tax”, but `bcdiv(..., 2)` truncates.

**Fix**
Use integer-cents math or implement proper rounding (half-up) for string decimals.

---

### V6-MEDIUM-04 — Stock transfer ship/receive payload indexing is risky + no max validation
**Status:** ✅ New in v6 report

**Where**
- `app/Services/StockTransferService.php`:
  - ship: uses `$validated['items'][$item->id]` (lines 208–214)
  - receive: uses `$validated['items'][$item->id]` (lines 286–300)
- Validation does not ensure `qty_shipped <= qty_approved`.

**Impact**
Payload shape mismatch can ship/receive wrong quantities. Over-shipping can drive stock negative.

**Fix**
Validate payload shape explicitly (`items.*.id`) and enforce qty bounds.

---

## Quick prioritization (recommended order)
1) **Branch isolation & security:** V6-HIGH-01, V6-HIGH-05  
2) **Inventory correctness:** V6-CRITICAL-02, V6-CRITICAL-03, V6-HIGH-02  
3) **Finance/accounting correctness:** V6-CRITICAL-04, V6-CRITICAL-05, V6-CRITICAL-07  
4) **Stability:** V6-CRITICAL-01 (BCMath requirement)
