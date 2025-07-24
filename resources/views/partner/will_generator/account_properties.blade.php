@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .hidden {
    display: none !important; /* !important is often needed to override framework defaults */
}

        .form-group.radio-group label {
            display: inline-flex;
            align-items: center;
            margin-right: 15px;
            font-weight: normal;
        }
        .form-group.radio-group input[type="radio"] {
            margin-right: 5px;
            width: auto; /* Override full width if Tailwind applies it */
            vertical-align: middle; /* Align radio button with text */
        }
        .modal-body .form-group label {
            font-weight: 600; /* Make modal labels slightly bolder */
            color: #333;
            margin-bottom: 5px;
        }
        .modal-body input[type="text"],
        .modal-body input[type="number"],
        .modal-body select {
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            padding: 0.5rem 0.75rem;
            width: 100%;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }
        .modal-body select {
            background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23000%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13%205.4l-118.2%20118.2L16.2%2074.8a17.6%2017.6%200%200%200-24.8%2024.8l130.4%20130.4a17.6%2017.6%200%200%200%2024.8%200L292.4%2094.2a17.6%2017.6%200%200%200-5.4-24.8z%22%2F%3E%3C%2Fsvg%3E');
            background-repeat: no-repeat;
            background-position: right 10px center;
            background-size: 12px;
            padding-right: 30px;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .modal-body .form-control:focus {
            border-color: #80bdff;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
    </style>
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    {{-- Main Content Column --}}
                    <div class="col-xl-8"> {{-- Adjust column width as needed (e.g., col-xl-8) --}}
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Account and Properties</h4>
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form id="msform" class="needs-validation" novalidate
                                    action="{{ route('partner.will_generator.store_step4') }}" method="POST">
                                    @csrf
                                    <script src="https://cdn.tailwindcss.com"></script> {{-- Consider moving this to your main layout if used globally --}}
                                    <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                        <div class="col-sm-12">

                                            <h1 id="childrenQuestion" {{-- Rename ID for clarity --}}
                                                class="text-2xl sm:text-2xl font-bold text-gray-800 mb-4">
                                                List your accounts and property
                                            </h1>
                                            <p class="text-gray-600 mb-2">
                                                This includes bank accounts, pensions, property and life insurance policies.
                                                It helps your executors, the people who will deal with your estate after you
                                                die, know which providers to contact.
                                            </p>

                                            <p class="text-gray-600 mb-6">
                                                We will not ask for specific details like account numbers.
                                            </p>

                                            <div class="space-y-4 mb-8">
                                                {{-- The hidden input for 'children' is likely vestigial if moving to assets --}}
                                                {{-- <input type="hidden" name="children" id="children"> --}}
                                            </div>

                                            {{-- This section will show your assets, not children --}}
                                            <div id="existingAssetsList"> {{-- Renamed ID from childrenContentWrapper / existingChildrenList --}}
                                                @forelse ($assets as $asset)
                                                    {{-- Assuming $assets now contains actual asset data --}}
                                                    <div id="assetDetailItem-{{ $asset->id }}"
                                                        class="asset-detail-item bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-8">
                                                        <div class="flex justify-between items-center">
                                                            <div>
                                                                {{-- Display actual asset details here --}}
                                                                <p class="font-semibold text-gray-900">
                                                                    {{ @$asset->account_name ?? (@$asset->property_address ?? 'Unnamed Asset') }}
                                                                </p>
                                                                <p class="text-sm text-gray-600">
                                                                    {{ @$asset->type ?? 'Type not specified' }} - Value:
                                                                    {{ @$asset->value ?? 'N/A' }}
                                                                </p>
                                                            </div>
                                                            <button type="button" data-toggle="modal"
                                                                data-target="#editWillAssetModal" {{-- Renamed modal target --}}
                                                                data-id="{{ $asset->id }}"
                                                                data-name="{{ @$asset->account_name }}"
                                                                data-type="{{ @$asset->type }}"
                                                                data-value="{{ @$asset->value }}"
                                                                class="edit_asset_button text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    stroke-linecap="round" stroke-linejoin="round"
                                                                    class="inline-block mr-1">
                                                                    <path
                                                                        d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                                                                    </path>
                                                                    <path
                                                                        d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z">
                                                                    </path>
                                                                </svg>
                                                                Edit details
                                                            </button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    {{-- Message if no assets are added yet --}}
                                                    <p class="text-gray-500 text-center py-4">No accounts or properties
                                                        added yet.</p>
                                                @endforelse
                                            </div>

                                            {{-- Add Account/Property Button --}}
                                            <div id="">
                                                <button type="button"
                                                    class="w-full py-3 px-4 bg-white border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-700 transition-all duration-200 flex items-center justify-center"
                                                    data-toggle="modal" data-target="#addWillAssetModal">
                                                    {{-- Renamed modal target --}}
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="inline-block mr-2">
                                                        <line x1="12" y1="5" x2="12" y2="19">
                                                        </line>
                                                        <line x1="5" y1="12" x2="19" y2="12">
                                                        </line>
                                                    </svg>
                                                    Add account or property
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <button class="btn btn-warning btn-lg" id="saveAndContinueButton">Save and continue</button>
                                    </div>
                                    {{-- Removed the original wizard-footer with Back/Next buttons --}}
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Related Articles Column --}}
                    <div class="col-xl-4"> {{-- Adjust column width as needed (e.g., col-xl-4) --}}
                        <div class="card"> {{-- You might want to style this card differently --}}
                            <div class="card-header">
                                <h4>Related articles</h4>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><a href="#" class="text-blue-600 hover:underline">How to avoid
                                            inheritance tax</a></li>
                                    <li><a href="#" class="text-blue-600 hover:underline">How to update or amend your
                                            will</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- Save and continue button outside the form, or within if you want to submit the form --}}
        {{-- If you want this button to submit the form above, make it type="submit" and place it inside the form. --}}
        {{-- If it navigates to the next step via JS, keep it separate and handle the navigation. --}}

    </div>

    {{-- Add Asset Modal --}}
    <div class="modal fade" id="addWillAssetModal" tabindex="-1" role="dialog" aria-labelledby="addWillAssetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="addWillAssetModalLabel">Add new account or property</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form id="addWillAssetForm">
            @csrf
            <div class="modal-body">
                <div class="form-group mb-3">
                    <label for="add_asset_type_select">Asset type</label>
                    <select class="form-control" id="add_asset_type_select" name="asset_type">
                        <option value="select">Select...</option>
                        <option value="bankAccount">Bank account</option>
                        <option value="pension">Pension</option>
                        <option value="lifeInsurance">Life insurance</option>
                        <option value="stocksAndShares">Stocks and shares</option>
                        <option value="property">Property</option>
                        <option value="other">Other</option>
                    </select>
                    <div class="text-danger" id="error-add_asset_type"></div>
                </div>

                <div id="addBankAccountFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_bank_name">Bank name</label>
                        <input type="text" class="form-control" name="bank_name" id="add_bank_name" placeholder="e.g. HSBC">
                        <div class="text-danger" id="error-add_bank_name"></div>
                    </div>
                </div>

                <div id="addPensionFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_pension_provider">Provider</label>
                        <input type="text" class="form-control" name="pension_provider" id="add_pension_provider" placeholder="e.g. Aviva">
                        <div class="text-danger" id="error-add_pension_provider"></div>
                    </div>
                </div>

                <div id="addLifeInsuranceFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_life_insurance_provider">Provider</label>
                        <input type="text" class="form-control" name="life_insurance_provider" id="add_life_insurance_provider" placeholder="e.g. Legal & General">
                        <div class="text-danger" id="error-add_life_insurance_provider"></div>
                    </div>
                </div>

                <div id="addStocksAndSharesFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_company_name">Company name</label>
                        <input type="text" class="form-control" name="company_name" id="add_company_name" placeholder="e.g. Invesco">
                        <div class="text-danger" id="error-add_company_name"></div>
                    </div>
                </div>

                <div id="addPropertyFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_property_address">Address</label>
                        <input type="text" class="form-control" name="property_address" id="add_property_address" placeholder="e.g. 27 Downham Road, London, N1 5AA">
                        <div class="text-danger" id="error-add_property_address"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Does this property have a mortgage?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="has_mortgage" value="yes" required> Yes</label>
                            <label><input type="radio" name="has_mortgage" value="no"> No</label>
                            <label><input type="radio" name="has_mortgage" value="unknown"> I don't know</label>
                        </div>
                        <div class="text-danger" id="error-add_has_mortgage"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Who owns this property?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="ownership_type" value="sole" required> I am the only owner</label>
                            <label><input type="radio" name="ownership_type" value="joint"> I own it jointly with someone else</label>
                            <label><input type="radio" name="ownership_type" value="unknown"> I don't know</label>
                        </div>
                        <div class="text-danger" id="error-add_ownership_type"></div>
                    </div>
                </div>

                <div id="addOtherFields" class="asset-fields-modal hidden">
                    <div class="form-group mb-3">
                        <label for="add_other_description">Description</label>
                        <input type="text" class="form-control" name="other_description" id="add_other_description" placeholder="e.g. Money under the mattress">
                        <div class="text-danger" id="error-add_other_description"></div>
                    </div>
                </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" id="saveAssetButton">Save asset</button>
            </div>
        </form>
    </div>
