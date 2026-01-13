<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchasePayment extends Model
{
    /**
     * Fillable fields for purchase payments
     */
    protected $fillable = [
        'purchase_id',
        'reference_number',
        'amount',
        'payment_method',
        'status',
        'payment_date',
        'currency',
        'exchange_rate',
        'card_last_four',
        'bank_name',
        'cheque_number',
        'cheque_date',
        'notes',
        'paid_by',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'exchange_rate' => 'decimal:8',
        'payment_date' => 'date',
        'cheque_date' => 'date',
    ];

    public const METHOD_CASH = 'cash';

    public const METHOD_CARD = 'card';

    public const METHOD_TRANSFER = 'bank_transfer';

    public const METHOD_CHEQUE = 'cheque';

    public static function paymentMethods(): array
    {
        return [
            self::METHOD_CASH => __('Cash'),
            self::METHOD_CARD => __('Card'),
            self::METHOD_TRANSFER => __('Bank Transfer'),
            self::METHOD_CHEQUE => __('Cheque'),
        ];
    }

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    // Backward compatibility accessor
    public function getCreatedByAttribute()
    {
        return $this->paid_by;
    }
}
