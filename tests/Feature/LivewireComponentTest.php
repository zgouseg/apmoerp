<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\File;
use Livewire\Livewire;
use Tests\TestCase;

/**
 * QA Test Suite: Livewire Component Render Tests
 * 
 * Goal: Test that Livewire components can render without errors.
 */
class LivewireComponentTest extends TestCase
{
    private const MAX_FAILURES_TO_DISPLAY = 10;
    
    /**
     * Get all Livewire component classes.
     */
    protected function discoverLivewireComponents(): array
    {
        $components = [];
        $livewirePath = app_path('Livewire');
        
        if (!is_dir($livewirePath)) {
            return $components;
        }
        
        $files = File::allFiles($livewirePath);
        
        foreach ($files as $file) {
            $relativePath = $file->getRelativePathname();
            
            // Skip concerns, traits, interfaces
            if (str_contains($relativePath, 'Concerns') || 
                str_contains($relativePath, 'Traits') ||
                str_contains($relativePath, 'Interface')) {
                continue;
            }
            
            // Convert file path to class name
            $className = 'App\\Livewire\\' . str_replace(['/', '.php'], ['\\', ''], $relativePath);
            
            if (class_exists($className)) {
                // Check if it's a Livewire component
                $reflection = new \ReflectionClass($className);
                
                if (!$reflection->isAbstract() && 
                    $reflection->isSubclassOf(\Livewire\Component::class)) {
                    $components[] = $className;
                }
            }
        }
        
        return $components;
    }

    /**
     * Check if a component requires parameters in mount().
     */
    protected function requiresParameters(string $className): array
    {
        $reflection = new \ReflectionClass($className);
        
        if (!$reflection->hasMethod('mount')) {
            return ['required' => false, 'params' => []];
        }
        
        $mount = $reflection->getMethod('mount');
        $params = $mount->getParameters();
        
        $required = [];
        foreach ($params as $param) {
            if (!$param->isOptional()) {
                $required[] = [
                    'name' => $param->getName(),
                    'type' => $param->hasType() ? $param->getType()?->getName() : null,
                ];
            }
        }
        
        return [
            'required' => !empty($required),
            'params' => $required,
        ];
    }

    /**
     * Test that components without required params render successfully.
     */
    public function test_components_without_required_params_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $components = $this->discoverLivewireComponents();
        $failures = [];
        $passes = [];
        $skipped = [];
        
        foreach ($components as $className) {
            $paramInfo = $this->requiresParameters($className);
            
            if ($paramInfo['required']) {
                $skipped[] = [
                    'class' => $className,
                    'reason' => 'Requires parameters: ' . json_encode($paramInfo['params']),
                ];
                continue;
            }
            
            try {
                Livewire::test($className)
                    ->assertStatus(200);
                    
                $passes[] = $className;
            } catch (\Exception $e) {
                $failures[] = [
                    'class' => $className,
                    'error' => $e->getMessage(),
                ];
            }
        }
        
        // Log the results
        $totalComponents = count($components);
        $passCount = count($passes);
        $failCount = count($failures);
        $skipCount = count($skipped);
        
        // If there are failures, report them
        if (!empty($failures)) {
            $failureMessages = array_map(function($f) {
                return "{$f['class']}: {$f['error']}";
            }, array_slice($failures, 0, self::MAX_FAILURES_TO_DISPLAY));
            
            $this->fail(
                "Livewire component render failures ({$failCount} failed, {$passCount} passed, {$skipCount} skipped):\n" . 
                implode("\n", $failureMessages) .
                ($failCount > self::MAX_FAILURES_TO_DISPLAY ? "\n...and " . ($failCount - self::MAX_FAILURES_TO_DISPLAY) . " more failures" : "")
            );
        }
        
        $this->assertTrue(true, "All {$passCount} testable components rendered successfully. {$skipCount} skipped (require params).");
    }

    /**
     * Test specific high-priority components individually.
     */
    public function test_dashboard_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        // Test main dashboard
        if (class_exists(\App\Livewire\Dashboard\Index::class)) {
            Livewire::test(\App\Livewire\Dashboard\Index::class)
                ->assertStatus(200);
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Auth components render.
     */
    public function test_auth_components_render(): void
    {
        // Test login page (guest)
        if (class_exists(\App\Livewire\Auth\Login::class)) {
            Livewire::test(\App\Livewire\Auth\Login::class)
                ->assertStatus(200);
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Admin components render.
     */
    public function test_admin_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $adminComponents = [
            \App\Livewire\Admin\Users\Index::class,
            \App\Livewire\Admin\Roles\Index::class,
            \App\Livewire\Admin\Branches\Index::class,
            \App\Livewire\Admin\Modules\Index::class,
            \App\Livewire\Admin\CurrencyManager::class,
            \App\Livewire\Admin\ActivityLog::class,
        ];
        
        $failures = [];
        
        foreach ($adminComponents as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("Admin component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Finance/Accounting components render.
     */
    public function test_finance_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $financeComponents = [
            \App\Livewire\Accounting\Index::class,
            \App\Livewire\Banking\Index::class,
            \App\Livewire\Banking\Accounts\Index::class,
            \App\Livewire\Banking\Transactions\Index::class,
            \App\Livewire\Expenses\Index::class,
            \App\Livewire\Income\Index::class,
            \App\Livewire\FixedAssets\Index::class,
        ];
        
        $failures = [];
        
        foreach ($financeComponents as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("Finance component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Sales/Purchases components render.
     */
    public function test_sales_purchases_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $components = [
            \App\Livewire\Sales\Index::class,
            \App\Livewire\Purchases\Index::class,
        ];
        
        $failures = [];
        
        foreach ($components as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("Sales/Purchases component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Inventory/Warehouse components render.
     */
    public function test_inventory_warehouse_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $components = [
            \App\Livewire\Inventory\Index::class,
            \App\Livewire\Inventory\Products\Index::class,
            \App\Livewire\Warehouse\Index::class,
            \App\Livewire\Warehouse\Locations\Index::class,
            \App\Livewire\Warehouse\Transfers\Index::class,
        ];
        
        $failures = [];
        
        foreach ($components as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("Inventory/Warehouse component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test HRM components render.
     */
    public function test_hrm_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $components = [
            \App\Livewire\Hrm\Index::class,
            \App\Livewire\Hrm\Employees\Index::class,
            \App\Livewire\Hrm\Departments\Index::class,
        ];
        
        $failures = [];
        
        foreach ($components as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("HRM component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }

    /**
     * Test Other module components render.
     */
    public function test_other_module_index_components_render(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);
        
        $components = [
            \App\Livewire\Projects\Index::class,
            \App\Livewire\Documents\Index::class,
            \App\Livewire\Helpdesk\Tickets\Index::class,
            \App\Livewire\Rental\Index::class,
            \App\Livewire\Manufacturing\BillsOfMaterials\Index::class,
            \App\Livewire\Manufacturing\ProductionOrders\Index::class,
        ];
        
        $failures = [];
        
        foreach ($components as $component) {
            if (!class_exists($component)) {
                continue;
            }
            
            try {
                Livewire::test($component)->assertStatus(200);
            } catch (\Exception $e) {
                $failures[] = "$component: " . $e->getMessage();
            }
        }
        
        if (!empty($failures)) {
            $this->fail("Other module component failures:\n" . implode("\n", $failures));
        }
        
        $this->assertTrue(true);
    }
}
