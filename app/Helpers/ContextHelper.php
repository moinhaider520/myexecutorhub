<?php
namespace App\Helpers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ContextHelper
{
    public static function user()
    {
        // Executor acting as customer
        if (
            Auth::check() &&
            Auth::user()->hasRole('executor') &&
            session()->has('acting_customer_id')
        ) {
            return User::find(session('acting_customer_id'));
        }

        // Normal logged-in user
        return Auth::user();
    }

    public static function isImpersonating()
    {
        return session()->has('acting_customer_id');
    }
}
