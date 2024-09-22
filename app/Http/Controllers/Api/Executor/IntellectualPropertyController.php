<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\IntellectualPropertiesTypes;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class IntellectualPropertyController extends Controller
{
    /**
     * Display the intellectual properties for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve intellectual property types and intellectual properties created by the authenticated user's creator
            $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', $user->created_by)->get();
            $intellectualProperties = IntellectualProperty::where('created_by', $user->created_by)->get();

            // Return the intellectual properties data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'intellectual_properties' => $intellectualProperties,
                    'intellectual_property_types' => $intellectualPropertyTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve intellectual properties',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
