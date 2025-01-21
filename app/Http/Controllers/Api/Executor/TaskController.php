<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Get a list of tasks based on the `created_by` field of the authenticated user's creator.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            $tasks = Task::where('created_by', $user->created_by)->get();

            return response()->json([
                'success' => true,
                'tasks' => $tasks,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve tasks.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
