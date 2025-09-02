<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PartnerRelationship;
use App\Helpers\EncryptionHelper;
use Illuminate\Support\Facades\DB;

class GeneratePartnerController extends Controller
{
    /**
     * Display a listing of the partners.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // all sub partners (users) of the logged-in partner
        $partners = User::whereIn('id', function ($query) {
            $query->select('sub_partner_id')
                ->from('partner_relationships')
                ->where('parent_partner_id', auth()->id());
        })->get();

        return view('partner.partners.index', compact('partners'));
    }

    /**
     * Show the form for creating a new partner.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('partner.partners.create');
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
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email',
            'address'       => 'required',
            'city'          => 'required',
            'postal_code'   => 'required',
            'contact_number' => 'required',
            'access_type'   => 'required',
        ]);

        $couponCode = $request->name . strtoupper(uniqid());

        try {
            DB::beginTransaction();

            $partner = User::create([
                'name'              => $request->name,
                'email'             => $request->email,
                'address'           => $request->address,
                'city'              => $request->city,
                'postal_code'       => $request->postal_code,
                'phone_number'      => $request->contact_number,
                'access_type'       => $request->access_type,
                'profession'        => $request->profession,
                'coupon_code'       => $couponCode,
                'trial_ends_at'     => now()->addYears(10),
                'subscribed_package' => 'Premium',
                'password'          => bcrypt('1234'),
            ]);

            $partner->assignRole('partner');

            PartnerRelationship::create([
                'parent_partner_id' => auth()->id(),
                'sub_partner_id'    => $partner->id,
            ]);

            DB::commit();
            return redirect()->route('partner.partners.index')->with('success', 'Partner created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified partner.
     *
     * @param  string  $encryptedId
     * @return \Illuminate\View\View
     */
    public function edit($encryptedId)
    {
        $id = EncryptionHelper::decryptId($encryptedId);
        $partner = User::findOrFail($id);
        return view('partner.partners.edit', compact('partner'));
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
            'name'          => 'required',
            'email'         => 'required|email|unique:users,email,' . $id,
            'address'       => 'required',
            'city'          => 'required',
            'postal_code'   => 'required',
            'contact_number' => 'required',
            'access_type'   => 'required',
        ]);

        try {
            DB::beginTransaction();

            $partner = User::findOrFail($id);
            $partner->update([
                'name'         => $request->name,
                'email'        => $request->email,
                'address'      => $request->address,
                'city'         => $request->city,
                'postal_code'  => $request->postal_code,
                'phone_number' => $request->contact_number,
                'access_type'  => $request->access_type,
                'profession'   => $request->profession,
            ]);

            DB::commit();
            return redirect()->route('partner.partners.index')->with('success', 'Partner profile updated successfully.');
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
            return redirect()->route('partner.partners.index')->with('success', 'Partner profile deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
