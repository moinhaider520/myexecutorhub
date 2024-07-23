<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankType;
use App\Models\BankAccount;
use Illuminate\Support\Facades\Auth;

class BankAccountController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve bank types and bank accounts created by the authenticated user
        $bankTypes = BankType::where('created_by', $user->created_by)->get();
        $bankAccounts = BankAccount::where('created_by', $user->created_by)->get();
        
        return view('executor.assets.bank_accounts', compact('bankAccounts', 'bankTypes'));
    }
}
