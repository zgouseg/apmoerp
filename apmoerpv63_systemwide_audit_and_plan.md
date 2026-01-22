# APMO ERP v63 — مراجعة (Migrations + HasBranch/BranchScope)

- Date: **2026-01-22**
- Stack: **Laravel ^12.0 / Livewire ^4.0.1 / PHP ^8.2**

الهدف: مراجعة نسخة v63 من منظور **المigrations** وربطها بسياسة **Branch = Tenant** (HasBranch/BranchScope) بدون تطبيق تغييرات.

## 1) Snapshot

- Migration files: **37**
- Tables created by migrations: **191**
- Required tables detected (models + explicit code refs + framework/package): **200**
- Missing tables (required - created): **14**

- Models detected: **174**
- Branch-expected tables (models/base/hasbranch/branch_id mentions): **117**

- Tables with `branch_id` column in migrations: **93**
- Tables with `branch_id` FK constrained to branches: **0**
- Tables with scoped unique `unique([branch_id, ...])`: **60**

- Inferred pivot tables (belongsToMany): **8** | Pivot missing migrations: **0**

- Packages: Spatie Permission=True, Activitylog=True, Sanctum=True


## 2) HasBranch / BranchScope alignment

### 2.1 Branch-expected tables but migration missing `branch_id`

- `adjustment_items`
- `alert_recipients`
- `bom_items`
- `bom_operations`
- `branches`
- `dashboard_widgets`
- `employee_shifts`
- `grn_items`
- `leave_requests`
- `manufacturing_transactions`
- `product_store_mappings`
- `production_order_items`
- `production_order_operations`
- `purchase_items`
- `purchase_requisition_items`
- `rental_invoices`
- `rental_periods`
- `sale_items`
- `search_history`
- `stock_movements`
- `store_integrations`
- `store_sync_logs`
- `store_tokens`
- `supplier_quotation_items`
- `ticket_sla_policies`
- `transfer_items`
- `user_dashboard_widgets`
- `vehicle_contracts`
- `vehicle_payments`
- `warranties`
- `workflow_rules`

### 2.2 Tables with `branch_id` but no FK constraint to `branches`

- `account_mappings`
- `accounts`
- `alert_instances`
- `alert_rules`
- `anomaly_baselines`
- `asset_depreciations`
- `attachments`
- `attendances`
- `audit_logs`
- `bank_accounts`
- `bank_reconciliations`
- `bank_transactions`
- `bills_of_materials`
- `branch_admins`
- `branch_employee`
- `branch_modules`
- `branch_user`
- `cashflow_projections`
- `cost_centers`
- `credit_notes`
- `customers`
- `debit_notes`
- `deliveries`
- `departments`
- `documents`
- `expense_categories`
- `expenses`
- `fiscal_periods`
- `fixed_assets`
- `goods_received_notes`
- `hr_employees`
- `income_categories`
- `incomes`
- `installment_plans`
- `inventory_batches`
- `inventory_serials`
- `journal_entries`
- `leave_holidays`
- `leave_types`
- `low_stock_alerts`
- `loyalty_settings`
- `loyalty_transactions`
- `media`
- `module_fields`
- `module_policies`
- `module_settings`
- `notes`
- `payrolls`
- `pos_sessions`
- `price_groups`
- `product_categories`
- `product_price_tiers`
- `production_orders`
- `products`
- `projects`
- `properties`
- `purchase_requisitions`
- `purchase_return_items`
- `purchase_returns`
- `purchases`
- `quotes`
- `receipts`
- `rental_contracts`
- `rental_payments`
- `rental_units`
- `return_notes`
- `return_refunds`
- `sales`
- `sales_return_items`
- `sales_returns`
- `search_index`
- `shifts`
- `stock_adjustments`
- `stock_transfers`
- `store_orders`
- `stores`
- `supplier_performance_metrics`
- `supplier_quotations`
- `suppliers`
- `taxes`
- `tenants`
- `tickets`
- `transfers`
- `user_dashboard_layouts`
- `users`
- `vehicles`
- `warehouses`
- `widget_data_cache`
- `wood_conversions`
- `wood_waste`
- `work_centers`
- `workflow_definitions`
- `workflow_instances`

### 2.3 Models importing HasBranch but not using it (likely bug / missed scoping)

