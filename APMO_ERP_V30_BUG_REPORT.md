# APMO ERP (v30) — New/Remaining Bug Report

**Scan date:** 2026-01-17 (Africa/Cairo)  
**Project package:** `apmoerpv30.zip`  
**Scope:** Full codebase review (Laravel app). **Database/seeders ignored** as requested.

## Framework / Package Versions (verified)
- `laravel/framework`: **v12.0.0** (from `composer.lock`)
- `livewire/livewire`: **v4.0.1** (from `composer.lock`) ✅ *Livewire upgraded to latest 4.0.1*

## Quick summary (what you’ll find)
- **Dashboard & analytics numbers can be wrong** because multiple dashboard modules compute sales based on `created_at` instead of the business date `sale_date` (this impacts synced/backdated sales).  
- **Inventory valuation can be inaccurate** due to float conversions + bcmath scale truncation in costing calculations.  
- **Several code generators have race conditions** because `lockForUpdate()` is used without a DB transaction (can cause duplicate codes).  
- **Warehouse code generation has a formatting bug** (missing `-`) when resolving collisions.  
- **Money rounding is inconsistently handled** in multiple places (often truncation via `bcdiv(..., '1', 2)` instead of proper rounding).

## Previous report verification (v29)
All **v29 bugs** appear **fixed** in this codebase **except** the architectural duplication around transfers (see **V30-MED-09**).

---

# New / Remaining Bugs

## V30-CRIT-01 — Dashboard/reporting uses `created_at` instead of business date `sale_date`
**Severity:** Critical (financial reporting/KPI correctness)  

### Evidence
- `app/Livewire/Components/DashboardWidgets.php:71–97` uses `whereDate('created_at', ...)`, `whereBetween('created_at', ...)`, `whereMonth/Year('created_at', ...)` for sales totals.
- `app/Livewire/Concerns/LoadsDashboardData.php:186–193` builds the 7-day sales chart using `created_at`.
- `app/Livewire/Concerns/LoadsDashboardData.php:215–229` payment-method distribution filters by `sales.created_at`.

### Why this is a bug
The system has a dedicated **`sale_date`** field (see `app/Models/Sale.php`) which represents the business transaction date (and is typically set on imported/synced orders). Using `created_at` causes:
- Synced/backdated sales to appear on the **sync/import day** instead of the actual sale day.
- Inconsistent numbers across screens (some parts use `sale_date`, others use `created_at`).

### Impact
- Wrong daily/weekly/monthly KPIs.
- Misleading revenue tracking and payment method distributions.
- Potential mismatch between dashboard totals and accounting/operational reports.

### Suggested fix
- Standardize dashboard/reporting queries to use **`sale_date`** for business reporting.
- If some screens need “record creation timeline”, keep those explicitly labeled and separate.
- Add tests for “synced sale with old sale_date” ensuring it appears in the correct day bucket.

---

## V30-HIGH-02 — Inventory valuation uses floats + wrong bcmath scale (precision loss)
**Severity:** High (inventory valuation accuracy)  

### Evidence
- `app/Services/CostingService.php:280–316`
  - DB results are cast to **float**:
    - `$warehouseValue = (float) ($warehouseStats->total_value ?? 0);`
    - `$transitValue = (float) ($transitStats->total_value ?? 0);`
  - Total is computed with `bcadd(..., 2)` (2 decimals) even though the system uses **decimal:4** widely:
    - `$totalValue = bcadd((string) $warehouseValue, (string) $transitValue, 2);`

### Why this is a bug
- Casting DB sums to float introduces rounding error.
- Using **scale=2** truncates precision.
- The app stores many monetary fields as **decimal:4**, so this method can drift from the stored truth.

### Impact
- Financial reports can show incorrect inventory value (especially with fractional quantities, unit costs with 4 decimals, or large datasets).

### Suggested fix
- Keep values as **strings** from DB and avoid float casting.
- Use a consistent scale (prefer the project-wide standard—likely **4**) and only round for final UI display.

---

