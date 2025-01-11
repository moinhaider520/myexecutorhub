<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\TwoFactorCode;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->status !== 'A') {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Your account has not been activated yet.');
        }

        if ($user->trial_ends_at && now()->greaterThan($user->trial_ends_at)) {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Please subscribe to continue.');
        }

        // Generate and send the 2FA code
        $this->sendTwoFactorCode($user);

        // Store user email in session for 2FA verification
        session(['two_factor_email' => $user->email]);

        // Logout the user temporarily
        Auth::logout();

        return redirect()->route('two-factor.index');
    }

    protected function sendTwoFactorCode($user)
    {
        $user->update([
            'two_factor_code' => mt_rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($user));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
