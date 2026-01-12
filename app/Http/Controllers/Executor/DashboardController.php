<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\Document;
use App\Models\User;
use App\Models\ExecutorTodoStage;
use App\Models\ExecutorTodoProgress;
use App\Models\DocumentLocation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        $customers=$user->customers;
        $actingCustomer = session('acting_customer_id')
        ? User::find(session('acting_customer_id'))
        : null;

        // IMPORTANT: use acting customer for data
        $contextUser = $actingCustomer ?? $user;
        // Fetch totals specific to the authenticated user
        $totalExecutors = $contextUser->executors->count();
        $totalDocuments = Document::where('created_by', $contextUser->id)->count();

        $bankbalance = BankAccount::where('created_by', $contextUser->id)->sum('balance');
        $totalBusinessInterest = BusinessInterest::where('created_by', $contextUser->id)->sum('share_value');
        $totalDigitalAssets = DigitalAsset::where('created_by', $contextUser->id)->sum('value');
        $totalForeignAssets = ForeignAssets::where('created_by', $contextUser->id)->sum('asset_value');
        $totalInvestmentAccounts = InvestmentAccount::where('created_by', $contextUser->id)->sum('balance');
        $totalPersonalChattel = PersonalChattel::where('created_by', $contextUser->id)->sum('value');
        $totalProperty = Property::where('created_by', $contextUser->id)->sum('value');

        $totalBankBalance = $bankbalance + $totalBusinessInterest + $totalDigitalAssets + $totalForeignAssets + $totalInvestmentAccounts + $totalPersonalChattel + $totalProperty;
        $totalDebt = DebtAndLiability::where('created_by', $contextUser->id)->sum('amount_outstanding');
        $documentLocations = DocumentLocation::where('created_by', $contextUser->id)->get();


        // Fetch executor todo stages with items (both standard and advanced)
        $standardTodoStages = ExecutorTodoStage::with(['todoItems'])
            ->where('type', 'standard')
            ->orderBy('order')
            ->get();

        $advancedTodoStages = ExecutorTodoStage::with(['todoItems'])
            ->where('type', 'advanced')
            ->orderBy('order')
            ->get();

        // Load user progress for each todo item (Standard)
        foreach ($standardTodoStages as $stage) {
            foreach ($stage->todoItems as $todoItem) {
                $todoItem->currentUserProgress = ExecutorTodoProgress::where('todo_item_id', $todoItem->id)
                    ->where('user_id', $contextUser->id)
                    ->where('created_by', $contextUser->id)
                    ->first();
            }
        }

        // Load user progress for each todo item (Advanced)
        foreach ($advancedTodoStages as $stage) {
            foreach ($stage->todoItems as $todoItem) {
                $todoItem->currentUserProgress = ExecutorTodoProgress::where('todo_item_id', $todoItem->id)
                    ->where('user_id', $contextUser->id)
                    ->where('created_by', $contextUser->id)
                    ->first();
            }
        }

        // Calculate todo statistics for both lists
        $standardTotalItems = $standardTodoStages->sum(function ($stage) {
            return $stage->todoItems->count();
        });

        $standardCompletedItems = $standardTodoStages->sum(function ($stage) {
            return $stage->todoItems->sum(function ($item) {
                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
            });
        });

        $advancedTotalItems = $advancedTodoStages->sum(function ($stage) {
            return $stage->todoItems->count();
        });

        $advancedCompletedItems = $advancedTodoStages->sum(function ($stage) {
            return $stage->todoItems->sum(function ($item) {
                return $item->currentUserProgress && $item->currentUserProgress->status === 'completed' ? 1 : 0;
            });
        });

        $standardCompletionPercentage = $standardTotalItems > 0 ? round(($standardCompletedItems / $standardTotalItems) * 100) : 0;
        $advancedCompletionPercentage = $advancedTotalItems > 0 ? round(($advancedCompletedItems / $advancedTotalItems) * 100) : 0;

        return view('executor.dashboard', compact(
            'totalExecutors',
            'totalDocuments',
            'totalBankBalance',
            'totalDebt',
            'standardTodoStages',
            'advancedTodoStages',
            'standardTotalItems',
            'standardCompletedItems',
            'standardCompletionPercentage',
            'advancedTotalItems',
            'advancedCompletedItems',
            'advancedCompletionPercentage',
            'documentLocations',
            'customers',
            'actingCustomer',
        ));
    }

    /**
     * Update todo item status
     */
    public function updateTodoStatus(Request $request)
    {
        $request->validate([
            'todo_item_id' => 'required|exists:executor_todo_items,id',
            'status' => 'required|in:not_completed,completed,not_required',
            'notes' => 'nullable|string'
        ]);

        $user = Auth::user();
        $contextUser = ContextHelper::user();

        ExecutorTodoProgress::updateOrCreate(
            [
                'todo_item_id' => $request->todo_item_id,
                'user_id' => $contextUser->id,
                'created_by' => $contextUser->id,
            ],
            [
                'status' => $request->status,
                'notes' => $request->notes,
                'completed_at' => $request->status === 'completed' ? now() : null,
            ]
        );

        return response()->json(['success' => true]);
    }
}
