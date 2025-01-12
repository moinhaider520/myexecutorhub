<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('created_by', Auth::id())->get();
        return view('customer.tasks.index', compact('tasks'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction(); 

        try {
            $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'date' => 'required|date',
            ]);

            Task::create([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
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
            ]);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'date' => $request->date,
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