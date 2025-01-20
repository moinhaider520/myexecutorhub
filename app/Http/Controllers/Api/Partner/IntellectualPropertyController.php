<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\IntellectualPropertiesTypes;

class IntellectualPropertyController extends Controller
{
    /**
     * Display a list of intellectual properties for the authenticated Partner.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', Auth::id())->get();
            $intellectualProperties = IntellectualProperty::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'intellectualProperties' => $intellectualProperties, 'intellectualPropertyTypes' => $intellectualPropertyTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
                'created_by' => Auth::id(),
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
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true], 200);
    }
}
