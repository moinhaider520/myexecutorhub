<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PensionController extends Controller
{
    /**
     * Get the list of pensions for the authenticated user.
     */
    public function view()
    {
        try {
            $pensions = Pension::where('created_by', Auth::id())->get();
            return response()->json([
                'success' => true,
                'data' => $pensions
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created pension.
     */
    public function store(Request $request)
    {
        $request->validate([
            'pensions' => 'required|string|max:255',
            'pension_provider' => 'required|string|max:255',
            'pension_reference_number' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $pension = Pension::create([
                'pensions' => $request->pensions,
                'pension_provider' => $request->pension_provider,
                'pension_reference_number' => $request->pension_reference_number,
                'created_by' => Auth::id(),
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pension added successfully', 'data' => $pension], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Something went wrong, please try again.'], 500);
        }
    }

    /**
     * Update the specified pension.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'pensions' => 'required|string|max:255',
            'pension_provider' => 'required|string|max:255',
            'pension_reference_number' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $pension = Pension::findOrFail($id);
            $pension->update([
                'pensions' => $request->pensions,
                'pension_provider' => $request->pension_provider,
                'pension_reference_number' => $request->pension_reference_number,
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pension updated successfully', 'data' => $pension], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => 'Something went wrong, please try again.'], 500);
        }
    }

    /**
     * Delete a specific pension.
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pension = Pension::findOrFail($id);
            $pension->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Pension deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }
}
