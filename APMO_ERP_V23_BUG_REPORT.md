# APMO ERP (v23) — Bug Report (New / Still Existing)

> **Scope requested by you:** deep static code review of the project files (ERP, multi-branch), **ignoring DB/migrations/seeders**.  
> **Version check (composer.lock):**
> - `laravel/framework`: **v12.8.0**
> - `livewire/livewire`: **v4.0.0-beta.5**

---

## Executive summary

This version still contains multiple **runtime-breaking** issues (pages that will crash), plus **serious accounting/stock integrity risks**, and several **multi-branch isolation problems**.

### Severity counts (this scan)

- **Critical:** 4
- **High:** 9
- **Medium:** 6

---

## Critical bugs

### V23-CRIT-01 — Purchases Return flow is broken (refund = 0, return note not linked, wrong columns)
**Type:** Finance + Logic + Data integrity  
**Files:**
- `app/Livewire/Purchases/Returns/Index.php` (lines **149–171**)  

**What I found**
- Refund calculation uses `PurchaseItem::$cost` which is **not a defined attribute/accessor** in `PurchaseItem` (the model exposes `unit_price` and `unit_cost` alias). This makes the refund line evaluate to **0.0**.
- Creates `ReturnNote` with fields that don’t match the `ReturnNote` model:
  - Uses `purchase_id` which is **not fillable** (and may not exist at all).
  - Uses `total` instead of `total_amount`.
  - Uses `created_by` but `ReturnNote` doesn’t include it in `$fillable`.
- Then it sets purchase status to `returned` without any **inventory reverse movement** or **accounting** adjustments.

**Impact**
- Purchase returns appear “processed” but:
  - Refund amount is wrong (likely always **0**).
  - The return note may not show up in the UI at all (because `purchase_id` never saves → later query uses `whereNotNull('purchase_id')`).
  - Purchase is marked `returned` but stock/accounting aren’t adjusted → **financial & inventory inconsistency**.

**Fix suggestion**
- Either:
  1) Implement a dedicated **PurchaseReturnService** (similar to SalesReturnService) and call it from Livewire, OR
  2) Align this component with `ReturnNote` schema (use `total_amount`, `type`, `status`, correct foreign key, and create required stock/accounting entries).
- Replace `$pi->cost` with `$pi->unit_cost` (or `$pi->unit_price`).

---

### V23-CRIT-02 — Banking Transactions page likely crashes (wrong eager-load relation)
**Type:** Runtime crash  
**File:** `app/Livewire/Banking/Transactions/Index.php` (line **46**)  

**What I found**
- Query uses: `BankTransaction::with(['account', 'createdBy'])`.
- `BankTransaction` model defines relation `bankAccount()` (not `account()`).

**Impact**
- Laravel will throw: **“Call to undefined relationship [account]”** → the page crashes.

**Fix suggestion**
- Replace eager load with: `with(['bankAccount', 'createdBy'])` and update view references accordingly.

---

### V23-CRIT-03 — Banking Reconciliation Livewire is outdated/inconsistent and can crash + corrupt data
**Type:** Runtime crash + Finance + Data integrity  
**File:** `app/Livewire/Banking/Reconciliation.php` (multiple lines; key areas: **27–33**, **49–107**, **154–189**, **215–274**)  

**What I found**
1) The component calls `$this->authorize('banking.reconcile')` but the class **does not use** `AuthorizesRequests` trait.
2) It uses columns/fields that are not consistent with `BankTransaction` current model logic:
   - `is_reconciled`, `reconciled_at`, `reconciled_by`, `reference` are used in queries/updates, while the model uses `status` + `reconciliation_id` + `reference_number`.
3) Math is wrong for reconciliation difference:
   - It sums **raw `amount`** for matched transactions, ignoring `type` (deposit/withdrawal). This breaks statement matching.
4) It updates transactions by ID list without verifying they belong to the selected bank account.

**Impact**
- The page can **hard-fail** (missing authorize method).
- Even if it runs, it can mark the wrong transactions as “reconciled” and produce wrong balances.

**Fix suggestion**
- Option A (recommended): remove/replace this component and build reconciliation UI around `BankingService::startReconciliation()` and `BankingService::reconcileTransactions()`.
- Option B: refactor it to:
  - Use `AuthorizesRequests`.
  - Use `BankTransaction::STATUS_RECONCILED` + `reconciliation_id`.
  - Use signed amounts (deposit = +, withdrawal = -).
  - Ensure transactions belong to the chosen account + branch.

