<?php

namespace App\Models;

use App\Traits\HasBranch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * CRIT-DB-03 FIX: StockTransfer model fields aligned with migration schema.
 * Fixed column name mismatches:
 * - transfer_number → reference_number
 * - transfer_type → type
 * - expected_delivery_date → expected_arrival_date
 * - actual_delivery_date → actual_arrival_date
 * Removed columns that don't exist in schema (insurance_cost, total_cost, courier_name, etc.)
 */
class StockTransfer extends Model
{
    use HasBranch, HasFactory, SoftDeletes;

    /**
     * Fillable fields aligned with migration:
     * 2026_01_04_000003_create_inventory_tables.php
     */
    protected $fillable = [
        'branch_id',
        'reference_number',
        'type',
        'from_warehouse_id',
        'to_warehouse_id',
        'from_branch_id',
        'to_branch_id',
        'status',
        'priority',
        'transfer_date',
        'expected_arrival_date',
        'actual_arrival_date',
        'total_items',
        'total_value',
        'shipping_cost',
        'shipping_method',
        'tracking_number',
        'reason',
        'notes',
        'rejection_reason',
        'requires_approval',
        'is_auto_generated',
        'created_by',
        'approved_by',
        'approved_at',
        'shipped_by',
        'shipped_at',
        'received_by',
        'received_at',
    ];

    protected $casts = [
        'transfer_date' => 'date',
        'expected_arrival_date' => 'date',
        'actual_arrival_date' => 'date',
        'total_items' => 'decimal:3',
        'total_value' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'requires_approval' => 'boolean',
        'is_auto_generated' => 'boolean',
        'approved_at' => 'datetime',
        'shipped_at' => 'datetime',
        'received_at' => 'datetime',
    ];

    // Status constants
    public const STATUS_DRAFT = 'draft';

    public const STATUS_PENDING = 'pending';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_IN_TRANSIT = 'in_transit';

    public const STATUS_RECEIVED = 'received';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_CANCELLED = 'cancelled';

    public const STATUS_REJECTED = 'rejected';

    // Priority constants
    public const PRIORITY_LOW = 'low';

    public const PRIORITY_MEDIUM = 'medium';

    public const PRIORITY_HIGH = 'high';

    public const PRIORITY_URGENT = 'urgent';

    // Type constants
    public const TYPE_INTER_WAREHOUSE = 'inter_warehouse';

    public const TYPE_INTER_BRANCH = 'inter_branch';

