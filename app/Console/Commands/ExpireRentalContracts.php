<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Branch;
use App\Models\RentalContract;
use App\Services\BranchContextManager;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * CRIT-01 FIX: Console commands now properly set branch context via BranchContextManager
 * to work with BranchScope's fail-closed behavior for console contexts.
 */
class ExpireRentalContracts extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'rental:expire-contracts
                            {--date= : The date to check for expired contracts (default: today)}
                            {--branch= : Branch ID to check (optional)}
                            {--dry-run : Preview changes without applying them}';

    /**
     * The console command description.
     */
    protected $description = 'Expire rental contracts that have passed their end date and release associated units';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $date = $this->option('date') ?: now()->toDateString();
        $branchId = $this->option('branch') ? (int) $this->option('branch') : null;
        $dryRun = $this->option('dry-run');

        $this->info("Checking for rental contracts that expired before or on: {$date}");

        // CRIT-01 FIX: If no branch specified, iterate over all active branches
        if ($branchId === null) {
            return $this->processAllBranches($date, $dryRun);
        }

        return $this->processForBranch($branchId, $date, $dryRun);
    }

    /**
     * Process contract expiration for all active branches.
     */
    protected function processAllBranches(string $date, bool $dryRun): int
    {
        $branches = Branch::active()->pluck('id');

        if ($branches->isEmpty()) {
            $this->info('No active branches found.');

            return self::SUCCESS;
        }

        $this->info("Processing {$branches->count()} active branch(es)...");

        $totalExpired = 0;
        $totalReleased = 0;
        $hasErrors = false;

        foreach ($branches as $branchId) {
            $this->line("Processing branch #{$branchId}...");
            $result = $this->processForBranch($branchId, $date, $dryRun, false);

            if (is_array($result)) {
                $totalExpired += $result['expired'];
                $totalReleased += $result['released'];
                if ($result['errors']) {
                    $hasErrors = true;
                }
            }
        }

        $this->newLine();
        if ($dryRun) {
            $this->info("Dry run completed. Would expire {$totalExpired} contract(s) and release {$totalReleased} unit(s) across all branches.");
        } else {
            $this->info("Successfully expired {$totalExpired} contract(s) and released {$totalReleased} unit(s) across all branches.");
        }

        return $hasErrors ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Process contract expiration for a single branch with proper branch context.
     *
     * @return int|array
     */
    protected function processForBranch(int $branchId, string $date, bool $dryRun, bool $returnStatus = true)
    {
        // CRIT-01 FIX: Set branch context before executing branch-scoped queries
        BranchContextManager::setBranchContext($branchId);

        try {
            // MED-06 FIX: Use <= to match description "before or on"
            // Find active contracts that have passed their end date (including today)
            $expiredContracts = RentalContract::where('status', 'active')
                ->whereNotNull('end_date')
                ->where('end_date', '<=', $date)
                ->where('branch_id', $branchId)
                ->with('unit')
                ->get();

            if ($expiredContracts->isEmpty()) {
                $this->info("No expired contracts found for branch #{$branchId}.");

                if ($returnStatus) {
                    return self::SUCCESS;
                }

                return ['expired' => 0, 'released' => 0, 'errors' => false];
            }

            $this->info("Found {$expiredContracts->count()} expired contract(s) for branch #{$branchId}.");

            $expiredCount = 0;
            $releasedUnits = 0;
            $errors = [];

            foreach ($expiredContracts as $contract) {
                try {
                    if ($dryRun) {
                        $this->line("Would expire contract #{$contract->id} (end date: {$contract->end_date})");
                        if ($contract->unit) {
                            $this->line("  - Would release unit #{$contract->unit->id} ({$contract->unit->code})");
                        }
                        $expiredCount++;
                    } else {
                        DB::transaction(function () use ($contract, &$expiredCount, &$releasedUnits) {
                            // Update contract status
                            $contract->status = 'expired';
                            $contract->save();

                            $this->line("Expired contract #{$contract->id} (end date: {$contract->end_date})");

                            // Release the associated unit
                            if ($contract->unit) {
                                $unit = $contract->unit;
                                if ($unit->status === 'occupied' || $unit->status === 'rented') {
                                    $unit->status = 'available';
                                    $unit->save();
                                    $this->line("  - Released unit #{$unit->id} ({$unit->code})");
                                    $releasedUnits++;
                                }
                            }

                            $expiredCount++;
                        });
                    }
                } catch (\Exception $e) {
                    $errorMsg = "Failed to expire contract #{$contract->id}: {$e->getMessage()}";
                    $this->error($errorMsg);
                    $errors[] = $errorMsg;
                    Log::error('Rental contract expiration failed', [
                        'contract_id' => $contract->id,
                        'branch_id' => $branchId,
                        'error' => $e->getMessage(),
                    ]);
                }
            }

            if ($dryRun) {
                $this->info("\nDry run completed for branch #{$branchId}. No changes were made.");
            } else {
                $this->info("\nSuccessfully expired {$expiredCount} contract(s) and released {$releasedUnits} unit(s) for branch #{$branchId}.");
            }

            if (! empty($errors)) {
                $this->error("\nErrors encountered: ".count($errors));
            }

            if ($returnStatus) {
                return empty($errors) ? self::SUCCESS : self::FAILURE;
            }

            return [
                'expired' => $expiredCount,
                'released' => $releasedUnits,
                'errors' => ! empty($errors),
            ];
        } finally {
            // CRIT-01 FIX: Always clear branch context after processing
            BranchContextManager::clearBranchContext();
        }
    }
}
