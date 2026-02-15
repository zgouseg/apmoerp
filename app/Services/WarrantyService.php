<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Warranty;
use App\Traits\HandlesServiceErrors;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class WarrantyService
{
    use HandlesServiceErrors;

    /**
     * Create or update a warranty for a vehicle.
     */
    public function upsertWarranty(int $vehicleId, int $branchId, array $data): Warranty
    {
        return $this->handleServiceOperation(
            callback: fn () => Warranty::updateOrCreate(
                ['vehicle_id' => $vehicleId],
                [
                    'branch_id' => $branchId,
                    'provider' => $data['provider'] ?? 'default',
                    'start_date' => $data['start_date'] ?? now(),
                    'end_date' => $data['end_date'] ?? now()->addYear(),
                    'notes' => $data['notes'] ?? null,
                ]
            ),
            operation: 'upsertWarranty',
            context: ['vehicle_id' => $vehicleId, 'branch_id' => $branchId]
        );
    }

    /**
     * Check if a warranty claim is valid for a vehicle.
     *
     * Audit Report 10, Bug #3: Validates warranty by checking both
     * the date range AND optional mileage limit stored in extra_attributes.
     * Without this check, a vehicle that exceeded its warranty mileage
     * but is still within the date range would incorrectly be covered,
     * causing the company to absorb repair costs it shouldn't.
     */
    public function isWarrantyValid(int $vehicleId): array
    {
        return $this->handleServiceOperation(
            callback: function () use ($vehicleId) {
                $warranty = Warranty::where('vehicle_id', $vehicleId)
                    ->where('start_date', '<=', now())
                    ->where('end_date', '>=', now())
                    ->first();

                if (! $warranty) {
                    return [
                        'valid' => false,
                        'reason' => __('No active warranty found or warranty has expired.'),
                    ];
                }

                // Check mileage limit if set in extra_attributes
                $extra = $warranty->extra_attributes ?? [];
                $mileageLimit = $extra['mileage_limit'] ?? null;

                if ($mileageLimit !== null) {
                    $vehicle = Vehicle::find($vehicleId);
                    $currentOdometer = $vehicle?->extra_attributes['odometer'] ?? 0;

                    if ($currentOdometer > $mileageLimit) {
                        return [
                            'valid' => false,
                            'reason' => __('Vehicle mileage (:current km) exceeds warranty limit (:limit km).', [
                                'current' => number_format($currentOdometer),
                                'limit' => number_format($mileageLimit),
                            ]),
                            'warranty_id' => $warranty->id,
                        ];
                    }
                }

                return [
                    'valid' => true,
                    'warranty_id' => $warranty->id,
                    'provider' => $warranty->provider,
                    'expires_at' => $warranty->end_date->toDateString(),
                ];
            },
            operation: 'isWarrantyValid',
            context: ['vehicle_id' => $vehicleId],
            defaultValue: ['valid' => false, 'reason' => __('Could not verify warranty status.')]
        );
    }

    /**
     * Get all warranties expiring within a given number of days.
     *
     * @return Collection<int, Warranty>
     */
    public function getExpiringWarranties(int $branchId, int $days = 30): Collection
    {
        return $this->handleServiceOperation(
            callback: fn () => Warranty::where('branch_id', $branchId)
                ->where('end_date', '>=', now())
                ->where('end_date', '<=', now()->addDays($days))
                ->with('vehicle')
                ->orderBy('end_date')
                ->get(),
            operation: 'getExpiringWarranties',
            context: ['branch_id' => $branchId, 'days' => $days],
            defaultValue: new Collection
        );
    }

    /**
     * Extend an existing warranty.
     */
    public function extendWarranty(int $warrantyId, string $newEndDate): Warranty
    {
        return $this->handleServiceOperation(
            callback: function () use ($warrantyId, $newEndDate) {
                $warranty = Warranty::findOrFail($warrantyId);

                $parsedDate = \Carbon\Carbon::parse($newEndDate);

                if ($parsedDate->lte($warranty->end_date)) {
                    throw new \InvalidArgumentException(
                        __('New end date must be after the current end date (:current).', [
                            'current' => $warranty->end_date->toDateString(),
                        ])
                    );
                }

                $warranty->update(['end_date' => $parsedDate]);

                return $warranty->fresh();
            },
            operation: 'extendWarranty',
            context: ['warranty_id' => $warrantyId, 'new_end_date' => $newEndDate]
        );
    }
}
