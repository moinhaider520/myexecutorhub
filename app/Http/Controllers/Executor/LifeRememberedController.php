<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\LifeRemembered;
use Illuminate\Support\Facades\Auth;

class LifeRememberedController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        // Retrieve the LifeRemembered entry created by the authenticated user
        $lifeRemembered = LifeRemembered::where('created_by', $user->created_by)->get();
        return view('executor.life_remembered.life_remembered', compact('lifeRemembered'));
    }
}
