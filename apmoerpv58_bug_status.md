- **[HIGH]** `app/Http/Controllers/Branch/PurchaseController.php:83` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Category: `Authorization`
  - Status in v58: `not_found`
  - Previous evidence: `$purchaseModel = Purchase::findOrFail($purchase);`

- **[HIGH]** `app/Http/Controllers/Branch/PurchaseController.php:83` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Category: `Authorization`
  - Status in v58: `not_found`
  - Previous evidence: `$purchaseModel = Purchase::findOrFail($purchase);`

- **[MEDIUM]** `app/Livewire/Admin/Settings/AdvancedSettings.php:1` — **Livewire action without explicit validation**
  - Category: `Quality`
  - Status in v58: `not_found`
  - Previous evidence: `No $this->validate() detected in component`

- **[MEDIUM]** `app/Livewire/Concerns/WithLivewire4Forms.php:1` — **Livewire action without explicit validation**
  - Category: `Quality`
  - Status in v58: `not_found`
  - Previous evidence: `No $this->validate() detected in component`

- **[MEDIUM]** `app/Models/Ticket.php:1` — **Possible missing DB transaction around multi-write operation**
  - Category: `Consistency`
  - Status in v58: `not_found`
  - Previous evidence: `multiple writes detected; no DB::transaction found`

- **[MEDIUM]** `app/Livewire/Purchases/Requisitions/Form.php:1` — **Possible missing DB transaction around multi-write operation**
  - Category: `Consistency`
  - Status in v58: `not_found`
  - Previous evidence: `multiple writes detected; no DB::transaction found`

- **[MEDIUM]** `app/Services/ImportService.php:1` — **Possible missing DB transaction around multi-write operation**
  - Category: `Consistency`
  - Status in v58: `not_found`
  - Previous evidence: `multiple writes detected; no DB::transaction found`


### B) Bugs ما زالت موجودة في v58 (Unfixed)

- Severity counts: **HIGH**: 94, **CRITICAL**: 34, **MEDIUM**: 11

#### Authorization (count: 92)

- **[HIGH]** `app/Http/Controllers/Admin/ModuleCatalogController.php:55` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$moduleRecord = \App\Models\Module::findOrFail($module);`

- **[HIGH]** `app/Http/Controllers/Admin/ModuleCatalogController.php:55` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$moduleRecord = \App\Models\Module::findOrFail($module);`

- **[HIGH]** `app/Http/Controllers/Admin/ModuleFieldController.php:68` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$fieldRecord = ModuleProductField::findOrFail($field);`

- **[HIGH]** `app/Http/Controllers/Admin/ModuleFieldController.php:68` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$fieldRecord = ModuleProductField::findOrFail($field);`

- **[HIGH]** `app/Http/Controllers/Admin/PermissionController.php:53` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$role = \Spatie\Permission\Models\Role::findOrFail($roleId);`

- **[HIGH]** `app/Http/Controllers/Admin/PermissionController.php:53` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$role = \Spatie\Permission\Models\Role::findOrFail($roleId);`

- **[HIGH]** `app/Livewire/Accounting/Accounts/Form.php:91` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$account = Account::findOrFail($accountId);`

- **[HIGH]** `app/Livewire/Accounting/Accounts/Form.php:91` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$account = Account::findOrFail($accountId);`

- **[HIGH]** `app/Livewire/Accounting/JournalEntries/Form.php:172` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$entry = JournalEntry::findOrFail($journalEntryId);`

- **[HIGH]** `app/Livewire/Accounting/JournalEntries/Form.php:172` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$entry = JournalEntry::findOrFail($journalEntryId);`

- **[HIGH]** `app/Livewire/Admin/Branches/Form.php:191` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$branch = Branch::findOrFail($branchId);`

- **[HIGH]** `app/Livewire/Admin/Branches/Form.php:191` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$branch = Branch::findOrFail($branchId);`

- **[HIGH]** `app/Livewire/Admin/Categories/Index.php:61` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$category = ProductCategory::find($id);`

- **[HIGH]** `app/Livewire/Admin/Categories/Index.php:61` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$category = ProductCategory::find($id);`

