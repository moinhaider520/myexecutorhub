<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Beneficiary;
use App\Models\Charity;
use App\Models\User;
use App\Models\Will_User_Info;
use App\Models\WillInheritedPeople;
use App\Models\WillUserAccountsProperty;
use App\Models\WillUserChildren;
use App\Models\WillUserEstates;
use App\Models\WillUserFuneral;
use App\Models\WillUserInfo;
use App\Models\WillUserInheritedGift;
use App\Models\WillUserPet;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WillGeneratorController extends Controller
{
    public function index()
    {
        $user_about_infos = WillUserInfo::where('user_id', Auth::id())->get();
        return view('partner.will_generator.index', compact('user_about_infos'));
    }

    public function create($will_user_id)
    {
        $will_user_info = WillUserInfo::find($will_user_id);
        return view('partner.will_generator.create', compact('will_user_info'));
    }


    public function step3($will_user_id)
    {

        $partners = WillInheritedPeople::where('will_user_id', '=', $will_user_id)
            ->where('type', 'partner')
            ->get();

        return view('partner.will_generator.step3', ['partners' => $partners, 'will_user_id' => $will_user_id]);
    }

    public function store_step3(Request $request)
    {
        try {

            $will_inherited_people = WillInheritedPeople::where('id', '=', $request->executors)->first();

            DB::beginTransaction();
            $will_user_id = WillUserInfo::where('id', '=', $request->will_user_id)
                ->update([
                    'martial_status' => $request->martial_status,
                    'partner_name' => $will_inherited_people ? ($will_inherited_people->first_name . ' ' . $will_inherited_people->last_name) : 'No partner',
                ]);
            DB::commit();
            return redirect()->route('partner.will_generator.step4', $request->will_user_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function step4($will_user_id)
    {
        $children = WillInheritedPeople::where('will_user_id', '=', $will_user_id)->where('type', 'child')->get();
        return view('partner.will_generator.step4', ['children' => $children, 'will_user_id' => $will_user_id]);
    }

    public function store_step4(Request $request)
    {

        $will_user_id = WillUserInfo::where('id', '=', $request->will_user_id)
            ->update([
                'children' => $request->children,
            ]);
        return redirect()->route('partner.will_generator.step5', $request->will_user_id);
    }
    public function step5($will_user_id)
    {
        $pets = WillInheritedPeople::where('will_user_id', '=', $will_user_id)->where('type', 'pet')->get();
        return view('partner.will_generator.step5', ['pets' => $pets, 'will_user_id' => $will_user_id]);
    }
    public function store_step5(Request $request)
    {

        $will_user_id = WillUserInfo::where('id', '=', $request->will_user_id)
            ->update([
                'pets' => $request->pets,
            ]);
        return redirect()->route('partner.will_generator.create', $request->will_user_id)->with(['success' => 'Your Personal Information has been submitted successfully']);
    }

    public function about_you($will_user_id = null)
    {
        $user_info = WillUserInfo::find($will_user_id);
        return view('partner.will_generator.about_you', compact('user_info'));
    }

    public function store_about_you(Request $request)
    {
        try {

            DB::beginTransaction();
            $will_user_id = WillUserInfo::updateOrCreate(
                [
                    'id' => $request->will_user_id
                ],
                [
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
                ]
            );
            DB::commit();

            return redirect()->route('partner.will_generator.step3', $request->will_user_id ?? $will_user_id->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function delete_about_you($will_user_id)
    {
        try {
            $user_info = WillUserInfo::find($will_user_id);
            if ($user_info) {
                DB::beginTransaction();
                $user_info->delete();
                DB::commit();
            }
            return redirect()->back()->with('success', 'User Info data has been deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function store_user_child(Request $request)
    {

        try {
            DB::beginTransaction();
            WillInheritedPeople::create([
                'first_name' => $request->name,
                'date_of_birth' => $request->date_of_birth,
                'will_user_id' => $request->will_user_id,
                'type' => 'child',
            ]);
            DB::commit();
            $children = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'child')->get();

            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Child information saved successfully', 'data' => $html]);
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
            $children = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'child')->get();
            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully', 'data' => $html]);
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
                return response()->json(['status' => false, 'message' => 'No Pet found']);
            }

            $children = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'child')->get();
            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Children information deleted successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_user_pet(Request $request)
    {

        try {
            DB::beginTransaction();
            WillInheritedPeople::create([
                'first_name' => $request->name,
                'will_user_id' => $request->will_user_id,
                'type' => 'pet',
            ]);
            DB::commit();
            $pets = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'pet')->get();

            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information saved successfully', 'data' => $html]);
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
            $pets = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'pet')->get();
            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information update successfully', 'data' => $html]);
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

            $pets = WillInheritedPeople::where('will_user_id', '=', $request->will_user_id)->where('type', 'pet')->get();
            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information deleted successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function account_properties($will_user_id)
    {
        $assets = WillUserAccountsProperty::where('will_user_id', $will_user_id)->get();
        return view('partner.will_generator.account_properties', compact('assets', 'will_user_id'));
    }
    public function submit_account_properties($will_user_id)
    {
        return redirect()->route('partner.will_generator.create', $will_user_id)->with(['success' => 'Your Account Information has been submitted successfully']);
    }


    public function store_account_properties(Request $request, $will_user_id)
    {
        try {

            DB::beginTransaction();
            WillUserAccountsProperty::create([
                'asset_type' => $request->asset_type,
                'asset_name' => $request->asset_value,
                'mortage' => $request->has_mortgage,
                'owner' => $request->ownership_type,
                'will_user_id' => $will_user_id,
                'created_by' => Auth::user()->id,
            ]);
            DB::commit();
            $assets = WillUserAccountsProperty::where('will_user_id', '=', $will_user_id)->get();
            $html = view('partner.will_generator.ajax.asset_list', ['assets' => $assets])->render();
            return response()->json(['status' => true, 'message' => 'Account information deleted successfully', 'data' => $html]);
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
            $assets = WillUserAccountsProperty::where('will_user_id', '=', $will_user_id)->get();
            $html = view('partner.will_generator.ajax.asset_list', ['assets' => $assets])->render();
            return response()->json(['status' => true, 'message' => 'Account information update successfully', 'data' => $html]);
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

            $assets = WillUserAccountsProperty::where('will_user_id', '=', $will_user_id)->get();
            $html = view('partner.will_generator.ajax.asset_list', ['assets' => $assets])->render();
            return response()->json(['status' => true, 'message' => 'Account Information deleted successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }




    public function executor($will_user_id)
    {
        return view('partner.will_generator.executor', compact('will_user_id'));
    }
    public function executor_step2($will_user_id)
    {
        return view('partner.will_generator.executor_step2', compact('will_user_id'));
    }
    public function executor_step3($will_user_id)
    {
        return view('partner.will_generator.executor_step3', compact('will_user_id'));
    }
    public function get_executor_step3(Request $request)
    {
        $executorType = $request->executor_type;
        $executors = WillInheritedPeople::where('will_user_id', $request->will_user_id)
            ->where(function ($query) {
                $query->orWhere('type', 'partner')
                    ->orWhere('type', 'child');
            })
            ->get();
        if ($request->executor_type == "friends_family") {
            return view('partner.will_generator.family_friend', [
                'showProfessionalExecutors' => false,
                'selectedExecutorType' => $executorType,
                'executors' => $executors,
                'will_user_id' => $request->will_user_id
            ]);
        } elseif ($request->executor_type == "farewill_trustees") {
            return redirect()->route('partner.will_generator.farewill_trustees', $request->will_user_id);
        } else {
            return view('partner.will_generator.family_friend', [
                'showProfessionalExecutors' => true,
                'selectedExecutorType' => $executorType,
                'executors' => $executors,
                'will_user_id' => $request->will_user_id
            ]);
        }
    }

    public function farewill_trustees($will_user_id)
    {
        return view('partner.will_generator.farewill_trustees', compact('will_user_id'));
    }

    public function store_executor(Request $request)
{
    try {
        DB::beginTransaction();

        $will_user_id = WillUserInfo::find($request->will_user_id);
        $executorIds = []; 

        if ($request->has('friends_and_family')) {
            $executorIds = $request->input('executors', []);
        }
        if ($request->has('farewill_trustees')) {
            $farewillTrustee = WillInheritedPeople::firstOrCreate(
                ['type' => 'Professional Executor'],
                [
                    'first_name' => 'Farewill',
                    'last_name' => 'Trustees',
                    'type' => 'Professional Executor',
                    'will_user_id' => $request->will_user_id,
                ]
            );
            $executorIds[] = $farewillTrustee->id;
        
        }

        $will_user_id->executors()->sync($executorIds);   
        DB::commit();
        return redirect()->route('partner.will_generator.create', $request->will_user_id)
                         ->with(['success' => 'Your Executors has been selected successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['status' => false, 'message' => $e->getMessage()]);
    }
}

    public function store_family_friend(Request $request)
    {
        try {
            DB::beginTransaction();
            $willUserInfo = WillUserInfo::find($request->will_user_id);

            $willUserInfo->beneficiaries()
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->delete();

            $selectedFamilyFriendsIds = $request->input('family_friends', []);

            foreach ($selectedFamilyFriendsIds as $familyFriendId) {
                $familyFriend = WillInheritedPeople::findOrFail($familyFriendId);

                $willUserInfo->beneficiaries()->create([
                    'beneficiable_id' => $familyFriend->id,
                    'beneficiable_type' => get_class($familyFriend),
                    'share_percentage' => 0.00,
                ]);
            }

            DB::commit();

            return redirect()->route('partner.will_generator.choose_inherited_charity', $request->will_user_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    


    public function your_estate($will_user_id)
    {
        return view('partner.will_generator.estate.your_estate', compact('will_user_id'));
    }
    public function choose_inherited_persons($will_user_id)
    {

        $executors = WillInheritedPeople::where('will_user_id', '=', $will_user_id)->get();
        return view('partner.will_generator.estate.choose_inherited_persons', compact('executors', 'will_user_id'));
    }
    public function choose_inherited_charity($will_user_id)
    {

        $inheritedPersons = Beneficiary::where('beneficiable_type', WillInheritedPeople::class)
            ->where('will_user_id', $will_user_id)
            ->get();

        $charities = Charity::get();
        return view('partner.will_generator.estate.choose_inherited_charity', compact('inheritedPersons', 'charities', 'will_user_id'));
    }

    public function process_inherited_charity(Request $request)
    {

        try {
            $willUserInfo = WillUserInfo::find($request->will_user_id);

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


            // Redirect to the next step (e.g., allocating percentages)
            return redirect()->route('partner.will_generator.share_percentage', $request->will_user_id) // Create this route next
                ->with('success', 'Charity beneficiaries saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }
    public function share_percentage($will_user_id)
    {
        $executors = User::role('executor')->get();
        $beneficiaries = WillUserInfo::with('beneficiaries')->where('id', $will_user_id)->first();

        return view('partner.will_generator.estate.share_percentage', compact('executors', 'beneficiaries', 'will_user_id'));
    }
    public function gift($will_user_id)
    {

        $physicalGifts = [];
        if ($will_user_id) {
            $physicalGifts = WillUserInheritedGift::where('will_user_id', $will_user_id)
                ->whereIn('gift_type', ['one-off', 'collection', 'vehicle', 'money'])
                ->get();
        }

        return view('partner.will_generator.gift', compact('physicalGifts', 'will_user_id'));
    }


    public function show_add_gift($type, $will_user_id)
    {
        $executors = WillInheritedPeople::where('will_user_id', $will_user_id)
            ->where(function ($query) {
                $query->where('type', 'pet')
                    ->orWhere('type', 'partner')
                    ->orWhere('type', 'child');
            })
            ->get();

        return view('partner.will_generator.gift_add', compact('type', 'executors', 'will_user_id'));
    }
    public function edit_add_gift($id)
    {
        try {

            $gift = WillUserInheritedGift::findOrFail($id);
            $executors = WillInheritedPeople::where('will_user_id', $gift->will_user_id)
                ->where(function ($query) {
                    $query->where('type', 'pet')
                        ->orWhere('type', 'partner')
                        ->orWhere('type', 'child');
                })
                ->get();

            $selectedRecipientIds = explode(',', $gift->family_inherited_id);

            return view('partner.will_generator.gift_edit', compact('gift', 'executors', 'selectedRecipientIds'));
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while trying to edit the gift: ' . $e->getMessage());
        }
    }
    public function store_add_gift(Request $request, $will_user_id)
    {
        try {


            $familyInheritedIdsString = implode(',', $request['executors']);
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

            return redirect()->route('partner.will_generator.gift', $will_user_id)->with('success', 'Gift added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update_gift(Request $request, $id)
    {
        try {
            $gift = WillUserInheritedGift::findOrFail($id);

            $familyInheritedIdsString = implode(',', $request['executors']);

            DB::beginTransaction();
            $gift->update([
                'gift_type' => $request['type'],
                'gift_name' => $request['item_description'],
                'family_inherited_id' => $familyInheritedIdsString,
                'leave_message' => $request['message'],
            ]);
            DB::commit();

            return redirect()->route('partner.will_generator.gift', $gift->will_user_id)->with('success', 'Gift updated successfully!');
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




    public function funeral($will_user_id)
    {

        $funeralPlan = WillUserFuneral::find($will_user_id);
        return view('partner.will_generator.funeral.funeral', compact('funeralPlan', 'will_user_id'));
    }

    public function store_funeral_plan(Request $request)
    {
        try {

            DB::beginTransaction();
            $funeralPlan = WillUserFuneral::firstOrNew(['will_user_id' => $request->will_user_id]);
            $funeralPlan->funeral_paid = $request['pre_paid_plan'];
            $funeralPlan->funeral_provider_name = $request['funeral_provider_name'] ?? null;
            $funeralPlan->funeral_identification_no = $request['funeral_identification_no'] ?? null;
            $funeralPlan->funeral_wish = ($request['pre_paid_plan'] === 'no') ? ($request['funeral_guide_wish'] ?? null) : null;
            if ($request['include_funeral_wishes'] === 'yes') {
                $funeralPlan->funeral_type = $request['funeral_type_choice'];
                $funeralPlan->funeral_direct_cremation = ($request['funeral_type_choice'] === 'cremation') ?
                    ($request['direct_cremation_wish'] ?? null) : null;
            } else {
                $funeralPlan->funeral_type = 'no_wishes_not_included';
                $funeralPlan->funeral_direct_cremation = null;
            }

            $funeralPlan->additional = $request['additional_wishes'] ?? null;
            $funeralPlan->created_by = Auth::user()->id;
            $funeralPlan->save();
            DB::commit();
            return redirect()->route('partner.will_generator.create', $request->will_user_id)->with('success', 'Funeral plan details saved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function store_user_partner(Request $request)
    {
        try {
            DB::beginTransaction();
            WillInheritedPeople::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'will_user_id' => $request->will_user_id,
                'type' => $request->type,
            ]);

            DB::commit();
            $partners = WillInheritedPeople::where('will_user_id', $request->will_user_id)->get();
            $html = view('partner.will_generator.ajax.partner_list', compact('partners'))->render();
            return response()->json(['status' => true, 'messsage' => 'Partner have been saved successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function edit_user_partner(Request $request)
    {
        try {

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
            $partners = WillInheritedPeople::where('will_user_id', $request->will_user_id)->get();

            $html = view('partner.will_generator.ajax.partner_list', compact('partners'))->render();
            return response()->json(['status' => true, 'messsage' => 'Partner have been updated successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function partner_delete(Request $request)
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

            $partners = WillInheritedPeople::where('will_user_id', '=', $will_user_id)->get();
            $html = view('partner.will_generator.ajax.partner_list', ['partners' => $partners])->render();
            return response()->json(['status' => true, 'message' => 'Partner deleted successfully', 'data' => $html]);
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
            $charities = Charity::get();
            $html = view('partner.will_generator.ajax.charity', compact('charities'))->render();
            return response()->json(['status' => true, 'message' => 'Charity store in database successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function store_share_percentage(Request $request)
    {
        try {

            $inputPercentages = $request->input('percentages');
            DB::beginTransaction();
            $shouldRedirectToDeathBackup = false;
            foreach ($inputPercentages as $beneficiaryData) {
                $beneficiaryId = $beneficiaryData['id'];
                $percentage = $beneficiaryData['percentage'];
                $beneficiary = Beneficiary::where('id', $beneficiaryId)
                    ->where('will_user_id', $request->will_user_id)
                    ->first();
                $beneficiary->share_percentage = $percentage;
                $beneficiary->save();
                if ($beneficiary->beneficiary_type === 'App\\Models\\InheritedPeople') {
                    $shouldRedirectToDeathBackup = true;
                }
            }
            DB::commit();
            if ($shouldRedirectToDeathBackup) {
                return redirect()->route('partner.will_generator.benificaries_death_backup', $request->will_user_id);
            } else {
                return redirect()->route('partner.will_generator.estate.summary', $request->will_user_id);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update beneficiary percentages. Please try again.');
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
        return view('partner.will_generator.estate.benificaries_death', compact('beneficiary', 'allBeneficiaries', 'will_user_id'));
    }


    public function store_benificaries_death_backup(Request $request)
    {

        try {

            DB::beginTransaction();
            $beneficiary = Beneficiary::find($request->input('current_beneficiary_id'));
            $beneficiary->death_backup_plan = $request->input('selected_backup_option');
            $beneficiary->save();
            DB::commit();

            $beneficiaries = Beneficiary::where('will_user_id', $request->will_user_id)
                ->where('beneficiable_type', WillInheritedPeople::class)
                ->orderBy('id')
                ->get();


            $currentBeneficiaryIndex = $beneficiaries->search(function ($item) use ($beneficiary) {

                return $item->id == $beneficiary->id;
            });

            $nextBeneficiary = $beneficiaries->get($currentBeneficiaryIndex + 1);

            if ($nextBeneficiary) {

                return redirect()->route('partner.will_generator.benificaries_death_backup', ['beneficiary' => $nextBeneficiary, 'will_user_id' => $request->will_user_id]);
            } else {

                return redirect()->route('partner.will_generator.estate.summary', $request->will_user_id);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function estate_summary($will_user_id)
    {

        $beneficiaries = Beneficiary::where('will_user_id', $will_user_id)
            ->orderBy('id')
            ->get();

        return view('partner.will_generator.estate.summary', compact('beneficiaries', 'will_user_id'));
    }

    public function store_estate_summary(Request $request, $will_user_id)
    {
        try {
            $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();
            DB::beginTransaction();
            $will_estate_summary = WillUserEstates::create([
                'specific_person_will' => $request->input('excluded_choice'),
                'will_estate_reason' => $request->input('will_estate_reason'),
                'will_user_id' => $will_user_id,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()->route('partner.will_generator.create', $will_user_id)->with(['success' => 'Your Estate Summary has been submitted successfully']);
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
