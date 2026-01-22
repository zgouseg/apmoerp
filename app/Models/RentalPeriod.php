<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CRIT-DB-02 FIX: RentalPeriod now extends Model directly instead of BaseModel.
 * The rental_periods table does NOT have softDeletes() column in migration,
 * so using BaseModel (which includes SoftDeletes trait) would cause SQL errors.
 * This table also doesn't need branch_id filtering - it's linked via contract_id.
 */
class RentalPeriod extends Model
{
    use HasFactory;

    protected $table = 'rental_periods';

    protected $fillable = [
        'contract_id',
        'period_number',
        'start_date',
        'end_date',
        'due_date',
        'rent_amount',
        'status',
        'is_prorated',
        'is_paid',
    ];

    protected $casts = [
        'period_number' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'due_date' => 'date',
        'rent_amount' => 'decimal:4',
        'is_prorated' => 'boolean',
        'is_paid' => 'boolean',
    ];

    /**
     * Get the rental contract this period belongs to
     */
    public function contract(): BelongsTo
    {
        return $this->belongsTo(RentalContract::class, 'contract_id');
    }

    /**
     * Scope to get pending periods
     */
    public function scopePending(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope to get paid periods
     */
    public function scopePaid(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_paid', true);
    }

    /**
     * Scope to get overdue periods
     */
    public function scopeOverdue(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('status', 'overdue');
    }

    /**
     * Calculate the number of days in this rental period
     */
    public function calculateDays(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date);
    }
}
