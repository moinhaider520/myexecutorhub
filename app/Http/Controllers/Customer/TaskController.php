<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\VoiceNotes;
use Auth;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function view()
    {
        $Tasks = VoiceNotes::where('created_by', Auth::id())->get();
        return view('customer.tasks.index',compact('Tasks'));
    }
}
