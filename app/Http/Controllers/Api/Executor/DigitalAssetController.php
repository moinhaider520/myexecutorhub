<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\DigitalAssetsTypes;
use App\Models\DigitalAsset;
use App\Models\OnboardingProgress;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
class DigitalAssetController extends Controller
{
    /**
     * Display the digital assets for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id): JsonResponse
    {
        try {
            // Get the currently authenticated user
            $user = Auth::user();

            // Retrieve digital asset types and digital assets created by the authenticated user's creator
            $digitalAssetsTypes = DigitalAssetsTypes::where('created_by', $id)->get();
            $digitalAssets = DigitalAsset::where('created_by', $id)->get();

            // Return the digital assets data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'digital_assets' => $digitalAssets,
                    'digital_assets_types' => $digitalAssetsTypes,
                ],
            ], 200);
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve digital assets',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created digital asset in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
       public function store(Request $request)
    {
        try {
            // ✅ Validate inputs
            $request->validate([
                'asset_type' => 'required|string|max:255',
                'asset_name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'email_used' => 'required|string|email|max:255',
                'value' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            // ✅ Return validation errors as JSON
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            DigitalAsset::create([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_name,
                'username' => $request->username,
                'password' => $request->password,
                'email_used' => $request->email_used,
                'value' => $request->value,
                'created_by' => $request->created_by,
            ]);

            // ✅ Handle onboarding progress
            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['digital_asset_added' => true]
            );

            if (!$progress->digital_asset_added) {
                $progress->digital_asset_added = true;
                $progress->save();
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Digital Asset added successfully.',
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to add Digital Asset: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update the specified digital asset in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'asset_type' => 'required|string|max:255',
                'asset_name' => 'required|string|max:255',
                'username' => 'required|string|max:255',
                'password' => 'required|string|max:255',
                'email_used' => 'required|string|email|max:255',
                'value' => 'required|numeric|min:0',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => $e->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $digitalAsset = DigitalAsset::findOrFail($id);

            $digitalAsset->update([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_name,
                'username' => $request->username,
                'password' => $request->password,
                'email_used' => $request->email_used,
                'value' => $request->value,
            ]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Digital Asset updated successfully.',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Digital Asset not found.',
            ], 404);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update Digital Asset: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified digital asset from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $digitalAsset = DigitalAsset::findOrFail($id);
            $digitalAsset->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Digital Asset deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom digital asset type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_digital_assets_type' => 'required|string|max:255|unique:digital_assets_types,name'
        ]);

        DigitalAssetsTypes::create([
            'name' => $request->custom_digital_assets_type,
            'created_by' => $request->created_by,
        ]);

        return response()->json(['success' => true, 'message' => 'Custom digital asset type saved successfully.'], 200);
    }
}
