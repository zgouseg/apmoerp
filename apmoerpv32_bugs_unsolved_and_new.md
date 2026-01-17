# apmoerp v32 — Bug Delta Report (Old Unsolved + New)

This report includes **only**: (1) old bugs from the **v31 report** that are **still present** in v32, and (2) **new** bugs found in v32.

## Summary
- Baseline old bugs (from v31 report): **104**
- Old bugs fixed in v32: **0**
- Old bugs still not solved: **104**
- New bugs found in v32: **151**

### Old bugs still not solved — by severity
- High: 63
- Medium: 41

### New bugs — by severity
- High: 19
- Medium: 132

---

## A) Old bugs NOT solved yet (still present in v32)

### A.1 — High — Logic/Multi-branch — Fallback to Branch::first()?->id can mis-assign records
- File: `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- Line (v32): `82`
- Evidence: `$branchId = $user->branch_id ?? Branch::first()?->id;`

### A.2 — High — Logic/Multi-branch — Fallback to Branch::first()?->id can mis-assign records
- File: `app/Livewire/Manufacturing/ProductionOrders/Form.php`
- Line (v32): `87`
- Evidence: `$branchId = $user->branch_id ?? Branch::first()?->id;`

### A.3 — High — Logic/Multi-branch — Fallback to Branch::first()?->id can mis-assign records
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v32): `103`
- Evidence: `return Branch::first()?->id;`

### A.4 — High — Logic/Multi-branch — Fallback to Branch::first()?->id can mis-assign records
- File: `app/Livewire/Manufacturing/WorkCenters/Form.php`
- Line (v32): `131`
- Evidence: `$branchId = $user->branch_id ?? Branch::first()?->id;`

### A.5 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v32): `232`
- Evidence: `->select($column, DB::raw('COUNT(*) as count'))`

### A.6 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v32): `237`
- Evidence: `$query->whereRaw($where);`

### A.7 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Console/Commands/CheckDatabaseIntegrity.php`
- Line (v32): `348`
- Evidence: `DB::statement($fix);`

### A.8 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v32): `126`
- Evidence: `$data = $query->selectRaw('`

### A.9 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Api/StoreIntegrationController.php`
- Line (v32): `75`
- Evidence: `->selectRaw($stockExpr.' as current_stock');`

### A.10 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v32): `58`
- Evidence: `$query->addSelect(DB::raw("'{$warehouseId}' as warehouse_id"));`

### A.11 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v32): `63`
- Evidence: `$query->havingRaw('current_quantity <= products.min_stock');`

### A.12 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Api/V1/InventoryController.php`
- Line (v32): `314`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity) as balance')`

### A.13 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Http/Controllers/Branch/ReportsController.php`
- Line (v32): `50`
- Evidence: `->selectRaw("{$dateExpr} as first_move")`

### A.14 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v32): `86`
- Evidence: `'due_amount' => (clone $query)->selectRaw('SUM(total_amount - paid_amount) as due')->value('due') ?? 0,`

### A.15 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Admin/Branch/Reports.php`
- Line (v32): `99`
- Evidence: `'total_value' => (clone $query)->sum(DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)')),`

### A.16 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v32): `147`
- Evidence: `->whereRaw("{$stockExpr} <= min_stock")`

### A.17 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v32): `285`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### A.18 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v32): `287`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### A.19 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Concerns/LoadsDashboardData.php`
- Line (v32): `290`
- Evidence: `->orderByRaw($stockExpr)`

### A.20 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Dashboard/CustomizableDashboard.php`
- Line (v32): `249`
- Evidence: `$totalValue = (clone $productsQuery)->sum(\Illuminate\Support\Facades\DB::raw('COALESCE(default_price, 0) * COALESCE(stock_quantity, 0)'));`

### A.21 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Helpdesk/Dashboard.php`
- Line (v32): `76`
- Evidence: `$ticketsByPriority = Ticket::select('priority_id', DB::raw('count(*) as count'))`

