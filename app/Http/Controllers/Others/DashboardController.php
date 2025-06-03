<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\Document;
use App\Models\User;
use Auth;
use App\Models\BusinessInterest;
use App\Models\DigitalAsset;
use App\Models\ForeignAssets;
use App\Models\IntellectualProperty;
use App\Models\InvestmentAccount;
use App\Models\PersonalChattel;
use App\Models\Property;

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
        $bankbalance = BankAccount::where('created_by', $user->created_by)->sum('balance');
        $totalBusinessInterest = BusinessInterest::where('created_by', $user->created_by)->sum('share_value');
        $totalDigitalAssets = DigitalAsset::where('created_by', $user->created_by)->sum('value');
        $totalForeignAssets = ForeignAssets::where('created_by', $user->created_by)->sum('asset_value');
        $totalInvestmentAccounts = InvestmentAccount::where('created_by', $user->created_by)->sum('balance');
        $totalPersonalChattel = PersonalChattel::where('created_by', $user->created_by)->sum('value');
        $totalProperty = Property::where('created_by', $user->created_by)->sum('value');

        $totalBankBalance = $bankbalance + $totalBusinessInterest + $totalDigitalAssets + $totalForeignAssets + $totalInvestmentAccounts + $totalPersonalChattel + $totalProperty;
        $totalDebt = DebtAndLiability::where('created_by', $user->created_by)->sum('amount_outstanding');

        return view('others.dashboard', compact(
            'totalExecutors',
            'totalDocuments',
            'totalBankBalance',
            'totalDebt',
        ));
    }
}