</div>
    </div>

    {{-- Edit Asset Modal (similar structure, populate values on edit button click) --}}
    <div class="modal fade" id="editWillAssetModal" tabindex="-1" role="dialog" aria-labelledby="editWillAssetModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editWillAssetModalLabel">Edit Account or Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editWillAssetForm">
                    @csrf
                    <input type="hidden" name="asset_id" id="edit_asset_id">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="edit_asset_type_select">Asset type</label>
                            <select class="form-control" id="edit_asset_type_select" name="asset_type">
                                <option value="select">Select...</option>
                                <option value="bankAccount">Bank account</option>
                                <option value="pension">Pension</option>
                                <option value="lifeInsurance">Life insurance</option>
                                <option value="stocksAndShares">Stocks and shares</option>
                                <option value="property">Property</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="text-danger" id="error-edit_asset_type"></div>
                        </div>

                        <div id="editBankAccountFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_bank_name">Bank name</label>
                                <input type="text" class="form-control" name="bank_name" id="edit_bank_name" placeholder="e.g. HSBC">
                                <div class="text-danger" id="error-edit_bank_name"></div>
                            </div>
                        </div>

                        <div id="editPensionFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_pension_provider">Provider</label>
                                <input type="text" class="form-control" name="pension_provider" id="edit_pension_provider" placeholder="e.g. Aviva">
                                <div class="text-danger" id="error-edit_pension_provider"></div>
                            </div>
                        </div>

                        <div id="editLifeInsuranceFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_life_insurance_provider">Provider</label>
                                <input type="text" class="form-control" name="life_insurance_provider" id="edit_life_insurance_provider" placeholder="e.g. Legal & General">
                                <div class="text-danger" id="error-edit_life_insurance_provider"></div>
                            </div>
                        </div>

                        <div id="editStocksAndSharesFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_company_name">Company name</label>
                                <input type="text" class="form-control" name="company_name" id="edit_company_name" placeholder="e.g. Invesco">
                                <div class="text-danger" id="error-edit_company_name"></div>
                            </div>
                        </div>

                        <div id="editPropertyFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_property_address">Address</label>
                                <input type="text" class="form-control" name="property_address" id="edit_property_address" placeholder="e.g. 27 Downham Road, London, N1 5AA">
                                <div class="text-danger" id="error-edit_property_address"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Does this property have a mortgage?</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="edit_has_mortgage" value="yes" required> Yes</label>
                                    <label><input type="radio" name="edit_has_mortgage" value="no"> No</label>
                                    <label><input type="radio" name="edit_has_mortgage" value="unknown"> I don't know</label>
                                </div>
                                <div class="text-danger" id="error-edit_has_mortgage"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Who owns this property?</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="edit_ownership_type" value="sole" required> I am the only owner</label>
                                    <label><input type="radio" name="edit_ownership_type" value="joint"> I own it jointly with someone else</label>
                                    <label><input type="radio" name="edit_ownership_type" value="unknown"> I don't know</label>
                                </div>
                                <div class="text-danger" id="error-edit_ownership_type"></div>
                            </div>
                        </div>

                        <div id="editOtherFields" class="asset-fields-modal hidden">
                            <div class="form-group mb-3">
                                <label for="edit_other_description">Description</label>
                                <input type="text" class="form-control" name="other_description" id="edit_other_description" placeholder="e.g. Money under the mattress">
                                <div class="text-danger" id="error-edit_other_description"></div>
                            </div>
                        </div>

                        {{-- Common Optional Value Field --}}
                        <div class="form-group mb-3">
                            <label for="edit_asset_value">Estimated Value (Optional)</label>
                            <input type="number" class="form-control" name="asset_value" id="edit_asset_value"
                                placeholder="Enter Estimated Value" min="0">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deleteAssetButton">Remove Item</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="updateAssetButton">Update changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    $(document).ready(function() {
    // CSRF Token Setup (already good)
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    // Function to clear all dynamic field errors for "Add" modal (already good)
    function clearAddErrors() {
        $('#addWillAssetForm .text-danger').text('');
    }

    // Function to clear all dynamic field errors for "Edit" modal (already good)
    function clearEditErrors() {
        $('#editWillAssetForm .text-danger').text('');
    }

    // --- Asset Field Toggling Logic (CONSOLIDATED AND CORRECTED) ---
    // Get the select element as a jQuery object
    const assetTypeSelect = $('#add_asset_type_select');

    // Get all the specific field containers by their IDs as jQuery objects
    const addBankAccountFields = $('#addBankAccountFields');
    const addPensionFields = $('#addPensionFields');
    const addLifeInsuranceFields = $('#addLifeInsuranceFields');
    const addStocksAndSharesFields = $('#addStocksAndSharesFields');
    const addPropertyFields = $('#addPropertyFields');
    const addOtherFields = $('#addOtherFields');

    // Get the container for the Estimated Value field as a jQuery object
    const addAssetValueFieldContainer = $('#addAssetValueFieldContainer');

    function toggleAssetFields() {
        const selectedValue = assetTypeSelect.val(); // Use .val() for jQuery object


        // Hide all asset-specific field containers using .addClass('hidden')
        addBankAccountFields.addClass('hidden');
        addPensionFields.addClass('hidden');
        addLifeInsuranceFields.addClass('hidden');
        addStocksAndSharesFields.addClass('hidden');
        addPropertyFields.addClass('hidden');
        addOtherFields.addClass('hidden');

        // Hide the Estimated Value field by default
        if (addAssetValueFieldContainer.length) { // Check if the jQuery object found an element
            addAssetValueFieldContainer.addClass('hidden');
        }

        // Show the relevant container(s) based on the selected value using .removeClass('hidden')
        if (selectedValue === 'bankAccount') {
            addBankAccountFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        } else if (selectedValue === 'pension') {
            addPensionFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        } else if (selectedValue === 'lifeInsurance') {
            addLifeInsuranceFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        } else if (selectedValue === 'stocksAndShares') {
            addStocksAndSharesFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        } else if (selectedValue === 'property') {
            addPropertyFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        } else if (selectedValue === 'other') {
            addOtherFields.removeClass('hidden');
            if (addAssetValueFieldContainer.length) addAssetValueFieldContainer.removeClass('hidden');
        }
    }

    // Attach the event listener to the dropdown using jQuery's .on()
    assetTypeSelect.on('change', toggleAssetFields);

    // Initial call to set the correct state when the page loads
    // This will trigger the alert and hide fields correctly
    toggleAssetFields();

    // --- Bootstrap Modal Show Event ---
    // This is already using jQuery, so it's good.
    $('#addWillAssetModal').on('show.bs.modal', function () {
        // Reset the dropdown to "Select..."
        assetTypeSelect.val('select'); // Use .val() for jQuery object
        // Trigger the change handler to hide all fields
        toggleAssetFields(); // This will also trigger the alert
        // Clear any previous input values within the form
        $('#addWillAssetForm')[0].reset(); // Still need [0] to get the native DOM element for .reset()
        // Clear previous error messages
        clearAddErrors(); // Using your defined function
    });

    // --- Add Asset Form Submission (already good) ---
    $('#addWillAssetForm').on('submit', function(e) {
        e.preventDefault();
        clearAddErrors();

        const assetType = $('#add_asset_type_select').val();
        let postData = {
            _token: csrfToken,
            asset_type: assetType,
            asset_value: $('#add_asset_value').val()
        };

        // Add specific fields based on asset type
        switch (assetType) {
            case 'bankAccount':
                postData.bank_name = $('#add_bank_name').val();
                break;
            case 'pension':
                postData.pension_provider = $('#add_pension_provider').val();
                break;
            case 'lifeInsurance':
                postData.life_insurance_provider = $('#add_life_insurance_provider').val();
                break;
            case 'stocksAndShares':
                postData.company_name = $('#add_company_name').val();
                break;
            case 'property':
                postData.property_address = $('#add_property_address').val();
                postData.has_mortgage = $('input[name="has_mortgage"]:checked').val();
                postData.ownership_type = $('input[name="ownership_type"]:checked').val();
                break;
            case 'other':
                postData.other_description = $('#add_other_description').val();
                break;
        }

                $.ajax({
                    url: "#", // !!! IMPORTANT: Define this route in web.php
                    method: 'POST',
                    data: postData,
                    dataType: 'json',
                    success: function(response) {
                        $('#addWillAssetModal').modal('hide');
                        $('#existingAssetsList').html(response.data); // Assuming response.data is the rendered HTML list of assets
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 419) {
                            alert(
                                'Your session has expired or the security token is invalid. Please refresh the page and try again.'
                            );
                            location.reload();
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            // Display errors for each specific field
                            if (errors.asset_type) { $('#error-add_asset_type').text(errors.asset_type); }
                            if (errors.bank_name) { $('#error-add_bank_name').text(errors.bank_name); }
                            if (errors.pension_provider) { $('#error-add_pension_provider').text(errors.pension_provider); }
                            if (errors.life_insurance_provider) { $('#error-add_life_insurance_provider').text(errors.life_insurance_provider); }
                            if (errors.company_name) { $('#error-add_company_name').text(errors.company_name); }
                            if (errors.property_address) { $('#error-add_property_address').text(errors.property_address); }
                            if (errors.has_mortgage) { $('#error-add_has_mortgage').text(errors.has_mortgage); }
                            if (errors.ownership_type) { $('#error-add_ownership_type').text(errors.ownership_type); }
                            if (errors.other_description) { $('#error-add_other_description').text(errors.other_description); }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            }
                            alert(errorMessage);
                            console.error("AJAX Error:", jqXHR);
                        }
                    }
                });
            });

            // --- Populate Edit Modal ---
            $(document).on('click', '.edit_asset_button', function() {
                clearEditErrors();
                const id = $(this).data('id');
                // You'll need to fetch the full asset data from the server using the ID
                // to populate all specific fields, as the current data attributes are limited.
                // For demonstration, I'm using the limited data attributes you provided.
                // In a real application, you'd make an AJAX call here:
                // $.ajax({
                //     url: `/api/assets/${id}`, // Example API route
                //     method: 'GET',
                //     success: function(assetData) {
                //         populateEditModal(assetData);
                //     }
                // });

                // Dummy data for demonstration based on existing data attributes:
                const name = $(this).data('name');
                const type = $(this).data('type');
                const value = $(this).data('value');

                $('#edit_asset_id').val(id);
                $('#edit_asset_type_select').val(type).trigger('change'); // Set type and trigger change

                // Populate specific fields based on dummy type and name (needs refinement for real data)
                switch (type) {
                    case 'bankAccount':
                        $('#edit_bank_name').val(name); // Assuming 'name' holds the bank name
                        break;
                    case 'pension':
                        $('#edit_pension_provider').val(name); // Assuming 'name' holds the provider
                        break;
                    case 'lifeInsurance':
                        $('#edit_life_insurance_provider').val(name); // Assuming 'name' holds the provider
                        break;
                    case 'stocksAndShares':
                        $('#edit_company_name').val(name); // Assuming 'name' holds the company name
                        break;
                    case 'property':
                        $('#edit_property_address').val(name); // Assuming 'name' holds the address
                        // For radio buttons, you'd need actual data:
                        // $('input[name="edit_has_mortgage"][value="' + assetData.has_mortgage + '"]').prop('checked', true);
                        // $('input[name="edit_ownership_type"][value="' + assetData.ownership_type + '"]').prop('checked', true);
                        break;
                    case 'other':
                        $('#edit_other_description').val(name); // Assuming 'name' holds the description
                        break;
                }
                $('#edit_asset_value').val(value);
            });

            // --- Update Asset ---
            $('#editWillAssetForm').on('submit', function(e) {
                e.preventDefault();
                clearEditErrors();

                const assetId = $('#edit_asset_id').val();
                const assetType = $('#edit_asset_type_select').val();
                let postData = {
                    _token: csrfToken,
                    id: assetId,
                    asset_type: assetType,
                    asset_value: $('#edit_asset_value').val()
                };

                // Add specific fields based on asset type for update
                switch (assetType) {
                    case 'bankAccount':
                        postData.bank_name = $('#edit_bank_name').val();
                        break;
                    case 'pension':
                        postData.pension_provider = $('#edit_pension_provider').val();
                        break;
                    case 'lifeInsurance':
                        postData.life_insurance_provider = $('#edit_life_insurance_provider').val();
                        break;
                    case 'stocksAndShares':
                        postData.company_name = $('#edit_company_name').val();
                        break;
                    case 'property':
                        postData.property_address = $('#edit_property_address').val();
                        postData.has_mortgage = $('input[name="edit_has_mortgage"]:checked').val();
                        postData.ownership_type = $('input[name="edit_ownership_type"]:checked').val();
                        break;
                    case 'other':
                        postData.other_description = $('#edit_other_description').val();
                        break;
                }

                $.ajax({
                    url: "#", // !!! IMPORTANT: Define this route in web.php
                    method: 'POST', // Or PUT/PATCH if your route definition uses it
                    data: postData,
                    dataType: 'json',
                    success: function(response) {
                        $('#editWillAssetModal').modal('hide');
                        $('#existingAssetsList').html(response.data);
                    },
                    error: function(jqXHR) {
                        if (jqXHR.status === 419) {
                            alert(
                                'Your session has expired or the security token is invalid. Please refresh the page and try again.'
                            );
                            location.reload();
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            if (errors.asset_type) { $('#error-edit_asset_type').text(errors.asset_type); }
                            if (errors.bank_name) { $('#error-edit_bank_name').text(errors.bank_name); }
                            if (errors.pension_provider) { $('#error-edit_pension_provider').text(errors.pension_provider); }
                            if (errors.life_insurance_provider) { $('#error-edit_life_insurance_provider').text(errors.life_insurance_provider); }
                            if (errors.company_name) { $('#error-edit_company_name').text(errors.company_name); }
                            if (errors.property_address) { $('#error-edit_property_address').text(errors.property_address); }
                            if (errors.has_mortgage) { $('#error-edit_has_mortgage').text(errors.has_mortgage); }
                            if (errors.ownership_type) { $('#error-edit_ownership_type').text(errors.ownership_type); }
                            if (errors.other_description) { $('#error-edit_other_description').text(errors.other_description); }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            }
                            alert(errorMessage);
                            console.error("AJAX Error:", jqXHR);
                        }
                    }
                });
            });

            // --- Delete Asset ---
            $('#deleteAssetButton').on('click', function(e) {
                e.preventDefault();
                clearEditErrors();
                var assetId = $('#edit_asset_id').val();
                var postData = {
                    id: assetId
                };

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "#", // !!! IMPORTANT: Define this route in web.php
                            method: 'POST', // Or DELETE if your route definition uses it
                            data: postData,
                            dataType: 'json',
                            success: function(response) {
                                $('#editWillAssetModal').modal('hide');
                                $('#existingAssetsList').html(response.data);
                                Swal.fire(
                                    'Deleted!',
                                    'Your asset has been deleted.',
                                    'success'
                                );
                            },
                            error: function(jqXHR) {
                                if (jqXHR.status === 419) {
                                    alert(
                                        'Your session has expired or the security token is invalid. Please refresh the page and try again.');
                                    location.reload();
                                } else {
                                    var errorMessage = 'An unexpected error occurred.';
                                    if (jqXHR.responseJSON && jqXHR.responseJSON
                                        .message) {
                                        errorMessage = jqXHR.responseJSON.message;
                                    }
                                    Swal.fire(
                                        'Error!',
                                        errorMessage,
                                        'error'
                                    );
                                    console.error("AJAX Error:", jqXHR);
                                }
                            }
                        });
                    }
                });
            });

            // --- Save and Continue Button Logic ---
            $('#saveAndContinueButton').on('click', function(e) {
                e.preventDefault();
                // This button should typically submit the main form, which has action="{{ route('partner.will_generator.store_step4') }}"
                $('#msform').submit(); // Submits the main form with CSRF token
            });
        });

    </script>
@endsection
