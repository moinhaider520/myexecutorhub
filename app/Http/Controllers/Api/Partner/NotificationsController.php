<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function view()
    {
        try {
            $partner = Auth::user();
            $notifications = $partner->notifications()->whereNull('read_at')->get();
            return response()->json([
                'success' => true,
                'data' => $notifications
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