## V30-HIGH-03 — Race conditions: `lockForUpdate()` used without a transaction in code generators
**Severity:** High (duplicate codes / inconsistent behavior under concurrency)  

### Evidence
These files call `lockForUpdate()` but **do not** wrap the code generation + create/update in `DB::transaction(...)`:
- `app/Livewire/Hrm/Shifts/Form.php:82–155`
- `app/Livewire/Projects/Form.php:95–215`
- `app/Livewire/Warehouse/Warehouses/Form.php:64–154`

### Why this is a bug
`SELECT ... FOR UPDATE` has **no effect outside a DB transaction**, so concurrent requests can:
- Generate the same next sequence
- Pass validation simultaneously
- Create duplicate codes (or throw DB/validation errors intermittently)

### Suggested fix
- Wrap code generation + create in a single `DB::transaction()` (see how you did it in `Manufacturing/WorkCenters/Form.php`).
- Add a unique DB index on code (if business requires strict uniqueness) and implement retry logic on constraint violation.

---

## V30-HIGH-04 — Warehouse code generation formatting bug when resolving collisions
**Severity:** High (data consistency / UX / code uniqueness patterns)  

### Evidence
- `app/Livewire/Warehouse/Warehouses/Form.php:84–87`
  - Initial code: `$code = $prefix.'-'.$base;`
  - Collision loop sets: `$code = $prefix.$base.$counter;` (**missing `-`**)

### Impact
Warehouse codes can become inconsistent (e.g., `WH-ABC` then `WHABC1`) which breaks expectations and may affect lookups or integrations.

### Suggested fix
Change collision code generation to keep consistent format:
- `$code = $prefix.'-'.$base.$counter;`

---

## V30-MED-05 — Warehouse form allows duplicate `code` (no uniqueness validation)
**Severity:** Medium  

### Evidence
- `app/Livewire/Warehouse/Warehouses/Form.php:92–101` rules:
  - `'code' => 'nullable|string|max:50',` (no unique constraint)

### Why this is a bug
A user can manually enter a duplicate code and bypass the uniqueness intent of `generateCode()`.

### Suggested fix
- Add validation like: `unique:warehouses,code,<ignoreId>` and/or scope by branch if needed.

---

## V30-MED-06 — Bank balance checks use scale=2 despite `decimal:4` balances
**Severity:** Medium (edge-case overdrafts / false insufficient balance)  

### Evidence
- `app/Services/BankingService.php:269–274` uses `bccomp(..., 2)`
- `app/Services/BankingService.php:300–311` uses `bccomp(..., 2)` and formats balances as `%.2f`.
- `app/Models/BankAccount.php` casts `current_balance` as `decimal:4`.

### Impact
- A withdrawal could be allowed/denied incorrectly for values near the 0.01 boundary.

### Suggested fix
- Use a consistent bcmath scale (likely **4**) for comparisons and internal math.
- Only round for display.

---

## V30-MED-07 — Return note reference number can still duplicate on the first record of the day
**Severity:** Medium (reference integrity)  

### Evidence
- `app/Services/SaleService.php:140–165`
  - Uses `lockForUpdate()` on the last note **for today**.

### Why this can still break
If there is **no** `ReturnNote` row yet for the day:
- Both concurrent transactions can see “no lastNote” and both generate sequence `00001`.
- If the column is unique, one will fail; if not unique, duplicates will exist.

### Suggested fix
- Use a dedicated sequence table/row per day (lock that row), **or**
- Add a unique constraint and retry with the next number on collision.

---

## V30-MED-08 — Systemic money truncation: `bcdiv($x, '1', 2)` used as “rounding”
**Severity:** Medium (financial totals drift / compliance risk in edge cases)  

### Evidence (representative)
- `app/Services/POSService.php:213–223` converts line totals and sale totals via `bcdiv(..., '1', 2)`.

### Why this is a bug
`bcdiv($value, '1', 2)` **truncates** to 2 decimals; it is not guaranteed “half-up rounding”. The code already introduced `bcround()` for tax compliance, so totals should use the same approach.

