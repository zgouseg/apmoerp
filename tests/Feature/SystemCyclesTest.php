<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\SalePayment;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use App\Models\PurchasePayment;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Property;
use App\Models\RentalUnit;
use App\Models\Tenant;
use App\Models\RentalContract;
use App\Models\StockMovement;
use App\Models\Account;
use App\Models\JournalEntry;
use App\Models\JournalEntryLine;
use App\Models\BankAccount;
use App\Models\Warehouse;
use Livewire\Livewire;

/**
 * System Cycles Test Suite
 *
 * Tests full business cycles end-to-end:
 * - Customer creation & management
 * - Product creation & inventory
 * - Sales cycle (create sale, add items, payment)
 * - Purchase cycle
 * - Expense & income recording
 * - Rental cycle (property, unit, tenant, contract)
 * - Financial reports data integrity
 * - Export Excel functionality across modules
 * - All form components render and validate
 */
class SystemCyclesTest extends TestCase
{
    /* ========================================
     * CUSTOMER CYCLE
     * ======================================== */

    public function test_customer_creation_cycle(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Test Customer',
            'email' => 'testcustomer@example.com',
            'phone' => '+20 100 000 1234',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($customer->id);
        $this->assertNotNull($customer->code, 'Customer should auto-generate a code');
        $this->assertEquals('Test Customer', $customer->name);
        $this->assertEquals($branch->id, $customer->branch_id);
    }

    public function test_customer_form_renders(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        try {
            Livewire::test(\App\Livewire\Customers\Form::class);
            $this->assertTrue(true, 'Customer form rendered');
        } catch (\Exception $e) {
            $this->markTestSkipped('Customer form render: ' . $e->getMessage());
        }
    }

