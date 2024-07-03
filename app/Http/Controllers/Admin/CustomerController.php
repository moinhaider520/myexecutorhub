<?php

namespace App\Http\Controllers\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customers = User::role('customer')->get();
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for editing the specified customer.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
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

            $customer = User::findOrFail($id);
            $customer->update([
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'postal_code' => $request->postal_code,
                'contact_number' => $request->contact_number,
            ]);

            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified customer from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $customer = User::findOrFail($id);
            $customer->delete();

            DB::commit();
            return redirect()->route('admin.customers.index')->with('success', 'Customer profile deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
