<?php

declare(strict_types=1);

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Services\Contracts\ReportServiceInterface as Reports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct(protected Reports $reports) {}

    public function branchSummary(Request $request)
    {
        $branchId = (int) $request->attributes->get('branch_id');

        return $this->ok($this->reports->financeSummary($branchId, $request->input('from'), $request->input('to')));
    }

    public function moduleSummary()
    {
        return $this->ok(['modules' => (array) config('modules.available')]);
    }

    public function topProducts(Request $request)
    {
        $branchId = (int) $request->attributes->get('branch_id');
        $limit = min(max((int) $request->integer('limit', 10), 1), 100);

        return $this->ok($this->reports->topProducts($branchId, $limit));
    }

    public function stockAging(Request $request)
    {
        $branchId = (int) $request->attributes->get('branch_id');
        $asOf = $request->input('as_of', now()->toDateString());

        $dateExpr = DB::getDriverName() === 'pgsql'
            ? 'MIN(DATE(m.created_at))'
            : 'MIN(DATE(m.created_at))';

        // Filter by branch through the products table since stock_movements doesn't have branch_id
        $rows = DB::table('stock_movements as m')
            ->join('products as p', 'p.id', '=', 'm.product_id')
            ->select('p.id', 'p.name')
            ->selectRaw('SUM(m.quantity) as qty')
            ->selectRaw("{$dateExpr} as first_move")
            ->where('p.branch_id', $branchId)
            ->whereDate('m.created_at', '<=', $asOf)
            ->groupBy('p.id', 'p.name')
            ->orderBy('first_move')
            ->get();

        return $this->ok(['as_of' => $asOf, 'items' => $rows]);
    }

    public function pnl(Request $request)
    {
        $b = (int) $request->attributes->get('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // MED-01 FIX: Exclude cancelled/void/returned/refunded sales and purchases for accurate PnL
        // These statuses represent transactions that should not be counted in revenue/expenses
        $excludedStatuses = ['cancelled', 'void', 'voided', 'returned', 'refunded'];

        $sales = DB::table('sales')
            ->where('branch_id', $b)
            ->whereNotIn('status', $excludedStatuses)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->sum('total_amount');

        $purchases = DB::table('purchases')
            ->where('branch_id', $b)
            ->whereNotIn('status', $excludedStatuses)
            ->whereDate('created_at', '>=', $from)
            ->whereDate('created_at', '<=', $to)
            ->sum('total_amount');

        return $this->ok(['period' => [$from, $to], 'pnl' => round($sales - $purchases, 2)]);
    }

    public function cashflow(Request $request)
    {
        $b = (int) $request->attributes->get('branch_id');
        $from = $request->input('from', now()->startOfMonth()->toDateString());
        $to = $request->input('to', now()->endOfMonth()->toDateString());

        // STILL-V14-HIGH-01 FIX: Compute cashflow from bank transactions instead of sales/purchases paid_amount
        // This provides accurate cashflow including refunds, bank fees, journals, adjustments, opening balances, transfers, partial payments, etc.
        $inflows = DB::table('bank_transactions')
            ->where('branch_id', $b)
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->where('type', 'deposit')
            ->where('status', '!=', 'cancelled')
            ->sum('amount');

        $outflows = DB::table('bank_transactions')
            ->where('branch_id', $b)
            ->whereDate('transaction_date', '>=', $from)
            ->whereDate('transaction_date', '<=', $to)
            ->where('type', 'withdrawal')
            ->where('status', '!=', 'cancelled')
            ->sum('amount');

        return $this->ok(['period' => [$from, $to], 'inflow' => round($inflows, 2), 'outflow' => round($outflows, 2), 'net' => round($inflows - $outflows, 2)]);
    }
}
