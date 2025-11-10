<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\UserBankDetails;
use Auth;
use DB;
use Illuminate\Http\Request;

class WithdrawalBankAccountController extends Controller
{
    public function view()
    {
        try {
            $bankdetails = UserBankDetails::where('user_id', Auth::id())->get();
            return response()->json(['success' => true, 'bankAccounts' => $bankdetails], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

        public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'bank_name' => 'required|string|max:255',
                'sort_code' => 'required|string|max:255',
                'account_name' => 'required|string|max:255',
                'iban' => 'required|string|max:255',
            ]);

            DB::beginTransaction();

            $bank = UserBankDetails::create([
                'bank_name' => $validated['bank_name'],
                'sort_code' => $validated['sort_code'],
                'account_name' => $validated['account_name'],
                'iban' => $validated['iban'],
                'user_id' => Auth::id(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bank account added successfully.',
                'data' => $bank,
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ✅ Update Bank Account
    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'bank_name' => 'required|string|max:255',
                'sort_code' => 'required|string|max:255',
                'account_name' => 'required|string|max:255',
                'iban' => 'required|string|max:255',
            ]);

            DB::beginTransaction();

            $bank = UserBankDetails::findOrFail($id);

            $bank->update($validated);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bank account updated successfully.',
                'data' => $bank,
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    // ✅ Delete Bank Account
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $bank = UserBankDetails::findOrFail($id);
            $bank->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Bank account deleted successfully.',
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
