<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCode;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.two-factor');
    }

    public function verify(Request $request)
    {
        $request->validate(['two_factor_code' => 'required|numeric']);

        // Retrieve the user by email stored in the session
        $user = User::where('email', session('two_factor_email'))->first();

        if (!$user || $user->two_factor_code !== $request->two_factor_code) {
            return redirect()->route('two-factor.index')->withErrors(['two_factor_code' => 'Invalid code.']);
        }

        // Ensure two_factor_expires_at is a Carbon instance before comparing
        $expiresAt = Carbon::parse($user->two_factor_expires_at);

        if ($expiresAt->lessThan(now())) {
            return redirect()->route('two-factor.index')->withErrors(['two_factor_code' => 'The code has expired.']);
        }

        $user->update([
            'last_login' => now(),
        ]);

        // Log the user in
        Auth::login($user);

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('executor')) {
            return redirect()->route('executor.dashboard');
        } elseif ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        } elseif ($user->hasRole('partner')) {
            return redirect()->route('partner.dashboard');
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function resend(Request $request)
    {
        // fetch the email we stored earlier in session
        $email = session('two_factor_email');

        if (!$email) {
            return redirect()->route('login')->with('status', 'Session expired, please log in again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->with('status', 'User not found.');
        }

        // regenerate code and send again
        $user->update([
            'two_factor_code' => mt_rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($user));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }
}
