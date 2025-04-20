<?php
namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use Exception;
use Illuminate\Support\Facades\Log;

class VoiceNotesController extends Controller
{
    public function view()
    {
        $voiceNotes = VoiceNotes::where('created_by', Auth::id())->get();
        return view('customer.notes.voice_notes', compact('voiceNotes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'audio-blob' => 'required',
        ]);

        try {
            $audioBlob = $request->input('audio-blob');
            $audioBlob = str_replace('data:audio/wav;base64,', '', $audioBlob);
            $audioBlob = str_replace(' ', '+', $audioBlob);
            $audioData = base64_decode($audioBlob);

            $fileName = uniqid() . '.wav';
            $directory = public_path('storage/voice_notes');

            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }

            $filePath = $directory . '/' . $fileName;
            file_put_contents($filePath, $audioData);

            $voiceNote = new VoiceNotes();
            $voiceNote->start_date = $request->start_date;
            $voiceNote->end_date = $request->start_date;
            $voiceNote->voice_note = 'voice_notes/' . $fileName;
            $voiceNote->created_by = Auth::id();
            $voiceNote->save();

            return redirect()->back()->with('success', 'Voice note added successfully.');
        } catch (Exception $e) {
            Log::error('Customer Voice Note Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while saving the voice note.');
        }
    }

    public function destroy($id)
    {
        try {
            $voiceNote = VoiceNotes::findOrFail($id);

            $filePath = public_path('storage/' . $voiceNote->voice_note);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $voiceNote->delete();

            return redirect()->back()->with('success', 'Voice note deleted successfully.');
        } catch (Exception $e) {
            Log::error('Customer Voice Note Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while deleting the voice note.');
        }
    }
}
