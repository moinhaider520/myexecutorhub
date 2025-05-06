<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\OnboardingProgress;
use App\Models\Picture;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PictureController extends Controller
{
    use ImageUpload;

    public function index()
    {
        try {
            $pictures = Picture::where('created_by', Auth::id())->get();

            return response()->json([
                'success' => true,
                'data' => $pictures
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pictures.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'file' => 'required|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        DB::beginTransaction();
        try {
            $path = $this->imageUpload($request->file('file'), 'pictures');

            Picture::create([
                'name' => $request->name,
                'description' => $request->description,
                'file_path' => $path,
                'created_by' => Auth::id()
            ]);

            $progress = OnboardingProgress::firstOrCreate(
                ['user_id' => Auth::id()],
                ['picture_uploaded' => true]
            );

            if (!$progress->picture_uploaded) {
                $progress->picture_uploaded = true;
                $progress->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture added successfully.']);
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
            'file' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:51200',
        ]);

        DB::beginTransaction();
        try {
            $picture = Picture::findOrFail($id);

            // Optional: Check if this picture belongs to the current user
            if ($picture->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $picture->name = $request->name;
            $picture->description = $request->description;

            if ($request->hasFile('file')) {
                $filePath = public_path('assets/upload/' . basename($picture->file_path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }

                $path = $this->imageUpload($request->file('file'), 'pictures');
                $picture->file_path = $path;
            }

            $picture->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $picture = Picture::findOrFail($id);

            // Optional: Check ownership
            if ($picture->created_by !== Auth::id()) {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }

            $filePath = public_path('assets/upload/' . basename($picture->file_path));
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $picture->delete();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Picture deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
