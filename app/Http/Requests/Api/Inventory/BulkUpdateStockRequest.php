<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Inventory;

use App\Rules\BranchScopedExists;
use Illuminate\Foundation\Http\FormRequest;

class BulkUpdateStockRequest extends FormRequest
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
            'updates' => 'required|array|min:1',
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'updates.*.product_id' => ['required_without:updates.*.external_id', new BranchScopedExists('products', 'id', $branchId, allowNull: true)],
            'updates.*.external_id' => 'required_without:updates.*.product_id|string',
            'updates.*.qty' => 'required|numeric',
            'updates.*.direction' => 'required|in:in,out,set',
            'updates.*.reason' => 'nullable|string|max:255',
            'updates.*.warehouse_id' => ['nullable', new BranchScopedExists('warehouses', 'id', $branchId, allowNull: true)],
        ];
    }
}
