<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use Illuminate\Support\Facades\Auth;

class VoiceNotesController extends Controller
{
    /**
     * Display the voice notes view.
     *
     * @return \Illuminate\View\View
     */
    public function view()
    {
        $contextUser = ContextHelper::user();
        $voiceNotes = VoiceNotes::where('created_by', $contextUser->id)->get();
        // Return the view with the voice notes data
        return view('executor.notes.voice_notes', compact('voiceNotes'));
    }
}
