<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\CustomDropDown;
use App\Models\FuneralPlan;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Traits\ImageUpload;
class FuneralPlanController extends Controller
{
    use ImageUpload;
    /**
     * Get the list of funeral plans for the authenticated user.
     */
    public function view($id)
    {
        try {
            $user = Auth::user();
            $funeralPlans = FuneralPlan::where('created_by', $id)->get();
            $type = CustomDropDown::where('category', 'funeral_plan')->where('created_by', $id)->get();
            return response()->json([
                'success' => true,
                'data' => $funeralPlans,
                'funeral_plan_types' => $type
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'funeral_plan' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png',
        ]);

        try {
            DB::beginTransaction();

            $path = null;
            if ($request->hasFile('file')) {
                $path = $this->imageUpload($request->file('file'), 'funeral_plans');
            }

            FuneralPlan::create([
                'funeral_plan' => $request->funeral_plan,
                'file_path' => $path,
                'created_by' => $request->created_by
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
            'custom_funeral_plan' => 'required'
        ]);

        try {
            CustomDropDown::create([
                'name' => $request->custom_funeral_plan,
                'category' => 'funeral_plan',
                'created_by' => $request->created_by,
            ]);

            return response()->json(['success' => true, 'message' => 'Custom funeral plan type added.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
