<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Pension;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    /**
     * Get the list of pensions for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();
            $pensions = Pension::where('created_by', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $pensions
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

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
                'created_by' => $request->created_by,
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
