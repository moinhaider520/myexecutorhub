<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\Document;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the customer dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Fetch totals specific to the authenticated user
        $totalExecutors = User::role('executor')->where('created_by', $user->created_by)->count();
        $totalDocuments = Document::where('created_by', $user->created_by)->count();
        $totalBankBalance = BankAccount::where('created_by', $user->created_by)->sum('balance');
        $totalDebt = DebtAndLiability::where('created_by', $user->created_by)->sum('amount_outstanding');

        return view('others.dashboard', compact(
            'totalExecutors',
            'totalDocuments',
            'totalBankBalance',
            'totalDebt',
        ));
    }
}