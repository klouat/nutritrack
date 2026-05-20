<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Asupan;
use App\Models\Message;

class ProfilController extends Controller
{
    public function index()
    {
        return view('dashboard.profil');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'telp' => 'nullable|string|max:20',
            'umur' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string|max:255',
            'riwayat' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->telp,
            'umur' => $request->umur,
            'pekerjaan' => $request->pekerjaan,
            'riwayat_kesehatan' => $request->riwayat,
            'alergi' => $request->alergi,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function editPassword()
    {
        return view('dashboard.password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->old_password, $user->password)) {
            if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Password lama tidak sesuai.'
                ], 422);
            }
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        if ($request->wantsJson() || $request->expectsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Password berhasil diperbarui.'
            ]);
        }
        
        return back()->with('success', 'Password berhasil diperbarui.');
    }
    
    public function destroy(Request $request)
    {
        $user = Auth::user();

        DB::transaction(function () use ($user) {
            DB::table('asupan')->where('user_id', $user->id)->delete();
            DB::table('messages')
                ->where('from_id', $user->id)
                ->orWhere('to_id', $user->id)
                ->delete();
        });

        Auth::logout();
        $user->delete(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('status', 'Akun Anda telah berhasil dihapus.');
    }

    /**
     * API methods for Vue component
     */
    public function getProfileData()
    {
        $user = Auth::user();
        
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'nomor_telepon' => $user->nomor_telepon,
            'umur' => $user->umur,
            'pekerjaan' => $user->pekerjaan,
            'riwayat_kesehatan' => $user->riwayat_kesehatan,
            'alergi' => $user->alergi,
            'routes' => [
                'password_update' => route('profil.password.update'),
                'delete_account' => route('profil.destroy'),
            ]
        ]);
    }

    public function updateProfileApi(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'umur' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string|max:255',
            'riwayat_kesehatan' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'umur' => $request->umur,
            'pekerjaan' => $request->pekerjaan,
            'riwayat_kesehatan' => $request->riwayat_kesehatan,
            'alergi' => $request->alergi,
        ]);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }

    public function updateForPostman(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nomor_telepon' => 'nullable|string|max:20',
            'umur' => 'nullable|integer|min:0',
            'pekerjaan' => 'nullable|string|max:255',
            'riwayat_kesehatan' => 'nullable|string|max:255',
            'alergi' => 'nullable|string|max:255',
        ]);

        $user->update($validated);

        return response()->json([
            'message' => 'Profil berhasil diperbarui.',
            'user' => $user->fresh(),
        ]);
    }
}
