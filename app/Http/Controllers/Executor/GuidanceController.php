<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
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
        $contextUser = ContextHelper::user();
        // Retrieve the guidance created by the authenticated user
        $guidance = Guidance::where('created_by', $contextUser->id)->get();

        return view('executor.guidance.guidance', compact('guidance'));
    }
}
