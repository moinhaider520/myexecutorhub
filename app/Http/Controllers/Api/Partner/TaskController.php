<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    /**
     * Get a list of tasks created by the authenticated user.
     */
    public function index()
    {
        $tasks = Task::where('created_by', Auth::id())->get();
        return response()->json(['success' => true, 'tasks' => $tasks], 200);
    }

    /**
     * Store a new task for the authenticated user.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'nullable|date_format:H:i',
            ]);

            $task = Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Task added successfully.', 'task' => $task], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to add task.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Update an existing task for the authenticated user.
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $task = Task::where('id', $id)->where('created_by', Auth::id())->firstOrFail();

            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
                'time' => 'nullable|date_format:H:i',
            ]);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Task updated successfully.', 'task' => $task], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update task.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a task for the authenticated user.
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $task = Task::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $task->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Task deleted successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to delete task.', 'error' => $e->getMessage()], 500);
        }
    }
}
