<?php

namespace App\Http\Controllers\Executor;

use App\Helpers\ContextHelper;
use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index() // Rename this from view to index
    {
       $authUser = auth()->user();
        $contextUser = ContextHelper::user();
        $userIds = collect([$authUser->id, $contextUser->id])
            ->unique()
            ->values();
        $tasks = Task::whereIn('created_by', $userIds)->get();
        return view('executor.tasks.index', compact('tasks'));

    }

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

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
                'time' => $request->time,
                'created_by' => Auth::id(),
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Task added successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to add task. Error: ' . $e->getMessage()]);
        }
    }

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

            return response()->json(['success' => true, 'message' => 'Task updated successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update task. Error: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $task = Task::where('id', $id)->where('created_by', Auth::id())->firstOrFail();
            $task->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Task deleted successfully.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to delete task. Error: ' . $e->getMessage()]);
        }
    }
}
