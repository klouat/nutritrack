<?php

namespace App\Http\Controllers;

use App\Models\Asupan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;

class AsupanController extends Controller
{   
    public function index(Request $request): JsonResponse
    {
        $asupan = Asupan::query()
            ->where('user_id', Auth::id())
            ->orderByDesc('tanggal_konsumsi')
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'message' => $asupan->isEmpty()
                ? 'Data asupan tidak ditemukan.'
                : 'Data asupan berhasil diambil.',
            'asupan' => $asupan,
        ]);
    }

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

        $weeklyAsupan = Asupan::query()
            ->where('user_id', $user->id)
            ->whereDate('tanggal_konsumsi', '>=', now()->subDays(6)->toDateString())
            ->selectRaw('tanggal_konsumsi, COALESCE(SUM(kadar_gula), 0) as total_gula, COALESCE(SUM(kadar_kalori), 0) as total_kalori')
            ->groupBy('tanggal_konsumsi')
            ->orderBy('tanggal_konsumsi')
            ->get()
            ->keyBy(function (Asupan $item) {
                return Carbon::parse($item->tanggal_konsumsi)->toDateString();
            });

        $weeklySummary = collect(range(6, 0))
            ->map(function (int $daysAgo) use ($weeklyAsupan) {
                $date = now()->subDays($daysAgo)->toDateString();
                $item = $weeklyAsupan->get($date);

                return [
                    'tanggal' => $date,
                    'label' => Carbon::parse($date)->translatedFormat('D'),
                    'total_gula' => (float) ($item->total_gula ?? 0),
                    'total_kalori' => (float) ($item->total_kalori ?? 0),
                ];
            })
            ->values();

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
            'weekly_asupan' => $weeklySummary,
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
            'porsi' => 'required|numeric|gt:0',
            'kadar_gula' => 'nullable|numeric|gte:0',
            'kadar_kalori' => 'nullable|numeric|gte:0',
            'tanggal_konsumsi' => 'nullable|date',
            'waktu_konsumsi' => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $porsi = (float) $validated['porsi'];
        $kadarGula = (float) ($validated['kadar_gula'] ?? 0);
        $kadarKalori = (float) ($validated['kadar_kalori'] ?? 0);

        $asupan = Asupan::create([
            'user_id' => Auth::id(),
            'nama' => $validated['nama'],
            'porsi' => $porsi,
            'kadar_gula' => $kadarGula * $porsi,
            'kadar_kalori' => $kadarKalori * $porsi,
            'tanggal_konsumsi' => $validated['tanggal_konsumsi'] ?? now()->toDateString(),
            'waktu_konsumsi' => $validated['waktu_konsumsi'] ?? 'Pagi',
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

    public function update(Request $request, Asupan $asupan)
    {
        abort_if($asupan->user_id !== Auth::id(), 403);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string',
            'porsi' => 'sometimes|required|numeric|gt:0',
            'kadar_gula' => 'sometimes|required|numeric|gte:0',
            'kadar_kalori' => 'sometimes|required|numeric|gte:0',
            'tanggal_konsumsi' => 'sometimes|required|date',
            'waktu_konsumsi' => 'sometimes|required|string',
            'catatan' => 'nullable|string',
        ]);

        $baseGula = array_key_exists('kadar_gula', $validated)
            ? (float) $validated['kadar_gula']
            : ((float) $asupan->kadar_gula / max((float) $asupan->porsi, 1));

        $baseKalori = array_key_exists('kadar_kalori', $validated)
            ? (float) $validated['kadar_kalori']
            : ((float) $asupan->kadar_kalori / max((float) $asupan->porsi, 1));

        $porsi = array_key_exists('porsi', $validated)
            ? (float) $validated['porsi']
            : (float) $asupan->porsi;

        $asupan->update([
            'nama' => $validated['nama'] ?? $asupan->nama,
            'porsi' => $porsi,
            'kadar_gula' => $baseGula * $porsi,
            'kadar_kalori' => $baseKalori * $porsi,
            'tanggal_konsumsi' => $validated['tanggal_konsumsi'] ?? $asupan->tanggal_konsumsi,
            'waktu_konsumsi' => $validated['waktu_konsumsi'] ?? $asupan->waktu_konsumsi,
            'catatan' => $validated['catatan'] ?? $asupan->catatan,
        ]);

        return response()->json([
            'message' => 'Asupan berhasil diperbarui.',
            'asupan' => $asupan->fresh(),
        ]);
    }

    public function destroy(Request $request, Asupan $asupan)
    {
        abort_if($asupan->user_id !== Auth::id(), 403);

        $asupan->delete();

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Asupan berhasil dihapus.',
            ]);
        }

        return redirect()->back()->with('success', 'Asupan berhasil dihapus.');
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
