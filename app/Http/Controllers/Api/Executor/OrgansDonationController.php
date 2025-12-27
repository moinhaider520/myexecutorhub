<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrgansDonation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class OrgansDonationController extends Controller
{
    /**
     * Display a listing of the organ donations for the authenticated executor.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view($id): JsonResponse
    {
        try {
            // Retrieve organ donations created by the authenticated executor
            $organDonations = OrgansDonation::where('created_by', $id)->get();

            return response()->json([
                'success' => true,
                'data' => $organDonations
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
