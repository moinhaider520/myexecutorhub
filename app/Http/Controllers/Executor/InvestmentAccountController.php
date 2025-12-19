<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvestmentTypes;
use App\Models\InvestmentAccount;
use Illuminate\Support\Facades\Auth;

class InvestmentAccountController extends Controller
{
    public function index()
    {
        $contextUser = ContextHelper::user();
        $investmentTypes = InvestmentTypes::where('created_by', $contextUser->id)->get();
        $investmentAccounts = InvestmentAccount::where('created_by', $contextUser->id)->get();

        return view('executor.assets.investment_accounts', compact('investmentAccounts', 'investmentTypes'));
    }
}
