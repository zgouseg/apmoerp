<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * SECURITY: This command has been disabled to prevent accidental or malicious
 * password resets. Use the standard Laravel password reset flow instead.
 */
class RepairUserPasswords extends Command
{
    protected $signature = 'user:repair-passwords {--email=} {--admin-only : No longer functional}';

    protected $description = '[DISABLED] This command has been disabled for security reasons.';

    public function handle(): int
    {
        $this->error('This command has been disabled for security reasons.');
        $this->info('Use the standard password reset flow (Forgot Password) instead.');

        return self::FAILURE;
    }
}