- **[HIGH]** `app/Livewire/Admin/CurrencyManager.php:50` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$currency = Currency::find($id);`

- **[HIGH]** `app/Livewire/Admin/CurrencyManager.php:50` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$currency = Currency::find($id);`

- **[HIGH]** `app/Livewire/Admin/Modules/ModuleManager.php:177` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::findOrFail($moduleId);`

- **[HIGH]** `app/Livewire/Admin/Modules/ModuleManager.php:177` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::findOrFail($moduleId);`

- **[HIGH]** `app/Livewire/Admin/SetupWizard.php:211` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::find($moduleId);`

- **[HIGH]** `app/Livewire/Admin/SetupWizard.php:211` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::find($moduleId);`

- **[HIGH]** `app/Livewire/Admin/Stock/LowStockAlerts.php:32` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$alert = LowStockAlert::findOrFail($alertId);`

- **[HIGH]** `app/Livewire/Admin/Stock/LowStockAlerts.php:32` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$alert = LowStockAlert::findOrFail($alertId);`

- **[HIGH]** `app/Livewire/Admin/Store/Stores.php:76` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$store = Store::findOrFail($id);`

- **[HIGH]** `app/Livewire/Admin/Store/Stores.php:76` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$store = Store::findOrFail($id);`

- **[HIGH]** `app/Livewire/Admin/UnitsOfMeasure/Index.php:73` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$unit = UnitOfMeasure::find($id);`

- **[HIGH]** `app/Livewire/Admin/UnitsOfMeasure/Index.php:73` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$unit = UnitOfMeasure::find($id);`

- **[HIGH]** `app/Livewire/Components/NotificationsCenter.php:63` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$notification = Notification::find($notificationId);`

- **[HIGH]** `app/Livewire/Components/NotificationsCenter.php:63` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$notification = Notification::find($notificationId);`

- **[HIGH]** `app/Livewire/Helpdesk/Categories/Index.php:29` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$category = TicketCategory::findOrFail($id);`

- **[HIGH]** `app/Livewire/Helpdesk/Categories/Index.php:29` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$category = TicketCategory::findOrFail($id);`

- **[HIGH]** `app/Livewire/Helpdesk/Priorities/Index.php:29` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$priority = TicketPriority::findOrFail($id);`

- **[HIGH]** `app/Livewire/Helpdesk/Priorities/Index.php:29` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$priority = TicketPriority::findOrFail($id);`

- **[HIGH]** `app/Livewire/Inventory/ProductCompatibility.php:132` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$vehicle = VehicleModel::find($id);`

- **[HIGH]** `app/Livewire/Inventory/ProductCompatibility.php:132` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$vehicle = VehicleModel::find($id);`

- **[HIGH]** `app/Livewire/Inventory/ProductCompatibility.php:249` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$compatibility = ProductCompatibilityModel::find($compatibilityId);`

- **[HIGH]** `app/Livewire/Inventory/ProductCompatibility.php:249` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$compatibility = ProductCompatibilityModel::find($compatibilityId);`

- **[HIGH]** `app/Livewire/Inventory/Products/Form.php:171` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::find($value);`

- **[HIGH]** `app/Livewire/Inventory/Products/Form.php:171` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::find($value);`

- **[HIGH]** `app/Livewire/Purchases/Form.php:97` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$supplier = Supplier::find($value);`

- **[HIGH]** `app/Livewire/Purchases/Form.php:97` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$supplier = Supplier::find($value);`

- **[HIGH]** `app/Livewire/Purchases/Form.php:109` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$warehouse = Warehouse::find($value);`

- **[HIGH]** `app/Livewire/Purchases/Form.php:109` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$warehouse = Warehouse::find($value);`

- **[HIGH]** `app/Livewire/Sales/Form.php:108` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$customer = Customer::find($value);`

- **[HIGH]** `app/Livewire/Sales/Form.php:108` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$customer = Customer::find($value);`

- **[HIGH]** `app/Livewire/Sales/Form.php:120` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$warehouse = Warehouse::find($value);`

- **[HIGH]** `app/Models/User.php:255` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `return Branch::find($contextBranchId);`

- **[HIGH]** `app/Rules/CreditLimitCheck.php:43` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$customer = Customer::find($value);`

