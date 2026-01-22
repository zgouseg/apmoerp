<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CRIT-DB-01/CRIT-DB-04 FIX: StockMovement now extends Model directly instead of BaseModel.
 * - Removed HasBranch trait to avoid BranchScope since branch_id was not in original schema
 * - Added SoftDeletes to match migration schema (stock_movements has deleted_at column)
 * - Enabled timestamps since migration has timestamps() (previously $timestamps = false was wrong)
 */
class StockMovement extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'stock_movements';

    // Movement type constants
    public const TYPE_PURCHASE = 'purchase';
    public const TYPE_SALE = 'sale';
    public const TYPE_TRANSFER = 'transfer';
    public const TYPE_TRANSFER_IN = 'transfer_in';
    public const TYPE_TRANSFER_OUT = 'transfer_out';
    public const TYPE_ADJUSTMENT = 'adjustment';
    public const TYPE_RETURN = 'return';
    public const TYPE_INITIAL = 'initial';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000003_create_inventory_tables.php
     * Note: branch_id was added via later migration but filtering is done via parent relationships
     */
    protected $fillable = [
        'product_id',
        'warehouse_id',
        'batch_id',
        'movement_type',
        'reference_type',
        'reference_id',
        'quantity',
        'unit_cost',
        'stock_before',
        'stock_after',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'stock_before' => 'decimal:4',
        'stock_after' => 'decimal:4',
    ];

    // CRIT-DB-04 FIX: Enabled timestamps - migration has both created_at and updated_at

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
    }

    /**
     * Polymorphic source document: PurchaseItem, SaleItem, AdjustmentItem, TransferItem, etc.
     */
    public function source(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeIn(Builder $query): Builder
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeOut(Builder $query): Builder
    {
        return $query->where('quantity', '<', 0);
    }

    public function scopeForProduct(Builder $query, $id): Builder
    {
        return $query->where('product_id', $id);
    }

    public function scopePurchase(Builder $query): Builder
    {
        return $query->where('movement_type', 'purchase');
    }

    public function scopeSale(Builder $query): Builder
    {
        return $query->where('movement_type', 'sale');
    }

    public function scopeTransfer(Builder $query): Builder
    {
        return $query->where('movement_type', 'transfer');
    }

    public function scopeAdjustment(Builder $query): Builder
    {
        return $query->where('movement_type', 'adjustment');
    }

    // Backward compatibility accessors
    public function getQtyAttribute()
    {
        return $this->quantity;
    }

    public function setQtyAttribute($value): void
    {
        $this->attributes['quantity'] = $value;
    }

    public function getDirectionAttribute(): string
    {
        return $this->quantity >= 0 ? 'in' : 'out';
    }

    public function getTypeAttribute(): ?string
    {
        return $this->movement_type;
    }

    public function setTypeAttribute($value): void
    {
        $this->attributes['movement_type'] = $value;
    }
}
