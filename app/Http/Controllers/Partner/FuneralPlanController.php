<?php

namespace App\Http\Controllers\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomDropDown;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use App\Models\FuneralPlan;

class FuneralPlanController extends Controller
{
    use ImageUpload;
    
    /**
     * Display a listing of the resource.
     */
    public function view()
    {
        $funeralPlanTypes = CustomDropDown::where('category', 'funeral_plan')->get();
        $funeralPlans = FuneralPlan::where('created_by', Auth::id())->get();
        return view('partner.funeral_plans.view', compact('funeralPlans', 'funeralPlanTypes'));
    }

    /**
     * Store a newly created resource in storage.
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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
                // Delete the file from the public/assets/upload directory if it exists
                if ($funeralPlan->file_path) {
                    $filePath = public_path('assets/upload/' . basename($funeralPlan->file_path));
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                $path = $this->imageUpload($request->file('file'), 'funeral_plans');
                $funeralPlan->file_path = $path;
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            
            $funeralPlan = FuneralPlan::findOrFail($id);
            
            // Delete the file from the public/assets/upload directory if it exists
            if ($funeralPlan->file_path) {
                $filePath = public_path('assets/upload/' . basename($funeralPlan->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete the funeral plan record
            $funeralPlan->delete();
            
            DB::commit();
            return redirect()->route('partner.funeral_plans.view')->with('success', 'Funeral plan deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
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

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}