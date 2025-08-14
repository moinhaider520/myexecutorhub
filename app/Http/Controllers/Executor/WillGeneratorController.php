<?php

namespace App\Http\Controllers\Executor;

use App\Http\Controllers\Controller;
use App\Models\WillUserInfo;
use Auth;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
class WillGeneratorController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user_about_infos = WillUserInfo::where('user_id', $user->created_by)->get();
        return view('executor.will_generator.index', compact('user_about_infos'));
    }

    public function create_pdf($will_user_id)
    {
        $will_user = WillUserInfo::with('child')->find($will_user_id);

        $pdf = PDF::loadView('executor.will_generator.will_pdf', ['user_info' => $will_user]);
        return $pdf->download('invoice.pdf');
    }
}
