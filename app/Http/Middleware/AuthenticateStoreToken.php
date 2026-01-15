<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Store;
use App\Models\StoreToken;
use App\Services\BranchContextManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateStoreToken
{
    public function handle(Request $request, Closure $next, string ...$abilities): Response
    {
        $token = $this->getTokenFromRequest($request);

        if (! $token) {
            return response()->json([
                'success' => false,
                'message' => 'API token required.',
            ], 401);
        }

        // V22-CRIT-01 FIX: Load StoreToken without BranchScope since there's no auth user
        // StoreToken table doesn't have branch_id, but the relationship to Store needs
        // to bypass BranchScope to load properly without authentication
        $storeToken = StoreToken::withoutGlobalScopes()->where('token', $token)->first();

        if (! $storeToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API token.',
            ], 401);
        }

        if ($storeToken->isExpired()) {
            return response()->json([
                'success' => false,
                'message' => 'API token has expired.',
            ], 401);
        }

        // V22-CRIT-01 FIX: Load Store without BranchScope since we're authenticating via token, not user
        // After loading, we'll set the branch context from the store's branch_id
        $store = Store::withoutGlobalScopes()
            ->where('id', $storeToken->store_id)
            ->first();

        if (! $store || ! $store->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Store is not active.',
            ], 403);
        }

        // V22-CRIT-01 FIX: Set branch context from the store's branch_id
        // This allows subsequent queries in the request to be properly scoped
        if ($store->branch_id) {
            BranchContextManager::setBranchContext($store->branch_id);
            $request->attributes->set('branch_id', $store->branch_id);
        }

        if (empty($abilities) && ! $storeToken->hasAbility('*')) {
            return response()->json([
                'success' => false,
                'message' => 'This endpoint requires explicit token abilities.',
            ], 403);
        }

        foreach ($abilities as $ability) {
            if (! $storeToken->hasAbility($ability)) {
                return response()->json([
                    'success' => false,
                    'message' => "Token does not have the '{$ability}' ability.",
                ], 403);
            }
        }

        $storeToken->touchLastUsed();

        $request->merge([
            'store' => $store,
            'store_token' => $storeToken,
        ]);

        return $next($request);
    }

    /**
     * V22-CRIT-01 FIX: Clear branch context after the request is handled
     * This prevents context leakage between requests
     */
    public function terminate(Request $request, Response $response): void
    {
        BranchContextManager::clearBranchContext();
    }

    protected function getTokenFromRequest(Request $request): ?string
    {
        $authHeader = $request->header('Authorization');

        if ($authHeader && str_starts_with($authHeader, 'Bearer ')) {
            return substr($authHeader, 7);
        }

        return $request->query('api_token') ?? $request->input('api_token');
    }
}
