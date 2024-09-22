<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\PropertyType;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class PropertyController extends Controller
{
    /**
     * Display the properties and property types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve property types and properties created by the authenticated user's creator
            $propertyTypes = PropertyType::where('created_by', $user->created_by)->get();
            $properties = Property::where('created_by', $user->created_by)->get();

            // Return the properties and property types as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'properties' => $properties,
                    'property_types' => $propertyTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve properties and types',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
