<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Cache\RateLimiter as CacheRateLimiter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        $token = request()->cookie('nutri_token');

        if ($token && PersonalAccessToken::findToken($token)) {
            return redirect()->route('profil');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);

            $throttleKey = $this->throttleKey($request, $credentials['email']);
            $rateLimiter = $this->loginRateLimiter();

            if ($rateLimiter->tooManyAttempts($throttleKey, 5)) {
                $seconds = $rateLimiter->availableIn($throttleKey);

                return response()->json([
                    'success' => false,
                    'message' => "Terlalu banyak percobaan login. Coba lagi dalam {$seconds} detik.",
                ], 429);
            }

            $user = User::where('email', $credentials['email'])->first();

            if (!$user || !$user->password || !Hash::check($credentials['password'], $user->password)) {
                $rateLimiter->hit($throttleKey, 60);

                return response()->json([
                    'success' => false,
                    'message' => 'Email atau password salah.',
                    'errors' => [
                        'email' => ['Email atau password salah.']
                    ]
                ], 422);
            }

            $rateLimiter->clear($throttleKey);

            /** @var NewAccessToken $token */
            $token = $user->createToken('api-login-token');

            return $this->authenticatedResponse($request, $user, $token);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }
    }

    protected function throttleKey(Request $request, string $email): string
    {
        return Str::lower($email) . '|' . $request->ip();
    }

    protected function loginRateLimiter(): CacheRateLimiter
    {
        // Use a persistent store so failed login attempts survive across requests
        // even when the app default cache driver is configured as "array".
        return new CacheRateLimiter(Cache::store('file'));
    }

    protected function authenticatedResponse(Request $request, User $user, NewAccessToken $token): JsonResponse
    {
        return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'token' => $token->plainTextToken,
                'token_type' => 'Bearer',
                'user' => $user,
            ])->cookie(
                'nutri_token',
                $token->plainTextToken,
                60 * 24 * 30,
                '/',
                null,
                $request->isSecure(),
                false,
                false,
                'Lax'
            );
    }
    
    public function logout(Request $request)
    {
        $plainTextToken = $request->bearerToken() ?: $request->cookie('nutri_token');

        if ($plainTextToken) {
            $accessToken = PersonalAccessToken::findToken($plainTextToken);
            $accessToken?->delete();
        }

        if ($request->is('api/*')) {
            return response()->json([
                'message' => 'Logout successful.',
            ])->withoutCookie('nutri_token');
        }

        return redirect('/login')->withoutCookie('nutri_token');
    }
}

