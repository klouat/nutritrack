<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsultasiController extends Controller
{
    public function chooseDoctor()
    {
        return view('dashboard.konsultasi.index');
    }
    public function messagesForDoctor()
    {
        $role = Auth::user()->role; 
        
        
        if (!in_array($role, ['dokter_pencegahan', 'dokter_pengobatan'])) {
            abort(403, "Access denied. You are not authorized to view this page.");
        }
        $users = Message::where('to_role', $role)
            ->distinct('from_id')
            ->pluck('from_id')
            ->map(function ($userId) {
                return User::find($userId);
            });

        return view('dashboard.konsultasi.dokter', compact('users', 'role'));
    }
 public function chatPageWithUser($userId)
    {
        $auth = Auth::user();
        if (!in_array($auth->role, ['dokter_pencegahan', 'dokter_pengobatan', 'user'])) {
            abort(403, "Access denied. You are not authorized to view this page.");
        }


        if (in_array($auth->role, ['dokter_pencegahan', 'dokter_pengobatan'])) {
            $messages = Message::where(function ($query) use ($auth, $userId) {
                $query->where('from_id', $auth->id)
                      ->where('to_id', $userId);
            })->orWhere(function ($query) use ($auth, $userId) {
                $query->where('from_id', $userId)
                      ->where('to_id', $auth->id); 
            })->orWhere(function ($query) use ($auth, $userId) {
                $query->where('from_id', $userId)
                      ->whereNull('to_id')
                      ->where('to_role', $auth->role);
            })->orderBy('created_at')->get();
        } else {
            $messages = Message::where(function ($query) use ($auth, $userId) {
                $query->where('from_id', $auth->id)
                      ->where('to_id', $userId);
            })->orWhere(function ($query) use ($auth, $userId) {
                $query->where('from_id', $userId)
                      ->where('to_id', $auth->id);
            })->orderBy('created_at')->get();
        }

        return view('dashboard.konsultasi.chatdokter', [
            'messages' => $messages,
            'role' => $auth->role,
            'userId' => $userId,
        ]);
    }

public function chatPage($role)
{
    $userId = Auth::id();

    $dokterIds = User::where('role', $role)->pluck('id');

    $messages = Message::where(function ($query) use ($userId, $role) {
        $query->where('from_id', $userId)
              ->where('to_role', $role);
    })->orWhere(function ($query) use ($userId, $dokterIds) {
        $query->whereIn('from_id', $dokterIds)
              ->where('to_id', $userId);
    })->orderBy('created_at')->get();

    return view('dashboard.konsultasi.chat', compact('role', 'messages'));
}

    public function sendMessage(Request $request)
{
    $request->validate([
        'message' => 'required',
        'to_role' => 'nullable|in:dokter_pencegahan,dokter_pengobatan',
        'to_id' => 'nullable|exists:users,id',
    ]);
    if (!$request->to_role && !$request->to_id) {
        return response()->json(['success' => false, 'error' => 'Tujuan pesan harus ditentukan.']);
    }

    Message::create([
        'from_id' => Auth::id(),
        'to_id' => $request->to_id,
        'to_role' => $request->to_role, 
        'message' => $request->message,
    ]);

    return response()->json(['success' => true, 'message' => $request->message]);
}
public function fetchMessages($role)
{
    $userId = Auth::id();
    $dokterIds = User::where('role', $role)->pluck('id');

    $messages = Message::where(function ($query) use ($userId, $role) {
        $query->where('from_id', $userId)
              ->where('to_role', $role);
    })->orWhere(function ($query) use ($userId, $dokterIds) {
        $query->whereIn('from_id', $dokterIds)
              ->where('to_id', $userId);
    })->orderBy('created_at')->get();

    return response()->json($messages);
}
public function fetchMessagesFromUser($userId)
    {
        $authId = Auth::id();
        $authUserRole = Auth::user()->role;

        $messages = Message::where(function ($query) use ($authId, $userId) {
            $query->where('from_id', $authId)
                  ->where('to_id', $userId);
        })
        ->orWhere(function ($query) use ($authId, $userId, $authUserRole) {
            $query->where('from_id', $userId)
                  ->where(function($q) use ($authId, $authUserRole) {
                      $q->where('to_id', $authId) 
                        ->orWhere(function($subQ) use ($authUserRole) {
                            $subQ->whereNull('to_id') 
                                 ->where('to_role', $authUserRole);
                        });
                  });
        })
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json($messages);
    }

    public function sendForPostman(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'to_role' => 'nullable|in:dokter_pencegahan,dokter_pengobatan',
            'to_id' => 'nullable|exists:users,id',
        ]);

        if (empty($validated['to_role']) && empty($validated['to_id'])) {
            return response()->json([
                'message' => 'Tujuan konsultasi harus diisi dengan to_role atau to_id.'
            ], 422);
        }

        $message = Message::create([
            'from_id' => Auth::id(),
            'to_id' => $validated['to_id'] ?? null,
            'to_role' => $validated['to_role'] ?? null,
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Konsultasi berhasil dikirim.',
            'data' => $message,
        ], 201);
    }
}
