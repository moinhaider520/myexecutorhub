<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\Pension;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PensionController extends Controller
{
    /**
     * Get the list of pensions for the authenticated user.
     */
    public function view()
    {
        try {
            $user = Auth::user();
            $pensions = Pension::where('created_by', $user->created_by)->get();

            return response()->json([
                'success' => true,
                'data' => $pensions
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
