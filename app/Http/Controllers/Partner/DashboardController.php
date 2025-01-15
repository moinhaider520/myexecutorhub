<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingProgress;
use App\Models\Document;     
use App\Models\BankAccount;    
use App\Models\DebtAndLiability; 
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the Partner dashboard.
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
  
          $progress = OnboardingProgress::where('user_id', Auth::id())->first();

          $guide = [
              'Add at Least One Executor' => $progress->executor_added ?? false,
              'Add at Least One Bank Account' => $progress->bank_account_added ?? false,
              'Add at Least One Digital Asset' => $progress->digital_asset_added ?? false,
              'Add at Least One Property Owned' => $progress->property_added ?? false,
              'Upload at Least One Document' => $progress->document_uploaded ?? false,
              'Upload at Least One Picture' => $progress->picture_uploaded ?? false,
          ];

          return view('partner.dashboard', compact(
              'totalExecutors',
              'totalDocuments',
              'totalBankBalance',
              'totalDebt'
          ));
    }    
}