    public const TYPE_INTERNAL = 'internal';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transfer) {
            if (empty($transfer->reference_number)) {
                $transfer->reference_number = static::generateReferenceNumber();
            }
        });
    }

    /**
     * Generate unique reference number
     * NEW-HIGH-08 FIX: Use database locking to prevent race conditions
     * V32-CRIT-03 FIX: Wrap in DB::transaction to ensure lockForUpdate is effective
     * CRIT-DB-03 FIX: Renamed from generateTransferNumber to match schema column name
     */
    public static function generateReferenceNumber(): string
    {
        return \Illuminate\Support\Facades\DB::transaction(function () {
            $prefix = 'TRF';
            $date = now()->format('Ymd');

            // Use lockForUpdate to prevent concurrent reads from getting the same number
            // V32-CRIT-03 FIX: The outer DB::transaction ensures the lock is effective
            $lastTransfer = static::where('reference_number', 'like', "{$prefix}-{$date}-%")
                ->lockForUpdate()
                ->orderBy('reference_number', 'desc')
                ->first();

            if ($lastTransfer) {
                $lastNumber = (int) substr($lastTransfer->reference_number, -4);
                $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
            } else {
                $newNumber = '0001';
            }

            return "{$prefix}-{$date}-{$newNumber}";
        });
    }

    /**
     * Legacy alias for generateReferenceNumber
     * @deprecated Use generateReferenceNumber() instead
     */
    public static function generateTransferNumber(): string
    {
        return static::generateReferenceNumber();
    }

    /**
     * Relationships
     */
    public function fromWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'from_warehouse_id');
    }

    public function toWarehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'to_warehouse_id');
    }

    public function fromBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'from_branch_id');
    }

    public function toBranch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'to_branch_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(StockTransferItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(StockTransferApproval::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StockTransferDocument::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(StockTransferHistory::class)->orderBy('created_at', 'desc');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function shippedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'shipped_by');
    }

    public function receivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scopes
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    public function scopeApproved($query)
    {
        return $query->where('status', self::STATUS_APPROVED);
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', self::STATUS_IN_TRANSIT);
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', self::PRIORITY_URGENT);
    }

    /**
     * Check if transfer can be approved
     */
    public function canBeApproved(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if transfer can be shipped
     */
    public function canBeShipped(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if transfer can be received
     */
    public function canBeReceived(): bool
    {
        return $this->status === self::STATUS_IN_TRANSIT;
    }

    /**
     * Approve transfer
     */
    public function approve(int $userId): bool
    {
        if (! $this->canBeApproved()) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_APPROVED,
            'approved_by' => $userId,
            'approved_at' => now(),
        ]);

        $this->recordStatusChange(self::STATUS_PENDING, self::STATUS_APPROVED, $userId);

        return true;
    }

    /**
     * Mark as shipped
     * CRIT-DB-03 FIX: Removed references to non-existent columns (courier_name, vehicle_number, etc.)
     */
    public function markAsShipped(int $userId, ?array $shippingData = null): bool
    {
        if (! $this->canBeShipped()) {
            return false;
        }

        $updateData = [
            'status' => self::STATUS_IN_TRANSIT,
            'shipped_by' => $userId,
            'shipped_at' => now(),
        ];

        if ($shippingData) {
            $updateData = array_merge($updateData, array_filter([
                'tracking_number' => $shippingData['tracking_number'] ?? null,
                'shipping_method' => $shippingData['shipping_method'] ?? null,
            ]));
        }

        $this->update($updateData);
        $this->recordStatusChange(self::STATUS_APPROVED, self::STATUS_IN_TRANSIT, $userId);

        return true;
    }

    /**
     * Mark as received
     * CRIT-DB-03 FIX: Changed actual_delivery_date to actual_arrival_date to match schema
     */
    public function markAsReceived(int $userId): bool
    {
        if (! $this->canBeReceived()) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_RECEIVED,
            'received_by' => $userId,
            'received_at' => now(),
            'actual_arrival_date' => now()->toDateString(),
        ]);

        $this->recordStatusChange(self::STATUS_IN_TRANSIT, self::STATUS_RECEIVED, $userId);

        return true;
    }

    /**
     * Complete transfer (after all items processed)
     *
     * V32-HIGH-03 FIX: Accept userId parameter instead of using auth()->id() directly.
     * This allows the method to work correctly in CLI/queue/webhook contexts
     * where there is no authenticated user.
     *
     * @param  int|null  $userId  User ID for audit trail. Falls back to auth()->id() if null.
     */
    public function complete(?int $userId = null): bool
    {
        if ($this->status !== self::STATUS_RECEIVED) {
            return false;
        }

        $this->update(['status' => self::STATUS_COMPLETED]);
        // V33-CRIT-02 FIX: Use provided userId or fall back to actual_user_id() for proper audit attribution
        $this->recordStatusChange(self::STATUS_RECEIVED, self::STATUS_COMPLETED, $userId ?? actual_user_id());

        return true;
    }

    /**
     * Reject transfer
     * CRIT-DB-03 FIX: Changed internal_notes to rejection_reason to match schema
     */
    public function reject(int $userId, ?string $reason = null): bool
    {
        if ($this->status !== self::STATUS_PENDING) {
            return false;
        }

        $this->update([
            'status' => self::STATUS_REJECTED,
            'rejection_reason' => $reason,
        ]);

        $this->recordStatusChange(self::STATUS_PENDING, self::STATUS_REJECTED, $userId, $reason);

        return true;
    }

    /**
     * Cancel transfer
     * CRIT-DB-03 FIX: Changed internal_notes to notes to match schema
     */
    public function cancel(int $userId, ?string $reason = null): bool
    {
        if (in_array($this->status, [self::STATUS_COMPLETED, self::STATUS_CANCELLED])) {
            return false;
        }

        $oldStatus = $this->status;
        $updateData = [
            'status' => self::STATUS_CANCELLED,
        ];
        
        if ($reason) {
            $updateData['notes'] = ($this->notes ? $this->notes . "\n" : '') . "Cancelled: {$reason}";
        }
        
        $this->update($updateData);

        $this->recordStatusChange($oldStatus, self::STATUS_CANCELLED, $userId, $reason);

        return true;
    }

    /**
     * Record status change in history
     * V33-MED-03 FIX: Default to actual_user_id() when userId is null to prevent null audit actor
     */
    protected function recordStatusChange(string $fromStatus, string $toStatus, ?int $userId = null, ?string $notes = null): void
    {
        StockTransferHistory::create([
            'stock_transfer_id' => $this->id,
            'from_status' => $fromStatus,
            'to_status' => $toStatus,
            'notes' => $notes,
            'changed_by' => $userId ?? actual_user_id(),
            'changed_at' => now(),
        ]);
    }

    /**
     * Calculate transfer totals
     * CRIT-DB-03 FIX: Use correct column names from migration (total_items, total_value)
     */
    public function calculateTotals(): void
    {
        $this->total_items = $this->items->sum('quantity_requested');
        $this->total_value = $this->items->sum(function ($item) {
            return $item->quantity_requested * $item->unit_cost;
        });
        $this->save();
    }

    /**
     * Check if transfer is overdue
     * CRIT-DB-03 FIX: Use correct column name expected_arrival_date
     */
    public function isOverdue(): bool
    {
        if (! $this->expected_arrival_date || $this->status === self::STATUS_COMPLETED) {
            return false;
        }

        return now()->isAfter($this->expected_arrival_date);
    }

    /**
     * Get completion percentage
     * CRIT-DB-03 FIX: Use items relationship to calculate completion
     */
    public function getCompletionPercentage(): float
    {
        $totalRequested = $this->items->sum('quantity_requested');
        $totalReceived = $this->items->sum('quantity_received');
        
        if ($totalRequested <= 0) {
            return 0;
        }

        return ($totalReceived / $totalRequested) * 100;
    }
}