### A.22 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v32): `61`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= products.min_stock AND COALESCE(stock_calc.total_stock, 0) > 0');`

### A.23 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Inventory/StockAlerts.php`
- Line (v32): `63`
- Evidence: `$query->whereRaw('COALESCE(stock_calc.total_stock, 0) <= 0');`

### A.24 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `204`
- Evidence: `->selectRaw("{$dateFormat} as period")`

### A.25 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `328`
- Evidence: `->selectRaw("{$hourExpr} as hour")`

### A.26 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Warehouse/Index.php`
- Line (v32): `99`
- Evidence: `$totalValue = (clone $stockMovementQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0;`

### A.27 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Livewire/Warehouse/Movements/Index.php`
- Line (v32): `90`
- Evidence: `'total_value' => (clone $baseQuery)->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')->value('value') ?? 0,`

### A.28 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/Product.php`
- Line (v32): `283`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`

### A.29 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/Product.php`
- Line (v32): `299`
- Evidence: `return $query->whereRaw("({$stockSubquery}) <= 0");`

### A.30 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/Product.php`
- Line (v32): `315`
- Evidence: `return $query->whereRaw("({$stockSubquery}) > 0");`

### A.31 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/Project.php`
- Line (v32): `170`
- Evidence: `return $query->whereRaw('actual_cost > budget');`

### A.32 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/SearchIndex.php`
- Line (v32): `76`
- Evidence: `$builder->whereRaw(`

### A.33 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Models/SearchIndex.php`
- Line (v32): `85`
- Evidence: `$q->whereRaw('LOWER(title) LIKE ?', [$searchTerm])`

### A.34 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v32): `38`
- Evidence: `$cogs = $cogsQuery->sum(DB::raw('sale_items.quantity * COALESCE(products.cost, 0)'));`

### A.35 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/InventoryTurnoverService.php`
- Line (v32): `48`
- Evidence: `$avgInventoryValue = $inventoryQuery->sum(DB::raw('COALESCE(stock_quantity, 0) * COALESCE(cost, 0)'));`

### A.36 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v32): `145`
- Evidence: `DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}') as period"),`

### A.37 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/ProfitMarginAnalysisService.php`
- Line (v32): `152`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(sales.created_at, '{$dateFormat}')"))`

### A.38 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v32): `66`
- Evidence: `DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),`

### A.39 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Analytics/SalesForecastingService.php`
- Line (v32): `73`
- Evidence: `->groupBy(DB::raw("DATE_FORMAT(created_at, '{$dateFormat}')"))`

### A.40 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/AutomatedAlertService.php`
- Line (v32): `220`
- Evidence: `->whereRaw("({$stockSubquery}) > 0")`

### A.41 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Performance/QueryOptimizationService.php`
- Line (v32): `179`
- Evidence: `DB::statement($optimizeStatement);`

### A.42 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/PurchaseReturnService.php`
- Line (v32): `459`
- Evidence: `return $query->select('condition', DB::raw('COUNT(*) as count'), DB::raw('SUM(qty_returned) as total_qty'))`

### A.43 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/RentalService.php`
- Line (v32): `375`
- Evidence: `$stats = $query->selectRaw('`

### A.44 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v32): `27`
- Evidence: `->selectRaw("{$datediffExpr} as recency_days")`

### A.45 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v32): `158`
- Evidence: `->selectRaw("{$datediffExpr} as days_since_purchase")`

### A.46 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/Reports/SlowMovingStockService.php`
- Line (v32): `44`
- Evidence: `->havingRaw('COALESCE(days_since_sale, 999) > ?', [$days])`

### A.47 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/ScheduledReportService.php`
- Line (v32): `77`
- Evidence: `DB::raw("{$dateExpr} as date"),`

### A.48 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/ScheduledReportService.php`
- Line (v32): `95`
- Evidence: `return $query->groupBy(DB::raw($dateExpr))`

