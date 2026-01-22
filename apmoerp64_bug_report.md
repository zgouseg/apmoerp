# APMO ERP v64 — Bug Audit Report

- Date: **2026-01-22**
- Stack: **Laravel ^12.0 / Livewire ^4.0.1 / PHP ^8.2**

Scope: فحص static للكود (Services/Models/Livewire/Controllers/Blade/Migrations) للعثور على bugs (منطق/مالية/أمان/تكامل بيانات). **تم تجاهل database runtime** (لا تشغيل/لا DB فعلية).

## Summary

- Total findings: **247**

- By severity:

  - CRITICAL: **31**
  - HIGH: **185**
  - MEDIUM: **31**

## CRITICAL

### CRITICAL-001 — Security/IDOR

- **File:** `app/Models/AdjustmentItem.php`
- **Issue:** Branch-expected table `adjustment_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `adjustment_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-002 — Security/IDOR

- **File:** `app/Models/AlertRecipient.php`
- **Issue:** Branch-expected table `alert_recipients` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `alert_recipients` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-003 — Security/IDOR

- **File:** `app/Models/BomItem.php`
- **Issue:** Branch-expected table `bom_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `bom_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-004 — Security/IDOR

- **File:** `app/Models/BomOperation.php`
- **Issue:** Branch-expected table `bom_operations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `bom_operations` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-005 — Security/IDOR

- **File:** `app/Models/Branch.php`
- **Issue:** Branch-expected table `branches` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `branches` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-006 — Security/IDOR

- **File:** `app/Models/DashboardWidget.php`
- **Issue:** Branch-expected table `dashboard_widgets` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `dashboard_widgets` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-007 — Security/IDOR

- **File:** `app/Models/EmployeeShift.php`
- **Issue:** Branch-expected table `employee_shifts` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `employee_shifts` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-008 — Security/IDOR

- **File:** `app/Models/GRNItem.php`
- **Issue:** Branch-expected table `grn_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `grn_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-009 — Security/IDOR

- **File:** `app/Models/LeaveRequest.php`
- **Issue:** Branch-expected table `leave_requests` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `leave_requests` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-010 — Security/IDOR

- **File:** `app/Models/ManufacturingTransaction.php`
- **Issue:** Branch-expected table `manufacturing_transactions` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `manufacturing_transactions` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-011 — Security/IDOR

- **File:** `app/Models/ProductStoreMapping.php`
- **Issue:** Branch-expected table `product_store_mappings` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `product_store_mappings` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-012 — Security/IDOR

- **File:** `app/Models/ProductionOrderItem.php`
- **Issue:** Branch-expected table `production_order_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `production_order_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-013 — Security/IDOR

- **File:** `app/Models/ProductionOrderOperation.php`
- **Issue:** Branch-expected table `production_order_operations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `production_order_operations` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-014 — Security/IDOR

- **File:** `app/Models/PurchaseItem.php`
- **Issue:** Branch-expected table `purchase_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `purchase_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-015 — Security/IDOR

- **File:** `app/Models/PurchaseRequisitionItem.php`
- **Issue:** Branch-expected table `purchase_requisition_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `purchase_requisition_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-016 — Security/IDOR

- **File:** `app/Models/RentalInvoice.php`
- **Issue:** Branch-expected table `rental_invoices` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `rental_invoices` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-017 — Security/IDOR

- **File:** `app/Models/RentalPeriod.php`
- **Issue:** Branch-expected table `rental_periods` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `rental_periods` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-018 — Security/IDOR

- **File:** `app/Models/SaleItem.php`
- **Issue:** Branch-expected table `sale_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `sale_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-019 — Security/IDOR

- **File:** `app/Models/SearchHistory.php`
- **Issue:** Branch-expected table `search_history` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `search_history` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-020 — Security/IDOR

- **File:** `app/Models/StockMovement.php`
- **Issue:** Branch-expected table `stock_movements` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `stock_movements` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-021 — Security/IDOR

- **File:** `app/Models/StoreIntegration.php`
- **Issue:** Branch-expected table `store_integrations` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `store_integrations` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-022 — Security/IDOR

- **File:** `app/Models/StoreSyncLog.php`
- **Issue:** Branch-expected table `store_sync_logs` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `store_sync_logs` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-023 — Security/IDOR

- **File:** `app/Models/StoreToken.php`
- **Issue:** Branch-expected table `store_tokens` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `store_tokens` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-024 — Security/IDOR

- **File:** `app/Models/SupplierQuotationItem.php`
- **Issue:** Branch-expected table `supplier_quotation_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `supplier_quotation_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-025 — Security/IDOR

