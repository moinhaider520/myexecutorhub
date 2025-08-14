<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Beneficiary;
use App\Models\Charity;
use App\Models\WillInheritedPeople;
use App\Models\WillUserAccountsProperty;
use App\Models\WillUserEstates;
use App\Models\WillUserFuneral;
use App\Models\WillUserInfo;
use App\Models\WillUserInheritedGift;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
class WillGeneratorController extends Controller
{
    public function partner_about_you()
    {
        try {
            $will_user_infos = WillUserInfo::where('user_id', Auth::user()->id)->get();
            if ($will_user_infos) {
                return response()->json(['status' => true, 'data' => $will_user_infos]);
            } else {
                return response()->json(['status' => false, 'message' => 'No Will User Info found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function about_you($id)
    {
        try {
            $will_user_info = WillUserInfo::find($id);
            if ($will_user_info) {
                return response()->json(['status' => true, 'data' => $will_user_info]);
            } else {
                return response()->json(['status' => false, 'message' => 'No Will User Info found']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
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
            session(['will_user_id' => $user_will_user_info->id]);
            return response()->json(['status' => true, 'Will User Info' => $user_will_user_info]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_about_you(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user_will_user_info = WillUserInfo::findOrFail($id);

            $user_will_user_info->update([
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
            ]);

            DB::commit();

            return response()->json(['status' => true, 'data' => $user_will_user_info]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function child($will_user_id)
    {
        try {

            $children = WillInheritedPeople::where('will_user_id', $will_user_id)
                ->where('type', 'child')
                ->get();
            return response()->json(['status' => true, 'data' => $children]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function store_user_child(Request $request, $will_user_id)
    {

        try {
            DB::beginTransaction();
            $child = WillInheritedPeople::create([
                'first_name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'will_user_id' => $will_user_id,
                'type' => 'child',
            ]);
            DB::commit();
            return response()->json(['status' => true, 'message' => 'Child information saved successfully', 'data' => $child]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_child(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::where('id', '=', $id)
                ->update([
                    'first_name' => $request->name,
                    'date_of_birth' => $request->date_of_birth,
                ]);
            DB::commit();
            $children = WillInheritedPeople::where('id', '=', $request->child_id)->first();
            return response()->json(['status' => true, 'message' => 'Child information updated successfully', 'data' => $children]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_user_child($id)
    {
        try {

            $user_child = WillInheritedPeople::where('id', '=', $id)->first();
            if ($user_child) {
                DB::beginTransaction();
                $user_child->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No child found']);
            }
            return response()->json(['status' => true, 'message' => 'Child information deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function pet($will_user_id)
    {
        try {
            $pets = WillInheritedPeople::where('will_user_id', $will_user_id)->where('type', 'pet')
                ->get();
            return response()->json(['status' => true, 'data' => $pets]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_user_pet(Request $request, $will_user_id)
    {

        try {
            DB::beginTransaction();
            $pet = WillInheritedPeople::create([
                'first_name' => $request->name,
                'will_user_id' => $will_user_id,
                'type' => 'pet',
            ]);
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Pet information submitted successfully', 'data' => $pet]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function edit_user_pet(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::where('id', '=', $id)
                ->update([
                    'first_name' => $request->name,
                ]);
            DB::commit();
            $pet = WillInheritedPeople::where('id', '=', $id)->first();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully', 'data' => $pet]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function delete_user_pet($id)
    {
        try {

            $user_pet = WillInheritedPeople::where('id', '=', $id)->first();
            if ($user_pet) {
                DB::beginTransaction();
                $user_pet->delete();
                DB::commit();
            } else {
                return response()->json(['status' => false, 'message' => 'No Pet found']);
            }
            return response()->json(['status' => true, 'message' => 'Pet information delete successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function account_properties($will_user_id)
    {
        try {
            $account_properties = WillUserAccountsProperty::where('will_user_id', $will_user_id)->get();
            return response()->json(['status' => true, 'data' => $account_properties]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function store_account_properties(Request $request, $will_user_id)
    {
        try {
            DB::beginTransaction();
            $user_account_property = WillUserAccountsProperty::create([
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
    public function update_account_properties(Request $request, $id)
    {
        try {

            DB::beginTransaction();
            WillUserAccountsProperty::where('id', '=', $id)
                ->update([
                    'asset_type' => $request->asset_type,
                    'asset_name' => $request->asset_value,
                    'mortage' => $request->has_mortgage,
                    'owner' => $request->ownership_type,
                ]);
            DB::commit();
            $updated_account_property = WillUserAccountsProperty::where('id', '=', $id)->first();
            return response()->json(['status' => true, 'message' => 'Account information update successfully', 'data' => $updated_account_property]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function delete_account_properties($id)
    {
        try {
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

    public function funeral_plan($will_user_id)
    {
        try {
            $funeral_plan = WillUserFuneral::where('will_user_id', $will_user_id)->first();
            return response()->json(['status' => true, 'data' => $funeral_plan]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_funeral_plan(Request $request, $will_user_id)
    { {
            try {

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

                $funeralPlan = WillUserFuneral::firstOrNew(['will_user_id' => $will_user_id]);

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
                $funeralPlan->created_by = Auth::user()->id;
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

    public function user_partner($will_user_id)
    {
        try {
            $partners = WillInheritedPeople::where('will_user_id', $will_user_id)
                ->where('type', 'partner')
                ->get();
            return response()->json(['status' => true, 'data' => $partners]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_user_partner(Request $request, $will_user_id)
    {
        try {

            DB::beginTransaction();
            $partner = WillInheritedPeople::create([
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


    public function edit_user_partner(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::where('id', $id)
                ->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'type' => $request->type,
                ]);
            DB::commit();
            $partner = WillInheritedPeople::find($id);
            return response()->json(['status' => true, 'messsage' => 'Partner have been updated successfully', 'data' => $partner]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function delete_user_partner($id)
    {
        try {
            $will_inherited_people = WillInheritedPeople::where('id', '=', $id)->first();
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

    public function gift($will_user_id)
    {
        try {
            $gifts = WillUserInheritedGift::where('will_user_id', $will_user_id)->get();
            return response()->json(['status' => true, 'data' => $gifts]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_add_gift(Request $request, $will_user_id)
    {
        try {

            $familyInheritedIdsString = implode(',', $request['recipients']);
            DB::beginTransaction();
            $gift = WillUserInheritedGift::create([
                'gift_type' => $request['type'],
                'gift_name' => $request['item_description'],
                'family_inherited_id' => $familyInheritedIdsString, // Store the comma-separated string
                'leave_message' => $request['message'],
                'will_user_id' => $will_user_id,
                'created_by' => Auth::user()->id,
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
            DB::beginTransaction();
            $gift->delete();
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Gift deleted successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function family_friend($will_user_id)
    {
        try {
            $family_friends = WillInheritedPeople::where('will_user_id', $will_user_id)
                ->where('type', 'partner')
                ->orWhere('type', '=', 'child')
                ->get();
            return response()->json(['status' => true, 'data' => $family_friends]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_family_friend(Request $request, $will_user_id)
    {
        try {
            DB::beginTransaction();

            $willUserInfo = WillUserInfo::findOrFail($will_user_id);

            // Remove existing family/friends
            $willUserInfo->beneficiaries()
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->delete();

            $selectedFamilyFriendsIds = $request->input('family_friends', []);
            $selectedFamilyFriendsPercentages = $request->input('family_friends_percentages', []);

            foreach ($selectedFamilyFriendsIds as $index => $familyFriendId) {
                $familyFriend = WillInheritedPeople::findOrFail($familyFriendId);

                $willUserInfo->beneficiaries()->create([
                    'beneficiable_id' => $familyFriend->id,
                    'beneficiable_type' => get_class($familyFriend),
                    'share_percentage' => isset($selectedFamilyFriendsPercentages[$index])
                        ? (float) $selectedFamilyFriendsPercentages[$index]
                        : 0.00,
                ]);
            }

            DB::commit();
            DB::beginTransaction();

            // Remove existing charities
            $willUserInfo->beneficiaries()
                ->where('beneficiable_type', Charity::class)
                ->delete();

            if ($request->input('leave_to_charity') === 'yes') {

                $selectedManualCharityIds = $request->input('charities_manual', []);
                $selectedManualCharityPercentages = $request->input('charities_manual_percentages', []);

                foreach ($selectedManualCharityIds as $index => $charityId) {
                    $charity = Charity::findOrFail($charityId);

                    $willUserInfo->beneficiaries()->create([
                        'beneficiable_id' => $charity->id,
                        'beneficiable_type' => get_class($charity),
                        'share_percentage' => isset($selectedManualCharityPercentages[$index])
                            ? (float) $selectedManualCharityPercentages[$index]
                            : 0.00,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Family, friends, and charities processed successfully.',
                'family_friends' => $willUserInfo->beneficiaries()
                    ->where('beneficiable_type', WillInheritedPeople::class)
                    ->get(),
                'charities' => $willUserInfo->beneficiaries()
                    ->where('beneficiable_type', Charity::class)
                    ->get(),
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function charities()
    {
        try {

            $charities = Charity::all();
            return response()->json(['status' => true, 'data' => $charities]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function inherited_charity($will_user_id)
    {
        try {

            $charities = WillUserInfo::find($will_user_id)->beneficiaries()
                ->where('beneficiable_type', Charity::class)
                ->get();
            return response()->json(['status' => true, 'data' => $charities]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function process_inherited_charity(Request $request, $will_user_id)
    {

        try {
            $willUserInfo = WillUserInfo::find($will_user_id);

            DB::beginTransaction();
            // Remove existing Charity beneficiaries for this will
            $willUserInfo->beneficiaries()
                ->where('beneficiable_type', Charity::class)
                ->delete();

            if ($request->input('leave_to_charity') === 'yes') {
                // Process pre-defined/logo charities (ensure their values are Charity IDs)
                $selectedLogoCharityIds = $request->input('charities', []);
                foreach ($selectedLogoCharityIds as $charityId) {
                    $charity = Charity::findOrFail($charityId);
                    $willUserInfo->beneficiaries()->create([
                        'beneficiable_id' => $charity->id,
                        'beneficiable_type' => get_class($charity), // App\Models\Charity
                        'share_percentage' => 0.00, // Default
                    ]);
                }

                // Process manually added charities (their values are already Charity IDs)
                $selectedManualCharityIds = $request->input('charities_manual', []);
                foreach ($selectedManualCharityIds as $charityId) {
                    $charity = Charity::findOrFail($charityId);
                    $willUserInfo->beneficiaries()->create([
                        'beneficiable_id' => $charity->id,
                        'beneficiable_type' => get_class($charity), // App\Models\Charity
                        'share_percentage' => 0.00, // Default
                    ]);
                }
            }

            DB::commit();
            $beneficiaries = $willUserInfo->beneficiaries()
                ->where('beneficiable_type', Charity::class)->get();

            $inputPercentages = $request->input('percentages');
            DB::beginTransaction();
            if ($request->has('percentages')) {

                foreach ($inputPercentages as $beneficiaryData) {
                    $beneficiaryId = $beneficiaryData['id'];
                    $percentage = $beneficiaryData['percentage'];
                    $beneficiary = Beneficiary::where('id', $beneficiaryId)
                        ->where('will_user_id', $willUserInfo->id)
                        ->first();
                    $beneficiary->share_percentage = $percentage;
                    $beneficiary->save();
                }

                DB::commit();
            }

            return response()->json([
                'status' => true,
                'message' => 'Charity beneficiaries processed successfully.',
                'charities' => $beneficiaries

            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_charity(Request $request)
    {
        try {

            DB::beginTransaction();
            $charity = Charity::create([
                'name' => $request->name,
                'registration_number' => $request->registration_number,
                'logo_path' => $request->logo_path,
            ]);
            DB::commit();

            return response()->json(['status' => true, 'message' => 'Charity store in database successfully', 'data' => $charity]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_share_percentage(Request $request, $will_user_id)
    {
        try {
            $willUserInfo = WillUserInfo::find($will_user_id);
            $inputPercentages = $request->input('percentages');
            DB::beginTransaction();
            foreach ($inputPercentages as $beneficiaryData) {
                $beneficiaryId = $beneficiaryData['id'];
                $percentage = $beneficiaryData['percentage'];
                $beneficiary = Beneficiary::where('id', $beneficiaryId)
                    ->where('will_user_id', $willUserInfo->id)
                    ->first();
                $beneficiary->share_percentage = $percentage;
                $beneficiary->save();
            }

            DB::commit();
            return response()->json(['status' => true, 'Beneficiary percentages updated successfully!', 'data' => $willUserInfo->beneficiaries()->get()]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function benificaries_death_backup(Request $request, $will_user_id)
    {

        if ($request->has('beneficiary')) {

            $beneficiary = Beneficiary::where('will_user_id', $will_user_id)
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->where('id', $request->beneficiary)
                ->first();
        } else {
            $beneficiary = Beneficiary::where('will_user_id', $will_user_id)
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->first();
        }

        $allBeneficiaries = WillUserInfo::with('beneficiaries')->where('id', $will_user_id)->first();
        return response()->json([
            'status' => true,
            'beneficiary' => $beneficiary,
            'allBeneficiaries' => $allBeneficiaries->beneficiaries
        ]);
    }


    public function store_benificaries_death_backup(Request $request, $will_user_id)
    {
        try {
            DB::beginTransaction();

            $ids = $request->input('current_beneficiary_id');
            $options = $request->input('selected_backup_option');

            // Normalize to arrays
            if (!is_array($ids)) {
                $ids = [$ids];
            }
            if (!is_array($options)) {
                $options = [$options];
            }

            foreach ($ids as $index => $id) {
                $beneficiary = Beneficiary::where('will_user_id', $will_user_id)
                    ->where('id', $id)
                    ->first();

                if (!$beneficiary) {
                    continue; // Skip if not found
                }

                $beneficiary->death_backup_plan = $options[$index] ?? null;
                $beneficiary->save();
            }

            DB::commit();

            $beneficiaries = Beneficiary::where('will_user_id', $will_user_id)
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->orderBy('id')
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Beneficiary death backup plan(s) updated successfully.',
                'beneficiaries' => $beneficiaries
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    public function estate_summary($will_user_id)
    {

        $beneficiaries = Beneficiary::with('willUser','beneficiable')->where('will_user_id', $will_user_id)
            ->orderBy('id')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $beneficiaries,
        ]);
    }

    public function store_estate_summary(Request $request, $will_user_id)
    {
        try {

            DB::beginTransaction();
            $will_estate_summary = WillUserEstates::create([
                'specific_person_will' => $request->input('excluded_choice'),
                'will_estate_reason' => $request->input('will_estate_reason'),
                'will_user_id' => $will_user_id,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Estate summary saved successfully.',
                'will_estate_summary' => $will_estate_summary
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function executors($will_user_id)
    {
        try {
            $will_user_info = WillUserInfo::find($will_user_id);
            $will_user_info->refresh()->load('executors');
            return response()->json(['status' => true, 'data' => $will_user_info]);
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_executor(Request $request, $will_user_id)
    {
        try {

            DB::beginTransaction();
            $will_user_info = WillUserInfo::find($will_user_id);
            $will_user_info->executors()->sync($request->executor_id);

            DB::commit();
            $will_user_info = WillUserInfo::find($will_user_id);
            $will_user_info->refresh()->load('executors');
            return response()->json(['status' => true, 'message' => 'Executor saved successfully', 'data' => $will_user_info]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function create_pdf($will_user_id)
    {
        $will_user = WillUserInfo::with('child')->find($will_user_id);

        $pdf = PDF::loadView('partner.will_generator.will_pdf', ['user_info' => $will_user]);
        return $pdf->download('invoice.pdf');
    }
}

