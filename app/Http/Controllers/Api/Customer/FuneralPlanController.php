<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FuneralPlan;
use App\Models\CustomDropDown;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class FuneralPlanController extends Controller
{
    use ImageUpload;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $funeralPlanTypes = CustomDropDown::where('category', 'funeral_plan')
                ->where('created_by', Auth::id())
                ->get();

            $funeralPlans = FuneralPlan::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'funeral_plans' => $funeralPlans,
                'funeral_plan_types' => $funeralPlanTypes,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $path = null;
            if ($request->hasFile('file')) {
                $path = $this->imageUpload($request->file('file'), 'funeral_plans');
            }

            FuneralPlan::create([
                'funeral_plan' => $request->funeral_plan,
                'file_path' => $path,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'funeral_plan' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        try {
            DB::beginTransaction();

            $funeralPlan = FuneralPlan::findOrFail($id);
            $funeralPlan->funeral_plan = $request->funeral_plan;

            if ($request->hasFile('file')) {
                if ($funeralPlan->file_path) {
                    $filePath = public_path('assets/upload/' . basename($funeralPlan->file_path));
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $funeralPlan->file_path = $this->imageUpload($request->file('file'), 'funeral_plans');
            }

            $funeralPlan->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $funeralPlan = FuneralPlan::findOrFail($id);

            if ($funeralPlan->file_path) {
                $filePath = public_path('assets/upload/' . basename($funeralPlan->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $funeralPlan->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save custom funeral plan type
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_funeral_plan' => 'required|string|max:255|unique:custom_drop_downs,name,NULL,id,category,funeral_plan'
        ]);

        try {
            CustomDropDown::create([
                'name' => $request->custom_funeral_plan,
                'category' => 'funeral_plan',
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom funeral plan type added.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
