<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\VoiceNotes;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function view()
    {
        $user = Auth::user();
        $Tasks = VoiceNotes::where('created_by', $user->created_by)->get();
        return view('executor.tasks.index',compact('Tasks'));
    }
}