### A.49 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/ScheduledReportService.php`
- Line (v32): `127`
- Evidence: `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`

### A.50 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/ScheduledReportService.php`
- Line (v32): `231`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = ?), 0) as quantity', [$branchId]);`

### A.51 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/ScheduledReportService.php`
- Line (v32): `236`
- Evidence: `$query->selectRaw('COALESCE((SELECT SUM(quantity) FROM stock_movements sm INNER JOIN warehouses w ON sm.warehouse_id = w.id WHERE sm.product_id = products.id AND w.branch_id = products.branch_id), 0) as quantity');`

### A.52 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/SmartNotificationsService.php`
- Line (v32): `42`
- Evidence: `->selectRaw("{$stockExpr} as current_quantity")`

### A.53 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/SmartNotificationsService.php`
- Line (v32): `43`
- Evidence: `->whereRaw("{$stockExpr} <= products.min_stock")`

### A.54 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/StockReorderService.php`
- Line (v32): `40`
- Evidence: `->whereRaw("({$stockSubquery}) <= reorder_point")`

### A.55 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/StockReorderService.php`
- Line (v32): `65`
- Evidence: `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`

### A.56 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/StockReorderService.php`
- Line (v32): `66`
- Evidence: `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`

### A.57 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/StockService.php`
- Line (v32): `31`
- Evidence: `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`

### A.58 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/StockService.php`
- Line (v32): `101`
- Evidence: `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`

### A.59 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/WorkflowAutomationService.php`
- Line (v32): `27`
- Evidence: `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`

### A.60 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/WorkflowAutomationService.php`
- Line (v32): `169`
- Evidence: `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`

### A.61 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/WorkflowAutomationService.php`
- Line (v32): `170`
- Evidence: `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`

### A.62 — High — Security/SQL — Raw SQL with variable interpolation
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v32): `42`
- Evidence: `? $saleModel::selectRaw('DATE(created_at) as day, SUM(total_amount) as total')`

### A.63 — High — Security/SQL — Raw SQL with variable interpolation
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v32): `55`
- Evidence: `? $contractModel::selectRaw('status, COUNT(*) as total')`

### A.64 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Rental/Reports/Dashboard.php`
- Line (v32): `69`
- Evidence: `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`

### A.65 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `152`
- Evidence: `$avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`

### A.66 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `171`
- Evidence: `$salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`

### A.67 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `176`
- Evidence: `$completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`

### A.68 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `300`
- Evidence: `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`

### A.69 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `340`
- Evidence: `return (float) bcdiv($result, '1', BCMATH_STORAGE_SCALE);`

### A.70 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `476`
- Evidence: `'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`

### A.71 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `478`
- Evidence: `'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`

### A.72 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `479`
- Evidence: `'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`

### A.73 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Models/StockTransferItem.php`
- Line (v32): `74`
- Evidence: `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`

### A.74 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/AutomatedAlertService.php`
- Line (v32): `173`
- Evidence: `$utilization = (float) bcmul(`

### A.75 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/AutomatedAlertService.php`
- Line (v32): `183`
- Evidence: `$availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`

### A.76 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/AutomatedAlertService.php`
- Line (v32): `234`
- Evidence: `$estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`

### A.77 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/CurrencyExchangeService.php`
- Line (v32): `55`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 4);`

### A.78 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/CurrencyService.php`
- Line (v32): `128`
- Evidence: `return (float) bcmul((string) $amount, (string) $rate, 2);`

### A.79 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/HRMService.php`
- Line (v32): `235`
- Evidence: `return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`

### A.80 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/HelpdeskService.php`
- Line (v32): `293`
- Evidence: `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`

### A.81 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/LoyaltyService.php`
- Line (v32): `208`
- Evidence: `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`

### A.82 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/PricingService.php`
- Line (v32): `30`
- Evidence: `return (float) bcdiv((string) $override, '1', 4);`

