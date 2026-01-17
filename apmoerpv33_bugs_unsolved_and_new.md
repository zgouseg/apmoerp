# apmoerp v33 — Bug Delta Report (Old Unsolved + New)

This report includes **only**: (1) bugs from the **v32 report** that are **still present** in v33, and (2) **new** bugs found in v33.

## Summary
- Baseline old bugs (from v32 report): **248**
- Old bugs fixed in v33: **13**
- Old bugs still not solved: **235**
- New bugs found in v33: **114**

### Old bugs still not solved — by severity
- High: 65
- Medium: 170

### New bugs — by severity
- Medium: 114

---

## A) Old bugs NOT solved yet (still present in v33)

### A.1 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.5`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v33): `232`
- Evidence: `->select($column, DB::raw('COUNT(*) as count'))`

### A.2 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.6`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v33): `237`
- Evidence: `$query->whereRaw($where);`

### A.3 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.7`
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v33): `348`
- Evidence: `DB::statement($fix);`

### A.4 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.8`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v33): `126`
- Evidence: `$data = $query->selectRaw('`

### A.5 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.9`
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v33): `75`
- Evidence: `->selectRaw($stockExpr.' as current_stock');`

### A.6 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.10`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v33): `65`
- Evidence: `$query->addSelect(DB::raw("'{$warehouseId}' as warehouse_id"));`

### A.7 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.11`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v33): `70`
- Evidence: `$query->havingRaw('current_quantity <= products.min_stock');`

### A.8 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.12`
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v33): `331`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity) as balance')`

### A.9 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.14`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v33): `86`
- Evidence: `'due_amount' => (clone $query)->selectRaw('SUM(total_amount - paid_amount) as due')->value('due') ?? 0,`

### A.10 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.15`
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v33): `99`
- Evidence: `'total_value' => (clone $query)->sum(DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)')),`

### A.11 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.16`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v33): `147`
- Evidence: `->whereRaw("{$stockExpr} <= min_stock")`

### A.12 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.17`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v33): `285`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### A.13 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.18`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v33): `287`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### A.14 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.19`
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v33): `290`
- Evidence: `->orderByRaw($stockExpr)`

### A.15 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.20`
- File: `app/Livewire/Dashboard/CustomizableDashboard.php`
- Line (v33): `249`
- Evidence: `$totalValue = (clone $productsQuery)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`

### A.16 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.21`
- File: `app/Livewire/Helpdesk/Dashboard.php`
- Line (v33): `76`
- Evidence: `$ticketsByPriority = Ticket::select('priority_id', DB::raw('count(*) as count'))`

### A.17 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.22`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v33): `61`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`

### A.18 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.23`
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v33): `63`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0');`

### A.19 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.24`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `204`
- Evidence: `->selectRaw("{$dateFormat} as period")`

### A.20 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.25`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `328`
- Evidence: `->selectRaw("{$hourExpr} as hour")`

### A.21 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.26`
- File: `app/Livewire/Warehouse/Index.php`
- Line (v33): `99`
- Evidence: `$totalValue = (clone $stockMovementQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0;`

### A.22 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.27`
- File: `app/Livewire/Warehouse/Movements/Index.php`
- Line (v33): `90`
- Evidence: `'total_value' => (clone $baseQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0,`

### A.23 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.28`
- File: `app/Models/Product.php`
- Line (v33): `283`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

### A.24 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.29`
- File: `app/Models/Product.php`
- Line (v33): `299`
- Evidence: `return $query->whereRaw("({$stockSubquery}) <= 0");`

### A.25 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.30`
- File: `app/Models/Product.php`
- Line (v33): `315`
- Evidence: `return $query->whereRaw("({$stockSubquery}) > 0");`

### A.26 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.31`
- File: `app/Models/Project.php`
- Line (v33): `170`
- Evidence: `return $query->whereRaw('actual_cost > budget');`

### A.27 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.32`
- File: `app/Models/SearchIndex.php`
- Line (v33): `76`
- Evidence: `$builder->whereRaw(`

### A.28 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.33`
- File: `app/Models/SearchIndex.php`
- Line (v33): `85`
- Evidence: `$q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])`

### A.29 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.34`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v33): `38`
- Evidence: `$cogs = $cogsQuery->sum(DB::raw('sale_items.quantity * COALESCE(products.cost, 0)'));`

### A.30 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.35`
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v33): `48`
- Evidence: `$avgInventoryValue = $inventoryQuery->sum(DB::raw('COALESCE(stock_quantity, 0) * COALESCE(cost, 0)'));`

### A.31 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.36`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v33): `145`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### A.32 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.37`
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v33): `152`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### A.33 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.38`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v33): `66`
- Evidence: `DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### A.34 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.39`
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v33): `73`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### A.35 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.40`
- File: `app/Services/AutomatedAlertService.php`
- Line (v33): `220`
- Evidence: `->whereRaw("({$stockSubquery}) > 0")`

### A.36 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.41`
- File: `app/Services/Performance/QueryOptimizationService.php`
- Line (v33): `179`
- Evidence: `DB::statement($optimizeStatement);`

### A.37 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.42`
- File: `app/Services/PurchaseReturnService.php`
- Line (v33): `459`
- Evidence: `return $query->select('condition', DB::raw('COUNT(*) as count'), DB::raw('SUM(qty_returned) as total_qty'))`

