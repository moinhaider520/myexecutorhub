<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Will_User_Info;
use App\Models\WillUserChildren;
use App\Models\WillUserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WillGeneratorController extends Controller
{
    public function index()
    {
        // $wills = WillVideos::where('customer_id', Auth::id())->get();
        return view('partner.will_generator.index');
    }

    public function create()
    {
        $authId = auth()->id();
        return view('partner.will_generator.create', ['authId' => $authId]);
    }
    public function step4()
    {
        $authId = auth()->id();
        return view('partner.will_generator.step4', ['authId' => $authId]);
    }
    public function step5()
    {
        $authId = auth()->id();
        return view('partner.will_generator.step5', ['authId' => $authId]);
    }

    public function about_you()
    {
        $authId = auth()->id();
        return view('partner.will_generator.about_you', ['authId' => $authId]);
    }

    public function store_about_you(Request $request)
    {
        try{

            DB::beginTransaction();
            $will_user_id=WillUserInfo::create([
                'legal_name'=>$request->legal_name,
                'user_name'=>$request->user_name,
                'date_of_birth'=>$request->date_of_birth,
                'address_line_1'=>$request->address_line_1,
                'address_line_2'=>$request->address_line_2,
                'city'=>$request->city,
                'post_code'=>$request->post_code,
                'phone_number'=>$request->phone_number,
                'martial_status'=>$request->martial_status,
                'children'=>$request->children,
                'pets'=>$request->pets,
                'user_id'=>Auth::user()->id,
            ]);
            DB::commit();
            session(['will_user_id' => $will_user_id->id]);
            return redirect()->route('partner.will_generator.step4');
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function store_user_child(Request $request)
    {

        try {
            DB::beginTransaction();
            WillUserChildren::create([
                'child_name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'will_user_id'=>session('will_user_id'),
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Child information saved successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
}