### A.83 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/PricingService.php`
- Line (v32): `38`
- Evidence: `return (float) bcdiv((string) $p, '1', 4);`

### A.84 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/PricingService.php`
- Line (v32): `45`
- Evidence: `return (float) bcdiv((string) $base, '1', 4);`

### A.85 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/PurchaseService.php`
- Line (v32): `105`
- Evidence: `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`

### A.86 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/RentalService.php`
- Line (v32): `388`
- Evidence: `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`

### A.87 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/RentalService.php`
- Line (v32): `519`
- Evidence: `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`

### A.88 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/Reports/CustomerSegmentationService.php`
- Line (v32): `136`
- Evidence: `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`

### A.89 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `63`
- Evidence: `return (float) bcdiv($taxPortion, '1', 4);`

### A.90 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `69`
- Evidence: `return (float) bcdiv($taxAmount, '1', 4);`

### A.91 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `82`
- Evidence: `return (float) bcdiv((string) $base, '1', 4);`

### A.92 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `98`
- Evidence: `return (float) bcdiv($total, '1', 4);`

### A.93 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `102`
- Evidence: `defaultValue: (float) bcdiv((string) $base, '1', 4)`

### A.94 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/TaxService.php`
- Line (v32): `142`
- Evidence: `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`

### A.95 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/UIHelperService.php`
- Line (v32): `190`
- Evidence: `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`

### A.96 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `123`
- Evidence: `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`

### A.97 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `144`
- Evidence: `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`

### A.98 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `274`
- Evidence: `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`

### A.99 — Medium — Finance/Precision — BCMath result cast to float
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `412`
- Evidence: `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`

### A.100 — Medium — Logic/Files — Local disk URL generation may fail
- File: `app/Http/Controllers/Branch/ProductController.php`
- Line (v32): `156`
- Evidence: `'url' => Storage::disk('local')->url($path),`

### A.101 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- File: `app/Http/Controllers/Admin/MediaDownloadController.php`
- Line (v32): `53`
- Evidence: `$content = $disk->get($path);`

### A.102 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- File: `app/Http/Controllers/Files/UploadController.php`
- Line (v32): `41`
- Evidence: `$content = $storage->get($path);`

### A.103 — Medium — Perf/Security — Loads entire file into memory (Storage::get)
- File: `app/Services/DiagnosticsService.php`
- Line (v32): `178`
- Evidence: `$retrieved = Storage::disk($disk)->get($filename);`

### A.104 — Medium — Security/Auth — Token accepted via query/body (leak risk)
- File: `app/Http/Middleware/AuthenticateStoreToken.php`
- Line (v32): `109`
- Evidence: `return $request->query('api_token') ?? $request->input('api_token');`

---

## B) New bugs found in v32

### B.1 — High — Security/SQL — Raw SQL with variable interpolation
- File: `app/Services/QueryPerformanceService.php`
- Line (v32): `147`
- Evidence: `$explain = DB::select('EXPLAIN FORMAT=JSON '.$sql);`

### B.2 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/form/input.blade.php`
- Line (v32): `64`
- Evidence: `{!! $icon !!}`

### B.3 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/form/input.blade.php`
- Line (v32): `94`
- Evidence: `{!! $icon !!}`

### B.4 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/icon.blade.php`
- Line (v32): `37`
- Evidence: `{!! $iconPath !!}`

### B.5 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/button.blade.php`
- Line (v32): `44`
- Evidence: `{!! $icon !!}`

### B.6 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/button.blade.php`
- Line (v32): `50`
- Evidence: `{!! $icon !!}`

### B.7 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/button.blade.php`
- Line (v32): `63`
- Evidence: `{!! $icon !!}`

### B.8 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/button.blade.php`
- Line (v32): `69`
- Evidence: `{!! $icon !!}`

### B.9 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/card.blade.php`
- Line (v32): `17`
- Evidence: `{!! $icon !!}`

