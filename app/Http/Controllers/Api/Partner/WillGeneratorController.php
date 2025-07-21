<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\WillUserChildren;
use App\Models\WillUserInfo;
use App\Models\WillUserPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WillGeneratorController extends Controller
{
     public function store_about_you(Request $request)
    {
        try{
            DB::beginTransaction();
            $user_will_user_info=WillUserInfo::create([
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
            return response()->json(['status'=>true,'Will User Info'=>$user_will_user_info]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }


    public function store_child(Request $request){
        try{
            DB::beginTransaction();
            $child_info=WillUserChildren::create([
                'child_name'=>$request->child_name,
                'date_of_birth'=>$request->date_of_birth,
                'will_user_id'=>$request->will_user_id,
            ]);
            DB::commit();
            return response()->json(['status'=>true,'child_info'=>$child_info]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);

        }
    }


    public function store_pet(Request $request){
        try{
            DB::beginTransaction();
            $pet_info=WillUserPet::create([
                'pet_name'=>$request->pet_name,
                'will_user_id'=>$request->will_user_id,
            ]);
            DB::commit();
            return response()->json(['status'=>true,'pet_info'=>$pet_info]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);

        }
    }
}