### A.38 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `B.1`
- File: `app/Services/QueryPerformanceService.php`
- Line (v33): `216`
- Evidence: `$explain = DB::select('EXPLAIN FORMAT=JSON '.$sql);`

### A.39 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.43`
- File: `app/Services/RentalService.php`
- Line (v33): `375`
- Evidence: `$stats = $query->selectRaw('`

### A.40 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.44`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v33): `27`
- Evidence: `->selectRaw("{$datediffExpr} as recency_days")`

### A.41 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.45`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v33): `158`
- Evidence: `->selectRaw("{$datediffExpr} as days_since_purchase")`

### A.42 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.46`
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v33): `44`
- Evidence: `->havingRaw('COALESCE(days_since_sale, 999) > ?', [$days])`

### A.43 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.47`
- File: `app/Services/ScheduledReportService.php`
- Line (v33): `77`
- Evidence: `DB::raw("{$dateExpr} as date"),`

### A.44 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.48`
- File: `app/Services/ScheduledReportService.php`
- Line (v33): `95`
- Evidence: `return $query->groupBy(DB::raw($dateExpr))`

### A.45 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.49`
- File: `app/Services/ScheduledReportService.php`
- Line (v33): `127`
- Evidence: `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

### A.46 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.50`
- File: `app/Services/ScheduledReportService.php`
- Line (v33): `231`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = ?), 0) as quantity', [$branchId]);`

### A.47 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.51`
- File: `app/Services/ScheduledReportService.php`
- Line (v33): `236`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = products.branch_id), 0) as quantity');`

### A.48 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.52`
- File: `app/Services/SmartNotificationsService.php`
- Line (v33): `42`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### A.49 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.53`
- File: `app/Services/SmartNotificationsService.php`
- Line (v33): `43`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### A.50 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.54`
- File: `app/Services/StockReorderService.php`
- Line (v33): `40`
- Evidence: `->whereRaw("({$stockSubquery}) <= reorder_point")`

### A.51 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.55`
- File: `app/Services/StockReorderService.php`
- Line (v33): `65`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

### A.52 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.56`
- File: `app/Services/StockReorderService.php`
- Line (v33): `66`
- Evidence: `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

### A.53 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.57`
- File: `app/Services/StockService.php`
- Line (v33): `31`
- Evidence: `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### A.54 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.58`
- File: `app/Services/StockService.php`
- Line (v33): `101`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### A.55 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.59`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v33): `27`
- Evidence: `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

### A.56 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.60`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v33): `169`
- Evidence: `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`

### A.57 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.61`
- File: `app/Services/WorkflowAutomationService.php`
- Line (v33): `170`
- Evidence: `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`

### A.58 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.4`
- File: `resources/views/components/icon.blade.php`
- Line (v33): `37`
- Evidence: `{!! $iconPath !!}`

### A.59 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.10`
- File: `resources/views/components/ui/card.blade.php`
- Line (v33): `39`
- Evidence: `{!! $actions !!}`

### A.60 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.14`
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v33): `61`
- Evidence: `@if($wireModel) {!! $wireDirective !!} @endif`

### A.61 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.62`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v33): `42`
- Evidence: `? $saleModel::selectRaw('DATE(created_at) as day, SUM(total_amount) as total')`

### A.62 — High — Security/SQL — Raw SQL with variable interpolation
- Baseline ID (v32): `A.63`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v33): `55`
- Evidence: `? $contractModel::selectRaw('status, COUNT(*) as total')`

### A.63 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.17`
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Line (v33): `54`
- Evidence: `{!! $qrCodeSvg !!}`

### A.64 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.18`
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Line (v33): `39`
- Evidence: `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### A.65 — High — Security/XSS — Unescaped Blade output (XSS risk)
- Baseline ID (v32): `B.19`
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Line (v33): `260`
- Evidence: `{!! sanitize_svg_icon($actionIcon) !!}`

### A.66 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v32): `A.101`
- File: `app/Http/Controllers/Admin/MediaDownloadController.php`
- Line (v33): `53`
- Evidence: `$content = $disk->get($path);`

### A.67 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.20`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v33): `249`
- Evidence: `$inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### A.68 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.21`
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v33): `252`
- Evidence: `$outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### A.69 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.22`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v33): `205`
- Evidence: `$lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### A.70 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.23`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v33): `206`
- Evidence: `$lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### A.71 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.24`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v33): `223`
- Evidence: `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### A.72 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.25`
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v33): `225`
- Evidence: `$tax = max(0, (float) ($validated['tax'] ?? 0));`

### A.73 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.26`
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v33): `77`
- Evidence: `'price' => (float) $product->default_price,`

### A.74 — Medium — Logic/Files — Local disk URL generation may fail
- Baseline ID (v32): `A.100`
- File: `app/Http/Controllers/Branch/ProductController.php`
- Line (v33): `156`
- Evidence: `'url' => Storage::disk('local')->url($path),`

### A.75 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.27`
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Line (v33): `103`
- Evidence: `return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### A.76 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.28`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v33): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### A.77 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.29`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v33): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.78 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.30`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v33): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.79 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.31`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v33): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.80 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.32`
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v33): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.81 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.33`
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Line (v33): `51`
- Evidence: `(float) $data['amount'],`

### A.82 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.34`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v33): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### A.83 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.35`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v33): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### A.84 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.36`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v33): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### A.85 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.37`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v33): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### A.86 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.38`
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v33): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### A.87 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v32): `A.102`
- File: `app/Http/Controllers/Files/UploadController.php`
- Line (v33): `41`
- Evidence: `$content = $storage->get($path);`

