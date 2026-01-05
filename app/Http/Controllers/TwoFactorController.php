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

        $user = User::where('email', session('two_factor_email'))->first();

        if (!$user || $user->two_factor_code !== $request->two_factor_code) {
            return redirect()->route('two-factor.index')
                ->withErrors(['two_factor_code' => 'Invalid code.']);
        }

        if (Carbon::parse($user->two_factor_expires_at)->lessThan(now())) {
            return redirect()->route('two-factor.index')
                ->withErrors(['two_factor_code' => 'The code has expired.']);
        }

        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
            'last_login' => now(),
        ]);

        Auth::loginUsingId($user->id);
        $request->session()->regenerate();

        if ($user->hasRole('executor')) {
            $user->load('customers');
            $firstCustomer = $user->customers->first();
            if ($firstCustomer) {
                session([
                    'acting_customer_id' => $firstCustomer->id,
                ]);
            } else {
                session()->forget('acting_customer_id');
            }
            return redirect()->route('executor.dashboard');
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('customer')) {
            return redirect()->route('customer.dashboard');
        }

        if ($user->hasRole('partner')) {
            return redirect()->route('partner.dashboard');
        }

        return redirect()->route('dashboard');
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
