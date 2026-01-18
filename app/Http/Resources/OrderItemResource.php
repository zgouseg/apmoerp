<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'product_id' => $this->product_id,
            'product' => $this->whenLoaded('product', fn () => new ProductResource($this->product)),
            'quantity' => (int) $this->qty,
            // V38-FINANCE-01 FIX: Use decimal_float() for proper precision handling
            'unit_price' => decimal_float($this->unit_price),
            'discount' => decimal_float($this->discount),
            'tax' => decimal_float($this->tax ?? 0),
            'total' => decimal_float($this->line_total),
            'notes' => $this->notes,
        ];
    }
}
