<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\CouponUsage;
use App\Models\User;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\OnboardingProgress;
use App\Models\DebtAndLiability;
use App\Models\DocumentLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * Display the partner dashboard data.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();

            $totalExecutors = User::role('executor')->where('created_by', $user->id)->count();
            $totalDocuments = Document::where('created_by', $user->id)->count();
            $totalBankBalance = BankAccount::where('created_by', $user->id)->sum('balance');
            $totalDebt = DebtAndLiability::where('created_by', $user->id)->sum('amount_outstanding');

            $progress = OnboardingProgress::where('user_id', $user->id)->first();
            $referredUsers = CouponUsage::with('user')->where('partner_id', $user->id)->latest()->get();
            $documentLocations = DocumentLocation::where('created_by', $user->id)->get();

            $guide = [
                'Add at Least One Executor' => $progress->executor_added ?? false,
                'Add at Least One Bank Account' => $progress->bank_account_added ?? false,
                'Add at Least One Digital Asset' => $progress->digital_asset_added ?? false,
                'Add at Least One Property Owned' => $progress->property_added ?? false,
                'Upload at Least One Document' => $progress->document_uploaded ?? false,
            ];

            return response()->json([
                'success' => true,
                'data' => [
                    'total_executors' => $totalExecutors,
                    'total_documents' => $totalDocuments,
                    'total_bank_balance' => $totalBankBalance,
                    'total_debt' => $totalDebt,
                    'guide' => $guide,
                    'referredUsers' => $referredUsers,
                    'document_locations' => $documentLocations
                ]
            ], 200);
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

        try {
            $location = DocumentLocation::create([
                'created_by' => Auth::id(),
                'location' => $request->location,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Document location added successfully.',
                'location' => $location,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add document location.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update a document location.
     */
    public function updateLocation(Request $request, $id): JsonResponse
    {
        $request->validate(['location' => 'required|string|max:255']);

        try {
            $location = DocumentLocation::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $location->update(['location' => $request->location]);

            return response()->json([
                'success' => true,
                'message' => 'Location updated successfully.',
                'location' => $location,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update location.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a document location.
     */
    public function deleteLocation($id): JsonResponse
    {
        try {
            $location = DocumentLocation::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $location->delete();

            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully.',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete location.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
