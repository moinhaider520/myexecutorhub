@extends('layouts.will_generator') {{-- Adjust your layout if different --}}

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Include Tailwind CSS if you haven't already --}}
<script src="https://cdn.tailwindcss.com"></script>

<style>
    /* General Layout */
    .container-fluid {
        padding: 1.5rem;
    }

    .card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Form Elements */
    .form-label {
        display: block;
        color: #2d3748;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #cbd5e0;
        border-radius: 0.375rem;
        font-size: 1rem;
        color: #2d3748;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-input:focus {
        border-color: #4299e1;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
    }

    textarea.form-input {
        min-height: 8rem;
        resize: vertical;
    }

    /* Radio Button Group */
    .radio-group-container {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .radio-option {
        background-color: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .radio-option:hover {
        background-color: #edf2f7;
        border-color: #a0aec0;
    }

    .radio-option.selected {
        background-color: #e6fffa;
        /* Light green/teal */
        border-color: #38b2ac;
        /* Darker green/teal */
        box-shadow: 0 0 0 2px rgba(56, 178, 172, 0.5);
    }

    .radio-option input[type="radio"] {
        display: none;
        /* Hide native radio button */
    }

    .radio-option label {
        display: block;
        cursor: pointer;
        font-weight: 500;
        color: #2d3748;
    }

    .radio-option .description {
        font-size: 0.875rem;
        color: #4a5568;
        margin-top: 0.25rem;
    }

    /* Bottom Navigation Buttons */
    .bottom-nav-buttons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 2rem;
        border-top: 1px solid #edf2f7;
        margin-top: 3rem;
    }

    .back-button {
        padding: 0.75rem 1.5rem;
        background-color: transparent;
        color: #4a5568;
        border: none;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .back-button:hover {
        background-color: #edf2f7;
    }

    .save-continue-button {
        padding: 0.75rem 2.5rem;
        border-radius: 0.375rem;
        background-color: #fbd38d;
        /* Yellow from screenshot */
        color: #2d3748;
        /* Dark text */
        font-weight: 600;
        font-size: 1rem;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        border: none;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    }

    .save-continue-button:hover {
        background-color: #f6ad55;
        /* Darker yellow on hover */
    }

    /* Related Articles Sidebar Styles */
    .related-articles-card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 1.5rem;
    }

    .related-articles-card h4 {
        font-weight: 700;
        margin-bottom: 1rem;
        color: #2d3748;
    }

    .related-articles-card ul li {
        padding: 0.5rem 0;
        border-bottom: 1px solid #edf2f7;
    }

    .related-articles-card ul li:last-child {
        border-bottom: none;
    }

    .related-articles-card ul li a {
        color: #4299e1;
        text-decoration: none;
        font-size: 0.95rem;
    }

    .related-articles-card ul li a:hover {
        text-decoration: underline;
    }
</style>

<div class="container-fluid default-dashboard">
    <div class="row widget-grid">
        <div class="col-xl-8"> 
            <div class="card height-equal">
                <form method="POST" action="{{ route('partner.will_generator.store_funeral_plan') }}">
                    @csrf
                    <input type="hidden" name="will_user_id" value="{{ $will_user_id }}">
                    <div class="card-body basic-wizard important-validation">
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                            Do you have a pre-paid funeral plan?
                        </h1>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            A funeral plan means you've arranged and paid for your funeral upfront.
                        </p>
                        <div class="mb-6">
                            <div class="radio-group-container">
                                <div class="radio-option" data-value="yes">
                                    <input type="radio" id="prePaidPlanYes" name="pre_paid_plan" value="yes"
                                        {{ old('pre_paid_plan', $funeralPlan->funeral_paid ?? '') == 'yes' ? 'checked' : '' }}>
                                    <label for="prePaidPlanYes">Yes</label>
                                </div>
                                <div class="radio-option" data-value="no">
                                    <input type="radio" id="prePaidPlanNo" name="pre_paid_plan" value="no"
                                        {{ old('pre_paid_plan', $funeralPlan->funeral_paid ?? '') == 'no' ? 'checked' : '' }}>
                                    <label for="prePaidPlanNo">No</label>
                                </div>
                            </div>
                            @error('pre_paid_plan')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Conditional: Your funeral plan details (if pre_paid_plan is 'yes') --}}
                        <div id="funeralPlanDetails" class="hidden">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                Your funeral plan details
                            </h2>
                            <p class="text-gray-700 leading-relaxed mb-6">
                                If you have a funeral plan in place, it's a good idea to include it in your
                                will so you can make sure your family knows about it.
                            </p>
                            <div class="mb-4">
                                <label for="funeralProviderName" class="form-label">Funeral plan provider</label>
                                <p class="text-gray-600 text-sm mb-2">The name of the company you bought the funeral plan from</p>
                                <input type="text" id="funeralProviderName" name="funeral_provider_name" class="form-input"
                                    value="{{ old('funeral_provider_name', $funeralPlan->funeral_provider_name ?? '') }}" placeholder="e.g. Farewill Funerals">
                                @error('funeral_provider_name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="mb-6">
                                <label for="funeralIdentificationNo" class="form-label">Funeral plan number (optional)</label>
                                <p class="text-gray-600 text-sm mb-2">Any identification you were given for your funeral plan</p>
                                <input type="text" id="funeralIdentificationNo" name="funeral_identification_no" class="form-input"
                                    value="{{ old('funeral_identification_no', $funeralPlan->funeral_identification_no ?? '') }}" placeholder="e.g. 123456789">
                                @error('funeral_identification_no')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Conditional: Would you like a free funeral plans guide? (if pre_paid_plan is 'no') --}}
                        <div id="funeralGuideWishSection" class="hidden">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                Would you like a free funeral plans guide?
                            </h2>
                            <p class="text-gray-700 leading-relaxed mb-6">
                                Even if you're not ready to set up a plan just yet, we can send you our
                                free guide and keep you up to date with any tips, discounts and news
                                from Farewill Funerals in the future.
                                <br><br>
                                As a Farewill customer, you will also receive &pound;150 off your funeral plan.
                            </p>
                            <div class="mb-6">
                                <div class="radio-group-container">
                                    <div class="radio-option" data-value="yes">
                                        <input type="radio" id="funeralGuideYes" name="funeral_guide_wish" value="yes"
                                            {{ old('funeral_guide_wish', $funeralPlan->funeral_wish ?? '') == 'yes' ? 'checked' : '' }}>
                                        <label for="funeralGuideYes">Yes</label>
                                    </div>
                                    <div class="radio-option" data-value="no">
                                        <input type="radio" id="funeralGuideNo" name="funeral_guide_wish" value="no"
                                            {{ old('funeral_guide_wish', $funeralPlan->funeral_wish ?? '') == 'no' ? 'checked' : '' }}>
                                        <label for="funeralGuideNo">No</label>
                                    </div>
                                </div>
                                @error('funeral_guide_wish')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200"> {{-- Separator --}}

                        {{-- 2. Would you like to include funeral wishes in your will? --}}
                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                            Would you like to include funeral wishes in your will?
                        </h2>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            Although it's not legally binding, letting the people close to you know
                            what you'd like for your funeral, can help them make decisions in the
                            future.
                            <br><br>
                            You can include:
                        <ul class="list-disc list-inside text-gray-700 mb-6">
                            <li>What type of funeral you would like</li>
                            <li>How you would you like to be remembered</li>
                        </ul>
                        </p>
                        <div class="mb-6">
                            <div class="radio-group-container">
                                <div class="radio-option" data-value="yes">
                                    <input type="radio" id="includeWishesYes" name="include_funeral_wishes" value="yes"
                                        {{ old('include_funeral_wishes', ($funeralPlan && in_array($funeralPlan->funeral_type, ['cremation', 'burial', 'let_decide'])) ? 'yes' : '') == 'yes' ? 'checked' : '' }}>
                                    <label for="includeWishesYes">Yes</label>
                                </div>
                                <div class="radio-option" data-value="no">
                                    <input type="radio" id="includeWishesNo" name="include_funeral_wishes" value="no"
                                        {{ old('include_funeral_wishes', ($funeralPlan && $funeralPlan->funeral_type == 'no_wishes_not_included') ? 'no' : '') == 'no' ? 'checked' : '' }}>
                                    <label for="includeWishesNo">No</label>
                                </div>
                            </div>
                            @error('include_funeral_wishes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Conditional: What type of funeral would you like? (if include_funeral_wishes is 'yes') --}}
                        <div id="funeralTypeSection" class="hidden">
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                What type of funeral would you like?
                            </h2>
                            <div class="mb-6">
                                <div class="radio-group-container">
                                    <div class="radio-option" data-value="cremation">
                                        <input type="radio" id="funeralTypeCremation" name="funeral_type_choice" value="cremation"
                                            {{ old('funeral_type_choice', $funeralPlan->funeral_type ?? '') == 'cremation' ? 'checked' : '' }}>
                                        <label for="funeralTypeCremation">Cremation</label>
                                    </div>
                                    <div class="radio-option" data-value="burial">
                                        <input type="radio" id="funeralTypeBurial" name="funeral_type_choice" value="burial"
                                            {{ old('funeral_type_choice', $funeralPlan->funeral_type ?? '') == 'burial' ? 'checked' : '' }}>
                                        <label for="funeralTypeBurial">Burial</label>
                                    </div>
                                    <div class="radio-option" data-value="let_decide">
                                        <input type="radio" id="funeralTypeLetDecide" name="funeral_type_choice" value="let_decide"
                                            {{ old('funeral_type_choice', $funeralPlan->funeral_type ?? '') == 'let_decide' ? 'checked' : '' }}>
                                        <label for="funeralTypeLetDecide">Let the people responsible for my estate decide</label>
                                    </div>
                                </div>
                                @error('funeral_type_choice')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Conditional: Direct cremation wish (if funeral_type_choice is 'cremation') --}}
                            <div id="directCremationSection" class="hidden">
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                                    Would you like to suggest a Farewill direct cremation in your will?
                                </h2>
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    A direct cremation is a cremation without a service at the crematorium.
                                    By cutting out the extra fuss they can save families thousands.
                                </p>
                                <div class="mb-6">
                                    <div class="radio-group-container">
                                        <div class="radio-option" data-value="yes">
                                            <input type="radio" id="directCremationYes" name="direct_cremation_wish" value="yes"
                                                {{ old('direct_cremation_wish', $funeralPlan->funeral_direct_cremation ?? '') == 'yes' ? 'checked' : '' }}>
                                            <label for="directCremationYes">Yes</label>
                                        </div>
                                        <div class="radio-option" data-value="no">
                                            <input type="radio" id="directCremationNo" name="direct_cremation_wish" value="no"
                                                {{ old('direct_cremation_wish', $funeralPlan->funeral_direct_cremation ?? '') == 'no' ? 'checked' : '' }}>
                                            <label for="directCremationNo">No</label>
                                        </div>
                                    </div>
                                    @error('direct_cremation_wish')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="my-8 border-gray-200"> {{-- Separator --}}

                        {{-- 3. Do you have any additional wishes for your funeral? --}}
                        <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                            Do you have any additional wishes for your funeral?
                        </h2>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            This can be anything you like, from music and religious preferences, to
                            firework displays and fancy dress.
                            <br><br>
                            You could think about:
                        <ul class="list-disc list-inside text-gray-700 mb-6">
                            <li>Where you'd like it to take place</li>
                            <li>What you'd like people to do in your memory</li>
                            <li>Where you'd like your final resting place to be</li>
                        </ul>
                        Expressing your wishes aren't legally binding, but they can be very
                        helpful for the people close to you.
                        </p>
                        <div class="mb-6">
                            <label for="additionalWishes" class="form-label">Your wishes (Optional)</label>
                            <textarea id="additionalWishes" name="additional_wishes" class="form-input" rows="4" placeholder="e.g. I would like my ashes scattered... ">{{ old('additional_wishes', $funeralPlan->additional ?? '') }}</textarea>
                            @error('additional_wishes')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Bottom Navigation --}}
                        <div class="bottom-nav-buttons">
                            <button type="button" class="back-button" onclick="history.back()">
                                &larr; Back
                            </button>
                            <button type="submit" class="save-continue-button">
                                Save and continue
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-xl-4"> {{-- Sidebar area --}}
            <div class="related-articles-card">
                <h4>Related articles</h4>
                <ul>
                    <li><a href="#" class="text-blue-600 hover:underline">Arranging a funeral</a></li>
                    <li><a href="#" class="text-blue-600 hover:underline">Funeral costs</a></li>
                    {{-- More related articles would go here --}}
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Radio button groups
        const prePaidPlanRadios = $('input[name="pre_paid_plan"]');
        const includeWishesRadios = $('input[name="include_funeral_wishes"]');
        const funeralTypeRadios = $('input[name="funeral_type_choice"]');
        const directCremationRadios = $('input[name="direct_cremation_wish"]');
        const funeralGuideRadios = $('input[name="funeral_guide_wish"]');

        // Conditional sections
        const funeralPlanDetails = $('#funeralPlanDetails');
        const funeralGuideWishSection = $('#funeralGuideWishSection');
        const funeralTypeSection = $('#funeralTypeSection');
        const directCremationSection = $('#directCremationSection');

        // Function to update visibility of all sections based on current selections
        function updateAllVisibility() {
            const selectedPrePaidPlan = prePaidPlanRadios.filter(':checked').val();
            const selectedIncludeWishes = includeWishesRadios.filter(':checked').val();
            const selectedFuneralType = funeralTypeRadios.filter(':checked').val();

            // 1. Pre-paid funeral plan section
            if (selectedPrePaidPlan === 'yes') {
                funeralPlanDetails.removeClass('hidden');
                funeralGuideWishSection.addClass('hidden');
            } else if (selectedPrePaidPlan === 'no') {
                funeralPlanDetails.addClass('hidden');
                funeralGuideWishSection.removeClass('hidden');
            } else {
                funeralPlanDetails.addClass('hidden');
                funeralGuideWishSection.addClass('hidden');
            }

            // 2. Include funeral wishes section
            if (selectedIncludeWishes === 'yes') {
                funeralTypeSection.removeClass('hidden');
                if (selectedFuneralType === 'cremation') {
                    directCremationSection.removeClass('hidden');
                } else {
                    directCremationSection.addClass('hidden');
                }
            } else {
                funeralTypeSection.addClass('hidden');
                directCremationSection.addClass('hidden');
            }

            // Ensure direct cremation is hidden if funeral type changes from cremation
            if (selectedFuneralType !== 'cremation') {
                directCremationSection.addClass('hidden');
            }
        }

        // Function to apply selected class to radio option containers
        function applyRadioSelectionStyling() {
            $('.radio-group-container input[type="radio"]').each(function() {
                if ($(this).is(':checked')) {
                    $(this).closest('.radio-option').addClass('selected');
                } else {
                    $(this).closest('.radio-option').removeClass('selected');
                }
            });
        }

        // Initial visibility and styling on page load
        updateAllVisibility();
        applyRadioSelectionStyling();

        // Event listener for the radio option containers
        // This is the core change for better responsiveness
        $('.radio-option').on('click', function() {
            // Find the radio button inside the clicked div and check it
            const radioInput = $(this).find('input[type="radio"]');
            if (radioInput.length) {
                radioInput.prop('checked', true);
            }
            // Now, apply styling and update visibility based on the new state
            applyRadioSelectionStyling();
            updateAllVisibility();
        });

        // Event listeners on the radios themselves for programatic changes
        prePaidPlanRadios.on('change', updateAllVisibility);
        includeWishesRadios.on('change', updateAllVisibility);
        funeralTypeRadios.on('change', updateAllVisibility);
        directCremationRadios.on('change', updateAllVisibility);
        funeralGuideRadios.on('change', updateAllVisibility);

        // Handle form submission with SweetAlert
        $('form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            Swal.fire({
                icon: 'info',
                title: 'Saving Funeral Plan...',
                text: 'Your funeral plan details are being saved.',
                showConfirmButton: false,
                timer: 1500,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            }).then(() => {
                this.submit();
            });
        });
    });
</script>
@endsection