### A.88 — Medium — Security/Auth — Token accepted via query/body (leak risk)
- Baseline ID (v32): `A.104`
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Line (v33): `109`
- Evidence: `return $request->query('api_token') ?? $request->input('api_token');`

### A.89 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.39`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v33): `43`
- Evidence: `$disc = (float) ($row['discount'] ?? 0);`

### A.90 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.40`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v33): `80`
- Evidence: `return (float) (config('erp.discount.max_line', 15)); // sensible default`

### A.91 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.41`
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v33): `89`
- Evidence: `return (float) (config('erp.discount.max_invoice', 20));`

### A.92 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.42`
- File: `app/Http/Resources/CustomerResource.php`
- Line (v33): `38`
- Evidence: `(float) ($this->balance ?? 0.0)`

### A.93 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.43`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v33): `20`
- Evidence: `'discount' => (float) $this->discount,`

### A.94 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.44`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v33): `21`
- Evidence: `'tax' => (float) ($this->tax ?? 0),`

### A.95 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.45`
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v33): `22`
- Evidence: `'total' => (float) $this->line_total,`

### A.96 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.46`
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `24`
- Evidence: `'discount' => (float) $this->discount,`

### A.97 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.47`
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `25`
- Evidence: `'tax' => (float) $this->tax,`

### A.98 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.48`
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `26`
- Evidence: `'total' => (float) $this->grand_total,`

### A.99 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.49`
- File: `app/Http/Resources/ProductResource.php`
- Line (v33): `47`
- Evidence: `'price' => (float) $this->default_price,`

### A.100 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.50`
- File: `app/Http/Resources/ProductResource.php`
- Line (v33): `48`
- Evidence: `'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### A.101 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.51`
- File: `app/Jobs/ClosePosDayJob.php`
- Line (v33): `72`
- Evidence: `$paid = (float) $paidString;`

### A.102 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.52`
- File: `app/Listeners/ApplyLateFee.php`
- Line (v33): `43`
- Evidence: `$invoice->amount = (float) $newAmount;`

### A.103 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.53`
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Line (v33): `144`
- Evidence: `'amount' => number_format((float) ltrim($difference, '-'), 2),`

### A.104 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.54`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v33): `67`
- Evidence: `$totalRevenue = (float) $ordersForStats->sum('total');`

### A.105 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.55`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v33): `84`
- Evidence: `$sources[$source]['revenue'] += (float) $order->total;`

### A.106 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.56`
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v33): `139`
- Evidence: `$dayValues[] = (float) $items->sum('total');`

### A.107 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.57`
- File: `app/Livewire/Banking/Reconciliation.php`
- Line (v33): `304`
- Evidence: `'amount' => number_format((float) $this->difference, 2),`

### A.108 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.58`
- File: `app/Livewire/Income/Form.php`
- Line (v33): `102`
- Evidence: `$this->amount = (float) $income->amount;`

### A.109 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.59`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v33): `132`
- Evidence: `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### A.110 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.60`
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v33): `133`
- Evidence: `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### A.111 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.61`
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v33): `137`
- Evidence: `$this->cost = (float) ($product->cost ?: $product->standard_cost);`

### A.112 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.62`
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `173`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### A.113 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.63`
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `239`
- Evidence: `'unit_cost' => (float) ($product->cost ?? 0),`

### A.114 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.64`
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `357`
- Evidence: `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### A.115 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.65`
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v33): `104`
- Evidence: `'cost' => (float) $item->unit_cost,`

### A.116 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.64`
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Line (v33): `69`
- Evidence: `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### A.117 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.65`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `152`
- Evidence: `$avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### A.118 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.66`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `171`
- Evidence: `$salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### A.119 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.67`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `176`
- Evidence: `$completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### A.120 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.66`
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v33): `319`
- Evidence: `'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.121 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.67`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `195`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### A.122 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.68`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `202`
- Evidence: `$this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### A.123 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.68`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `300`
- Evidence: `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### A.124 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.69`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `340`
- Evidence: `return (float) bcdiv($result, '1', BCMATH_STORAGE_SCALE);`

### A.125 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.70`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `476`
- Evidence: `'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### A.126 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.71`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `478`
- Evidence: `'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### A.127 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.72`
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `479`
- Evidence: `'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### A.128 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.69`
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v33): `116`
- Evidence: `'price' => (float) $item->unit_price,`

### A.129 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.70`
- File: `app/Models/BankTransaction.php`
- Line (v33): `107`
- Evidence: `$amount = (float) $this->amount;`

### A.130 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.71`
- File: `app/Models/InstallmentPayment.php`
- Line (v33): `61`
- Evidence: `$newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### A.131 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.72`
- File: `app/Models/InstallmentPayment.php`
- Line (v33): `62`
- Evidence: `$newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### A.132 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.73`
- File: `app/Models/StockTransferItem.php`
- Line (v33): `74`
- Evidence: `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### A.133 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.73`
- File: `app/Observers/ProductObserver.php`
- Line (v33): `31`
- Evidence: `$product->cost = round((float) $product->cost, 2);`

### A.134 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.75`
- File: `app/Rules/ValidDiscountPercentage.php`
- Line (v33): `29`
- Evidence: `$discount = (float) $value;`

### A.135 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.76`
- File: `app/Rules/ValidPriceOverride.php`
- Line (v33): `25`
- Evidence: `$price = (float) $value;`

