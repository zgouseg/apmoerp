# APMO ERP v38 — Old (Unsolved) + New Bugs

## Summary

- **Compared versions:** `v37` → `v38`
- **Laravel:** `^12.0`
- **Livewire:** `^4.0.1`
- **Baseline bugs (from v37 report):** `247`
- **Old bugs fixed in v38:** `38`
- **Old bugs still present:** `277`
- **New bugs detected in v38:** `252`

### Notes
- Static heuristic scan (no runtime tests).
- `database/` ignored as requested.

---

## Old bugs not solved yet

### 1. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Console/Commands/CheckDatabaseIntegrity.php`
- **Line:** `264`
- **Evidence:** `$query->whereRaw($where);`
- **Why it matters:** If the expression is influenced by request params (period/grouping/order), enforce a strict whitelist and never pass user input directly.

### 2. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `100`
- **Evidence:** `->selectRaw($stockExpr.' as current_stock');`
- **Why it matters:** If the expression is influenced by request params (period/grouping/order), enforce a strict whitelist and never pass user input directly.

### 3. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `167`
- **Evidence:** `$queryToken = $request->query('api_token');`
- **Why it matters:** Tokens in query strings leak via logs/referrers/history. Prefer Authorization: Bearer header, signed URLs, or cookies (as appropriate).

### 4. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `173`
- **Evidence:** `$bodyToken = $request->input('api_token');`
- **Why it matters:** Tokens in query strings leak via logs/referrers/history. Prefer Authorization: Bearer header, signed URLs, or cookies (as appropriate).

### 5. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `170`
- **Evidence:** `->whereRaw("{$stockExpr} <= min_stock")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 6. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `318`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 7. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `320`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 8. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `323`
- **Evidence:** `->orderByRaw($stockExpr)`
- **Why it matters:** If the expression is influenced by request params (period/grouping/order), enforce a strict whitelist and never pass user input directly.

### 9. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `245`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 10. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `407`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 11. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `308`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 12. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `328`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) <= 0");`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 13. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `348`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) > 0");`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 14. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `225`
- **Evidence:** `->whereRaw("({$stockSubquery}) > 0")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 15. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `46`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 16. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `177`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 17. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `52`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 18. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `149`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 19. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `149`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 20. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `58`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 21. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `59`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 22. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `56`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= reorder_point")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 23. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `81`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 24. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `82`
- **Evidence:** `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 25. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `46`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 26. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `188`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 27. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `189`
- **Evidence:** `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`
- **Why it matters:** Prefer parameter bindings (? + bindings array) or strict whitelists for identifiers/date parts; never interpolate request-derived input into raw SQL.

