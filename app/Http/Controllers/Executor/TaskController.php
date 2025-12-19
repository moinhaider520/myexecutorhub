<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index() // Rename this from view to index
    {
        $contextUser = ContextHelper::user();
        $Tasks = Task::where('created_by', $contextUser->id)->get();
        return view('executor.tasks.index', compact('Tasks'));

    }
}
