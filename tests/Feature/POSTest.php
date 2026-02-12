<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Sale;
use App\Models\SalePayment;
use App\Models\Branch;

/**
 * POS (Point of Sale) Test Suite
 *
 * Tests POS functionality including:
 * - Terminal access and branch context
 * - Sale creation
 * - Payment processing
 * - Component existence and Livewire rendering
 */
class POSTest extends TestCase
{
    /* ========================================
     * POS MODEL TESTS
     * ======================================== */

    /**
     * Test Sale model has POS-specific attributes.
     */
    public function test_sale_model_has_pos_attributes(): void
    {
        $sale = new Sale();

        // Check fillable has POS fields
        $this->assertContains('is_pos_sale', $sale->getFillable());
        $this->assertContains('pos_session_id', $sale->getFillable());
        $this->assertContains('change_amount', $sale->getFillable());
    }

    /**
     * Test RentalInvoice is separate from Sale.
     */
    public function test_rental_invoice_is_separate_from_sale(): void
    {
        $sale = new Sale();
        $rentalInvoice = new \App\Models\RentalInvoice();

        // Different tables
        $this->assertEquals('sales', $sale->getTable());
        $this->assertEquals('rental_invoices', $rentalInvoice->getTable());

        // Different module keys
        $this->assertNotEquals(
            $sale->getModuleKey(),
            $rentalInvoice->getModuleKey()
        );
    }

    /* ========================================
     * POS ROUTE TESTS
     * ======================================== */

    /**
     * Test POS terminal route loads with proper branch context.
     * Uses withoutVite() to avoid Vite manifest errors in test env.
     */
    public function test_pos_terminal_loads_with_branch_context(): void
    {
        $this->withoutVite();

        $admin = $this->createAdminUser();
        $branch = Branch::first();

        // Set branch context in session to simulate BranchSwitcher
        session(['admin_branch_context' => $branch->id]);

        $response = $this->actingAs($admin)->get('/pos');

        // Should NOT get 403 anymore (branch fallback is in place)
        $this->assertNotEquals(403, $response->status(), 'POS should not return 403 with branch context');

        // Clean up any unclosed output buffers from Livewire rendering
        while (ob_get_level() > 1) {
            ob_end_clean();
        }
    }

    /**
     * Test POS terminal falls back to user branch when no session context.
     */
    public function test_pos_terminal_falls_back_to_user_branch(): void
    {
        $this->withoutVite();

        $admin = $this->createAdminUser();

        // Do NOT set branch context - terminal should fall back to user's branch
        $response = $this->actingAs($admin)->get('/pos');

        // Should NOT get 403 because Terminal falls back to user->branch_id
        $this->assertNotEquals(403, $response->status(), 'POS should fall back to user branch');

        // Clean up any unclosed output buffers from Livewire rendering
        while (ob_get_level() > 1) {
            ob_end_clean();
        }
    }

    /**
     * Test POS daily report route loads.
     */
    public function test_pos_daily_report_loads(): void
    {
        $this->withoutVite();

        $admin = $this->createAdminUser();
        $branch = Branch::first();
        session(['admin_branch_context' => $branch->id]);

        ob_start();
        $response = $this->actingAs($admin)->get('/pos/daily-report');
        ob_end_clean();

        // Should not get 403
        $this->assertNotEquals(403, $response->status());
    }

    /* ========================================
     * POS LIVEWIRE COMPONENT TESTS
     * ======================================== */

    /**
     * Test POS Terminal component exists.
     */
    public function test_pos_terminal_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\Terminal::class));
    }

    /**
     * Test POS HoldList component exists.
     */
    public function test_pos_hold_list_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\HoldList::class));
    }

    /**
     * Test POS ReceiptPreview component exists.
     */
    public function test_pos_receipt_preview_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\ReceiptPreview::class));
    }

    /**
     * Test POS DailyReport component exists.
     */
    public function test_pos_daily_report_component_exists(): void
    {
        $this->assertTrue(class_exists(\App\Livewire\Pos\DailyReport::class));
    }

    /**
     * Test POS Terminal has required methods.
     */
    public function test_pos_terminal_has_required_methods(): void
    {
        $reflection = new \ReflectionClass(\App\Livewire\Pos\Terminal::class);

        $this->assertTrue($reflection->hasMethod('mount'), 'Terminal should have mount method');
        $this->assertTrue($reflection->hasMethod('render'), 'Terminal should have render method');
        $this->assertTrue($reflection->hasMethod('boot'), 'Terminal should have boot method');
    }

    /* ========================================
     * SALE CREATION TESTS
     * ======================================== */

    /**
     * Test can create a POS sale.
     */
    public function test_can_create_pos_sale(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $sale = Sale::create([
            'branch_id' => $branch->id,
            'is_pos_sale' => true,
            'type' => 'invoice',
            'status' => 'completed',
            'payment_status' => 'paid',
            'sale_date' => now(),
            'subtotal' => 100.00,
            'total_amount' => 100.00,
            'paid_amount' => 100.00,
            'created_by' => $admin->id,
        ]);

        $this->assertNotNull($sale->id);
        $this->assertTrue($sale->is_pos_sale);
        $this->assertEquals('completed', $sale->status);
    }

    /**
     * Test POS sale has correct relationships.
     */
    public function test_pos_sale_has_relationships(): void
    {
        $sale = new Sale();

        $this->assertTrue(method_exists($sale, 'items'));
        $this->assertTrue(method_exists($sale, 'payments'));
        $this->assertTrue(method_exists($sale, 'customer'));
        $this->assertTrue(method_exists($sale, 'branch'));
    }

    /* ========================================
     * POS PAYMENT TESTS
     * ======================================== */

    /**
     * Test SalePayment model exists.
     */
    public function test_sale_payment_model_exists(): void
    {
        $this->assertTrue(class_exists(SalePayment::class));
    }

    /**
     * Test can record payment for sale.
     */
    public function test_can_record_sale_payment(): void
    {
        $admin = $this->createAdminUser();
        $branch = Branch::first();

        $sale = Sale::create([
            'branch_id' => $branch->id,
            'is_pos_sale' => true,
            'type' => 'invoice',
            'status' => 'pending',
            'payment_status' => 'pending',
            'sale_date' => now(),
            'subtotal' => 100.00,
            'total_amount' => 100.00,
            'paid_amount' => 0,
            'created_by' => $admin->id,
        ]);

        $payment = SalePayment::create([
            'sale_id' => $sale->id,
            'payment_method' => 'cash',
            'amount' => 100.00,
            'payment_date' => now(),
        ]);

        $this->assertNotNull($payment->id);
        $this->assertEquals($sale->id, $payment->sale_id);
        $this->assertEquals('cash', $payment->payment_method);
    }

    /* ========================================
     * INVOICE MODEL CLARIFICATION TESTS
     * ======================================== */

    /**
     * Test confirms Sale model is used for POS invoices.
     */
    public function test_sale_model_used_for_pos_invoices(): void
    {
        $sale = new Sale();

        $this->assertContains('type', $sale->getFillable());
        $this->assertContains('is_pos_sale', $sale->getFillable());
    }

    /**
     * Test RentalInvoice is only for rentals module.
     */
    public function test_rental_invoice_only_for_rentals(): void
    {
        $rentalInvoice = new \App\Models\RentalInvoice();

        $this->assertEquals('rentals', $rentalInvoice->getModuleKey());
        $this->assertTrue(method_exists($rentalInvoice, 'contract'));
    }
}
