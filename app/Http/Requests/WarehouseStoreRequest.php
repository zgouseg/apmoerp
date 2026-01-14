<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class WarehouseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('warehouses.create') ?? false;
    }

    public function rules(): array
    {
        // NEW-HIGH-01 FIX: Use branch_id from request attributes (set by middleware) instead of user's branch_id
        // This ensures the uniqueness check uses the same branch_id that will be used when creating the warehouse
        $branchId = (int) $this->attributes->get('branch_id');

        // Fail validation with clear message if branch context is not available
        if (! $branchId) {
            throw ValidationException::withMessages([
                'branch_id' => [__('Branch context is required.')],
            ]);
        }

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('warehouses', 'name')->where('branch_id', $branchId),
            ],
            'code' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('warehouses', 'code')->where('branch_id', $branchId),
            ],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }
}
