<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\IntellectualPropertiesTypes;
use App\Models\IntellectualProperty;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class IntellectualPropertyController extends Controller
{
    /**
     * Display the intellectual properties for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve intellectual property types and intellectual properties created by the authenticated user's creator
            $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', $id)->get();
            $intellectualProperties = IntellectualProperty::where('created_by', $id)->get();

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

     /**
     * Store a newly created intellectual property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'property_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            IntellectualProperty::create([
                'property_type' => $request->property_type,
                'description' => $request->description,
                'created_by' => $request->created_by,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Intellectual Property added successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified intellectual property in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'property_type' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            $intellectualProperty = IntellectualProperty::findOrFail($id);
            $intellectualProperty->update([
                'property_type' => $request->property_type,
                'description' => $request->description,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Intellectual Property updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified intellectual property from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $intellectualProperty = IntellectualProperty::findOrFail($id);
            $intellectualProperty->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Intellectual Property deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom intellectual property type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_intellectual_property_type' => 'required|string|max:255|unique:intellectual_properties_types,name'
        ]);

        IntellectualPropertiesTypes::create([
            'name' => $request->custom_intellectual_property_type,
            'created_by' => $request->created_by,
        ]);

        return response()->json(['success' => true], 200);
    }
}
