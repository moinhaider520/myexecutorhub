<?php
namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VoiceNotes;
use Illuminate\Support\Facades\Storage;

class VoiceNotesController extends Controller
{
    public function view()
    {
        $voiceNotes = VoiceNotes::where('created_by', Auth::id())->get();
        return view('partner.notes.voice_notes', compact('voiceNotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'audio-blob' => 'required',
        ]);

        $audioBlob = $request->input('audio-blob');
        $audioBlob = str_replace('data:audio/wav;base64,', '', $audioBlob);
        $audioBlob = str_replace(' ', '+', $audioBlob);
        $audioData = base64_decode($audioBlob);

        $fileName = 'voice_notes/' . uniqid() . '.wav';
        Storage::disk('public')->put($fileName, $audioData);

        $voiceNote = new VoiceNotes();
        $voiceNote->start_date = $request->start_date;
        $voiceNote->end_date = $request->start_date;
        $voiceNote->voice_note = $fileName;
        $voiceNote->created_by = Auth::id();
        $voiceNote->save();

        return redirect()->back()->with('success', 'Voice note added successfully.');
    }

    public function destroy($id)
    {
        $voiceNote = VoiceNotes::findOrFail($id);

        // Delete the file from storage
        Storage::disk('public')->delete($voiceNote->voice_note);

        // Delete the record from the database
        $voiceNote->delete();

        return redirect()->back()->with('success', 'Voice note added successfully.');
    }
}
