<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyType;

class PropertyController extends Controller
{
    /**
     * Display a list of properties for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $propertyTypes = PropertyType::where('created_by', Auth::id())->get();
            $properties = Property::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'properties' => $properties, 'propertyTypes' => $propertyTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
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
                'created_by' => Auth::id(),
            ]);

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
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom property type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
