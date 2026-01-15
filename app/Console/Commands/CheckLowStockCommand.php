<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Branch;
use App\Services\AutomatedAlertService;
use App\Services\BranchContextManager;
use App\Services\StockReorderService;
use Illuminate\Console\Command;

/**
 * CheckLowStockCommand - Automated low stock monitoring
 *
 * NEW FEATURE: Scheduled command for low stock monitoring
 *
 * CRIT-01 FIX: Console commands now properly set branch context via BranchContextManager
 * to work with BranchScope's fail-closed behavior for console contexts.
 */
class CheckLowStockCommand extends Command
{
    protected $signature = 'stock:check-low
                          {--branch= : Branch ID to check}
                          {--auto-reorder : Automatically generate purchase requisitions}';

    protected $description = 'Check for low stock products and send alerts';

    public function handle(): int
    {
        $this->info('Checking for low stock products...');

        $branchId = $this->option('branch') ? (int) $this->option('branch') : null;
        $autoReorder = $this->option('auto-reorder');

        // CRIT-01 FIX: If no branch specified, iterate over all active branches
        if ($branchId === null) {
            return $this->processAllBranches($autoReorder);
        }

        return $this->processForBranch($branchId, $autoReorder);
    }

    /**
     * Process low stock checks for all active branches.
     */
    protected function processAllBranches(bool $autoReorder): int
    {
        $branches = Branch::active()->pluck('id');

        if ($branches->isEmpty()) {
            $this->info('No active branches found.');

            return self::SUCCESS;
        }

        $this->info("Processing {$branches->count()} active branch(es)...");

        $totalAlerts = 0;
        foreach ($branches as $branchId) {
            $this->line("Processing branch #{$branchId}...");
            $totalAlerts += $this->processForBranch($branchId, $autoReorder, false);
        }

        $this->info("Total low stock alerts across all branches: {$totalAlerts}");

        return self::SUCCESS;
    }

    /**
     * Process low stock check for a single branch with proper branch context.
     */
    protected function processForBranch(int $branchId, bool $autoReorder, bool $returnStatus = true): int
    {
        // CRIT-01 FIX: Set branch context before executing branch-scoped queries
        BranchContextManager::setBranchContext($branchId);

        try {
            $alertService = app(AutomatedAlertService::class);
            $alerts = $alertService->checkLowStockAlerts($branchId);

            if (empty($alerts)) {
                $this->info("No low stock alerts found for branch #{$branchId}.");

                return $returnStatus ? self::SUCCESS : 0;
            }

            $this->warn('Found '.count($alerts)." low stock products for branch #{$branchId}:");

            $this->table(
                ['Product', 'Code', 'Current Stock', 'Threshold', 'Severity', 'Branch'],
                array_map(fn ($a) => [
                    $a['product_name'],
                    $a['product_code'],
                    $a['current_stock'],
                    $a['alert_threshold'],
                    $a['severity'],
                    $a['branch_name'] ?? 'N/A',
                ], array_slice($alerts, 0, 10))
            );

            if (count($alerts) > 10) {
                $this->info('... and '.(count($alerts) - 10).' more');
            }

            // Auto-generate requisitions if requested
            if ($autoReorder) {
                $this->info('Generating purchase requisitions...');
                $reorderService = app(StockReorderService::class);
                $result = $reorderService->autoGenerateRequisitions($branchId, 1); // System user

                if ($result['success']) {
                    $this->info($result['message']);
                    if (! empty($result['requisitions'])) {
                        $this->table(
                            ['Requisition Code', 'Branch ID', 'Items Count'],
                            array_map(fn ($r) => [$r['code'], $r['branch_id'], $r['items_count']], $result['requisitions'])
                        );
                    }
                } else {
                    $this->error('Failed to generate requisitions');
                }
            }

            return $returnStatus ? self::SUCCESS : count($alerts);
        } finally {
            // CRIT-01 FIX: Always clear branch context after processing
            BranchContextManager::clearBranchContext();
        }
    }
}