### A.136 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.74`
- File: `app/Services/AutomatedAlertService.php`
- Line (v33): `173`
- Evidence: `$utilization = (float) bcmul(`

### A.137 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.75`
- File: `app/Services/AutomatedAlertService.php`
- Line (v33): `183`
- Evidence: `$availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### A.138 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.76`
- File: `app/Services/AutomatedAlertService.php`
- Line (v33): `234`
- Evidence: `$estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### A.139 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.77`
- File: `app/Services/CurrencyExchangeService.php`
- Line (v33): `55`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 4);`

### A.140 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.78`
- File: `app/Services/CurrencyService.php`
- Line (v33): `128`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 2);`

### A.141 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.77`
- File: `app/Services/DataValidationService.php`
- Line (v33): `115`
- Evidence: `$amount = (float) $amount;`

### A.142 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- Baseline ID (v32): `A.103`
- File: `app/Services/DiagnosticsService.php`
- Line (v33): `178`
- Evidence: `$retrieved = Storage::disk($disk)->get($filename);`

### A.143 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.78`
- File: `app/Services/DiscountService.php`
- Line (v33): `93`
- Evidence: `return (float) config('pos.discount.max_amount', 1000);`

### A.144 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.79`
- File: `app/Services/DiscountService.php`
- Line (v33): `103`
- Evidence: `: (float) config('pos.discount.max_amount', 1000);`

### A.145 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.80`
- File: `app/Services/DiscountService.php`
- Line (v33): `157`
- Evidence: `$value = (float) ($discount['value'] ?? 0);`

### A.146 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.81`
- File: `app/Services/FinancialReportService.php`
- Line (v33): `148`
- Evidence: `'total' => (float) bcround((string) $totalRevenue, 2),`

### A.147 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.82`
- File: `app/Services/FinancialReportService.php`
- Line (v33): `153`
- Evidence: `'total' => (float) bcround((string) $totalExpenses, 2),`

### A.148 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.83`
- File: `app/Services/FinancialReportService.php`
- Line (v33): `253`
- Evidence: `'total' => (float) bcround((string) $totalAssets, 2),`

### A.149 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.84`
- File: `app/Services/FinancialReportService.php`
- Line (v33): `258`
- Evidence: `'total' => (float) bcround((string) $totalLiabilities, 2),`

### A.150 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.85`
- File: `app/Services/FinancialReportService.php`
- Line (v33): `263`
- Evidence: `'total' => (float) bcround((string) $totalEquity, 2),`

### A.151 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.79`
- File: `app/Services/HRMService.php`
- Line (v33): `235`
- Evidence: `return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### A.152 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.80`
- File: `app/Services/HelpdeskService.php`
- Line (v33): `293`
- Evidence: `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### A.153 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.86`
- File: `app/Services/ImportService.php`
- Line (v33): `568`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### A.154 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.87`
- File: `app/Services/InstallmentService.php`
- Line (v33): `103`
- Evidence: `'amount_due' => max(0, (float) $amount),`

### A.155 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.81`
- File: `app/Services/LoyaltyService.php`
- Line (v33): `208`
- Evidence: `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### A.156 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.88`
- File: `app/Services/POSService.php`
- Line (v33): `128`
- Evidence: `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### A.157 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.89`
- File: `app/Services/POSService.php`
- Line (v33): `145`
- Evidence: `if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### A.158 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.90`
- File: `app/Services/POSService.php`
- Line (v33): `149`
- Evidence: `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### A.159 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.91`
- File: `app/Services/POSService.php`
- Line (v33): `153`
- Evidence: `$itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### A.160 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.92`
- File: `app/Services/POSService.php`
- Line (v33): `232`
- Evidence: `$amount = (float) ($payment['amount'] ?? 0);`

### A.161 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.93`
- File: `app/Services/POSService.php`
- Line (v33): `259`
- Evidence: `'amount' => (float) bcround($grandTotal, 2),`

### A.162 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.94`
- File: `app/Services/POSService.php`
- Line (v33): `486`
- Evidence: `'paid' => (float) $paidAmountString,`

### A.163 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.95`
- File: `app/Services/PayslipService.php`
- Line (v33): `112`
- Evidence: `'total' => (float) $total,`

### A.164 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.82`
- File: `app/Services/PricingService.php`
- Line (v33): `30`
- Evidence: `return (float) bcdiv((string) $override, '1', 4);`

### A.165 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.83`
- File: `app/Services/PricingService.php`
- Line (v33): `38`
- Evidence: `return (float) bcdiv((string) $p, '1', 4);`

### A.166 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.84`
- File: `app/Services/PricingService.php`
- Line (v33): `45`
- Evidence: `return (float) bcdiv((string) $base, '1', 4);`

### A.167 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.97`
- File: `app/Services/PricingService.php`
- Line (v33): `58`
- Evidence: `$price = max(0.0, (float) Arr::get($line, 'price', 0));`

### A.168 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.98`
- File: `app/Services/PricingService.php`
- Line (v33): `60`
- Evidence: `$discVal = (float) Arr::get($line, 'discount', 0);`

### A.169 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.99`
- File: `app/Services/PricingService.php`
- Line (v33): `85`
- Evidence: `'discount' => (float) bcround((string) $discount, 2),`

### A.170 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.100`
- File: `app/Services/PricingService.php`
- Line (v33): `86`
- Evidence: `'tax' => (float) bcround((string) $taxAmount, 2),`

