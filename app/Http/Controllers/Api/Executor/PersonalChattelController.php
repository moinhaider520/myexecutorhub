<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\ChattelType;
use App\Models\PersonalChattel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PersonalChattelController extends Controller
{
    /**
     * Display the personal chattels and chattel types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve chattel types and personal chattels created by the authenticated user's creator
            $chattelTypes = ChattelType::where('created_by', $id)->get();
            $personalChattels = PersonalChattel::where('created_by', $id)->get();

            // Return the personal chattels and chattel types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'personal_chattels' => $personalChattels,
                    'chattel_types' => $chattelTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve personal chattels and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
