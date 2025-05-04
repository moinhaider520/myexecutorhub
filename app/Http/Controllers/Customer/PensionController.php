<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PensionController extends Controller
{
    public function view()
    {
        $pensions = Pension::where('created_by', Auth::id())->get();
        return view('customer.pensions.view', compact('pensions'));
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
            Pension::create([
                'pensions' => $request->pensions,
                'pension_provider' => $request->pension_provider,
                'pension_reference_number' => $request->pension_reference_number,
                'created_by' => Auth::id(),
            ]);
            DB::commit();
            return response()->json(['message' => 'Pension added successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong, please try again.'], 500);
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
            return response()->json(['message' => 'Pension updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Something went wrong, please try again.'], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $pension = Pension::findOrFail($id);
            $pension->delete();
            DB::commit();
            return redirect()->route('customer.pensions.view')->with('success', 'Pension deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
