<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * QA Test Suite: Migrations & Seeders
 * 
 * Goal: Ensure migrations and seeders run cleanly and database is consistent.
 */
class MigrationSeederTest extends TestCase
{
    /**
     * Test that all migrations run successfully.
     */
    public function test_migrations_run_successfully(): void
    {
        // The RefreshDatabase trait already runs migrations
        // This test confirms they complete without error
        $this->artisan('migrate:status')
            ->assertSuccessful();
    }

    /**
     * Test that database seeders run successfully.
     */
    public function test_seeders_run_successfully(): void
    {
        // Already seeded in setUp, verify key records exist
        $this->assertDatabaseHas('users', [
            'email' => 'admin@ghanem-lvju-egypt.com',
        ]);
        
        $this->assertDatabaseHas('branches', [
            'code' => 'HQ',
        ]);
    }

    /**
     * Test that roles are created properly.
     */
    public function test_roles_are_seeded(): void
    {
        $this->assertDatabaseHas('roles', ['name' => 'Super Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'Admin']);
        $this->assertDatabaseHas('roles', ['name' => 'Manager']);
        $this->assertDatabaseHas('roles', ['name' => 'Employee']);
    }

    /**
     * Test that permissions are created properly.
     */
    public function test_permissions_are_seeded(): void
    {
        // Check for some key permissions
        $permissionCount = \Spatie\Permission\Models\Permission::count();
        $this->assertGreaterThan(0, $permissionCount, 'Permissions should be seeded');
    }

    /**
     * Test that modules are seeded.
     */
    public function test_modules_are_seeded(): void
    {
        $moduleCount = \App\Models\Module::count();
        $this->assertGreaterThan(0, $moduleCount, 'Modules should be seeded');
    }

    /**
     * Test that currencies are seeded.
     */
    public function test_currencies_are_seeded(): void
    {
        $this->assertDatabaseHas('currencies', ['code' => 'EGP']);
    }

    /**
     * Test that admin user has Super Admin role.
     */
    public function test_admin_user_has_super_admin_role(): void
    {
        $admin = \App\Models\User::where('email', 'admin@ghanem-lvju-egypt.com')->first();
        
        $this->assertNotNull($admin);
        $this->assertTrue($admin->hasRole('Super Admin'));
    }
}
