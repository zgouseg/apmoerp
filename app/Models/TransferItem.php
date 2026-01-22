<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CRIT-DB-01 FIX: TransferItem now extends Model directly instead of BaseModel.
 * Line-item tables inherit branch context from their parent (Transfer) and don't need
 * their own BranchScope. The transfer_items table has timestamps but no softDeletes,
 * and branch_id is optional (added via migration but not required for the model's functionality).
 */
class TransferItem extends Model
{
    use HasFactory;

    protected $table = 'transfer_items';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000003_create_inventory_tables.php
     * Note: branch_id removed as it's inherited from parent Transfer record
     */
    protected $fillable = [
        'transfer_id',
        'product_id',
        'quantity',
        'received_quantity',
        'unit_cost',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'received_quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
    ];

    public function transfer(): BelongsTo
    {
        return $this->belongsTo(Transfer::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Backward compatibility accessor
    public function getQtyAttribute()
    {
        return $this->quantity;
    }

    public function setQtyAttribute($value): void
    {
        $this->attributes['quantity'] = $value;
    }
}
