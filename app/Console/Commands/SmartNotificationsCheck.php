<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Branch;
use App\Services\BranchContextManager;
use App\Services\SmartNotificationsService;
use Illuminate\Console\Command;

/**
 * CRIT-01 FIX: Console commands now properly set branch context via BranchContextManager
 * to work with BranchScope's fail-closed behavior for console contexts.
 */
class SmartNotificationsCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'erp:notifications:check {--branch= : Branch ID to check (optional)} {--type= : Notification type (low_stock, overdue, reminders, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and send smart notifications for low stock, overdue invoices, and payment reminders';

    /**
     * Execute the console command.
     */
    public function handle(SmartNotificationsService $service): int
    {
        $branchId = $this->option('branch') ? (int) $this->option('branch') : null;
        $type = $this->option('type') ?? 'all';

        $this->info('Running smart notifications check...');

        // CRIT-01 FIX: If no branch specified, iterate over all active branches
        if ($branchId === null) {
            return $this->processAllBranches($service, $type);
        }

        return $this->processForBranch($service, $branchId, $type);
    }

    /**
     * Process notifications for all active branches.
     */
    protected function processAllBranches(SmartNotificationsService $service, string $type): int
    {
        $branches = Branch::active()->pluck('id');

        if ($branches->isEmpty()) {
            $this->info('No active branches found.');

            return Command::SUCCESS;
        }

        $this->info("Processing {$branches->count()} active branch(es)...");

        $totalNotifications = 0;
        foreach ($branches as $branchId) {
            $this->line("Processing branch #{$branchId}...");
            $totalNotifications += $this->processForBranch($service, $branchId, $type, false);
        }

        $this->newLine();
        $this->info("Total notifications sent across all branches: {$totalNotifications}");

        return Command::SUCCESS;
    }

    /**
     * Process notifications for a single branch with proper branch context.
     */
    protected function processForBranch(SmartNotificationsService $service, int $branchId, string $type, bool $returnStatus = true): int
    {
        // CRIT-01 FIX: Set branch context before executing branch-scoped queries
        BranchContextManager::setBranchContext($branchId);

        try {
            $results = [];

            switch ($type) {
                case 'low_stock':
                    $results['low_stock'] = $service->checkLowStockAlerts($branchId);
                    break;

                case 'overdue':
                    $results['overdue_invoices'] = $service->checkOverdueInvoices($branchId);
                    break;

                case 'reminders':
                    $results['payment_reminders'] = $service->checkPaymentReminders($branchId);
                    break;

                case 'all':
                default:
                    $results = $service->runAllChecks($branchId);
                    break;
            }

            // Output results
            $totalNotifications = 0;

            foreach ($results as $checkType => $items) {
                $count = count($items);
                $totalNotifications += $count;

                if ($count > 0) {
                    $this->info(sprintf('  Branch #%d - %s: %d notifications sent', $branchId, ucfirst(str_replace('_', ' ', $checkType)), $count));

                    if ($this->getOutput()->isVerbose()) {
                        foreach ($items as $item) {
                            $this->line("    - {$item}");
                        }
                    }
                } else {
                    $this->line(sprintf('  Branch #%d - %s: No notifications needed', $branchId, ucfirst(str_replace('_', ' ', $checkType))));
                }
            }

            if ($returnStatus) {
                $this->newLine();
                $this->info("Total notifications sent for branch #{$branchId}: {$totalNotifications}");

                return Command::SUCCESS;
            }

            return $totalNotifications;
        } finally {
            // CRIT-01 FIX: Always clear branch context after processing
            BranchContextManager::clearBranchContext();
        }
    }
}
