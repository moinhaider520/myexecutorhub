<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class WithdrawalController extends Controller
{
    /**
     * Display all withdrawal requests.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $withdrawals = Withdrawal::orderByRaw('status = ? DESC', ['Pending'])
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'data' => $withdrawals
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve withdrawal requests',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the status of a withdrawal request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        try {
            DB::beginTransaction();

            // Find the withdrawal request
            $withdrawal = Withdrawal::findOrFail($id);

            // Update the status and approver ID
            $withdrawal->status = $request->input('status');
            $withdrawal->approved_by = Auth::id();
            $withdrawal->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Withdrawal status updated successfully',
                'data' => $withdrawal
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update withdrawal status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
