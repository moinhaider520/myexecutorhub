<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use App\Traits\CloudinaryUpload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class VoiceNotesController extends Controller
{
    use CloudinaryUpload;

    /**
     * Display the voice notes for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            $voiceNotes = VoiceNotes::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => $voiceNotes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a new voice note.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request
        $request->validate([
            'start_date' => 'required|date',
            'audio_blob' => 'required',
        ]);

        try {
            if ($request->hasFile('audio_blob')) {
                $upload = $this->uploadFileToCloud($request->file('audio_blob'), 'executorhub/voice_notes');
            } else {
                $audioBlob = (string) $request->input('audio_blob');
                $audioBlob = preg_replace('/^data:audio\/[^;]+;base64,/', '', $audioBlob);
                $audioBlob = str_replace(' ', '+', $audioBlob);
                $audioData = base64_decode($audioBlob);

                if ($audioData === false) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid audio data.'
                    ], 422);
                }

                $tempPath = tempnam(sys_get_temp_dir(), 'voice_note_');
                file_put_contents($tempPath, $audioData);
                $upload = $this->uploadFileToCloud(new \SplFileInfo($tempPath), 'executorhub/voice_notes');
                @unlink($tempPath);
            }

            // Create a new voice note record in the database
            $voiceNote = new VoiceNotes();
            $voiceNote->start_date = $request->start_date;
            $voiceNote->end_date = $request->start_date; // Assuming end_date is the same as start_date
            $voiceNote->voice_note = $upload['url'];
            $voiceNote->voice_note_public_id = $upload['public_id'];
            $voiceNote->created_by = Auth::id();
            $voiceNote->save();

            return response()->json([
                'success' => true,
                'message' => 'Voice note added successfully.',
                'data' => $voiceNote
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a voice note.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        try {
            $voiceNote = VoiceNotes::findOrFail($id);

            $this->deleteStoredFile($voiceNote->voice_note, $voiceNote->voice_note_public_id);

            // Delete the record from the database
            $voiceNote->delete();

            return response()->json([
                'success' => true,
                'message' => 'Voice note deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
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