- **File:** `app/Models/TicketSLAPolicy.php`
- **Issue:** Branch-expected table `ticket_sla_policies` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `ticket_sla_policies` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-026 — Security/IDOR

- **File:** `app/Models/TransferItem.php`
- **Issue:** Branch-expected table `transfer_items` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `transfer_items` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-027 — Security/IDOR

- **File:** `app/Models/UserDashboardWidget.php`
- **Issue:** Branch-expected table `user_dashboard_widgets` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `user_dashboard_widgets` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-028 — Security/IDOR

- **File:** `app/Models/VehicleContract.php`
- **Issue:** Branch-expected table `vehicle_contracts` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `vehicle_contracts` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-029 — Security/IDOR

- **File:** `app/Models/VehiclePayment.php`
- **Issue:** Branch-expected table `vehicle_payments` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `vehicle_payments` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-030 — Security/IDOR

- **File:** `app/Models/Warranty.php`
- **Issue:** Branch-expected table `warranties` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `warranties` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


### CRITICAL-031 — Security/IDOR

- **File:** `app/Models/WorkflowRule.php`
- **Issue:** Branch-expected table `workflow_rules` has no `branch_id` column in its migration (tenant isolation risk)

- **Evidence:** Model indicates branch usage (BaseModel/HasBranch/branch_id mention) but migrations for `workflow_rules` don't include branch_id.

- **Recommended fix:** Decide classification: (A) branch-owned => add branch_id FK + indexes + scoped uniques; or (B) global/user-owned => remove branch expectation and enforce policies.


## HIGH

### HIGH-001 — Data Integrity/Transactions

- **File:** `app/Livewire/Admin/Modules/Form.php`
- **Issue:** Multi-write method `save` likely needs DB::transaction (found 5 write ops)

- **Evidence:** Heuristic: multiple create/update/save/delete operations in one method without DB::transaction/beginTransaction.

- **Recommended fix:** Wrap the whole method in DB::transaction(fn()=>{ ... }) and handle exceptions; ensure stock/accounting writes are atomic.


### HIGH-002 — Data Integrity/Transactions

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Multi-write method `uploadFiles` likely needs DB::transaction (found 3 write ops)

- **Evidence:** Heuristic: multiple create/update/save/delete operations in one method without DB::transaction/beginTransaction.

- **Recommended fix:** Wrap the whole method in DB::transaction(fn()=>{ ... }) and handle exceptions; ensure stock/accounting writes are atomic.


### HIGH-003 — Data Integrity/Transactions

- **File:** `app/Observers/ModuleObserver.php`
- **Issue:** Multi-write method `deleted` likely needs DB::transaction (found 4 write ops)

- **Evidence:** Heuristic: multiple create/update/save/delete operations in one method without DB::transaction/beginTransaction.

- **Recommended fix:** Wrap the whole method in DB::transaction(fn()=>{ ... }) and handle exceptions; ensure stock/accounting writes are atomic.


### HIGH-004 — Data Integrity/Transactions

- **File:** `app/Observers/ProductObserver.php`
- **Issue:** Multi-write method `deleteMediaFiles` likely needs DB::transaction (found 4 write ops)

- **Evidence:** Heuristic: multiple create/update/save/delete operations in one method without DB::transaction/beginTransaction.

- **Recommended fix:** Wrap the whole method in DB::transaction(fn()=>{ ... }) and handle exceptions; ensure stock/accounting writes are atomic.


### HIGH-005 — Data Integrity/Transactions

- **File:** `app/Services/AccountingService.php`
- **Issue:** Multi-write method `postAutoGeneratedEntry` likely needs DB::transaction (found 3 write ops)

- **Evidence:** Heuristic: multiple create/update/save/delete operations in one method without DB::transaction/beginTransaction.

- **Recommended fix:** Wrap the whole method in DB::transaction(fn()=>{ ... }) and handle exceptions; ensure stock/accounting writes are atomic.


### HIGH-006 — Security/IDOR

- **File:** `app/Livewire/Admin/ActivityLogShow.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-007 — Security/IDOR

- **File:** `app/Livewire/Admin/Branches/Compare.php`
- **Issue:** Possible IDOR: `compare` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-008 — Security/IDOR

- **File:** `app/Livewire/Admin/Branches/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-009 — Security/IDOR

- **File:** `app/Livewire/Admin/Categories/Form.php`
- **Issue:** Possible IDOR: `loadCategory` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-010 — Security/IDOR

