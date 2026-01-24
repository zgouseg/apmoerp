<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receipt extends BaseModel
{
    protected ?string $moduleKey = 'finance';

    protected $table = 'receipts';

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000001_create_sales_tables.php
     */
    protected $fillable = [
        'sale_id',
        'branch_id',
        'code',
        'amount',
        'receipt_date',
        'payment_method',
        'extra_attributes',
        'created_by',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'receipt_date' => 'datetime',
        'extra_attributes' => 'array',
    ];

    /**
     * Backward compatibility accessor for receipt_number
     */
    public function getReceiptNumberAttribute()
    {
        return $this->code;
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    // Backward compatibility accessors
    public function getReferenceAttribute()
    {
        return $this->code;
    }

    public function getMethodAttribute()
    {
        return $this->payment_method;
    }

    public function getPaidAtAttribute()
    {
        return $this->receipt_date ?? $this->created_at;
    }
}
