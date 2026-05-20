<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckDoctorRole
{
    public function handle(Request $request, Closure $next, string $mode = 'doctor-only')
    {
        $user = $request->user();
        $isDoctor = $user && in_array($user->role, ['dokter_pencegahan', 'dokter_pengobatan']);

        if ($mode === 'redirect-doctor' && $isDoctor) {
            return redirect()->route('konsultasi.messages');
        }

        if ($mode === 'doctor-only' && !$isDoctor) {
            abort(403, 'Access denied. You are not authorized to view this page.');
        }

        return $next($request);
    }
}
