<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\CloudinaryUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use CloudinaryUpload;
    public function user_details()
    {
        return response()->json(['success' => true, 'data' => Auth::user()], 200);
    }

    public function update_profile(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'postal_code' => 'nullable|string',
                'contact_number' => 'nullable|string',
                'date_of_birth' => 'nullable|date|before:today',
            ]);

            DB::beginTransaction();

            $profile_update = Auth::user()->update([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
                'date_of_birth' => $request->date_of_birth,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'Updated Profile Detail' => Auth::user()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function picture_update(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png|max:2048',
            ]);

            $user = Auth::user();

            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                if ($user->profile_image_public_id) {
                    $this->deleteFromCloud($user->profile_image_public_id);
                }

                $imagePath = $this->uploadToCloud($request->file('photo'), 'executorhub/profile_images');
                $user->update([
                    'profile_image' => $imagePath['url'],
                    'profile_image_public_id' => $imagePath['public_id'],
                ]);
            }

            DB::commit();
            return response()->json(['status' => true, 'User Picture' => $user->profile_image]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_password(Request $request)
    {
        // Validation
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = User::find(Auth::id());

            if ($user && Hash::check($request->current_password, $user->password)) {
                DB::beginTransaction();

                $user->update([
                    'password' => Hash::make($request->new_password),
                ]);

                DB::commit();

                return response()->json(['status' => true, 'message' => 'Your password has been changed successfully']);
            } else {
                // If current password doesn't match
                return response()->json(['status' => false, 'error' => 'Your current password is invalid'], 400);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