- **[HIGH]** `app/Rules/StockAvailabilityCheck.php:37` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$product = Product::find($value);`

- **[HIGH]** `app/Services/AttachmentAuthorizationService.php:55` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$attachable = $modelClass::findOrFail($modelId);`

- **[HIGH]** `app/Services/BankingService.php:57` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$bankAccount = BankAccount::findOrFail($bankAccountId);`

- **[HIGH]** `app/Services/BankingService.php:271` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$account = BankAccount::findOrFail($accountId);`

- **[HIGH]** `app/Services/BranchAccessService.php:205` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$branch = Branch::findOrFail($branchId);`

- **[HIGH]** `app/Services/BranchAccessService.php:226` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$branch = Branch::find($branchId);`

- **[HIGH]** `app/Services/BranchAccessService.php:241` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::findOrFail($moduleId);`

- **[HIGH]** `app/Services/BranchAccessService.php:286` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$user = User::findOrFail($userId);`

- **[HIGH]** `app/Services/CacheService.php:107` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `return \App\Models\Branch::find($branchId)?->settings ?? [];`

- **[HIGH]** `app/Services/CacheService.php:149` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$user = \App\Models\User::find($userId);`

- **[HIGH]** `app/Services/CurrencyService.php:201` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$rate = CurrencyRate::findOrFail($id);`

- **[HIGH]** `app/Services/Dashboard/DashboardDataService.php:38` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$widget = DashboardWidget::findOrFail($widgetId);`

- **[HIGH]** `app/Services/Dashboard/DashboardWidgetService.php:107` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$layout = UserDashboardLayout::findOrFail($layoutId);`

- **[HIGH]** `app/Services/Dashboard/DashboardWidgetService.php:108` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$widget = DashboardWidget::findOrFail($widgetId);`

- **[HIGH]** `app/Services/Dashboard/DashboardWidgetService.php:136` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `UserDashboardWidget::findOrFail($userWidgetId)->delete();`

- **[HIGH]** `app/Services/Dashboard/DashboardWidgetService.php:144` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$userWidget = UserDashboardWidget::findOrFail($userWidgetId);`

- **[HIGH]** `app/Services/DocumentService.php:241` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$targetUser = User::findOrFail($userId);`

- **[HIGH]** `app/Services/FinancialReportService.php:433` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$account = Account::findOrFail($accountId);`

- **[HIGH]** `app/Services/FinancialReportService.php:512` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$account = Account::findOrFail($account);`

- **[HIGH]** `app/Services/HRMService.php:39` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$employee = HREmployee::findOrFail($employeeId);`

- **[HIGH]** `app/Services/HRMService.php:69` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$att = Attendance::findOrFail($attendanceId);`

- **[HIGH]** `app/Services/HelpdeskService.php:75` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$assignee = User::findOrFail($userId);`

- **[HIGH]** `app/Services/InventoryService.php:76` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$product = Product::findOrFail($productId);`

- **[HIGH]** `app/Services/LeaveManagementService.php:175` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `// $employee = Employee::find($employeeId);`

- **[HIGH]** `app/Services/LeaveManagementService.php:318` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$encashment = LeaveEncashment::findOrFail($encashmentId);`

- **[HIGH]** `app/Services/LeaveManagementService.php:553` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$leaveType = LeaveType::find($leaveTypeId);`

- **[HIGH]** `app/Services/LeaveManagementService.php:602` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$leaveRequest = LeaveRequest::findOrFail($leaveRequestId);`

- **[HIGH]** `app/Services/ModuleProductService.php:118` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$field = ModuleProductField::findOrFail($fieldId);`

- **[HIGH]** `app/Services/ModuleProductService.php:163` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::findOrFail($moduleId);`

- **[HIGH]** `app/Services/ModuleProductService.php:193` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$product = Product::findOrFail($productId);`

- **[HIGH]** `app/Services/MotorcycleService.php:52` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$c = VehicleContract::findOrFail($contractId);`

- **[HIGH]** `app/Services/NotificationService.php:146` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$user = User::find($userId);`

