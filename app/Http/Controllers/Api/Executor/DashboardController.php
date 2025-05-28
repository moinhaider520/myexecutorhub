<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Document;
use App\Models\BankAccount;
use App\Models\DebtAndLiability;
use App\Models\DocumentLocation;
use App\Models\ExecutorTodoStage;
use App\Models\ExecutorTodoProgress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
            // Get the currently authenticated user
            $user = Auth::user();
            
            // Use the 'created_by' field to get the related data
            $createdById = $user->created_by;
            
            // Fetch totals specific to the user's 'created_by' ID
            $totalExecutors = User::role('executor')->where('created_by', $createdById)->count();
            $totalDocuments = Document::where('created_by', $createdById)->count();
            $totalBankBalance = BankAccount::where('created_by', $createdById)->sum('balance');
            $totalDebt = DebtAndLiability::where('created_by', $createdById)->sum('amount_outstanding');
            $documentLocations = DocumentLocation::where('created_by', $user->created_by)->get();

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
                        ->where('user_id', $user->id)
                        ->where('created_by', $user->created_by)
                        ->first();
                }
            }

            // Load user progress for each todo item (Advanced)
            foreach ($advancedTodoStages as $stage) {
                foreach ($stage->todoItems as $todoItem) {
                    $todoItem->currentUserProgress = ExecutorTodoProgress::where('todo_item_id', $todoItem->id)
                        ->where('user_id', $user->id)
                        ->where('created_by', $user->created_by)
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

            // Return the data as a JSON response
            return response()->json([
                'success' => true,
                'data' => [
                    'total_executors' => $totalExecutors,
                    'total_documents' => $totalDocuments,
                    'total_bank_balance' => $totalBankBalance,
                    'total_debt' => $totalDebt,
                    'document_locations' => $documentLocations,
                    'standard_todo_stages' => $standardTodoStages,
                    'advanced_todo_stages' => $advancedTodoStages,
                    'standard_total_items' => $standardTotalItems,
                    'standard_completed_items' => $standardCompletedItems,
                    'standard_completion_percentage' => $standardCompletionPercentage,
                    'advanced_total_items' => $advancedTotalItems,
                    'advanced_completed_items' => $advancedCompletedItems,
                    'advanced_completion_percentage' => $advancedCompletionPercentage,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            // Handle errors and return a response
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve dashboard data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update todo item status
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTodoStatus(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'todo_item_id' => 'required|exists:executor_todo_items,id',
                'status' => 'required|in:not_completed,completed,not_required',
                'notes' => 'nullable|string'
            ]);

            $user = Auth::user();

            ExecutorTodoProgress::updateOrCreate(
                [
                    'todo_item_id' => $request->todo_item_id,
                    'user_id' => $user->id,
                    'created_by' => $user->created_by,
                ],
                [
                    'status' => $request->status,
                    'notes' => $request->notes,
                    'completed_at' => $request->status === 'completed' ? now() : null,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Todo status updated successfully'
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update todo status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}