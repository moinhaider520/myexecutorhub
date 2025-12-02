<?php

namespace App\Http\Controllers\Others;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\Document;
use App\Models\DocumentLocation;
use App\Models\DocumentReminder;
use App\Models\DocumentTypes;
use App\Models\OnboardingProgress;
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

        $documentLocations = DocumentLocation::where('created_by', $user->created_by)->get();



        // Get all document types (system defined + user custom types)
        $defaultTypes = [
            "Property deeds and titles",
            "Tax returns and tax documents",
            "Loan agreements",
            "Business contracts",
            "DEEDS",
            "Life insurance",
            "Mortgage",
            "Draft Document",
            "Will",
            "Foreign Wills",
            "Will register certificate",
            "Will commentary",
            "Glossary",
            "Will clarity statement",
            "Trust",
            "Lasting power of attorney property & finance",
            "Lasting power of attorney health & welfare",
            "Advanced directive property & finance",
            "Advance directive health & welfare",
            "Letter of exclusion",
            "Memorandum of wishes"
        ];

        $customTypes = DocumentTypes::where('created_by', $user->created_by)->pluck('name')->toArray();
        $allDocumentTypes = array_merge($defaultTypes, $customTypes);

        // Get uploaded document types for the user
        $uploadedDocumentTypes = Document::where('created_by', $user->created_by)
            ->pluck('document_type')
            ->unique()
            ->toArray();


        return view('others.dashboard', compact(
            'totalExecutors',
            'totalDocuments',
            'totalBankBalance',
            'totalDebt',
            'allDocumentTypes',
            'uploadedDocumentTypes',
            'documentLocations',
        ));
    }
}