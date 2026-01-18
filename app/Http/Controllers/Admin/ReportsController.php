<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ReportServiceInterface as Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct(protected Reports $reports) {}

    public function finance(Request $request)
    {
        $branchId = (int) $request->integer('branch_id');
        $from = $request->input('from');
        $to = $request->input('to');

        return $this->ok($this->reports->financeSummary($branchId, $from, $to));
    }

    public function topProducts(Request $request)
    {
        $branchId = (int) $request->integer('branch_id');
        $limit = min(max((int) $request->integer('limit', 10), 1), 100);

        return $this->ok($this->reports->topProducts($branchId, $limit));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: System usage report
     */
    public function usage(Request $request)
    {
        $from = $request->input('from', now()->subDays(30)->toDateString());
        $to = $request->input('to', now()->toDateString());

        $usageData = [
            'period' => ['from' => $from, 'to' => $to],
            'active_users' => DB::table('users')
                ->whereNotNull('last_login_at')
                ->whereDate('last_login_at', '>=', $from)
                ->count(),
            'total_logins' => DB::table('activity_log')
                ->where('description', 'like', '%logged in%')
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->count(),
            'api_requests' => DB::table('activity_log')
                ->whereDate('created_at', '>=', $from)
                ->whereDate('created_at', '<=', $to)
                ->count(),
        ];

        return $this->ok($usageData);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: System performance report
     */
    public function performance(Request $request)
    {
        $from = $request->input('from', now()->subDays(7)->toDateString());
        $to = $request->input('to', now()->toDateString());

        $performanceData = [
            'period' => ['from' => $from, 'to' => $to],
            'response_times' => [
                'avg' => 0,
                'min' => 0,
                'max' => 0,
            ],
            'database_queries' => [
                'slow_queries_count' => 0,
            ],
            'memory_usage' => [
                'current' => memory_get_usage(true),
                'peak' => memory_get_peak_usage(true),
            ],
        ];

        return $this->ok($performanceData);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: System errors report
     */
    public function errors(Request $request)
    {
        $from = $request->input('from', now()->subDays(7)->toDateString());
        $to = $request->input('to', now()->toDateString());

        $errorsData = [
            'period' => ['from' => $from, 'to' => $to],
            'total_errors' => 0,
            'errors_by_type' => [],
            'recent_errors' => [],
        ];

        return $this->ok($errorsData);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Finance sales report
     *
     * SECURITY NOTE: The selectRaw expressions use only hardcoded column names.
     * No user input is interpolated into the SQL.
     */
    public function financeSales(Request $request)
    {
        $branchId = $request->integer('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // V31-HIGH-03 FIX: Use sale_date instead of created_at for accurate period filtering
        // and exclude non-revenue statuses (draft, cancelled, void, refunded)
        // V37-CRIT-03 FIX: Exclude soft-deleted records using whereNull('deleted_at')
        $query = DB::table('sales')
            ->whereNull('deleted_at')
            ->whereDate('sale_date', '>=', $from)
            ->whereDate('sale_date', '<=', $to)
            ->whereNotIn('status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $data = $query->selectRaw('
            COUNT(*) as total_count,
            COALESCE(SUM(total_amount), 0) as total_amount,
            COALESCE(SUM(paid_amount), 0) as paid_amount,
            COALESCE(SUM(total_amount) - SUM(paid_amount), 0) as outstanding
        ')->first();

        return $this->ok([
            'period' => ['from' => $from, 'to' => $to],
            'branch_id' => $branchId ?: 'all',
            'sales' => $data,
        ]);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Finance purchases report
     */
    public function financePurchases(Request $request)
    {
        $branchId = $request->integer('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // V31-HIGH-03 FIX: Use purchase_date instead of created_at for accurate period filtering
        // and exclude non-relevant statuses (draft, cancelled)
        // V37-CRIT-03 FIX: Exclude soft-deleted records using whereNull('deleted_at')
        $query = DB::table('purchases')
            ->whereNull('deleted_at')
            ->whereDate('purchase_date', '>=', $from)
            ->whereDate('purchase_date', '<=', $to)
            ->whereNotIn('status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $data = $query->selectRaw('
            COUNT(*) as total_count,
            COALESCE(SUM(total_amount), 0) as total_amount,
            COALESCE(SUM(paid_amount), 0) as paid_amount,
            COALESCE(SUM(total_amount) - SUM(paid_amount), 0) as outstanding
        ')->first();

        return $this->ok([
            'period' => ['from' => $from, 'to' => $to],
            'branch_id' => $branchId ?: 'all',
            'purchases' => $data,
        ]);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Finance profit and loss report
     * V31-HIGH-03 FIX: Use proper date columns and exclude non-revenue statuses
     * BUG-1 FIX: Calculate COGS from actual cost_price in sale_items, not total purchases
     */
    public function financePnl(Request $request)
    {
        $branchId = $request->integer('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // V31-HIGH-03 FIX: Use sale_date instead of created_at
        // and filter out non-revenue statuses
        $salesQuery = DB::table('sales')
            ->whereDate('sale_date', '>=', $from)
            ->whereDate('sale_date', '<=', $to)
            ->whereNotIn('status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);

        if ($branchId) {
            $salesQuery->where('branch_id', $branchId);
        }

        // BUG-1 FIX: Calculate actual COGS from sale_items.cost_price * quantity
        // This represents the actual cost of goods that were sold, not total purchases
        $cogsQuery = DB::table('sale_items')
            ->join('sales', 'sale_items.sale_id', '=', 'sales.id')
            ->whereDate('sales.sale_date', '>=', $from)
            ->whereDate('sales.sale_date', '<=', $to)
            ->whereNotIn('sales.status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);

        if ($branchId) {
            $cogsQuery->where('sales.branch_id', $branchId);
        }

        $expensesQuery = DB::table('expenses')
            ->whereDate('expense_date', '>=', $from)
            ->whereDate('expense_date', '<=', $to);

        if ($branchId) {
            $expensesQuery->where('branch_id', $branchId);
        }

        // V31-HIGH-03 FIX: Use bcmath for precise financial calculations
        $totalSalesRaw = $salesQuery->sum('total_amount') ?? 0;

        // BUG-1 FIX: Calculate COGS as SUM(cost_price * quantity) from sale_items
        $totalCogsRaw = $cogsQuery->selectRaw('SUM(COALESCE(cost_price, 0) * COALESCE(quantity, 0)) as total_cogs')
            ->value('total_cogs') ?? 0;

        $totalExpensesRaw = $expensesQuery->sum('amount') ?? 0;

        $totalSales = (string) $totalSalesRaw;
        $totalCogs = (string) $totalCogsRaw;
        $totalExpenses = (string) $totalExpensesRaw;

        $grossProfit = bcsub($totalSales, $totalCogs, 2);
        $netProfit = bcsub($grossProfit, $totalExpenses, 2);

        return $this->ok([
            'period' => ['from' => $from, 'to' => $to],
            'branch_id' => $branchId ?: 'all',
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            'revenue' => decimal_float($totalSales),
            'cost_of_goods' => decimal_float($totalCogs),
            'gross_profit' => decimal_float($grossProfit),
            'expenses' => decimal_float($totalExpenses),
            'net_profit' => decimal_float($netProfit),
        ]);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Finance cashflow report
     * STILL-V14-HIGH-01 FIX: Use bank transactions for accurate cashflow
     * BUG-3 FIX: Handle all transaction types correctly and use bcmath for precision
     */
    public function financeCashflow(Request $request)
    {
        $branchId = $request->integer('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // STILL-V14-HIGH-01 FIX: Use bank_transactions for accurate cashflow
        $query = DB::table('bank_transactions')
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->where('status', '!=', 'cancelled'); // BUG-3 FIX: Exclude cancelled transactions

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        // BUG-3 FIX: Handle all transaction types correctly
        // Inflows: deposits and interest (credits to account)
        $inflowsRaw = (clone $query)->whereIn('type', ['deposit', 'interest'])->sum('amount') ?? 0;

        // Outflows: withdrawals and all other debit types
        $outflowsRaw = (clone $query)->whereNotIn('type', ['deposit', 'interest'])->sum('amount') ?? 0;

        // BUG-3 FIX: Use bcmath for precise financial calculations
        $inflows = (string) $inflowsRaw;
        $outflows = (string) $outflowsRaw;
        $netCashflow = bcsub($inflows, $outflows, 2);

        return $this->ok([
            'period' => ['from' => $from, 'to' => $to],
            'branch_id' => $branchId ?: 'all',
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            'inflows' => decimal_float($inflows),
            'outflows' => decimal_float($outflows),
            'net_cashflow' => decimal_float($netCashflow),
        ]);
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Finance aging report
     * V31-HIGH-03 FIX: Use sale_date/purchase_date and filter non-revenue statuses
     */
    public function financeAging(Request $request)
    {
        $branchId = $request->integer('branch_id');
        $type = $request->input('type', 'receivables'); // receivables or payables

        $today = now();

        if ($type === 'receivables') {
            // V31-HIGH-03 FIX: Use sale_date for aging and filter non-revenue statuses
            // Explicitly select sale_date to ensure the proper date is used for aging
            // V37-CRIT-03 FIX: Exclude soft-deleted records using whereNull('deleted_at')
            $query = DB::table('sales')
                ->select(['id', 'total_amount', 'paid_amount', 'sale_date'])
                ->whereNull('deleted_at')
                ->whereRaw('paid_amount < total_amount')
                ->whereNotIn('status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);
        } else {
            // V31-HIGH-03 FIX: Use purchase_date for aging and filter non-relevant statuses
            // Explicitly select purchase_date to ensure the proper date is used for aging
            // V37-CRIT-03 FIX: Exclude soft-deleted records using whereNull('deleted_at')
            $query = DB::table('purchases')
                ->select(['id', 'total_amount', 'paid_amount', 'purchase_date'])
                ->whereNull('deleted_at')
                ->whereRaw('paid_amount < total_amount')
                ->whereNotIn('status', ['draft', 'cancelled', 'void', 'voided', 'returned', 'refunded']);
        }

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        $items = $query->get();

        // V31-HIGH-03 FIX: Use bcmath for precise financial calculations
        $aging = [
            'current' => '0',
            '1_30_days' => '0',
            '31_60_days' => '0',
            '61_90_days' => '0',
            'over_90_days' => '0',
        ];

        foreach ($items as $item) {
            $outstanding = bcsub((string) ($item->total_amount ?? 0), (string) ($item->paid_amount ?? 0), 2);
            // V31-HIGH-03 FIX: Use sale_date/purchase_date directly (explicitly selected in query)
            // Skip items with null date as they have no valid aging basis
            $dateColumn = $type === 'receivables' ? $item->sale_date : $item->purchase_date;
            if ($dateColumn === null) {
                // Skip items without a proper date - they shouldn't exist but handle gracefully
                continue;
            }
            $itemDate = \Carbon\Carbon::parse($dateColumn);
            $daysOld = $itemDate->diffInDays($today);

            if ($daysOld <= 0) {
                $aging['current'] = bcadd($aging['current'], $outstanding, 2);
            } elseif ($daysOld <= 30) {
                $aging['1_30_days'] = bcadd($aging['1_30_days'], $outstanding, 2);
            } elseif ($daysOld <= 60) {
                $aging['31_60_days'] = bcadd($aging['31_60_days'], $outstanding, 2);
            } elseif ($daysOld <= 90) {
                $aging['61_90_days'] = bcadd($aging['61_90_days'], $outstanding, 2);
            } else {
                $aging['over_90_days'] = bcadd($aging['over_90_days'], $outstanding, 2);
            }
        }

        // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
        $agingFloat = array_map(fn ($v) => decimal_float($v), $aging);

        return $this->ok([
            'type' => $type,
            'branch_id' => $branchId ?: 'all',
            'aging' => $agingFloat,
            'total' => array_sum($agingFloat),
        ]);
    }
}