- **File:** `app/Livewire/Admin/Categories/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-011 — Security/IDOR

- **File:** `app/Livewire/Admin/Currency/Form.php`
- **Issue:** Possible IDOR: `loadCurrency` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-012 — Security/IDOR

- **File:** `app/Livewire/Admin/Currency/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-013 — Security/IDOR

- **File:** `app/Livewire/Admin/CurrencyRate/Form.php`
- **Issue:** Possible IDOR: `loadRate` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-014 — Security/IDOR

- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Issue:** Possible IDOR: `openPaymentModal` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-015 — Security/IDOR

- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Issue:** Possible IDOR: `recordPayment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-016 — Security/IDOR

- **File:** `app/Livewire/Admin/Loyalty/Index.php`
- **Issue:** Possible IDOR: `adjustPoints` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-017 — Security/IDOR

- **File:** `app/Livewire/Admin/MediaLibrary.php`
- **Issue:** Possible IDOR: `viewImage` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-018 — Security/IDOR

- **File:** `app/Livewire/Admin/MediaLibrary.php`
- **Issue:** Possible IDOR: `delete` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-019 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/Fields/Form.php`
- **Issue:** Possible IDOR: `loadField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-020 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/Index.php`
- **Issue:** Possible IDOR: `getModuleHealth` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-021 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ModuleManager.php`
- **Issue:** Possible IDOR: `toggleModuleStatus` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-022 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ModuleManager.php`
- **Issue:** Possible IDOR: `deleteModule` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-023 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ProductFields/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-024 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/ProductFields/Form.php`
- **Issue:** Possible IDOR: `loadField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-025 — Security/IDOR

- **File:** `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- **Issue:** Possible IDOR: `loadPeriod` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-026 — Security/IDOR

- **File:** `app/Livewire/Admin/Reports/ReportTemplatesManager.php`
- **Issue:** Possible IDOR: `edit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-027 — Security/IDOR

- **File:** `app/Livewire/Admin/Reports/ScheduledReportsManager.php`
- **Issue:** Possible IDOR: `edit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-028 — Security/IDOR

- **File:** `app/Livewire/Admin/Roles/Index.php`
- **Issue:** Possible IDOR: `compareRoles` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-029 — Security/IDOR

- **File:** `app/Livewire/Admin/Stock/LowStockAlerts.php`
- **Issue:** Possible IDOR: `acknowledgeAlert` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-030 — Security/IDOR

- **File:** `app/Livewire/Admin/Stock/LowStockAlerts.php`
- **Issue:** Possible IDOR: `resolveAlert` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-031 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/Form.php`
- **Issue:** Possible IDOR: `loadStore` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-032 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-033 — Security/IDOR

- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Issue:** Possible IDOR: `viewOrder` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-034 — Security/IDOR

- **File:** `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- **Issue:** Possible IDOR: `loadUnit` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-035 — Security/IDOR

- **File:** `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-036 — Security/IDOR

- **File:** `app/Livewire/Admin/Users/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-037 — Security/IDOR

- **File:** `app/Livewire/Admin/Users/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-038 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `saveNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-039 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `editNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-040 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `deleteNote` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-041 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `togglePin` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-042 — Security/IDOR

- **File:** `app/Livewire/Components/NotesAttachments.php`
- **Issue:** Possible IDOR: `deleteAttachment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-043 — Security/IDOR

- **File:** `app/Livewire/Documents/Tags/Form.php`
- **Issue:** Possible IDOR: `loadTag` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-044 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Categories/Form.php`
- **Issue:** Possible IDOR: `loadCategory` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-045 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Index.php`
- **Issue:** Possible IDOR: `sortBy` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-046 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/Priorities/Form.php`
- **Issue:** Possible IDOR: `loadPriority` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-047 — Security/IDOR

- **File:** `app/Livewire/Helpdesk/SLAPolicies/Form.php`
- **Issue:** Possible IDOR: `loadPolicy` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-048 — Security/IDOR

- **File:** `app/Livewire/Hrm/Employees/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-049 — Security/IDOR

- **File:** `app/Livewire/Hrm/Shifts/Form.php`
- **Issue:** Possible IDOR: `loadShift` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-050 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-051 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings.php`
- **Issue:** Possible IDOR: `delete` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-052 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `mount` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-053 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `loadMapping` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-054 — Security/IDOR

