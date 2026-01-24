<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Delivery extends BaseModel
{
    use SoftDeletes;

    protected ?string $moduleKey = 'sales';

    protected $table = 'deliveries';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000001_create_sales_tables.php
     */
    protected $fillable = [
        'sale_id',
        'branch_id',
        'code',
        'status',
        'scheduled_date',
        'delivery_date',
        'delivery_address',
        'driver_name',
        'driver_phone',
        'vehicle_number',
        'delivery_cost',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'delivery_date' => 'date',
        'delivery_cost' => 'decimal:4',
    ];

    /**
     * Backward compatibility accessor for reference_number
     */
    public function getReferenceNumberAttribute()
    {
        return $this->code;
    }

    /**
     * Backward compatibility accessor for shipping_cost
     */
    public function getShippingCostAttribute()
    {
        return $this->delivery_cost;
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function deliveredByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Backward compatibility accessors
    public function getDeliveredAtAttribute()
    {
        return $this->delivery_date;
    }

    // Scopes
    public function scopePending(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeDispatched(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'dispatched');
    }

    public function scopeDelivered(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'delivered');
    }
}
