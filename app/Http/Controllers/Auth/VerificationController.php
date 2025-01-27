<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;

class VerificationController extends Controller
{
    /**
     * Show the email verification notice.
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('auth.verify');
    }

    /**
     * Handle an incoming email verification request.
     *
     * @param  \Illuminate\Foundation\Auth\EmailVerificationRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(EmailVerificationRequest $request)
    {
        // Ensure the user is not already verified
        if ($request->user()->hasVerifiedEmail()) {
            return Redirect::route('home'); // Redirect to a desired page
        }

        // Verify the user's email
        $request->user()->markEmailAsVerified();

        // Fire the Verified event
        event(new Verified($request->user()));

        return Redirect::route('home')->with('success', 'Your email has been verified successfully.');
    }

    /**
     * Resend the verification email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        // Ensure the user is authenticated
        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'A fresh verification link has been sent to your email address.');
    }
}