### A.171 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.101`
- File: `app/Services/PricingService.php`
- Line (v33): `87`
- Evidence: `'total' => (float) bcround((string) $total, 2),`

### A.172 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.102`
- File: `app/Services/ProductService.php`
- Line (v33): `113`
- Evidence: `$product->default_price = (float) $price;`

### A.173 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.103`
- File: `app/Services/ProductService.php`
- Line (v33): `118`
- Evidence: `$product->cost = (float) $cost;`

### A.174 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.104`
- File: `app/Services/PurchaseService.php`
- Line (v33): `79`
- Evidence: `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### A.175 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.85`
- File: `app/Services/PurchaseService.php`
- Line (v33): `105`
- Evidence: `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### A.176 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.105`
- File: `app/Services/PurchaseService.php`
- Line (v33): `283`
- Evidence: `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### A.177 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.106`
- File: `app/Services/RentalService.php`
- Line (v33): `270`
- Evidence: `$i->amount = (float) $newAmount;`

### A.178 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.86`
- File: `app/Services/RentalService.php`
- Line (v33): `388`
- Evidence: `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### A.179 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.87`
- File: `app/Services/RentalService.php`
- Line (v33): `519`
- Evidence: `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### A.180 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.107`
- File: `app/Services/ReportService.php`
- Line (v33): `53`
- Evidence: `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### A.181 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.108`
- File: `app/Services/ReportService.php`
- Line (v33): `54`
- Evidence: `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### A.182 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.109`
- File: `app/Services/ReportService.php`
- Line (v33): `55`
- Evidence: `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### A.183 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.110`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v33): `41`
- Evidence: `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### A.184 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.111`
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v33): `42`
- Evidence: `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### A.185 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.88`
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v33): `136`
- Evidence: `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### A.186 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.112`
- File: `app/Services/SaleService.php`
- Line (v33): `222`
- Evidence: `'amount' => (float) $refund,`

### A.187 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.113`
- File: `app/Services/SalesReturnService.php`
- Line (v33): `209`
- Evidence: `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### A.188 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.114`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `164`
- Evidence: `$price = (float) Arr::get($item, 'price', 0);`

### A.189 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.115`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `165`
- Evidence: `$discount = (float) Arr::get($item, 'discount', 0);`

### A.190 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.116`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `255`
- Evidence: `$total = (float) ($order->total ?? 0);`

### A.191 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.117`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `256`
- Evidence: `$tax = (float) ($order->tax_total ?? 0);`

### A.192 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.118`
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `258`
- Evidence: `$discount = (float) ($order->discount_total ?? 0);`

### A.193 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.119`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `320`
- Evidence: `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### A.194 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.120`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `458`
- Evidence: `'unit_price' => (float) ($lineItem['price'] ?? 0),`

### A.195 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.121`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `461`
- Evidence: `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### A.196 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.122`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `488`
- Evidence: `'default_price' => (float) ($data['price'] ?? 0),`

### A.197 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.123`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `581`
- Evidence: `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### A.198 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.124`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `584`
- Evidence: `'total_amount' => (float) ($data['total'] ?? 0),`

### A.199 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.126`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `632`
- Evidence: `'line_total' => (float) ($lineItem['total'] ?? 0),`

### A.200 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.127`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `756`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### A.201 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.128`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `757`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### A.202 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.129`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `827`
- Evidence: `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### A.203 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.130`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `828`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### A.204 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.131`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `829`
- Evidence: `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### A.205 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.132`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `857`
- Evidence: `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### A.206 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.133`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `858`
- Evidence: `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### A.207 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.134`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `859`
- Evidence: `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### A.208 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.135`
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `992`
- Evidence: `return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### A.209 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.136`
- File: `app/Services/TaxService.php`
- Line (v33): `23`
- Evidence: `return (float) ($tax?->rate ?? 0.0);`

### A.210 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.137`
- File: `app/Services/TaxService.php`
- Line (v33): `51`
- Evidence: `$rate = (float) $tax->rate;`

### A.211 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.89`
- File: `app/Services/TaxService.php`
- Line (v33): `63`
- Evidence: `return (float) bcdiv($taxPortion, '1', 4);`

### A.212 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.90`
- File: `app/Services/TaxService.php`
- Line (v33): `69`
- Evidence: `return (float) bcdiv($taxAmount, '1', 4);`

### A.213 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.91`
- File: `app/Services/TaxService.php`
- Line (v33): `82`
- Evidence: `return (float) bcdiv((string) $base, '1', 4);`

### A.214 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.92`
- File: `app/Services/TaxService.php`
- Line (v33): `98`
- Evidence: `return (float) bcdiv($total, '1', 4);`

### A.215 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.93`
- File: `app/Services/TaxService.php`
- Line (v33): `102`
- Evidence: `defaultValue: (float) bcdiv((string) $base, '1', 4)`

### A.216 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.94`
- File: `app/Services/TaxService.php`
- Line (v33): `142`
- Evidence: `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### A.217 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.95`
- File: `app/Services/UIHelperService.php`
- Line (v33): `190`
- Evidence: `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### A.218 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.138`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `97`
- Evidence: `$cost = (float) ($product->standard_cost ?? 0);`

### A.219 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.139`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `121`
- Evidence: `'price' => (float) $price,`

