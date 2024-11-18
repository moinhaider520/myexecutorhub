<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected function authenticated(Request $request, $user)
    {
        if ($user->status !== 'A') {
            Auth::logout(); // Logout the user
            return redirect()->route('login')->with('status', 'Your account has not been activated yet.');
        }

        // Check if the trial period has ended
        if ($user->trial_ends_at && now()->greaterThan($user->trial_ends_at)) {
            Auth::logout();
            return redirect()->route('login')->with('status', 'Please subscribe to continue.');
        }

        // Update last_login field
        $user->update(['last_login' => now()]);

        // Redirect based on role
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

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
}