- **File:** `app/Livewire/Inventory/ProductStoreMappings/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-055 — Security/IDOR

- **File:** `app/Livewire/Purchases/GRN/Form.php`
- **Issue:** Possible IDOR: `loadPOItems` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-056 — Security/IDOR

- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-057 — Security/IDOR

- **File:** `app/Livewire/Rental/Properties/Form.php`
- **Issue:** Possible IDOR: `loadProperty` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-058 — Security/IDOR

- **File:** `app/Livewire/Rental/Tenants/Form.php`
- **Issue:** Possible IDOR: `loadTenant` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-059 — Security/IDOR

- **File:** `app/Livewire/Rental/Units/Form.php`
- **Issue:** Possible IDOR: `save` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-060 — Security/IDOR

- **File:** `app/Livewire/Warehouse/Locations/Form.php`
- **Issue:** Possible IDOR: `loadWarehouse` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-061 — Security/IDOR

- **File:** `app/Livewire/Warehouse/Warehouses/Form.php`
- **Issue:** Possible IDOR: `loadWarehouse` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-062 — Security/IDOR

- **File:** `app/Providers/RouteServiceProvider.php`
- **Issue:** Possible IDOR: `boot` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-063 — Security/IDOR

- **File:** `app/Repositories/Contracts/BaseRepositoryInterface.php`
- **Issue:** Possible IDOR: `findOrFail` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-064 — Security/IDOR

- **File:** `app/Repositories/EloquentBaseRepository.php`
- **Issue:** Possible IDOR: `findOrFail` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-065 — Security/IDOR

- **File:** `app/Services/AttachmentAuthorizationService.php`
- **Issue:** Possible IDOR: `authorizeForModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-066 — Security/IDOR

- **File:** `app/Services/AuthService.php`
- **Issue:** Possible IDOR: `enableImpersonation` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-067 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `recordTransaction` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-068 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `startReconciliation` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-069 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `calculateBookBalanceAt` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-070 — Security/IDOR

- **File:** `app/Services/BankingService.php`
- **Issue:** Possible IDOR: `getAccountBalance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-071 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `getBranchModules` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-072 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `enableModuleForBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-073 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `disableModuleForBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-074 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `updateBranchModuleSettings` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-075 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `assignUserToBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-076 — Security/IDOR

- **File:** `app/Services/BranchAccessService.php`
- **Issue:** Possible IDOR: `getUsersInBranch` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-077 — Security/IDOR

- **File:** `app/Services/CurrencyService.php`
- **Issue:** Possible IDOR: `deactivateRate` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-078 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardDataService.php`
- **Issue:** Possible IDOR: `getWidgetData` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-079 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `addWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-080 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `removeWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-081 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `updateWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-082 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `toggleWidget` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-083 — Security/IDOR

- **File:** `app/Services/Dashboard/DashboardWidgetService.php`
- **Issue:** Possible IDOR: `resetToDefault` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-084 — Security/IDOR

- **File:** `app/Services/DocumentService.php`
- **Issue:** Possible IDOR: `shareDocument` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-085 — Security/IDOR

- **File:** `app/Services/FinancialReportService.php`
- **Issue:** Possible IDOR: `getAccountStatement` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-086 — Security/IDOR

- **File:** `app/Services/FinancialReportService.php`
- **Issue:** Possible IDOR: `getAccountBalance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-087 — Security/IDOR

- **File:** `app/Services/HRMService.php`
- **Issue:** Possible IDOR: `logAttendance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-088 — Security/IDOR

- **File:** `app/Services/HRMService.php`
- **Issue:** Possible IDOR: `approveAttendance` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-089 — Security/IDOR

- **File:** `app/Services/HelpdeskService.php`
- **Issue:** Possible IDOR: `assignTicket` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-090 — Security/IDOR

- **File:** `app/Services/LeaveManagementService.php`
- **Issue:** Possible IDOR: `approveEncashment` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-091 — Security/IDOR

- **File:** `app/Services/LeaveManagementService.php`
- **Issue:** Possible IDOR: `approveLeaveRequest` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-092 — Security/IDOR

- **File:** `app/Services/ManufacturingService.php`
- **Issue:** Possible IDOR: `createProductionOrder` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-093 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `updateField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-094 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `deleteField` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-095 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `createProduct` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-096 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `updateProduct` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-097 — Security/IDOR

- **File:** `app/Services/ModuleProductService.php`
- **Issue:** Possible IDOR: `getModulePricingInfo` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-098 — Security/IDOR

- **File:** `app/Services/MotorcycleService.php`
- **Issue:** Possible IDOR: `deliverContract` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-099 — Security/IDOR

- **File:** `app/Services/PayslipService.php`
- **Issue:** Possible IDOR: `calculatePayroll` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-100 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `approveReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-101 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `completeReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-102 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `rejectReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-103 — Security/IDOR

