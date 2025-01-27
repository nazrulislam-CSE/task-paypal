<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail; 

class UserController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Send verification email
        $user->sendEmailVerificationNotification();

        return back()->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
    
        // Find the user by email
        $user = User::where('email', $request->email)->first();
    
        // If user exists and the password matches
        if ($user && Hash::check($request->password, $user->password)) {
            // Generate OTP and save it in the user's session
            $otp = rand(100000, 999999); // Generate a 6-digit OTP


            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(10);
            $user->save();
    
            // Send OTP via email
            Mail::to($user->email)->send(new OtpMail($otp));
    
            // Store OTP in the session (optional, for easy access in the verification)
            session(['otp' => $otp]);
    
            // Pass a success message to the OTP page
            session()->flash('success', 'An OTP has been sent to your email.');

            // Redirect to OTP verification page
            return view('auth.otp', ['email' => $request->email]);
        }

        // If the credentials are invalid
        return back()->with('error', 'Invalid credentials.');
    }

    // Method to resend OTP
    public function resendOTP(Request $request)
    {
        // Validate email
        $request->validate([
            'email' => 'required|email',
        ]);

        // Retrieve the user based on email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Generate a new OTP
            $otp = rand(100000, 999999);

            // Store OTP in session
            session(['otp' => $otp]);

            // Optionally, send the OTP to the user via email
            Mail::to($user->email)->send(new OtpMail($otp));

            // Send a success message
            return back()->with('success', 'OTP has been resent to your email.');
        }

        // If user not found
        return back()->with('error', 'User not found.');
    }

    public function verifyOTP(Request $request)
    {
        // Validate the OTP and email
        $request->validate([
            'otp' => 'required|numeric',
            'email' => 'required|email',
        ]);

        // Retrieve the user by email
        $user = User::where('email', $request->email)->first();

        // Check if OTP matches the one stored in the session or database
        if ($user && $user->otp == $request->otp) {
            // Optionally, clear OTP from the session/database after successful verification
            $user->otp = null; // Remove OTP from database
            $user->save();

            session()->forget('otp'); // Remove OTP from session

            // Optionally, log the user in after verification
            auth()->login($user);

            // Redirect to the dashboard or desired page
            return redirect()->route('user.dashboard')->with('success', 'User Login Successfully');
        }

        // If OTP is incorrect, show error message
        return back()->with('error', 'Invalid OTP. Please try again.');
    }

    public function dashboard()
    {
        $pageTitle = "User Dashboard";
        $products = Product::latest()->get();
        return view('frontend.dashboard',compact('pageTitle','products'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('error','User Logout Successfully');;
    }



}