- **[HIGH]** `app/Services/POSService.php:364` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$session = PosSession::findOrFail($sessionId);`

- **[HIGH]** `app/Services/PayslipService.php:192` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$employee = \App\Models\HREmployee::findOrFail($employeeId);`

- **[HIGH]** `app/Services/PricingService.php:34` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$pg = PriceGroup::find($priceGroupId);`

- **[HIGH]** `app/Services/PurchaseReturnService.php:188` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$return = PurchaseReturn::findOrFail($returnId);`

- **[HIGH]** `app/Services/RentalService.php:54` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$u = RentalUnit::findOrFail($unitId);`

- **[HIGH]** `app/Services/ReportService.php:544` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$module = Module::findOrFail($moduleId);`

- **[HIGH]** `app/Services/SalesReturnService.php:276` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$return = SalesReturn::findOrFail($returnId);`

- **[HIGH]** `app/Services/SparePartsService.php:67` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$model = VehicleModel::findOrFail($id);`

- **[HIGH]** `app/Services/StockTransferService.php:534` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$transfer = StockTransfer::findOrFail($transferId);`

- **[HIGH]** `app/Services/TaxService.php:20` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$tax = Tax::find($taxId);`

- **[HIGH]** `app/Services/UX/SmartSuggestionsService.php:188` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$baseProduct = Product::find($productId);`

- **[HIGH]** `app/Services/WorkflowAutomationService.php:139` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$customer = Customer::find($customerId);`

- **[HIGH]** `app/Services/WorkflowAutomationService.php:164` — **Potential IDOR: find/findOrFail by raw ID without nearby authorization**
  - Status in v58: `present`
  - Evidence: `$supplier = Supplier::find($supplierId);`


#### Security (count: 36)

- **[CRITICAL]** `app/Console/Commands/CheckDatabaseIntegrity.php:336` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$indexes = DB::select("SHOW INDEX FROM {$table}");`

- **[CRITICAL]** `app/Console/Commands/CheckDatabaseIntegrity.php:336` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$indexes = DB::select("SHOW INDEX FROM {$table}");`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:171` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= min_stock")`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:171` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= min_stock")`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:326` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:326` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:329` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->orderByRaw($stockExpr)`

- **[CRITICAL]** `app/Livewire/Concerns/LoadsDashboardData.php:329` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->orderByRaw($stockExpr)`

- **[CRITICAL]** `app/Models/Product.php:309` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

- **[CRITICAL]** `app/Models/Product.php:309` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

- **[CRITICAL]** `app/Models/Product.php:332` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `return $query->whereRaw("({$stockSubquery}) <= 0");`

- **[CRITICAL]** `app/Models/Product.php:332` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `return $query->whereRaw("({$stockSubquery}) <= 0");`

- **[CRITICAL]** `app/Models/Product.php:355` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `return $query->whereRaw("({$stockSubquery}) > 0");`

- **[CRITICAL]** `app/Models/Product.php:355` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `return $query->whereRaw("({$stockSubquery}) > 0");`

- **[CRITICAL]** `app/Services/AutomatedAlertService.php:239` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) > 0")`

- **[CRITICAL]** `app/Services/AutomatedAlertService.php:239` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) > 0")`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:119` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$existingIndexes = DB::select("SHOW INDEXES FROM {$wrappedTable}");`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:119` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$existingIndexes = DB::select("SHOW INDEXES FROM {$wrappedTable}");`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:123` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$columns = DB::select("SHOW COLUMNS FROM {$wrappedTable}");`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:123` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$columns = DB::select("SHOW COLUMNS FROM {$wrappedTable}");`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:224` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$explainResults = DB::select("{$keyword} {$trimmedQuery}");`

- **[CRITICAL]** `app/Services/Performance/QueryOptimizationService.php:224` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$explainResults = DB::select("{$keyword} {$trimmedQuery}");`

- **[CRITICAL]** `app/Services/ScheduledReportService.php:161` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

- **[CRITICAL]** `app/Services/ScheduledReportService.php:161` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

- **[CRITICAL]** `app/Services/SmartNotificationsService.php:63` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

- **[CRITICAL]** `app/Services/SmartNotificationsService.php:63` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

- **[CRITICAL]** `app/Services/StockReorderService.php:64` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= reorder_point")`