- **File:** `app/Services/PurchaseReturnService.php`
- **Issue:** Possible IDOR: `cancelReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-104 — Security/IDOR

- **File:** `app/Services/RentalService.php`
- **Issue:** Possible IDOR: `setUnitStatus` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-105 — Security/IDOR

- **File:** `app/Services/ReportService.php`
- **Issue:** Possible IDOR: `getModuleReport` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-106 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `approveReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-107 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `processRefund` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-108 — Security/IDOR

- **File:** `app/Services/SalesReturnService.php`
- **Issue:** Possible IDOR: `rejectReturn` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-109 — Security/IDOR

- **File:** `app/Services/SparePartsService.php`
- **Issue:** Possible IDOR: `updateVehicleModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-110 — Security/IDOR

- **File:** `app/Services/SparePartsService.php`
- **Issue:** Possible IDOR: `deleteVehicleModel` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-111 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `approveTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-112 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `shipTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-113 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `receiveTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-114 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `rejectTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-115 — Security/IDOR

- **File:** `app/Services/StockTransferService.php`
- **Issue:** Possible IDOR: `cancelTransfer` uses findOrFail without obvious authorize() or branch filter

- **Evidence:** Heuristic match: findOrFail(...) present, but no $this->authorize(...) and no where('branch_id', ...) in same method block.

- **Recommended fix:** Add explicit authorization (policy/gate) OR ensure query is branch-scoped via BaseModel/HasBranch, e.g. Model::query()->whereBranch()->findOrFail($id).


### HIGH-116 — Security/Scoping

- **File:** `app/Models/AssetMaintenanceLog.php`
- **Issue:** Model `AssetMaintenanceLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `asset_maintenance_logs`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-117 — Security/Scoping

- **File:** `app/Models/AuditLog.php`
- **Issue:** Model `AuditLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `audit_logs`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-118 — Security/Scoping

- **File:** `app/Models/CreditNote.php`
- **Issue:** Model `CreditNote` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `credit_notes`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-119 — Security/Scoping

- **File:** `app/Models/CreditNoteApplication.php`
- **Issue:** Model `CreditNoteApplication` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `credit_note_applications`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-120 — Security/Scoping

- **File:** `app/Models/Currency.php`
- **Issue:** Model `Currency` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `currencies`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-121 — Security/Scoping

- **File:** `app/Models/CurrencyRate.php`
- **Issue:** Model `CurrencyRate` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `currency_rates`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-122 — Security/Scoping

- **File:** `app/Models/DebitNote.php`
- **Issue:** Model `DebitNote` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `debit_notes`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-123 — Security/Scoping

- **File:** `app/Models/DocumentActivity.php`
- **Issue:** Model `DocumentActivity` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `document_activities`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-124 — Security/Scoping

- **File:** `app/Models/DocumentShare.php`
- **Issue:** Model `DocumentShare` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `document_shares`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-125 — Security/Scoping

- **File:** `app/Models/DocumentTag.php`
- **Issue:** Model `DocumentTag` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `document_tags`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-126 — Security/Scoping

- **File:** `app/Models/DocumentVersion.php`
- **Issue:** Model `DocumentVersion` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `document_versions`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-127 — Security/Scoping

- **File:** `app/Models/ExportLayout.php`
- **Issue:** Model `ExportLayout` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `export_layouts`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-128 — Security/Scoping

- **File:** `app/Models/InstallmentPayment.php`
- **Issue:** Model `InstallmentPayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `installment_payments`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-129 — Security/Scoping

- **File:** `app/Models/InventoryTransit.php`
- **Issue:** Model `InventoryTransit` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `inventory_transits`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-130 — Security/Scoping

- **File:** `app/Models/JournalEntryLine.php`
- **Issue:** Model `JournalEntryLine` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `journal_entry_lines`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-131 — Security/Scoping

- **File:** `app/Models/LeaveAccrualRule.php`
- **Issue:** Model `LeaveAccrualRule` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_accrual_rules`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-132 — Security/Scoping

- **File:** `app/Models/LeaveAdjustment.php`
- **Issue:** Model `LeaveAdjustment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_adjustments`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-133 — Security/Scoping

- **File:** `app/Models/LeaveBalance.php`
- **Issue:** Model `LeaveBalance` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_balances`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-134 — Security/Scoping

- **File:** `app/Models/LeaveEncashment.php`
- **Issue:** Model `LeaveEncashment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_encashments`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-135 — Security/Scoping

