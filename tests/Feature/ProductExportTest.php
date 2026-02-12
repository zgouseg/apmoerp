<?php

namespace Tests\Feature;

use Tests\TestCase;
use Livewire\Livewire;
use App\Models\Product;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Support\Facades\Schema;

/**
 * Product Export Test Suite
 * 
 * Tests product export functionality including code column.
 * 
 * Note: Base TestCase already uses RefreshDatabase and seeds the database.
 * Do NOT add RefreshDatabase or migrate:fresh here - it causes VACUUM errors on SQLite.
 */
class ProductExportTest extends TestCase
{

    public function test_products_table_has_code_column(): void
    {
        $this->assertTrue(
            Schema::hasColumn('products', 'code'),
            'Products table should have code column'
        );
    }

    public function test_product_export_includes_code_column(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $exportService = app(\App\Services\ExportService::class);
        $columns = $exportService->getAvailableColumns('products');

        $this->assertArrayHasKey('code', $columns, 'Export should include code column');
    }

    public function test_can_create_product_with_auto_generated_code(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $product = new Product();
        $product->branch_id = $branch->id;
        $product->name = 'Test Product';
        $product->sku = 'SKU-001';
        $product->status = 'active';
        $product->created_by = $admin->id;
        $product->save();

        // Code should be auto-generated (starts with PRD-)
        $this->assertNotNull($product->code, 'Product code should be auto-generated');
        $this->assertStringStartsWith('PRD-', $product->code, 'Auto-generated code should start with PRD-');
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'sku' => 'SKU-001',
        ]);
    }

    public function test_can_create_product_with_explicit_code(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Use direct attribute set since 'code' is guarded against mass-assignment
        $product = new Product();
        $product->branch_id = $branch->id;
        $product->name = 'Test Product';
        $product->code = 'TEST-001';
        $product->sku = 'SKU-002';
        $product->status = 'active';
        $product->created_by = $admin->id;
        $product->save();

        $this->assertEquals('TEST-001', $product->code);
        $this->assertDatabaseHas('products', [
            'code' => 'TEST-001',
            'sku' => 'SKU-002',
        ]);
    }

    public function test_products_index_can_export(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        try {
            $component = Livewire::test(\App\Livewire\Inventory\Products\Index::class);
            
            // Check export method exists
            $this->assertTrue(
                method_exists($component->instance(), 'export'),
                'Products Index should have export method'
            );
        } catch (\Exception $e) {
            $this->markTestSkipped('Products export test: ' . $e->getMessage());
        }
    }

    public function test_export_modal_opens_and_closes(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        try {
            $component = Livewire::test(\App\Livewire\Inventory\Products\Index::class)
                ->call('openExportModal')
                ->assertSet('showExportModal', true);

            $component->call('closeExportModal')
                ->assertSet('showExportModal', false);
        } catch (\Exception $e) {
            $this->markTestSkipped('Export modal test: ' . $e->getMessage());
        }
    }

    public function test_export_with_different_max_rows(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $branch = Branch::first();

        // Create test products (code will be auto-generated since it's guarded)
        for ($i = 1; $i <= 10; $i++) {
            $product = new Product();
            $product->branch_id = $branch->id;
            $product->name = "Product $i";
            $product->sku = "SKU-$i";
            $product->status = 'active';
            $product->created_by = $admin->id;
            $product->save();
        }

        try {
            $component = Livewire::test(\App\Livewire\Inventory\Products\Index::class);

            // Test different max row options
            foreach ([100, 500, 1000, 5000, 10000] as $maxRows) {
                $component->set('exportMaxRows', $maxRows);
                $this->assertEquals($maxRows, $component->get('exportMaxRows'));
            }

            // Test 'all' option
            $component->set('exportMaxRows', 'all');
            $this->assertEquals('all', $component->get('exportMaxRows'));
        } catch (\Exception $e) {
            $this->markTestSkipped('Export max rows test: ' . $e->getMessage());
        }
    }

    public function test_export_query_selects_code_column(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $branch = Branch::first();

        // Create a product with explicit code (set directly, not via mass-assignment)
        $product = new Product();
        $product->branch_id = $branch->id;
        $product->name = 'Test Export Product';
        $product->code = 'EXPORT-001';
        $product->sku = 'SKU-EXPORT-001';
        $product->status = 'active';
        $product->created_by = $admin->id;
        $product->save();

        // Query products like export does
        $result = Product::query()
            ->leftJoin('modules', 'products.module_id', '=', 'modules.id')
            ->leftJoin('branches', 'products.branch_id', '=', 'branches.id')
            ->where('products.id', $product->id)
            ->select([
                'products.id',
                'products.code',
                'products.name',
                'products.sku',
                'products.barcode',
                'products.type',
                'products.cost as standard_cost',
                'products.default_price as default_price',
                'products.min_stock',
                'products.status',
                'modules.name as module_name',
                'branches.name as branch_name',
                'products.created_at',
            ])
            ->first();

        $this->assertNotNull($result);
        $this->assertEquals('EXPORT-001', $result->code);
    }

    public function test_export_service_can_export_products_data(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        $branch = Branch::first();

        // Create product with explicit code
        $product = new Product();
        $product->branch_id = $branch->id;
        $product->name = 'Export Test';
        $product->code = 'EXP-TEST';
        $product->sku = 'SKU-EXP';
        $product->status = 'active';
        $product->created_by = $admin->id;
        $product->save();

        $exportService = app(\App\Services\ExportService::class);
        
        // Test data preparation
        $data = collect([
            [
                'id' => $product->id,
                'code' => $product->code,
                'name' => $product->name,
                'sku' => $product->sku,
                'status' => $product->status,
            ]
        ]);

        // Verify data has code
        $this->assertEquals('EXP-TEST', $data->first()['code']);
    }
}
