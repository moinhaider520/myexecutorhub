<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LifeRemembered;
use Illuminate\Support\Facades\Auth;

class LifeRememberedController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve the LifeRemembered entry created by the authenticated user
        $lifeRemembered = LifeRemembered::where('created_by', $user->created_by)->first();
        
        return view('others.life_remembered.life_remembered', compact('lifeRemembered'));
    }
}