### Full occurrence list (files/lines)
- `app/Livewire/Inventory/Services/Form.php:233`
- `app/Services/AccountingService.php:707`
- `app/Services/CostingService.php:109`
- `app/Services/CostingService.php:154`
- `app/Services/CostingService.php:162`
- `app/Services/DiscountService.php:72`
- `app/Services/FinancialReportService.php:70`
- `app/Services/FinancialReportService.php:71`
- `app/Services/FinancialReportService.php:146`
- `app/Services/FinancialReportService.php:150`
- `app/Services/FinancialReportService.php:249`
- `app/Services/FinancialReportService.php:253`
- `app/Services/FinancialReportService.php:257`
- `app/Services/FinancialReportService.php:482`
- `app/Services/FinancialReportService.php:483`
- `app/Services/FinancialReportService.php:484`
- `app/Services/HRMService.php:165`
- `app/Services/HRMService.php:206`
- `app/Services/PayslipService.php:79`
- `app/Services/PayslipService.php:92`
- `app/Services/PayslipService.php:102`
- `app/Services/PayslipService.php:160`
- `app/Services/PayslipService.php:222`
- `app/Services/PayslipService.php:223`
- `app/Services/PayslipService.php:225`
- `app/Services/PayslipService.php:227`
- `app/Services/PayslipService.php:322`
- `app/Services/POSService.php:213`
- `app/Services/POSService.php:220`
- `app/Services/POSService.php:221`
- `app/Services/POSService.php:222`
- `app/Services/POSService.php:223`
- `app/Services/POSService.php:256`
- `app/Services/POSService.php:265`
- `app/Services/PricingService.php:84`
- `app/Services/PricingService.php:85`
- `app/Services/PricingService.php:86`
- `app/Services/PricingService.php:87`
- `app/Services/PurchaseService.php:137`
- `app/Services/PurchaseService.php:138`
- `app/Services/PurchaseService.php:139`
- `app/Services/StockReorderService.php:107`
- `app/Services/StockReorderService.php:167`
- `app/Services/StockReorderService.php:287`
- `app/Services/TaxService.php:35`
- `app/Services/TaxService.php:150`
- `app/Services/TaxService.php:187`
- `app/Services/TaxService.php:193`
- `app/Services/WoodService.php:104`

### Suggested fix
- Replace truncation with a consistent rounding helper (e.g. `bcround($value, 2)`), and keep internal amounts as strings/decimal:4 where needed.

---

## V30-MED-09 — Transfers are still implemented in multiple parallel ways (ERP coherence risk)
**Severity:** Medium (process/reporting inconsistencies)  

### Evidence
- `app/Models/Transfer.php` + `app/Livewire/Warehouse/Transfers/*` (one transfer workflow)
- `app/Models/StockTransfer.php` + `app/Services/StockTransferService.php` (another workflow with in-transit logic)
- `app/Http/Controllers/Branch/StockController.php:73–95` provides an *immediate* warehouse-to-warehouse transfer via `InventoryServiceInterface` (no transfer entity).

### Why this is a bug
Multiple transfer paradigms increase the chance of:
- Inconsistent stock movement creation rules
- Inconsistent audit trails
- Conflicting reports (some reports may only understand one model)

### Suggested fix
Decide on **one** canonical transfer workflow and deprecate the others (or clearly scope them: e.g., “instant adjustment” vs “in-transit transfer”). Ensure reporting/COGS/valuation uses one consistent source of truth.

---

## Appendix — How I validated v29 fixes (high level)
- Sales return restock now uses `unit_cost` / `cost_price` instead of `unit_price` (see `app/Services/SalesReturnService.php`).
- Store sync now sets `created_by`, `warehouse_id`, and `cost_price` for created sales/items (see `app/Services/Store/StoreSyncService.php`).
- Transfer model no longer depends on `auth()` inside model methods (see `app/Models/Transfer.php`).
- `composer.json` minimum-stability is now `stable`.
- Livewire is upgraded to `v4.0.1`.

