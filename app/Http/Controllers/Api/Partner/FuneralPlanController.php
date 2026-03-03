<?php

namespace App\Http\Controllers\Api\Partner;

use Illuminate\Support\Facades\Auth;
use App\Models\CustomDropDown;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\CloudinaryUpload;
use App\Models\FuneralPlan;

class FuneralPlanController extends Controller
{
    use CloudinaryUpload;

    /**
     * Get funeral plans and their types.
     */
    public function view()
    {
        try {
            $funeralPlanTypes = CustomDropDown::where('category', 'funeral_plan')->get();
            $funeralPlans = FuneralPlan::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'funeral_plans' => $funeralPlans,
                    'funeral_plan_types' => $funeralPlanTypes
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a new funeral plan.
     */
    public function store(Request $request)
    {
        $request->validate([
            'funeral_plan' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $path = null;
            $publicId = null;
            if ($request->hasFile('file')) {
                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/funeral_plans');
                $path = $upload['url'];
                $publicId = $upload['public_id'];
            }

            $plan = FuneralPlan::create([
                'funeral_plan' => $request->funeral_plan,
                'file_path' => $path,
                'file_public_id' => $publicId,
                'created_by' => Auth::id()
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan added successfully.', 'data' => $plan], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing funeral plan.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'funeral_plan' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:51200',
        ]);

        try {
            DB::beginTransaction();

            $funeralPlan = FuneralPlan::findOrFail($id);
            $funeralPlan->funeral_plan = $request->funeral_plan;

            if ($request->hasFile('file')) {
                $this->deleteStoredFile($funeralPlan->file_path, $funeralPlan->file_public_id);
                $upload = $this->uploadFileToCloud($request->file('file'), 'executorhub/funeral_plans');
                $funeralPlan->file_path = $upload['url'];
                $funeralPlan->file_public_id = $upload['public_id'];
            }

            $funeralPlan->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan updated successfully.', 'data' => $funeralPlan], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a funeral plan.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $funeralPlan = FuneralPlan::findOrFail($id);

            $this->deleteStoredFile($funeralPlan->file_path, $funeralPlan->file_public_id);

            $funeralPlan->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Funeral plan deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom funeral plan type.
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

            return response()->json(['success' => true, 'message' => 'Custom funeral plan type saved.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function deleteStoredFile(?string $path, ?string $publicId): void
    {
        if (!empty($publicId)) {
            $this->deleteFromCloud($publicId);
            return;
        }

        if (empty($path) || filter_var($path, FILTER_VALIDATE_URL)) {
            return;
        }

        $filePath = public_path('assets/upload/' . basename($path));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
