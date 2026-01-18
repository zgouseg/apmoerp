<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'order_number' => $this->order_number ?? $this->id,
            'customer' => $this->whenLoaded('customer', fn () => new CustomerResource($this->customer)),
            'customer_id' => $this->customer_id,
            'branch_id' => $this->branch_id,
            'branch' => $this->whenLoaded('branch', fn () => new BranchResource($this->branch)),
            'user' => $this->whenLoaded('user', fn () => new UserResource($this->user)),
            'items' => $this->whenLoaded('items', fn () => OrderItemResource::collection($this->items)),
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            'subtotal' => decimal_float($this->sub_total),
            'discount' => decimal_float($this->discount),
            'tax' => decimal_float($this->tax),
            'total' => decimal_float($this->grand_total),
            'paid_amount' => decimal_float($this->paid_total ?? 0),
            'due_amount' => decimal_float($this->due_total),
            'status' => $this->status,
            'payment_status' => $this->computePaymentStatus(),
            'payment_method' => $this->payment_method,
            'source' => $this->channel ?? 'pos',
            'external_reference' => $this->external_reference,
            'notes' => $this->notes,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    /**
     * Compute payment status safely, handling models with or without isPaid() method.
     */
    protected function computePaymentStatus(): string
    {
        // Check if the underlying model has isPaid method
        if (method_exists($this->resource, 'isPaid')) {
            return $this->resource->isPaid() ? 'paid' : ($this->paid_total > 0 ? 'partial' : 'unpaid');
        }

        // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
        $paidTotal = decimal_float($this->paid_total ?? 0);
        $grandTotal = decimal_float($this->grand_total ?? 0);

        if ($grandTotal <= 0) {
            return 'unpaid';
        }

        if ($paidTotal >= $grandTotal) {
            return 'paid';
        }

        return $paidTotal > 0 ? 'partial' : 'unpaid';
    }
}
