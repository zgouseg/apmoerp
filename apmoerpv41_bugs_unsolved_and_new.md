# APMO ERP v41 — Old (Unsolved) + New Bugs

## Summary
- **Compared versions:** `v40` → `v41`
- **Laravel:** `^12.0`
- **Livewire:** `^4.0.1`
- **Baseline bugs (from v40 report):** `519`
- **Old bugs fixed in v41:** `1`
- **Old bugs still present:** `518`
- **New bugs detected in v41 (by scan):** `64`

### Notes
- Static heuristic scan (no runtime tests).
- `database/` ignored as requested.
- Old-bug status: fixed only if (a) same rule/file not found by scan and (b) old evidence not present after whitespace normalization.

---

## Old bugs not solved yet (still present in v41)

### 1. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `318`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 2. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `248`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 3. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `414`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 4. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `45`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 5. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `171`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 6. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `52`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 7. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `58`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 8. [HIGH] selectRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `SELECT_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `188`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** selectRaw contains interpolated variable (SQL injection risk)

### 9. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/ProfitMarginAnalysisService.php`
- **Line:** `209`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 10. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `116`
- **Evidence:** `->groupBy(DB::raw($periodExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 11. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `292`
- **Evidence:** `->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 12. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `119`
- **Evidence:** `return $query->groupBy(DB::raw($dateExpr))`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 13. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `100`
- **Evidence:** `->selectRaw($stockExpr.' as current_stock');`
- **Why it matters:** Raw SQL expression comes from variable (must be strict whitelist)

### 14. [HIGH] Raw SQL expression comes from variable (must be strict whitelist)
- **Rule ID:** `SQL_RAW_EXPR_VAR`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `323`
- **Evidence:** `->orderByRaw($stockExpr)`
- **Why it matters:** Raw SQL expression comes from variable (must be strict whitelist)

