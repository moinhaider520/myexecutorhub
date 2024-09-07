<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VoiceNotes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class VoiceNotesController extends Controller
{
    /**
     * Display the voice notes for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();
            
            // Retrieve voice notes created by the user
            $voiceNotes = VoiceNotes::where('created_by', $user->created_by)->get();
            
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
}