### A.220 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.96`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `123`
- Evidence: `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### A.221 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.97`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `144`
- Evidence: `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### A.222 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.140`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `197`
- Evidence: `'price' => (float) $item->default_price,`

### A.223 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.141`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `245`
- Evidence: `'price' => (float) $product->default_price,`

### A.224 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.98`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `274`
- Evidence: `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### A.225 — Medium — Finance/Precision — BCMath result cast to float
- Baseline ID (v32): `A.99`
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `412`
- Evidence: `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### A.226 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.142`
- File: `app/Services/WhatsAppService.php`
- Line (v33): `114`
- Evidence: `'tax' => number_format((float) $sale->tax_total, 2),`

### A.227 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.143`
- File: `app/Services/WhatsAppService.php`
- Line (v33): `115`
- Evidence: `'discount' => number_format((float) $sale->discount_total, 2),`

### A.228 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.144`
- File: `app/Services/WhatsAppService.php`
- Line (v33): `116`
- Evidence: `'total' => number_format((float) $sale->grand_total, 2),`

### A.229 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.145`
- File: `app/ValueObjects/Money.php`
- Line (v33): `73`
- Evidence: `return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### A.230 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.146`
- File: `app/ValueObjects/Money.php`
- Line (v33): `81`
- Evidence: `return (float) $this->amount;`

### A.231 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.147`
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v33): `51`
- Evidence: `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### A.232 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.148`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v33): `62`
- Evidence: `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.233 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.149`
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v33): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### A.234 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.150`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v33): `62`
- Evidence: `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### A.235 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- Baseline ID (v32): `B.151`
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v33): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`

---

## B) New bugs found in v33

### B.1 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php`
- Line (v33): `83`
- Evidence: `$stock = (float) ($stockData[$product->id] ?? 0);`

### B.2 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v33): `92`
- Evidence: `'current_stock' => (float) ($product->current_stock ?? 0),`

### B.3 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v33): `226`
- Evidence: `$shipping = max(0, (float) ($validated['shipping'] ?? 0));`

### B.4 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Controllers/Api/V1/POSController.php`
- Line (v33): `181`
- Evidence: `(float) ($request->input('opening_cash') ?? 0)`

### B.5 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v33): `50`
- Evidence: `$invDisc = (float) ($payload['invoice_discount'] ?? 0);`

### B.6 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/CustomerResource.php`
- Line (v33): `26`
- Evidence: `(float) ($this->credit_limit ?? 0.0)`

### B.7 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/CustomerResource.php`
- Line (v33): `30`
- Evidence: `(float) ($this->discount_percentage ?? 0.0)`

### B.8 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/CustomerResource.php`
- Line (v33): `50`
- Evidence: `(float) ($this->total_purchases ?? 0.0)`

### B.9 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `27`
- Evidence: `'paid_amount' => (float) ($this->paid_total ?? 0),`

### B.10 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `51`
- Evidence: `$paidTotal = (float) ($this->paid_total ?? 0);`

### B.11 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/OrderResource.php`
- Line (v33): `52`
- Evidence: `$grandTotal = (float) ($this->grand_total ?? 0);`

### B.12 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `25`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### B.13 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `26`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### B.14 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `27`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### B.15 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `28`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### B.16 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `29`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### B.17 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `30`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### B.18 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/PurchaseResource.php`
- Line (v33): `31`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### B.19 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `31`
- Evidence: `'sub_total' => (float) ($this->sub_total ?? 0.0),`

### B.20 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `32`
- Evidence: `'tax_total' => (float) ($this->tax_total ?? 0.0),`

### B.21 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `33`
- Evidence: `'discount_total' => (float) ($this->discount_total ?? 0.0),`

### B.22 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `34`
- Evidence: `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`

### B.23 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `35`
- Evidence: `'grand_total' => (float) ($this->grand_total ?? 0.0),`

### B.24 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `36`
- Evidence: `'paid_total' => (float) ($this->paid_total ?? 0.0),`

### B.25 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SaleResource.php`
- Line (v33): `37`
- Evidence: `'due_total' => (float) ($this->due_total ?? 0.0),`

### B.26 — Medium — Finance/Precision — Float cast for totals
- File: `app/Http/Resources/SupplierResource.php`
- Line (v33): `37`
- Evidence: `(float) ($this->minimum_order_value ?? 0.0)`

### B.27 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/PurchasesSettings.php`
- Line (v33): `58`
- Evidence: `$this->purchase_approval_threshold = (float) ($settings['purchases.approval_threshold'] ?? 10000);`

### B.28 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `256`
- Evidence: `$this->hrm_working_hours_per_day = (float) ($settings['hrm.working_hours_per_day'] ?? 8.0);`

### B.29 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `259`
- Evidence: `$this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`

### B.30 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `261`
- Evidence: `$this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`

### B.31 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `262`
- Evidence: `$this->hrm_meal_allowance = (float) ($settings['hrm.meal_allowance'] ?? 0.0);`

### B.32 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `263`
- Evidence: `$this->hrm_health_insurance_deduction = (float) ($settings['hrm.health_insurance_deduction'] ?? 0.0);`

### B.33 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Admin/Settings/UnifiedSettings.php`
- Line (v33): `268`
- Evidence: `$this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`

### B.34 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v33): `206`
- Evidence: `$data[] = (float) ($salesByDate[$dateKey] ?? 0);`

### B.35 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Customers/Form.php`
- Line (v33): `89`
- Evidence: `$this->credit_limit = (float) ($customer->credit_limit ?? 0);`

