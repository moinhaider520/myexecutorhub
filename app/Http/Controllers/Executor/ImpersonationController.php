<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    public function start(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
        ]);

        $executor = auth()->user();
        abort_unless(
            $executor->customers()->where('users.id', $request->customer_id)->exists(),
            403
        );
        session([
            'acting_customer_id' => $request->customer_id,
        ]);

        return response()->json([
            'success' => true,
            'redirect' => route('executor.dashboard'),
        ]);
    }
}
