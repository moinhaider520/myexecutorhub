<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ExecutorActivationController extends Controller
{
    public function show(string $token): View
    {
        $user = User::where('executor_invite_token', $token)
            ->whereNotNull('executor_invited_at')
            ->first();

        abort_unless($user, 404);

        return view('auth.activate-executor', compact('user', 'token'));
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::where('executor_invite_token', $token)
            ->whereNotNull('executor_invited_at')
            ->firstOrFail();

        DB::transaction(function () use ($request, $user) {
            $user->forceFill([
                'password' => Hash::make($request->password),
                'preferred_role' => $user->preferred_role ?: 'executor',
                'user_role' => $user->user_role ?: 'executor',
            ])->save();

            $user->markExecutorActivated();
        });

        return redirect()
            ->route('login')
            ->with('status', 'Your executor account has been activated. Please sign in.');
    }
}
