<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\FuneralWake;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class FuneralWakeController extends Controller
{
    /**
     * Display a listing of funeral wakes for the executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            $user = Auth::user();
            $funeralwakes = FuneralWake::where('created_by', $user->created_by)->get();
            
            return response()->json([
                'success' => true, 
                'funeral_wakes' => $funeralwakes
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ], 500);
        }
    }
}