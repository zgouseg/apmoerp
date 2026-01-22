<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CRIT-DB-03 FIX: StockTransferItem model fields aligned with migration schema.
 * - Removed HasBranch trait (branch filtering via parent StockTransfer)
 * - Fixed column names: qty_* → quantity_*
 * - Removed columns that don't exist in schema
 */
class StockTransferItem extends Model
{
    use HasFactory;

    protected $table = 'stock_transfer_items';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000003_create_inventory_tables.php
     */
    protected $fillable = [
        'stock_transfer_id',
        'product_id',
        'sku',
        'quantity_requested',
        'quantity_shipped',
        'quantity_received',
        'quantity_damaged',
        'unit_cost',
        'batch_number',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity_requested' => 'decimal:3',
        'quantity_shipped' => 'decimal:3',
        'quantity_received' => 'decimal:3',
        'quantity_damaged' => 'decimal:3',
        'unit_cost' => 'decimal:2',
        'expiry_date' => 'date',
    ];

    /**
     * Relationships
     */
    public function stockTransfer(): BelongsTo
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Check if item is fully received
     */
    public function isFullyReceived(): bool
    {
        return bccomp((string)$this->quantity_shipped, (string)$this->quantity_received, 3) === 0;
    }

    /**
     * Check if item has damage
     */
    public function hasDamage(): bool
    {
        return $this->quantity_damaged > 0;
    }

    /**
     * Get variance between shipped and received
     * Note: Uses 3 decimal places for quantity variance (not currency) to preserve precision
     */
    public function getVariance(): float
    {
        return decimal_float(bcsub((string)$this->quantity_shipped, (string)$this->quantity_received, 3), 3);
    }

    // Backward compatibility accessors
    public function getQtyRequestedAttribute(): ?float
    {
        return $this->quantity_requested !== null ? (float) $this->quantity_requested : null;
    }

    public function getQtyShippedAttribute(): ?float
    {
        return $this->quantity_shipped !== null ? (float) $this->quantity_shipped : null;
    }

    public function getQtyReceivedAttribute(): ?float
    {
        return $this->quantity_received !== null ? (float) $this->quantity_received : null;
    }

    public function getQtyDamagedAttribute(): ?float
    {
        return $this->quantity_damaged !== null ? (float) $this->quantity_damaged : null;
    }
}
