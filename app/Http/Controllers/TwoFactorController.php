<?php

namespace App\Http\Controllers;

use App\Mail\TwoFactorCode;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;
use Mail;
use Twilio\Rest\Client;

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
        $email = session('two_factor_email');

        if (!$email) {
            return redirect()->route('login')->with('status', 'Session expired, please log in again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')->with('status', 'User not found.');
        }

        $user->update([
            'two_factor_code' => mt_rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        Mail::to($user->email)->send(new TwoFactorCode($user));

        return back()->with('status', 'A new verification code has been sent to your email.');
    }

    public function sendSms(Request $request)
    {
        $email = session('two_factor_email');

        if (!$email) {
            return redirect()->route('login')
                ->with('status', 'Session expired, please log in again.');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('login')
                ->with('status', 'User not found.');
        }

        $to = $user->contact_number;

        if (empty($to)) {
            return back()->withErrors([
                'sms' => 'No contact number is associated with your account.',
            ]);
        }

        // Normalize phone (remove spaces)
        $to = preg_replace('/\s+/', '', $to);

        // Optional: ensure it starts with +
        if (!str_starts_with($to, '+')) {
            return back()->withErrors([
                'sms' => 'Phone number must be in international format (e.g. +447XXXXXXXXX).',
            ]);
        }

        // Generate fresh OTP for SMS
        $user->update([
            'two_factor_code' => mt_rand(100000, 999999),
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        $sid = Config::get('services.twilio.sid');
        $token = Config::get('services.twilio.token');
        $from = Config::get('services.twilio.from');

        if (!$sid || !$token || !$from) {
            return back()->withErrors([
                'sms' => 'Twilio is not configured. Please contact support.',
            ]);
        }

        try {
            $client = new Client($sid, $token);

            $client->messages->create($to, [
                'from' => $from,
                'body' => "Your verification code is: {$user->two_factor_code}",
            ]);

            return back()->with('status', 'Verification code sent to your phone.');
        } catch (\Throwable $e) {
            return back()->withErrors([
                'sms' => 'Failed to send SMS. Please try again.',
            ]);
        }
    }
}
