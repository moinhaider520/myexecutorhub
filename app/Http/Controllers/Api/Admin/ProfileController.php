<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageUpload;
    public function user_details()
    {
        return response()->json(['success' => true, 'data' => Auth::user()], 200);
    }

    public function update_profile(Request $request)
    {
        try {
            DB::beginTransaction();

            $profile_update = Auth::user()->update([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
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
            if ($request->hasFile('photo')) {
                $file_name = $this->imageUpload($request->photo);
            }

            DB::beginTransaction();

            $profile_picture = Auth::user()->update([
                'profile_image' => $file_name ?? Auth::user()->profile_image,
            ]);

            DB::commit();
            return response()->json(['status' => true, 'User Picture' => Auth::user()->profile_image]);
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
