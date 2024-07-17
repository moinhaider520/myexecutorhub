<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\PersonalChattel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;

class PersonalChattelController extends Controller
{
    use ImageUpload;

    public function view()
    {
        $personalChattels = PersonalChattel::where('created_by', Auth::id())->get();
        return view('customer.assets.personal_chattels', compact('personalChattels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'chattel_type' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'value' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $photoPaths = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $photoPaths[] = $this->imageUpload($photo, 'personal_chattels');
                }
            }

            PersonalChattel::create([
                'chattel_type' => $request->chattel_type,
                'description' => $request->description,
                'photos' => json_encode($photoPaths),
                'value' => $request->value,
                'created_by' => Auth::id(),
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Personal Chattel added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'chattel_type' => 'required|string|max:255',
            'description' => 'required|string',
            'photos' => 'nullable|array',
            'photos.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'value' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $personalChattel = PersonalChattel::findOrFail($id);
            $photoPaths = json_decode($personalChattel->photos, true) ?? [];

            if ($request->hasFile('photos')) {
                // Delete old photos
                foreach ($photoPaths as $path) {
                    $filePath = public_path('assets/upload/' . basename($path));
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }

                foreach ($request->file('photos') as $photo) {
                    $photoPaths[] = $this->imageUpload($photo, 'personal_chattels');
                }
            }

            $personalChattel->update([
                'chattel_type' => $request->chattel_type,
                'description' => $request->description,
                'photos' => json_encode($photoPaths),
                'value' => $request->value,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Personal Chattel updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $personalChattel = PersonalChattel::findOrFail($id);
            $photoPaths = json_decode($personalChattel->photos, true) ?? [];

            // Delete photos from the public/assets/upload directory
            foreach ($photoPaths as $path) {
                $filePath = public_path('assets/upload/' . basename($path));
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            // Delete the personal chattel record
            $personalChattel->delete();
            DB::commit();
            return redirect()->route('customer.personal_chattels.view')->with('success', 'Chattel deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
