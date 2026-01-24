<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * QA Test Suite: Finance Module
 * 
 * Goal: Finance module should load, render, and perform core flows without 500 errors.
 */
class FinanceModuleTest extends TestCase
{
    /**
     * Test accounting index page loads.
     */
    public function test_accounting_index_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/accounting');
        
        $this->assertNotEquals(500, $response->status(), 'Accounting index should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Accounting index should return 200 or redirect');
    }

    /**
     * Test banking index page loads.
     */
    public function test_banking_index_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/banking');
        
        $this->assertNotEquals(500, $response->status(), 'Banking index should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Banking index should return 200 or redirect');
    }

    /**
     * Test bank accounts list loads.
     */
    public function test_bank_accounts_list_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/banking/accounts');
        
        $this->assertNotEquals(500, $response->status(), 'Bank accounts list should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Bank accounts should return 200 or redirect');
    }

    /**
     * Test bank account create form loads.
     */
    public function test_bank_account_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/banking/accounts/create');
        
        $this->assertNotEquals(500, $response->status(), 'Bank account create form should not return 500');
    }

    /**
     * Test bank transactions list loads.
     */
    public function test_bank_transactions_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/banking/transactions');
        
        $this->assertNotEquals(500, $response->status(), 'Bank transactions should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Transactions should return 200 or redirect');
    }

    /**
     * Test bank reconciliation page loads.
     */
    public function test_bank_reconciliation_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/banking/reconciliation');
        
        $this->assertNotEquals(500, $response->status(), 'Bank reconciliation should not return 500');
    }

    /**
     * Test expenses index loads.
     */
    public function test_expenses_index_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/expenses');
        
        $this->assertNotEquals(500, $response->status(), 'Expenses index should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Expenses should return 200 or redirect');
    }

    /**
     * Test expenses create form loads.
     */
    public function test_expenses_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/expenses/create');
        
        $this->assertNotEquals(500, $response->status(), 'Expenses create form should not return 500');
    }

    /**
     * Test expense categories loads.
     */
    public function test_expense_categories_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/expenses/categories');
        
        $this->assertNotEquals(500, $response->status(), 'Expense categories should not return 500');
    }

    /**
     * Test income index loads.
     */
    public function test_income_index_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/income');
        
        $this->assertNotEquals(500, $response->status(), 'Income index should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Income should return 200 or redirect');
    }

    /**
     * Test income create form loads.
     */
    public function test_income_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/income/create');
        
        $this->assertNotEquals(500, $response->status(), 'Income create form should not return 500');
    }

    /**
     * Test income categories loads.
     */
    public function test_income_categories_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/income/categories');
        
        $this->assertNotEquals(500, $response->status(), 'Income categories should not return 500');
    }

    /**
     * Test fixed assets index loads.
     */
    public function test_fixed_assets_index_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/fixed-assets');
        
        $this->assertNotEquals(500, $response->status(), 'Fixed assets index should not return 500');
        $this->assertContains($response->status(), [200, 302], 'Fixed assets should return 200 or redirect');
    }

    /**
     * Test fixed assets create form loads.
     */
    public function test_fixed_assets_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/fixed-assets/create');
        
        $this->assertNotEquals(500, $response->status(), 'Fixed assets create form should not return 500');
    }

    /**
     * Test accounting accounts create form loads.
     */
    public function test_accounting_accounts_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/accounting/accounts/create');
        
        $this->assertNotEquals(500, $response->status(), 'Accounting accounts create form should not return 500');
    }

    /**
     * Test journal entries create form loads.
     */
    public function test_journal_entries_create_form_loads(): void
    {
        $admin = $this->createAdminUser();
        
        $response = $this->actingAs($admin)->get('/app/accounting/journal-entries/create');
        
        $this->assertNotEquals(500, $response->status(), 'Journal entries create form should not return 500');
    }
}
