<?php

namespace App\Http\Controllers\Api\Executor;

use App\Http\Controllers\Controller;
use App\Models\WillUserInfo;
use Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class WillGeneratorController extends Controller
{
    public function partner_about_you($id)
    {
        try {
            $user = Auth::user();
            $will_user_infos = WillUserInfo::where('user_id', $id)->get();
            if ($will_user_infos) {
                return response()->json(['status' => true, 'data' => $will_user_infos]);
            } else {
                return response()->json(['status' => false, 'message' => 'No Will User Info found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function create_pdf($will_user_id)
    {
        $will_user = WillUserInfo::with('child')->find($will_user_id);

        $pdf = PDF::loadView('partner.will_generator.will_pdf', ['user_info' => $will_user]);
        return $pdf->stream('will_generated.pdf');
    }
}
