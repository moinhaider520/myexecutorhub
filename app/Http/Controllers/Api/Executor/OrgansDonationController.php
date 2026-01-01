<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use DB;
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

    /**
     * Store a newly created organ donation in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'donation' => 'required',
        ]);

        try {
            DB::beginTransaction();

            OrgansDonation::create([
                'donation' => $request->donation,
                'organs_to_donate' => $request->organs_to_donate,
                'organs_to_not_donate' => $request->organs_to_not_donate,
                'created_by' => $request->created_by,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Organs Donation added successfully.'
            ], 201);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified organ donation in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'donation' => 'required'
        ]);

        try {
            DB::beginTransaction();

            $donation = OrgansDonation::findOrFail($id);
            $donation->update([
                'donation' => $request->donation,
                'organs_to_donate' => $request->organs_to_donate,
                'organs_to_not_donate' => $request->organs_to_not_donate,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Organs Donation updated successfully.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified organ donation from the database.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();

            $organDonation = OrgansDonation::findOrFail($id);
            $organDonation->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Organs Donation deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
