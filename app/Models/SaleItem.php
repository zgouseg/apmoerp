<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CRIT-DB-01 FIX: SaleItem now extends Model directly instead of BaseModel.
 * Line-item tables inherit branch context from their parent (Sale) and don't need
 * their own BranchScope. The sale_items table has softDeletes but branch_id is
 * optional (added via migration but not required for the model's functionality).
 */
class SaleItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sale_items';

    protected $with = ['product'];

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000001_create_sales_tables.php
     * Note: branch_id removed as it's inherited from parent Sale record
     */
    protected $fillable = [
        'sale_id',
        'product_id',
        'variation_id',
        'warehouse_id',
        'product_name',
        'sku',
        'quantity',
        'unit_id',
        'unit_price',
        'cost_price',
        'discount_percent',
        'discount_amount',
        'tax_percent',
        'tax_amount',
        'line_total',
        'batch_id',
        'serial_numbers',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'cost_price' => 'decimal:4',
        'discount_percent' => 'decimal:2',
        'discount_amount' => 'decimal:4',
        'tax_percent' => 'decimal:2',
        'tax_amount' => 'decimal:4',
        'line_total' => 'decimal:4',
        'serial_numbers' => 'array',
    ];

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'variation_id');
    }

    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(InventoryBatch::class, 'batch_id');
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

    public function getDiscountAttribute()
    {
        return $this->discount_amount;
    }

    public function getTaxRateAttribute()
    {
        return $this->tax_percent;
    }
}
