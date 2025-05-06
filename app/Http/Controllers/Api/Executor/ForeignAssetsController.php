<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\ForeignAssets;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ForeignAssetsController extends Controller
{
    /**
     * Get the list of foreign assets for the authenticated user.
     */
    public function view()
    {
        try {
            $user = Auth::user();
            $foreignAssets = ForeignAssets::where('created_by', $user->created_by)->get();

            return response()->json([
                'success' => true,
                'data' => $foreignAssets
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