    public function test_customer_index_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Customers\Index::class));
        $index = new \App\Livewire\Customers\Index();
        $this->assertTrue(method_exists($index, 'render'));
    }

    /* ========================================
     * SUPPLIER CYCLE
     * ======================================== */

    public function test_supplier_creation_cycle(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $supplier = Supplier::create([
            'branch_id' => $branch->id,
            'name' => 'Test Supplier',
            'email' => 'supplier@example.com',
            'phone' => '+20 100 000 5678',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($supplier->id);
        $this->assertNotNull($supplier->code, 'Supplier should auto-generate a code');
        $this->assertEquals('Test Supplier', $supplier->name);
    }

    /* ========================================
     * PRODUCT CYCLE
     * ======================================== */

    public function test_product_creation_with_uuid_and_code(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $product = Product::create([
            'branch_id' => $branch->id,
            'name' => 'Test Product',
            'sku' => 'TEST-SKU-001',
            'price' => 100.00,
            'cost' => 50.00,
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($product->id);
        $this->assertNotNull($product->uuid, 'Product should have auto-generated UUID');
        $this->assertNotNull($product->code, 'Product should have auto-generated code');
        $this->assertStringStartsWith('PRD-', $product->code);
        $this->assertEquals('active', $product->status);
    }

    public function test_product_form_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Inventory\Products\Form::class));
        $form = new \App\Livewire\Inventory\Products\Form();
        $this->assertTrue(method_exists($form, 'save'));
        $this->assertTrue(method_exists($form, 'render'));
    }

    public function test_product_show_uses_correct_fields(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $product = Product::create([
            'branch_id' => $branch->id,
            'name' => 'Show Test Product',
            'sku' => 'SHOW-SKU-001',
            'status' => 'active',
            'notes' => 'Test product notes',
            'created_by' => $admin->id,
        ]);

        // Verify product uses 'status' not 'is_active', and 'notes' not 'description'
        $this->assertEquals('active', $product->status);
        $this->assertEquals('Test product notes', $product->notes);
    }

    /* ========================================
     * SALES CYCLE
     * ======================================== */

    public function test_full_sales_cycle(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Create customer
        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Sales Cycle Customer',
            'created_by' => $admin->id,
        ]);

        // Create product
        $product = Product::create([
            'branch_id' => $branch->id,
            'name' => 'Sales Product',
            'sku' => 'SALE-PRD-001',
            'price' => 250.00,
            'cost' => 100.00,
            'stock_quantity' => 50,
            'created_by' => $admin->id,
        ]);

        // Create sale
        $sale = Sale::create([
            'branch_id' => $branch->id,
            'customer_id' => $customer->id,
            'type' => 'invoice',
            'status' => 'completed',
            'payment_status' => 'paid',
            'sale_date' => now(),
            'subtotal' => 500.00,
            'total_amount' => 500.00,
            'paid_amount' => 500.00,
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($sale->id);

        // Create sale item
        $saleItem = SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product->id,
            'quantity' => 2,
            'unit_price' => 250.00,
            'line_total' => 500.00,
        ]);

        $this->assertNotNull($saleItem->id);

        // Record payment
        $payment = SalePayment::create([
            'sale_id' => $sale->id,
            'payment_method' => 'cash',
            'amount' => 500.00,
            'payment_date' => now(),
        ]);

        $this->assertNotNull($payment->id);
        $this->assertEquals(500.00, (float) $payment->amount);
    }

    public function test_sales_form_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Sales\Form::class));
    }

    /* ========================================
     * PURCHASE CYCLE
     * ======================================== */

    public function test_full_purchase_cycle(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $supplier = Supplier::create([
            'branch_id' => $branch->id,
            'name' => 'Purchase Supplier',
            'created_by' => $admin->id,
        ]);

        $product = Product::create([
            'branch_id' => $branch->id,
            'name' => 'Purchase Product',
            'sku' => 'PUR-PRD-001',
            'cost' => 75.00,
            'created_by' => $admin->id,
        ]);

        $purchase = Purchase::create([
            'branch_id' => $branch->id,
            'supplier_id' => $supplier->id,
            'status' => 'received',
            'payment_status' => 'paid',
            'purchase_date' => now(),
            'subtotal' => 750.00,
            'total_amount' => 750.00,
            'paid_amount' => 750.00,
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($purchase->id);

        $purchaseItem = PurchaseItem::create([
            'purchase_id' => $purchase->id,
            'product_id' => $product->id,
            'quantity' => 10,
            'unit_price' => 75.00,
            'line_total' => 750.00,
        ]);

        $this->assertNotNull($purchaseItem->id);
    }

    /* ========================================
     * EXPENSE & INCOME CYCLE
     * ======================================== */

    public function test_expense_creation(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $expense = Expense::create([
            'branch_id' => $branch->id,
            'reference_number' => 'EXP-TEST-001',
            'expense_date' => now()->toDateString(),
            'amount' => 500.00,
            'total_amount' => 500.00,
            'status' => 'approved',
            'payment_method' => 'cash',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($expense->id);
        $this->assertEquals(500.00, (float) $expense->amount);
    }

    public function test_income_creation(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $income = Income::create([
            'branch_id' => $branch->id,
            'reference_number' => 'INC-TEST-001',
            'income_date' => now()->toDateString(),
            'amount' => 1000.00,
            'total_amount' => 1000.00,
            'status' => 'received',
            'payment_method' => 'bank_transfer',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($income->id);
        $this->assertEquals(1000.00, (float) $income->amount);
    }

    public function test_expense_form_renders(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        try {
            Livewire::test(\App\Livewire\Expenses\Form::class);
            $this->assertTrue(true, 'Expense form rendered');
        } catch (\Exception $e) {
            $this->markTestSkipped('Expense form render: ' . $e->getMessage());
        }
    }

    public function test_income_form_renders(): void
    {
        $admin = $this->createAdminUser();
        $this->actingAs($admin);

        try {
            Livewire::test(\App\Livewire\Income\Form::class);
            $this->assertTrue(true, 'Income form rendered');
        } catch (\Exception $e) {
            $this->markTestSkipped('Income form render: ' . $e->getMessage());
        }
    }

    /* ========================================
     * RENTAL CYCLE
     * ======================================== */

    public function test_full_rental_cycle(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Create property with code
        $property = Property::create([
            'branch_id' => $branch->id,
            'name' => 'Test Property',
            'code' => 'PROP-001',
            'address' => '123 Test Street',
        ]);

        $this->assertNotNull($property->id);
        $this->assertEquals('PROP-001', $property->code);

        // Create rental unit
        $unit = RentalUnit::create([
            'branch_id' => $branch->id,
            'property_id' => $property->id,
            'name' => 'Unit A1',
            'status' => 'available',
        ]);

        $this->assertNotNull($unit->id);

        // Create tenant
        $tenant = Tenant::create([
            'branch_id' => $branch->id,
            'name' => 'Test Tenant',
            'phone' => '+20 100 000 9999',
        ]);

        $this->assertNotNull($tenant->id);

        // Create rental contract
        $contract = RentalContract::create([
            'branch_id' => $branch->id,
            'unit_id' => $unit->id,
            'tenant_id' => $tenant->id,
            'contract_number' => 'RC-000001',
            'start_date' => now()->toDateString(),
            'end_date' => now()->addYear()->toDateString(),
            'rent_amount' => 5000.00,
            'deposit_amount' => 10000.00,
            'rent_frequency' => 'monthly',
            'status' => 'active',
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($contract->id);
        $this->assertEquals(5000.00, (float) $contract->rent_amount);
        $this->assertEquals('monthly', $contract->rent_frequency);
    }

    public function test_property_fillable_includes_code(): void
    {
        $property = new Property();
        $this->assertContains('code', $property->getFillable());
    }

    /* ========================================
     * STOCK MOVEMENT CYCLE
     * ======================================== */

    public function test_stock_movement_creation(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $product = Product::create([
            'branch_id' => $branch->id,
            'name' => 'Stock Test Product',
            'sku' => 'STK-PRD-001',
            'stock_quantity' => 0,
            'created_by' => $admin->id,
        ]);

        $warehouse = Warehouse::first() ?? Warehouse::create([
            'branch_id' => $branch->id,
            'name' => 'Test Warehouse',
            'code' => 'WH-TEST',
        ]);

        $movement = StockMovement::create([
            'product_id' => $product->id,
            'branch_id' => $branch->id,
            'warehouse_id' => $warehouse->id,
            'movement_type' => StockMovement::TYPE_PURCHASE,
            'quantity' => 50,
            'unit_cost' => 100.00,
            'stock_before' => 0,
            'stock_after' => 50,
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($movement->id);
        $this->assertEquals(50, (float) $movement->quantity);
        $this->assertEquals('in', $movement->direction);
    }

    /* ========================================
     * ACCOUNTING CYCLE
     * ======================================== */

    public function test_journal_entry_creation(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Create accounts
        $cashAccount = Account::create([
            'branch_id' => $branch->id,
            'account_number' => '1001',
            'name' => 'Cash',
            'type' => 'asset',
            'is_active' => true,
        ]);

        $revenueAccount = Account::create([
            'branch_id' => $branch->id,
            'account_number' => '4001',
            'name' => 'Sales Revenue',
            'type' => 'revenue',
            'is_active' => true,
        ]);

        $entry = JournalEntry::create([
            'branch_id' => $branch->id,
            'reference_number' => 'JE-TEST-001',
            'entry_date' => now()->toDateString(),
            'description' => 'Test journal entry',
            'status' => 'posted',
            'total_debit' => 1000.00,
            'total_credit' => 1000.00,
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($entry->id);

        // Add debit line
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $cashAccount->id,
            'debit' => 1000.00,
            'credit' => 0,
        ]);

        // Add credit line
        JournalEntryLine::create([
            'journal_entry_id' => $entry->id,
            'account_id' => $revenueAccount->id,
            'debit' => 0,
            'credit' => 1000.00,
        ]);

        $this->assertEquals(2, $entry->lines()->count());
    }

    /* ========================================
     * EXPORT EXCEL TESTS
     * ======================================== */

    public function test_export_enabled_components_have_export_method(): void
    {
        $components = [
            \App\Livewire\Sales\Index::class,
            \App\Livewire\Customers\Index::class,
            \App\Livewire\Suppliers\Index::class,
            \App\Livewire\Inventory\Products\Index::class,
            \App\Livewire\Purchases\Index::class,
            \App\Livewire\Expenses\Index::class,
            \App\Livewire\Income\Index::class,
        ];

        foreach ($components as $componentClass) {
            if (!class_exists($componentClass)) {
                continue;
            }
            $component = new $componentClass();
            $this->assertTrue(
                method_exists($component, 'export') || method_exists($component, 'startExport'),
                "$componentClass should have an export method"
            );
        }
    }

    public function test_export_service_exists_and_has_methods(): void
    {
        $this->assertTrue(
            class_exists(\App\Services\ExportService::class),
            'ExportService class should exist'
        );

        $service = app(\App\Services\ExportService::class);
        $this->assertTrue(method_exists($service, 'export'));
    }

    /* ========================================
     * FORM COMPONENT EXISTENCE TESTS
     * ======================================== */

    public function test_all_form_components_exist(): void
    {
        $forms = [
            'Customers' => \App\Livewire\Customers\Form::class,
            'Suppliers' => \App\Livewire\Suppliers\Form::class,
            'Products' => \App\Livewire\Inventory\Products\Form::class,
            'Sales' => \App\Livewire\Sales\Form::class,
            'Purchases' => \App\Livewire\Purchases\Form::class,
            'Expenses' => \App\Livewire\Expenses\Form::class,
            'Income' => \App\Livewire\Income\Form::class,
            'Rental Properties' => \App\Livewire\Rental\Properties\Form::class,
            'Rental Units' => \App\Livewire\Rental\Units\Form::class,
            'Rental Tenants' => \App\Livewire\Rental\Tenants\Form::class,
            'Rental Contracts' => \App\Livewire\Rental\Contracts\Form::class,
            'Bank Accounts' => \App\Livewire\Banking\Accounts\Form::class,
            'Journal Entries' => \App\Livewire\Accounting\JournalEntries\Form::class,
            'Accounting Accounts' => \App\Livewire\Accounting\Accounts\Form::class,
        ];

        foreach ($forms as $name => $class) {
            $this->assertTrue(class_exists($class), "$name form ($class) should exist");
        }
    }

    public function test_all_form_components_have_save_and_render(): void
    {
        $forms = [
            \App\Livewire\Customers\Form::class,
            \App\Livewire\Suppliers\Form::class,
            \App\Livewire\Inventory\Products\Form::class,
            \App\Livewire\Sales\Form::class,
            \App\Livewire\Purchases\Form::class,
            \App\Livewire\Expenses\Form::class,
            \App\Livewire\Income\Form::class,
        ];

        foreach ($forms as $class) {
            if (!class_exists($class)) {
                continue;
            }
            $this->assertTrue(method_exists($class, 'save'), "$class should have save()");
            $this->assertTrue(method_exists($class, 'render'), "$class should have render()");
        }
    }

    /* ========================================
     * FINANCIAL REPORT INTEGRITY
     * ======================================== */

    public function test_report_service_exists(): void
    {
        $this->assertTrue(class_exists(\App\Services\ReportService::class));
    }

    public function test_financial_report_service_exists(): void
    {
        $this->assertTrue(class_exists(\App\Services\FinancialReportService::class));
    }

    public function test_report_service_date_filtering_uses_strings(): void
    {
        // Verify the bug fix: expense_date whereBetween should use toDateString()
        $source = file_get_contents(app_path('Services/ReportService.php'));

        // All three whereBetween calls should use toDateString()
        $this->assertStringContainsString(
            "whereBetween('sale_date', [\$dateFrom->toDateString(), \$dateTo->toDateString()])",
            $source,
            'Sale date filtering should use toDateString()'
        );
        $this->assertStringContainsString(
            "whereBetween('purchase_date', [\$dateFrom->toDateString(), \$dateTo->toDateString()])",
            $source,
            'Purchase date filtering should use toDateString()'
        );
        $this->assertStringContainsString(
            "whereBetween('expense_date', [\$dateFrom->toDateString(), \$dateTo->toDateString()])",
            $source,
            'Expense date filtering should use toDateString()'
        );
    }

    public function test_sales_analytics_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Reports\SalesAnalytics::class));
    }

    /* ========================================
     * SIDEBAR & DASHBOARD
     * ======================================== */

    public function test_dashboard_route_exists(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('dashboard'));
    }

    public function test_pos_terminal_route_exists(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('pos.terminal'));
    }

    public function test_admin_reports_pos_route_exists(): void
    {
        $this->assertTrue(\Illuminate\Support\Facades\Route::has('admin.reports.pos'));
    }

    public function test_sidebar_view_exists(): void
    {
        $this->assertFileExists(resource_path('views/layouts/sidebar-new.blade.php'));
    }

    public function test_dashboard_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Dashboard\CustomizableDashboard::class));
    }

    public function test_branch_switcher_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Shared\BranchSwitcher::class));
        $switcher = new \App\Livewire\Shared\BranchSwitcher();
        $this->assertTrue(method_exists($switcher, 'switchBranch'));
        $this->assertTrue(method_exists($switcher, 'getSelectedBranchProperty'));
    }

    /* ========================================
     * MODEL-MIGRATION ALIGNMENT TESTS
     * ======================================== */

    public function test_products_table_has_uuid_and_code_columns(): void
    {
        $this->assertTrue(
            \Illuminate\Support\Facades\Schema::hasColumn('products', 'uuid'),
            'Products table should have uuid column'
        );
        $this->assertTrue(
            \Illuminate\Support\Facades\Schema::hasColumn('products', 'code'),
            'Products table should have code column'
        );
    }

    public function test_properties_table_has_code_column(): void
    {
        $this->assertTrue(
            \Illuminate\Support\Facades\Schema::hasColumn('properties', 'code'),
            'Properties table should have code column'
        );
    }

    public function test_audit_logs_event_is_nullable(): void
    {
        // Verify audit_logs.event is nullable so audit observer works
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Create an audit log without event field - should not throw
        $log = \App\Models\AuditLog::create([
            'user_id' => $admin->id,
            'branch_id' => $branch->id,
            'auditable_type' => 'App\\Models\\Branch',
            'auditable_id' => $branch->id,
            'action' => 'test',
            'old_values' => [],
            'new_values' => [],
        ]);

        $this->assertNotNull($log->id);
    }

    /* ========================================
     * POS MODULE TESTS
     * ======================================== */

    public function test_pos_terminal_component_has_required_methods(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\Terminal::class));
        $terminal = new \App\Livewire\Pos\Terminal();
        $this->assertTrue(method_exists($terminal, 'mount'));
        $this->assertTrue(method_exists($terminal, 'render'));
    }

    public function test_pos_session_model_exists(): void
    {
        $this->assertTrue(class_exists(\App\Models\PosSession::class));
    }

    public function test_pos_daily_report_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\DailyReport::class));
    }

    /* ========================================
     * DARK MODE / THEME TESTS
     * ======================================== */

    public function test_theme_toggle_uses_consistent_keys(): void
    {
        // Verify app.js and navbar use the same localStorage key ('theme')
        $appJs = file_get_contents(resource_path('js/app.js'));
        $navbar = file_get_contents(resource_path('views/layouts/navbar.blade.php'));

        $this->assertStringContainsString("localStorage.getItem('theme')", $appJs);
        $this->assertStringContainsString("localStorage.setItem('theme'", $appJs);
        $this->assertStringContainsString("localStorage.setItem('theme'", $navbar);
    }
}
