<?php

declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\Purchase;

interface PurchaseServiceInterface
{
    public function create(array $payload): Purchase;

    public function approve(int $id): Purchase;

    public function receive(int $id): Purchase;

    /**
     * STILL-V7-HIGH-U08 FIX: Updated signature to include payment method and notes
     */
    public function pay(int $id, float $amount, string $paymentMethod = 'cash', ?string $notes = null): Purchase;

    public function cancel(int $id): Purchase;
}
