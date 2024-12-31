<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\LPAVideos;
use Auth;
use Illuminate\Http\Request;

class LPAController extends Controller
{
    public function view()
    {
        try {
            $lpas = LPAVideos::where('customer_id', Auth::id())->get();

            return response()->json(['success' => true, 'lpas' => $lpas], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
