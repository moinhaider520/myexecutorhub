<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\FuneralWake;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class FuneralWakeController extends Controller
{
    public function view()
    {
        $funeralwakes = FuneralWake::where('created_by', Auth::id())->get();
        return view('customer.funeral_wake.funeral_wake', compact('funeralwakes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $funeral_wake = FuneralWake::create([
                'name' => $request->name,
                'description' => $request->description,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Record added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $funeral_wake = FuneralWake::findOrFail($id);
            $funeral_wake->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $funeral_wake = FuneralWake::findOrFail($id);
            $funeral_wake->delete();

            DB::commit();
            return redirect()->route('customer.funeral_wake.view')->with('success', 'Playlist deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
