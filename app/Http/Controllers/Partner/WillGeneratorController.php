<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Charity;
use App\Models\User;
use App\Models\Will_User_Info;
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
        $children = WillUserChildren::where('will_user_id', '=', session('will_user_id'))->get();
        return view('partner.will_generator.step4', ['children' => $children]);
    }

    public function store_step4(Request $request)
    {

        $will_user_id = WillUserInfo::where('id', '=', session('will_user_id'))
            ->update([
                'children' => $request->children,
            ]);
        return redirect()->route('partner.will_generator.step5');
    }
    public function step5()
    {
        $pets = WillUserPet::where('will_user_id', '=', session('will_user_id'))->get();
        return view('partner.will_generator.step5', ['pets' => $pets]);
    }
    public function store_step5(Request $request)
    {

        $will_user_id = WillUserInfo::where('id', '=', session('will_user_id'))
            ->update([
                'pets' => $request->pets,
            ]);
        return redirect()->route('partner.will_generator.create')->with(['success' => 'Your Personal Information has been submitted successfully']);
    }

    public function about_you()
    {
        $authId = auth()->id();
        return view('partner.will_generator.about_you', ['authId' => $authId]);
    }

    public function store_about_you(Request $request)
    {
        try {

            DB::beginTransaction();
            $will_user_id = WillUserInfo::create([
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
            session(['will_user_id' => $will_user_id->id]);
            return redirect()->route('partner.will_generator.step4');
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
                'will_user_id' => session('will_user_id'),
                'type' => 'child',
            ]);
            DB::commit();
            $children = WillInheritedPeople::where('will_user_id', '=', session('will_user_id'))->get();

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
            $children = WillInheritedPeople::where('will_user_id', '=', session('will_user_id'))->get();
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

            $children = WillInheritedPeople::where('will_user_id', '=', session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.children_list', ['children' => $children])->render();
            return response()->json(['status' => true, 'message' => 'Pet information deleted successfully', 'data' => $html]);
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
                'will_user_id' => session('will_user_id'),
                'type' => 'pet',
            ]);
            DB::commit();
            $pets = WillUserPet::where('will_user_id', '=', session('will_user_id'))->get();

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
            $pets = WillInheritedPeople::where('will_user_id', '=', session('will_user_id'))->get();
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

            $pets = WillInheritedPeople::where('will_user_id', '=', session('will_user_id'))->get();
            $html = view('partner.will_generator.ajax.pet_list', ['pets' => $pets])->render();
            return response()->json(['status' => true, 'message' => 'Pet information deleted successfully', 'data' => $html]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }



    public function account_properties()
    {
        $assets = WillUserAccountsProperty::all();
        return view('partner.will_generator.account_properties', compact('assets'));
    }
    public function submit_account_properties()
    {
        return redirect()->route('partner.will_generator.create')->with(['success' => 'Your Account Information has been submitted successfully']);
    }


    public function store_account_properties(Request $request)
    {
        try {
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
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


    public function executor()
    {
        return view('partner.will_generator.executor');
    }
    public function executor_step2()
    {
        return view('partner.will_generator.executor_step2');
    }
    public function executor_step3()
    {
        return view('partner.will_generator.executor_step3');
    }
    public function get_executor_step3(Request $request)
    {
        $executorType = $request->executor_type;
        $executors = WillInheritedPeople::get();
        if ($request->executor_type == "friends_family") {
            return view('partner.will_generator.family_friend', [
                'showProfessionalExecutors' => false,
                'selectedExecutorType' => $executorType, // Pass for potential pre-selection or logic
                'executors' => $executors // Pass for potential pre-selection or logic
            ]);
        } elseif ($request->executor_type == "farewill_trustees") {
            return redirect()->route('partner.will_generator.farewill_trustees');
        }
        else{
            return view('partner.will_generator.family_friend', [
                'showProfessionalExecutors' => true,
                'selectedExecutorType' => $executorType,
                'executors'=>$executors, // Pass for potential pre-selection or logic
            ]);
        }
    }
    public function family_friend()
    {
        $executors = WillInheritedPeople::get();
        return view('partner.will_generator.family_friend', compact('executors'));
    }
    public function farewill_trustees()
    {
        return view('partner.will_generator.farewill_trustees');
    }

    public function store_family_friend(Request $request)
    {
        try {
            DB::beginTransaction();
            $willUserInfo = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();

            $willUserInfo->beneficiaries()
                         ->where('beneficiable_type', WillInheritedPeople::class)
                         ->delete();

            $selectedFamilyFriendsIds = $request->input('family_friends', []);

            foreach ($selectedFamilyFriendsIds as $familyFriendId) {
                $familyFriend = WillInheritedPeople::findOrFail($familyFriendId);

                $willUserInfo->beneficiaries()->create([
                    'beneficiable_id' => $familyFriend->id,
                    'beneficiable_type' => get_class($familyFriend), // App\Models\FamilyFriend
                    'share_percentage' => 0.00, // Default, to be set in a later step
                ]);
            }

            DB::commit();

            // Redirect to the charity selection page
            if (url()->previous() && url()->previous() == route('partner.will_generator.choose_inherited_persons')) {
                return redirect()->route('partner.will_generator.choose_inherited_charity');
            } else {
                return redirect()->route('partner.will_generator.create')->with(['success' => 'Your Executors has been selected successfully']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    public function store_farewill_trustees(Request $request)
    {
        try {
            DB::beginTransaction();
            $will_user_id = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();
            $will_user_id->executors()->sync($request->executors);
            DB::commit();
            if (url()->previous() && url()->previous() == route('partner.will_generator.choose_inherited_persons')) {
                return redirect()->route('partner.will_generator.choose_inherited_charity');
            } else {

                return redirect()->route('partner.will_generator.create')->with(['success' => 'Your Executors has been selected successfully']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function your_estate()
    {
        return view('partner.will_generator.estate.your_estate');
    }
    public function choose_inherited_persons()
    {
        $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
        $executors = WillInheritedPeople::where('will_user_id', '=', $will_user_id)->get();
        return view('partner.will_generator.estate.choose_inherited_persons', compact('executors'));
    }
    public function choose_inherited_charity()
    {
        $executors = User::role('executor')->get();
        $charities=Charity::get();
        return view('partner.will_generator.estate.choose_inherited_charity', compact('executors','charities'));
    }

    public function process_inherited_charity(Request $request)
    {
        dd($request->all());
         $willUserInfo = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();

        DB::beginTransaction();
        try {
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
            return redirect()->route('partner.will_generator.allocate_percentages') // Create this route next
                             ->with('success', 'Charity beneficiaries saved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
    public function share_percentage()
    {
        $executors = User::role('executor')->get();
        return view('partner.will_generator.estate.share_percentage', compact('executors'));
    }
    public function gift()
    {

        $createdBy = Auth::id();
        $willUserId = null;


        $willUserInfo = WillUserInfo::where('user_id', $createdBy)->latest()->first();
        if ($willUserInfo) {
            $willUserId = $willUserInfo->id;
        }


        $physicalGifts = [];
        if ($willUserId) {
            $physicalGifts = WillUserInheritedGift::where('will_user_id', $willUserId)
                ->whereIn('gift_type', ['one-off', 'collection', 'vehicle', 'money'])
                ->get();
        }

        return view('partner.will_generator.gift', compact('physicalGifts'));
    }


    public function show_add_gift($type)
    {
        $executors = User::role('executor')->get();
        return view('partner.will_generator.gift_add', compact('type', 'executors'));
    }
    public function edit_add_gift($id)
    {
        try {
            $gift = WillUserInheritedGift::findOrFail($id);
            $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();

            if (is_null($willUserId) || $gift->will_user_id !== $willUserId->id) {
                return back()->with('error', 'Unauthorized access or gift not found.');
            }
            $executors = User::role('executor')->where('created_by', Auth::user()->id)->get();

            $selectedRecipientIds = explode(',', $gift->family_inherited_id);

            return view('partner.will_generator.gift_edit', compact('gift', 'executors', 'selectedRecipientIds'));
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred while trying to edit the gift: ' . $e->getMessage());
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

            return redirect()->route('partner.will_generator.gift')->with('success', 'Gift added successfully!');
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

            return redirect()->route('partner.will_generator.gift')->with('success', 'Gift updated successfully!');
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




    public function funeral()
    {
        $willUserId = WillUserInfo::where('id', session('will_user_id'))->first() ?? WillUserInfo::latest()->first();
        $funeralPlan = null;
        if ($willUserId) {
            $funeralPlan = WillUserFuneral::where('will_user_id', $willUserId)->first();
        }

        return view('partner.will_generator.funeral.funeral', compact('funeralPlan'));
    }

    public function store_funeral_plan(Request $request)
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
            return redirect()->route('partner.will_generator.create')->with('success', 'Funeral plan details saved successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()]);
        }
    }


    public function store_user_partner(Request $request){
        try{

            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            WillInheritedPeople::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'will_user_id' => $will_user_id,
                'type' => $request->type,
            ]);
            DB::commit();
            $partners=WillInheritedPeople::where('will_user_id',$will_user_id)->get();
            $html=view('partner.will_generator.ajax.partner_list',compact('partners'))->render();
            return response()->json(['status'=>true,'messsage'=>'Partner have been saved successfully','data'=>$html]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }

    }


    public function edit_user_partner(Request $request){
        try{
            $will_user_id = session('will_user_id') ?? WillUserInfo::latest()->first()->id;
            DB::beginTransaction();
            WillInheritedPeople::where('id',$request->id)
            ->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone_number,
                'email' => $request->email,
                'type' => $request->relationship,
            ]);
            DB::commit();
            $partners=WillInheritedPeople::where('will_user_id',$will_user_id)->get();

            $html=view('partner.will_generator.ajax.partner_list',compact('partners'))->render();
            return response()->json(['status'=>true,'messsage'=>'Partner have been updated successfully','data'=>$html]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }


    public function store_charity(Request $request){
        try{

            DB::beginTransaction();
            $charity=Charity::create([
                'name'=>$request->name,
                'registration_number'=>$request->registration_number,
                'logo_path'=>$request->logo_path,
            ]);
            DB::commit();
            $charities=Charity::get();
            $html=view('partner.will_generator.ajax.charity',compact('charities'))->render();
            return response()->json(['status'=>true,'message'=>'Charity store in database successfully','data'=>$html]);
        }
        catch(\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>false,'message'=>$e->getMessage()]);
        }
    }
}
