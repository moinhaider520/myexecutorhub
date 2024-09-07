<?php

namespace App\Http\Controllers\Api\Partner;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\OrgansDonation;
use Illuminate\Http\JsonResponse;

class OrgansDonationController extends Controller
{
    /**
     * Display a listing of the user's organ donations.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function view(): JsonResponse
    {
        try {
            $organDonations = OrgansDonation::where('created_by', Auth::id())->get();

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
                'created_by' => Auth::id(),
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
