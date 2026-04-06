<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolePreferenceController extends Controller
{
    public function switch(Request $request, string $role): RedirectResponse
    {
        $user = Auth::user();
        abort_unless($user && in_array($role, $user->availableDashboardRoles(), true), 403);

        $request->session()->put('active_role', $role);

        if ($role !== 'executor') {
            $request->session()->forget('acting_customer_id');
        } elseif (!$request->session()->has('acting_customer_id')) {
            $user->loadMissing('customers');
            $firstCustomer = $user->customers->first();

            if ($firstCustomer) {
                $request->session()->put('acting_customer_id', $firstCustomer->id);
            }
        }

        return redirect()->route($user->dashboardRouteName($role));
    }

    public function updatePreference(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'preferred_role' => ['required', 'string'],
        ]);

        $preferredRole = $request->string('preferred_role')->toString();
        abort_unless($user && in_array($preferredRole, $user->availableDashboardRoles(), true), 403);

        $user->update([
            'preferred_role' => $preferredRole,
        ]);

        $request->session()->put('active_role', $preferredRole);

        if ($preferredRole !== 'executor') {
            $request->session()->forget('acting_customer_id');
        }

        return redirect()->back()->with('success', 'Preferred role updated successfully.');
    }
}
