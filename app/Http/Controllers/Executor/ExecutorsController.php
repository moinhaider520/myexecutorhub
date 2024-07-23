<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ExecutorsController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve executors created by the authenticated user
        $executors = User::role('executor')->where('created_by', $user->created_by)->get();
        
        return view('executor.executors.executors', compact('executors'));
    }
}