---

### V23-CRIT-04 — Queued listeners won’t notify anyone because BranchScope fails in queue
**Type:** Logic + Multi-branch (queue context)  
**Files:**
- `app/Listeners/ProposePurchaseOrder.php` (lines **27–37**)  
- `app/Listeners/SendDueReminder.php` (lines **15–28**)  

**What I found**
- Both listeners implement `ShouldQueue`.
- In queue workers there is typically **no authenticated user**.
- Your `BranchScope` is **fail-closed** when there is no auth user and no explicit branch context.
- Therefore:
  - `ProposePurchaseOrder` queries `User::query()` (branch-scoped) → returns **empty**, so stock-low notifications never send.
  - `SendDueReminder` loads `$contract->tenant` (Tenant is branch-scoped) → relationship returns **null**, so reminders never send.

**Impact**
- Business-critical alerts (low stock, rent due reminders) silently fail.

**Fix suggestion**
- In each queued listener, set explicit branch context at the start:
  - e.g. `BranchContextManager::setBranchContext($warehouse->branch_id)` or `$contract->branch_id`, and clear it in `finally`.
- Or bypass global scope intentionally for these lookups and apply explicit filters.

---

## High bugs

### V23-HIGH-01 — `products.stock_quantity` cache is inconsistent (warehouse-specific vs global)
**Type:** Inventory integrity + Reporting  
**Files:**
- `app/Http/Controllers/Api/V1/InventoryController.php` (lines **144–149**)  
- `app/Repositories/StockMovementRepository.php` (method `updateProductStockCache()`)
- `app/Console/Commands/CheckDatabaseIntegrity.php` (stock consistency assumes global sum)

**What I found**
- `StockMovementRepository::create()` updates `products.stock_quantity` based on **SUM(stock_movements.quantity)** for the product (global).
- But `InventoryController::updateStock()` later sets `products.stock_quantity` to the **current stock in a single warehouse**.

**Impact**
- Dashboards/reports that rely on `products.stock_quantity` will show **wrong totals**.
- Integrity check may report false mismatches.

**Fix suggestion**
- Decide one meaning for `products.stock_quantity`:
  - **Global per product** across warehouses (recommended), or
  - Remove/stop relying on it entirely and compute by `StockLevelRepository` / `StockService`.
- Remove the per-warehouse overwrite in `InventoryController`.

---

### V23-HIGH-02 — Product API update can overwrite stock cache incorrectly
**Type:** Inventory integrity  
**File:** `app/Http/Controllers/Api/V1/ProductsController.php` (lines **293–347**)  

**What I found**
- In `update()`, when `quantity` is passed:
  - It sets `$product->stock_quantity = $newQuantity`.
  - It creates a stock movement difference (repo updates global cache).
  - ثم يقوم بـ `$product->save()` بعد ذلك → قد يعيد تخزين `stock_quantity` بالقيمة القديمة في الـ object، ويكسر cache.
- Also, `quantity` is treated as warehouse-specific but written to a single product cached column.

**Impact**
- `products.stock_quantity` becomes unreliable.

**Fix suggestion**
- Remove direct `$product->stock_quantity` assignments here.
- Let stock be represented by stock movements / stock levels.

---

### V23-HIGH-03 — `voidSale()` bypasses stock movement repository (cache mismatch + missing locking)
**Type:** Inventory integrity + Concurrency  
**File:** `app/Services/SaleService.php` (lines **241–290**)  

**What I found**
- Creates reversal movements using `StockMovement::create()` directly.
- This bypasses:
  - warehouse row locking anchor
  - `updateProductStockCache()`
  - consistent movement normalization

**Impact**
- After voiding sales, stock movements may be correct, but cached product stock becomes inconsistent.

**Fix suggestion**
- Use `StockMovementRepository->create()` for reversals or call a dedicated inventory service that does.

---

### V23-HIGH-04 — `StockService::adjustStock()` does not update product cache and has a race condition when no rows exist
**Type:** Concurrency + Inventory integrity  
**Files:**
- `app/Services/StockService.php` (lines **249–275**)  
- Called from:
  - `app/Services/SalesReturnService.php` (lines **337–344**)
  - `app/Services/StockTransferService.php` (e.g. lines **241–248**)

