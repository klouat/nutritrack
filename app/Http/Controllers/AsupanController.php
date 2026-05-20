<?php

namespace App\Http\Controllers;

use App\Models\Asupan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AsupanController extends Controller
{   
    public function dashboard(Request $request)
    {
        $user = $request->user();
        $today = now()->toDateString();

        $dailyTotals = Asupan::query()
            ->where('user_id', $user->id)
            ->whereDate('tanggal_konsumsi', $today)
            ->selectRaw('COALESCE(SUM(kadar_gula), 0) as total_gula, COALESCE(SUM(kadar_kalori), 0) as total_kalori')
            ->first();

        $maxGula = 50;
        $maxKalori = 2400;

        $todayAsupan = Asupan::query()
            ->where('user_id', $user->id)
            ->whereDate('tanggal_konsumsi', $today)
            ->latest('created_at')
            ->limit(10)
            ->get();

        return response()->json([
            'message' => 'Dashboard data fetched successfully.',
            'user' => $user,
            'summary' => [
                'tanggal' => $today,
                'total_gula' => (float) $dailyTotals->total_gula,
                'total_kalori' => (float) $dailyTotals->total_kalori,
                'gula_percentage' => round(min(((float) $dailyTotals->total_gula / $maxGula) * 100, 100), 1),
                'kalori_percentage' => round(min(((float) $dailyTotals->total_kalori / $maxKalori) * 100, 100), 1),
                'max_gula' => $maxGula,
                'max_kalori' => $maxKalori,
            ],
            'today_asupan' => $todayAsupan,
        ]);
    }

    public function create()
    {
        return view('dashboard.asupan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string',
            'kadar_gula' => 'required|numeric',   
            'kadar_kalori' => 'required|numeric', 
            'tanggal_konsumsi' => 'required|date',
            'waktu_konsumsi' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $asupan = Asupan::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'kadar_gula' => $validated['kadar_gula'],
            'kadar_kalori' => $validated['kadar_kalori'],
            'tanggal_konsumsi' => $validated['tanggal_konsumsi'],
            'waktu_konsumsi' => $validated['waktu_konsumsi'],
            'catatan' => $validated['catatan'] ?? null,
        ]);

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Asupan berhasil disimpan',
                'asupan' => $asupan
            ], 201);
        }

        return redirect()->back()->with('success', 'Asupan berhasil disimpan');
    }

    public function getDailyTotals()
    {
        $today = Carbon::today()->toDateString();
        $userId = Auth::id();

        $dailyTotals = Asupan::where('user_id', $userId)
            ->whereDate('tanggal_konsumsi', $today)
            ->selectRaw('SUM(kadar_gula) as total_gula, SUM(kadar_kalori) as total_kalori')
            ->first();

        $maxGula = 50;
        $maxKalori = 2400;

        $gulaPercentage = $dailyTotals->total_gula ? min(($dailyTotals->total_gula / $maxGula) * 100, 100) : 0;
        $kaloriPercentage = $dailyTotals->total_kalori ? min(($dailyTotals->total_kalori / $maxKalori) * 100, 100) : 0;

        return [
            'total_gula' => $dailyTotals->total_gula ?: 0,
            'total_kalori' => $dailyTotals->total_kalori ?: 0,
            'gula_percentage' => round($gulaPercentage, 1),
            'kalori_percentage' => round($kaloriPercentage, 1),
            'max_gula' => $maxGula,
            'max_kalori' => $maxKalori
        ];
    }
}