### B.36 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Customers/Form.php`
- Line (v33): `90`
- Evidence: `$this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`

### B.37 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Hrm/Employees/Form.php`
- Line (v33): `93`
- Evidence: `$this->form['salary'] = (float) ($employeeModel->salary ?? 0);`

### B.38 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v33): `142`
- Evidence: `$this->form['min_stock'] = (float) ($p->min_stock ?? 0);`

### B.39 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v33): `144`
- Evidence: `$this->form['reorder_point'] = (float) ($p->reorder_point ?? 0);`

### B.40 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v33): `206`
- Evidence: `'total_hours' => (float) ($stats->total_hours ?? 0),`

### B.41 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v33): `207`
- Evidence: `'billable_hours' => (float) ($stats->billable_hours ?? 0),`

### B.42 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v33): `208`
- Evidence: `'non_billable_hours' => (float) ($stats->non_billable_hours ?? 0),`

### B.43 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Projects/TimeLogs.php`
- Line (v33): `209`
- Evidence: `'total_cost' => (float) ($stats->total_cost ?? 0),`

### B.44 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `163`
- Evidence: `$this->discount_total = (float) ($purchase->discount_total ?? 0);`

### B.45 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `164`
- Evidence: `$this->shipping_total = (float) ($purchase->shipping_total ?? 0);`

### B.46 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Purchases/Form.php`
- Line (v33): `174`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### B.47 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `185`
- Evidence: `$this->discount_total = (float) ($sale->discount_total ?? 0);`

### B.48 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `186`
- Evidence: `$this->shipping_total = (float) ($sale->shipping_total ?? 0);`

### B.49 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `196`
- Evidence: `'tax_rate' => (float) ($item->tax_rate ?? 0),`

### B.50 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `268`
- Evidence: `'unit_price' => (float) ($product->default_price ?? 0),`

### B.51 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Sales/Form.php`
- Line (v33): `446`
- Evidence: `$validatedPrice = (float) ($product->default_price ?? 0);`

### B.52 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Suppliers/Form.php`
- Line (v33): `115`
- Evidence: `$this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`

### B.53 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Suppliers/Form.php`
- Line (v33): `117`
- Evidence: `$this->quality_rating = (float) ($supplier->quality_rating ?? 0);`

### B.54 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Suppliers/Form.php`
- Line (v33): `118`
- Evidence: `$this->delivery_rating = (float) ($supplier->delivery_rating ?? 0);`

### B.55 — Medium — Finance/Precision — Float cast for totals
- File: `app/Livewire/Suppliers/Form.php`
- Line (v33): `119`
- Evidence: `$this->service_rating = (float) ($supplier->service_rating ?? 0);`

### B.56 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BillOfMaterial.php`
- Line (v33): `124`
- Evidence: `$scrapFactor = 1 + ((float) ($item->scrap_percentage ?? 0) / 100);`

### B.57 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BillOfMaterial.php`
- Line (v33): `130`
- Evidence: `$yieldFactor = (float) ($this->yield_percentage ?? 100) / 100;`

### B.58 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BillOfMaterial.php`
- Line (v33): `145`
- Evidence: `$durationHours = (float) ($operation->duration_minutes ?? 0) / 60;`

### B.59 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BillOfMaterial.php`
- Line (v33): `146`
- Evidence: `$costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`

### B.60 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BillOfMaterial.php`
- Line (v33): `148`
- Evidence: `return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`

### B.61 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/BomItem.php`
- Line (v33): `70`
- Evidence: `$scrapFactor = 1 + ((float) ($this->scrap_percentage ?? 0) / 100);`

### B.62 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/FixedAsset.php`
- Line (v33): `156`
- Evidence: `$currentValue = (float) ($this->current_value ?? 0);`

### B.63 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/FixedAsset.php`
- Line (v33): `157`
- Evidence: `$salvageValue = (float) ($this->salvage_value ?? 0);`

### B.64 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/FixedAsset.php`
- Line (v33): `175`
- Evidence: `$purchaseCost = (float) ($this->purchase_cost ?? 0);`

### B.65 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/GRNItem.php`
- Line (v33): `85`
- Evidence: `$expectedQty = (float) ($this->expected_quantity ?? 0);`

### B.66 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/InstallmentPayment.php`
- Line (v33): `45`
- Evidence: `return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`

### B.67 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/InstallmentPayment.php`
- Line (v33): `60`
- Evidence: `$amountPaid = (float) ($this->amount_paid ?? 0);`

### B.68 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/JournalEntry.php`
- Line (v33): `101`
- Evidence: `return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`

### B.69 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/JournalEntry.php`
- Line (v33): `106`
- Evidence: `return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`

### B.70 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/ProductionOrder.php`
- Line (v33): `175`
- Evidence: `$plannedQty = (float) ($this->planned_quantity ?? 0);`

### B.71 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/ProductionOrder.php`
- Line (v33): `181`
- Evidence: `return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`

### B.72 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/Project.php`
- Line (v33): `208`
- Evidence: `return (float) ($timeLogsCost + $expensesCost);`

### B.73 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/ProjectTimeLog.php`
- Line (v33): `110`
- Evidence: `return (float) ($this->hours * $this->hourly_rate);`

### B.74 — Medium — Finance/Precision — Float cast for totals
- File: `app/Models/Supplier.php`
- Line (v33): `129`
- Evidence: `return (float) ($this->rating ?? 0);`