**What I found**
- Locks `stock_movements` rows with `lockForUpdate()->sum()`.
- If there are **no rows yet** for a product+warehouse, this lock does not protect against concurrent inserts (classic phantom/race).
- Also it never updates `products.stock_quantity` cache.

**Impact**
- Possible negative stock / wrong stock_after under concurrency.
- Cache inconsistency after transfers/returns.

**Fix suggestion**
- Deprecate `StockService::adjustStock()` for writes and route all writes through `StockMovementRepository`.

---

### V23-HIGH-05 — Warehouse Transfer UI does not move inventory + note not saved + created_by overwritten
**Type:** Inventory logic + Data integrity  
**Files:**
- `app/Livewire/Warehouse/Transfers/Form.php` (lines **109–133**)  
- `app/Models/Transfer.php` (lines **167–178**)  

**What I found**
- Transfer status can be set to `completed` without creating stock movements → inventory never changes.
- Form sends `'note' => ...` but `Transfer` expects `notes` (fillable) → note won’t be persisted.
- Form overwrites `created_by` on update.
- `Transfer::ship()` incorrectly sets `created_by` instead of a shipped_by field.

**Impact**
- Users can “transfer stock” in UI but nothing happens in inventory.
- Audit trail wrong.

**Fix suggestion**
- Either remove this legacy Transfer UI or integrate it with InventoryService transfer logic.
- Use `notes` column key and keep `created_by` immutable.

---

### V23-HIGH-06 — Helpdesk ticket stats are wrong (query builder reused/mutated)
**Type:** Logic  
**File:** `app/Services/HelpdeskService.php` (lines **254–264**)  

**What I found**
- Same `$query` is used for multiple counts:
  - `$query->where('status','new')->count()` then `$query->where('status','open')->count()` etc.
- This accumulates WHERE conditions, so later counts become **0 or incorrect**.

**Impact**
- Dashboard/metrics for tickets are wrong.

**Fix suggestion**
- Clone the builder per metric (e.g. `(clone $query)->where(...)->count()`).

---

### V23-HIGH-07 — Manufacturing BOM Form: wrong branch fallback + empty product list for branch-less users
**Type:** Multi-branch logic  
**File:** `app/Livewire/Manufacturing/BillsOfMaterials/Form.php` (lines **81–83**, **116–120**)  

**What I found**
- If user has `branch_id = null`, it uses `Branch::first()` for saving.
- But in render it does `Product::where('branch_id', auth()->user()->branch_id ?? null)` → becomes `where branch_id is null` (usually empty).

**Impact**
- Super admins / multi-branch users cannot select products properly.
- Data may be saved under an arbitrary branch.

**Fix suggestion**
- Require explicit branch selection when user has no current branch context.

---

### V23-HIGH-08 — Manufacturing Production Orders: branch fallback to first branch + overwrites created_by
**Type:** Multi-branch + Audit  
**File:** `app/Livewire/Manufacturing/ProductionOrders/Form.php` (lines **86–107**, **109–116**, **124–139**)  

**What I found**
- Same `Branch::first()` fallback.
- Render lists use `$branchId = $user->branch_id ?? null` and filter by it → branch-less users see empty lists.
- Sets `created_by` in `$data` even on update (overwrites original creator).

**Impact**
- Wrong branch records.
- Broken audit.

---

### V23-HIGH-09 — Work Center code generation lock is ineffective (lockForUpdate without transaction)
**Type:** Concurrency  
**File:** `app/Livewire/Manufacturing/WorkCenters/Form.php` (lines **91–114**)  

**What I found**
- Calls `->lockForUpdate()` in `generateCode()` but this method is **not executed inside a DB transaction**.
- Therefore row locking is ineffective for preventing concurrent duplicates.

**Impact**
- Duplicate Work Center codes possible under concurrent creation.

**Fix suggestion**
- Wrap code generation + create in a DB transaction, and enforce a DB unique index for safety.

---

## Medium bugs

