<?php

namespace Tests;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // SAFETY: Prevent RefreshDatabase from accidentally running against
        // a MySQL/MariaDB production database. Tests should use SQLite in-memory.
        $connection = config('database.default');
        if (in_array($connection, ['mysql', 'mariadb', 'pgsql'])) {
            $this->markTestSkipped(
                "Tests are configured to use '{$connection}' connection. "
                . 'RefreshDatabase would DROP ALL TABLES. '
                . 'Set DB_CONNECTION=sqlite and DB_DATABASE=:memory: in phpunit.xml or .env.testing.'
            );
        }

        // Prevent @vite() from requiring a build manifest in tests
        $this->withoutVite();
        
        // Seed the database for tests
        $this->seed();
    }

    /**
     * Create an admin user for testing.
     */
    protected function createAdminUser(): User
    {
        $user = User::where('email', 'admin@ghanem-lvju-egypt.com')->first();
        
        if (!$user) {
            $branch = Branch::first() ?? Branch::create([
                'name' => 'Test Branch',
                'code' => 'TEST',
                'address' => 'Test Address',
                'is_active' => true,
            ]);
            
            $user = User::factory()->create([
                'email' => 'admin@ghanem-lvju-egypt.com',
                'name' => 'Admin User',
                'branch_id' => $branch->id,
                'is_active' => true,
            ]);
            $user->assignRole('Super Admin');
            $user->branches()->sync([$branch->id]);
        }
        
        return $user;
    }

    /**
     * Create a regular user for testing.
     */
    protected function createRegularUser(): User
    {
        $testEmail = 'test-employee@test.com';
        $user = User::where('email', $testEmail)->first();
        
        if (!$user) {
            $branch = Branch::first();
            $user = User::factory()->create([
                'email' => $testEmail,
                'name' => 'Test Employee',
                'branch_id' => $branch?->id,
                'is_active' => true,
            ]);
            $user->assignRole('Employee');
            if ($branch) {
                $user->branches()->sync([$branch->id]);
            }
        }
        
        return $user;
    }
}