### B.10 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/card.blade.php`
- Line (v32): `38`
- Evidence: `{!! $actions !!}`

### B.11 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/data-table.blade.php`
- Line (v32): `183`
- Evidence: `{!! $row[$key] ?? '-' !!}`

### B.12 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/empty-state.blade.php`
- Line (v32): `23`
- Evidence: `{!! $displayIcon !!}`

### B.13 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v32): `50`
- Evidence: `{!! $icon !!}`

### B.14 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v32): `61`
- Evidence: `@if($wireModel) {!! $wireDirective !!} @endif`

### B.15 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/form/input.blade.php`
- Line (v32): `78`
- Evidence: `{!! $icon !!}`

### B.16 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/components/ui/page-header.blade.php`
- Line (v32): `45`
- Evidence: `{!! $icon !!}`

### B.17 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/livewire/auth/two-factor-setup.blade.php`
- Line (v32): `54`
- Evidence: `{!! $qrCodeSvg !!}`

### B.18 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/livewire/shared/dynamic-form.blade.php`
- Line (v32): `39`
- Evidence: `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`

### B.19 — High — Security/XSS — Unescaped Blade output (XSS risk)
- File: `resources/views/livewire/shared/dynamic-table.blade.php`
- Line (v32): `260`
- Evidence: `{!! sanitize_svg_icon($actionIcon) !!}`

### B.20 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v32): `249`
- Evidence: `$inflows = (float) (clone $query)->where('type', 'deposit')->sum('amount');`

### B.21 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Admin/ReportsController.php`
- Line (v32): `252`
- Evidence: `$outflows = (float) (clone $query)->where('type', 'withdrawal')->sum('amount');`

### B.22 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v32): `205`
- Evidence: `$lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`

### B.23 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v32): `206`
- Evidence: `$lineDiscount = max(0, (float) ($item['discount'] ?? 0));`

### B.24 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v32): `223`
- Evidence: `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`

### B.25 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/OrdersController.php`
- Line (v32): `225`
- Evidence: `$tax = max(0, (float) ($validated['tax'] ?? 0));`

### B.26 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Api/V1/ProductsController.php`
- Line (v32): `77`
- Evidence: `'price' => (float) $product->default_price,`

### B.27 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/PurchaseController.php`
- Line (v32): `103`
- Evidence: `return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`

### B.28 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v32): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### B.29 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v32): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### B.30 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v32): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### B.31 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v32): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### B.32 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- Line (v32): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### B.33 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- Line (v32): `51`
- Evidence: `(float) $data['amount'],`

### B.34 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v32): `159`
- Evidence: `'total_amount' => (float) $rowData['total'],`

### B.35 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v32): `160`
- Evidence: `'subtotal' => (float) ($rowData['subtotal'] ?? $rowData['total']),`

### B.36 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v32): `161`
- Evidence: `'tax_amount' => (float) ($rowData['tax'] ?? 0),`

### B.37 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v32): `162`
- Evidence: `'discount_amount' => (float) ($rowData['discount'] ?? 0),`

### B.38 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- Line (v32): `163`
- Evidence: `'paid_amount' => (float) ($rowData['paid'] ?? 0),`

### B.39 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v32): `43`
- Evidence: `$disc = (float) ($row['discount'] ?? 0);`

### B.40 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v32): `80`
- Evidence: `return (float) (config('erp.discount.max_line', 15)); // sensible default`

### B.41 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Middleware/EnforceDiscountLimit.php`
- Line (v32): `89`
- Evidence: `return (float) (config('erp.discount.max_invoice', 20));`

### B.42 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/CustomerResource.php`
- Line (v32): `38`
- Evidence: `(float) ($this->balance ?? 0.0)`

### B.43 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v32): `20`
- Evidence: `'discount' => (float) $this->discount,`

### B.44 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v32): `21`
- Evidence: `'tax' => (float) ($this->tax ?? 0),`