### V23-MED-01 — Income/Expense categories are not branch-scoped (leak + cross-branch selection)
**Type:** Multi-branch isolation  
**Files:**
- `app/Models/IncomeCategory.php` (no `HasBranch`, has `branch_id`)  
- `app/Models/ExpenseCategory.php` (no `HasBranch`, has `branch_id`)  
- `app/Livewire/Income/Form.php` (lines **52–60**, **141–160**, **176–181**)  
- `app/Livewire/Expenses/Form.php` (lines **49–58**, **142–164**, **180–185**)  

**What I found**
- Category models include `branch_id` but do not apply BranchScope.
- Forms validate `category_id` with `exists:*_categories,id` without ensuring it belongs to the same branch.
- Render loads categories without branch filtering.
- Both forms overwrite `created_by` on update.

**Impact**
- Branch users can attach expenses/income to categories of other branches → reports become inconsistent.

**Fix suggestion**
- Make category models branch-scoped (use `HasBranch` or extend `BaseModel`).
- In validation: enforce category belongs to the selected/current branch.

---

### V23-MED-02 — HR Employee form loads schema/users for default branch, then edits employee from another branch without refreshing
**Type:** Multi-branch logic  
**File:** `app/Livewire/Hrm/Employees/Form.php` (lines **64–85**, **86–99**)  

**What I found**
- Initializes branch to `user->branch_id ?? 1`.
- Loads `$dynamicSchema` and `$availableUsers` for that branch.
- If editing an employee from another branch, it updates `form['branch_id']` but does **not recompute** schema/users.

**Impact**
- Wrong dynamic fields schema.
- Wrong user assignment options.

**Fix suggestion**
- After loading the employee, recompute schema/users for `employeeModel->branch_id`.

---

### V23-MED-03 — Warehouse Adjustment: `note` is validated but won’t persist + created_by overwritten
**Type:** Data loss + Audit  
**File:** `app/Livewire/Warehouse/Adjustments/Form.php` (lines **111–123**)  

**What I found**
- Saves `note` in `$data`, but `Adjustment` model fillable doesn’t include `note`/`notes`.
- Also sets `created_by` for updates.

**Impact**
- User-entered note is lost.
- created_by audit wrong.

---

### V23-MED-04 — ProductObserver rounds values in `updated()` but does not persist
**Type:** Logic  
**File:** `app/Observers/ProductObserver.php` (lines **54–66**)  

**What I found**
- In `updated()`, it modifies `$product->default_price`, `$product->cost`, etc **after** the update is already saved.
- No `save()` afterward → rounding isn’t persisted.

**Impact**
- Rounding intent not applied; audit trail can be misleading.

**Fix suggestion**
- Move rounding logic into `saving()` / `updating()` observer event.

---

### V23-MED-05 — Multiple components overwrite `created_by` on update
**Type:** Audit / data correctness  
**Examples:**
- `app/Livewire/Manufacturing/ProductionOrders/Form.php` (line **106**)  
- `app/Livewire/Warehouse/Transfers/Form.php` (line **115**)  
- `app/Livewire/Warehouse/Adjustments/Form.php` (line **116**)  
- `app/Livewire/Income/Form.php` (line **147**)  
- `app/Livewire/Expenses/Form.php` (line **151**)  

**Impact**
- Original creator becomes incorrect; compliance/audit issues.

**Fix suggestion**
- Keep `created_by` immutable; use `updated_by` for edits.

---

### V23-MED-06 — BankingService doesn’t enforce transaction branch/account consistency strongly enough
**Type:** Finance + Security (data isolation)  
**File:** `app/Services/BankingService.php` (lines **33–66**, **102–124**)  

**What I found**
- `recordTransaction()` accepts `$data` and creates a transaction without forcing `branch_id = bankAccount->branch_id`.
- `reconcileTransactions()` updates transactions by ID list; doesn’t ensure each transaction belongs to the reconciliation’s bank_account_id.

**Impact**
- Potential cross-branch transaction linkage if a caller passes wrong data or IDs are tampered.

**Fix suggestion**
- Always set branch_id from bank account in service.
- Filter reconciliation updates by `bank_account_id` (and branch) in the update query.

---

## Notes

- I intentionally did **not** inspect migrations/seeders per your instruction. Some of the issues above are still **code-level bugs** because they rely on attributes that the current models do not expose (e.g., `purchase_id`, `total`, `reference`, `is_reconciled`).

