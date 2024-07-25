<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentTypes;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;

class InvestmentAccountController extends Controller
{
    public function index()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve investment types and investment accounts created by the authenticated user
        $investmentTypes = InvestmentTypes::where('created_by', $user->created_by)->get();
        $investmentAccounts = InvestmentAccount::where('created_by', $user->created_by)->get();
        
        return view('others.assets.investment_accounts', compact('investmentAccounts', 'investmentTypes'));
    }
}
