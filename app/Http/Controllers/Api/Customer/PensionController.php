<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PensionController extends Controller
{
    public function index()
    {
        $pensions = Pension::where('created_by', Auth::id())->get();
        return response()->json([
            'success' => true,
            'data' => $pensions
        ]);
    }

    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            $pension = Pension::create([
                'pensions' => $request->pensions,
                'pension_provider' => $request->pension_provider,
                'pension_reference_number' => $request->pension_reference_number,
                'created_by' => Auth::id(),
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pension added successfully.',
                'data' => $pension
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {

        DB::beginTransaction();
        try {
            $pension = Pension::findOrFail($id);

            // Ensure the user owns the pension
            if ($pension->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $pension->update([
                'pensions' => $request->pensions,
                'pension_provider' => $request->pension_provider,
                'pension_reference_number' => $request->pension_reference_number,
            ]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pension updated successfully.',
                'data' => $pension
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Update failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pension = Pension::findOrFail($id);

            // Ensure the user owns the pension
            if ($pension->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $pension->delete();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pension deleted successfully.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Delete failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