- **File:** `app/Models/LeaveHoliday.php`
- **Issue:** Model `LeaveHoliday` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_holidaies`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-136 — Security/Scoping

- **File:** `app/Models/LeaveRequestApproval.php`
- **Issue:** Model `LeaveRequestApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_request_approvals`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-137 — Security/Scoping

- **File:** `app/Models/LeaveType.php`
- **Issue:** Model `LeaveType` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `leave_types`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-138 — Security/Scoping

- **File:** `app/Models/LoginActivity.php`
- **Issue:** Model `LoginActivity` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `login_activities`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-139 — Security/Scoping

- **File:** `app/Models/Media.php`
- **Issue:** Model `Media` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `media`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-140 — Security/Scoping

- **File:** `app/Models/Module.php`
- **Issue:** Model `Module` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `modules`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-141 — Security/Scoping

- **File:** `app/Models/ModuleCustomField.php`
- **Issue:** Model `ModuleCustomField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_custom_fields`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-142 — Security/Scoping

- **File:** `app/Models/ModuleField.php`
- **Issue:** Model `ModuleField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_fields`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-143 — Security/Scoping

- **File:** `app/Models/ModuleNavigation.php`
- **Issue:** Model `ModuleNavigation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_navigation`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-144 — Security/Scoping

- **File:** `app/Models/ModuleOperation.php`
- **Issue:** Model `ModuleOperation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_operations`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-145 — Security/Scoping

- **File:** `app/Models/ModulePolicy.php`
- **Issue:** Model `ModulePolicy` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_policies`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-146 — Security/Scoping

- **File:** `app/Models/ModuleProductField.php`
- **Issue:** Model `ModuleProductField` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_product_fields`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-147 — Security/Scoping

- **File:** `app/Models/ModuleSetting.php`
- **Issue:** Model `ModuleSetting` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `module_settings`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-148 — Security/Scoping

- **File:** `app/Models/Notification.php`
- **Issue:** Model `Notification` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `notifications`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-149 — Security/Scoping

- **File:** `app/Models/ProductCompatibility.php`
- **Issue:** Model `ProductCompatibility` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `product_compatibilities`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-150 — Security/Scoping

- **File:** `app/Models/ProductFieldValue.php`
- **Issue:** Model `ProductFieldValue` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `product_field_values`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-151 — Security/Scoping

- **File:** `app/Models/ProductVariation.php`
- **Issue:** Model `ProductVariation` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `product_variations`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-152 — Security/Scoping

- **File:** `app/Models/Project.php`
- **Issue:** Model `Project` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `projects`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-153 — Security/Scoping

- **File:** `app/Models/ProjectExpense.php`
- **Issue:** Model `ProjectExpense` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `project_expenses`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-154 — Security/Scoping

- **File:** `app/Models/ProjectMilestone.php`
- **Issue:** Model `ProjectMilestone` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `project_milestones`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-155 — Security/Scoping

- **File:** `app/Models/ProjectTask.php`
- **Issue:** Model `ProjectTask` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `project_tasks`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-156 — Security/Scoping

- **File:** `app/Models/ProjectTimeLog.php`
- **Issue:** Model `ProjectTimeLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `project_time_logs`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-157 — Security/Scoping

- **File:** `app/Models/PurchasePayment.php`
- **Issue:** Model `PurchasePayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `purchase_payments`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-158 — Security/Scoping

- **File:** `app/Models/PurchaseReturn.php`
- **Issue:** Model `PurchaseReturn` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `purchase_returns`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-159 — Security/Scoping

- **File:** `app/Models/PurchaseReturnItem.php`
- **Issue:** Model `PurchaseReturnItem` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `purchase_return_items`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-160 — Security/Scoping

- **File:** `app/Models/ReportDefinition.php`
- **Issue:** Model `ReportDefinition` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `report_definitions`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-161 — Security/Scoping

- **File:** `app/Models/ReportTemplate.php`
- **Issue:** Model `ReportTemplate` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `report_templates`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-162 — Security/Scoping

- **File:** `app/Models/ReturnRefund.php`
- **Issue:** Model `ReturnRefund` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `return_refunds`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-163 — Security/Scoping

- **File:** `app/Models/SalePayment.php`
- **Issue:** Model `SalePayment` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `sale_payments`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-164 — Security/Scoping

- **File:** `app/Models/SalesReturn.php`
- **Issue:** Model `SalesReturn` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `sales_returns`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-165 — Security/Scoping

- **File:** `app/Models/SavedReportView.php`
- **Issue:** Model `SavedReportView` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `saved_report_views`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-166 — Security/Scoping

- **File:** `app/Models/ScheduledReport.php`
- **Issue:** Model `ScheduledReport` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `scheduled_reports`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-167 — Security/Scoping

- **File:** `app/Models/StockTransfer.php`
- **Issue:** Model `StockTransfer` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `stock_transfers`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-168 — Security/Scoping

- **File:** `app/Models/StockTransferApproval.php`
- **Issue:** Model `StockTransferApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `stock_transfer_approvals`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-169 — Security/Scoping

