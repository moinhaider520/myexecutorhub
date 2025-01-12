<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\VoiceNotes;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function view()
    {
        $Tasks = VoiceNotes::where('created_by', Auth::id())->get();
        return view('partner.tasks.index',compact('Tasks'));
    }
}