### 15. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `170`
- **Evidence:** `->whereRaw("{$stockExpr} <= min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 16. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `318`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 17. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `320`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 18. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `248`
- **Evidence:** `->selectRaw("{$dateFormat} as period")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 19. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Livewire/Reports/SalesAnalytics.php`
- **Line:** `414`
- **Evidence:** `->selectRaw("{$hourExpr} as hour")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 20. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `308`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 21. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `328`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) <= 0");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 22. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Models/Product.php`
- **Line:** `348`
- **Evidence:** `return $query->whereRaw("({$stockSubquery}) > 0");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 23. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/AutomatedAlertService.php`
- **Line:** `227`
- **Evidence:** `->whereRaw("({$stockSubquery}) > 0")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 24. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `45`
- **Evidence:** `->selectRaw("{$datediffExpr} as recency_days")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 25. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `171`
- **Evidence:** `->selectRaw("{$datediffExpr} as days_since_purchase")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 26. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `52`
- **Evidence:** `->selectRaw("{$daysDiffExpr} as days_since_sale")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 27. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `151`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 28. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/ScheduledReportService.php`
- **Line:** `151`
- **Evidence:** `$query->whereRaw("({$stockSubquery}) <= COALESCE(products.reorder_point, 0)");`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 29. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `58`
- **Evidence:** `->selectRaw("{$stockExpr} as current_quantity")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 30. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `59`
- **Evidence:** `->whereRaw("{$stockExpr} <= products.min_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 31. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `56`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= reorder_point")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 32. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `81`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= stock_alert_threshold")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 33. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `82`
- **Evidence:** `->whereRaw("({$stockSubquery}) > COALESCE(reorder_point, 0)")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 34. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `46`
- **Evidence:** `->whereRaw("({$stockSubquery}) <= COALESCE(reorder_point, min_stock, 0)")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 35. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `188`
- **Evidence:** `->selectRaw("*, ({$stockSubquery}) as calculated_stock")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 36. [HIGH] Raw SQL string contains PHP variable (possible SQL injection / unsafe expression)
- **Rule ID:** `SQL_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `189`
- **Evidence:** `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`
- **Why it matters:** Raw SQL string contains PHP variable (SQL injection risk)

### 37. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `198`
- **Evidence:** `$queryToken = $request->query('api_token');`
- **Why it matters:** API token accepted from query/body (leak risk)

### 38. [HIGH] API token accepted from query/body (leak risk)
- **Rule ID:** `TOKEN_IN_QUERY`
- **File:** `app/Http/Middleware/AuthenticateStoreToken.php`
- **Line:** `204`
- **Evidence:** `$bodyToken = $request->input('api_token');`
- **Why it matters:** API token accepted from query/body (leak risk)

### 39. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `4`
- **Evidence:** `This component uses {!! !!} for the $icon prop. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 40. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `10`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 41. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/form/input.blade.php`
- **Line:** `76`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 42. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/icon.blade.php`
- **Line:** `44`
- **Evidence:** `{!! sanitize_svg_icon($iconPath) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 43. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} to render SVG icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 44. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 45. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/button.blade.php`
- **Line:** `56`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 46. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `3`
- **Evidence:** `SECURITY NOTE: This component uses {!! !!} for two types of content:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 47. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `27`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 48. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/card.blade.php`
- **Line:** `50`
- **Evidence:** `{!! $actions !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 49. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for SVG icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 50. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `10`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 51. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/empty-state.blade.php`
- **Line:** `43`
- **Evidence:** `{!! sanitize_svg_icon($displayIcon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 52. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `3`
- **Evidence:** `SECURITY NOTE: This component uses {!! !!} for:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 53. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `60`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 54. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/form/input.blade.php`
- **Line:** `72`
- **Evidence:** `@if($wireModel) {!! $wireDirective !!} @endif`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 55. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for the $icon prop. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 56. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 57. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/components/ui/page-header.blade.php`
- **Line:** `57`
- **Evidence:** `{!! sanitize_svg_icon($icon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 58. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `This view uses {!! $qrCodeSvg !!} to render a QR code image. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 59. [MEDIUM] Blade outputs unescaped variable (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `4`
- **Evidence:** `This view uses {!! $qrCodeSvg !!} to render a QR code image. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 60. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `9`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 61. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for the $icon field from form schema. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 62. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 63. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-form.blade.php`
- **Line:** `52`
- **Evidence:** `<span class="text-slate-400">{!! sanitize_svg_icon($icon) !!}</span>`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 64. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `5`
- **Evidence:** `This component uses {!! !!} for action icons. This is safe because:`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 65. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `11`
- **Evidence:** `Static analysis tools may flag {!! !!} as XSS risks. This is a false positive`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 66. [MEDIUM] Unescaped Blade output ({!! !!}) may cause XSS if input is not trusted
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `273`
- **Evidence:** `{!! sanitize_svg_icon($actionIcon) !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

### 67. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/POSController.php`
- **Line:** `218`
- **Evidence:** `(float) $request->input('closing_cash'),`
- **Why it matters:** Float cast used (precision risk for finance)

### 68. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `30`
- **Evidence:** `'discount_amount' => $this->discount_amount ? (float) $this->discount_amount : null,`
- **Why it matters:** Float cast used (precision risk for finance)

### 69. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SupplierResource.php`
- **Line:** `18`
- **Evidence:** `return $value ? (float) $value : null;`
- **Why it matters:** Float cast used (precision risk for finance)

### 70. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SupplierResource.php`
- **Line:** `54`
- **Evidence:** `fn () => (float) $this->purchases->sum('total_amount')`
- **Why it matters:** Float cast used (precision risk for finance)

### 71. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `72`
- **Evidence:** `$gross = (float) $grossString;`
- **Why it matters:** Float cast used (precision risk for finance)

### 72. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `73`
- **Evidence:** `$paid = (float) $paidString;`
- **Why it matters:** Float cast used (precision risk for finance)

### 73. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/ApplyLateFee.php`
- **Line:** `43`
- **Evidence:** `$invoice->amount = (float) $newAmount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 74. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/UpdateStockOnPurchase.php`
- **Line:** `27`
- **Evidence:** `$itemQty = (float) $item->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 75. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Listeners/UpdateStockOnSale.php`
- **Line:** `49`
- **Evidence:** `$baseQuantity = (float) $item->quantity * (float) $conversionFactor;`
- **Why it matters:** Float cast used (precision risk for finance)

### 76. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Accounting/JournalEntries/Form.php`
- **Line:** `144`
- **Evidence:** `'amount' => number_format((float) ltrim($difference, '-'), 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 77. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/CurrencyRate/Form.php`
- **Line:** `51`
- **Evidence:** `$this->rate = (float) $rate->rate;`
- **Why it matters:** Float cast used (precision risk for finance)

### 78. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Installments/Index.php`
- **Line:** `45`
- **Evidence:** `$this->paymentAmount = (float) $payment->remaining_amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 79. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Modules/RentalPeriods/Form.php`
- **Line:** `73`
- **Evidence:** `$this->price_multiplier = (float) $period->price_multiplier;`
- **Why it matters:** Float cast used (precision risk for finance)

### 80. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `67`
- **Evidence:** `$totalRevenue = (float) $ordersForStats->sum('total');`
- **Why it matters:** Float cast used (precision risk for finance)

### 81. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `68`
- **Evidence:** `$totalDiscount = (float) $ordersForStats->sum('discount_total');`
- **Why it matters:** Float cast used (precision risk for finance)

### 82. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `69`
- **Evidence:** `$totalShipping = (float) $ordersForStats->sum('shipping_total');`
- **Why it matters:** Float cast used (precision risk for finance)

### 83. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `70`
- **Evidence:** `$totalTax = (float) $ordersForStats->sum('tax_total');`
- **Why it matters:** Float cast used (precision risk for finance)

### 84. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `84`
- **Evidence:** `$sources[$source]['revenue'] += (float) $order->total;`
- **Why it matters:** Float cast used (precision risk for finance)

### 85. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `121`
- **Evidence:** `return (float) $s['revenue'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 86. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `139`
- **Evidence:** `$dayValues[] = (float) $items->sum('total');`
- **Why it matters:** Float cast used (precision risk for finance)

### 87. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Employees/Form.php`
- **Line:** `178`
- **Evidence:** `$employee->salary = (float) $this->form['salary'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 88. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `95`
- **Evidence:** `$model->basic = (float) $basic;`
- **Why it matters:** Float cast used (precision risk for finance)

### 89. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `96`
- **Evidence:** `$model->allowances = (float) $allowances;`
- **Why it matters:** Float cast used (precision risk for finance)

### 90. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `97`
- **Evidence:** `$model->deductions = (float) $deductions;`
- **Why it matters:** Float cast used (precision risk for finance)

### 91. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `98`
- **Evidence:** `$model->net = (float) $net;`
- **Why it matters:** Float cast used (precision risk for finance)

### 92. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Reports/Dashboard.php`
- **Line:** `126`
- **Evidence:** `'total_net' => (float) $group->sum('net'),`
- **Why it matters:** Float cast used (precision risk for finance)

### 93. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Income/Form.php`
- **Line:** `102`
- **Evidence:** `$this->amount = (float) $income->amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 94. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/ProductHistory.php`
- **Line:** `114`
- **Evidence:** `$this->currentStock = (float) $currentStock;`
- **Why it matters:** Float cast used (precision risk for finance)

### 95. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `143`
- **Evidence:** `$this->form['max_stock'] = $p->max_stock ? (float) $p->max_stock : null;`
- **Why it matters:** Float cast used (precision risk for finance)

### 96. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `145`
- **Evidence:** `$this->form['lead_time_days'] = $p->lead_time_days ? (float) $p->lead_time_days : null;`
- **Why it matters:** Float cast used (precision risk for finance)

### 97. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `136`
- **Evidence:** `$this->defaultPrice = (float) $product->default_price;`
- **Why it matters:** Float cast used (precision risk for finance)

### 98. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `234`
- **Evidence:** `$this->defaultPrice = (float) bcround($calculated, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 99. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `171`
- **Evidence:** `'qty' => (float) $item->qty,`
- **Why it matters:** Float cast used (precision risk for finance)

### 100. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `172`
- **Evidence:** `'unit_cost' => (float) $item->unit_cost,`
- **Why it matters:** Float cast used (precision risk for finance)

### 101. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `102`
- **Evidence:** `'max_qty' => (float) $item->qty,`
- **Why it matters:** Float cast used (precision risk for finance)

### 102. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `104`
- **Evidence:** `'cost' => (float) $item->unit_cost,`
- **Why it matters:** Float cast used (precision risk for finance)

### 103. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `160`
- **Evidence:** `$qty = min((float) $it['qty'], (float) $pi->qty);`
- **Why it matters:** Float cast used (precision risk for finance)

### 104. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `162`
- **Evidence:** `$unitCost = (float) $pi->unit_cost;`
- **Why it matters:** Float cast used (precision risk for finance)

### 105. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `177`
- **Evidence:** `$this->form['rent'] = (float) $model->rent;`
- **Why it matters:** Float cast used (precision risk for finance)

### 106. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `178`
- **Evidence:** `$this->form['deposit'] = (float) $model->deposit;`
- **Why it matters:** Float cast used (precision risk for finance)

### 107. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `339`
- **Evidence:** `$contract->rent = (float) $this->form['rent'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 108. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Contracts/Form.php`
- **Line:** `340`
- **Evidence:** `$contract->deposit = (float) $this->form['deposit'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 109. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Reports/Dashboard.php`
- **Line:** `69`
- **Evidence:** `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`
- **Why it matters:** Float cast used (precision risk for finance)

### 110. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `96`
- **Evidence:** `$this->form['rent'] = (float) $unitModel->rent;`
- **Why it matters:** Float cast used (precision risk for finance)

### 111. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `97`
- **Evidence:** `$this->form['deposit'] = (float) $unitModel->deposit;`
- **Why it matters:** Float cast used (precision risk for finance)

### 112. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `155`
- **Evidence:** `$unit->rent = (float) $this->form['rent'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 113. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Rental/Units/Form.php`
- **Line:** `156`
- **Evidence:** `$unit->deposit = (float) $this->form['deposit'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 114. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `123`
- **Evidence:** `$itemQuantity = (float) $item->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 115. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomItem.php`
- **Line:** `69`
- **Evidence:** `$baseQuantity = (float) $this->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 116. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `58`
- **Evidence:** `return (float) $this->duration_minutes + (float) $this->setup_time_minutes;`
- **Why it matters:** Float cast used (precision risk for finance)

### 117. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `67`
- **Evidence:** `$workCenterCost = $timeHours * (float) $this->workCenter->cost_per_hour;`
- **Why it matters:** Float cast used (precision risk for finance)

### 118. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomOperation.php`
- **Line:** `68`
- **Evidence:** `$laborCost = (float) $this->labor_cost;`
- **Why it matters:** Float cast used (precision risk for finance)

### 119. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GRNItem.php`
- **Line:** `93`
- **Evidence:** `return (abs($expectedQty - (float) $acceptedQty) / $expectedQty) * 100;`
- **Why it matters:** Float cast used (precision risk for finance)

### 120. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `162`
- **Evidence:** `return (float) $this->items->sum('received_quantity');`
- **Why it matters:** Float cast used (precision risk for finance)

### 121. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `167`
- **Evidence:** `return (float) $this->items->sum('accepted_quantity');`
- **Why it matters:** Float cast used (precision risk for finance)

### 122. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GoodsReceivedNote.php`
- **Line:** `172`
- **Evidence:** `return (float) $this->items->sum('rejected_quantity');`
- **Why it matters:** Float cast used (precision risk for finance)

### 123. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPayment.php`
- **Line:** `45`
- **Evidence:** `return max(0, (float) $this->amount_due - (float) ($this->amount_paid ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 124. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPlan.php`
- **Line:** `71`
- **Evidence:** `return (float) $this->payments()->sum('amount_paid');`
- **Why it matters:** Float cast used (precision risk for finance)

### 125. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/InstallmentPlan.php`
- **Line:** `76`
- **Evidence:** `return max(0, (float) $this->total_amount - (float) $this->down_payment - $this->paid_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 126. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ModuleSetting.php`
- **Line:** `53`
- **Evidence:** `'float', 'decimal' => (float) $this->setting_value,`
- **Why it matters:** Float cast used (precision risk for finance)

### 127. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductFieldValue.php`
- **Line:** `39`
- **Evidence:** `'decimal' => (float) $this->value,`
- **Why it matters:** Float cast used (precision risk for finance)

### 128. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductionOrder.php`
- **Line:** `189`
- **Evidence:** `return (float) $this->planned_quantity - (float) $this->produced_quantity - (float) $this->rejected_quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 129. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Project.php`
- **Line:** `195`
- **Evidence:** `return (float) $this->budget;`
- **Why it matters:** Float cast used (precision risk for finance)

### 130. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProjectTask.php`
- **Line:** `150`
- **Evidence:** `return (float) $this->timeLogs()->sum('hours');`
- **Why it matters:** Float cast used (precision risk for finance)

### 131. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProjectTask.php`
- **Line:** `156`
- **Evidence:** `$estimated = (float) $this->estimated_hours;`
- **Why it matters:** Float cast used (precision risk for finance)

### 132. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `189`
- **Evidence:** `return (float) $this->paid_amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 133. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `194`
- **Evidence:** `return max(0, (float) $this->total_amount - (float) $this->paid_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 134. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `229`
- **Evidence:** `$paidAmount = (float) $this->paid_amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 135. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Purchase.php`
- **Line:** `230`
- **Evidence:** `$totalAmount = (float) $this->total_amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 136. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `205`
- **Evidence:** `return (float) $this->payments()`
- **Why it matters:** Float cast used (precision risk for finance)

### 137. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `212`
- **Evidence:** `return max(0, (float) $this->total_amount - $this->total_paid);`
- **Why it matters:** Float cast used (precision risk for finance)

### 138. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Sale.php`
- **Line:** `235`
- **Evidence:** `$totalAmount = (float) $this->total_amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 139. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/StockTransferItem.php`
- **Line:** `74`
- **Evidence:** `return (float) bcsub((string)$this->qty_shipped, (string)$this->qty_received, 3);`
- **Why it matters:** Float cast used (precision risk for finance)

### 140. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/SystemSetting.php`
- **Line:** `103`
- **Evidence:** `'float', 'decimal' => is_numeric($value) ? (float) $value : $default,`
- **Why it matters:** Float cast used (precision risk for finance)

### 141. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Traits/CommonQueryScopes.php`
- **Line:** `192`
- **Evidence:** `return number_format((float) $value, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 142. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Transfer.php`
- **Line:** `220`
- **Evidence:** `return (float) $this->items()`
- **Why it matters:** Float cast used (precision risk for finance)

### 143. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/UnitOfMeasure.php`
- **Line:** `87`
- **Evidence:** `$baseValue = $value * (float) $this->conversion_factor;`
- **Why it matters:** Float cast used (precision risk for finance)

### 144. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/UnitOfMeasure.php`
- **Line:** `89`
- **Evidence:** `$targetFactor = (float) $targetUnit->conversion_factor;`
- **Why it matters:** Float cast used (precision risk for finance)

### 145. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `142`
- **Evidence:** `$customer->addBalance((float) $model->total_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 146. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `144`
- **Evidence:** `$customer->subtractBalance((float) $model->total_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 147. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `151`
- **Evidence:** `$supplier->addBalance((float) $model->total_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 148. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/FinancialTransactionObserver.php`
- **Line:** `153`
- **Evidence:** `$supplier->subtractBalance((float) $model->total_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 149. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `49`
- **Evidence:** `$product->default_price = round((float) $product->default_price, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 150. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `52`
- **Evidence:** `$product->standard_cost = round((float) $product->standard_cost, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 151. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `55`
- **Evidence:** `$product->cost = round((float) $product->cost, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 152. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Rules/ValidDiscount.php`
- **Line:** `35`
- **Evidence:** `$num = (float) $value;`
- **Why it matters:** Float cast used (precision risk for finance)

### 153. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `126`
- **Evidence:** `'revenue' => (float) $row->revenue,`
- **Why it matters:** Float cast used (precision risk for finance)

### 154. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Analytics/SalesForecastingService.php`
- **Line:** `127`
- **Evidence:** `'avg_order_value' => (float) $row->avg_order_value,`
- **Why it matters:** Float cast used (precision risk for finance)

### 155. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/HelpdeskService.php`
- **Line:** `294`
- **Evidence:** `return (float) bcdiv((string) $totalMinutes, (string) $tickets->count(), 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 156. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LeaveManagementService.php`
- **Line:** `621`
- **Evidence:** `$daysToDeduct = (float) $leaveRequest->days_count;`
- **Why it matters:** Float cast used (precision risk for finance)

### 157. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LoyaltyService.php`
- **Line:** `37`
- **Evidence:** `$points = (int) floor((float) $pointsDecimal);`
- **Why it matters:** Float cast used (precision risk for finance)

### 158. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/LoyaltyService.php`
- **Line:** `208`
- **Evidence:** `return (float) bcmul((string) $points, (string) $settings->redemption_rate, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 159. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `113`
- **Evidence:** `$product->default_price = (float) $price;`
- **Why it matters:** Float cast used (precision risk for finance)

### 160. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `118`
- **Evidence:** `$product->cost = (float) $cost;`
- **Why it matters:** Float cast used (precision risk for finance)

### 161. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `103`
- **Evidence:** `$qtyReturned = (float) $itemData['qty_returned'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 162. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `104`
- **Evidence:** `$purchaseQty = (float) $purchaseItem->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 163. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `313`
- **Evidence:** `if ((float) $item->qty_returned <= 0) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 164. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `322`
- **Evidence:** `'qty' => (float) $item->qty_returned,`
- **Why it matters:** Float cast used (precision risk for finance)

### 165. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `328`
- **Evidence:** `'unit_cost' => (float) $item->unit_cost,`
- **Why it matters:** Float cast used (precision risk for finance)

### 166. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `77`
- **Evidence:** `$qty = (float) $it['qty'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 167. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `105`
- **Evidence:** `$lineTax = (float) bcmul($taxableAmount, bcdiv((string) $taxPercent, '100', 6), 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 168. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `129`
- **Evidence:** `'line_total' => (float) $lineTotal,`
- **Why it matters:** Float cast used (precision risk for finance)

### 169. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `138`
- **Evidence:** `$p->subtotal = (float) bcround($subtotal, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 170. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `139`
- **Evidence:** `$p->tax_amount = (float) bcround($totalTax, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 171. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `140`
- **Evidence:** `$p->discount_amount = (float) bcround($totalDiscount, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 172. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `142`
- **Evidence:** `$p->total_amount = (float) bcround(`
- **Why it matters:** Float cast used (precision risk for finance)

### 173. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `221`
- **Evidence:** `$remainingDue = max(0, (float) $p->total_amount - (float) $p->paid_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 174. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `254`
- **Evidence:** `$p->paid_amount = (float) $newPaidAmount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 175. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `257`
- **Evidence:** `if ((float) $p->paid_amount >= (float) $p->total_amount) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 176. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `259`
- **Evidence:** `} elseif ((float) $p->paid_amount > 0) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 177. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `284`
- **Evidence:** `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 178. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `284`
- **Evidence:** `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 179. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `133`
- **Evidence:** `'rent' => (float) $payload['rent'],`
- **Why it matters:** Float cast used (precision risk for finance)

### 180. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `154`
- **Evidence:** `$c->rent = (float) $payload['rent'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 181. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `243`
- **Evidence:** `$i->paid_total = (float) $newPaidTotal;`
- **Why it matters:** Float cast used (precision risk for finance)

### 182. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `271`
- **Evidence:** `$i->amount = (float) $newAmount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 183. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `389`
- **Evidence:** `? (float) bcmul(bcdiv((string) $occupiedUnits, (string) $totalUnits, 4), '100', 2)`
- **Why it matters:** Float cast used (precision risk for finance)

### 184. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `520`
- **Evidence:** `? (float) bcmul(bcdiv((string) $collectedAmount, (string) $totalAmount, 4), '100', 2)`
- **Why it matters:** Float cast used (precision risk for finance)

### 185. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `94`
- **Evidence:** `return $rows->map(fn ($r) => ['id' => $r->id, 'name' => $r->name, 'gross' => (float) $r->gross])->all();`
- **Why it matters:** Float cast used (precision risk for finance)

### 186. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `39`
- **Evidence:** `'current_cash' => (float) $currentCash,`
- **Why it matters:** Float cast used (precision risk for finance)

### 187. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `41`
- **Evidence:** `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`
- **Why it matters:** Float cast used (precision risk for finance)

### 188. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `42`
- **Evidence:** `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`
- **Why it matters:** Float cast used (precision risk for finance)

### 189. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `43`
- **Evidence:** `'ending_cash_forecast' => (float) $dailyForecast->last()['ending_balance'],`
- **Why it matters:** Float cast used (precision risk for finance)

### 190. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `138`
- **Evidence:** `'inflows' => (float) $dailyInflowsStr,`
- **Why it matters:** Float cast used (precision risk for finance)

### 191. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `139`
- **Evidence:** `'outflows' => (float) $dailyOutflowsStr,`
- **Why it matters:** Float cast used (precision risk for finance)

### 192. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `140`
- **Evidence:** `'net_flow' => (float) $netFlow,`
- **Why it matters:** Float cast used (precision risk for finance)

### 193. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `141`
- **Evidence:** `'ending_balance' => (float) $runningBalance,`
- **Why it matters:** Float cast used (precision risk for finance)

### 194. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `152`
- **Evidence:** `'total_revenue' => (float) $totalRevenue,`
- **Why it matters:** Float cast used (precision risk for finance)

### 195. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `154`
- **Evidence:** `? (float) bcdiv($totalRevenue, (string) count($customers), 2)`
- **Why it matters:** Float cast used (precision risk for finance)

### 196. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/CustomerSegmentationService.php`
- **Line:** `192`
- **Evidence:** `'revenue_at_risk' => (float) $at_risk->sum('lifetime_revenue'),`
- **Why it matters:** Float cast used (precision risk for finance)

### 197. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `77`
- **Evidence:** `'stock_value' => (float) $stockValue,`
- **Why it matters:** Float cast used (precision risk for finance)

### 198. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `80`
- **Evidence:** `'daily_sales_rate' => (float) $dailyRate,`
- **Why it matters:** Float cast used (precision risk for finance)

### 199. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `88`
- **Evidence:** `'total_stock_value' => (float) $products->sum(function ($product) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 200. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `121`
- **Evidence:** `'potential_loss' => (float) $potentialLoss,`
- **Why it matters:** Float cast used (precision risk for finance)

### 201. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Reports/SlowMovingStockService.php`
- **Line:** `127`
- **Evidence:** `'total_potential_loss' => (float) $products->sum(function ($product) {`
- **Why it matters:** Float cast used (precision risk for finance)

### 202. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `104`
- **Evidence:** `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`
- **Why it matters:** Float cast used (precision risk for finance)

### 203. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `104`
- **Evidence:** `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`
- **Why it matters:** Float cast used (precision risk for finance)

### 204. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `173`
- **Evidence:** `'total_amount' => (float) $refund,`
- **Why it matters:** Float cast used (precision risk for finance)

### 205. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `234`
- **Evidence:** `'amount' => (float) $refund,`
- **Why it matters:** Float cast used (precision risk for finance)

### 206. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `234`
- **Evidence:** `'amount' => (float) $refund,`
- **Why it matters:** Float cast used (precision risk for finance)

### 207. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `297`
- **Evidence:** `$returned[$itemId] = abs((float) $returnedQty);`
- **Why it matters:** Float cast used (precision risk for finance)

### 208. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `317`
- **Evidence:** `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 209. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `317`
- **Evidence:** `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 210. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `322`
- **Evidence:** `$soldQty = (float) $saleItem->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 211. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `322`
- **Evidence:** `$soldQty = (float) $saleItem->quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 212. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `218`
- **Evidence:** `$remainingRefundable = (float) $return->refund_amount - (float) $alreadyRefunded;`
- **Why it matters:** Float cast used (precision risk for finance)

### 213. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SmartNotificationsService.php`
- **Line:** `202`
- **Evidence:** `$dueTotal = max(0, (float) $invoice->total_amount - (float) $invoice->paid_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 214. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `102`
- **Evidence:** `return (float) $product->reorder_qty;`
- **Why it matters:** Float cast used (precision risk for finance)

### 215. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `114`
- **Evidence:** `return (float) $product->minimum_order_quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 216. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `119`
- **Evidence:** `return (float) $product->maximum_order_quantity;`
- **Why it matters:** Float cast used (precision risk for finance)

### 217. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `123`
- **Evidence:** `return (float) bcround((string) $optimalQty, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 218. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `127`
- **Evidence:** `return $product->reorder_point ? ((float) $product->reorder_point * 2) : 50;`
- **Why it matters:** Float cast used (precision risk for finance)

### 219. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `152`
- **Evidence:** `return $totalSold ? ((float) $totalSold / $days) : 0;`
- **Why it matters:** Float cast used (precision risk for finance)

### 220. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `187`
- **Evidence:** `'sales_velocity' => (float) bcround((string) $salesVelocity, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 221. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockReorderService.php`
- **Line:** `308`
- **Evidence:** `'total_estimated_cost' => (float) bcround((string) $totalEstimatedCost, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 222. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `61`
- **Evidence:** `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`
- **Why it matters:** Float cast used (precision risk for finance)

### 223. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `167`
- **Evidence:** `return (float) DB::table('stock_movements')`
- **Why it matters:** Float cast used (precision risk for finance)

### 224. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `322`
- **Evidence:** `$stockBefore = (float) DB::table('stock_movements')`
- **Why it matters:** Float cast used (precision risk for finance)

### 225. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `381`
- **Evidence:** `$totalStock = (float) StockMovement::where('product_id', $productId)`
- **Why it matters:** Float cast used (precision risk for finance)

### 226. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `236`
- **Evidence:** `$itemQuantities[(int) $itemId] = (float) $itemData['qty_shipped'];`
- **Why it matters:** Float cast used (precision risk for finance)

### 227. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `158`
- **Evidence:** `$qty = (float) Arr::get($item, 'qty', 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 228. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `164`
- **Evidence:** `$price = (float) Arr::get($item, 'price', 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 229. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `165`
- **Evidence:** `$discount = (float) Arr::get($item, 'discount', 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 230. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `35`
- **Evidence:** `return (float) bcround($taxAmount, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 231. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `51`
- **Evidence:** `$rate = (float) $tax->rate;`
- **Why it matters:** Float cast used (precision risk for finance)

### 232. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `51`
- **Evidence:** `$rate = (float) $tax->rate;`
- **Why it matters:** Float cast used (precision risk for finance)

### 233. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `63`
- **Evidence:** `return (float) bcdiv($taxPortion, '1', 4);`
- **Why it matters:** Float cast used (precision risk for finance)

### 234. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `69`
- **Evidence:** `return (float) bcdiv($taxAmount, '1', 4);`
- **Why it matters:** Float cast used (precision risk for finance)

### 235. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `82`
- **Evidence:** `return (float) bcdiv((string) $base, '1', 4);`
- **Why it matters:** Float cast used (precision risk for finance)

### 236. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `98`
- **Evidence:** `return (float) bcdiv($total, '1', 4);`
- **Why it matters:** Float cast used (precision risk for finance)

### 237. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `98`
- **Evidence:** `return (float) bcdiv($total, '1', 4);`
- **Why it matters:** Float cast used (precision risk for finance)

### 238. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `102`
- **Evidence:** `defaultValue: (float) bcdiv((string) $base, '1', 4)`
- **Why it matters:** Float cast used (precision risk for finance)

### 239. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `142`
- **Evidence:** `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`
- **Why it matters:** Float cast used (precision risk for finance)

### 240. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `151`
- **Evidence:** `'total_tax' => (float) bcround($totalTax, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 241. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UIHelperService.php`
- **Line:** `190`
- **Evidence:** `$value = (float) bcdiv((string) $value, '1024', $precision + 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 242. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `61`
- **Evidence:** `$suggestedQty = max((float) $eoq, (float) $product->minimum_order_quantity ?? 1);`
- **Why it matters:** Float cast used (precision risk for finance)

### 243. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `69`
- **Evidence:** `$urgency = $this->determineReorderUrgency((float) $currentStock, (float) $reorderPoint, (float) $product->min_stock ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 244. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `76`
- **Evidence:** `'reorder_point' => (float) $reorderPoint,`
- **Why it matters:** Float cast used (precision risk for finance)

### 245. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `78`
- **Evidence:** `'sales_velocity' => (float) $salesVelocity,`
- **Why it matters:** Float cast used (precision risk for finance)

### 246. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `79`
- **Evidence:** `'days_of_stock_remaining' => (float) $daysOfStock,`
- **Why it matters:** Float cast used (precision risk for finance)

### 247. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `83`
- **Evidence:** `'recommendation' => $this->generateReorderRecommendation($urgency, (float) $daysOfStock, $suggestedQty),`
- **Why it matters:** Float cast used (precision risk for finance)

### 248. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `121`
- **Evidence:** `'price' => (float) $price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 249. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `121`
- **Evidence:** `'price' => (float) $price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 250. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `123`
- **Evidence:** `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 251. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `123`
- **Evidence:** `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 252. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `141`
- **Evidence:** `'current_margin' => (float) $currentMargin.'%',`
- **Why it matters:** Float cast used (precision risk for finance)

### 253. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `142`
- **Evidence:** `'suggested_price' => (float) $suggestedPrice,`
- **Why it matters:** Float cast used (precision risk for finance)

### 254. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `144`
- **Evidence:** `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 255. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `144`
- **Evidence:** `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 256. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `147`
- **Evidence:** `'recommendation' => $this->generatePricingRecommendation((float) $suggestedPrice, $currentPrice, (float) $currentMargin),`
- **Why it matters:** Float cast used (precision risk for finance)

### 257. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `197`
- **Evidence:** `'price' => (float) $item->default_price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 258. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `197`
- **Evidence:** `'price' => (float) $item->default_price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 259. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `200`
- **Evidence:** `'avg_quantity' => (float) $item->avg_quantity,`
- **Why it matters:** Float cast used (precision risk for finance)

### 260. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `201`
- **Evidence:** `'individual_total' => (float) $totalPrice,`
- **Why it matters:** Float cast used (precision risk for finance)

### 261. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `202`
- **Evidence:** `'suggested_bundle_price' => (float) $suggestedBundlePrice,`
- **Why it matters:** Float cast used (precision risk for finance)

### 262. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `203`
- **Evidence:** `'customer_savings' => (float) $savings,`
- **Why it matters:** Float cast used (precision risk for finance)

### 263. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `245`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 264. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `245`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Float cast used (precision risk for finance)

### 265. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `246`
- **Evidence:** `'margin' => (float) $margin,`
- **Why it matters:** Float cast used (precision risk for finance)

### 266. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `246`
- **Evidence:** `'margin' => (float) $margin,`
- **Why it matters:** Float cast used (precision risk for finance)

### 267. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `277`
- **Evidence:** `return (float) bcdiv((string) ($totalSold ?? 0), (string) $days, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 268. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `415`
- **Evidence:** `? (float) bcmul(bcdiv(bcsub((string) $product->default_price, (string) $product->standard_cost, 2), (string) $product->default_price, 4), '100', 2)`
- **Why it matters:** Float cast used (precision risk for finance)

### 269. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `106`
- **Evidence:** `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 270. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `117`
- **Evidence:** `'subtotal' => number_format((float) $sale->sub_total, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 271. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `118`
- **Evidence:** `'tax' => number_format((float) $sale->tax_total, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 272. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `119`
- **Evidence:** `'discount' => number_format((float) $sale->discount_total, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 273. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `120`
- **Evidence:** `'total' => number_format((float) $sale->grand_total, 2),`
- **Why it matters:** Float cast used (precision risk for finance)

### 274. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `39`
- **Evidence:** `'efficiency' => $this->efficiency((float) $payload['input_qty'], (float) $payload['output_qty']),`
- **Why it matters:** Float cast used (precision risk for finance)

### 275. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `56`
- **Evidence:** `$eff = $this->efficiency((float) $row->input_qty, (float) $row->output_qty);`
- **Why it matters:** Float cast used (precision risk for finance)

### 276. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `105`
- **Evidence:** `return (float) bcround($percentage, 2);`
- **Why it matters:** Float cast used (precision risk for finance)

### 277. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Float cast used (precision risk for finance)

### 278. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `81`
- **Evidence:** `return (float) $this->amount;`
- **Why it matters:** Float cast used (precision risk for finance)

### 279. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/admin/dashboard.blade.php`
- **Line:** `58`
- **Evidence:** `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Float cast used (precision risk for finance)

### 280. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 281. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 282. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 283. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 284. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 285. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 286. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 287. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 288. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 289. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 290. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 291. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 292. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Float cast used (precision risk for finance)

### 293. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 294. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 295. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 296. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float cast used (precision risk for finance)

### 297. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** Float cast used (precision risk for finance)

### 298. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Float cast used (precision risk for finance)

### 299. [MEDIUM] Float/double cast in finance/qty context (rounding drift)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** Float cast used (precision risk for finance)

### 300. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `346`
- **Evidence:** `return (float) ($query->selectRaw('SUM(quantity) as balance')`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 301. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `227`
- **Evidence:** `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 302. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `229`
- **Evidence:** `$tax = max(0, (float) ($validated['tax'] ?? 0));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 303. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Http/Middleware/EnforceDiscountLimit.php`
- **Line:** `43`
- **Evidence:** `$disc = (float) ($row['discount'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 304. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Http/Resources/CustomerResource.php`
- **Line:** `38`
- **Evidence:** `(float) ($this->balance ?? 0.0)`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 305. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `72`
- **Evidence:** `$gross = (float) $grossString;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 306. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Jobs/ClosePosDayJob.php`
- **Line:** `73`
- **Evidence:** `$paid = (float) $paidString;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 307. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Listeners/ApplyLateFee.php`
- **Line:** `43`
- **Evidence:** `$invoice->amount = (float) $newAmount;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 308. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Listeners/UpdateStockOnPurchase.php`
- **Line:** `27`
- **Evidence:** `$itemQty = (float) $item->quantity;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 309. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Listeners/UpdateStockOnSale.php`
- **Line:** `49`
- **Evidence:** `$baseQuantity = (float) $item->quantity * (float) $conversionFactor;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 310. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Accounting/JournalEntries/Form.php`
- **Line:** `144`
- **Evidence:** `'amount' => number_format((float) ltrim($difference, '-'), 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 311. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Admin/CurrencyRate/Form.php`
- **Line:** `51`
- **Evidence:** `$this->rate = (float) $rate->rate;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 312. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `67`
- **Evidence:** `$totalRevenue = (float) $ordersForStats->sum('total');`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 313. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `84`
- **Evidence:** `$sources[$source]['revenue'] += (float) $order->total;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 314. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Admin/Store/OrdersDashboard.php`
- **Line:** `139`
- **Evidence:** `$dayValues[] = (float) $items->sum('total');`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 315. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Hrm/Payroll/Run.php`
- **Line:** `98`
- **Evidence:** `$model->net = (float) $net;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 316. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Hrm/Reports/Dashboard.php`
- **Line:** `126`
- **Evidence:** `'total_net' => (float) $group->sum('net'),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 317. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Income/Form.php`
- **Line:** `102`
- **Evidence:** `$this->amount = (float) $income->amount;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 318. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `132`
- **Evidence:** `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 319. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `133`
- **Evidence:** `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 320. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `137`
- **Evidence:** `$this->cost = (float) ($product->cost ?: $product->standard_cost);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 321. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `171`
- **Evidence:** `'qty' => (float) $item->qty,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 322. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `173`
- **Evidence:** `'discount' => (float) ($item->discount ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 323. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `239`
- **Evidence:** `'unit_cost' => (float) ($product->cost ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 324. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `357`
- **Evidence:** `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 325. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `102`
- **Evidence:** `'max_qty' => (float) $item->qty,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 326. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `104`
- **Evidence:** `'cost' => (float) $item->unit_cost,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 327. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Purchases/Returns/Index.php`
- **Line:** `160`
- **Evidence:** `$qty = min((float) $it['qty'], (float) $pi->qty);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 328. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Livewire/Rental/Reports/Dashboard.php`
- **Line:** `69`
- **Evidence:** `$occupancyRate = $total > 0 ? (float) bcdiv(bcmul((string) $occupied, '100', 4), (string) $total, 1) : 0;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 329. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `123`
- **Evidence:** `$itemQuantity = (float) $item->quantity;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 330. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Models/BomItem.php`
- **Line:** `69`
- **Evidence:** `$baseQuantity = (float) $this->quantity;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 331. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Models/JournalEntry.php`
- **Line:** `101`
- **Evidence:** `return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 332. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Models/JournalEntry.php`
- **Line:** `106`
- **Evidence:** `return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 333. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Observers/ProductObserver.php`
- **Line:** `55`
- **Evidence:** `$product->cost = round((float) $product->cost, 2);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 334. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `141`
- **Evidence:** `$qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 335. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ImportService.php`
- **Line:** `568`
- **Evidence:** `'cost' => (float) ($data['cost'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 336. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `113`
- **Evidence:** `$product->default_price = (float) $price;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 337. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ProductService.php`
- **Line:** `118`
- **Evidence:** `$product->cost = (float) $cost;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 338. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `104`
- **Evidence:** `$purchaseQty = (float) $purchaseItem->quantity;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 339. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseReturnService.php`
- **Line:** `322`
- **Evidence:** `'qty' => (float) $item->qty_returned,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 340. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `77`
- **Evidence:** `$qty = (float) $it['qty'];`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 341. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `79`
- **Evidence:** `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 342. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `138`
- **Evidence:** `$p->subtotal = (float) bcround($subtotal, 2);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 343. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `284`
- **Evidence:** `if ($p->payment_status === 'paid' || (float) $p->paid_amount > 0) {`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 344. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/RentalService.php`
- **Line:** `271`
- **Evidence:** `$i->amount = (float) $newAmount;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 345. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `70`
- **Evidence:** `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 346. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `71`
- **Evidence:** `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 347. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `72`
- **Evidence:** `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 348. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `94`
- **Evidence:** `return $rows->map(fn ($r) => ['id' => $r->id, 'name' => $r->name, 'gross' => (float) $r->gross])->all();`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 349. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `192`
- **Evidence:** `'total_value' => $items->sum(fn ($p) => ((float) ($p->stock_quantity ?? 0)) * ((float) ($p->cost ?? $p->standard_cost ?? 0))),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 350. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `41`
- **Evidence:** `'total_expected_inflows' => (float) $expectedInflows->sum('amount'),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 351. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Reports/CashFlowForecastService.php`
- **Line:** `42`
- **Evidence:** `'total_expected_outflows' => (float) $expectedOutflows->sum('amount'),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 352. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `71`
- **Evidence:** `$requestedQty = (float) ($it['qty'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 353. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `104`
- **Evidence:** `$availableToReturn = max(0, (float) $si->quantity - $alreadyReturned);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 354. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `234`
- **Evidence:** `'amount' => (float) $refund,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 355. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `317`
- **Evidence:** `$currentReturnMap[$saleItemId] = ($currentReturnMap[$saleItemId] ?? 0) + (float) $item['qty'];`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 356. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `322`
- **Evidence:** `$soldQty = (float) $saleItem->quantity;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 357. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `92`
- **Evidence:** `$qtyToReturn = (float) ($itemData['qty'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 358. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `211`
- **Evidence:** `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 359. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `61`
- **Evidence:** `return (float) $query->selectRaw('COALESCE(SUM(quantity), 0) as stock')`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 360. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `131`
- **Evidence:** `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 361. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `105`
- **Evidence:** `$requestedQty = (float) ($itemData['qty'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 362. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `158`
- **Evidence:** `$qty = (float) Arr::get($item, 'qty', 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 363. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `164`
- **Evidence:** `$price = (float) Arr::get($item, 'price', 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 364. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `165`
- **Evidence:** `$discount = (float) Arr::get($item, 'discount', 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 365. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `255`
- **Evidence:** `$total = (float) ($order->total ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 366. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `256`
- **Evidence:** `$tax = (float) ($order->tax_total ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 367. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `258`
- **Evidence:** `$discount = (float) ($order->discount_total ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 368. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `320`
- **Evidence:** `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 369. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `410`
- **Evidence:** `'subtotal' => (float) ($data['subtotal_price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 370. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `458`
- **Evidence:** `'unit_price' => (float) ($lineItem['price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 371. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `461`
- **Evidence:** `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 372. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `488`
- **Evidence:** `'default_price' => (float) ($data['price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 373. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `581`
- **Evidence:** `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 374. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `584`
- **Evidence:** `'total_amount' => (float) ($data['total'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 375. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `632`
- **Evidence:** `'line_total' => (float) ($lineItem['total'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 376. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `756`
- **Evidence:** `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 377. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `757`
- **Evidence:** `'cost' => (float) ($data['cost'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 378. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `826`
- **Evidence:** `'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 379. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `827`
- **Evidence:** `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 380. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `828`
- **Evidence:** `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 381. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `829`
- **Evidence:** `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 382. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `856`
- **Evidence:** `'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 383. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `857`
- **Evidence:** `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 384. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `858`
- **Evidence:** `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 385. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `859`
- **Evidence:** `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 386. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `992`
- **Evidence:** `return (float) ($product->standard_cost ?? $product->cost ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 387. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `23`
- **Evidence:** `return (float) ($tax?->rate ?? 0.0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 388. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `51`
- **Evidence:** `$rate = (float) $tax->rate;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 389. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `98`
- **Evidence:** `return (float) bcdiv($total, '1', 4);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 390. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `130`
- **Evidence:** `$subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 391. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `142`
- **Evidence:** `'total_with_tax' => (float) bcadd((string) $subtotal, (string) $taxAmount, 4),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 392. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `175`
- **Evidence:** `$rate = (float) ($taxRateRules['rate'] ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 393. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `97`
- **Evidence:** `$cost = (float) ($product->standard_cost ?? 0);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 394. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `121`
- **Evidence:** `'price' => (float) $price,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 395. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `123`
- **Evidence:** `'profit_per_unit' => (float) bcsub($price, (string) $cost, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 396. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `144`
- **Evidence:** `'profit_per_unit' => (float) bcsub($suggestedPrice, (string) $cost, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 397. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `197`
- **Evidence:** `'price' => (float) $item->default_price,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 398. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `245`
- **Evidence:** `'price' => (float) $product->default_price,`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 399. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `106`
- **Evidence:** `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 400. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `117`
- **Evidence:** `'subtotal' => number_format((float) $sale->sub_total, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 401. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `118`
- **Evidence:** `'tax' => number_format((float) $sale->tax_total, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 402. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `119`
- **Evidence:** `'discount' => number_format((float) $sale->discount_total, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 403. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `120`
- **Evidence:** `'total' => number_format((float) $sale->grand_total, 2),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 404. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `83`
- **Evidence:** `'qty' => (float) ($payload['qty'] ?? 0),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 405. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 406. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `81`
- **Evidence:** `return (float) $this->amount;`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 407. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/admin/dashboard.blade.php`
- **Line:** `58`
- **Evidence:** `'data' => $salesSeries->pluck('total')->map(fn ($v) => (float) $v)->toArray(),`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 408. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 409. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 410. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 411. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 412. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 413. [MEDIUM] Float cast/format used for money/qty (rounding drift risk)
- **Rule ID:** `FLOAT_FINANCE`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** Float usage in finance-related calculation can cause rounding drift

### 414. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Livewire/Accounting/JournalEntries/Form.php`
- **Line:** `144`
- **Evidence:** `'amount' => number_format((float) ltrim($difference, '-'), 2),`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 415. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Models/Traits/CommonQueryScopes.php`
- **Line:** `192`
- **Evidence:** `return number_format((float) $value, 2);`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 416. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `106`
- **Evidence:** `return "• {$item->product->name} x{$item->qty} = ".number_format((float) $item->line_total, 2);`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 417. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `117`
- **Evidence:** `'subtotal' => number_format((float) $sale->sub_total, 2),`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 418. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `118`
- **Evidence:** `'tax' => number_format((float) $sale->tax_total, 2),`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 419. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `119`
- **Evidence:** `'discount' => number_format((float) $sale->discount_total, 2),`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 420. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/Services/WhatsAppService.php`
- **Line:** `120`
- **Evidence:** `'total' => number_format((float) $sale->grand_total, 2),`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 421. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `app/ValueObjects/Money.php`
- **Line:** `73`
- **Evidence:** `return number_format((float) $this->amount, $decimals).' '.$this->currency;`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 422. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/employees/index.blade.php`
- **Line:** `198`
- **Evidence:** `{{ number_format((float) $employee->salary, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 423. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `86`
- **Evidence:** `{{ number_format((float) $row->basic, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 424. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `89`
- **Evidence:** `{{ number_format((float) $row->allowances, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 425. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `92`
- **Evidence:** `{{ number_format((float) $row->deductions, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 426. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/hrm/payroll/index.blade.php`
- **Line:** `95`
- **Evidence:** `{{ number_format((float) $row->net, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 427. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/bills-of-materials/index.blade.php`
- **Line:** `146`
- **Evidence:** `<td>{{ number_format((float)$bom->quantity, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 428. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `151`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_planned, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 429. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/production-orders/index.blade.php`
- **Line:** `152`
- **Evidence:** `<td>{{ number_format((float)$order->quantity_produced, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 430. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `147`
- **Evidence:** `<td>{{ number_format((float)$workCenter->capacity_per_hour, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 431. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/manufacturing/work-centers/index.blade.php`
- **Line:** `148`
- **Evidence:** `<td>{{ number_format((float)$workCenter->cost_per_hour, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 432. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-orange-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 433. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$purchase->grand_total, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 434. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/purchases/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedPurchase->grand_total, 2) }}</p>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 435. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/contracts/index.blade.php`
- **Line:** `96`
- **Evidence:** `{{ number_format((float) $row->rent, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 436. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `84`
- **Evidence:** `{{ number_format((float) $unit->rent, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 437. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/rental/units/index.blade.php`
- **Line:** `87`
- **Evidence:** `{{ number_format((float) $unit->deposit, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 438. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `62`
- **Evidence:** `<td class="font-mono text-red-600">{{ number_format((float)$return->total, 2) }}</td>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 439. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `111`
- **Evidence:** `{{ number_format((float)$sale->grand_total, 2) }}`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 440. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/sales/returns/index.blade.php`
- **Line:** `120`
- **Evidence:** `<p class="text-sm"><strong>{{ __('Total') }}:</strong> {{ number_format((float)$selectedSale->grand_total, 2) }}</p>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 441. [MEDIUM] number_format((float)...) used for money (rounding drift)
- **Rule ID:** `NUMBER_FORMAT_FLOAT`
- **File:** `resources/views/livewire/shared/dynamic-table.blade.php`
- **Line:** `226`
- **Evidence:** `<span class="font-medium">{{ $currency }}{{ number_format((float)$value, 2) }}</span>`
- **Why it matters:** number_format((float)...) used for money (rounding drift)

### 442. [HIGH] orderByRaw contains interpolated variable (SQL injection risk)
- **Rule ID:** `ORDERBY_RAW_INTERPOLATION`
- **File:** `app/Services/WorkflowAutomationService.php`
- **Line:** `189`
- **Evidence:** `->orderByRaw("(COALESCE(reorder_point, min_stock, 0) - ({$stockSubquery})) DESC")`
- **Why it matters:** orderByRaw contains interpolated variable (SQL injection risk)

### 443. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/InventoryController.php`
- **Line:** `346`
- **Evidence:** `return (float) ($query->selectRaw('SUM(quantity) as balance')`
- **Why it matters:** Float cast used (precision risk for finance)

### 444. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `229`
- **Evidence:** `$tax = max(0, (float) ($validated['tax'] ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 445. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/CustomerResource.php`
- **Line:** `26`
- **Evidence:** `(float) ($this->credit_limit ?? 0.0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 446. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/CustomerResource.php`
- **Line:** `38`
- **Evidence:** `(float) ($this->balance ?? 0.0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 447. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/CustomerResource.php`
- **Line:** `50`
- **Evidence:** `(float) ($this->total_purchases ?? 0.0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 448. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `25`
- **Evidence:** `'sub_total' => (float) ($this->sub_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 449. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `26`
- **Evidence:** `'tax_total' => (float) ($this->tax_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 450. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `27`
- **Evidence:** `'discount_total' => (float) ($this->discount_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 451. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `28`
- **Evidence:** `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 452. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `29`
- **Evidence:** `'grand_total' => (float) ($this->grand_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 453. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `30`
- **Evidence:** `'paid_total' => (float) ($this->paid_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 454. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/PurchaseResource.php`
- **Line:** `31`
- **Evidence:** `'due_total' => (float) ($this->due_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 455. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Customers/Form.php`
- **Line:** `89`
- **Evidence:** `$this->credit_limit = (float) ($customer->credit_limit ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 456. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Projects/TimeLogs.php`
- **Line:** `206`
- **Evidence:** `'total_hours' => (float) ($stats->total_hours ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 457. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Projects/TimeLogs.php`
- **Line:** `209`
- **Evidence:** `'total_cost' => (float) ($stats->total_cost ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 458. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `163`
- **Evidence:** `$this->discount_total = (float) ($purchase->discount_total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 459. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `164`
- **Evidence:** `$this->shipping_total = (float) ($purchase->shipping_total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 460. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `239`
- **Evidence:** `'unit_cost' => (float) ($product->cost ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 461. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `146`
- **Evidence:** `$costPerHour = (float) ($operation->workCenter->cost_per_hour ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 462. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `148`
- **Evidence:** `return $durationHours * $costPerHour + (float) ($operation->labor_cost ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 463. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/FixedAsset.php`
- **Line:** `175`
- **Evidence:** `$purchaseCost = (float) ($this->purchase_cost ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 464. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/GRNItem.php`
- **Line:** `85`
- **Evidence:** `$expectedQty = (float) ($this->expected_quantity ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 465. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/JournalEntry.php`
- **Line:** `101`
- **Evidence:** `return (float) ($this->attributes['total_debit'] ?? $this->lines()->sum('debit'));`
- **Why it matters:** Float cast used (precision risk for finance)

### 466. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/JournalEntry.php`
- **Line:** `106`
- **Evidence:** `return (float) ($this->attributes['total_credit'] ?? $this->lines()->sum('credit'));`
- **Why it matters:** Float cast used (precision risk for finance)

### 467. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Project.php`
- **Line:** `208`
- **Evidence:** `return (float) ($timeLogsCost + $expensesCost);`
- **Why it matters:** Float cast used (precision risk for finance)

### 468. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Repositories/StockMovementRepository.php`
- **Line:** `141`
- **Evidence:** `$qty = abs((float) ($data['qty'] ?? $data['quantity'] ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 469. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ImportService.php`
- **Line:** `567`
- **Evidence:** `'default_price' => (float) ($data['default_price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 470. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ImportService.php`
- **Line:** `568`
- **Evidence:** `'cost' => (float) ($data['cost'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 471. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ImportService.php`
- **Line:** `587`
- **Evidence:** `'credit_limit' => (float) ($data['credit_limit'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 472. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `79`
- **Evidence:** `$unitPrice = (float) ($it['unit_price'] ?? $it['price'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 473. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `135`
- **Evidence:** `$shippingAmount = (float) ($payload['shipping_amount'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 474. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `70`
- **Evidence:** `'sales' => ['total' => (float) ($sales->total ?? 0), 'paid' => (float) ($sales->paid ?? 0)],`
- **Why it matters:** Float cast used (precision risk for finance)

### 475. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `71`
- **Evidence:** `'purchases' => ['total' => (float) ($purchases->total ?? 0), 'paid' => (float) ($purchases->paid ?? 0)],`
- **Why it matters:** Float cast used (precision risk for finance)

### 476. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `72`
- **Evidence:** `'pnl' => (float) ($sales->total ?? 0) - (float) ($purchases->total ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 477. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `192`
- **Evidence:** `'total_value' => $items->sum(fn ($p) => ((float) ($p->stock_quantity ?? 0)) * ((float) ($p->cost ?? $p->standard_cost ?? 0))),`
- **Why it matters:** Float cast used (precision risk for finance)

### 478. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/ReportService.php`
- **Line:** `193`
- **Evidence:** `'total_cost' => $items->sum(fn ($p) => (float) ($p->standard_cost ?? 0)),`
- **Why it matters:** Float cast used (precision risk for finance)

### 479. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SaleService.php`
- **Line:** `71`
- **Evidence:** `$requestedQty = (float) ($it['qty'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 480. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `92`
- **Evidence:** `$qtyToReturn = (float) ($itemData['qty'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 481. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/SalesReturnService.php`
- **Line:** `211`
- **Evidence:** `$requestedAmount = (float) ($validated['amount'] ?? $return->refund_amount);`
- **Why it matters:** Float cast used (precision risk for finance)

### 482. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `105`
- **Evidence:** `$requestedQty = (float) ($itemData['qty'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 483. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `338`
- **Evidence:** `$qtyReceived = (float) ($itemData['qty_received'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 484. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `339`
- **Evidence:** `$qtyDamaged = (float) ($itemData['qty_damaged'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 485. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `378`
- **Evidence:** `$qtyReceived = (float) ($itemReceivingData['qty_received'] ?? $item->qty_shipped);`
- **Why it matters:** Float cast used (precision risk for finance)

### 486. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockTransferService.php`
- **Line:** `379`
- **Evidence:** `$qtyDamaged = (float) ($itemReceivingData['qty_damaged'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 487. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `255`
- **Evidence:** `$total = (float) ($order->total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 488. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `256`
- **Evidence:** `$tax = (float) ($order->tax_total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 489. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `257`
- **Evidence:** `$shipping = (float) ($order->shipping_total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 490. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreOrderToSaleService.php`
- **Line:** `258`
- **Evidence:** `$discount = (float) ($order->discount_total ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 491. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `320`
- **Evidence:** `'default_price' => (float) ($data['variants'][0]['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 492. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `410`
- **Evidence:** `'subtotal' => (float) ($data['subtotal_price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 493. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `411`
- **Evidence:** `'tax_amount' => (float) ($data['total_tax'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 494. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `412`
- **Evidence:** `'discount_amount' => (float) ($data['total_discounts'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 495. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `413`
- **Evidence:** `'total_amount' => (float) ($data['total_price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 496. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `458`
- **Evidence:** `'unit_price' => (float) ($lineItem['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 497. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `460`
- **Evidence:** `'discount_amount' => (float) ($lineItem['total_discount'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 498. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `461`
- **Evidence:** `'line_total' => (float) ($lineItem['quantity'] ?? 1) * (float) ($lineItem['price'] ?? 0) - (float) ($lineItem['total_discount'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 499. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `488`
- **Evidence:** `'default_price' => (float) ($data['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 500. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `581`
- **Evidence:** `'subtotal' => (float) ($data['total'] ?? 0) - (float) ($data['total_tax'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 501. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `582`
- **Evidence:** `'tax_amount' => (float) ($data['total_tax'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 502. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `583`
- **Evidence:** `'discount_amount' => (float) ($data['discount_total'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 503. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `584`
- **Evidence:** `'total_amount' => (float) ($data['total'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 504. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `629`
- **Evidence:** `'unit_price' => (float) ($lineItem['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 505. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `632`
- **Evidence:** `'line_total' => (float) ($lineItem['total'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 506. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `756`
- **Evidence:** `'default_price' => (float) ($data['default_price'] ?? $data['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 507. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `757`
- **Evidence:** `'cost' => (float) ($data['cost'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 508. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `826`
- **Evidence:** `'subtotal' => (float) ($data['sub_total'] ?? $data['subtotal'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 509. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `827`
- **Evidence:** `'tax_amount' => (float) ($data['tax_total'] ?? $data['tax'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 510. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `828`
- **Evidence:** `'discount_amount' => (float) ($data['discount_total'] ?? $data['discount'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 511. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `829`
- **Evidence:** `'total_amount' => (float) ($data['grand_total'] ?? $data['total'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 512. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `856`
- **Evidence:** `'quantity' => (float) ($lineItem['qty'] ?? $lineItem['quantity'] ?? 1),`
- **Why it matters:** Float cast used (precision risk for finance)

### 513. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `857`
- **Evidence:** `'unit_price' => (float) ($lineItem['unit_price'] ?? $lineItem['price'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 514. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `858`
- **Evidence:** `'discount_amount' => (float) ($lineItem['discount'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 515. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `859`
- **Evidence:** `'line_total' => (float) ($lineItem['line_total'] ?? $lineItem['total'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 516. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/Store/StoreSyncService.php`
- **Line:** `992`
- **Evidence:** `return (float) ($product->standard_cost ?? $product->cost ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 517. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `130`
- **Evidence:** `$subtotal = (float) ($item['subtotal'] ?? $item['line_total'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 518. [MEDIUM] Float usage in finance-related calculation can cause rounding drift
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `293`
- **Evidence:** `return (float) ($totalStock ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

---

## New bugs detected in v41

### 1. [HIGH] DB::raw() argument is variable (must be strict whitelist)
- **Rule ID:** `SQL_DBRAW_VAR`
- **File:** `app/Support/ValidatedSqlExpression.php`
- **Line:** `90`
- **Evidence:** `return DB::raw($this->expression);`
- **Why it matters:** DB::raw() argument is variable (must be strict whitelist)

### 2. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Helpers/helpers.php`
- **Line:** `497`
- **Evidence:** `return (float) $rounded;`
- **Why it matters:** Float cast used (precision risk for finance)

### 3. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Admin/Reports/InventoryReportsExportController.php`
- **Line:** `83`
- **Evidence:** `$stock = (float) ($stockData[$product->id] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 4. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/StoreIntegrationController.php`
- **Line:** `116`
- **Evidence:** `'current_stock' => (float) ($product->current_stock ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 5. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `227`
- **Evidence:** `$orderDiscount = max(0, (float) ($validated['discount'] ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 6. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/OrdersController.php`
- **Line:** `230`
- **Evidence:** `$shipping = max(0, (float) ($validated['shipping'] ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 7. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Controllers/Api/V1/POSController.php`
- **Line:** `181`
- **Evidence:** `(float) ($request->input('opening_cash') ?? 0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 8. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Middleware/EnforceDiscountLimit.php`
- **Line:** `43`
- **Evidence:** `$disc = (float) ($row['discount'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 9. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Middleware/EnforceDiscountLimit.php`
- **Line:** `50`
- **Evidence:** `$invDisc = (float) ($payload['invoice_discount'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 10. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/CustomerResource.php`
- **Line:** `30`
- **Evidence:** `(float) ($this->discount_percentage ?? 0.0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 11. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `31`
- **Evidence:** `'sub_total' => (float) ($this->sub_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 12. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `32`
- **Evidence:** `'tax_total' => (float) ($this->tax_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 13. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `33`
- **Evidence:** `'discount_total' => (float) ($this->discount_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 14. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `34`
- **Evidence:** `'shipping_total' => (float) ($this->shipping_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 15. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `35`
- **Evidence:** `'grand_total' => (float) ($this->grand_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 16. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `36`
- **Evidence:** `'paid_total' => (float) ($this->paid_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 17. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SaleResource.php`
- **Line:** `37`
- **Evidence:** `'due_total' => (float) ($this->due_total ?? 0.0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 18. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Http/Resources/SupplierResource.php`
- **Line:** `37`
- **Evidence:** `(float) ($this->minimum_order_value ?? 0.0)`
- **Why it matters:** Float cast used (precision risk for finance)

### 19. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/PurchasesSettings.php`
- **Line:** `58`
- **Evidence:** `$this->purchase_approval_threshold = (float) ($settings['purchases.approval_threshold'] ?? 10000);`
- **Why it matters:** Float cast used (precision risk for finance)

### 20. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `256`
- **Evidence:** `$this->hrm_working_hours_per_day = (float) ($settings['hrm.working_hours_per_day'] ?? 8.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 21. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `259`
- **Evidence:** `$this->hrm_transport_allowance_value = (float) ($settings['hrm.transport_allowance_value'] ?? 10.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 22. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `261`
- **Evidence:** `$this->hrm_housing_allowance_value = (float) ($settings['hrm.housing_allowance_value'] ?? 0.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 23. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `262`
- **Evidence:** `$this->hrm_meal_allowance = (float) ($settings['hrm.meal_allowance'] ?? 0.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 24. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `263`
- **Evidence:** `$this->hrm_health_insurance_deduction = (float) ($settings['hrm.health_insurance_deduction'] ?? 0.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 25. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Admin/Settings/UnifiedSettings.php`
- **Line:** `268`
- **Evidence:** `$this->rental_penalty_value = (float) ($settings['rental.penalty_value'] ?? 5.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 26. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Concerns/LoadsDashboardData.php`
- **Line:** `228`
- **Evidence:** `$data[] = (float) ($salesByDate[$dateKey] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 27. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Customers/Form.php`
- **Line:** `90`
- **Evidence:** `$this->discount_percentage = (float) ($customer->discount_percentage ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 28. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Hrm/Employees/Form.php`
- **Line:** `93`
- **Evidence:** `$this->form['salary'] = (float) ($employeeModel->salary ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 29. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `132`
- **Evidence:** `$this->form['price'] = (float) ($p->default_price ?? $p->price ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 30. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `133`
- **Evidence:** `$this->form['cost'] = (float) ($p->standard_cost ?? $p->cost ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 31. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `142`
- **Evidence:** `$this->form['min_stock'] = (float) ($p->min_stock ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 32. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Products/Form.php`
- **Line:** `144`
- **Evidence:** `$this->form['reorder_point'] = (float) ($p->reorder_point ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 33. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Inventory/Services/Form.php`
- **Line:** `137`
- **Evidence:** `$this->cost = (float) ($product->cost ?: $product->standard_cost);`
- **Why it matters:** Float cast used (precision risk for finance)

### 34. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Projects/TimeLogs.php`
- **Line:** `207`
- **Evidence:** `'billable_hours' => (float) ($stats->billable_hours ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 35. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Projects/TimeLogs.php`
- **Line:** `208`
- **Evidence:** `'non_billable_hours' => (float) ($stats->non_billable_hours ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 36. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `173`
- **Evidence:** `'discount' => (float) ($item->discount ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 37. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `174`
- **Evidence:** `'tax_rate' => (float) ($item->tax_rate ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 38. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Purchases/Form.php`
- **Line:** `357`
- **Evidence:** `$discountAmount = max(0, (float) ($item['discount'] ?? 0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 39. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Suppliers/Form.php`
- **Line:** `115`
- **Evidence:** `$this->minimum_order_value = (float) ($supplier->minimum_order_value ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 40. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Suppliers/Form.php`
- **Line:** `117`
- **Evidence:** `$this->quality_rating = (float) ($supplier->quality_rating ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 41. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Suppliers/Form.php`
- **Line:** `118`
- **Evidence:** `$this->delivery_rating = (float) ($supplier->delivery_rating ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 42. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Livewire/Suppliers/Form.php`
- **Line:** `119`
- **Evidence:** `$this->service_rating = (float) ($supplier->service_rating ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 43. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `124`
- **Evidence:** `$scrapFactor = 1 + ((float) ($item->scrap_percentage ?? 0) / 100);`
- **Why it matters:** Float cast used (precision risk for finance)

### 44. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `130`
- **Evidence:** `$yieldFactor = (float) ($this->yield_percentage ?? 100) / 100;`
- **Why it matters:** Float cast used (precision risk for finance)

### 45. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BillOfMaterial.php`
- **Line:** `145`
- **Evidence:** `$durationHours = (float) ($operation->duration_minutes ?? 0) / 60;`
- **Why it matters:** Float cast used (precision risk for finance)

### 46. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/BomItem.php`
- **Line:** `70`
- **Evidence:** `$scrapFactor = 1 + ((float) ($this->scrap_percentage ?? 0) / 100);`
- **Why it matters:** Float cast used (precision risk for finance)

### 47. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/FixedAsset.php`
- **Line:** `156`
- **Evidence:** `$currentValue = (float) ($this->current_value ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 48. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/FixedAsset.php`
- **Line:** `157`
- **Evidence:** `$salvageValue = (float) ($this->salvage_value ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 49. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/FixedAsset.php`
- **Line:** `176`
- **Evidence:** `$salvageValue = (float) ($this->salvage_value ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 50. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductionOrder.php`
- **Line:** `175`
- **Evidence:** `$plannedQty = (float) ($this->planned_quantity ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 51. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProductionOrder.php`
- **Line:** `181`
- **Evidence:** `return ((float) ($this->produced_quantity ?? 0) / $plannedQty) * 100;`
- **Why it matters:** Float cast used (precision risk for finance)

### 52. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/ProjectTimeLog.php`
- **Line:** `110`
- **Evidence:** `return (float) ($this->hours * $this->hourly_rate);`
- **Why it matters:** Float cast used (precision risk for finance)

### 53. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Models/Supplier.php`
- **Line:** `129`
- **Evidence:** `return (float) ($this->rating ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 54. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/InventoryService.php`
- **Line:** `48`
- **Evidence:** `return (float) ($perWarehouse->get($warehouseId, 0.0));`
- **Why it matters:** Float cast used (precision risk for finance)

### 55. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `94`
- **Evidence:** `$discountPercent = (float) ($it['discount_percent'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 56. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `101`
- **Evidence:** `$taxPercent = (float) ($it['tax_percent'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 57. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/PurchaseService.php`
- **Line:** `102`
- **Evidence:** `$lineTax = (float) ($it['tax_amount'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 58. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/StockService.php`
- **Line:** `130`
- **Evidence:** `return (float) ($query->selectRaw('SUM(quantity * COALESCE(unit_cost, 0)) as value')`
- **Why it matters:** Float cast used (precision risk for finance)

### 59. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `23`
- **Evidence:** `return (float) ($tax?->rate ?? 0.0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 60. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/TaxService.php`
- **Line:** `175`
- **Evidence:** `$rate = (float) ($taxRateRules['rate'] ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 61. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `98`
- **Evidence:** `$cost = (float) ($product->standard_cost ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 62. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/UX/SmartSuggestionsService.php`
- **Line:** `129`
- **Evidence:** `$currentPrice = (float) ($product->default_price ?? 0);`
- **Why it matters:** Float cast used (precision risk for finance)

### 63. [MEDIUM] Float cast used (precision risk for finance)
- **Rule ID:** `FLOAT_CAST_FINANCE`
- **File:** `app/Services/WoodService.php`
- **Line:** `83`
- **Evidence:** `'qty' => (float) ($payload['qty'] ?? 0),`
- **Why it matters:** Float cast used (precision risk for finance)

### 64. [MEDIUM] Blade outputs unescaped content via {!! !!} (XSS risk)
- **Rule ID:** `BLADE_UNESCAPED`
- **File:** `resources/views/livewire/auth/two-factor-setup.blade.php`
- **Line:** `67`
- **Evidence:** `{!! $qrCodeSvg !!}`
- **Why it matters:** Blade outputs unescaped content via {!! !!} (XSS risk)

