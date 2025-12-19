<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankType;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function view()
    {
        $contextUser = ContextHelper::user();
        $bankTypes = BankType::where('created_by', $contextUser->id)->get();
        $bankAccounts = BankAccount::where('created_by', $contextUser->id)->get();

        return view('executor.assets.bank_accounts', compact('bankAccounts', 'bankTypes'));
    }
}
