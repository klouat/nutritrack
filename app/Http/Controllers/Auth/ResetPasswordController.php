<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules;

class ResetPasswordController extends Controller
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reset(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'otp' => 'required|digits:5',
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $email = $request->email;
            $otp = $request->otp;
            
            // Find the OTP record
            $otpRecord = PasswordResetOtp::where('email', $email)
                                        ->where('otp', $otp)
                                        ->where('used', false)
                                        ->first();
            
           if (!$otpRecord) {
            return response()->json([
             'errors' => ['otp' => 'Invalid OTP code.'],
            ], 422);
            }

            
           if ($otpRecord->isExpired()) {
            return response()->json([
             'errors' => ['otp' => 'OTP code has expired. Please request a new one.'],
                 ], 422);
            }
            
            // Find the user and reset their password
            $user = User::where('email', $email)->first();
            
            $user->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));

            $user->save();
            
            // Mark the OTP as used
            $otpRecord->update(['used' => true]);
            
            // Fire the password reset event
            event(new PasswordReset($user));
            
            return response()->json([
                'message' => 'Your password has been reset successfully',
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => ['general' => ['Something went wrong. Please try again.']],
            ], 500);
        }
    }
} 