<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
}
