<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\WillVideos;
use Auth;
use Illuminate\Http\Request;

class WillController extends Controller
{
    public function view()
    {
        try {
            $user = Auth::user();
            $wills = WillVideos::where('customer_id', $user->created_by)->get();

            return response()->json(['success' => true, 'wills' => $wills], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
