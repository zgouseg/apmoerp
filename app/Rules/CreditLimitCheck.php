<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Customer;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

/**
 * CreditLimitCheck - Validate customer has available credit
 *
 * NEW FEATURE: Custom validation rule for credit limit checking
 * V48-FINANCE-02 FIX: Use string for amount and BCMath for arithmetic to avoid float precision issues
 */
class CreditLimitCheck implements ValidationRule
{
    private string $amount;

    private ?string $message = null;

    /**
     * @param  string  $amount  Amount as a decimal string (e.g., "100.50")
     */
    public function __construct(string $amount)
    {
        if (! is_numeric($amount)) {
            throw new \InvalidArgumentException('Amount must be a valid numeric string');
        }
        $this->amount = $amount;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $value) {
            return;
        }

        $customer = Customer::find($value);

        if (! $customer) {
            $fail('The selected customer does not exist.');

            return;
        }

        if ($customer->credit_hold) {
            $fail("Customer {$customer->name} is on credit hold: {$customer->credit_hold_reason}");

            return;
        }

        if (! $customer->hasAvailableCredit($this->amount)) {
            // V48-FINANCE-02 FIX: Use BCMath for available credit calculation
            $availableCredit = bcsub((string) $customer->credit_limit, (string) $customer->balance, 2);
            $fail("Customer {$customer->name} has insufficient credit. Available: ".number_format((float) $availableCredit, 2).', Required: '.number_format((float) $this->amount, 2));

            return;
        }
    }
}
