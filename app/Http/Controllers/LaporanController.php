<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function create()
    {
        return view('dashboard.laporan');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi_laporan' => 'required|string',
        ]);
        
        $laporan = Laporan::create([
            'judul' => $request->judul,
            'isi_laporan' => $request->isi_laporan,
        ]);

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Laporan berhasil dibuat.',
                'laporan' => $laporan
            ], 201);
        }

        return redirect()->route('laporan.create')->with('success', 'Laporan berhasil dibuat.');
    }
}