- **File:** `app/Models/StockTransferDocument.php`
- **Issue:** Model `StockTransferDocument` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `stock_transfer_documents`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-170 — Security/Scoping

- **File:** `app/Models/StockTransferHistory.php`
- **Issue:** Model `StockTransferHistory` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `stock_transfer_history`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-171 — Security/Scoping

- **File:** `app/Models/StockTransferItem.php`
- **Issue:** Model `StockTransferItem` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `stock_transfer_items`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-172 — Security/Scoping

- **File:** `app/Models/SupplierPerformanceMetric.php`
- **Issue:** Model `SupplierPerformanceMetric` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `supplier_performance_metrics`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-173 — Security/Scoping

- **File:** `app/Models/SystemSetting.php`
- **Issue:** Model `SystemSetting` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `system_settings`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-174 — Security/Scoping

- **File:** `app/Models/Ticket.php`
- **Issue:** Model `Ticket` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `tickets`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-175 — Security/Scoping

- **File:** `app/Models/TicketCategory.php`
- **Issue:** Model `TicketCategory` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `ticket_categories`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-176 — Security/Scoping

- **File:** `app/Models/TicketPriority.php`
- **Issue:** Model `TicketPriority` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `ticket_priorities`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-177 — Security/Scoping

- **File:** `app/Models/TicketReply.php`
- **Issue:** Model `TicketReply` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `ticket_replies`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-178 — Security/Scoping

- **File:** `app/Models/UnitOfMeasure.php`
- **Issue:** Model `UnitOfMeasure` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `units_of_measure`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-179 — Security/Scoping

- **File:** `app/Models/UserFavorite.php`
- **Issue:** Model `UserFavorite` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `user_favorites`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-180 — Security/Scoping

- **File:** `app/Models/UserPreference.php`
- **Issue:** Model `UserPreference` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `user_preferences`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-181 — Security/Scoping

- **File:** `app/Models/UserSession.php`
- **Issue:** Model `UserSession` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `user_sessions`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-182 — Security/Scoping

- **File:** `app/Models/VehicleModel.php`
- **Issue:** Model `VehicleModel` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `vehicle_models`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-183 — Security/Scoping

- **File:** `app/Models/WorkflowApproval.php`
- **Issue:** Model `WorkflowApproval` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `workflow_approvals`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-184 — Security/Scoping

- **File:** `app/Models/WorkflowAuditLog.php`
- **Issue:** Model `WorkflowAuditLog` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `workflow_audit_logs`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


### HIGH-185 — Security/Scoping

- **File:** `app/Models/WorkflowNotification.php`
- **Issue:** Model `WorkflowNotification` extends `Model` (not BaseModel) and does not use HasBranch (possible missing BranchScope)

- **Evidence:** Table inferred: `workflow_notifications`. This pattern previously caused IDOR risks when branch-owned data is queried without scope.

- **Recommended fix:** If branch-owned: migrate to BaseModel or add `use HasBranch;` + ensure migration includes branch_id. If global: document as global and ensure policies/permissions guard access.


## MEDIUM

### MEDIUM-001 — Code Quality/Security

- **File:** `app/Models/AuditLog.php`
- **Issue:** Model `AuditLog` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `audit_logs`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-002 — Code Quality/Security

- **File:** `app/Models/CreditNote.php`
- **Issue:** Model `CreditNote` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `credit_notes`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-003 — Code Quality/Security

- **File:** `app/Models/DebitNote.php`
- **Issue:** Model `DebitNote` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `debit_notes`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-004 — Code Quality/Security

- **File:** `app/Models/LeaveHoliday.php`
- **Issue:** Model `LeaveHoliday` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `leave_holidaies`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-005 — Code Quality/Security

- **File:** `app/Models/Media.php`
- **Issue:** Model `Media` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `media`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-006 — Code Quality/Security

- **File:** `app/Models/ModuleField.php`
- **Issue:** Model `ModuleField` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_fields`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-007 — Code Quality/Security

- **File:** `app/Models/ModulePolicy.php`
- **Issue:** Model `ModulePolicy` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_policies`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-008 — Code Quality/Security

