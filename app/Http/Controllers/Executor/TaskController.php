<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index() // Rename this from view to index
    {
        $user = Auth::user();
        $Tasks = Task::where('created_by', $user->created_by)->get();
        return view('executor.tasks.index', compact('Tasks'));

    }
}
