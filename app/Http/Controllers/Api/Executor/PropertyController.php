<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\OnboardingProgress;
use App\Models\PropertyType;
use App\Models\Property;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
class PropertyController extends Controller
{
    /**
     * Display the properties and property types for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve property types and properties created by the authenticated user's creator
            $propertyTypes = PropertyType::where('created_by', $id)->get();
            $properties = Property::where('created_by', $id)->get();

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

    /**
     * Store a newly created property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'owner_names' => 'required|string|max:255',
            'how_owned' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            Property::create([
                'property_type' => $request->property_type,
                'address' => $request->address,
                'owner_names' => $request->owner_names,
                'how_owned' => $request->how_owned,
                'value' => $request->value,
                'created_by' => $request->created_by,
            ]);

            // Check if onboarding_progress exists for the user
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['property_added' => true]
            );

            // If the record exists but property_added is false, update it
            if (!$progress->property_added) {
                $progress->property_added = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Property added successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified property.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_type' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'owner_names' => 'required|string|max:255',
            'how_owned' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $property = Property::findOrFail($id);
            $property->update([
                'property_type' => $request->property_type,
                'address' => $request->address,
                'owner_names' => $request->owner_names,
                'how_owned' => $request->how_owned,
                'value' => $request->value,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Property updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified property.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $property = Property::findOrFail($id);
            $property->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Property deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom property type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_property_type' => 'required|string|max:255|unique:property_types,name'
        ]);

        try {
            PropertyType::create([
                'name' => $request->custom_property_type,
                'created_by' => $request->created_by,
            ]);

            return response()->json(['success' => true, 'message' => 'Custom property type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
