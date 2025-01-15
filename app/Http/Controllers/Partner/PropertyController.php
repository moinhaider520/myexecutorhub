<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\Property;
use App\Models\OnboardingProgress;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PropertyType;

class PropertyController extends Controller
{
    public function view()
    {
        $propertyTypes = PropertyType::where('created_by', Auth::id())->get();
        $properties = Property::where('created_by', Auth::id())->get();
        return view('partner.assets.properties', compact('properties', 'propertyTypes'));
    }

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
            return response()->json(['success' => true, 'message' => 'Property added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

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
            return response()->json(['success' => true, 'message' => 'Property updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $property = Property::findOrFail($id);
            $property->delete();

            DB::commit();
            return redirect()->route('partner.properties.view')->with('success', 'Property deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_property_type' => 'required|string|max:255|unique:property_types,name'
        ]);

        PropertyType::create([
            'name' => $request->custom_property_type,
            'created_by' => Auth::id(),
        ]);

        return response()->json(['success' => true]);
    }
}
