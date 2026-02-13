<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Income;
use App\Models\IncomeCategory;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserPreference;
use App\Services\CurrencyExchangeService;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

/**
 * Deep System Test Suite
 *
 * Comprehensive tests verifying bug fixes and core functionality.
 */
class DeepSystemTest extends TestCase
{
    // ──────────────────────────────────────────────────────────
    // 1. Customer Form saves is_active properly
    // ──────────────────────────────────────────────────────────

    public function test_customer_is_active_true_saved_correctly(): void
    {
        $branch = Branch::first();

        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Active Customer',
            'code' => 'TEST-ACT-001',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'is_active' => true,
        ]);
        $this->assertTrue($customer->fresh()->is_active);
    }

    public function test_customer_is_active_false_saved_correctly(): void
    {
        $branch = Branch::first();

        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Inactive Customer',
            'code' => 'TEST-INACT-001',
            'is_active' => false,
        ]);

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'is_active' => false,
        ]);
        $this->assertFalse($customer->fresh()->is_active);
    }

    // ──────────────────────────────────────────────────────────
    // 2. Expense Form stores attachments as JSON array
    // ──────────────────────────────────────────────────────────

    public function test_expense_attachment_stored_as_json_array(): void
    {
        $branch = Branch::first();
        $category = ExpenseCategory::create([
            'branch_id' => $branch->id,
            'name' => 'Test Category',
            'is_active' => true,
        ]);

        $expense = Expense::create([
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'reference_number' => 'EXP-TEST-001',
            'expense_date' => now()->toDateString(),
            'amount' => 100.0000,
            'total_amount' => 100.0000,
            'status' => 'pending',
            'attachments' => ['receipts/receipt1.pdf'],
        ]);

        $fresh = $expense->fresh();
        $this->assertIsArray($fresh->attachments);
        $this->assertContains('receipts/receipt1.pdf', $fresh->attachments);
    }

    // ──────────────────────────────────────────────────────────
    // 3. Income Form stores attachments as JSON array
    // ──────────────────────────────────────────────────────────

    public function test_income_attachment_stored_as_json_array(): void
    {
        $branch = Branch::first();
        $category = IncomeCategory::create([
            'branch_id' => $branch->id,
            'name' => 'Test Income Cat',
            'is_active' => true,
        ]);

        $income = Income::create([
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'reference_number' => 'INC-TEST-001',
            'income_date' => now()->toDateString(),
            'amount' => 500.0000,
            'total_amount' => 500.0000,
            'status' => 'received',
            'attachments' => ['invoices/inv1.pdf'],
        ]);

        $fresh = $income->fresh();
        $this->assertIsArray($fresh->attachments);
        $this->assertContains('invoices/inv1.pdf', $fresh->attachments);
    }

    // ──────────────────────────────────────────────────────────
    // 4. Tenant model has Notifiable trait
    // ──────────────────────────────────────────────────────────

    public function test_tenant_uses_notifiable_trait(): void
    {
        $traits = class_uses_recursive(Tenant::class);
        $this->assertContains(Notifiable::class, $traits);
    }

    public function test_tenant_has_notify_method(): void
    {
        $this->assertTrue(method_exists(Tenant::class, 'notify'));
    }

    // ──────────────────────────────────────────────────────────
    // 5. BCMath precision in financial calculations
    // ──────────────────────────────────────────────────────────

    public function test_decimal_float_helper_precision(): void
    {
        // Verify the helper exists and handles precision correctly
        $this->assertTrue(function_exists('decimal_float'));

        // Classic floating-point trap: 0.1 + 0.2 should be 0.3
        $result = decimal_float(bcadd('0.1', '0.2', 4), 2);
        $this->assertSame(0.3, $result);

        // Large financial amount precision
        $result = decimal_float(bcmul('99999.9999', '1.15', 4), 4);
        $this->assertIsFloat($result);
    }

    public function test_currency_exchange_same_currency_returns_same_amount(): void
    {
        $service = app(CurrencyExchangeService::class);
        $result = $service->convert(100.50, 'EGP', 'EGP');
        $this->assertSame(100.50, $result);
    }

    // ──────────────────────────────────────────────────────────
    // 6. Config/erp.php exists and has all keys
    // ──────────────────────────────────────────────────────────

    public function test_erp_config_has_discount_keys(): void
    {
        $this->assertNotNull(config('erp.discount.max_line'));
        $this->assertNotNull(config('erp.discount.max_invoice'));
        $this->assertIsFloat(config('erp.discount.max_line'));
        $this->assertIsFloat(config('erp.discount.max_invoice'));
    }

    public function test_erp_config_has_barcodes_dir(): void
    {
        $this->assertNotNull(config('erp.barcodes.dir'));
        $this->assertIsString(config('erp.barcodes.dir'));
    }

    public function test_erp_config_has_all_expected_keys(): void
    {
        $this->assertNotNull(config('erp.prefixes'));
        $this->assertNotNull(config('erp.pagination.default'));
        $this->assertNotNull(config('erp.currency.default'));
        $this->assertNotNull(config('erp.currency.decimals'));
        $this->assertNotNull(config('erp.export.max_rows'));
        $this->assertNotNull(config('erp.export.chunk_size'));
    }

    // ──────────────────────────────────────────────────────────
    // 7. Config/rental.php has buffer_hours
    // ──────────────────────────────────────────────────────────

    public function test_rental_config_has_buffer_hours(): void
    {
        $this->assertNotNull(config('rental.buffer_hours'));
        $this->assertIsInt(config('rental.buffer_hours'));
    }

    public function test_rental_config_has_all_expected_keys(): void
    {
        $this->assertNotNull(config('rental.grace_days'));
        $this->assertNotNull(config('rental.late_fee_type'));
        $this->assertNotNull(config('rental.reminder_days_before'));
        $this->assertNotNull(config('rental.security_deposit_percentage'));
    }

    // ──────────────────────────────────────────────────────────
    // 8. Role permissions are complete
    // ──────────────────────────────────────────────────────────

    public function test_admin_role_has_accounting_permissions(): void
    {
        $admin = Role::findByName('Admin', 'web');

        $this->assertTrue($admin->hasPermissionTo('accounting.view'));
        $this->assertTrue($admin->hasPermissionTo('accounting.create'));
        $this->assertTrue($admin->hasPermissionTo('accounting.update'));
    }

    public function test_admin_role_has_sales_permissions(): void
    {
        $admin = Role::findByName('Admin', 'web');

        $this->assertTrue($admin->hasPermissionTo('sales.create'));
        $this->assertTrue($admin->hasPermissionTo('sales.manage'));
    }

    public function test_admin_role_has_banking_permission(): void
    {
        $admin = Role::findByName('Admin', 'web');
        $this->assertTrue($admin->hasPermissionTo('banking.view'));
    }

    public function test_admin_role_has_expense_income_permissions(): void
    {
        $admin = Role::findByName('Admin', 'web');

        $this->assertTrue($admin->hasPermissionTo('expenses.view'));
        $this->assertTrue($admin->hasPermissionTo('income.view'));
    }

    public function test_accountant_role_has_accounting_view(): void
    {
        $accountant = Role::findByName('Accountant', 'web');
        $this->assertTrue($accountant->hasPermissionTo('accounting.view'));
    }

    // ──────────────────────────────────────────────────────────
    // 9. AutoLogout handles null preferences gracefully
    // ──────────────────────────────────────────────────────────

    public function test_auto_logout_middleware_exists(): void
    {
        $this->assertTrue(class_exists(\App\Http\Middleware\AutoLogout::class));
    }

    public function test_auto_logout_null_preferences_no_crash(): void
    {
        // The middleware checks: if ($preferences && $preferences->auto_logout)
        // When preferences is null, the condition short-circuits and no error occurs.
        $middleware = new \App\Http\Middleware\AutoLogout();
        $user = $this->createAdminUser();

        // Clear any cached preferences
        \Illuminate\Support\Facades\Cache::forget(sprintf('user_prefs:%d', $user->id));

        $this->actingAs($user);

        // Simulate a request through the middleware - should not throw
        $request = \Illuminate\Http\Request::create('/dashboard', 'GET');
        $request->setLaravelSession(app('session.store'));

        $response = $middleware->handle($request, function ($req) {
            return response('OK');
        });

        $this->assertEquals(200, $response->getStatusCode());
    }

    // ──────────────────────────────────────────────────────────
    // 10. WriteAuditTrail logs errors instead of swallowing
    // ──────────────────────────────────────────────────────────

    public function test_write_audit_trail_catch_uses_log_warning(): void
    {
        $reflection = new \ReflectionClass(\App\Listeners\WriteAuditTrail::class);
        $source = file_get_contents($reflection->getFileName());

        // Verify the catch block uses Log::warning (not silently swallowing)
        $this->assertStringContainsString('Log::warning(', $source);
        $this->assertStringContainsString('WriteAuditTrail: failed to write audit log', $source);
    }

    public function test_write_audit_trail_is_not_queued(): void
    {
        $reflection = new \ReflectionClass(\App\Listeners\WriteAuditTrail::class);

        // Should NOT implement ShouldQueue (synchronous for proper context capture)
        $this->assertFalse(
            $reflection->implementsInterface(\Illuminate\Contracts\Queue\ShouldQueue::class)
        );
    }

    // ──────────────────────────────────────────────────────────
    // 11. CurrencyExchangeService handles zero rate
    // ──────────────────────────────────────────────────────────

    public function test_currency_exchange_no_rate_returns_original_amount(): void
    {
        $service = app(CurrencyExchangeService::class);

        // When no rate exists, service should return original amount (no division by zero)
        Log::shouldReceive('warning')->once();
        $result = $service->convert(250.00, 'XXX', 'YYY');
        $this->assertEquals(250.00, $result);
    }

    // ──────────────────────────────────────────────────────────
    // 12. Livewire form components exist with save/render methods
    // ──────────────────────────────────────────────────────────

    public function test_livewire_form_components_exist(): void
    {
        $forms = [
            \App\Livewire\Customers\Form::class,
            \App\Livewire\Expenses\Form::class,
            \App\Livewire\Income\Form::class,
            \App\Livewire\Accounting\JournalEntries\Form::class,
            \App\Livewire\Sales\Form::class,
            \App\Livewire\Banking\Accounts\Form::class,
            \App\Livewire\Suppliers\Form::class,
            \App\Livewire\Rental\Tenants\Form::class,
            \App\Livewire\Inventory\Products\Form::class,
        ];

        foreach ($forms as $formClass) {
            $this->assertTrue(class_exists($formClass), "Form class {$formClass} should exist");
        }
    }

    public function test_livewire_form_components_have_save_method(): void
    {
        $forms = [
            \App\Livewire\Customers\Form::class,
            \App\Livewire\Expenses\Form::class,
            \App\Livewire\Income\Form::class,
            \App\Livewire\Accounting\JournalEntries\Form::class,
            \App\Livewire\Sales\Form::class,
            \App\Livewire\Banking\Accounts\Form::class,
            \App\Livewire\Suppliers\Form::class,
        ];

        foreach ($forms as $formClass) {
            $this->assertTrue(
                method_exists($formClass, 'save'),
                "{$formClass} should have a save() method"
            );
        }
    }

    public function test_livewire_form_components_have_render_method(): void
    {
        $forms = [
            \App\Livewire\Customers\Form::class,
            \App\Livewire\Expenses\Form::class,
            \App\Livewire\Income\Form::class,
            \App\Livewire\Accounting\JournalEntries\Form::class,
            \App\Livewire\Sales\Form::class,
        ];

        foreach ($forms as $formClass) {
            $this->assertTrue(
                method_exists($formClass, 'render'),
                "{$formClass} should have a render() method"
            );
        }
    }

    // ──────────────────────────────────────────────────────────
    // 13. Model columns match migration columns for key models
    // ──────────────────────────────────────────────────────────

    public function test_customers_table_has_is_active_column(): void
    {
        $this->assertTrue(Schema::hasColumn('customers', 'is_active'));
    }

    public function test_expenses_table_has_attachments_column(): void
    {
        $this->assertTrue(Schema::hasColumn('expenses', 'attachments'));
    }

    public function test_incomes_table_has_attachments_column(): void
    {
        $this->assertTrue(Schema::hasColumn('incomes', 'attachments'));
    }

    public function test_customers_table_has_expected_columns(): void
    {
        $expected = [
            'id', 'branch_id', 'code', 'name', 'is_active', 'is_blocked',
            'email', 'phone', 'credit_limit', 'balance',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('customers', $column),
                "customers table should have '{$column}' column"
            );
        }
    }

    public function test_expenses_table_has_expected_columns(): void
    {
        $expected = [
            'id', 'branch_id', 'reference_number', 'expense_date',
            'amount', 'total_amount', 'status', 'attachments',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('expenses', $column),
                "expenses table should have '{$column}' column"
            );
        }
    }

    public function test_incomes_table_has_expected_columns(): void
    {
        $expected = [
            'id', 'branch_id', 'reference_number', 'income_date',
            'amount', 'total_amount', 'status', 'attachments',
        ];

        foreach ($expected as $column) {
            $this->assertTrue(
                Schema::hasColumn('incomes', $column),
                "incomes table should have '{$column}' column"
            );
        }
    }

    // ──────────────────────────────────────────────────────────
    // 14. Export functionality - HasExport trait
    // ──────────────────────────────────────────────────────────

    public function test_has_export_trait_exists(): void
    {
        $this->assertTrue(trait_exists(\App\Traits\HasExport::class));
    }

    public function test_index_components_use_has_export_trait(): void
    {
        $indexComponents = [
            \App\Livewire\Customers\Index::class,
            \App\Livewire\Expenses\Index::class,
            \App\Livewire\Income\Index::class,
            \App\Livewire\Sales\Index::class,
            \App\Livewire\Suppliers\Index::class,
        ];

        foreach ($indexComponents as $component) {
            $traits = class_uses_recursive($component);
            $this->assertContains(
                \App\Traits\HasExport::class,
                $traits,
                "{$component} should use HasExport trait"
            );
        }
    }

    public function test_has_export_trait_provides_required_methods(): void
    {
        $methods = ['openExportModal', 'closeExportModal', 'toggleAllExportColumns'];

        foreach ($methods as $method) {
            // Check any component that uses the trait
            $this->assertTrue(
                method_exists(\App\Livewire\Customers\Index::class, $method),
                "HasExport trait should provide {$method}()"
            );
        }
    }

    // ──────────────────────────────────────────────────────────
    // Additional regression tests
    // ──────────────────────────────────────────────────────────

    public function test_customer_casts_boolean_fields(): void
    {
        $branch = Branch::first();

        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Cast Test',
            'code' => 'TEST-CAST-001',
            'is_active' => 1,
            'is_blocked' => 0,
        ]);

        $fresh = $customer->fresh();
        $this->assertIsBool($fresh->is_active);
        $this->assertIsBool($fresh->is_blocked);
        $this->assertTrue($fresh->is_active);
        $this->assertFalse($fresh->is_blocked);
    }

    public function test_expense_casts_decimal_fields(): void
    {
        $branch = Branch::first();
        $category = ExpenseCategory::create([
            'branch_id' => $branch->id,
            'name' => 'Decimal Test Cat',
            'is_active' => true,
        ]);

        $expense = Expense::create([
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'reference_number' => 'EXP-DEC-001',
            'expense_date' => now()->toDateString(),
            'amount' => 123.4567,
            'total_amount' => 123.4567,
            'status' => 'pending',
        ]);

        $fresh = $expense->fresh();
        $this->assertIsNumeric($fresh->amount);
    }

    public function test_tenant_can_be_created(): void
    {
        $branch = Branch::first();

        $tenant = Tenant::create([
            'branch_id' => $branch->id,
            'name' => 'Test Tenant',
            'email' => 'tenant@test.com',
            'phone' => '1234567890',
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('tenants', [
            'id' => $tenant->id,
            'name' => 'Test Tenant',
            'is_active' => true,
        ]);
    }

    public function test_customer_auto_generates_code_when_empty(): void
    {
        $branch = Branch::first();

        $customer = Customer::create([
            'branch_id' => $branch->id,
            'name' => 'Auto Code Customer',
            'is_active' => true,
        ]);

        $this->assertNotNull($customer->code);
        $this->assertNotEmpty($customer->code);
    }

    public function test_expense_multiple_attachments(): void
    {
        $branch = Branch::first();
        $category = ExpenseCategory::create([
            'branch_id' => $branch->id,
            'name' => 'Multi Attach Cat',
            'is_active' => true,
        ]);

        $attachments = [
            'receipts/receipt1.pdf',
            'receipts/receipt2.jpg',
            'receipts/receipt3.png',
        ];

        $expense = Expense::create([
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'reference_number' => 'EXP-MULTI-001',
            'expense_date' => now()->toDateString(),
            'amount' => 200.0000,
            'total_amount' => 200.0000,
            'status' => 'pending',
            'attachments' => $attachments,
        ]);

        $fresh = $expense->fresh();
        $this->assertCount(3, $fresh->attachments);
        $this->assertEquals($attachments, $fresh->attachments);
    }
}
