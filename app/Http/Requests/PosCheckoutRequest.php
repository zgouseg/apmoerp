<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Rules\BranchScopedExists;
use App\Support\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PosCheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        return [
            'items' => ['required', 'array', 'min:1'],
            // V58-CRITICAL-02 FIX: Use BranchScopedExists for branch-aware validation
            'items.*.product_id' => ['required', new BranchScopedExists('products', 'id', $branchId)],
            'items.*.qty' => ['required', 'numeric', 'gt:0', 'lte:999999'],
            'items.*.price' => ['sometimes', 'numeric', 'gte:0'],
            'items.*.discount' => ['sometimes', 'numeric', 'gte:0'],
            'items.*.percent' => ['sometimes', 'boolean'],
            'items.*.tax_id' => ['sometimes', 'integer', new BranchScopedExists('taxes', 'id', $branchId, allowNull: true)],
            'customer_id' => ['sometimes', 'integer', new BranchScopedExists('customers', 'id', $branchId, allowNull: true)],
            'warehouse_id' => ['sometimes', 'integer', new BranchScopedExists('warehouses', 'id', $branchId, allowNull: true)],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            ApiResponse::validationError($validator->errors()->toArray())
        );
    }
}
