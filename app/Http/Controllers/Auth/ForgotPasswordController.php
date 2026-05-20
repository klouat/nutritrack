<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PasswordResetOtp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Display the password reset request form.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a 5-digit OTP code to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ], [
                'email.exists' => 'We could not find a user with that email address.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }

            $email = $request->email;
            
            // Generate a 5-digit OTP code
            $otp = str_pad(random_int(0, 99999), 5, '0', STR_PAD_LEFT);
            
            // Set expiry time (15 minutes from now)
            $expiresAt = Carbon::now()->addMinutes(15);
            
            // Delete any existing OTPs for this email
            PasswordResetOtp::where('email', $email)->delete();
            
            // Create a new OTP record
            PasswordResetOtp::create([
                'email' => $email,
                'otp' => $otp,
                'expires_at' => $expiresAt,
            ]);
            
            // Send the OTP via email
            $this->sendOtpEmail($email, $otp);
            
            return response()->json([
                'message' => 'A 5-digit code has been sent to your email address. Enter the code to reset your password.',
            ]);
            
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'errors' => ['email' => ['Something went wrong. Please try again.']],
            ], 500);
        }
    }

    /**
     * Send the OTP email to the user.
     *
     * @param  string  $email
     * @param  string  $otp
     * @return void
     */
    protected function sendOtpEmail($email, $otp)
    {
        $user = User::where('email', $email)->first();
        
        $data = [
            'name' => $user->name,
            'otp' => $otp
        ];
        
        Mail::send('emails.password-reset-otp', $data, function($message) use ($email) {
            $message->to($email)
                    ->subject('Password Reset OTP');
        });
    }

    /**
     * Verify the OTP code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOtp(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required|digits:5',
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
                    'errors' => ['otp' => ['Invalid OTP code.']],
                ], 422);
            }
            
            if ($otpRecord->isExpired()) {
                return response()->json([
                    'errors' => ['otp' => ['OTP code has expired. Please request a new one.']],
                ], 422);
            }
            
            // OTP is valid - return success
            return response()->json([
                'message' => 'OTP verified successfully.',
                'verified' => true,
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