<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Inventory;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class GetStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            'sku' => 'nullable|string|max:255',
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'warehouse_id' => ['nullable', new BranchScopedExists('warehouses', 'id', $branchId, allowNull: true)],
            'low_stock' => 'nullable|boolean',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];
    }
}
