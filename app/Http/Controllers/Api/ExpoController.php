<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpoController extends Controller
{
    /**
     * Update the expo token for the specified user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateExpoToken(Request $request, $id)
    {
        $request->validate([
            'expo_token' => 'required|string',
        ]);

        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json(['success' => false, 'message' => 'User not found'], 404);
            }

            DB::beginTransaction();

            $user->update([
                'expo_token' => $request->expo_token,
            ]);

            DB::commit();

            return response()->json(['success' => true, 'message' => 'Expo token updated successfully.'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