### B.75 — Medium — Finance/Precision — Float cast for totals
- File: `app/Repositories/StockMovementRepository.php`
- Line (v33): `74`
- Evidence: `$in = (float) (clone $baseQuery)->where('quantity', '>', 0)->sum('quantity');`

### B.76 — Medium — Finance/Precision — Float cast for totals
- File: `app/Repositories/StockMovementRepository.php`
- Line (v33): `138`
- Evidence: `$qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`

### B.77 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/AccountingService.php`
- Line (v33): `606`
- Evidence: `return (float) ($result ?? 0);`

### B.78 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/HRMService.php`
- Line (v33): `111`
- Evidence: `$housingAllowance = (float) ($extra['housing_allowance'] ?? 0);`

### B.79 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/HRMService.php`
- Line (v33): `112`
- Evidence: `$transportAllowance = (float) ($extra['transport_allowance'] ?? 0);`

### B.80 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/HRMService.php`
- Line (v33): `113`
- Evidence: `$otherAllowance = (float) ($extra['other_allowance'] ?? 0);`

### B.81 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/HRMService.php`
- Line (v33): `120`
- Evidence: `$loanDeduction = (float) ($extra['loan_deduction'] ?? 0);`

### B.82 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/ImportService.php`
- Line (v33): `567`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? 0),`

### B.83 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/ImportService.php`
- Line (v33): `587`
- Evidence: `'credit_limit' => (float) ($data['credit_limit'] ?? 0),`

### B.84 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/InventoryService.php`
- Line (v33): `48`
- Evidence: `return (float) ($perWarehouse->get($warehouseId, 0.0));`

### B.85 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/POSService.php`
- Line (v33): `112`
- Evidence: `$qty = (float) ($it['qty'] ?? 1);`

### B.86 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PayslipService.php`
- Line (v33): `126`
- Evidence: `$siRate = (float) ($siConfig['rate'] ?? 0.14);`

### B.87 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PayslipService.php`
- Line (v33): `127`
- Evidence: `$siMaxSalary = (float) ($siConfig['max_salary'] ?? 12600);`

### B.88 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PayslipService.php`
- Line (v33): `142`
- Evidence: `$limit = (float) ($bracket['limit'] ?? PHP_FLOAT_MAX);`

### B.89 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PayslipService.php`
- Line (v33): `143`
- Evidence: `$rate = (float) ($bracket['rate'] ?? 0);`

### B.90 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PurchaseService.php`
- Line (v33): `94`
- Evidence: `$discountPercent = (float) ($it['discount_percent'] ?? 0);`

### B.91 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PurchaseService.php`
- Line (v33): `101`
- Evidence: `$taxPercent = (float) ($it['tax_percent'] ?? 0);`

### B.92 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PurchaseService.php`
- Line (v33): `102`
- Evidence: `$lineTax = (float) ($it['tax_amount'] ?? 0);`

### B.93 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/PurchaseService.php`
- Line (v33): `135`
- Evidence: `$shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`

### B.94 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/SaleService.php`
- Line (v33): `71`
- Evidence: `$requestedQty = (float) ($it['qty'] ?? 0);`

### B.95 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/SalesReturnService.php`
- Line (v33): `89`
- Evidence: `$qtyToReturn = (float)($itemData['qty'] ?? 0);`

### B.96 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/StockTransferService.php`
- Line (v33): `104`
- Evidence: `$requestedQty = (float) ($itemData['qty'] ?? 0);`

### B.97 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/StockTransferService.php`
- Line (v33): `336`
- Evidence: `$qtyReceived = (float) ($itemData['qty_received'] ?? 0);`

### B.98 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/StockTransferService.php`
- Line (v33): `337`
- Evidence: `$qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`

### B.99 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/StockTransferService.php`
- Line (v33): `376`
- Evidence: `$qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`

### B.100 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/StockTransferService.php`
- Line (v33): `377`
- Evidence: `$qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`

### B.101 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v33): `257`
- Evidence: `$shipping = (float) ($order->shipping_total ?? 0);`

### B.102 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `410`
- Evidence: `'subtotal' => (float) ($data['subtotal_price'] ?? 0),`

### B.103 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `411`
- Evidence: `'tax_amount' => (float) ($data['total_tax'] ?? 0),`

### B.104 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `412`
- Evidence: `'discount_amount' => (float) ($data['total_discounts'] ?? 0),`

### B.105 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `413`
- Evidence: `'total_amount' => (float) ($data['total_price'] ?? 0),`

### B.106 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `460`
- Evidence: `'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`

### B.107 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `583`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? 0),`

### B.108 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `826`
- Evidence: `'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`

### B.109 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/Store/StoreSyncService.php`
- Line (v33): `856`
- Evidence: `'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`

### B.110 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/TaxService.php`
- Line (v33): `130`
- Evidence: `$subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`

### B.111 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/TaxService.php`
- Line (v33): `175`
- Evidence: `$rate = (float) ($taxRateRules['rate'] ?? 0);`

### B.112 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `128`
- Evidence: `$currentPrice = (float) ($product->default_price ?? 0);`

### B.113 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v33): `290`
- Evidence: `return (float) ($totalStock ?? 0);`

### B.114 — Medium — Finance/Precision — Float cast for totals
- File: `app/Services/WoodService.php`
- Line (v33): `83`
- Evidence: `'qty' => (float) ($payload['qty'] ?? 0),`
