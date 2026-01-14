# apmoerpv16 – Bug Report (New + Still-Unfixed Only)

**Scan target:** `apmoerpv16.zip` (re-uploaded)  
**Scope:** Full codebase scan (ignored `database/`, migrations, seeders).  
**Comparison baseline:** previous v16 scan/report.

## 0) Result Summary
- **New bugs in this upload:** **0**  
  *(The uploaded zip appears to be the same code state as the previous v16 scan — no new deltas detected in the areas checked.)*
- **Still-unfixed bugs:** **4** (3 Critical, 1 High)

---

## 1) STILL-UNFIXED (Critical)

### STILL-CRITICAL-01 — Route points to non-existent controller method: RoleController::syncPermissions
- **Route:** `routes/api/admin.php:85`
- **Controller:** `app/Http/Controllers/Admin/RoleController.php` (method missing entirely)
- **Impact:** Calling `POST /api/v1/admin/roles/{role}/sync-permissions` will throw **500 (BadMethodCallException / Method not found)**.
- **Fix:** Implement `syncPermissions(Role $role, Request $request)` or remove/rename the route to an existing method.

**Evidence**
- Route line: `routes/api/admin.php` line **85**
- RoleController methods present: `index/store/update/destroy` only (no `syncPermissions`) in `RoleController.php` lines **13–67**.

---

### STILL-CRITICAL-02 — Route points to non-existent controller method: SystemSettingController::index
- **Route:** `routes/api/admin.php:88`
- **Controller:** `app/Http/Controllers/Admin/SystemSettingController.php` (has `show()` and `update()`, but no `index()`)
- **Impact:** Calling `GET /api/v1/admin/settings` will throw **500**.
- **Fix (one of):**
  1) Change route to call `show`, **or**
  2) Add `index()` that calls the same logic as `show()`.

**Evidence**
- Route line: `routes/api/admin.php` line **88**
- SystemSettingController: only `show()` (lines **13–18**) + `update()` (lines **20–28**), no `index()`.

---

### STILL-CRITICAL-03 — Route points to non-existent controller method: Branch HRM PayrollController::pay
- **Route:** `routes/api/branch/hrm.php:67`
- **Controller:** `app/Http/Controllers/Branch/HRM/PayrollController.php` (missing `pay()`)
- **Impact:** Calling `POST /api/v1/branches/{branch}/hrm/payroll/{payroll}/pay` will throw **500**.
- **Fix:** Implement `pay(Payroll $payroll, Request $request)` or remove/rename the route.

**Evidence**
- Route line: `routes/api/branch/hrm.php` line **67**
- PayrollController: `index/run/approve` only (no `pay`) in `PayrollController.php`.

---

## 2) STILL-UNFIXED (High)

### STILL-HIGH-01 — Products API allows stock changes without `warehouse_id` (creates “phantom stock” vs stock_movements)
- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Where:**
  - `store()` accepts `quantity` with **nullable** `warehouse_id` (lines **182–188**) and writes `stock_quantity` (line **211**), but only creates a stock movement if `warehouse_id` is provided (lines **214–229**).
  - `update()` allows setting `quantity` and updates `stock_quantity` even when `warehouse_id` is missing (lines **288–299**), and only creates an adjustment movement if `warehouse_id` exists (lines **300–321**).
- **Impact:** Stock can drift from the source of truth (`stock_movements`), and becomes ambiguous in multi-warehouse setups. Reports that use StockService may disagree with cached `stock_quantity`, producing inconsistent inventory numbers.
- **Fix options:**
  1) Make `warehouse_id` **required whenever `quantity` is present** (recommended for multi-warehouse), or
  2) If you want branch-level stock without warehouse: create movements against a designated “default warehouse” per branch, or store a separate branch-level stock table.

**Evidence**
- `ProductsController.php` lines **168–229** and **288–321**.

---

## 3) New Bugs Found in This Upload
✅ None found in this re-upload compared to the previous v16 scan.

