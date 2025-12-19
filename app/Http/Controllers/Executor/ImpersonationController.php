<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request)
    {
        $customerId = $request->customer_id;
        $executor = Auth::user();

        abort_unless(
            $executor->customers()->where('users.id', $customerId)->exists(),
            403
        );

        session(['acting_customer_id' => $customerId]);

        return response()->json(['success' => true]);
    }
}