### 28. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `286`
- **Evidence:** `'inflows' => (float) $inflows,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 29. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `287`
- **Evidence:** `'outflows' => (float) $outflows,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 30. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `288`
- **Evidence:** `'net_cashflow' => (float) $netCashflow,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 31. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `146`
- **Evidence:** `$qty = (float) $row['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 32. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `250`
- **Evidence:** `$qty = (float) $item['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 33. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `129`
- **Evidence:** `$newQuantity = (float) $validated['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 34. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `145`
- **Evidence:** `$actualQty = abs((float) $validated['qty']);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 35. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `240`
- **Evidence:** `$newQuantity = (float) $item['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 36. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `246`
- **Evidence:** `$actualQty = abs((float) $item['qty']);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 37. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `205`
- **Evidence:** `$lineSubtotal = (float) $item['price'] * (float) $item['quantity'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 38. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** `77`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 39. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** `203`
- **Evidence:** `$quantity = (float) $validated['quantity'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 40. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** `309`
- **Evidence:** `$newQuantity = (float) $validated['quantity'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 41. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/PurchaseController.php`
- **Line:** `103`
- **Evidence:** `return $this->ok($this->purchases->pay($purchase, (float) $data['amount']), __('Paid'));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 42. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/Purchases/ExportImportController.php`
- **Line:** `159`
- **Evidence:** `'total_amount' => (float) $rowData['total'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 43. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- **Line:** `51`
- **Evidence:** `(float) $data['amount'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 44. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/Sales/ExportImportController.php`
- **Line:** `159`
- **Evidence:** `'total_amount' => (float) $rowData['total'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 45. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/StockController.php`
- **Line:** `68`
- **Evidence:** `$m = $this->inv->adjust($product->id, (float) $data['qty'], $warehouseId, $data['note'] ?? null);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 46. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/StockController.php`
- **Line:** `92`
- **Evidence:** `$res = $this->inv->transfer($product->id, (float) $data['qty'], $data['from_warehouse'], $data['to_warehouse']);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 47. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Middleware/EnforceDiscountLimit.php`
- **Line:** `76`
- **Evidence:** `return (float) $user->max_line_discount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 48. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Middleware/EnforceDiscountLimit.php`
- **Line:** `86`
- **Evidence:** `return (float) $user->max_invoice_discount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 49. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderItemResource.php`
- **Line:** `19`
- **Evidence:** `'unit_price' => (float) $this->unit_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 50. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderItemResource.php`
- **Line:** `20`
- **Evidence:** `'discount' => (float) $this->discount,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 51. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderItemResource.php`
- **Line:** `22`
- **Evidence:** `'total' => (float) $this->line_total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 52. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderItemResource.php`
- **Line:** `22`
- **Evidence:** `'total' => (float) $this->line_total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 53. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderResource.php`
- **Line:** `24`
- **Evidence:** `'discount' => (float) $this->discount,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 54. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderResource.php`
- **Line:** `25`
- **Evidence:** `'tax' => (float) $this->tax,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 55. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderResource.php`
- **Line:** `26`
- **Evidence:** `'total' => (float) $this->grand_total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 56. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `47`
- **Evidence:** `'price' => (float) $this->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 57. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `48`
- **Evidence:** `'cost' => $this->when(self::$canViewCost, (float) $this->cost),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 58. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `73`
- **Evidence:** `$paid = (float) $paidString;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 59. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/ApplyLateFee.php`
- **Line:** `43`
- **Evidence:** `$invoice->amount = (float) $newAmount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 60. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/UpdateStockOnPurchase.php`
- **Line:** `27`
- **Evidence:** `$itemQty = (float) $item->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 61. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/UpdateStockOnSale.php`
- **Line:** `49`
- **Evidence:** `$baseQuantity = (float) $item->quantity * (float) $conversionFactor;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 62. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Accounting/JournalEntries/Form.php`
- **Line:** `144`
- **Evidence:** `'amount' => number_format((float) ltrim($difference, '-'), 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 63. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/CurrencyRate/Form.php`
- **Line:** `51`
- **Evidence:** `$this->rate = (float) $rate->rate;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 64. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `67`
- **Evidence:** `$totalRevenue = (float) $ordersForStats->sum('total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 65. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `84`
- **Evidence:** `$sources[$source]['revenue'] += (float) $order->total;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 66. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `139`
- **Evidence:** `$dayValues[] = (float) $items->sum('total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 67. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Banking/Reconciliation.php`
- **Line:** `304`
- **Evidence:** `'amount' => number_format((float) $this->difference, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 68. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Income/Form.php`
- **Line:** `102`
- **Evidence:** `$this->amount = (float) $income->amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 69. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `143`
- **Evidence:** `$this->form['max_stock'] = $p->max_stock ? (float) $p->max_stock : null;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 70. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `145`
- **Evidence:** `$this->form['lead_time_days'] = $p->lead_time_days ? (float) $p->lead_time_days : null;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 71. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `136`
- **Evidence:** `$this->defaultPrice = (float) $product->default_price;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 72. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `234`
- **Evidence:** `$this->defaultPrice = (float) bcround($calculated, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 73. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- **Line:** `70`
- **Evidence:** `$this->quantity = (float) $this->bom->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 74. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `171`
- **Evidence:** `'qty' => (float) $item->qty,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 75. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `172`
- **Evidence:** `'unit_cost' => (float) $item->unit_cost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 76. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `102`
- **Evidence:** `'max_qty' => (float) $item->qty,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 77. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `104`
- **Evidence:** `'cost' => (float) $item->unit_cost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 78. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `160`
- **Evidence:** `$qty = min((float) $it['qty'], (float) $pi->qty);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 79. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Reports/Dashboard.php`
- **Line:** `69`
- **Evidence:** `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 80. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `381`
- **Evidence:** `'totals' => $results->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 81. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `193`
- **Evidence:** `'qty' => (float) $item->qty,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 82. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `194`
- **Evidence:** `'unit_price' => (float) $item->unit_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 83. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `300`
- **Evidence:** `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 84. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `300`
- **Evidence:** `return (float) bcdiv($total, '1', BCMATH_STORAGE_SCALE);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 85. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `340`
- **Evidence:** `return (float) bcdiv($result, '1', BCMATH_STORAGE_SCALE);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 86. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `456`
- **Evidence:** `$validatedPrice = (float) $item['unit_price'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 87. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `476`
- **Evidence:** `'discount_amount' => (float) bcdiv($discountAmount, '1', BCMATH_STORAGE_SCALE),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 88. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `478`
- **Evidence:** `'tax_amount' => (float) bcdiv($taxAmount, '1', BCMATH_STORAGE_SCALE),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 89. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Form.php`
- **Line:** `479`
- **Evidence:** `'line_total' => (float) bcdiv($lineTotal, '1', BCMATH_STORAGE_SCALE),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 90. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Returns/Index.php`
- **Line:** `114`
- **Evidence:** `'max_qty' => (float) $item->qty,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 91. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Returns/Index.php`
- **Line:** `116`
- **Evidence:** `'price' => (float) $item->unit_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 92. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Sales/Returns/Index.php`
- **Line:** `153`
- **Evidence:** `'qty' => min((float) $item['qty'], (float) $item['max_qty']),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 93. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Warehouse/Adjustments/Form.php`
- **Line:** `160`
- **Evidence:** `'qty' => abs((float) $item['qty']),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 94. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Warehouse/Adjustments/Form.php`
- **Line:** `161`
- **Evidence:** `'direction' => (float) $item['qty'] >= 0 ? 'in' : 'out',`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 95. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Warehouse/Transfers/Index.php`
- **Line:** `91`
- **Evidence:** `$qty = (float) $item->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 96. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BankTransaction.php`
- **Line:** `107`
- **Evidence:** `$amount = (float) $this->amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 97. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `123`
- **Evidence:** `$itemQuantity = (float) $item->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 98. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomItem.php`
- **Line:** `69`
- **Evidence:** `$baseQuantity = (float) $this->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 99. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/CurrencyRate.php`
- **Line:** `91`
- **Evidence:** `$rateValue = (float) $rate->rate;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 100. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPayment.php`
- **Line:** `61`
- **Evidence:** `$newAmountPaid = min($amountPaid + $amount, (float) $this->amount_due);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 101. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPayment.php`
- **Line:** `62`
- **Evidence:** `$newStatus = $newAmountPaid >= (float) $this->amount_due ? 'paid' : 'partial';`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 102. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `31`
- **Evidence:** `$product->cost = round((float) $product->cost, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 103. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `75`
- **Evidence:** `$out = (float) abs((clone $baseQuery)->where('quantity', '<', 0)->sum('quantity'));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 104. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `75`
- **Evidence:** `$out = (float) abs((clone $baseQuery)->where('quantity', '<', 0)->sum('quantity'));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 105. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `91`
- **Evidence:** `return (float) $baseQuery->sum('quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 106. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `91`
- **Evidence:** `return (float) $baseQuery->sum('quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 107. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `103`
- **Evidence:** `return (float) $group->sum('quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 108. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `103`
- **Evidence:** `return (float) $group->sum('quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 109. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `190`
- **Evidence:** `$currentStock = (float) StockMovement::where('product_id', $data['product_id'])`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 110. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `226`
- **Evidence:** `$totalStock = (float) StockMovement::where('product_id', $productId)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 111. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Rules/ValidDiscountPercentage.php`
- **Line:** `29`
- **Evidence:** `$discount = (float) $value;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 112. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Rules/ValidPriceOverride.php`
- **Line:** `25`
- **Evidence:** `$price = (float) $value;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 113. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Rules/ValidStockQuantity.php`
- **Line:** `29`
- **Evidence:** `$quantity = (float) $value;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 114. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `188`
- **Evidence:** `$availableCredit = (float) bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 115. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `157`
- **Evidence:** `'quantity' => (float) $batchQty,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 116. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `246`
- **Evidence:** `$batch->quantity = (float) $combinedQty;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 117. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CurrencyExchangeService.php`
- **Line:** `55`
- **Evidence:** `return (float) bcmul((string) $amount, (string) $rate, 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 118. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CurrencyExchangeService.php`
- **Line:** `95`
- **Evidence:** `return $rate ? (float) $rate->rate : null;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 119. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CurrencyExchangeService.php`
- **Line:** `238`
- **Evidence:** `'rate' => (float) $r->rate,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 120. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CurrencyService.php`
- **Line:** `128`
- **Evidence:** `return (float) bcmul((string) $amount, (string) $rate, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 121. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DataValidationService.php`
- **Line:** `115`
- **Evidence:** `$amount = (float) $amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 122. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `73`
- **Evidence:** `return (float) bcround($discTotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 123. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `88`
- **Evidence:** `return (float) config('sales.max_line_discount_percent',`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 124. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `93`
- **Evidence:** `return (float) config('pos.discount.max_amount', 1000);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 125. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `102`
- **Evidence:** `? (float) config('sales.max_invoice_discount_percent', 30)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 126. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `103`
- **Evidence:** `: (float) config('pos.discount.max_amount', 1000);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 127. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DiscountService.php`
- **Line:** `179`
- **Evidence:** `$maxDiscountPercent = (float) config('sales.max_combined_discount_percent', 80);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 128. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `148`
- **Evidence:** `'total' => (float) bcround((string) $totalRevenue, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 129. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `153`
- **Evidence:** `'total' => (float) bcround((string) $totalExpenses, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 130. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `253`
- **Evidence:** `'total' => (float) bcround((string) $totalAssets, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 131. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `258`
- **Evidence:** `'total' => (float) bcround((string) $totalLiabilities, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 132. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `263`
- **Evidence:** `'total' => (float) bcround((string) $totalEquity, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 133. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InstallmentService.php`
- **Line:** `103`
- **Evidence:** `'amount_due' => max(0, (float) $amount),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 134. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InventoryService.php`
- **Line:** `114`
- **Evidence:** `$qty = (float) $data['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 135. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InventoryService.php`
- **Line:** `159`
- **Evidence:** `return (float) $query->sum('quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 136. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `104`
- **Evidence:** `$previousDailyDiscount = (float) Sale::where('created_by', $user->id)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 137. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `135`
- **Evidence:** `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 138. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `135`
- **Evidence:** `$price = isset($it['price']) ? (float) $it['price'] : (float) ($product->default_price ?? 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 139. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `156`
- **Evidence:** `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 140. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `156`
- **Evidence:** `(new ValidPriceOverride((float) $product->cost, 0.0))->validate('price', $price, function ($m) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 141. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `163`
- **Evidence:** `$systemMaxDiscount = (float) setting('pos.max_discount_percent', 100);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 142. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `221`
- **Evidence:** `'line_total' => (float) bcround($lineTotal, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 143. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `229`
- **Evidence:** `$sale->subtotal = (float) bcround((string) $subtotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 144. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `230`
- **Evidence:** `$sale->discount_amount = (float) bcround((string) $discountTotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 145. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `231`
- **Evidence:** `$sale->tax_amount = (float) bcround((string) $taxTotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 146. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `232`
- **Evidence:** `$sale->total_amount = (float) bcround($grandTotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 147. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `266`
- **Evidence:** `'amount' => (float) bcround($grandTotal, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 148. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `266`
- **Evidence:** `'amount' => (float) bcround($grandTotal, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 149. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `275`
- **Evidence:** `$sale->paid_amount = (float) bcround($paidTotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 150. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `353`
- **Evidence:** `$totalSales = (float) $salesQuery->sum('total_amount');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 151. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `496`
- **Evidence:** `'gross' => (float) $totalAmountString,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 152. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `497`
- **Evidence:** `'paid' => (float) $paidAmountString,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 153. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `497`
- **Evidence:** `'paid' => (float) $paidAmountString,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 154. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `509`
- **Evidence:** `'total_amount' => (float) $totalAmountString,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 155. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/POSService.php`
- **Line:** `510`
- **Evidence:** `'paid_amount' => (float) $paidAmountString,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 156. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `75`
- **Evidence:** `$transportValue = (float) setting('hrm.transport_allowance_value', 10);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 157. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `83`
- **Evidence:** `$allowances['transport'] = (float) $transportAmount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 158. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `89`
- **Evidence:** `$housingValue = (float) setting('hrm.housing_allowance_value', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 159. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `97`
- **Evidence:** `$allowances['housing'] = (float) $housingAmount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 160. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `102`
- **Evidence:** `$mealAllowance = (float) setting('hrm.meal_allowance', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 161. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `106`
- **Evidence:** `$allowances['meal'] = (float) $mealAllowanceStr;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 162. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `112`
- **Evidence:** `'total' => (float) $total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 163. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `131`
- **Evidence:** `$deductions['social_insurance'] = (float) $socialInsurance;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 164. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `161`
- **Evidence:** `$healthInsurance = (float) setting('hrm.health_insurance_deduction', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 165. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `165`
- **Evidence:** `$deductions['health_insurance'] = (float) $healthInsuranceStr;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 166. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `227`
- **Evidence:** `'basic' => (float) bcround((string) $basic, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 167. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `228`
- **Evidence:** `'allowances' => (float) bcround((string) $allowances, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 168. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `230`
- **Evidence:** `'deductions' => (float) bcround((string) $deductions, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 169. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `232`
- **Evidence:** `'gross' => (float) bcround((string) $gross, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 170. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `233`
- **Evidence:** `'net' => (float) $net,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 171. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `259`
- **Evidence:** `$currentSalary = (float) $employee->salary;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 172. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `285`
- **Evidence:** `$salaryAtPeriodStart = (float) $salaryChanges[0]['old_salary'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 173. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `301`
- **Evidence:** `$newSalary = (float) $change['new_salary'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 174. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `328`
- **Evidence:** `return (float) bcround($proRataSalary, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 175. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `367`
- **Evidence:** `'old_salary' => (float) $old['basic_salary'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 176. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PayslipService.php`
- **Line:** `368`
- **Evidence:** `'new_salary' => (float) $attributes['basic_salary'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 177. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `57`
- **Evidence:** `$qty = max(0.0, (float) Arr::get($line, 'qty', 1));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 178. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `58`
- **Evidence:** `$price = max(0.0, (float) Arr::get($line, 'price', 0));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 179. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `60`
- **Evidence:** `$discVal = (float) Arr::get($line, 'discount', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 180. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `85`
- **Evidence:** `'discount' => (float) bcround((string) $discount, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 181. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `86`
- **Evidence:** `'tax' => (float) bcround((string) $taxAmount, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 182. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `87`
- **Evidence:** `'total' => (float) bcround((string) $total, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 183. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `113`
- **Evidence:** `$product->default_price = (float) $price;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 184. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `118`
- **Evidence:** `$product->cost = (float) $cost;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 185. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `104`
- **Evidence:** `$purchaseQty = (float) $purchaseItem->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 186. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `322`
- **Evidence:** `'qty' => (float) $item->qty_returned,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 187. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `77`
- **Evidence:** `$qty = (float) $it['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 188. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `105`
- **Evidence:** `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 189. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `129`
- **Evidence:** `'line_total' => (float) $lineTotal,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 190. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `138`
- **Evidence:** `$p->subtotal = (float) bcround($subtotal, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 191. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `139`
- **Evidence:** `$p->tax_amount = (float) bcround($totalTax, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 192. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `140`
- **Evidence:** `$p->discount_amount = (float) bcround($totalDiscount, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 193. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `142`
- **Evidence:** `$p->total_amount = (float) bcround(`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 194. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `221`
- **Evidence:** `$remainingDue = max(0, (float) $p->total_amount - (float) $p->paid_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 195. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `254`
- **Evidence:** `$p->paid_amount = (float) $newPaidAmount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 196. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `257`
- **Evidence:** `if ((float) $p->paid_amount >= (float) $p->total_amount) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 197. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `259`
- **Evidence:** `} elseif ((float) $p->paid_amount > 0) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 198. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `284`
- **Evidence:** `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 199. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `284`
- **Evidence:** `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 200. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `271`
- **Evidence:** `$i->amount = (float) $newAmount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 201. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `90`
- **Evidence:** `return $rows->map(fn ($r) => ['id' => $r->id, 'name' => $r->name, 'gross' => (float) $r->gross])->all();`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 202. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `41`
- **Evidence:** `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 203. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `42`
- **Evidence:** `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 204. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `138`
- **Evidence:** `'inflows' => (float) $dailyInflowsStr,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 205. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `139`
- **Evidence:** `'outflows' => (float) $dailyOutflowsStr,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 206. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `104`
- **Evidence:** `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 207. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `104`
- **Evidence:** `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 208. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `173`
- **Evidence:** `'total_amount' => (float) $refund,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 209. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `234`
- **Evidence:** `'amount' => (float) $refund,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 210. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `234`
- **Evidence:** `'amount' => (float) $refund,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 211. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `297`
- **Evidence:** `$returned[$itemId] = abs((float) $returnedQty);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 212. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `317`
- **Evidence:** `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 213. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `317`
- **Evidence:** `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 214. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `322`
- **Evidence:** `$soldQty = (float) $saleItem->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 215. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `322`
- **Evidence:** `$soldQty = (float) $saleItem->quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 216. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `218`
- **Evidence:** `$remainingRefundable = (float) $return->refund_amount - (float) $alreadyRefunded;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 217. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `61`
- **Evidence:** `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 218. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `167`
- **Evidence:** `return (float) DB::table('stock_movements')`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 219. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `322`
- **Evidence:** `$stockBefore = (float) DB::table('stock_movements')`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 220. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `381`
- **Evidence:** `$totalStock = (float) StockMovement::where('product_id', $productId)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 221. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `236`
- **Evidence:** `$itemQuantities[(int) $itemId] = (float) $itemData['qty_shipped'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 222. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `158`
- **Evidence:** `$qty = (float) Arr::get($item, 'qty', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 223. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `164`
- **Evidence:** `$price = (float) Arr::get($item, 'price', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 224. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `165`
- **Evidence:** `$discount = (float) Arr::get($item, 'discount', 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 225. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `35`
- **Evidence:** `return (float) bcround($taxAmount, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 226. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `51`
- **Evidence:** `$rate = (float) $tax->rate;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 227. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `51`
- **Evidence:** `$rate = (float) $tax->rate;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 228. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `63`
- **Evidence:** `return (float) bcdiv($taxPortion, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 229. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `69`
- **Evidence:** `return (float) bcdiv($taxAmount, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 230. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `82`
- **Evidence:** `return (float) bcdiv((string) $base, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 231. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `98`
- **Evidence:** `return (float) bcdiv($total, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 232. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `98`
- **Evidence:** `return (float) bcdiv($total, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 233. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `102`
- **Evidence:** `defaultValue: (float) bcdiv((string) $base, '1', 4)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 234. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `142`
- **Evidence:** `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 235. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `151`
- **Evidence:** `'total_tax' => (float) bcround($totalTax, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 236. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `61`
- **Evidence:** `$suggestedQty = max((float) $eoq, (float) $product->minimum_order_quantity ?? 1);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 237. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `69`
- **Evidence:** `$urgency = $this->determineReorderUrgency((float) $currentStock, (float) $reorderPoint, (float) $product->min_stock ?? 0);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 238. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `76`
- **Evidence:** `'reorder_point' => (float) $reorderPoint,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 239. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `78`
- **Evidence:** `'sales_velocity' => (float) $salesVelocity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 240. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `79`
- **Evidence:** `'days_of_stock_remaining' => (float) $daysOfStock,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 241. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `83`
- **Evidence:** `'recommendation' => $this->generateReorderRecommendation($urgency, (float) $daysOfStock, $suggestedQty),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 242. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `121`
- **Evidence:** `'price' => (float) $price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 243. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `121`
- **Evidence:** `'price' => (float) $price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 244. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `123`
- **Evidence:** `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 245. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `123`
- **Evidence:** `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 246. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `141`
- **Evidence:** `'current_margin' => (float) $currentMargin.'%',`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 247. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `142`
- **Evidence:** `'suggested_price' => (float) $suggestedPrice,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 248. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `144`
- **Evidence:** `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 249. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `144`
- **Evidence:** `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 250. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `147`
- **Evidence:** `'recommendation' => $this->generatePricingRecommendation((float) $suggestedPrice, $currentPrice, (float) $currentMargin),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 251. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `197`
- **Evidence:** `'price' => (float) $item->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 252. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `197`
- **Evidence:** `'price' => (float) $item->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 253. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `200`
- **Evidence:** `'avg_quantity' => (float) $item->avg_quantity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 254. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `201`
- **Evidence:** `'individual_total' => (float) $totalPrice,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 255. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `202`
- **Evidence:** `'suggested_bundle_price' => (float) $suggestedBundlePrice,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 256. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `203`
- **Evidence:** `'customer_savings' => (float) $savings,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 257. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `245`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 258. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `245`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 259. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `246`
- **Evidence:** `'margin' => (float) $margin,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 260. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `246`
- **Evidence:** `'margin' => (float) $margin,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 261. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `277`
- **Evidence:** `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 262. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `415`
- **Evidence:** `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 263. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `106`
- **Evidence:** `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 264. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `118`
- **Evidence:** `'tax' => number_format((float) $sale->tax_total, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 265. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `119`
- **Evidence:** `'discount' => number_format((float) $sale->discount_total, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 266. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `120`
- **Evidence:** `'total' => number_format((float) $sale->grand_total, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 267. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `39`
- **Evidence:** `'efficiency' => $this->efficiency((float) $payload['input_qty'], (float) $payload['output_qty']),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 268. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `56`
- **Evidence:** `$eff = $this->efficiency((float) $row->input_qty, (float) $row->output_qty);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 269. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `105`
- **Evidence:** `return (float) bcround($percentage, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 270. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 271. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `81`
- **Evidence:** `return (float) $this->amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 272. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/admin/dashboard.blade.php`
- **Line:** `58`
- **Evidence:** `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 273. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 274. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 275. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 276. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 277. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

---

## New bugs

### 1. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `318`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 2. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `245`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 3. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `407`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 4. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/ProfitMarginAnalysisService.php`
- **Line:** `202`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw with variable expression can become SQL injection if any part is influenced by user input; restrict to known-safe tokens.

### 5. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `109`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw with variable expression can become SQL injection if any part is influenced by user input; restrict to known-safe tokens.

### 6. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `285`
- **Evidence:** `->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw with variable expression can become SQL injection if any part is influenced by user input; restrict to known-safe tokens.

### 7. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `46`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 8. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `177`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 9. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `52`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 10. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `117`
- **Evidence:** `return $query->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw with variable expression can become SQL injection if any part is influenced by user input; restrict to known-safe tokens.

### 11. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `58`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 12. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `188`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** Never interpolate variables into raw SQL; use bindings or strict token whitelist.

### 13. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Helpers/helpers.php`
- **Line:** `107`
- **Evidence:** `$formatted = number_format((float) $normalized, $scale, '.', ',');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 14. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Helpers/helpers.php`
- **Line:** `107`
- **Evidence:** `$formatted = number_format((float) $normalized, $scale, '.', ',');`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 15. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Helpers/helpers.php`
- **Line:** `118`
- **Evidence:** `return number_format((float) $normalized, $decimals, '.', ',').'%';`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 16. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Helpers/helpers.php`
- **Line:** `118`
- **Evidence:** `return number_format((float) $normalized, $decimals, '.', ',').'%';`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 17. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `242`
- **Evidence:** `'revenue' => (float) $totalSales,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 18. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `243`
- **Evidence:** `'cost_of_goods' => (float) $totalCogs,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 19. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `244`
- **Evidence:** `'gross_profit' => (float) $grossProfit,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 20. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `245`
- **Evidence:** `'expenses' => (float) $totalExpenses,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 21. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `246`
- **Evidence:** `'net_profit' => (float) $netProfit,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 22. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/ReportsController.php`
- **Line:** `364`
- **Evidence:** `$agingFloat = array_map(fn ($v) => (float) $v, $aging);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 23. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/POSController.php`
- **Line:** `218`
- **Evidence:** `(float) $request->input('closing_cash'),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 24. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/ProductsController.php`
- **Line:** `78`
- **Evidence:** `'sale_price' => (float) $product->default_price, // Frontend fallback`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 25. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Branch/Rental/InvoiceController.php`
- **Line:** `68`
- **Evidence:** `return $this->ok($this->rental->applyPenalty($invoice->id, (float) $data['penalty'], $branch->id), __('Penalty applied'));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 26. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderResource.php`
- **Line:** `23`
- **Evidence:** `'subtotal' => (float) $this->sub_total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 27. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/OrderResource.php`
- **Line:** `28`
- **Evidence:** `'due_amount' => (float) $this->due_total,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 28. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `50`
- **Evidence:** `'min_stock' => $this->min_stock ? (float) $this->min_stock : 0.0,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 29. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `51`
- **Evidence:** `'max_stock' => $this->max_stock ? (float) $this->max_stock : null,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 30. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `52`
- **Evidence:** `'reorder_point' => $this->reorder_point ? (float) $this->reorder_point : 0.0,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 31. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `53`
- **Evidence:** `'reorder_qty' => $this->reorder_qty ? (float) $this->reorder_qty : 0.0,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 32. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/ProductResource.php`
- **Line:** `54`
- **Evidence:** `'lead_time_days' => $this->lead_time_days ? (float) $this->lead_time_days : null,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 33. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `30`
- **Evidence:** `'discount_amount' => $this->discount_amount ? (float) $this->discount_amount : null,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 34. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SupplierResource.php`
- **Line:** `18`
- **Evidence:** `return $value ? (float) $value : null;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 35. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SupplierResource.php`
- **Line:** `54`
- **Evidence:** `fn () => (float) $this->purchases->sum('total_amount')`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 36. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `72`
- **Evidence:** `$gross = (float) $grossString;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 37. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Livewire/Accounting/JournalEntries/Form.php`
- **Line:** `144`
- **Evidence:** `'amount' => number_format((float) ltrim($difference, '-'), 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 38. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Line:** `45`
- **Evidence:** `$this->paymentAmount = (float) $payment->remaining_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 39. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Loyalty/Index.php`
- **Line:** `59`
- **Evidence:** `$this->points_per_amount = (float) $settings->points_per_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 40. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Loyalty/Index.php`
- **Line:** `60`
- **Evidence:** `$this->amount_per_point = (float) $settings->amount_per_point;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 41. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Loyalty/Index.php`
- **Line:** `61`
- **Evidence:** `$this->redemption_rate = (float) $settings->redemption_rate;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 42. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- **Line:** `73`
- **Evidence:** `$this->price_multiplier = (float) $period->price_multiplier;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 43. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- **Line:** `37`
- **Evidence:** `$totalStock = (float) $products->sum('current_stock');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 44. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Reports/InventoryChartsDashboard.php`
- **Line:** `46`
- **Evidence:** `$values[] = (float) $product->current_stock;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 45. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- **Line:** `50`
- **Evidence:** `$totalRevenue = (float) $sales->sum('grand_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 46. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- **Line:** `66`
- **Evidence:** `$dayValues[] = (float) $items->sum('grand_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 47. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Reports/PosChartsDashboard.php`
- **Line:** `76`
- **Evidence:** `$branchValues[] = (float) $items->sum('grand_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 48. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/AdvancedSettings.php`
- **Line:** `184`
- **Evidence:** `'late_penalty_percent' => (float) $this->settingsService->get('notifications.late_penalty_percent', 5),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 49. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `68`
- **Evidence:** `$totalDiscount = (float) $ordersForStats->sum('discount_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 50. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `69`
- **Evidence:** `$totalShipping = (float) $ordersForStats->sum('shipping_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 51. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `70`
- **Evidence:** `$totalTax = (float) $ordersForStats->sum('tax_total');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 52. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `121`
- **Evidence:** `return (float) $s['revenue'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 53. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/UnitsOfMeasure/Form.php`
- **Line:** `63`
- **Evidence:** `$this->conversionFactor = (float) $unit->conversion_factor;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 54. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Livewire/Banking/Reconciliation.php`
- **Line:** `304`
- **Evidence:** `'amount' => number_format((float) $this->difference, 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 55. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Employees/Form.php`
- **Line:** `178`
- **Evidence:** `$employee->salary = (float) $this->form['salary'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 56. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `95`
- **Evidence:** `$model->basic = (float) $basic;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 57. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `96`
- **Evidence:** `$model->allowances = (float) $allowances;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 58. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `97`
- **Evidence:** `$model->deductions = (float) $deductions;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 59. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `98`
- **Evidence:** `$model->net = (float) $net;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 60. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Reports/Dashboard.php`
- **Line:** `126`
- **Evidence:** `'total_net' => (float) $group->sum('net'),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 61. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/ProductHistory.php`
- **Line:** `114`
- **Evidence:** `$this->currentStock = (float) $currentStock;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 62. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Manufacturing/BillsOfMaterials/Form.php`
- **Line:** `72`
- **Evidence:** `$this->scrap_percentage = (float) $this->bom->scrap_percentage;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 63. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Manufacturing/ProductionOrders/Form.php`
- **Line:** `73`
- **Evidence:** `$this->quantity_planned = (float) $this->productionOrder->quantity_planned;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 64. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Manufacturing/WorkCenters/Form.php`
- **Line:** `77`
- **Evidence:** `$this->capacity_per_hour = $this->workCenter->capacity_per_hour ? (float) $this->workCenter->capacity_per_hour : null;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 65. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Manufacturing/WorkCenters/Form.php`
- **Line:** `78`
- **Evidence:** `$this->cost_per_hour = (float) $this->workCenter->cost_per_hour;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 66. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `162`
- **Evidence:** `$unitCost = (float) $pi->unit_cost;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 67. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `177`
- **Evidence:** `$this->form['rent'] = (float) $model->rent;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 68. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `178`
- **Evidence:** `$this->form['deposit'] = (float) $model->deposit;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 69. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `339`
- **Evidence:** `$contract->rent = (float) $this->form['rent'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 70. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `340`
- **Evidence:** `$contract->deposit = (float) $this->form['deposit'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 71. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `96`
- **Evidence:** `$this->form['rent'] = (float) $unitModel->rent;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 72. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `97`
- **Evidence:** `$this->form['deposit'] = (float) $unitModel->deposit;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 73. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `155`
- **Evidence:** `$unit->rent = (float) $this->form['rent'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 74. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `156`
- **Evidence:** `$unit->deposit = (float) $this->form['deposit'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 75. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `180`
- **Evidence:** `$avgOrderValue = $totalOrders > 0 ? (float) bcdiv((string) $totalSales, (string) $totalOrders, 2) : 0;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 76. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `201`
- **Evidence:** `$salesGrowth = (float) bcdiv(bcmul($diff, '100', 6), (string) $prevTotalSales, 1);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 77. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `206`
- **Evidence:** `$completionRate = $totalOrders > 0 ? (float) bcdiv(bcmul((string) $completedOrders, '100', 4), (string) $totalOrders, 1) : 0;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 78. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `271`
- **Evidence:** `'revenue' => $results->pluck('revenue')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 79. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `311`
- **Evidence:** `'revenue' => (float) $p->total_revenue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 80. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `351`
- **Evidence:** `'total_spent' => (float) $c->total_spent,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 81. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `464`
- **Evidence:** `'revenues' => $results->pluck('total_revenue')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 82. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `58`
- **Evidence:** `return (float) $this->duration_minutes + (float) $this->setup_time_minutes;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 83. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `67`
- **Evidence:** `$workCenterCost = $timeHours * (float) $this->workCenter->cost_per_hour;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 84. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `68`
- **Evidence:** `$laborCost = (float) $this->labor_cost;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 85. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GRNItem.php`
- **Line:** `93`
- **Evidence:** `return (abs($expectedQty - (float) $acceptedQty) / $expectedQty) * 100;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 86. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `162`
- **Evidence:** `return (float) $this->items->sum('received_quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 87. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `167`
- **Evidence:** `return (float) $this->items->sum('accepted_quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 88. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `172`
- **Evidence:** `return (float) $this->items->sum('rejected_quantity');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 89. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPayment.php`
- **Line:** `45`
- **Evidence:** `return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 90. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPlan.php`
- **Line:** `71`
- **Evidence:** `return (float) $this->payments()->sum('amount_paid');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 91. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPlan.php`
- **Line:** `76`
- **Evidence:** `return max(0, (float) $this->total_amount - (float) $this->down_payment - $this->paid_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 92. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ModuleSetting.php`
- **Line:** `53`
- **Evidence:** `'float', 'decimal' => (float) $this->setting_value,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 93. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductFieldValue.php`
- **Line:** `39`
- **Evidence:** `'decimal' => (float) $this->value,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 94. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductionOrder.php`
- **Line:** `189`
- **Evidence:** `return (float) $this->planned_quantity - (float) $this->produced_quantity - (float) $this->rejected_quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 95. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Project.php`
- **Line:** `195`
- **Evidence:** `return (float) $this->budget;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 96. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProjectTask.php`
- **Line:** `150`
- **Evidence:** `return (float) $this->timeLogs()->sum('hours');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 97. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProjectTask.php`
- **Line:** `156`
- **Evidence:** `$estimated = (float) $this->estimated_hours;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 98. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `189`
- **Evidence:** `return (float) $this->paid_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 99. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `194`
- **Evidence:** `return max(0, (float) $this->total_amount - (float) $this->paid_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 100. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `229`
- **Evidence:** `$paidAmount = (float) $this->paid_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 101. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `230`
- **Evidence:** `$totalAmount = (float) $this->total_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 102. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `205`
- **Evidence:** `return (float) $this->payments()`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 103. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `212`
- **Evidence:** `return max(0, (float) $this->total_amount - $this->total_paid);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 104. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `235`
- **Evidence:** `$totalAmount = (float) $this->total_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 105. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/StockTransferItem.php`
- **Line:** `74`
- **Evidence:** `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 106. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/SystemSetting.php`
- **Line:** `103`
- **Evidence:** `'float', 'decimal' => is_numeric($value) ? (float) $value : $default,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 107. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Traits/CommonQueryScopes.php`
- **Line:** `192`
- **Evidence:** `return number_format((float) $value, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 108. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Models/Traits/CommonQueryScopes.php`
- **Line:** `192`
- **Evidence:** `return number_format((float) $value, 2);`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 109. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Transfer.php`
- **Line:** `220`
- **Evidence:** `return (float) $this->items()`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 110. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/UnitOfMeasure.php`
- **Line:** `87`
- **Evidence:** `$baseValue = $value * (float) $this->conversion_factor;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 111. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/UnitOfMeasure.php`
- **Line:** `89`
- **Evidence:** `$targetFactor = (float) $targetUnit->conversion_factor;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 112. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `142`
- **Evidence:** `$customer->addBalance((float) $model->total_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 113. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `144`
- **Evidence:** `$customer->subtractBalance((float) $model->total_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 114. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `151`
- **Evidence:** `$supplier->addBalance((float) $model->total_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 115. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `153`
- **Evidence:** `$supplier->subtractBalance((float) $model->total_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 116. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `25`
- **Evidence:** `$product->default_price = round((float) $product->default_price, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 117. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `28`
- **Evidence:** `$product->standard_cost = round((float) $product->standard_cost, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 118. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Rules/ValidDiscount.php`
- **Line:** `35`
- **Evidence:** `$num = (float) $value;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 119. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AccountingService.php`
- **Line:** `94`
- **Evidence:** `'debit' => (float) $unpaidAmount,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 120. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AccountingService.php`
- **Line:** `336`
- **Evidence:** `if (abs((float) $difference) >= 0.01) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 121. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AccountingService.php`
- **Line:** `345`
- **Evidence:** `return abs((float) $difference) < 0.01;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 122. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AccountingService.php`
- **Line:** `721`
- **Evidence:** `$totalCost = (float) bcround($totalCost, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 123. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `119`
- **Evidence:** `'revenue' => (float) $row->revenue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 124. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `120`
- **Evidence:** `'avg_order_value' => (float) $row->avg_order_value,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 125. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `178`
- **Evidence:** `$utilization = (float) bcmul(`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 126. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `239`
- **Evidence:** `$estimatedLoss = (float) bcmul((string) $currentStock, (string) $unitCost, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 127. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/BankingService.php`
- **Line:** `281`
- **Evidence:** `return (float) $this->getAccountBalance($accountId);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 128. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/BankingService.php`
- **Line:** `329`
- **Evidence:** `(float) $availableBalance,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 129. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `112`
- **Evidence:** `'unit_cost' => (float) $avgCost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 130. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `114`
- **Evidence:** `'total_cost' => (float) bcround($totalCost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 131. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `124`
- **Evidence:** `$unitCost = (float) $product->standard_cost;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 132. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `158`
- **Evidence:** `'unit_cost' => (float) $batch->unit_cost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 133. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `160`
- **Evidence:** `'total_cost' => (float) bcround($batchCost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 134. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `167`
- **Evidence:** `'unit_cost' => (float) $unitCost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 135. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `247`
- **Evidence:** `$batch->unit_cost = (float) $weightedAvgCost;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 136. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `329`
- **Evidence:** `'warehouse_value' => (float) $warehouseValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 137. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `330`
- **Evidence:** `'warehouse_quantity' => (float) $warehouseQuantity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 138. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `331`
- **Evidence:** `'transit_value' => (float) $transitValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 139. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `332`
- **Evidence:** `'transit_quantity' => (float) $transitQuantity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 140. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `333`
- **Evidence:** `'total_value' => (float) $totalValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 141. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `334`
- **Evidence:** `'total_quantity' => (float) $totalQuantity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 142. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `336`
- **Evidence:** `'in_warehouses' => (float) $warehouseValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 143. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `337`
- **Evidence:** `'in_transit' => (float) $transitValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 144. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/CostingService.php`
- **Line:** `360`
- **Evidence:** `if ((float) $totalStock <= self::STOCK_ZERO_TOLERANCE) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 145. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/DataValidationService.php`
- **Line:** `129`
- **Evidence:** `$percentage = (float) $percentage;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 146. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `71`
- **Evidence:** `'total_debit' => (float) bcround($totalDebitStr, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 147. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `72`
- **Evidence:** `'total_credit' => (float) bcround($totalCreditStr, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 148. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `73`
- **Evidence:** `'difference' => (float) $difference,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 149. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `155`
- **Evidence:** `'net_income' => (float) $netIncome,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 150. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `265`
- **Evidence:** `'total_liabilities_and_equity' => (float) $totalLiabilitiesAndEquity,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 151. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `311`
- **Evidence:** `$outstandingAmount = (float) $sale->total_amount - (float) $totalPaid + (float) $totalRefunded;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 152. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `381`
- **Evidence:** `$outstandingAmount = (float) $purchase->total_amount - (float) $totalPaid;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 153. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `455`
- **Evidence:** `$debit = (float) $line->debit;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 154. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `456`
- **Evidence:** `$credit = (float) $line->credit;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 155. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `491`
- **Evidence:** `'total_debit' => (float) bcround((string) $totalDebit, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 156. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `492`
- **Evidence:** `'total_credit' => (float) bcround((string) $totalCredit, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 157. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `493`
- **Evidence:** `'ending_balance' => (float) bcround((string) $runningBalance, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 158. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `521`
- **Evidence:** `$totalDebit = (float) $query->sum('debit');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 159. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/FinancialReportService.php`
- **Line:** `522`
- **Evidence:** `$totalCredit = (float) $query->sum('credit');`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 160. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HRMService.php`
- **Line:** `109`
- **Evidence:** `$basic = (float) $emp->salary;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 161. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HRMService.php`
- **Line:** `167`
- **Evidence:** `return (float) bcround($insurance, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 162. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HRMService.php`
- **Line:** `209`
- **Evidence:** `return (float) bcround($monthlyTax, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 163. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HRMService.php`
- **Line:** `233`
- **Evidence:** `$dailyRate = (float) $emp->salary / 30;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 164. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HRMService.php`
- **Line:** `236`
- **Evidence:** `return (float) bcmul((string) $dailyRate, (string) $absenceDays, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 165. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HelpdeskService.php`
- **Line:** `294`
- **Evidence:** `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 166. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InstallmentService.php`
- **Line:** `31`
- **Evidence:** `$totalAmount = (float) $sale->grand_total;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 167. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InstallmentService.php`
- **Line:** `130`
- **Evidence:** `$remainingAmount = (float) $payment->remaining_amount;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 168. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InstallmentService.php`
- **Line:** `146`
- **Evidence:** `'amount_paid' => (float) $newAmountPaid,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 169. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InstallmentService.php`
- **Line:** `161`
- **Evidence:** `$planRemainingAmount = max(0, (float) $planRemainingAmount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 170. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LeaveManagementService.php`
- **Line:** `621`
- **Evidence:** `$daysToDeduct = (float) $leaveRequest->days_count;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 171. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LoyaltyService.php`
- **Line:** `37`
- **Evidence:** `$points = (int) floor((float) $pointsDecimal);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 172. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LoyaltyService.php`
- **Line:** `208`
- **Evidence:** `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 173. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `30`
- **Evidence:** `return (float) bcdiv((string) $override, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 174. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `38`
- **Evidence:** `return (float) bcdiv((string) $p, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 175. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `45`
- **Evidence:** `return (float) bcdiv((string) $base, '1', 4);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 176. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PricingService.php`
- **Line:** `84`
- **Evidence:** `'subtotal' => (float) bcround((string) $subtotal, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 177. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `103`
- **Evidence:** `$qtyReturned = (float) $itemData['qty_returned'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 178. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `313`
- **Evidence:** `if ((float) $item->qty_returned <= 0) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 179. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `328`
- **Evidence:** `'unit_cost' => (float) $item->unit_cost,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 180. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `133`
- **Evidence:** `'rent' => (float) $payload['rent'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 181. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `154`
- **Evidence:** `$c->rent = (float) $payload['rent'];`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 182. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `243`
- **Evidence:** `$i->paid_total = (float) $newPaidTotal;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 183. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `389`
- **Evidence:** `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 184. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `520`
- **Evidence:** `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 185. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `39`
- **Evidence:** `'current_cash' => (float) $currentCash,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 186. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `43`
- **Evidence:** `'ending_cash_forecast' => (float) $dailyForecast->last()['ending_balance'],`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 187. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `140`
- **Evidence:** `'net_flow' => (float) $netFlow,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 188. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `141`
- **Evidence:** `'ending_balance' => (float) $runningBalance,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 189. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `153`
- **Evidence:** `'total_revenue' => (float) $totalRevenue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 190. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `155`
- **Evidence:** `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 191. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `198`
- **Evidence:** `'revenue_at_risk' => (float) $at_risk->sum('lifetime_revenue'),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 192. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `77`
- **Evidence:** `'stock_value' => (float) $stockValue,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 193. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `80`
- **Evidence:** `'daily_sales_rate' => (float) $dailyRate,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 194. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `88`
- **Evidence:** `'total_stock_value' => (float) $products->sum(function ($product) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 195. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `121`
- **Evidence:** `'potential_loss' => (float) $potentialLoss,`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 196. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `127`
- **Evidence:** `'total_potential_loss' => (float) $products->sum(function ($product) {`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 197. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `202`
- **Evidence:** `$dueTotal = max(0, (float) $invoice->total_amount - (float) $invoice->paid_amount);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 198. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `102`
- **Evidence:** `return (float) $product->reorder_qty;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 199. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `114`
- **Evidence:** `return (float) $product->minimum_order_quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 200. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `119`
- **Evidence:** `return (float) $product->maximum_order_quantity;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 201. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `123`
- **Evidence:** `return (float) bcround((string) $optimalQty, 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 202. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `127`
- **Evidence:** `return $product->reorder_point ? ((float) $product->reorder_point * 2) : 50;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 203. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `152`
- **Evidence:** `return $totalSold ? ((float) $totalSold / $days) : 0;`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 204. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `187`
- **Evidence:** `'sales_velocity' => (float) bcround((string) $salesVelocity, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 205. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `308`
- **Evidence:** `'total_estimated_cost' => (float) bcround((string) $totalEstimatedCost, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 206. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UIHelperService.php`
- **Line:** `190`
- **Evidence:** `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 207. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `106`
- **Evidence:** `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 208. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `117`
- **Evidence:** `'subtotal' => number_format((float) $sale->sub_total, 2),`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 209. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `117`
- **Evidence:** `'subtotal' => number_format((float) $sale->sub_total, 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 210. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `118`
- **Evidence:** `'tax' => number_format((float) $sale->tax_total, 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 211. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `119`
- **Evidence:** `'discount' => number_format((float) $sale->discount_total, 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 212. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `120`
- **Evidence:** `'total' => number_format((float) $sale->grand_total, 2),`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 213. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 214. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `50`
- **Evidence:** `{!! $actions !!}`
- **Why it matters:** Unescaped output can lead to XSS. Prefer {{ }} escaping, or sanitize/strip tags when HTML is required.

### 215. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `72`
- **Evidence:** `@if($wireModel) {!! $wireDirective !!} @endif`
- **Why it matters:** Unescaped output can lead to XSS. Prefer {{ }} escaping, or sanitize/strip tags when HTML is required.

### 216. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `This view uses {!! $qrCodeSvg !!} to render a QR code image. This is safe because:`
- **Why it matters:** Unescaped output can lead to XSS. Prefer {{ }} escaping, or sanitize/strip tags when HTML is required.

### 217. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `67`
- **Evidence:** `{!! $qrCodeSvg !!}`
- **Why it matters:** Unescaped output can lead to XSS. Prefer {{ }} escaping, or sanitize/strip tags when HTML is required.

### 218. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 219. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 220. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 221. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 222. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 223. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 224. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 225. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 226. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 227. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 228. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 229. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 230. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 231. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 232. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 233. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 234. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 235. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 236. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 237. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 238. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 239. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 240. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 241. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 242. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 243. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 244. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 245. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 246. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 247. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 248. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 249. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 250. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.

### 251. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** Use decimal-safe arithmetic (BCMath/Money) and DB DECIMAL for money/qty.

### 252. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** Formatting should not require float casts; store as DECIMAL and format via string-safe conversions.
