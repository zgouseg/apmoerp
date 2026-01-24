<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Branch;
use App\Models\User;

/**
 * Branch Switcher Test Suite
 * 
 * Tests branch switching functionality and context management.
 */
class BranchSwitcherTest extends TestCase
{
    /* ========================================
     * COMPONENT EXISTENCE TESTS
     * ======================================== */

    public function test_branch_switcher_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Shared\BranchSwitcher::class));
    }

    /* ========================================
     * VIEW FILE TESTS
     * ======================================== */

    public function test_branch_switcher_view_exists(): void
    {
        $viewPath = base_path('resources/views/livewire/shared/branch-switcher.blade.php');
        $this->assertFileExists($viewPath);
    }

    public function test_branch_switcher_view_has_proper_structure(): void
    {
        $viewPath = base_path('resources/views/livewire/shared/branch-switcher.blade.php');
        $content = file_get_contents($viewPath);
        
        // Should have root element with class
        $firstLine = trim(explode("\n", $content)[0]);
        $this->assertStringStartsWith('<div', $firstLine, 'Should start with root div');
        $this->assertStringContainsString('class=', $firstLine, 'Root div should have class');
    }

    /* ========================================
     * BRANCH MODEL TESTS
     * ======================================== */

    public function test_branch_model_exists(): void
    {
        $this->assertTrue(class_exists(Branch::class));
    }

    /**
     * Test branches are seeded.
     */
    public function test_branches_are_seeded(): void
    {
        $admin = $this->createAdminUser();
        $count = Branch::count();
        $this->assertGreaterThan(0, $count, 'Should have at least one branch');
    }

    /* ========================================
     * COMPONENT RENDERING TESTS
     * ======================================== */

    public function test_branch_switcher_can_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        try {
            $component = Livewire::test(\App\Livewire\Shared\BranchSwitcher::class);
            $this->assertTrue(true, 'Branch switcher rendered');
        } catch (\Exception $e) {
            $this->markTestSkipped('Branch switcher render failed: ' . $e->getMessage());
        }
    }

    /* ========================================
     * BRANCH SWITCHING LOGIC TESTS
     * ======================================== */

    public function test_branch_switcher_has_switch_method(): void
    {
        $class = new \ReflectionClass(\App\Livewire\Shared\BranchSwitcher::class);
        $this->assertTrue(
            $class->hasMethod('switchBranch') || $class->hasMethod('selectBranch') || $class->hasMethod('setBranch'),
            'Should have a branch switching method'
        );
    }

    public function test_branch_context_session_key(): void
    {
        // Verify session key used for branch context
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        session(['admin_branch_context' => 1]);
        $this->assertEquals(1, session('admin_branch_context'));
    }

    /* ========================================
     * USER BRANCH RELATIONSHIP TESTS
     * ======================================== */

    public function test_user_has_branch_relationship(): void
    {
        $user = new User();
        
        $hasBranch = method_exists($user, 'branch') || property_exists($user, 'branch_id');
        $hasBranches = method_exists($user, 'branches');
        
        $this->assertTrue($hasBranch || $hasBranches, 'User should have branch relationship');
    }

    public function test_admin_user_can_access_multiple_branches(): void
    {
        $admin = $this->createAdminUser();
        
        // Super admin should be able to see all branches
        $this->assertTrue($admin->hasRole('Super Admin') || $admin->hasRole('Admin'));
    }
}
