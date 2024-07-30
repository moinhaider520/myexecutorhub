<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;     
use App\Models\BankAccount;    
use App\Models\DebtAndLiability; 
use Illuminate\Support\Facades\Auth;

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
          $totalExecutors = User::role('executor')->where('created_by', $user->id)->count();
          $totalDocuments = Document::where('created_by', $user->id)->count();
          $totalBankBalance = BankAccount::where('created_by', $user->id)->sum('balance');
          $totalDebt = DebtAndLiability::where('created_by', $user->id)->sum('amount_outstanding');
  
          return view('customer.dashboard', compact(
              'totalExecutors',
              'totalDocuments',
              'totalBankBalance',
              'totalDebt'
          ));

    }
}