- **File:** `app/Models/ModuleSetting.php`
- **Issue:** Model `ModuleSetting` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `module_settings`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-009 — Code Quality/Security

- **File:** `app/Models/Project.php`
- **Issue:** Model `Project` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `projects`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-010 — Code Quality/Security

- **File:** `app/Models/PurchaseReturn.php`
- **Issue:** Model `PurchaseReturn` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `purchase_returns`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-011 — Code Quality/Security

- **File:** `app/Models/PurchaseReturnItem.php`
- **Issue:** Model `PurchaseReturnItem` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `purchase_return_items`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-012 — Code Quality/Security

- **File:** `app/Models/ReturnRefund.php`
- **Issue:** Model `ReturnRefund` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `return_refunds`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-013 — Code Quality/Security

- **File:** `app/Models/SalesReturn.php`
- **Issue:** Model `SalesReturn` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `sales_returns`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-014 — Code Quality/Security

- **File:** `app/Models/StockTransfer.php`
- **Issue:** Model `StockTransfer` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `stock_transfers`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-015 — Code Quality/Security

- **File:** `app/Models/SupplierPerformanceMetric.php`
- **Issue:** Model `SupplierPerformanceMetric` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `supplier_performance_metrics`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-016 — Code Quality/Security

- **File:** `app/Models/Ticket.php`
- **Issue:** Model `Ticket` imports HasBranch but doesn't `use HasBranch;` (inconsistent scoping)

- **Evidence:** Table: `tickets`. File imports the trait but doesn't activate it while referencing branch_id.

- **Recommended fix:** Either add `use HasBranch;` or remove import + branch_id references; align with intended tenancy.


### MEDIUM-017 — Security/Mass Assignment

- **File:** `app/Http/Controllers/Admin/ModuleFieldController.php`
- **Issue:** Potential unsafe mass assignment using $request->all()

- **Evidence:** Found create/update with $request->all(). This can bypass intended whitelisting if fillable/guarded is misconfigured.

- **Recommended fix:** Use validated DTO/array ($validated = $request->validate([...])) and pass only $validated; review $fillable on models.


### MEDIUM-018 — Security/XSS

- **File:** `resources/views/components/form/input.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-019 — Security/XSS

- **File:** `resources/views/components/icon.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-020 — Security/XSS

- **File:** `resources/views/components/ui/button.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-021 — Security/XSS

- **File:** `resources/views/components/ui/card.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-022 — Security/XSS

- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-023 — Security/XSS

- **File:** `resources/views/components/ui/form/input.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-024 — Security/XSS

- **File:** `resources/views/components/ui/page-header.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-025 — Security/XSS

- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-026 — Security/XSS

- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-027 — Security/XSS

- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Issue:** Blade contains unescaped output `{!! ... !!}` (XSS risk if content is user-controlled)

- **Evidence:** Found `{!!` in blade template.

- **Recommended fix:** Prefer `{{ }}` escaping; if HTML is required, sanitize input (e.g., HTMLPurifier) or strictly control source.


### MEDIUM-028 — Validation

- **File:** `app/Livewire/Admin/Branches/Modules.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Detected save/submit/store method but no validate()/validateOnly() calls in file (heuristic).

- **Recommended fix:** Ensure validation rules exist and validate input before writes.


### MEDIUM-029 — Validation

- **File:** `app/Livewire/Admin/Settings/AdvancedSettings.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Detected save/submit/store method but no validate()/validateOnly() calls in file (heuristic).

- **Recommended fix:** Ensure validation rules exist and validate input before writes.


### MEDIUM-030 — Validation

- **File:** `app/Livewire/Admin/Settings/SystemSettings.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Detected save/submit/store method but no validate()/validateOnly() calls in file (heuristic).

- **Recommended fix:** Ensure validation rules exist and validate input before writes.


### MEDIUM-031 — Validation

- **File:** `app/Livewire/Concerns/WithLivewire4Forms.php`
- **Issue:** Livewire component has mutating action without obvious validation

- **Evidence:** Detected save/submit/store method but no validate()/validateOnly() calls in file (heuristic).

- **Recommended fix:** Ensure validation rules exist and validate input before writes.


## Tenancy/Branch notes

- Models that extend `Model` directly (not BaseModel): **70**

- Branch-expected tables missing `branch_id` in migrations: **31**

- Tables with `branch_id` column in migrations: **93**
- Tables with `branch_id` FK constrained to branches: **0**
- Tables with scoped unique using branch_id: **60**
