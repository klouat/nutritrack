<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateWithApiToken
{
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            return $next($request);
        }

        $plainTextToken = $request->bearerToken() ?: $request->cookie('nutri_token');

        if (!$plainTextToken) {
            return $this->unauthenticated($request);
        }

        $accessToken = PersonalAccessToken::findToken($plainTextToken);

        if (!$accessToken || !$accessToken->tokenable) {
            return $this->unauthenticated($request);
        }

        $user = $accessToken->tokenable->withAccessToken($accessToken);
        Auth::setUser($user);

        return $next($request);
    }

    protected function unauthenticated(Request $request)
    {
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        return redirect('/login');
    }
}
