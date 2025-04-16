<?php

namespace App\Http\Controllers\Executor;

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
        $guidance = Guidance::where('created_by', $user->created_by)->get();
        
        return view('executor.guidance.guidance', compact('guidance'));
    }
}
