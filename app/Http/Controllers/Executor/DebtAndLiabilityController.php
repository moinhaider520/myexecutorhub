<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DebtAndLiabilitiesTypes;
use App\Models\DebtAndLiability;
use Illuminate\Support\Facades\Auth;

class DebtAndLiabilityController extends Controller
{
    public function view()
    {
        // Get the currently authenticated user
        $user = Auth::user();
        
        // Retrieve debt and liabilities types and debts/liabilities created by the authenticated user
        $debtAndLiabilitiesTypes = DebtAndLiabilitiesTypes::where('created_by', $user->created_by)->get();
        $debtsLiabilities = DebtAndLiability::where('created_by', $user->created_by)->get();
        
        return view('executor.assets.debt_and_liabilities', compact('debtsLiabilities', 'debtAndLiabilitiesTypes'));
    }
}
