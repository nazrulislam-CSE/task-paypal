<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Mail\OtpMail;

class OTPVerificationController extends Controller
{
    public function verifyOTP(Request $request)
    {
        // Validate OTP input
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email',
        ]);

        // Retrieve the session stored OTP
        $sessionOtp = session('otp');

        // If OTP matches the session value
        if ($sessionOtp && $sessionOtp == $request->otp) {
            // Clear OTP session after successful verification
            session()->forget('otp');

            // Optionally, you can log the user in automatically here
            $user = User::where('email', $request->email)->first();
            auth()->login($user);

            // Redirect to the dashboard
            return redirect()->route('user.dashboard'); // Update with your dashboard route
        }

        // If OTP does not match, show error
        return back()->with('error', 'Invalid OTP. Please try again.');
    }

    
}

