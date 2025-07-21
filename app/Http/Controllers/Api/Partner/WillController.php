<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\LPAVideos;
use App\Models\WillVideos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;

class WillController extends Controller
{
    public function view()
    {
        try {
            $wills = WillVideos::where('customer_id', Auth::id())->get();

            return response()->json(['success' => true, 'wills' => $wills], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
