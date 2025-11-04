<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\UserBankDetails;
use Auth;
use DB;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    public function index()
    {
        $bankdetails = UserBankDetails::where('user_id', Auth::id())->get();
        return view('partner.bank_details.index', compact('bankdetails'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:255',
            'sort_code' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            UserBankDetails::create([
                'bank_name' => $request->bank_name,
                'account_name' => $request->account_name,
                'sort_code' => $request->sort_code,
                'iban' => $request->iban,
                'user_id' => Auth::id()
            ]);
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account added successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bank_name' => 'required|string',
            'sort_code' => 'required|string|max:255',
            'iban' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $bankAccount = UserBankDetails::findOrFail($id);

            $bankAccount->bank_name = $request->bank_name;
            $bankAccount->account_name = $request->account_name;
            $bankAccount->sort_code = $request->sort_code;
            $bankAccount->iban = $request->iban;
            $bankAccount->user_id = Auth::id();

            $bankAccount->save();

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Bank account updated successfully.']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bankAccount = UserBankDetails::findOrFail($id);
            $bankAccount->delete();

            DB::commit();
            return redirect()->route('partner.bank_account.index')->with('success', 'Bank account deleted successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
