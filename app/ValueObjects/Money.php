<?php

declare(strict_types=1);

namespace App\ValueObjects;

use InvalidArgumentException;

/**
 * Value object for handling money amounts with currency
 */
final class Money
{
    public function __construct(
        public readonly string $amount,
        public readonly string $currency = 'EGP',
    ) {
        if (! is_numeric($this->amount)) {
            throw new InvalidArgumentException('Amount must be numeric');
        }
    }

    /**
     * Create Money instance from a numeric value
     *
     * V48-FINANCE-01 FIX: Accept string|int instead of float to avoid floating-point precision issues.
     * String values should be decimal representations (e.g., "100.50").
     * Integer values represent whole units (e.g., 100 = 100.00).
     *
     * @param  string|int  $amount  Decimal string (e.g., "100.50") or integer representing whole units
     * @param  string  $currency  Currency code (default: EGP)
     */
    public static function from(string|int $amount, string $currency = 'EGP'): self
    {
        if (is_int($amount)) {
            return new self(number_format($amount, 2, '.', ''), $currency);
        }

        // Validate string is a valid numeric value
        if (! is_numeric($amount)) {
            throw new InvalidArgumentException('Amount must be a valid numeric string or integer');
        }

        // Use bcadd with 0 to normalize the decimal string to 2 decimal places
        return new self(bcadd($amount, '0', 2), $currency);
    }

    /**
     * Add another Money instance
     */
    public function add(Money $other): Money
    {
        $this->ensureSameCurrency($other);

        return new self(
            bcadd($this->amount, $other->amount, 2),
            $this->currency
        );
    }

    /**
     * Subtract another Money instance
     */
    public function subtract(Money $other): Money
    {
        $this->ensureSameCurrency($other);

        return new self(
            bcsub($this->amount, $other->amount, 2),
            $this->currency
        );
    }

    /**
     * Multiply by a factor
     *
     * V48-FINANCE-01 FIX: Accept string|int instead of float to avoid floating-point precision issues.
     *
     * @param  string|int  $factor  Multiplier as a decimal string (e.g., "1.5") or integer
     */
    public function multiply(string|int $factor): Money
    {
        $factorStr = is_int($factor) ? (string) $factor : $factor;

        if (! is_numeric($factorStr)) {
            throw new InvalidArgumentException('Factor must be a valid numeric string or integer');
        }

        return new self(
            bcmul($this->amount, $factorStr, 2),
            $this->currency
        );
    }

    /**
     * Format the money amount for display
     * V43-FINANCE-01 FIX: Use decimal_float() for proper BCMath-based rounding before display
     */
    public function format(int $decimals = 2): string
    {
        return number_format(decimal_float($this->amount, $decimals), $decimals).' '.$this->currency;
    }

    /**
     * Convert to float
     * V43-FINANCE-01 FIX: Use decimal_float() for proper BCMath-based rounding
     */
    public function toFloat(): float
    {
        return decimal_float($this->amount);
    }

    /**
     * Convert to string
     */
    public function __toString(): string
    {
        return $this->format();
    }

    /**
     * Check if amount is zero
     */
    public function isZero(): bool
    {
        return bccomp($this->amount, '0', 2) === 0;
    }

    /**
     * Check if amount is positive
     */
    public function isPositive(): bool
    {
        return bccomp($this->amount, '0', 2) > 0;
    }

    /**
     * Check if amount is negative
     */
    public function isNegative(): bool
    {
        return bccomp($this->amount, '0', 2) < 0;
    }

    /**
     * Ensure the same currency is being used
     */
    private function ensureSameCurrency(Money $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new InvalidArgumentException(
                'Cannot perform operation on different currencies'
            );
        }
    }
}