- **[CRITICAL]** `app/Services/StockReorderService.php:64` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= reorder_point")`

- **[CRITICAL]** `app/Services/StockReorderService.php:97` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

- **[CRITICAL]** `app/Services/StockReorderService.php:97` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

- **[CRITICAL]** `app/Services/StockReorderService.php:98` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

- **[CRITICAL]** `app/Services/StockReorderService.php:98` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

- **[CRITICAL]** `app/Services/WorkflowAutomationService.php:54` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

- **[CRITICAL]** `app/Services/WorkflowAutomationService.php:54` — **Possible SQL injection via raw SQL / interpolation**
  - Status in v58: `present`
  - Evidence: `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

- **[HIGH]** `resources/views/components/ui/card.blade.php:50` — **Unescaped Blade output {!! !!}**
  - Status in v58: `present`
  - Evidence: `{!! $actions !!}`

- **[HIGH]** `resources/views/components/ui/form/input.blade.php:83` — **Unescaped Blade output {!! !!}**
  - Status in v58: `present`
  - Evidence: `@if($validWireModel && $validWireModifier) {!! $wireDirective !!} @endif`


#### Reliability (count: 9)

- **[MEDIUM]** `app/Jobs/BackupDatabaseJob.php:85` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('MYSQL_PWD='.$password);`

- **[MEDIUM]** `app/Jobs/BackupDatabaseJob.php:140` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('MYSQL_PWD');`

- **[MEDIUM]** `app/Jobs/BackupDatabaseJob.php:153` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('PGPASSWORD='.$password);`

- **[MEDIUM]** `app/Jobs/BackupDatabaseJob.php:209` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('PGPASSWORD');`

- **[MEDIUM]** `app/Services/BackupService.php:208` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('MYSQL_PWD='.$password);`

- **[MEDIUM]** `app/Services/BackupService.php:245` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('MYSQL_PWD');`

- **[MEDIUM]** `app/Services/BackupService.php:263` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('PGPASSWORD='.$password);`

- **[MEDIUM]** `app/Services/BackupService.php:300` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `putenv('PGPASSWORD');`

- **[MEDIUM]** `resources/views/components/bottom-sheet.blade.php:148` — **Runtime env() usage outside config**
  - Status in v58: `present`
  - Evidence: `padding-bottom: max(0.75rem, env(safe-area-inset-bottom));`


#### Quality (count: 2)

- **[MEDIUM]** `app/Livewire/Admin/Branches/Modules.php:5` — **Livewire action without explicit validation**
  - Status in v58: `present_variant`
  - Evidence: `No $this->validate() detected in component`

- **[MEDIUM]** `app/Livewire/Admin/Settings/SystemSettings.php:5` — **Livewire action without explicit validation**
  - Status in v58: `present_variant`
  - Evidence: `No $this->validate() detected in component`



---
## 2) Bugs جديدة (Newly discovered in v58)

> المقصود: Findings ظهرت من فحص إضافي على v58 ولم تكن ضمن قائمة الـ unfixed اللي كانت في v57.

- Newly discovered findings: **79**

### Security (count: 49)

