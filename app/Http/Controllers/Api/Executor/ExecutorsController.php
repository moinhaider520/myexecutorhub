<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ExecutorsController extends Controller
{
    public function view($id)
    {
        try {
            $user = User::findOrFail($id);

        $executors = $user->executors;
            return response()->json(['success' => true, 'executors' => $executors], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
