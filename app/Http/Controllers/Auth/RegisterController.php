<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Laravel\Sanctum\NewAccessToken;

class RegisterController extends Controller
{
    /**
     * Handle the user registration process.
     */
    public function register(Request $request)
    {
        Log::info('Registration request received:', $request->all());
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.unique' => 'Email sudah digunakan.',
        ]);

       
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Create user in the database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), 
            'role' => 'user', 
            'remember_token' => Str::random(10),
        ]);

        /** @var NewAccessToken $token */
        $token = $user->createToken('api-register-token');
       
        return response()->json([
            'message' => 'User successfully registered!',
            'user' => $user,
            'token' => $token->plainTextToken,
            'token_type' => 'Bearer',
        ], 201)->cookie(
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
}
