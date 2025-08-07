<?php

namespace App\Http\Controllers\Api\Partner;

use App\Http\Controllers\Controller;
use App\Models\WillInheritedPeople;
use App\Models\WillUserAccountsProperty;
use App\Models\WillUserChildren;
use App\Models\WillUserFuneral;
use App\Models\WillUserInfo;
use App\Models\WillUserInheritedGift;
use App\Models\WillUserPet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
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



    public function store_funeral_plan(Request $request){
        {
        try {
            $createdBy = Auth::id();
            $willUserInfo = WillUserInfo::where('user_id', $createdBy)->latest()->first();

            if (is_null($willUserInfo)) {
                return back()->with('error', 'Could not determine the associated will. Please try again.');
            }
            $willUserId = $willUserInfo->id;
            $rules = [
                'pre_paid_plan' => ['required', Rule::in(['yes', 'no'])],
                'funeral_provider_name' => ['nullable', 'string', 'max:255'],
                'funeral_identification_no' => ['nullable', 'string', 'max:255'],
                'funeral_guide_wish' => ['nullable', Rule::in(['yes', 'no'])],
                'include_funeral_wishes' => ['required', Rule::in(['yes', 'no'])],
                'funeral_type_choice' => ['nullable', Rule::in(['cremation', 'burial', 'let_decide'])],
                'direct_cremation_wish' => ['nullable', Rule::in(['yes', 'no'])],
                'additional_wishes' => 'nullable|string|max:1000',
            ];

            if ($request->input('pre_paid_plan') === 'yes') {
                $rules['funeral_provider_name'] = ['required', 'string', 'max:255'];
            } else {
                $rules['funeral_guide_wish'] = ['required', Rule::in(['yes', 'no'])];
            }


            if ($request->input('include_funeral_wishes') === 'yes') {
                $rules['funeral_type_choice'] = ['required', Rule::in(['cremation', 'burial', 'let_decide'])];

                if ($request->input('funeral_type_choice') === 'cremation') {
                    $rules['direct_cremation_wish'] = ['required', Rule::in(['yes', 'no'])];
                }
            }

            $validatedData = $request->validate($rules);

            DB::beginTransaction();

            $funeralPlan = WillUserFuneral::firstOrNew(['will_user_id' => $willUserId]);

            $funeralPlan->funeral_paid = $validatedData['pre_paid_plan']; // "Do you have a pre-paid funeral plan?"

            $funeralPlan->funeral_provider_name = $validatedData['funeral_provider_name'] ?? null;
            $funeralPlan->funeral_identification_no = $validatedData['funeral_identification_no'] ?? null;

            $funeralPlan->funeral_wish = ($validatedData['pre_paid_plan'] === 'no') ?
                ($validatedData['funeral_guide_wish'] ?? null) : null;

            if ($validatedData['include_funeral_wishes'] === 'yes') {
                $funeralPlan->funeral_type = $validatedData['funeral_type_choice']; // cremation, burial, let_decide
                $funeralPlan->funeral_direct_cremation = ($validatedData['funeral_type_choice'] === 'cremation') ?
                    ($validatedData['direct_cremation_wish'] ?? null) : null;
            } else {
                $funeralPlan->funeral_type = 'no_wishes_not_included'; // Or null, depending on your preference
                $funeralPlan->funeral_direct_cremation = null;
            }

            $funeralPlan->additional = $validatedData['additional_wishes'] ?? null;
            $funeralPlan->created_by = $createdBy;
            $funeralPlan->save();
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Funeral plan saved successfully.', 'data' => $funeralPlan]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    }





     public function store_user_partner(Request $request)
    {
        try {

            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            $partner=WillInheritedPeople::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'will_user_id' => $will_user_id,
                'type' => $request->type,
            ]);
            DB::commit();
            return response()->json(['status' => true, 'messsage' => 'Partner have been saved successfully', 'data' => $partner]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_partner(Request $request)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            WillInheritedPeople::where('id', $request->id)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone_number,
                    'email' => $request->email,
                    'type' => $request->relationship,
                ]);
            DB::commit();
            $partner = WillInheritedPeople::where('id', $request->id)->first();

           
            return response()->json(['status' => true, 'messsage' => 'Partner have been updated successfully', 'data' => $partner]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


     public function delete_user_partner(Request $request)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            $will_inherited_people = WillInheritedPeople::where('id', '=', $request->id)->first();
            if ($will_inherited_people) {
                DB::beginTransaction();
                $will_inherited_people->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No Pet found']);
            }

            return response()->json(['status' => true, 'message' => 'Partner deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function store_add_gift(Request $request)
    {
        try {
            $createdBy = Auth::id();
            $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();

            if (is_null($willUserId)) {
                return back()->with('error', 'Could not determine the associated will. Please try again.');
            }

            $familyInheritedIdsString = implode(',', $request['recipients']);


            DB::beginTransaction();
            $gift = WillUserInheritedGift::create([
                'gift_type' => $request['type'],
                'gift_name' => $request['item_description'],
                'family_inherited_id' => $familyInheritedIdsString, // Store the comma-separated string
                'leave_message' => $request['message'],
                'will_user_id' => $willUserId->id,
                'created_by' => $createdBy,
            ]);
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Gift added successfully!', 'data' => $gift]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function update_gift(Request $request, $id)
    {
        try {
            $gift = WillUserInheritedGift::findOrFail($id);
            $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();

            if (is_null($willUserId) || $gift->will_user_id !== $willUserId->id) {
                return back()->with('error', 'Unauthorized access or gift not found.');
            }

            $familyInheritedIdsString = implode(',', $request['recipients']);

            DB::beginTransaction();
            $gift->update([
                'gift_type' => $request['type'],
                'gift_name' => $request['item_description'],
                'family_inherited_id' => $familyInheritedIdsString,
                'leave_message' => $request['message'],
            ]);
            DB::commit();
            $updated_gift = WillUserInheritedGift::findOrFail($id);
            return response()->json(['status' => true, 'message' => 'Gift updated successfully!', 'data' => $updated_gift]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function delete_gift($id)
    {
        try {
            $gift = WillUserInheritedGift::findOrFail($id);
            $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();
            if (is_null($willUserId) || $gift->will_user_id !== $willUserId->id) {
                return back()->with('error', 'Unauthorized access or gift not found.');
            }
            DB::beginTransaction();
            $gift->delete();
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Gift deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

}
