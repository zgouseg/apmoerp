<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * SECURITY: This command has been disabled to prevent accidental data loss
 * from migration directory manipulation. Use standard Laravel migration
 * commands (migrate, migrate:rollback) instead.
 */
class ConsolidateMigrationsCommand extends Command
{
    protected $signature = 'migrations:consolidate
                            {--backup : No longer functional}
                            {--activate : No longer functional}
                            {--dry-run : No longer functional}';

    protected $description = '[DISABLED] This command has been disabled for security reasons.';

    public function handle(): int
    {
        $this->error('This command has been disabled for security reasons.');
        $this->info('Use standard Laravel migration commands (migrate, migrate:rollback) instead.');

        return self::FAILURE;
    }
}
