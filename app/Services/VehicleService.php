<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Warranty;
use App\Traits\HandlesServiceErrors;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class VehicleService
{
    use HandlesServiceErrors;

    /** Valid vehicle statuses matching the migration schema. */
    public const ALLOWED_STATUSES = ['available', 'sold', 'reserved', 'leased'];

    /**
     * Create a new vehicle.
     */
    public function createVehicle(int $branchId, array $data): Vehicle
    {
        return $this->handleServiceOperation(
            callback: fn () => Vehicle::create(array_merge($data, [
                'branch_id' => $branchId,
                'status' => $data['status'] ?? 'available',
            ])),
            operation: 'createVehicle',
            context: ['branch_id' => $branchId]
        );
    }

    /**
     * Update vehicle details.
     */
    public function updateVehicle(int $vehicleId, array $data): Vehicle
    {
        return $this->handleServiceOperation(
            callback: function () use ($vehicleId, $data) {
                $vehicle = Vehicle::findOrFail($vehicleId);
                $vehicle->update($data);

                return $vehicle->fresh();
            },
            operation: 'updateVehicle',
            context: ['vehicle_id' => $vehicleId]
        );
    }

    /**
     * Update vehicle status with validation.
     */
    public function updateStatus(int $vehicleId, string $newStatus): Vehicle
    {
        return $this->handleServiceOperation(
            callback: function () use ($vehicleId, $newStatus) {
                if (! in_array($newStatus, self::ALLOWED_STATUSES, true)) {
                    throw new \InvalidArgumentException(
                        __('Invalid vehicle status: :status', ['status' => $newStatus])
                    );
                }

                $vehicle = Vehicle::findOrFail($vehicleId);
                $vehicle->update(['status' => $newStatus]);

                return $vehicle;
            },
            operation: 'updateStatus',
            context: ['vehicle_id' => $vehicleId, 'status' => $newStatus]
        );
    }

    /**
     * Record an odometer reading with backward-check validation.
     *
     * Audit Report 10, Bug #4: Prevents odometer readings that go backward
     * (e.g., entering 40,000 km when the last reading was 50,000 km).
     * This protects maintenance schedules that depend on mileage intervals.
     *
     * Odometer readings are stored in the extra_attributes JSON field
     * since the vehicles table uses this for extensible data.
     */
    public function recordOdometerReading(int $vehicleId, int $reading, ?string $note = null): Vehicle
    {
        return $this->handleServiceOperation(
            callback: fn () => DB::transaction(function () use ($vehicleId, $reading, $note) {
                $vehicle = Vehicle::lockForUpdate()->findOrFail($vehicleId);

                if ($reading < 0) {
                    throw new \InvalidArgumentException(__('Odometer reading cannot be negative.'));
                }

                $extra = $vehicle->extra_attributes ?? [];
                $lastReading = $extra['odometer'] ?? 0;

                if ($reading < $lastReading) {
                    throw new \InvalidArgumentException(
                        __('Odometer reading (:new) cannot be less than the previous reading (:last).', [
                            'new' => number_format($reading),
                            'last' => number_format($lastReading),
                        ])
                    );
                }

                $extra['odometer'] = $reading;
                $extra['odometer_updated_at'] = now()->toIso8601String();

                if ($note) {
                    $extra['odometer_note'] = $note;
                }

                $vehicle->update(['extra_attributes' => $extra]);

                return $vehicle;
            }),
            operation: 'recordOdometerReading',
            context: ['vehicle_id' => $vehicleId, 'reading' => $reading]
        );
    }

    /**
     * Get vehicles for a branch with optional status filter.
     *
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(int $branchId, ?string $status = null): Collection
    {
        return $this->handleServiceOperation(
            callback: function () use ($branchId, $status) {
                $query = Vehicle::where('branch_id', $branchId);

                if ($status) {
                    $query->where('status', $status);
                }

                return $query->orderByDesc('id')->get();
            },
            operation: 'getVehicles',
            context: ['branch_id' => $branchId, 'status' => $status],
            defaultValue: new Collection
        );
    }

    /**
     * Check if a vehicle has an active warranty (date-based).
     *
     * Audit Report 10, Bug #3: Ensures warranty validity is checked
     * by date before authorizing warranty-covered repairs.
     */
    public function hasActiveWarranty(int $vehicleId): bool
    {
        return $this->handleServiceOperation(
            callback: fn () => Warranty::where('vehicle_id', $vehicleId)
                ->where('start_date', '<=', now())
                ->where('end_date', '>=', now())
                ->exists(),
            operation: 'hasActiveWarranty',
            context: ['vehicle_id' => $vehicleId],
            defaultValue: false
        );
    }
}
