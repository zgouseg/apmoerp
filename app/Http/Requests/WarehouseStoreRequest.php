<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class WarehouseStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('warehouses.create') ?? false;
    }

    public function rules(): array
    {
        $branchId = $this->user()?->branch_id;

        // NEW-HIGH-06 FIX: Scope warehouse name/code uniqueness to branch_id for multi-branch support
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
