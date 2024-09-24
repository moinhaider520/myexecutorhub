<?php

namespace App\Http\Controllers\Api\Customer;

use Illuminate\Support\Facades\Auth;
use App\Models\PersonalChattel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Traits\ImageUpload;
use App\Models\ChattelType;

class PersonalChattelController extends Controller
{
    use ImageUpload;

    /**
     * Display a list of personal chattels for the authenticated customer.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view()
    {
        try {
            $chattelTypes = ChattelType::where('created_by', Auth::id())->get();
            $personalChattels = PersonalChattel::where('created_by', Auth::id())->get();
            return response()->json(['success' => true, 'personalChattels' => $personalChattels, 'chattelTypes' => $chattelTypes], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Store a newly created personal chattel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Personal Chattel added successfully.'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update the specified personal chattel.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Personal Chattel updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified personal chattel.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
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
            return response()->json(['success' => true, 'message' => 'Personal Chattel deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Save a custom chattel type.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveCustomType(Request $request)
    {
        $request->validate([
            'custom_chattel_type' => 'required|string|max:255|unique:chattel_types,name'
        ]);

        try {
            ChattelType::create([
                'name' => $request->custom_chattel_type,
                'created_by' => Auth::id(),
            ]);

            return response()->json(['success' => true, 'message' => 'Custom chattel type added successfully.'], 201);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
