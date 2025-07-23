<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Will_User_Info;
use App\Models\WillUserChildren;
use App\Models\WillUserInfo;
use App\Models\WillUserPet;
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
        $children = WillUserChildren::where('will_user_id','=',session('will_user_id'))->get();
        return view('partner.will_generator.step4', ['children' => $children]);
    }

    public function store_step4(Request $request)
    {

        $will_user_id=WillUserInfo::where('id','=',session('will_user_id'))
        ->update([
                'children'=>$request->children,
            ]);
        return redirect()->route('partner.will_generator.step5');
    }
    public function step5()
    {
        $pets = WillUserPet::where('will_user_id','=',session('will_user_id'))->get();
        return view('partner.will_generator.step5', ['pets' => $pets]);
    }
    public function store_step5(Request $request)
    {

        $will_user_id=WillUserInfo::where('id','=',session('will_user_id'))
        ->update([
                'pets'=>$request->pets,
            ]);
        return redirect()->route('partner.will_generator.create')->with(['success'=>'Your Personal Information has been submitted successfully']);
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
            $children = WillUserChildren::where('will_user_id','=',session('will_user_id'))->get();

            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Child information saved successfully','data'=>$html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_child(Request $request){
        try{
            DB::beginTransaction();
            WillUserChildren::where('id','=',$request->child_id)
            ->update([
                'child_name' => $request->child_name,
                'date_of_birth' => $request->edit_child_date_of_birth,
            ]);
            DB::commit();
            $children = WillUserChildren::where('will_user_id','=',session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully','data'=>$html]);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }

    }

    public function delete_user_child(Request $request){
        try{

            $user_child=WillUserChildren::where('id','=',$request->child_id)->first();
            if($user_child){
                DB::beginTransaction();
                $user_child->delete();
                DB::commit();
            }
            else{
                return response()->json(['status'=>false,'message'=>'No Pet found']);
            }

            $children = WillUserChildren::where('will_user_id','=',session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Pet information deleted successfully','data'=>$html]);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }

    public function store_user_pet(Request $request)
    {

        try {
            DB::beginTransaction();
            WillUserPet::create([
                'pet_name' => $request->name,
                'will_user_id'=>session('will_user_id'),
            ]);
            DB::commit();
            $pets = WillUserPet::where('will_user_id','=',session('will_user_id'))->get();

            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information saved successfully','data'=>$html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_pet(Request $request){
        try{
            DB::beginTransaction();
            WillUserPet::where('id','=',$request->pet_id)
            ->update([
                'pet_name' => $request->name,
            ]);
            DB::commit();
            $pets = WillUserPet::where('will_user_id','=',session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully','data'=>$html]);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }

    }

    public function delete_user_pet(Request $request){
        try{

            $user_pet=WillUserPet::where('id','=',$request->pet_id)->first();
            if($user_pet){
                DB::beginTransaction();
                $user_pet->delete();
                DB::commit();
            }
            else{
                return response()->json(['status'=>false,'message'=>'No Pet found']);
            }

            $pets = WillUserPet::where('will_user_id','=',session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information deleted successfully','data'=>$html]);

        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
}
