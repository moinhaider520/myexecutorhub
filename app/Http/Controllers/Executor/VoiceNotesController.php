<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use App\Traits\CloudinaryUpload;
use Exception;
use Illuminate\Support\Facades\Log;

class VoiceNotesController extends Controller
{
    use CloudinaryUpload;

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

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'audio-blob' => 'required',
        ]);

        try {
            $audioBlob = $request->input('audio-blob');
            $audioBlob = str_replace('data:audio/wav;base64,', '', $audioBlob);
            $audioBlob = preg_replace('/^data:audio\/[^;]+;base64,/', '', $audioBlob);
            $audioBlob = str_replace(' ', '+', $audioBlob);
            $audioData = base64_decode($audioBlob);

            if ($audioData === false) {
                return redirect()->back()->with('error', 'Invalid audio data.');
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'voice_note_');
            file_put_contents($tempPath, $audioData);
            $upload = $this->uploadFileToCloud(new \SplFileInfo($tempPath), 'executorhub/voice_notes');
            @unlink($tempPath);

            $contextUser = ContextHelper::user();
            $voiceNote = new VoiceNotes();
            $voiceNote->start_date = $request->start_date;
            $voiceNote->end_date = $request->start_date;
            $voiceNote->voice_note = $upload['url'];
            $voiceNote->voice_note_public_id = $upload['public_id'];
            $voiceNote->created_by = $contextUser->id;
            $voiceNote->save();

            return redirect()->back()->with('success', 'Voice note added successfully.');
        } catch (Exception $e) {
            Log::error('Executor Voice Note Store Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while saving the voice note.');
        }
    }

    public function destroy($id)
    {
        try {
            $voiceNote = VoiceNotes::findOrFail($id);
            $this->deleteStoredFile($voiceNote->voice_note, $voiceNote->voice_note_public_id);
            $voiceNote->delete();

            return redirect()->back()->with('success', 'Voice note deleted successfully.');
        } catch (Exception $e) {
            Log::error('Executor Voice Note Delete Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while deleting the voice note.');
        }
    }

    private function deleteStoredFile(?string $path, ?string $publicId): void
    {
        if (!empty($publicId)) {
            $this->deleteFromCloud($publicId);
            return;
        }

        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        $filePath = public_path('storage/' . ltrim($path, '/'));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
