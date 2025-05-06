<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\FuneralPlan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FuneralPlanController extends Controller
{
    /**
     * Get the list of funeral plans for the authenticated user.
     */
    public function view()
    {
        try {
            $user = Auth::user();
            $funeralPlans = FuneralPlan::where('created_by', $user->created_by)->get();

            return response()->json([
                'success' => true,
                'data' => $funeralPlans
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong, please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
