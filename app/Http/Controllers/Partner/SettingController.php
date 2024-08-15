<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Traits\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    use ImageUpload;

    /**
     * Show the form for editing the Partner profile.
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('partner.account_settings.edit_profile', compact('user'));
    }

    /**
     * Update the Partner profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'contact_number' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
            ]);

            DB::commit();
            return redirect()->route('partner.dashboard')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();

            if ($request->hasFile('profile_image')) {
                $imagePath = $this->imageUpload($request->file('profile_image'));
                $user->update(['profile_image' => $imagePath]);
            }

            DB::commit();
            return redirect()->route('partner.dashboard')->with('success', 'Profile image updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the Partner profile image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $user->save();

            DB::commit();
            return redirect()->route('admin.dashboard')->with('success', 'Password updated successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
