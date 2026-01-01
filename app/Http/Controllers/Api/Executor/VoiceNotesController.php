<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class VoiceNotesController extends Controller
{
    /**
     * Display the voice notes for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();
            
            // Retrieve voice notes created by the user
            $voiceNotes = VoiceNotes::where('created_by', $id)->get();
            
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
            $voiceNote->created_by = $request->created_by;
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
