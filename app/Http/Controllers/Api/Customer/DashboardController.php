<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use App\Models\DebtAndLiability;
use App\Models\DocumentLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
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
     * Display the customer dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $user = Auth::user();

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

            $progress = OnboardingProgress::where('user_id', $user->id)->first();

            $guide = [
                'Add at Least One Executor' => $progress->executor_added ?? false,
                'Add at Least One Bank Account' => $progress->bank_account_added ?? false,
                'Add at Least One Digital Asset' => $progress->digital_asset_added ?? false,
                'Add at Least One Property Owned' => $progress->property_added ?? false,
                'Upload at Least One Document' => $progress->document_uploaded ?? false,
            ];

            $documentLocations = DocumentLocation::where('created_by', $user->id)->get();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_executors' => $totalExecutors,
                    'total_documents' => $totalDocuments,
                    'total_bank_balance' => $totalBankBalance,
                    'total_debt' => $totalDebt,
                    'guide' => $guide,
                    'document_locations' => $documentLocations,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a new document location.
     */
    public function storeDocumentLocation(Request $request): JsonResponse
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $location = DocumentLocation::create([
                'created_by' => Auth::id(),
                'location' => $request->location,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Document location added successfully.',
                'data' => $location,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to add location. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a document location.
     */
    public function updateDocumentLocation(Request $request, $id): JsonResponse
    {
        $request->validate([
            'location' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $location = DocumentLocation::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $location->update([
                'location' => $request->location,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully.',
                'data' => $location,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to update location. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a document location.
     */
    public function deleteDocumentLocation($id): JsonResponse
    {
        DB::beginTransaction();

        try {
            $location = DocumentLocation::where('id', $id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $location->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete location. Please try again.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