- `app/Models/AuditLog.php:7` — `AuditLog` table `audit_logs` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/CreditNote.php:5` — `CreditNote` table `credit_notes` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/DebitNote.php:5` — `DebitNote` table `debit_notes` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/LeaveHoliday.php:5` — `LeaveHoliday` table `leave_holidaies` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Media.php:7` — `Media` table `media` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModuleField.php:7` — `ModuleField` table `module_fields` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModulePolicy.php:7` — `ModulePolicy` table `module_policies` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModuleSetting.php:5` — `ModuleSetting` table `module_settings` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Project.php:5` — `Project` table `projects` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/PurchaseReturn.php:5` — `PurchaseReturn` table `purchase_returns` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/PurchaseReturnItem.php:5` — `PurchaseReturnItem` table `purchase_return_items` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ReturnRefund.php:5` — `ReturnRefund` table `return_refunds` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/SalesReturn.php:5` — `SalesReturn` table `sales_returns` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/StockTransfer.php:5` — `StockTransfer` table `stock_transfers` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/SupplierPerformanceMetric.php:5` — `SupplierPerformanceMetric` table `supplier_performance_metrics` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Ticket.php:5` — `Ticket` table `tickets` (imports HasBranch but missing `use HasBranch;`)

## 3) Migration coverage gaps

### 3.1 Missing tables (required - created)

- `base_models`
- `leave_holidaies`
- `migrations`
- `model_has_permissions`
- `model_has_roles`
- `permissions`
- `products as p`
- `role_has_permissions`
- `roles`
- `sale_items as si`
- `sale_items as si1`
- `sale_items as si2`
- `sales as s`
- `stock_movements as m`

### 3.2 Pivot tables missing migrations


## 4) Next steps (plan — بدون تنفيذ)

1) **Close schema gaps**: create missing tables + pivot tables.
2) **Align tenancy**: any branch-owned table must have `branch_id` + FK + indexes + scoped uniques.
3) **Fix model scoping**: any model that imports HasBranch must actually `use HasBranch;` (or extend BaseModel).


# APmo ERP v63 — Check تطبيق الخطة + الناقص + Bugs

**Generated:** 2026-01-22 (Africa/Cairo)

## 1) Plan Compliance
| Item | Status | Evidence |
|---|---|---|
| Branch context coherence | ✅ APPLIED | SetUserBranchContext + BranchScope + BranchContextManager |
| Finance rounding (bcround negative handling) | ❌ NOT APPLIED | app/Helpers/helpers.php::bcround |
| Branch scoping for models with branch_id | ❌ NOT APPLIED | remaining: 18 |
| Branch-aware exists validations | ❌ NOT APPLIED | remaining: 11 |
| Livewire authorization baseline | ❌ NOT APPLIED | flagged: 86 |
| Blade XSS raw output | ❌ NOT APPLIED | occurrences: 2 |
| Scope bypass hardened | ❌ NOT APPLIED | hits: 19 |
| Migrations sanity | ❌ NOT APPLIED | migrations: 37 |
| Tests & guardrails | ❌ NOT APPLIED | tests: 0 |

## 2) مقارنة v62 → v63 (KPIs)
| Metric | v62 | v63 | Δ |
|---|---|---|---|
| BranchContext fixed | 1 | 1 | +0 |
| bcround signed logic present | 0 | 0 | +0 |
| Unscoped models | 18 | 18 | +0 |
| Unsafe exists (branch-owned) | 11 | 11 | +0 |
| Livewire unauth mutation methods (flagged) | 86 | 86 | +0 |
| Blade raw output occurrences | 2 | 2 | +0 |
| Raw SQL hits | 54 | 54 | +0 |
| withoutGlobalScopes hits | 19 | 19 | +0 |
| Rule::exists()->where(branch_id) hits | 4 | 4 | +0 |
| Migrations files | 37 | 37 | +0 |
| Migration issues (HIGH/MEDIUM) | 197 | 197 | +0 |
| Tests files | 0 | 0 | +0 |
| Guard-like tests | 0 | 0 | +0 |

## 3) اللي اتصلح فعلاً (دلائل من الديف)
### 3.1 Models Scoping
- لا يوجد دليل على تحسن هنا مقارنة بـ v62.

### 3.2 exists validations
- لا يوجد دليل على تحسن هنا مقارنة بـ v62.

### 3.3 Livewire authorization
- لا يوجد دليل على تحسن هنا مقارنة بـ v62.

### 3.4 Blade raw output
- لم يظهر أنها اتصلحت مقارنة بـ v62.

---

# 4) Bugs/Nواقص (حسب الخطورة)

## 4.1 CRITICAL — Models فيها branch_id بدون scoping
- Remaining: 18
| Model file | Class line |
|---|---|
| app/Models/AuditLog.php | 14 |
| app/Models/BranchModule.php | 11 |
| app/Models/ChartOfAccount.php | 15 |
| app/Models/CreditNote.php | 12 |
| app/Models/DebitNote.php | 17 |
| app/Models/LeaveHoliday.php | 16 |
| app/Models/Media.php | 20 |
| app/Models/ModuleField.php | 19 |
| app/Models/ModulePolicy.php | 19 |
| app/Models/ModuleSetting.php | 18 |
| app/Models/Project.php | 15 |
| app/Models/PurchaseReturn.php | 19 |
| app/Models/PurchaseReturnItem.php | 15 |
| app/Models/ReturnRefund.php | 10 |
| app/Models/SalesReturn.php | 12 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |

**Refactor residue:** import HasBranch بدون use داخل الـ class:
| Model file | Class line |
|---|---|
| app/Models/AuditLog.php | 14 |
| app/Models/CreditNote.php | 12 |
| app/Models/DebitNote.php | 17 |
| app/Models/LeaveHoliday.php | 16 |
| app/Models/Media.php | 20 |
| app/Models/ModuleField.php | 19 |
| app/Models/ModulePolicy.php | 19 |
| app/Models/ModuleSetting.php | 18 |
| app/Models/Project.php | 15 |
| app/Models/PurchaseReturn.php | 19 |
| app/Models/PurchaseReturnItem.php | 15 |
| app/Models/ReturnRefund.php | 10 |
| app/Models/SalesReturn.php | 12 |
| app/Models/StockTransfer.php | 12 |
| app/Models/SupplierPerformanceMetric.php | 16 |
| app/Models/Ticket.php | 18 |

## 4.2 CRITICAL — exists validations على branch-owned بدون branch constraint
- Remaining: 11
| Table | count |
|---|---|
| modules | 3 |
| products | 3 |
| customers | 2 |
| warehouses | 2 |
| suppliers | 1 |

**Index:**
| File | Line | Table | Column | Rule |
|---|---|---|---|---|
| app/Livewire/Admin/ApiDocumentation.php | 165 | customers | id | 'customer_id' => 'nullable\|exists:customers,id', |
| app/Livewire/Sales/Form.php | 105 | customers | id | 'exists:customers,id', |
| app/Livewire/Admin/ApiDocumentation.php | 70 | modules | id | 'module_id' => 'required\|exists:modules,id', |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 136 | modules | id | 'moduleId' => 'required\|integer\|exists:modules,id', |
| app/Livewire/Inventory/Products/Form.php | 264 | modules | id | 'form.module_id' => ['nullable', 'integer', 'exists:modules,id'], |
| app/Livewire/Admin/ApiDocumentation.php | 116 | products | id | 'product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 129 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Admin/ApiDocumentation.php | 168 | products | id | 'items.*.product_id' => 'required\|exists:products,id', |
| app/Livewire/Purchases/Form.php | 94 | suppliers | id | 'exists:suppliers,id', |
| app/Livewire/Purchases/Form.php | 106 | warehouses | id | 'exists:warehouses,id', |
| app/Livewire/Sales/Form.php | 117 | warehouses | id | 'exists:warehouses,id', |

## 4.3 CRITICAL — Finance bcround negative policy
- signed logic detected (heuristic): False
- Location: `app/Helpers/helpers.php`
```php
434:     function bcround(?string $value, int $precision = 2): string
435:     {
436:         // Handle empty/null values
437:         if ($value === '' || $value === null) {
438:             return '0';
439:         }
440: 
441:         // V58-CRITICAL-01 FIX: Proper "half away from zero" rounding for both positive and negative values.
442:         // This matches PHP's default round() behavior (PHP_ROUND_HALF_UP equivalent for positives,
443:         // but rounds away from zero for negatives).
444:         //
445:         // Algorithm:
446:         // 1. Determine sign and work with absolute value
447:         // 2. Add offset (0.5 * 10^(-precision)) to absolute value
448:         // 3. Truncate using bcadd with target precision (bcmath truncates toward zero)
449:         // 4. Restore sign, handling the "-0.00" edge case
450:         //
451:         // This approach ensures:
452:         // - bcround('1.235', 2) = '1.24' (rounds up)
453:         // - bcround('-1.235', 2) = '-1.24' (rounds away from zero, i.e., more negative)
454:         // - bcround('1.234', 2) = '1.23' (rounds down)
455:         // - bcround('-1.234', 2) = '-1.23' (rounds toward zero)
456:         // - bcround('-0.001', 2) = '0.00' (normalized, no -0.00)
457: 
458:         $isNegative = str_starts_with($value, '-');
459:         $absValue = $isNegative ? ltrim($value, '-') : $value;
460: 
461:         // Validate the absolute value is a valid numeric string
462:         if (! is_numeric($absValue)) {
463:             return '0';
464:         }
465: 
466:         // Calculate offset for half-up rounding: 0.5 * 10^(-precision)
467:         // e.g., for precision=2, offset = '0.005'
468:         $offset = '0.' . str_repeat('0', $precision) . '5';
469: 
470:         // Add offset to absolute value. bcadd truncates toward zero at the given precision,
471:         // which effectively implements half-up rounding.
472:         // Need extra precision during addition to avoid premature truncation
473:         $sumPrecision = $precision + 1;
474:         $sum = bcadd($absValue, $offset, $sumPrecision);
475:         
476:         // Now truncate to the target precision using bcadd with '0'
477:         $rounded = bcadd($sum, '0', $precision);
478: 
479:         // Normalize result to avoid "-0.00" display issue
480:         // If the rounded value is zero, return positive zero
481:         if (bccomp($rounded, '0', $precision) === 0) {
482:             return bcadd('0', '0', $precision); // Ensures proper format like "0.00"
483:         }
484: 
485:         // Restore sign if the original value was negative
486:         return $isNegative ? '-' . $rounded : $rounded;
487:     }
```

## 4.4 HIGH — Livewire mutation methods بدون authorize (pattern)
- Flagged: 86
| Module | count |
|---|---|
| Admin | 32 |
| Components | 8 |
| Purchases | 7 |
| Inventory | 6 |
| Profile | 5 |
| Hrm | 4 |
| Rental | 4 |
| Manufacturing | 3 |
| CommandPalette.php | 2 |
| Expenses | 2 |
| Income | 2 |
| Reports | 2 |
| Sales | 2 |
| Shared | 2 |
| Auth | 1 |
| Banking | 1 |
| Customers | 1 |
| Dashboard | 1 |
| Helpdesk | 1 |

**Index (full):**
| File | Line | Method |
|---|---|---|
| app/Livewire/Admin/Branch/Employees.php | 68 | toggleStatus |
| app/Livewire/Admin/Branch/Settings.php | 72 | save |
| app/Livewire/Admin/Branches/Form.php | 179 | save |
| app/Livewire/Admin/Branches/Modules.php | 72 | save |
| app/Livewire/Admin/BulkImport.php | 141 | loadGoogleSheet |
| app/Livewire/Admin/BulkImport.php | 308 | runImport |
| app/Livewire/Admin/Categories/Form.php | 87 | save |
| app/Livewire/Admin/Currency/Form.php | 81 | save |
| app/Livewire/Admin/Loyalty/Index.php | 69 | saveSettings |
| app/Livewire/Admin/MediaLibrary.php | 66 | updatedFiles |
| app/Livewire/Admin/MediaLibrary.php | 142 | delete |
| app/Livewire/Admin/Modules/Form.php | 109 | save |
| app/Livewire/Admin/Modules/ManagementCenter.php | 157 | toggleModuleForBranch |
| app/Livewire/Admin/Modules/ManagementCenter.php | 190 | toggleModuleActive |
| app/Livewire/Admin/Modules/ProductFields.php | 122 | reorder |
| app/Livewire/Admin/Modules/ProductFields/Form.php | 157 | save |
| app/Livewire/Admin/Reports/ReportTemplatesManager.php | 206 | delete |
| app/Livewire/Admin/Reports/ScheduledReportsManager.php | 253 | delete |
| app/Livewire/Admin/Roles/Form.php | 201 | save |
| app/Livewire/Admin/Settings/PurchasesSettings.php | 65 | setSetting |
| app/Livewire/Admin/Settings/SystemSettings.php | 104 | save |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 312 | setSetting |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 440 | saveSecurity |
| app/Livewire/Admin/Settings/UnifiedSettings.php | 631 | restoreDefaults |
| app/Livewire/Admin/Settings/UserPreferences.php | 41 | save |
| app/Livewire/Admin/Settings/UserPreferences.php | 81 | resetToDefaults |
| app/Livewire/Admin/Settings/WarehouseSettings.php | 65 | setSetting |
| app/Livewire/Admin/SetupWizard.php | 182 | completeSetup |
| app/Livewire/Admin/SetupWizard.php | 259 | skipSetup |
| app/Livewire/Admin/Store/Form.php | 135 | save |
| app/Livewire/Admin/UnitsOfMeasure/Form.php | 107 | save |
| app/Livewire/Admin/Users/Form.php | 151 | save |
| app/Livewire/Auth/Login.php | 55 | login |
| app/Livewire/Banking/Reconciliation.php | 300 | complete |
| app/Livewire/CommandPalette.php | 68 | saveRecentSearch |
| app/Livewire/CommandPalette.php | 106 | clearRecentSearches |
| app/Livewire/Components/DashboardWidgets.php | 134 | toggleWidget |
| app/Livewire/Components/MediaPicker.php | 687 | handleMediaUpload |
| app/Livewire/Components/NotesAttachments.php | 99 | saveNote |
| app/Livewire/Components/NotesAttachments.php | 147 | deleteNote |
| app/Livewire/Components/NotesAttachments.php | 159 | togglePin |
| app/Livewire/Components/NotesAttachments.php | 182 | uploadFiles |
| app/Livewire/Components/NotesAttachments.php | 264 | deleteAttachment |
| app/Livewire/Components/NotificationsCenter.php | 71 | markAllAsRead |
| app/Livewire/Customers/Form.php | 103 | save |
| app/Livewire/Dashboard/CustomizableDashboard.php | 456 | saveUserPreferences |
| app/Livewire/Expenses/Categories/Form.php | 62 | save |
| app/Livewire/Expenses/Form.php | 108 | save |
| app/Livewire/Helpdesk/Tickets/Form.php | 103 | save |
| app/Livewire/Hrm/Employees/Form.php | 154 | save |
| app/Livewire/Hrm/Payroll/Run.php | 47 | runPayroll |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 77 | submitRequest |
| app/Livewire/Hrm/SelfService/MyLeaves.php | 113 | cancelRequest |
| app/Livewire/Income/Categories/Form.php | 61 | save |
| app/Livewire/Income/Form.php | 128 | save |
| app/Livewire/Inventory/Batches/Form.php | 74 | save |
| app/Livewire/Inventory/ProductCompatibility.php | 247 | toggleVerified |
| app/Livewire/Inventory/ProductStoreMappings.php | 108 | delete |
| app/Livewire/Inventory/ProductStoreMappings/Form.php | 122 | save |
| app/Livewire/Inventory/Serials/Form.php | 77 | save |
| app/Livewire/Inventory/Services/Form.php | 163 | save |
| app/Livewire/Manufacturing/BillsOfMaterials/Form.php | 80 | save |
| app/Livewire/Manufacturing/ProductionOrders/Form.php | 85 | save |
| app/Livewire/Manufacturing/WorkCenters/Form.php | 126 | save |
| app/Livewire/Profile/Edit.php | 50 | updateProfile |
| app/Livewire/Profile/Edit.php | 67 | updatePassword |
| app/Livewire/Profile/Edit.php | 88 | handleFileUploaded |
| app/Livewire/Profile/Edit.php | 118 | updateAvatar |
| app/Livewire/Profile/Edit.php | 144 | removeAvatar |
| app/Livewire/Purchases/Form.php | 281 | save |
| app/Livewire/Purchases/GRN/Form.php | 134 | saveGRNItems |
| app/Livewire/Purchases/GRN/Form.php | 191 | saveGRNRecord |
| app/Livewire/Purchases/Requisitions/Form.php | 155 | save |
| app/Livewire/Purchases/Requisitions/Form.php | 206 | submit |
| app/Livewire/Purchases/Returns/Index.php | 108 | processReturn |
| app/Livewire/Purchases/Returns/Index.php | 233 | deleteReturn |
| app/Livewire/Rental/Contracts/Form.php | 284 | removeExistingFile |
| app/Livewire/Rental/Contracts/Form.php | 313 | save |
| app/Livewire/Rental/Reports/Dashboard.php | 140 | notifyExpiringContracts |
| app/Livewire/Rental/Units/Form.php | 135 | save |
| app/Livewire/Reports/ScheduledReports.php | 61 | delete |
| app/Livewire/Reports/ScheduledReports/Form.php | 79 | save |
| app/Livewire/Sales/Form.php | 354 | save |
| app/Livewire/Sales/Returns/Index.php | 194 | deleteReturn |
| app/Livewire/Shared/OnboardingGuide.php | 351 | saveProgress |
| app/Livewire/Shared/OnboardingGuide.php | 391 | resetOnboarding |

## 4.5 HIGH — withoutGlobalScopes / withoutGlobalScope
- Hits: 19
| File | Line | Snippet |
|---|---|---|
| app/Http/Controllers/Api/V1/WebhooksController.php | 30 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 83 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 191 | $store = Store::withoutGlobalScopes()->with('integration')->find($storeId); |
| app/Http/Controllers/Api/V1/WebhooksController.php | 327 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Controllers/Api/V1/WebhooksController.php | 338 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Http/Middleware/AuthenticateStoreToken.php | 58 | $storeToken = StoreToken::withoutGlobalScopes()->where('token', $token)->first(); |
| app/Http/Middleware/AuthenticateStoreToken.php | 76 | $store = Store::withoutGlobalScopes() |
| app/Jobs/ClosePosDayJob.php | 33 | $activeBranches = Branch::withoutGlobalScopes() |
| app/Listeners/ProposePurchaseOrder.php | 36 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope |
| app/Listeners/ProposePurchaseOrder.php | 39 | ->withoutGlobalScopes() |
| app/Listeners/SendDueReminder.php | 26 | // V23-CRIT-04 FIX: Use withoutGlobalScopes() to bypass BranchScope when loading tenant |
| app/Listeners/SendDueReminder.php | 29 | ->withoutGlobalScopes() |
| app/Services/BranchContextManager.php | 146 | // IMPORTANT: We use withoutGlobalScopes() to prevent recursion |
| app/Services/BranchContextManager.php | 153 | $query->withoutGlobalScopes(); |
| app/Services/Store/StoreSyncService.php | 929 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 940 | $warehouse = \App\Models\Warehouse::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 966 | $user = User::withoutGlobalScopes() |
| app/Services/Store/StoreSyncService.php | 1002 | $product = Product::withoutGlobalScopes()->find($productId); |
| app/Traits/HasBranch.php | 64 | return $query->withoutGlobalScope(BranchScope::class); |

## 4.6 MEDIUM — XSS raw output ({!! !!})
- Occurrences: 2
| Blade file | Line | Expression |
|---|---|---|
| resources/views/components/ui/card.blade.php | 50 | {!! $actions !!} |
| resources/views/components/ui/form/input.blade.php | 83 | @if($validWireModel && $validWireModifier) {!! $wireDirective !!} @endif |

## 4.7 MEDIUM — Raw SQL backlog
- Hits: 54
| File | Line | Snippet |
|---|---|---|
| app/Console/Commands/CheckDatabaseIntegrity.php | 253 | ->whereRaw('ABS(COALESCE(products.stock_quantity, 0) - COALESCE(sm.calculated_stock, 0)) > 0.0001') |
| app/Console/Commands/CheckDatabaseIntegrity.php | 336 | $indexes = DB::select("SHOW INDEX FROM {$table}"); |
| app/Console/Commands/CheckDatabaseIntegrity.php | 432 | DB::statement($fix); |
| app/Http/Controllers/Admin/ReportsController.php | 428 | ->whereRaw('paid_amount < total_amount') |
| app/Http/Controllers/Admin/ReportsController.php | 437 | ->whereRaw('paid_amount < total_amount') |
| app/Livewire/Concerns/LoadsDashboardData.php | 24 | * This trait uses selectRaw(), whereRaw(), and orderByRaw() with variable interpolation. |
| app/Livewire/Concerns/LoadsDashboardData.php | 171 | ->whereRaw("{$stockExpr} <= min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 326 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Livewire/Concerns/LoadsDashboardData.php | 329 | ->orderByRaw($stockExpr) |
| app/Livewire/Hrm/Employees/Index.php | 141 | ->whereRaw("COALESCE(position, '') != ''") |
| app/Livewire/Inventory/StockAlerts.php | 64 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0'); |
| app/Livewire/Inventory/StockAlerts.php | 66 | $query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0'); |
| app/Livewire/Projects/TimeLogs.php | 182 | ->orderByRaw('COALESCE(log_date, date) desc') |
| app/Models/ModuleSetting.php | 118 | })->orderByRaw('CASE WHEN branch_id IS NULL THEN 1 ELSE 0 END'); |
| app/Models/Product.php | 24 | * This model uses whereRaw() in query scopes (scopeLowStock, scopeOutOfStock, scopeInStock) |
| app/Models/Product.php | 309 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold"); |
| app/Models/Product.php | 332 | return $query->whereRaw("({$stockSubquery}) <= 0"); |
| app/Models/Product.php | 355 | return $query->whereRaw("({$stockSubquery}) > 0"); |
| app/Models/Project.php | 175 | return $query->whereRaw('actual_cost > budget'); |
| app/Models/SearchIndex.php | 57 | * through the second argument to whereRaw(), preventing SQL injection. |
| app/Models/SearchIndex.php | 80 | $builder->whereRaw( |
| app/Models/SearchIndex.php | 89 | $q->whereRaw('LOWER(title) LIKE ?', [$searchTerm]) |
| app/Services/Analytics/AdvancedAnalyticsService.php | 564 | ->whereRaw('COALESCE(stock_quantity, 0) <= min_stock') |
| app/Services/AutomatedAlertService.php | 171 | ->whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit |
| app/Services/AutomatedAlertService.php | 239 | ->whereRaw("({$stockSubquery}) > 0") |
| app/Services/Dashboard/DashboardDataService.php | 244 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/Dashboard/DashboardDataService.php | 246 | ->orderByRaw('COALESCE(stock.current_stock, 0) ASC') |
| app/Services/Dashboard/DashboardDataService.php | 268 | ->whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold') |
| app/Services/DatabaseCompatibilityService.php | 22 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/Performance/QueryOptimizationService.php | 119 | $existingIndexes = DB::select("SHOW INDEXES FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 123 | $columns = DB::select("SHOW COLUMNS FROM {$wrappedTable}"); |
| app/Services/Performance/QueryOptimizationService.php | 187 | DB::statement($optimizeStatement); |
| app/Services/Performance/QueryOptimizationService.php | 224 | $explainResults = DB::select("{$keyword} {$trimmedQuery}"); |
| app/Services/QueryPerformanceService.php | 104 | $tables = DB::select(' |
| app/Services/QueryPerformanceService.php | 119 | $indexUsage = DB::select(' |
| app/Services/QueryPerformanceService.php | 216 | $explain = DB::select('EXPLAIN FORMAT=JSON '.$sql); |
| app/Services/Reports/CashFlowForecastService.php | 76 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/Reports/CashFlowForecastService.php | 97 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/ScheduledReportService.php | 20 | * This service uses selectRaw(), groupBy(), and whereRaw() with variable interpolation. |
| app/Services/ScheduledReportService.php | 161 | $query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)"); |
| app/Services/SmartNotificationsService.php | 25 | * This service uses selectRaw() and whereRaw() with variable interpolation. |
| app/Services/SmartNotificationsService.php | 63 | ->whereRaw("{$stockExpr} <= products.min_stock") |
| app/Services/SmartNotificationsService.php | 177 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/SmartNotificationsService.php | 253 | ->whereRaw('(total_amount - paid_amount) > 0') |
| app/Services/StockAlertService.php | 147 | ->whereRaw('current_stock <= alert_threshold * 0.25') |
| app/Services/StockReorderService.php | 28 | * This service uses whereRaw() with variable interpolation. |
| app/Services/StockReorderService.php | 64 | ->whereRaw("({$stockSubquery}) <= reorder_point") |
| app/Services/StockReorderService.php | 97 | ->whereRaw("({$stockSubquery}) <= stock_alert_threshold") |
| app/Services/StockReorderService.php | 98 | ->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)") |
| app/Services/StockService.php | 17 | * This service generates SQL expressions used in selectRaw(), whereRaw(), orderByRaw(), and groupBy(). |
| app/Services/WorkflowAutomationService.php | 18 | * This service uses whereRaw(), selectRaw(), and orderByRaw() with variable interpolation. |
| app/Services/WorkflowAutomationService.php | 54 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 201 | ->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)") |
| app/Services/WorkflowAutomationService.php | 204 | ->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC") |

---

# 5) Migrations (v63) — sanity
| Metric | Value |
|---|---|
| migrations files | 37 |
| issues HIGH/MEDIUM | 197 |
| schema ops (create/alter) | 197 |

## 5.1 Migration issues (full index)
| Severity | File | Line | Issue | Snippet |
|---|---|---|---|---|
| HIGH | database/migrations/2026_01_01_000001_create_branches_table.php | 50 | Drop operation | Schema::dropIfExists('branches'); |
| HIGH | database/migrations/2026_01_01_000002_create_users_table.php | 66 | Drop operation | Schema::dropIfExists('users'); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 143 | Drop operation | Schema::dropIfExists($tableNames['role_has_permissions']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 144 | Drop operation | Schema::dropIfExists($tableNames['model_has_roles']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 145 | Drop operation | Schema::dropIfExists($tableNames['model_has_permissions']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 146 | Drop operation | Schema::dropIfExists($tableNames['roles']); |
| HIGH | database/migrations/2026_01_01_000003_create_permission_tables.php | 147 | Drop operation | Schema::dropIfExists($tableNames['permissions']); |
| HIGH | database/migrations/2026_01_01_000004_create_modules_table.php | 63 | Drop operation | Schema::dropIfExists('modules'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 90 | Drop operation | Schema::dropIfExists('branch_admins'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 91 | Drop operation | Schema::dropIfExists('branch_modules'); |
| HIGH | database/migrations/2026_01_01_000005_create_branch_pivot_tables.php | 92 | Drop operation | Schema::dropIfExists('branch_user'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 222 | Drop operation | Schema::dropIfExists('module_product_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 223 | Drop operation | Schema::dropIfExists('module_policies'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 224 | Drop operation | Schema::dropIfExists('module_operations'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 225 | Drop operation | Schema::dropIfExists('module_navigation'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 226 | Drop operation | Schema::dropIfExists('module_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 227 | Drop operation | Schema::dropIfExists('module_custom_fields'); |
| HIGH | database/migrations/2026_01_01_000006_create_module_configuration_tables.php | 228 | Drop operation | Schema::dropIfExists('module_settings'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 99 | Drop operation | Schema::dropIfExists('units_of_measure'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 100 | Drop operation | Schema::dropIfExists('currency_rates'); |
| HIGH | database/migrations/2026_01_02_000001_create_currencies_units_tables.php | 101 | Drop operation | Schema::dropIfExists('currencies'); |
| HIGH | database/migrations/2026_01_02_000002_create_taxes_table.php | 49 | Drop operation | Schema::dropIfExists('taxes'); |
| HIGH | database/migrations/2026_01_02_000003_create_warehouses_table.php | 56 | Drop operation | Schema::dropIfExists('warehouses'); |
| HIGH | database/migrations/2026_01_02_000004_create_product_categories_price_groups_tables.php | 82 | Drop operation | Schema::dropIfExists('price_groups'); |
| HIGH | database/migrations/2026_01_02_000004_create_product_categories_price_groups_tables.php | 83 | Drop operation | Schema::dropIfExists('product_categories'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 250 | Drop operation | Schema::dropIfExists('product_field_values'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 251 | Drop operation | Schema::dropIfExists('product_price_tiers'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 252 | Drop operation | Schema::dropIfExists('product_variations'); |
| HIGH | database/migrations/2026_01_02_000005_create_products_table.php | 253 | Drop operation | Schema::dropIfExists('products'); |
| HIGH | database/migrations/2026_01_02_000006_create_vehicle_models_compatibilities_tables.php | 62 | Drop operation | Schema::dropIfExists('product_compatibilities'); |
| HIGH | database/migrations/2026_01_02_000006_create_vehicle_models_compatibilities_tables.php | 63 | Drop operation | Schema::dropIfExists('vehicle_models'); |
| HIGH | database/migrations/2026_01_02_000007_create_customers_suppliers_tables.php | 160 | Drop operation | Schema::dropIfExists('suppliers'); |
| HIGH | database/migrations/2026_01_02_000007_create_customers_suppliers_tables.php | 161 | Drop operation | Schema::dropIfExists('customers'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 157 | Drop operation | Schema::dropIfExists('product_store_mappings'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 158 | Drop operation | Schema::dropIfExists('store_sync_logs'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 159 | Drop operation | Schema::dropIfExists('store_orders'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 160 | Drop operation | Schema::dropIfExists('store_tokens'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 161 | Drop operation | Schema::dropIfExists('store_integrations'); |
| HIGH | database/migrations/2026_01_02_000008_create_stores_tables.php | 162 | Drop operation | Schema::dropIfExists('stores'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 190 | Drop operation | Schema::dropIfExists('journal_entry_lines'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 191 | Drop operation | Schema::dropIfExists('journal_entries'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 192 | Drop operation | Schema::dropIfExists('account_mappings'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 193 | Drop operation | Schema::dropIfExists('accounts'); |
| HIGH | database/migrations/2026_01_03_000001_create_accounting_tables.php | 194 | Drop operation | Schema::dropIfExists('fiscal_periods'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 182 | Drop operation | Schema::dropIfExists('cashflow_projections'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 183 | Drop operation | Schema::dropIfExists('bank_transactions'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 184 | Drop operation | Schema::dropIfExists('bank_reconciliations'); |
| HIGH | database/migrations/2026_01_03_000002_create_banking_tables.php | 185 | Drop operation | Schema::dropIfExists('bank_accounts'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 176 | Drop operation | Schema::dropIfExists('incomes'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 177 | Drop operation | Schema::dropIfExists('expenses'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 178 | Drop operation | Schema::dropIfExists('income_categories'); |
| HIGH | database/migrations/2026_01_03_000003_create_expense_income_tables.php | 179 | Drop operation | Schema::dropIfExists('expense_categories'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 156 | Drop operation | Schema::dropIfExists('asset_maintenance_logs'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 157 | Drop operation | Schema::dropIfExists('asset_depreciations'); |
| HIGH | database/migrations/2026_01_03_000004_create_fixed_assets_tables.php | 158 | Drop operation | Schema::dropIfExists('fixed_assets'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 306 | Drop operation | Schema::dropIfExists('deliveries'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 307 | Drop operation | Schema::dropIfExists('receipts'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 308 | Drop operation | Schema::dropIfExists('sale_payments'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 309 | Drop operation | Schema::dropIfExists('sale_items'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 310 | Drop operation | Schema::dropIfExists('sales'); |
| HIGH | database/migrations/2026_01_04_000001_create_sales_tables.php | 311 | Drop operation | Schema::dropIfExists('pos_sessions'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 416 | Drop operation | Schema::dropIfExists('grn_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 417 | Drop operation | Schema::dropIfExists('goods_received_notes'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 418 | Drop operation | Schema::dropIfExists('purchase_payments'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 419 | Drop operation | Schema::dropIfExists('purchase_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 423 | Drop operation | Schema::dropIfExists('purchases'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 424 | Drop operation | Schema::dropIfExists('supplier_quotation_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 425 | Drop operation | Schema::dropIfExists('supplier_quotations'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 426 | Drop operation | Schema::dropIfExists('purchase_requisition_items'); |
| HIGH | database/migrations/2026_01_04_000002_create_purchases_tables.php | 427 | Drop operation | Schema::dropIfExists('purchase_requisitions'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 485 | Drop operation | Schema::dropIfExists('stock_movements'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 486 | Drop operation | Schema::dropIfExists('inventory_transits'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 487 | Drop operation | Schema::dropIfExists('stock_transfer_history'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 488 | Drop operation | Schema::dropIfExists('stock_transfer_documents'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 489 | Drop operation | Schema::dropIfExists('stock_transfer_approvals'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 490 | Drop operation | Schema::dropIfExists('stock_transfer_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 491 | Drop operation | Schema::dropIfExists('stock_transfers'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 492 | Drop operation | Schema::dropIfExists('transfer_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 493 | Drop operation | Schema::dropIfExists('transfers'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 494 | Drop operation | Schema::dropIfExists('adjustment_items'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 495 | Drop operation | Schema::dropIfExists('stock_adjustments'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 496 | Drop operation | Schema::dropIfExists('inventory_serials'); |
| HIGH | database/migrations/2026_01_04_000003_create_inventory_tables.php | 497 | Drop operation | Schema::dropIfExists('inventory_batches'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 476 | Drop operation | Schema::dropIfExists('debit_notes'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 477 | Drop operation | Schema::dropIfExists('credit_note_applications'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 478 | Drop operation | Schema::dropIfExists('credit_notes'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 479 | Drop operation | Schema::dropIfExists('return_refunds'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 480 | Drop operation | Schema::dropIfExists('purchase_return_items'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 481 | Drop operation | Schema::dropIfExists('purchase_returns'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 482 | Drop operation | Schema::dropIfExists('sales_return_items'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 483 | Drop operation | Schema::dropIfExists('sales_returns'); |
| HIGH | database/migrations/2026_01_04_000004_create_returns_tables.php | 484 | Drop operation | Schema::dropIfExists('return_notes'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 500 | Drop operation | Schema::dropIfExists('payrolls'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 501 | Drop operation | Schema::dropIfExists('leave_holidays'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 502 | Drop operation | Schema::dropIfExists('leave_encashments'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 503 | Drop operation | Schema::dropIfExists('leave_adjustments'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 504 | Drop operation | Schema::dropIfExists('leave_request_approvals'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 505 | Drop operation | Schema::dropIfExists('leave_requests'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 506 | Drop operation | Schema::dropIfExists('leave_accrual_rules'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 507 | Drop operation | Schema::dropIfExists('leave_balances'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 508 | Drop operation | Schema::dropIfExists('leave_types'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 509 | Drop operation | Schema::dropIfExists('attendances'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 510 | Drop operation | Schema::dropIfExists('branch_employee'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 511 | Drop operation | Schema::dropIfExists('employee_shifts'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 512 | Drop operation | Schema::dropIfExists('hr_employees'); |
| HIGH | database/migrations/2026_01_05_000001_create_hr_payroll_tables.php | 513 | Drop operation | Schema::dropIfExists('shifts'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 237 | Drop operation | Schema::dropIfExists('rental_payments'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 238 | Drop operation | Schema::dropIfExists('rental_invoices'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 239 | Drop operation | Schema::dropIfExists('rental_periods'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 240 | Drop operation | Schema::dropIfExists('rental_contracts'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 241 | Drop operation | Schema::dropIfExists('tenants'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 242 | Drop operation | Schema::dropIfExists('rental_units'); |
| HIGH | database/migrations/2026_01_05_000002_create_rental_tables.php | 243 | Drop operation | Schema::dropIfExists('properties'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 117 | Drop operation | Schema::dropIfExists('warranties'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 118 | Drop operation | Schema::dropIfExists('vehicle_payments'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 119 | Drop operation | Schema::dropIfExists('vehicle_contracts'); |
| HIGH | database/migrations/2026_01_05_000003_create_vehicle_tables.php | 120 | Drop operation | Schema::dropIfExists('vehicles'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 294 | Drop operation | Schema::dropIfExists('manufacturing_transactions'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 295 | Drop operation | Schema::dropIfExists('production_order_operations'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 296 | Drop operation | Schema::dropIfExists('production_order_items'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 297 | Drop operation | Schema::dropIfExists('production_orders'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 298 | Drop operation | Schema::dropIfExists('bom_operations'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 299 | Drop operation | Schema::dropIfExists('bom_items'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 300 | Drop operation | Schema::dropIfExists('bills_of_materials'); |
| HIGH | database/migrations/2026_01_05_000004_create_manufacturing_tables.php | 301 | Drop operation | Schema::dropIfExists('work_centers'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 284 | Drop operation | Schema::dropIfExists('project_time_logs'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 285 | Drop operation | Schema::dropIfExists('project_expenses'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 286 | Drop operation | Schema::dropIfExists('task_dependencies'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 287 | Drop operation | Schema::dropIfExists('project_tasks'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 288 | Drop operation | Schema::dropIfExists('project_milestones'); |
| HIGH | database/migrations/2026_01_05_000005_create_project_tables.php | 289 | Drop operation | Schema::dropIfExists('projects'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 230 | Drop operation | Schema::dropIfExists('ticket_replies'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 231 | Drop operation | Schema::dropIfExists('tickets'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 232 | Drop operation | Schema::dropIfExists('ticket_categories'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 233 | Drop operation | Schema::dropIfExists('ticket_sla_policies'); |
| HIGH | database/migrations/2026_01_06_000001_create_ticket_tables.php | 234 | Drop operation | Schema::dropIfExists('ticket_priorities'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 262 | Drop operation | Schema::dropIfExists('notes'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 263 | Drop operation | Schema::dropIfExists('media'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 264 | Drop operation | Schema::dropIfExists('attachments'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 265 | Drop operation | Schema::dropIfExists('document_activities'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 266 | Drop operation | Schema::dropIfExists('document_shares'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 267 | Drop operation | Schema::dropIfExists('document_versions'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 268 | Drop operation | Schema::dropIfExists('document_tag'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 269 | Drop operation | Schema::dropIfExists('documents'); |
| HIGH | database/migrations/2026_01_06_000002_create_document_tables.php | 270 | Drop operation | Schema::dropIfExists('document_tags'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 189 | Drop operation | Schema::dropIfExists('workflow_notifications'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 190 | Drop operation | Schema::dropIfExists('workflow_audit_logs'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 191 | Drop operation | Schema::dropIfExists('workflow_approvals'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 192 | Drop operation | Schema::dropIfExists('workflow_instances'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 193 | Drop operation | Schema::dropIfExists('workflow_rules'); |
| HIGH | database/migrations/2026_01_06_000003_create_workflow_tables.php | 194 | Drop operation | Schema::dropIfExists('workflow_definitions'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 224 | Drop operation | Schema::dropIfExists('supplier_performance_metrics'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 225 | Drop operation | Schema::dropIfExists('low_stock_alerts'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 226 | Drop operation | Schema::dropIfExists('anomaly_baselines'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 227 | Drop operation | Schema::dropIfExists('alert_recipients'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 228 | Drop operation | Schema::dropIfExists('alert_instances'); |
| HIGH | database/migrations/2026_01_06_000004_create_alert_tables.php | 229 | Drop operation | Schema::dropIfExists('alert_rules'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 155 | Drop operation | Schema::dropIfExists('export_layouts'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 156 | Drop operation | Schema::dropIfExists('saved_report_views'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 157 | Drop operation | Schema::dropIfExists('scheduled_reports'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 158 | Drop operation | Schema::dropIfExists('report_templates'); |
| HIGH | database/migrations/2026_01_07_000001_create_reporting_tables.php | 159 | Drop operation | Schema::dropIfExists('report_definitions'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 122 | Drop operation | Schema::dropIfExists('widget_data_cache'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 123 | Drop operation | Schema::dropIfExists('user_dashboard_widgets'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 124 | Drop operation | Schema::dropIfExists('user_dashboard_layouts'); |
| HIGH | database/migrations/2026_01_07_000002_create_dashboard_tables.php | 125 | Drop operation | Schema::dropIfExists('dashboard_widgets'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 228 | Drop operation | Schema::dropIfExists('activity_log'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 229 | Drop operation | Schema::dropIfExists('audit_logs'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 230 | Drop operation | Schema::dropIfExists('system_settings'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 231 | Drop operation | Schema::dropIfExists('notifications'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 232 | Drop operation | Schema::dropIfExists('search_index'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 233 | Drop operation | Schema::dropIfExists('search_history'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 234 | Drop operation | Schema::dropIfExists('login_activities'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 235 | Drop operation | Schema::dropIfExists('user_sessions'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 236 | Drop operation | Schema::dropIfExists('user_favorites'); |
| HIGH | database/migrations/2026_01_07_000003_create_user_activity_tables.php | 237 | Drop operation | Schema::dropIfExists('user_preferences'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 130 | Drop operation | Schema::dropIfExists('installment_payments'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 131 | Drop operation | Schema::dropIfExists('installment_plans'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 132 | Drop operation | Schema::dropIfExists('loyalty_transactions'); |
| HIGH | database/migrations/2026_01_07_000004_create_loyalty_installment_tables.php | 133 | Drop operation | Schema::dropIfExists('loyalty_settings'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 104 | Drop operation | Schema::dropIfExists('personal_access_tokens'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 105 | Drop operation | Schema::dropIfExists('password_reset_tokens'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 106 | Drop operation | Schema::dropIfExists('failed_jobs'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 107 | Drop operation | Schema::dropIfExists('job_batches'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 108 | Drop operation | Schema::dropIfExists('jobs'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 109 | Drop operation | Schema::dropIfExists('sessions'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 110 | Drop operation | Schema::dropIfExists('cache_locks'); |
| HIGH | database/migrations/2026_01_08_000001_create_laravel_framework_tables.php | 111 | Drop operation | Schema::dropIfExists('cache'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 306 | Drop operation | $table->dropColumn(['department_id_fk', 'cost_center_id']); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 313 | Drop operation | Schema::dropIfExists('quote_items'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 314 | Drop operation | Schema::dropIfExists('quotes'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 315 | Drop operation | Schema::dropIfExists('wood_waste'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 316 | Drop operation | Schema::dropIfExists('wood_conversions'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 317 | Drop operation | Schema::dropIfExists('product_compatibility'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 318 | Drop operation | Schema::dropIfExists('report_schedules'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 319 | Drop operation | Schema::dropIfExists('cost_centers'); |
| HIGH | database/migrations/2026_01_09_000001_create_missing_tables.php | 320 | Drop operation | Schema::dropIfExists('departments'); |

# 6) Tests/Guardrails
| Metric | Value |
|---|---|
| tests files | 0 |
| guard-like tests (heuristic) | 0 |
| Rule::exists()->where(branch_id) hits | 4 |

⚠️ مازالت guard tests غير ظاهرة — ده معناه regression risk عالي.

---

# 7) Bugs جديدة
- لا توجد زيادات واضحة في البنود الحرجة مقارنة بـ v62 (حسب هذا الفحص).


# APMO ERP v63 — مراجعة (Migrations + HasBranch/BranchScope)

- Date: **2026-01-22**
- Stack: **Laravel ^12.0 / Livewire ^4.0.1 / PHP ^8.2**

الهدف: مراجعة نسخة v63 من منظور **المigrations** وربطها بسياسة **Branch = Tenant** (HasBranch/BranchScope) بدون تطبيق تغييرات.

## 1) Snapshot

- Migration files: **37**
- Tables created by migrations: **191**
- Required tables detected (models + explicit code refs + framework/package): **200**
- Missing tables (required - created): **14**

- Models detected: **174**
- Branch-expected tables (models/base/hasbranch/branch_id mentions): **117**

- Tables with `branch_id` column in migrations: **93**
- Tables with `branch_id` FK constrained to branches: **0**
- Tables with scoped unique `unique([branch_id, ...])`: **60**

- Inferred pivot tables (belongsToMany): **8** | Pivot missing migrations: **0**

- Packages: Spatie Permission=True, Activitylog=True, Sanctum=True


## 2) HasBranch / BranchScope alignment

### 2.1 Branch-expected tables but migration missing `branch_id`

- `adjustment_items`
- `alert_recipients`
- `bom_items`
- `bom_operations`
- `branches`
- `dashboard_widgets`
- `employee_shifts`
- `grn_items`
- `leave_requests`
- `manufacturing_transactions`
- `product_store_mappings`
- `production_order_items`
- `production_order_operations`
- `purchase_items`
- `purchase_requisition_items`
- `rental_invoices`
- `rental_periods`
- `sale_items`
- `search_history`
- `stock_movements`
- `store_integrations`
- `store_sync_logs`
- `store_tokens`
- `supplier_quotation_items`
- `ticket_sla_policies`
- `transfer_items`
- `user_dashboard_widgets`
- `vehicle_contracts`
- `vehicle_payments`
- `warranties`
- `workflow_rules`

### 2.2 Tables with `branch_id` but no FK constraint to `branches`

- `account_mappings`
- `accounts`
- `alert_instances`
- `alert_rules`
- `anomaly_baselines`
- `asset_depreciations`
- `attachments`
- `attendances`
- `audit_logs`
- `bank_accounts`
- `bank_reconciliations`
- `bank_transactions`
- `bills_of_materials`
- `branch_admins`
- `branch_employee`
- `branch_modules`
- `branch_user`
- `cashflow_projections`
- `cost_centers`
- `credit_notes`
- `customers`
- `debit_notes`
- `deliveries`
- `departments`
- `documents`
- `expense_categories`
- `expenses`
- `fiscal_periods`
- `fixed_assets`
- `goods_received_notes`
- `hr_employees`
- `income_categories`
- `incomes`
- `installment_plans`
- `inventory_batches`
- `inventory_serials`
- `journal_entries`
- `leave_holidays`
- `leave_types`
- `low_stock_alerts`
- `loyalty_settings`
- `loyalty_transactions`
- `media`
- `module_fields`
- `module_policies`
- `module_settings`
- `notes`
- `payrolls`
- `pos_sessions`
- `price_groups`
- `product_categories`
- `product_price_tiers`
- `production_orders`
- `products`
- `projects`
- `properties`
- `purchase_requisitions`
- `purchase_return_items`
- `purchase_returns`
- `purchases`
- `quotes`
- `receipts`
- `rental_contracts`
- `rental_payments`
- `rental_units`
- `return_notes`
- `return_refunds`
- `sales`
- `sales_return_items`
- `sales_returns`
- `search_index`
- `shifts`
- `stock_adjustments`
- `stock_transfers`
- `store_orders`
- `stores`
- `supplier_performance_metrics`
- `supplier_quotations`
- `suppliers`
- `taxes`
- `tenants`
- `tickets`
- `transfers`
- `user_dashboard_layouts`
- `users`
- `vehicles`
- `warehouses`
- `widget_data_cache`
- `wood_conversions`
- `wood_waste`
- `work_centers`
- `workflow_definitions`
- `workflow_instances`

### 2.3 Models importing HasBranch but not using it (likely bug / missed scoping)

- `app/Models/AuditLog.php:7` — `AuditLog` table `audit_logs` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/CreditNote.php:5` — `CreditNote` table `credit_notes` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/DebitNote.php:5` — `DebitNote` table `debit_notes` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/LeaveHoliday.php:5` — `LeaveHoliday` table `leave_holidaies` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Media.php:7` — `Media` table `media` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModuleField.php:7` — `ModuleField` table `module_fields` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModulePolicy.php:7` — `ModulePolicy` table `module_policies` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ModuleSetting.php:5` — `ModuleSetting` table `module_settings` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Project.php:5` — `Project` table `projects` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/PurchaseReturn.php:5` — `PurchaseReturn` table `purchase_returns` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/PurchaseReturnItem.php:5` — `PurchaseReturnItem` table `purchase_return_items` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/ReturnRefund.php:5` — `ReturnRefund` table `return_refunds` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/SalesReturn.php:5` — `SalesReturn` table `sales_returns` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/StockTransfer.php:5` — `StockTransfer` table `stock_transfers` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/SupplierPerformanceMetric.php:5` — `SupplierPerformanceMetric` table `supplier_performance_metrics` (imports HasBranch but missing `use HasBranch;`)
- `app/Models/Ticket.php:5` — `Ticket` table `tickets` (imports HasBranch but missing `use HasBranch;`)

## 3) Migration coverage gaps

### 3.1 Missing tables (required - created)

- `base_models`
- `leave_holidaies`
- `migrations`
- `model_has_permissions`
- `model_has_roles`
- `permissions`
- `products as p`
- `role_has_permissions`
- `roles`
- `sale_items as si`
- `sale_items as si1`
- `sale_items as si2`
- `sales as s`
- `stock_movements as m`

### 3.2 Pivot tables missing migrations


## 4) Next steps (plan — بدون تنفيذ)

1) **Close schema gaps**: create missing tables + pivot tables.
2) **Align tenancy**: any branch-owned table must have `branch_id` + FK + indexes + scoped uniques.
3) **Fix model scoping**: any model that imports HasBranch must actually `use HasBranch;` (or extend BaseModel).