### B.45 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderItemResource.php`
- Line (v32): `22`
- Evidence: `'total' => (float) $this->line_total,`

### B.46 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v32): `24`
- Evidence: `'discount' => (float) $this->discount,`

### B.47 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v32): `25`
- Evidence: `'tax' => (float) $this->tax,`

### B.48 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/OrderResource.php`
- Line (v32): `26`
- Evidence: `'total' => (float) $this->grand_total,`

### B.49 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/ProductResource.php`
- Line (v32): `47`
- Evidence: `'price' => (float) $this->default_price,`

### B.50 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Http/Resources/ProductResource.php`
- Line (v32): `48`
- Evidence: `'cost' => $this->when(self::$canViewCost, (float) $this->cost),`

### B.51 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Jobs/ClosePosDayJob.php`
- Line (v32): `72`
- Evidence: `$paid = (float) $paidString;`

### B.52 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Listeners/ApplyLateFee.php`
- Line (v32): `43`
- Evidence: `$invoice->amount = (float) $newAmount;`

### B.53 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Accounting/JournalEntries/Form.php`
- Line (v32): `144`
- Evidence: `'amount' => number_format((float) ltrim($difference, '-'), 2),`

### B.54 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v32): `67`
- Evidence: `$totalRevenue = (float) $ordersForStats->sum('total');`

### B.55 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v32): `84`
- Evidence: `$sources[$source]['revenue'] += (float) $order->total;`

### B.56 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Admin/Store/OrdersDashboard.php`
- Line (v32): `139`
- Evidence: `$dayValues[] = (float) $items->sum('total');`

### B.57 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Banking/Reconciliation.php`
- Line (v32): `304`
- Evidence: `'amount' => number_format((float) $this->difference, 2),`

### B.58 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Income/Form.php`
- Line (v32): `102`
- Evidence: `$this->amount = (float) $income->amount;`

### B.59 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v32): `132`
- Evidence: `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`

### B.60 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Inventory/Products/Form.php`
- Line (v32): `133`
- Evidence: `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`

### B.61 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Inventory/Services/Form.php`
- Line (v32): `137`
- Evidence: `$this->cost = (float) ($product->cost ?: $product->standard_cost);`

### B.62 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v32): `173`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### B.63 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v32): `239`
- Evidence: `'unit_cost' => (float) ($product->cost ?? 0),`

### B.64 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Purchases/Form.php`
- Line (v32): `357`
- Evidence: `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`

### B.65 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Purchases/Returns/Index.php`
- Line (v32): `104`
- Evidence: `'cost' => (float) $item->unit_cost,`

### B.66 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Reports/SalesAnalytics.php`
- Line (v32): `319`
- Evidence: `'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### B.67 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `195`
- Evidence: `'discount' => (float) ($item->discount ?? 0),`

### B.68 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Sales/Form.php`
- Line (v32): `202`
- Evidence: `$this->payment_amount = (float) ($firstPayment->amount ?? 0);`

### B.69 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Livewire/Sales/Returns/Index.php`
- Line (v32): `116`
- Evidence: `'price' => (float) $item->unit_price,`

### B.70 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Models/BankTransaction.php`
- Line (v32): `107`
- Evidence: `$amount = (float) $this->amount;`

### B.71 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v32): `61`
- Evidence: `$newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`

### B.72 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Models/InstallmentPayment.php`
- Line (v32): `62`
- Evidence: `$newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`

### B.73 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Observers/ProductObserver.php`
- Line (v32): `31`
- Evidence: `$product->cost = round((float) $product->cost, 2);`

### B.74 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Observers/ProductObserver.php`
- Line (v32): `54`
- Evidence: `$product->cost = round((float) $product->cost, 2);`

### B.75 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Rules/ValidDiscountPercentage.php`
- Line (v32): `29`
- Evidence: `$discount = (float) $value;`

