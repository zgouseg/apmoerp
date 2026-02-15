<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthLoginRequest;
use App\Models\User;
use App\Services\Contracts\AuthServiceInterface as AuthService;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $auth,
        protected RateLimiter $limiter,
    ) {}

    public function login(AuthLoginRequest $request)
    {
        $key = $this->throttleKey($request);
        $maxAttempts = 5;
        $decaySeconds = 60;

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->limiter->availableIn($key);

            return $this->fail(__('Too many attempts. Please try again later.'), 429, [
                'retry_after' => $retryAfter,
            ]);
        }

        $user = User::query()->where('email', $request->input('email'))->first();
        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            $this->limiter->hit($key, $decaySeconds);

            return $this->fail(__('Invalid credentials'), 422);
        }

        $this->limiter->clear($key);

        $hasIsActiveAttribute = array_key_exists('is_active', $user->getAttributes());

        if ($hasIsActiveAttribute && ! (bool) $user->is_active) {
            return $this->fail(__('User disabled'), 403);
        }

        $abilities = $request->input('abilities', ['*']);
        $token = $this->auth->issueToken($user, $abilities);

        return $this->ok([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], __('Logged in successfully'));
    }

    protected function throttleKey(Request $request): string
    {
        $email = strtolower((string) $request->input('email'));

        return sha1(sprintf('login|%s|%s', $email, $request->ip()));
    }

    public function me(Request $request)
    {
        return $this->ok(['user' => $request->user()]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if (method_exists($user, 'currentAccessToken')) {
            $user->currentAccessToken()?->delete();
        } else {
            $this->auth->revokeAllTokens($user);
        }

        return $this->ok(null, __('Logged out'));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Refresh the authentication token
     */
    public function refresh(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return $this->fail(__('Unauthenticated'), 401);
        }

        // Revoke current token and issue a new one
        if (method_exists($user, 'currentAccessToken')) {
            $user->currentAccessToken()?->delete();
        }

        $abilities = $request->input('abilities', ['*']);
        $token = $this->auth->issueToken($user, $abilities);

        return $this->ok([
            'token' => $token->plainTextToken,
            'user' => $user,
        ], __('Token refreshed successfully'));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Change user password
     */
    public function changePassword(Request $request)
    {
        $validated = $this->validate($request, [
            'current_password' => ['required', 'string'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();

        if (! Hash::check($validated['current_password'], $user->password)) {
            return $this->fail(__('Current password is incorrect'), 422);
        }

        $user->password = Hash::make($validated['new_password']);
        $user->save();

        // Revoke all other tokens to invalidate stolen/leaked sessions
        $currentTokenId = $user->currentAccessToken()?->id;
        $user->tokens()->where('id', '!=', $currentTokenId)->delete();

        return $this->ok(null, __('Password changed successfully'));
    }

    /**
     * NEW-V15-CRITICAL-02 FIX: Revoke all other sessions
     */
    public function revokeOtherSessions(Request $request)
    {
        $validated = $this->validate($request, [
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (! Hash::check($validated['password'], $user->password)) {
            return $this->fail(__('Password is incorrect'), 422);
        }

        $currentTokenId = $user->currentAccessToken()?->id;

        // Revoke all tokens except the current one
        $user->tokens()->where('id', '!=', $currentTokenId)->delete();

        return $this->ok(null, __('Other sessions revoked successfully'));
    }

    public function impersonate(Request $request)
    {
        $this->authorize('system.impersonate');

        $this->validate($request, [
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'abilities' => ['sometimes', 'array'],
        ]);

        $token = $this->auth->enableImpersonation((int) $request->input('user_id'), $request->input('abilities', ['*']));

        return $this->ok([
            'token' => $token?->plainTextToken,
            'impersonating' => true,
        ], __('Impersonation token issued'));
    }
}
