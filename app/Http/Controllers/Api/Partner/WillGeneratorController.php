<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\WillInheritedPeople;
use App\Models\WillUserAccountsProperty;
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
        try {
            DB::beginTransaction();
            $user_will_user_info = WillUserInfo::create([
                'legal_name' => $request->legal_name,
                'user_name' => $request->user_name,
                'date_of_birth' => $request->date_of_birth,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'post_code' => $request->post_code,
                'phone_number' => $request->phone_number,
                'martial_status' => $request->martial_status,
                'children' => $request->children,
                'pets' => $request->pets,
                'user_id' => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'Will User Info' => $user_will_user_info]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function store_user_child(Request $request)
    {

        try {
            DB::beginTransaction();
            $child= WillInheritedPeople::create([
                'first_name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'will_user_id' => session('will_user_id'),
                'type' => 'child',
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Child information saved successfully', 'Child' => $child]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_child(Request $request)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::where('id', '=', $request->child_id)
                ->update([
                    'first_name' => $request->child_name,
                    'date_of_birth' => $request->edit_child_date_of_birth,
                ]);
            DB::commit();
            $children = WillInheritedPeople::where('id','=',$request->child_id)->first();
            return response()->json(['status' => true, 'message' => 'Child information updated successfully', 'data' => $children]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_user_child(Request $request)
    {
        try {

            $user_child = WillInheritedPeople::where('id', '=', $request->child_id)->first();
            if ($user_child) {
                DB::beginTransaction();
                $user_child->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No child found']);
            }
            return response()->json(['status' => true, 'message' => 'Child information deleted successfully', 'data' => $user_child]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_user_pet(Request $request)
    {

        try {
            DB::beginTransaction();
            $pet=WillInheritedPeople::create([
                'first_name' => $request->name,
                'will_user_id' => session('will_user_id'),
                'type' => 'pet',
            ]);
            DB::commit();
            
            return response()->json(['status' => true, 'message' => 'Pet information submitted successfully','Pet Detail'=>$pet]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_pet(Request $request)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::where('id', '=', $request->pet_id)
                ->update([
                    'first_name' => $request->name,
                ]);
            DB::commit();
            $pet = WillInheritedPeople::where('id', '=', $request->pet_id)->first();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully','Pet Detail'=>$pet]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_user_pet(Request $request)
    {
        try {

            $user_pet = WillInheritedPeople::where('id', '=', $request->pet_id)->first();
            if ($user_pet) {
                DB::beginTransaction();
                $user_pet->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No Pet found']);
            }
            $pet = WillUserPet::where('id', '=', $request->pet_id)->first();
            return response()->json(['status' => true, 'message' => 'Pet information delete successfully','Pet Detail'=>$pet]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }





    public function store_account_properties(Request $request)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            $user_account_property=WillUserAccountsProperty::create([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_value,
                'mortage' => $request->has_mortgage,
                'owner' => $request->ownership_type,
                'will_user_id' => $will_user_id,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Account information submitted successfully', 'data' => $user_account_property]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function update_account_properties(Request $request)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            WillUserAccountsProperty::where('id', '=', $request->id)
                ->update([
                    'asset_type' => $request->asset_type,
                    'asset_name' => $request->asset_value,
                    'mortage' => $request->has_mortgage,
                    'owner' => $request->ownership_type,
                ]);
            DB::commit();
            $updated_account_property = WillUserAccountsProperty::where('id', '=', $request->id)->first();
            return response()->json(['status' => true, 'message' => 'Account information update successfully', 'data' => $updated_account_property]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function delete_account_properties($id)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            $account_property = WillUserAccountsProperty::where('id', '=', $id)->first();
            if ($account_property) {
                DB::beginTransaction();
                $account_property->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No Pet found']);
            }
            return response()->json(['status' => true, 'message' => 'Account Information deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


}
