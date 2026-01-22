<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CRIT-DB-01 FIX: AdjustmentItem now extends Model directly instead of BaseModel.
 * Line-item tables inherit branch context from their parent (Adjustment) and don't need
 * their own BranchScope. The adjustment_items table has no softDeletes, and branch_id is
 * optional (added via later migration but filtering is done via parent relationship).
 */
class AdjustmentItem extends Model
{
    use HasFactory;

    protected $table = 'adjustment_items';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000003_create_inventory_tables.php
     * Note: branch_id removed as it's inherited from parent Adjustment record
     */
    protected $fillable = [
        'adjustment_id',
        'product_id',
        'system_quantity',
        'counted_quantity',
        'difference',
        'unit_cost',
        'notes',
    ];

    protected $casts = [
        'system_quantity' => 'decimal:4',
        'counted_quantity' => 'decimal:4',
        'difference' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    public function adjustment(): BelongsTo
    {
        return $this->belongsTo(Adjustment::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Backward compatibility accessor.
     * Original qty field represented the adjustment difference (can be positive or negative).
     * Maps to 'difference' column which stores: counted_quantity - system_quantity
     */
    public function getQtyAttribute()
    {
        return $this->difference;
    }

    public function setQtyAttribute($value): void
    {
        $this->attributes['difference'] = $value;
    }
}
