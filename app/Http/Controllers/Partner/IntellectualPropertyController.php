<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntellectualProperty;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\IntellectualPropertiesTypes;

class IntellectualPropertyController extends Controller
{
    public function view()
    {
        $intellectualPropertyTypes = IntellectualPropertiesTypes::where('created_by', Auth::id())->get();
        $intellectualProperties = IntellectualProperty::where('created_by', Auth::id())->get();
        return view('partner.assets.intellectual_properties', compact('intellectualProperties', 'intellectualPropertyTypes'));
    }

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
            return response()->json(['success' => true, 'message' => 'Intellectual Property added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Intellectual Property updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $intellectualProperty = IntellectualProperty::findOrFail($id);
            $intellectualProperty->delete();
            DB::commit();
            return redirect()->route('partner.intellectual_properties.view')->with('success', 'Intellectual Property deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_intellectual_property_type' => 'required|string|max:255|unique:intellectual_properties_types,name'
        ]);

        IntellectualPropertiesTypes::create([
            'name' => $request->custom_intellectual_property_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
