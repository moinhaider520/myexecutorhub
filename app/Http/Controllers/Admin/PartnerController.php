<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\EncryptionHelper;
use Illuminate\Support\Facades\DB;

class PartnerController extends Controller
{
    /**
     * Display a listing of the partners.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $partners = User::role('partner')->get();
        return view('admin.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.partners.create');
    }

    /**
     * Store a newly created partner in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'contact_number' => 'required',
        ]);

        $couponCode = 'COUPON-' . strtoupper(uniqid());

        try {
            DB::beginTransaction();

            $partner = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone_number' => $request->contact_number,
                'coupon_code' => $couponCode, // Store the generated coupon code
                'trial_ends_at' => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'password' => bcrypt('1234'),
            ]);

            // Assign 'partner' role to the newly created user
            $partner->assignRole('partner');

            DB::commit();
            return redirect()->route('admin.partners.index')->with('success', 'Partner created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified partner.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        $id = EncryptionHelper::decryptId($encryptedId);
        $partner = User::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    /**
     * Update the specified partner in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required|numeric',
            'contact_number' => 'required',
        ]);

        try {
            DB::beginTransaction();

            $partner = User::findOrFail($id);
            $partner->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'phone_number' => $request->contact_number,
            ]);

            DB::commit();
            return redirect()->route('admin.partners.index')->with('success', 'Partner profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified partner from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $partner = User::findOrFail($id);
            $partner->delete();

            DB::commit();
            return redirect()->route('admin.partners.index')->with('success', 'Partner profile deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
