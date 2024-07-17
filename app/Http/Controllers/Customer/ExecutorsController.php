<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ExecutorsController extends Controller
{
    public function view()
    {
        $executors = User::role('executor')->where('created_by', Auth::id())->get();
        return view('customer.executors.executors', compact('executors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'relationship' => 'required|string',
            'status' => 'required|string',
            'password' => 'required|confirmed',
        ]);

        try {
            DB::beginTransaction();

            $executor = User::create([
                'title' => $request->title,
                'name' => $request->name,
                'lastname' => $request->lastname,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'password' => Hash::make($request->password),
                'created_by' => Auth::id(),
            ]);

            $executor->assignRole('executor');

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Executor added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'relationship' => 'required|string',
            'status' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->update([
                'title' => $request->title,                
                'name' => $request->name,
                'lastname' => $request->lastname,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
                'relationship' => $request->relationship,
                'status' => $request->status,
                'password' => $request->filled('password') ? Hash::make($request->password) : $executor->password,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Executor updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $executor = User::findOrFail($id);
            $executor->delete();

            DB::commit();
            return redirect()->route('customer.executor.view')->with('success', 'Executor deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
