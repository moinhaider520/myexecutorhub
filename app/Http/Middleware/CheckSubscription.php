<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $requiredPackage
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $requiredPackage)
    {
        $user = Auth::user();

        // Check if the user has the required subscription package
        if ($user && $user->subscribed_package === $requiredPackage) {
            return $next($request);
        }

        // Redirect or show an error if the user does not have the required package
        return redirect()->route('customer.dashboard')->with('error', 'You do not have access to this page.');
    }
}
