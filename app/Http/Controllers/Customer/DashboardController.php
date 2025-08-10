<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OnboardingProgress;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\DocumentReminder;
use App\Models\DocumentTypes;
use App\Models\DocumentLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $totalExecutors = User::role('executor')->where('created_by', $user->id)->count();
        $totalDocuments = Document::where('created_by', $user->id)->count();
        $bankbalance = BankAccount::where('created_by', $user->id)->sum('balance');
        $totalBusinessInterest = BusinessInterest::where('created_by', $user->id)->sum('share_value');
        $totalDigitalAssets = DigitalAsset::where('created_by', $user->id)->sum('value');
        $totalForeignAssets = ForeignAssets::where('created_by', $user->id)->sum('asset_value');
        $totalInvestmentAccounts = InvestmentAccount::where('created_by', $user->id)->sum('balance');
        $totalPersonalChattel = PersonalChattel::where('created_by', $user->id)->sum('value');
        $totalProperty = Property::where('created_by', $user->id)->sum('value');

        $totalBankBalance = $bankbalance + $totalBusinessInterest + $totalDigitalAssets + $totalForeignAssets + $totalInvestmentAccounts + $totalPersonalChattel + $totalProperty;
        $totalDebt = DebtAndLiability::where('created_by', $user->id)->sum('amount_outstanding');

        $progress = OnboardingProgress::where('user_id', Auth::id())->first();
        $documentLocations = DocumentLocation::where('created_by', $user->id)->get();

        $guide = [
            'Add at Least One Executor' => $progress->executor_added ?? false,
            'Add at Least One Bank Account' => $progress->bank_account_added ?? false,
            'Add at Least One Digital Asset' => $progress->digital_asset_added ?? false,
            'Add at Least One Property Owned' => $progress->property_added ?? false,
            'Upload at Least One Document' => $progress->document_uploaded ?? false,
            'Upload at Least One Picture' => $progress->picture_uploaded ?? false,
        ];

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

        $customTypes = DocumentTypes::where('created_by', $user->id)->pluck('name')->toArray();
        $allDocumentTypes = array_merge($defaultTypes, $customTypes);

        // Get uploaded document types for the user
        $uploadedDocumentTypes = Document::where('created_by', $user->id)
            ->pluck('document_type')
            ->unique()
            ->toArray();

        // Get reminders set by the user
        $documentReminders = DocumentReminder::where('user_id', $user->id)
            ->pluck('frequency', 'document_type')
            ->toArray();

        return view('customer.dashboard', compact(
            'totalExecutors',
            'totalDocuments',
            'totalBankBalance',
            'totalDebt',
            'guide',
            'allDocumentTypes',
            'uploadedDocumentTypes',
            'documentReminders',
            'documentLocations',
            'user'

        ));
    }

    /**
     * Update document reminder settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDocumentReminder(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'frequency' => 'required|in:weekly,fortnightly,monthly,quarterly,annually,not_required',
        ]);

        $user = Auth::user();

        DocumentReminder::updateOrCreate(
            [
                'user_id' => $user->id,
                'document_type' => $request->document_type,
            ],
            [
                'frequency' => $request->frequency,
                'last_reminded_at' => now(),
            ]
        );

        return response()->json(['success' => true]);
    }

    public function storeDocumentLocation(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            DocumentLocation::create([
                'created_by' => Auth::id(),
                'location' => $request->location,
            ]);

            DB::commit();
            return redirect()->route('customer.dashboard')->with('success', 'Document location added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to add location. Please try again.');
        }
    }


    public function updateLocation(Request $request, $id)
    {
        $request->validate(['location' => 'required|string|max:255']);

        DB::beginTransaction();

        try {
            $location = DocumentLocation::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $location->update(['location' => $request->location]);

            DB::commit();
            return redirect()->back()->with('success', 'Location updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update location. Please try again.');
        }
    }


    public function deleteLocation($id)
    {
        DB::beginTransaction();

        try {
            $location = DocumentLocation::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $location->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Location deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete location. Please try again.');
        }
    }
}
