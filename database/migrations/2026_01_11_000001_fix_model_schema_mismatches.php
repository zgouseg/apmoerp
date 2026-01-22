<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration: Fix Model↔Schema Mismatches
 *
 * APMOERP66 Audit Fix: Models are the source of truth.
 * This migration aligns database schema with existing model definitions.
 *
 * Tables Fixed:
 * - stock_transfers: Add missing columns from StockTransfer model
 * - stock_transfer_items: Rename columns and add missing fields from StockTransferItem model
 * - rental_periods: Recreate table to match RentalPeriod model (different purpose)
 * - stock_movements: Adjust for StockMovement model (timestamps only, no softDeletes needed per model)
 */
return new class extends Migration
{
    public function up(): void
    {
        // =====================================================
        // 1. FIX stock_transfers table
        // =====================================================
        Schema::table('stock_transfers', function (Blueprint $table) {
            // Rename columns to match model
            $table->renameColumn('reference_number', 'transfer_number');
            $table->renameColumn('type', 'transfer_type');
            $table->renameColumn('expected_arrival_date', 'expected_delivery_date');
            $table->renameColumn('actual_arrival_date', 'actual_delivery_date');
        });

        Schema::table('stock_transfers', function (Blueprint $table) {
            // Add missing columns from StockTransfer model
            $table->text('internal_notes')->nullable()->after('notes');
            $table->string('courier_name', 100)->nullable()->after('tracking_number');
            $table->string('vehicle_number', 50)->nullable()->after('courier_name');
            $table->string('driver_name', 100)->nullable()->after('vehicle_number');
            $table->string('driver_phone', 50)->nullable()->after('driver_name');
            $table->decimal('insurance_cost', 18, 2)->default(0)->after('shipping_cost');
            $table->decimal('total_cost', 18, 2)->default(0)->after('insurance_cost');
            $table->string('currency', 10)->default('USD')->after('total_cost');

            // Add quantity tracking columns
            $table->decimal('total_qty_requested', 18, 3)->default(0)->after('currency');
            $table->decimal('total_qty_shipped', 18, 3)->default(0)->after('total_qty_requested');
            $table->decimal('total_qty_received', 18, 3)->default(0)->after('total_qty_shipped');
            $table->decimal('total_qty_damaged', 18, 3)->default(0)->after('total_qty_received');

            // Add requested_by and updated_by
            $table->foreignId('requested_by')
                ->nullable()
                ->after('received_at')
                ->constrained('users')
                ->nullOnDelete()
                ->name('fk_stktrf_requested_by__usr');

            $table->foreignId('updated_by')
                ->nullable()
                ->after('created_by')
                ->constrained('users')
                ->nullOnDelete()
                ->name('fk_stktrf_updated_by__usr');
        });

        // Update unique constraint for transfer_number
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->dropUnique('uq_stktrf_branch_ref');
            $table->unique(['branch_id', 'transfer_number'], 'uq_stktrf_branch_transfer');
        });

        // =====================================================
        // 2. FIX stock_transfer_items table
        // =====================================================
        Schema::table('stock_transfer_items', function (Blueprint $table) {
            // Rename columns to match model (qty_* instead of quantity_*)
            $table->renameColumn('quantity_requested', 'qty_requested');
            $table->renameColumn('quantity_shipped', 'qty_shipped');
            $table->renameColumn('quantity_received', 'qty_received');
            $table->renameColumn('quantity_damaged', 'qty_damaged');
        });

        Schema::table('stock_transfer_items', function (Blueprint $table) {
            // Add missing columns from StockTransferItem model
            $table->foreignId('branch_id')
                ->nullable()
                ->after('id')
                ->constrained('branches')
                ->nullOnDelete()
                ->name('fk_stktrfi_branch__brnch');

            $table->decimal('qty_approved', 18, 3)->default(0)->after('qty_requested');
            $table->string('condition_on_shipping', 50)->nullable()->after('notes');
            $table->string('condition_on_receiving', 50)->nullable()->after('condition_on_shipping');
            $table->text('damage_report')->nullable()->after('condition_on_receiving');

            // Add branch index
            $table->index('branch_id', 'idx_stktrfi_branch_id');
        });

        // Remove the sku column that's not in model
        if (Schema::hasColumn('stock_transfer_items', 'sku')) {
            Schema::table('stock_transfer_items', function (Blueprint $table) {
                $table->dropColumn('sku');
            });
        }

        // =====================================================
        // 3. FIX transfer_items table
        // Model extends BaseModel (has SoftDeletes) and has branch_id
        // Migration doesn't have branch_id or softDeletes
        // =====================================================
        Schema::table('transfer_items', function (Blueprint $table) {
            $table->foreignId('branch_id')
                ->nullable()
                ->after('id')
                ->constrained('branches')
                ->nullOnDelete()
                ->name('fk_trfi_branch__brnch');

            $table->softDeletes();
            $table->index('branch_id', 'idx_trfi_branch_id');
        });

        // =====================================================
        // 4. FIX adjustment_items table
        // Model extends BaseModel (has SoftDeletes) and has branch_id
        // Migration doesn't have branch_id or softDeletes
        // =====================================================
        Schema::table('adjustment_items', function (Blueprint $table) {
            // Note: branch_id already added via 2026_01_10_000001 migration
            // Just add softDeletes to match BaseModel's SoftDeletes trait
            $table->softDeletes();
        });

        // =====================================================
        // 5. FIX rental_periods table
        // The model defines a completely different structure than the migration.
        // The model is for rental period TYPES (daily, weekly, monthly),
        // while the migration was for contract billing periods.
        // We need to add the model's columns to support the model's use case.
        // =====================================================
        Schema::table('rental_periods', function (Blueprint $table) {
            // Add columns from RentalPeriod model that don't exist
            $table->foreignId('module_id')
                ->nullable()
                ->after('id')
                ->constrained('modules')
                ->nullOnDelete()
                ->name('fk_rntprd_module__mod');

            $table->foreignId('branch_id')
                ->nullable()
                ->after('module_id')
                ->constrained('branches')
                ->nullOnDelete()
                ->name('fk_rntprd_branch__brnch');

            $table->string('period_key', 50)->nullable()->after('branch_id');
            $table->string('period_name', 100)->nullable()->after('period_key');
            $table->string('period_name_ar', 100)->nullable()->after('period_name');
            $table->string('period_type', 30)->nullable()->after('period_name_ar');
            $table->integer('duration_value')->nullable()->after('period_type');
            $table->string('duration_unit', 20)->nullable()->after('duration_value');
            $table->decimal('price_multiplier', 18, 4)->default(1)->after('duration_unit');
            $table->boolean('is_default')->default(false)->after('price_multiplier');
            $table->boolean('is_active')->default(true)->after('is_default');
            $table->integer('sort_order')->default(0)->after('is_active');

            // Add softDeletes since model extends BaseModel which uses SoftDeletes
            $table->softDeletes();

            // Add indexes
            $table->index('branch_id', 'idx_rntprd_branch_id');
            $table->index('module_id', 'idx_rntprd_module_id');
            $table->index('is_active', 'idx_rntprd_is_active');
        });

        // =====================================================
        // 4. FIX stock_transfer_history table
        // Model uses changed_by, changed_at, metadata
        // Migration uses user_id, performed_at, action, changes
        // =====================================================
        Schema::table('stock_transfer_history', function (Blueprint $table) {
            $table->renameColumn('user_id', 'changed_by');
            $table->renameColumn('performed_at', 'changed_at');
            $table->renameColumn('changes', 'metadata');
        });

        // Drop the 'action' column that's not in model (after rename to avoid conflicts)
        Schema::table('stock_transfer_history', function (Blueprint $table) {
            $table->dropColumn('action');
        });

        // =====================================================
        // 7. Note on stock_movements table
        // The model has $timestamps = false and doesn't use SoftDeletes
        // But migration has both timestamps() and softDeletes()
        // Keep the schema as-is since it's broader than model needs
        // The model can work with extra columns present
        // =====================================================
        // Note: StockMovement model says "migration only has created_at" but actually
        // the migration has timestamps() and softDeletes(). The model works with this
        // since it manually sets created_at. No change needed.
    }

    public function down(): void
    {
        // Revert stock_transfer_history changes
        Schema::table('stock_transfer_history', function (Blueprint $table) {
            $table->string('action', 50)->nullable()->after('changed_by');
        });

        Schema::table('stock_transfer_history', function (Blueprint $table) {
            $table->renameColumn('metadata', 'changes');
            $table->renameColumn('changed_at', 'performed_at');
            $table->renameColumn('changed_by', 'user_id');
        });

        // Revert adjustment_items changes
        Schema::table('adjustment_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // Revert transfer_items changes
        Schema::table('transfer_items', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex('idx_trfi_branch_id');
            $table->dropForeign('fk_trfi_branch__brnch');
            $table->dropColumn('branch_id');
        });

        // Revert rental_periods changes
        Schema::table('rental_periods', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropIndex('idx_rntprd_is_active');
            $table->dropIndex('idx_rntprd_module_id');
            $table->dropIndex('idx_rntprd_branch_id');
            $table->dropForeign('fk_rntprd_branch__brnch');
            $table->dropForeign('fk_rntprd_module__mod');
            $table->dropColumn([
                'module_id', 'branch_id', 'period_key', 'period_name', 'period_name_ar',
                'period_type', 'duration_value', 'duration_unit', 'price_multiplier',
                'is_default', 'is_active', 'sort_order'
            ]);
        });

        // Revert stock_transfer_items changes
        Schema::table('stock_transfer_items', function (Blueprint $table) {
            $table->dropColumn(['damage_report', 'condition_on_receiving', 'condition_on_shipping', 'qty_approved']);
            $table->dropIndex('idx_stktrfi_branch_id');
            $table->dropForeign('fk_stktrfi_branch__brnch');
            $table->dropColumn('branch_id');
            $table->string('sku', 100)->nullable()->after('product_id');
        });

        Schema::table('stock_transfer_items', function (Blueprint $table) {
            $table->renameColumn('qty_requested', 'quantity_requested');
            $table->renameColumn('qty_shipped', 'quantity_shipped');
            $table->renameColumn('qty_received', 'quantity_received');
            $table->renameColumn('qty_damaged', 'quantity_damaged');
        });

        // Revert stock_transfers changes - order matters!
        // First drop the new unique constraint
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->dropUnique('uq_stktrf_branch_transfer');
        });

        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->dropForeign('fk_stktrf_updated_by__usr');
            $table->dropForeign('fk_stktrf_requested_by__usr');
            $table->dropColumn([
                'internal_notes', 'courier_name', 'vehicle_number', 'driver_name', 'driver_phone',
                'insurance_cost', 'total_cost', 'currency',
                'total_qty_requested', 'total_qty_shipped', 'total_qty_received', 'total_qty_damaged',
                'requested_by', 'updated_by'
            ]);
        });

        // Rename columns back to original names
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->renameColumn('transfer_number', 'reference_number');
            $table->renameColumn('transfer_type', 'type');
            $table->renameColumn('expected_delivery_date', 'expected_arrival_date');
            $table->renameColumn('actual_delivery_date', 'actual_arrival_date');
        });

        // Now recreate the original unique constraint with original column name
        Schema::table('stock_transfers', function (Blueprint $table) {
            $table->unique(['branch_id', 'reference_number'], 'uq_stktrf_branch_ref');
        });
    }
};
