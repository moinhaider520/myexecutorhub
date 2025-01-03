<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    use ImageUpload;

    public function user_details($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return response()->json(['success' => true, 'data' => $user], 200);
    }

    public function update_profile(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found'], 404);
            }

            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
            ]);

            DB::commit();
            return response()->json(['status' => true, 'Updated Profile Detail' => $user], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function picture_update(Request $request, $id)
    {
        try {
            $user = User::find($id);
    
            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found'], 404);
            }
    
            if ($request->hasFile('photo')) {
                $file_name = $this->imageUpload($request->photo);
            }
    
            DB::beginTransaction();
    
            $user->update([
                'profile_image' => $file_name ?? $user->profile_image,
            ]);
    
            DB::commit();
            return response()->json(['status' => true, 'User Picture' => $user->profile_image], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }   

    public function update_password(Request $request, $id)
    {
        // Validation
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['status' => false, 'message' => 'User not found'], 404);
            }

            // Check if the current password matches
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['status' => false, 'message' => 'Current password is incorrect'], 400);
            }

            DB::beginTransaction();
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Password updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
