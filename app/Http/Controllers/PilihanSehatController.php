<?php

namespace App\Http\Controllers;

use App\Models\PilihanSehat;
use Illuminate\Http\Request;

class PilihanSehatController extends Controller
{
    protected function buildPilihanSehatQuery(?string $kategori = null)
    {
        $query = PilihanSehat::query();

        if ($kategori) {
            $query->where('kategori', strtolower($kategori));
        }

        return $query;
    }

    public function index(Request $request, $kategori = null)
    {
        $query = PilihanSehat::where('aktif', 1);

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $items = $query->orderBy('urutan')->get();

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Data pilihan sehat berhasil diambil.',
                'kategori' => $kategori,
                'items' => $items,
            ]);
        }

        return view('dashboard.pilihansehat.index', compact('items', 'kategori'));
    }

    public function adminIndex(Request $request)
    {
        $items = $this->buildPilihanSehatQuery(
            $request->filled('kategori') ? $request->kategori : null
        )->get();

        return view('admin.pilihansehat.index', compact('items'));
    }

    public function adminApiIndex(Request $request)
    {
        $items = $this->buildPilihanSehatQuery(
            $request->filled('kategori') ? $request->kategori : null
        )->get();

        return response()->json([
            'message' => 'Data admin pilihan sehat berhasil diambil.',
            'items' => $items,
        ]);
    }

    public function create()
    {
        return view('admin.pilihansehat.create');
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'gambar_path' => 'nullable|image',
            'nama' => 'required',
            'deskripsi' => 'required',
            'urutan' => 'required|integer',
            'aktif' => 'required|boolean',
        ]);

        if ($request->hasFile('gambar_path')) {
            $file = $request->file('gambar_path');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $filename);
            $data['gambar_path'] = 'images/' . $filename;
        }

        $pilihanSehat = PilihanSehat::create($data);

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Data berhasil ditambahkan.',
                'item' => $pilihanSehat,
            ], 201);
        }

        return redirect()->route('admin.pilihan-sehat.index')->with('success', 'Data berhasil ditambahkan.');
    }
public function edit(PilihanSehat $pilihanSehat)
{
    if (request()->wantsJson()) {
        return response()->json($pilihanSehat);
    }

    return view('admin.pilihansehat.edit', compact('pilihanSehat'));
}


public function update(Request $request, PilihanSehat $pilihanSehat)
{
    $data = $request->validate([
        'nama' => 'required',
        'deskripsi' => 'required',
        'urutan' => 'required|integer',
        'aktif' => 'required|boolean',
        'gambar_path' => 'nullable|image',
    ]);

    if ($request->hasFile('gambar_path')) {
        $file = $request->file('gambar_path');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('images'), $filename);
        $data['gambar_path'] = 'images/' . $filename;
    }

    $pilihanSehat->update($data);

    if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui.',
            'item' => $pilihanSehat->fresh(),
        ]);
    }

    return redirect()->route('admin.pilihan-sehat.index')->with('success', 'Data berhasil diperbarui.');
}
    public function destroy(PilihanSehat $pilihanSehat)
    {
        try {
            // Simpan informasi file gambar sebelum menghapus
            $gambarPath = $pilihanSehat->gambar_path;
            
            // Hapus dari database
            $pilihanSehat->delete();
            
            // Jika request minta JSON, berikan response JSON
            if (request()->wantsJson() || request()->expectsJson() || request()->ajax() || request()->is('api/*')) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus.'
                ]);
            }
            
            // Response normal untuk non-AJAX
            return back()->with('success', 'Data berhasil dihapus.');
        } catch (\Exception $e) {
            // Log error
            \Log::error('Error menghapus pilihan sehat: ' . $e->getMessage());
            
            // Response JSON jika diperlukan
            if (request()->wantsJson() || request()->expectsJson() || request()->ajax() || request()->is('api/*')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus data: ' . $e->getMessage()
                ], 500);
            }
            
            // Response normal
            return back()->with('error', 'Gagal menghapus data.');
        }
    }
}
