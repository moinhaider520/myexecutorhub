<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\User;

class WithdrawalController extends Controller
{
    /**
     * Display all withdrawal requests.
     */
    public function index()
    {
        $withdrawals = Withdrawal::orderByRaw('status = ? DESC', ['Pending'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.withdraw.index', compact('withdrawals'));
    }

    /**
     * Update the status of a withdrawal request.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        // Find the withdrawal request
        $withdrawal = Withdrawal::findOrFail($id);

        // Update the status
        $withdrawal->status = $request->input('status');
        $withdrawal->approved_by = auth()->id();

        $withdrawal->save();

        return redirect()->route('admin.withdraw.index')->with('success', 'Withdrawal status updated successfully.');
    }
}
