<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guidance;
use Illuminate\Support\Facades\Auth;

class GuidanceController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve the guidance created by the authenticated user
        $guidance = Guidance::where('created_by', $user->created_by)->first();
        
        return view('others.guidance.guidance', compact('guidance'));
    }
}