### B.76 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Rules/ValidPriceOverride.php`
- Line (v32): `25`
- Evidence: `$price = (float) $value;`

### B.77 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/DataValidationService.php`
- Line (v32): `115`
- Evidence: `$amount = (float) $amount;`

### B.78 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v32): `93`
- Evidence: `return (float) config('pos.discount.max_amount', 1000);`

### B.79 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v32): `103`
- Evidence: `: (float) config('pos.discount.max_amount', 1000);`

### B.80 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/DiscountService.php`
- Line (v32): `157`
- Evidence: `$value = (float) ($discount['value'] ?? 0);`

### B.81 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v32): `148`
- Evidence: `'total' => (float) bcround((string) $totalRevenue, 2),`

### B.82 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v32): `153`
- Evidence: `'total' => (float) bcround((string) $totalExpenses, 2),`

### B.83 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v32): `253`
- Evidence: `'total' => (float) bcround((string) $totalAssets, 2),`

### B.84 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v32): `258`
- Evidence: `'total' => (float) bcround((string) $totalLiabilities, 2),`

### B.85 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/FinancialReportService.php`
- Line (v32): `263`
- Evidence: `'total' => (float) bcround((string) $totalEquity, 2),`

### B.86 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ImportService.php`
- Line (v32): `568`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### B.87 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/InstallmentService.php`
- Line (v32): `103`
- Evidence: `'amount_due' => max(0, (float) $amount),`

### B.88 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `128`
- Evidence: `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`

### B.89 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `145`
- Evidence: `if ($user && ! $user->can_modify_price && abs($price - (float) ($product->default_price ?? 0)) > 0.001) {`

### B.90 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `149`
- Evidence: `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`

### B.91 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `153`
- Evidence: `$itemDiscountPercent = (float) ($it['discount'] ?? 0);`

### B.92 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `232`
- Evidence: `$amount = (float) ($payment['amount'] ?? 0);`

### B.93 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `259`
- Evidence: `'amount' => (float) bcround($grandTotal, 2),`

### B.94 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/POSService.php`
- Line (v32): `486`
- Evidence: `'paid' => (float) $paidAmountString,`

### B.95 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v32): `112`
- Evidence: `'total' => (float) $total,`

### B.96 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PayslipService.php`
- Line (v32): `171`
- Evidence: `'total' => (float) $total,`

### B.97 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v32): `58`
- Evidence: `$price = max(0.0, (float) Arr::get($line, 'price', 0));`

### B.98 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v32): `60`
- Evidence: `$discVal = (float) Arr::get($line, 'discount', 0);`

### B.99 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v32): `85`
- Evidence: `'discount' => (float) bcround((string) $discount, 2),`

### B.100 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v32): `86`
- Evidence: `'tax' => (float) bcround((string) $taxAmount, 2),`

### B.101 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PricingService.php`
- Line (v32): `87`
- Evidence: `'total' => (float) bcround((string) $total, 2),`

### B.102 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ProductService.php`
- Line (v32): `113`
- Evidence: `$product->default_price = (float) $price;`

### B.103 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ProductService.php`
- Line (v32): `118`
- Evidence: `$product->cost = (float) $cost;`

### B.104 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v32): `79`
- Evidence: `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`

### B.105 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/PurchaseService.php`
- Line (v32): `283`
- Evidence: `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`

### B.106 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/RentalService.php`
- Line (v32): `270`
- Evidence: `$i->amount = (float) $newAmount;`

### B.107 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v32): `53`
- Evidence: `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`

### B.108 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v32): `54`
- Evidence: `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`

### B.109 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/ReportService.php`
- Line (v32): `55`
- Evidence: `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`

### B.110 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v32): `41`
- Evidence: `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`

### B.111 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Reports/CashFlowForecastService.php`
- Line (v32): `42`
- Evidence: `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`

### B.112 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/SaleService.php`
- Line (v32): `222`
- Evidence: `'amount' => (float) $refund,`

