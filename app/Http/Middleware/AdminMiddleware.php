<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedRoles = ['admin', 'dokter_pencegahan', 'dokter_pengobatan'];

        if (!Auth::check() || !in_array(Auth::user()->role, $allowedRoles)) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Akses ditolak. Anda tidak memiliki izin yang sesuai.'
                ], 403);
            }

            return redirect('/dashboard')->with('error', 'Akses ditolak. Anda tidak memiliki izin yang sesuai.');
        }

        return $next($request);
    }
}
