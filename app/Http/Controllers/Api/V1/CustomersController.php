<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomersController extends BaseApiController
{
    public function index(Request $request): JsonResponse
    {
        $store = $this->getStore($request);

        // NEW-MEDIUM-06 FIX: Validate and cap per_page to prevent DoS
        $validated = $request->validate([
            'sort_by' => 'sometimes|string|in:created_at,id,name,email',
            'sort_dir' => 'sometimes|string|in:asc,desc',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ]);

        $sortBy = $validated['sort_by'] ?? 'created_at';
        $sortDir = $validated['sort_dir'] ?? 'desc';
        $perPage = $validated['per_page'] ?? 50;

        $query = Customer::query()
            ->when($store?->branch_id, fn ($q) => $q->where('branch_id', $store->branch_id))
            ->when($request->filled('search'), function ($q) use ($request) {
                $search = $request->string('search');
                $q->where(function ($searchQuery) use ($search) {
                    $searchQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->orderBy($sortBy, $sortDir);

        $customers = $query->paginate($perPage);

        return $this->paginatedResponse($customers, __('Customers retrieved successfully'));
    }

    public function show(Request $request, int $id): JsonResponse
    {
        $store = $this->getStore($request);

        $customer = Customer::query()
            ->when($store?->branch_id, fn ($q) => $q->where('branch_id', $store->branch_id))
            ->find($id);

        if (! $customer) {
            return $this->errorResponse(__('Customer not found'), 404);
        }

        $customer->load(['sales' => fn ($q) => $q->latest()->take(10)]);

        return $this->successResponse($customer, __('Customer retrieved successfully'));
    }

    public function store(Request $request): JsonResponse
    {
        $store = $this->getStore($request);
        $branchId = $store?->branch_id;

        // V22-HIGH-10 FIX: Scope unique validation to branch_id
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')->where(function ($query) use ($branchId) {
                    if ($branchId) {
                        $query->where('branch_id', $branchId);
                    }
                }),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers', 'phone')->where(function ($query) use ($branchId) {
                    if ($branchId) {
                        $query->where('branch_id', $branchId);
                    }
                }),
            ],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'external_id' => 'nullable|string|max:100',
        ]);

        $validated['branch_id'] = $branchId;

        $customer = Customer::create($validated);

        return $this->successResponse($customer, __('Customer created successfully'), 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $store = $this->getStore($request);
        $branchId = $store?->branch_id;

        $customer = Customer::query()
            ->when($branchId, fn ($q) => $q->where('branch_id', $branchId))
            ->find($id);

        if (! $customer) {
            return $this->errorResponse(__('Customer not found'), 404);
        }

        // V22-HIGH-10 FIX: Scope unique validation to branch_id
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('customers', 'email')
                    ->ignore($customer->id)
                    ->where(function ($query) use ($branchId) {
                        if ($branchId) {
                            $query->where('branch_id', $branchId);
                        }
                    }),
            ],
            'phone' => [
                'nullable',
                'string',
                'max:50',
                Rule::unique('customers', 'phone')
                    ->ignore($customer->id)
                    ->where(function ($query) use ($branchId) {
                        if ($branchId) {
                            $query->where('branch_id', $branchId);
                        }
                    }),
            ],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'company' => 'nullable|string|max:255',
            'tax_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
        ]);

        $customer->update($validated);

        return $this->successResponse($customer, __('Customer updated successfully'));
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $store = $this->getStore($request);

        $customer = Customer::query()
            ->when($store?->branch_id, fn ($q) => $q->where('branch_id', $store->branch_id))
            ->find($id);

        if (! $customer) {
            return $this->errorResponse(__('Customer not found'), 404);
        }

        $customer->delete();

        return $this->successResponse(null, __('Customer deleted successfully'));
    }

    public function byEmail(Request $request, string $email): JsonResponse
    {
        $store = $this->getStore($request);

        $customer = Customer::query()
            ->when($store?->branch_id, fn ($q) => $q->where('branch_id', $store->branch_id))
            ->where('email', $email)
            ->first();

        if (! $customer) {
            return $this->errorResponse(__('Customer not found'), 404);
        }

        return $this->successResponse($customer, __('Customer retrieved successfully'));
    }
}
