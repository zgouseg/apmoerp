<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CRIT-DB-01 FIX: PurchaseItem now extends Model directly instead of BaseModel.
 * Line-item tables inherit branch context from their parent (Purchase) and don't need
 * their own BranchScope. The purchase_items table has softDeletes but branch_id is
 * optional (added via migration but not required for the model's functionality).
 */
class PurchaseItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'purchase_items';

    protected $with = ['product'];

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000002_create_purchases_tables.php
     * Note: branch_id removed as it's inherited from parent Purchase record
     */
    protected $fillable = [
        'purchase_id',
        'product_id',
        'variation_id',
        'product_name',
        'sku',
        'quantity',
        'received_quantity',
        'unit_id',
        'unit_price',
        'discount_percent',
        'tax_percent',
        'tax_amount',
        'line_total',
        'expiry_date',
        'batch_number',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'received_quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'discount_percent' => 'decimal:2',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:4',
        'line_total' => 'decimal:4',
        'expiry_date' => 'date',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
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

    public function getUnitCostAttribute()
    {
        return $this->unit_price;
    }

    public function setUnitCostAttribute($value): void
    {
        $this->attributes['unit_price'] = $value;
    }

    public function getDiscountAttribute()
    {
        return $this->discount_percent;
    }

    public function getTaxRateAttribute()
    {
        return $this->tax_percent;
    }
}
