<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class VoiceNotesController extends Controller
{
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
        'audio_blob' => 'required', // Validate the file type
    ]);

    try {
        // Get the uploaded file from the request
        $audioFile = $request->file('audio_blob');

        // Generate a unique file name with the correct extension
        $uniqueFileName = uniqid() . '.' . $audioFile->getClientOriginalExtension();

        // Move the file to the assets/upload directory
        $audioFile->move(public_path('storage/voice_notes'), $uniqueFileName);

        // Create a new voice note record in the database
        $voiceNote = new VoiceNotes();
        $voiceNote->start_date = $request->start_date;
        $voiceNote->end_date = $request->start_date; // Assuming end_date is the same as start_date
        $voiceNote->voice_note = 'voice_notes/' . $uniqueFileName; // Store the relative path in the database
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

            // Delete the file from storage
            Storage::disk('public')->delete($voiceNote->voice_note);

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
}
