<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BlockDeceasedCustomerAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || !$user->isDeceasedCustomer()) {
            return $next($request);
        }

        Auth::logout();
        $request->session()?->invalidate();
        $request->session()?->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'This customer account is marked as deceased and can no longer be used.',
            ], 403);
        }

        return redirect()->route('login')
            ->with('status', 'This customer account is marked as deceased and can no longer be used.');
    }
}
