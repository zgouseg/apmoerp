<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

/**
 * QA Test Suite: All Views / Route Smoke Tests
 * 
 * Goal: Detect broken views, missing variables, and ensure routes don't return 500 errors.
 */
class ViewsSmokeTest extends TestCase
{
    protected array $failedRoutes = [];
    protected array $passedRoutes = [];
    protected array $skippedRoutes = [];

    /**
     * Get all GET routes for testing.
     */
    protected function getTestableRoutes(): array
    {
        $routes = collect(Route::getRoutes()->getRoutes())
            ->filter(function ($route) {
                // Only GET routes
                if (!in_array('GET', $route->methods())) {
                    return false;
                }
                
                $uri = $route->uri();
                
                // Skip Livewire internal routes
                if (str_starts_with($uri, 'livewire')) {
                    return false;
                }
                
                // Skip API routes for this test (tested separately)
                if (str_starts_with($uri, 'api/')) {
                    return false;
                }
                
                // Skip routes with complex parameters that need specific IDs
                if (preg_match('/\{[^}]+\}/', $uri)) {
                    return false;
                }
                
                // Skip certain utility routes
                $skipPatterns = [
                    'sanctum/',
                    '_debugbar',
                    'storage/',
                    'csrf-token',
                    'up',
                ];
                
                foreach ($skipPatterns as $pattern) {
                    if (str_contains($uri, $pattern)) {
                        return false;
                    }
                }
                
                return true;
            })
            ->map(function ($route) {
                return [
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                    'action' => $route->getActionName(),
                    'middleware' => $route->middleware(),
                ];
            })
            ->values()
            ->toArray();
            
        return $routes;
    }

    /**
     * Test that main application routes don't return 500.
     */
    #[\PHPUnit\Framework\Attributes\DataProvider('routeProvider')]
    public function test_route_does_not_return_500(string $uri, ?string $name): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/' . ltrim($uri, '/'));
        
        $this->assertNotEquals(
            500, 
            $response->status(), 
            "Route '{$uri}' (name: {$name}) returned HTTP 500. Check logs for error details."
        );
    }

    /**
     * Static routes that should always work.
     */
    public static function routeProvider(): array
    {
        return [
            'home' => ['/', 'home'],
            'login' => ['login', 'login'],
            'dashboard' => ['dashboard', 'dashboard'],
            
            // Admin routes
            'admin-users' => ['admin/users', 'admin.users.index'],
            'admin-roles' => ['admin/roles', 'admin.roles.index'],
            'admin-branches' => ['admin/branches', 'admin.branches.index'],
            'admin-modules' => ['admin/modules', 'admin.modules.index'],
            'admin-currencies' => ['admin/currencies', 'admin.currencies.index'],
            'admin-settings' => ['admin/settings', 'admin.settings'],
            'admin-activity-log' => ['admin/activity-log', 'admin.activity-log'],
            'admin-reports' => ['admin/reports', 'admin.reports.index'],
            
            // Finance/Accounting routes
            'accounting-index' => ['app/accounting', 'app.accounting.index'],
            'banking-index' => ['app/banking', 'app.banking.index'],
            'banking-accounts' => ['app/banking/accounts', 'app.banking.accounts.index'],
            'banking-transactions' => ['app/banking/transactions', 'app.banking.transactions.index'],
            'expenses-index' => ['app/expenses', 'app.expenses.index'],
            'income-index' => ['app/income', 'app.income.index'],
            
            // Sales routes
            'sales-index' => ['app/sales', 'app.sales.index'],
            
            // Purchases routes
            'purchases-index' => ['app/purchases', 'app.purchases.index'],
            
            // Inventory routes
            'inventory-index' => ['app/inventory', 'app.inventory.index'],
            
            // Warehouse routes
            'warehouse-index' => ['app/warehouse', 'app.warehouse.index'],
            
            // HRM routes
            'hrm-index' => ['app/hrm', 'app.hrm.index'],
            
            // Projects routes
            'projects-index' => ['app/projects', 'app.projects.index'],
            
            // Documents routes
            'documents-index' => ['app/documents', 'app.documents.index'],
            
            // Manufacturing routes
            'manufacturing-bom' => ['app/manufacturing/bills-of-materials', 'app.manufacturing.bills-of-materials.index'],
            'manufacturing-orders' => ['app/manufacturing/production-orders', 'app.manufacturing.production-orders.index'],
            
            // Helpdesk routes
            'helpdesk-tickets' => ['app/helpdesk/tickets', 'app.helpdesk.tickets.index'],
            
            // Rental routes
            'rental-index' => ['app/rental', 'app.rental.index'],
            
            // Fixed Assets routes
            'fixed-assets-index' => ['app/fixed-assets', 'app.fixed-assets.index'],
        ];
    }

    /**
     * Test the complete route list dynamically.
     */
    public function test_all_static_routes_load(): void
    {
        $admin = $this->createAdminUser();
        $routes = $this->getTestableRoutes();
        
        $failures = [];
        $passes = [];
        
        foreach ($routes as $route) {
            $uri = $route['uri'];
            
            try {
                $response = $this->actingAs($admin)->get('/' . ltrim($uri, '/'));
                
                if ($response->status() === 500) {
                    $failures[] = [
                        'uri' => $uri,
                        'name' => $route['name'],
                        'status' => $response->status(),
                        'action' => $route['action'],
                    ];
                } else {
                    $passes[] = [
                        'uri' => $uri,
                        'name' => $route['name'],
                        'status' => $response->status(),
                    ];
                }
            } catch (\Exception $e) {
                $failures[] = [
                    'uri' => $uri,
                    'name' => $route['name'],
                    'error' => $e->getMessage(),
                    'action' => $route['action'],
                ];
            }
        }
        
        // Output summary
        if (!empty($failures)) {
            $failureMessages = array_map(function($f) {
                $error = $f['error'] ?? "HTTP {$f['status']}";
                return "{$f['uri']} ({$f['name']}): {$error}";
            }, $failures);
            
            $this->fail(
                "The following routes failed:\n" . implode("\n", $failureMessages)
            );
        }
        
        $this->assertTrue(true, count($passes) . " routes passed");
    }
}