### B.113 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/SalesReturnService.php`
- Line (v32): `209`
- Evidence: `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`

### B.114 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v32): `164`
- Evidence: `$price = (float) Arr::get($item, 'price', 0);`

### B.115 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v32): `165`
- Evidence: `$discount = (float) Arr::get($item, 'discount', 0);`

### B.116 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v32): `255`
- Evidence: `$total = (float) ($order->total ?? 0);`

### B.117 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v32): `256`
- Evidence: `$tax = (float) ($order->tax_total ?? 0);`

### B.118 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreOrderToSaleService.php`
- Line (v32): `258`
- Evidence: `$discount = (float) ($order->discount_total ?? 0);`

### B.119 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `320`
- Evidence: `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`

### B.120 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `458`
- Evidence: `'unit_price' => (float) ($lineItem['price'] ?? 0),`

### B.121 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `461`
- Evidence: `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`

### B.122 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `488`
- Evidence: `'default_price' => (float) ($data['price'] ?? 0),`

### B.123 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `581`
- Evidence: `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`

### B.124 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `584`
- Evidence: `'total_amount' => (float) ($data['total'] ?? 0),`

### B.125 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `629`
- Evidence: `'unit_price' => (float) ($lineItem['price'] ?? 0),`

### B.126 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `632`
- Evidence: `'line_total' => (float) ($lineItem['total'] ?? 0),`

### B.127 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `756`
- Evidence: `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`

### B.128 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `757`
- Evidence: `'cost' => (float) ($data['cost'] ?? 0),`

### B.129 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `827`
- Evidence: `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`

### B.130 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `828`
- Evidence: `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`

### B.131 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `829`
- Evidence: `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`

### B.132 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `857`
- Evidence: `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`

### B.133 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `858`
- Evidence: `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`

### B.134 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `859`
- Evidence: `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`

### B.135 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/Store/StoreSyncService.php`
- Line (v32): `992`
- Evidence: `return (float) ($product->standard_cost ?? $product->cost ?? 0);`

### B.136 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v32): `23`
- Evidence: `return (float) ($tax?->rate ?? 0.0);`

### B.137 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/TaxService.php`
- Line (v32): `51`
- Evidence: `$rate = (float) $tax->rate;`

### B.138 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `97`
- Evidence: `$cost = (float) ($product->standard_cost ?? 0);`

### B.139 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `121`
- Evidence: `'price' => (float) $price,`

### B.140 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `197`
- Evidence: `'price' => (float) $item->default_price,`

### B.141 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/UX/SmartSuggestionsService.php`
- Line (v32): `245`
- Evidence: `'price' => (float) $product->default_price,`

### B.142 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v32): `114`
- Evidence: `'tax' => number_format((float) $sale->tax_total, 2),`

### B.143 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v32): `115`
- Evidence: `'discount' => number_format((float) $sale->discount_total, 2),`

### B.144 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/Services/WhatsAppService.php`
- Line (v32): `116`
- Evidence: `'total' => number_format((float) $sale->grand_total, 2),`

### B.145 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/ValueObjects/Money.php`
- Line (v32): `73`
- Evidence: `return number_format((float) $this->amount, $decimals).' '.$this->currency;`

### B.146 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `app/ValueObjects/Money.php`
- Line (v32): `81`
- Evidence: `return (float) $this->amount;`

### B.147 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `resources/views/livewire/admin/dashboard.blade.php`
- Line (v32): `51`
- Evidence: `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`

### B.148 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v32): `62`
- Evidence: `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`

### B.149 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `resources/views/livewire/purchases/returns/index.blade.php`
- Line (v32): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`

### B.150 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v32): `62`
- Evidence: `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`

### B.151 — Medium — Finance/Precision — Money/amount cast to float (rounding drift risk)
- File: `resources/views/livewire/sales/returns/index.blade.php`
- Line (v32): `120`
- Evidence: `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