- **[Critical]** `app/Console/Commands/CheckDatabaseIntegrity.php:336` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::select("SHOW INDEX FROM {$table}");`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Http/Controllers/Admin/ReportsController.php:426` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('paid_amount < total_amount')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Http/Controllers/Api/V1/InventoryController.php:84` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `havingRaw('COALESCE(SUM(sm.quantity), 0) <= products.min_stock');`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Http/Controllers/Branch/ReportsController.php:62` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `havingRaw('SUM(m.quantity) > 0') // Only include products with positive on-hand stock`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Admin/Branch/Reports.php:168` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('SUM(sale_items.quantity) as total_qty'), DB::raw('SUM(sale_items.line_total) as total_amount'))`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Components/DashboardWidgets.php:126` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `havingRaw('COALESCE(SUM(stock_movements.quantity), 0) <= products.min_stock'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Concerns/LoadsDashboardData.php:171` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("{$stockExpr} <= min_stock")`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Dashboard/CustomizableDashboard.php:251` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Helpdesk/Dashboard.php:76` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('count(*) as count') uses a hardcoded expression.`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Inventory/StockAlerts.php:64` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Projects/TimeLogs.php:182` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `orderByRaw('COALESCE(log_date, date) desc')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Purchases/Index.php:115` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('(purchases.total_amount - purchases.paid_amount) as amount_due'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Livewire/Sales/Index.php:142` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('(sales.total_amount - sales.paid_amount) as amount_due'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Models/ModuleSetting.php:118` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `orderByRaw('CASE WHEN branch_id IS NULL THEN 1 ELSE 0 END');`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Models/Product.php:309` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Models/Project.php:175` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('actual_cost > budget');`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Models/SearchIndex.php:80` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw(`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/ABCAnalysisService.php:61` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('SUM(line_total) as total_revenue'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/AdvancedAnalyticsService.php:564` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('COALESCE(stock_quantity, 0) <= min_stock')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/CustomerBehaviorService.php:49` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('MAX(sale_date) as last_purchase'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/InventoryTurnoverService.php:59` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('sale_items.quantity * COALESCE(sale_items.cost_price, products.cost, 0)'));`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/KPIDashboardService.php:136` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('stock_quantity * COALESCE(cost, 0)'));`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/ProfitMarginAnalysisService.php:67` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('COALESCE(SUM(sale_items.quantity), 0) as units_sold'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Analytics/SalesForecastingService.php:111` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw("{$periodExpr} as period"),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/AutomatedAlertService.php:171` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('balance >= (credit_limit * 0.8)') // 80% of credit limit`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Dashboard/DashboardDataService.php:244` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('COALESCE(stock.current_stock, 0) <= products.stock_alert_threshold')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/DocumentService.php:478` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('count(*) as count'))`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Performance/QueryOptimizationService.php:119` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::select("SHOW INDEXES FROM {$wrappedTable}");`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/QueryPerformanceService.php:104` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::select('`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/ReportService.php:70` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('COALESCE(SUM(total_amount), 0) as total'), DB::raw('COALESCE(SUM(paid_amount), 0) as paid'))`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Reports/CashFlowForecastService.php:76` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('(total_amount - paid_amount) > 0')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Reports/CustomerSegmentationService.php:191` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `havingRaw("{$datediffExpr} > 60")`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/Reports/SlowMovingStockService.php:71` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `havingRaw("COALESCE({$daysDiffExpr}, 999) > ?", [$days])`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/ScheduledReportService.php:161` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/SmartNotificationsService.php:63` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("{$stockExpr} <= products.min_stock")`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/StockAlertService.php:147` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw('current_stock <= alert_threshold * 0.25')`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/StockReorderService.php:64` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("({$stockSubquery}) <= reorder_point")`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/UX/SmartSuggestionsService.php:178` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `DB::raw('COUNT(*) as frequency'),`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Critical]** `app/Services/WorkflowAutomationService.php:54` — **Raw SQL with variable interpolation (possible SQLi)**
  - Evidence: `whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`
  - Note: Use bindings/parameters; avoid interpolating variables inside SQL strings.

- **[Medium]** `resources/views/components/form/input.blade.php:76` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}
             </span>
         </div>
         @endif
 
         <input
             type="{{ $type }}"`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/icon.blade.php:44` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($iconPath) !!}
 </svg>`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/ui/button.blade.php:56` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}
         @endif
         
         {{ $slot }}
         
         @if($icon && $iconPosition === 'right')`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/ui/card.blade.php:27` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}
             </div>
             @endif
             
             <div>
                 @if($title)`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/ui/empty-state.blade.php:43` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($displayIcon) !!}
         @else
             {{-- Safe output for emoji or plain text --}}
             {{ $displayIc`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/ui/form/input.blade.php:70` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}
         </div>
         @endif
 
         <input
             type="{{ $type }}"
             name="{{ $na`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/components/ui/page-header.blade.php:57` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}
             </div>
             @endif
             
             <div class="flex-1 min-w-0">`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/livewire/auth/two-factor-setup.blade.php:68` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($qrCodeSvg) !!}
                     </div>
                     <div class="text-xs text-slate-500">`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/livewire/shared/dynamic-form.blade.php:52` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($icon) !!}</span>
                             @endif
                             <span>{{ __($label) }}</span>`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.

- **[Medium]** `resources/views/livewire/shared/dynamic-table.blade.php:274` — **Unescaped Blade output `{!! !!}` may enable XSS**
  - Evidence: `{!! sanitize_svg_icon($actionIcon) !!}
                                                     @else`
  - Note: Only allow trusted/sanitized HTML. Prefer `{{ }}` or sanitize before output.


### Authorization (count: 22)

- **[High]** `app/Http/Controllers/Branch/PurchaseController.php:83` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `t branch before approval
         $purchaseModel = Purchase::where('branch_id', $branchId)->findOrFail($purchase);
         
         // Prevent self-approval: verify purchase was`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Http/Controllers/Branch/SaleController.php:71` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `01 FIX: Verify sale belongs to current branch
         Sale::where('branch_id', $branchId)->findOrFail($sale);
 
         return $this->ok($this->sales->handleReturn($sale, $data['`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Http/Controllers/Branch/StockController.php:38` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `nteger('warehouse_id') ?: null;
 
         Product::query()->where('branch_id', $branchId)->findOrFail($pid);
 
         if ($wid !== null) {
             Warehouse::query()->where`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/ActivityLogShow.php:19` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `unt(int $id): void
     {
         $this->activity = Activity::with(['causer', 'subject'])->findOrFail($id);
     }
 
     /**
      * Format properties for human-readable display`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/MediaLibrary.php:115` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `branch_id && ! $canBypassBranch, fn ($q) => $q->forBranch($user->branch_id))
             ->findOrFail($id);
 
         if (! $media->isImage()) {
             session()->flash('er`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/Reports/ReportTemplatesManager.php:141` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `public function edit(int $id): void
     {
         $template = ReportTemplate::query()->findOrFail($id);
 
         $this->editingId = $template->id;
         $this->key = $tem`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/Reports/ScheduledReportsManager.php:177` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `public function edit(int $id): void
     {
         $report = ScheduledReport::query()->findOrFail($id);
 
         $this->editingId = $report->id;
         $this->userId = $re`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/Store/OrdersDashboard.php:187` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `nction viewOrder(int $id): void
     {
         $order = StoreOrder::query()->with('sale')->findOrFail($id);
 
         $payload = $order->payload ?? [];
 
         $this->selected`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Admin/Users/Form.php:161` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `electedRoles) {
                 if ($userId) {
                     $user = User::query()->findOrFail($userId);
                 } else {
                     $user = new User;`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Components/NotesAttachments.php:140` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `type', $this->modelType)
             ->where('noteable_id', $this->modelId)
             ->findOrFail($noteId);
         $this->editingNoteId = $noteId;
         $this->newNote =`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Livewire/Inventory/ProductStoreMappings.php:112` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `n('inventory.products.delete');
 
         $mapping = ProductStoreMapping::with('product')->findOrFail($id);
 
         // Verify branch ownership before delete
         if ($mappi`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Providers/RouteServiceProvider.php:25` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `ch}
         Route::bind('branch', function ($value) {
             return Branch::query()->findOrFail($value);
         });
     }
 
     /**
      * Configure rate limiting for d`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/AuthService.php:111` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `d to impersonate');
                 }
 
                 $as = (\App\Models\User::query()->findOrFail($asUserId));
                 $token = $as->createToken('impersonate-'.Str::r`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/InventoryService.php:256` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `ranch_id', $branchId)
                         ->lockForUpdate()
                         ->findOrFail($productId);
 
                     // Source warehouse must belong to curren`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/POSService.php:421` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `sionId): array
     {
         $session = PosSession::with(['user', 'branch', 'closedBy'])->findOrFail($sessionId);
 
         $sales = Sale::where('branch_id', $session->branch_id`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/PurchaseReturnService.php:151` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `se ($returnId, $data) {
             $return = PurchaseReturn::with(['items', 'supplier'])->findOrFail($returnId);
 
             if (! $return->canBeApproved()) {`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/PurchaseService.php:35` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `nchId = $this->branchIdOrFail();
 
         return Purchase::where('branch_id', $branchId)->findOrFail($id);
     }
 
     public function create(array $payload): Purchase
     {`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/RentalService.php:87` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `$query->where('branch_id', $branchId);
                 }
                 $t = $query->findOrFail($tenantId);
                 $t->is_active = false;
                 $t->save`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/SaleService.php:36` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `$branchId = $this->branchIdOrFail();
 
         return Sale::where('branch_id', $branchId)->findOrFail($id);
     }
 
     public function show(int $id): Sale
     {
         retur`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/SalesReturnService.php:141` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `Id, $userId) {
                 $return = SalesReturn::with(['items.product', 'customer'])->findOrFail($returnId);
                 // V33-CRIT-02 FIX: Use actual_user_id() for pro`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `app/Services/StockTransferService.php:160` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `transferId, $userId) {
                 $transfer = StockTransfer::with(['items.product'])->findOrFail($transferId);
                 // V33-CRIT-02 FIX: Use actual_user_id() for p`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.

- **[High]** `bootstrap/app.php:25` — **Potential IDOR: findOrFail() without visible authorization checks**
  - Evidence: `Route::bind('branch', function ($value) {
                 return Branch::query()->findOrFail($value);
             });
         },
     )
     ->withMiddleware(function (`
  - Note: Confirm Policies/authorize() or branch scoping before loading by raw ID.


### Consistency (count: 8)

- **[High]** `app/Http/Controllers/Api/V1/ProductsController.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=6`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Livewire/Purchases/GRN/Index.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=4`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Livewire/Purchases/GRN/Inspection.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=5`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Livewire/Purchases/Requisitions/Form.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=8`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Models/Transfer.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=4`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Services/ImportService.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=7`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Services/ProductService.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=6`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.

- **[High]** `app/Services/Store/StoreOrderToSaleService.php:1` — **Multiple writes without DB::transaction (atomicity risk)**
  - Evidence: `write_calls=4`
  - Note: Wrap multi-step posting (financial/stock) in DB::transaction to avoid partial commits.


---
## 3) Diff summary (v57 → v58)

- Added files: **1**
- Removed files: **0**
- Changed files: **31**

### Added
- `app/Rules/BranchScopedExists.php`

### Changed
- `app/Helpers/helpers.php`
- `app/Http/Controllers/Admin/AuditLogController.php`
- `app/Http/Controllers/Admin/BranchController.php`
- `app/Http/Controllers/Admin/BranchModuleController.php`
- `app/Http/Controllers/Admin/ModuleCatalogController.php`
- `app/Http/Controllers/Admin/ModuleFieldController.php`
- `app/Http/Controllers/Admin/PermissionController.php`
- `app/Http/Controllers/Admin/RoleController.php`
- `app/Http/Controllers/Admin/SystemSettingController.php`
- `app/Http/Controllers/Admin/UserController.php`
- `app/Http/Controllers/Branch/PurchaseController.php`
- `app/Http/Controllers/Branch/SaleController.php`
- `app/Livewire/Admin/ActivityLog.php`
- `app/Livewire/Admin/BackupRestore.php`
- `app/Livewire/Admin/BulkImport.php`
- `app/Livewire/Admin/Categories/Index.php`
- `app/Livewire/Admin/CurrencyManager.php`
- `app/Livewire/Admin/Modules/ModuleManager.php`
- `app/Livewire/Admin/Store/Stores.php`
- `app/Livewire/Admin/Translations/Form.php`
- `app/Livewire/Admin/Translations/Index.php`
- `app/Livewire/Admin/UnitsOfMeasure/Index.php`
- `app/Livewire/Helpdesk/Categories/Index.php`
- `app/Livewire/Helpdesk/Priorities/Index.php`
- `app/Livewire/Helpdesk/SLAPolicies/Index.php`
- `app/Livewire/Purchases/Form.php`
- `app/Livewire/Sales/Form.php`
- `app/Models/Media.php`
- `app/Models/ModuleField.php`
- `app/Models/ModulePolicy.php`
- `app/Models/ModuleSetting.php`
