<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\InvalidDiscountException;
use App\Rules\ValidDiscount;
use App\Services\Contracts\DiscountServiceInterface;
use App\Traits\HandlesServiceErrors;

class DiscountService implements DiscountServiceInterface
{
    use HandlesServiceErrors;

    public function sanitize(float $value, bool $asPercent = true, ?float $cap = null): float
    {
        return $this->handleServiceOperation(
            callback: function () use ($value, $asPercent, $cap) {
                $value = max(0.0, $value);

                $cap = $cap ?? $this->getMaxDiscount($asPercent);

                // Validate discount against cap
                if ($value > $cap) {
                    throw new InvalidDiscountException(
                        $value,
                        $cap,
                        $asPercent ? 'percent' : 'amount'
                    );
                }

                if ($asPercent) {
                    $rule = ValidDiscount::percent($cap);
                } else {
                    $rule = ValidDiscount::amount($cap);
                }

                $rule->validate('discount', $value, function (string $message): void {});

                return min($value, $cap);
            },
            operation: 'sanitize',
            context: ['value' => $value, 'as_percent' => $asPercent, 'cap' => $cap],
            defaultValue: 0.0
        );
    }

    public function lineTotal(float $qty, float $price, float $discount, bool $percent = true): float
    {
        return $this->handleServiceOperation(
            callback: function () use ($qty, $price, $discount, $percent) {
                $qty = max(0.0, $qty);
                $price = max(0.0, $price);

                $subtotal = $qty * $price;

                $discount = $this->sanitize($discount, $percent);

                // Use bcmath for precise discount calculation
                $discTotal = $percent
                    ? bcmul((string) $subtotal, bcdiv((string) $discount, '100', 6), 6)
                    : (string) $discount;

                // Use bcmath comparisons for precision
                if (bccomp($discTotal, '0', 6) < 0) {
                    $discTotal = '0';
                } elseif (bccomp($discTotal, (string) $subtotal, 6) > 0) {
                    $discTotal = (string) $subtotal;
                }

                // V30-MED-08 FIX: Use bcround() instead of bcdiv truncation
                // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
                return decimal_float(bcround($discTotal, 2));
            },
            operation: 'lineTotal',
            context: ['qty' => $qty, 'price' => $price, 'discount' => $discount, 'percent' => $percent],
            defaultValue: 0.0
        );
    }

    /**
     * Get maximum allowed discount from configuration
     */
    protected function getMaxDiscount(bool $asPercent): float
    {
        if ($asPercent) {
            // Check sales config first, then fallback to POS config
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            return decimal_float(config('sales.max_line_discount_percent',
                config('pos.discount.max_percent', 50)
            ));
        }

        return decimal_float(config('pos.discount.max_amount', 1000));
    }

    /**
     * Validate invoice-level discount
     */
    public function validateInvoiceDiscount(float $discount, bool $asPercent = true): bool
    {
        // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
        $maxDiscount = $asPercent
            ? decimal_float(config('sales.max_invoice_discount_percent', 30))
            : decimal_float(config('pos.discount.max_amount', 1000));

        if ($discount > $maxDiscount) {
            throw new InvalidDiscountException(
                $discount,
                $maxDiscount,
                $asPercent ? 'percent' : 'amount'
            );
        }

        return true;
    }

    /**
     * Validate that discount stacking doesn't exceed limits
     * Prevents combining incompatible discount types
     *
     * @param  array  $discounts  Array of discount configurations: [['type' => 'customer', 'value' => 20, 'is_percent' => true], ...]
     * @param  float  $baseAmount  The base amount before any discounts
     * @return array ['allowed' => bool, 'reason' => string|null, 'total_discount' => float]
     */
    public function validateDiscountStacking(array $discounts, float $baseAmount): array
    {
        if (empty($discounts)) {
            return ['allowed' => true, 'reason' => null, 'total_discount' => 0.0];
        }

        // Extract discount types
        $types = array_column($discounts, 'type');

        // Check for incompatible combinations using configuration
        $incompatibleTypes = config('sales.incompatible_discount_types', [
            'coupon' => ['seasonal'],
            'seasonal' => ['coupon'],
        ]);

        foreach ($types as $type) {
            if (isset($incompatibleTypes[$type])) {
                $conflictingTypes = array_intersect($types, $incompatibleTypes[$type]);
                if (! empty($conflictingTypes)) {
                    return [
                        'allowed' => false,
                        'reason' => "Cannot combine {$type} discounts with ".implode(', ', $conflictingTypes).' discounts',
                        'total_discount' => 0.0,
                    ];
                }
            }
        }

        // Calculate total discount by applying them sequentially
        $currentAmount = $baseAmount;
        $totalDiscountAmount = 0.0;

        foreach ($discounts as $discount) {
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            $value = decimal_float($discount['value'] ?? 0);
            $isPercent = (bool) ($discount['is_percent'] ?? true);

            if ($isPercent) {
                // FIX: Use bcmath for percentage discount calculation
                $discountAmount = decimal_float(bcmul((string) $currentAmount, bcdiv((string) $value, '100', 6), 4), 4);
            } else {
                // Fixed amount discount
                $discountAmount = $value;
            }

            // Ensure discount doesn't exceed current amount
            $discountAmount = min($discountAmount, $currentAmount);

            $totalDiscountAmount += $discountAmount;
            // FIX: Use bcsub for precision
            $currentAmount = decimal_float(bcsub((string) $currentAmount, (string) $discountAmount, 4), 4);
        }

        // Final amount should never be negative
        $finalAmount = max(0.0, decimal_float(bcsub((string) $baseAmount, (string) $totalDiscountAmount, 4), 4));

        // Check if total discount exceeds maximum allowed (e.g., 80% of base)
        // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
        $maxDiscountPercent = decimal_float(config('sales.max_combined_discount_percent', 80));
        // FIX: Use bcmath for percentage calculation
        $discountPercent = $baseAmount > 0 ? decimal_float(bcmul(bcdiv((string) $totalDiscountAmount, (string) $baseAmount, 6), '100', 4), 4) : 0;

        if ($discountPercent > $maxDiscountPercent) {
            return [
                'allowed' => false,
                'reason' => "Combined discounts ({$discountPercent}%) exceed maximum allowed ({$maxDiscountPercent}%)",
                'total_discount' => $totalDiscountAmount,
            ];
        }

        return [
            'allowed' => true,
            'reason' => null,
            'total_discount' => $totalDiscountAmount,
            'final_amount' => $finalAmount,
        ];
    }
}
