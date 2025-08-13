@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>

input[type="radio"] {
    display: inline-block !important; /* Or block, based on desired layout */
    /* Add appearance: radio !important; as well, to force native styling */
    -webkit-appearance: radio !important;
    -moz-appearance: radio !important;
    appearance: radio !important;
    width: 16px !important; /* Ensure it has a size */
    height: 16px !important;
    opacity: 1 !important; /* Ensure it's not transparent */
    visibility: visible !important; /* Ensure it's not hidden */
    position: static !important; /* Ensure it's not positioned off-screen */
}


    .hidden {
        display: none !important;
    }

    .form-group .radio-group {
    display: flex !important;
    flex-direction: column !important;
    gap: 10px;
}

    .form-group.radio-group label {
        display: inline-flex;
        align-items: center;
        margin-right: 0;
        font-weight: normal;
        cursor: pointer;
    }
    .form-group.radio-group input[type="radio"] {
        margin-right: 8px;
        width: 16px !important;
        height: 16px !important;
        vertical-align: middle;
        -webkit-appearance: radio !important;
        -moz-appearance: radio !important;
        appearance: radio !important;
        opacity: 1 !important;
        visibility: visible !important;
        position: static !important;
        border: initial !important;
        background-color: initial !important;
        box-shadow: none !important;
    }
    .modal-body .form-group label {
        font-weight: 600;
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
        box-sizing: border-box;
    }
    .modal-body select {
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
    @php
    $assetTypeMap = [
        'bankAccount' => 'Bank Account',
        'pension' => 'Pension',
        'lifeInsurance' => 'Life Insurance',
        'stocksAndShares' => 'Stocks and Shares',
        'property' => 'Property',
        'other' => 'Other',
    ];
@endphp

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>Account and Properties</h4>
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form id="msform" class="needs-validation" novalidate
                                    action="{{ route('partner.will_generator.account_properties',$will_user_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="will_user_id" id="will_user_id" value="{{$will_user_id}}">
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

                                            </div>


                                            <div id="existingAssetsList">

                                                @forelse ($assets as $asset)
                                                    <div id="assetDetailItem-{{ $asset->id }}"
                                                        class="asset-detail-item bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-8">
                                                        <div class="flex justify-between items-center">
                                                            <div>

                                                                <p class="font-semibold text-gray-900">
                                                                    {{ @$asset->asset_name  ?? 'Unnamed Asset' }}
                                                                </p>
                                                                <p class="text-sm text-gray-600">
                                                                    {{ $assetTypeMap[$asset->asset_type] ?? 'Type not specified' }}
                                                                </p>
                                                            </div>
                                                            <button type="button" data-toggle="modal"
                                                                data-target="#editWillAssetModal"
                                                                data-id="{{ $asset->id }}"
                                                                data-type="{{ @$asset->asset_type }}"
                                                                data-value="{{ @$asset->asset_name }}"
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

                                                    <p class="text-gray-500 text-center py-4">No accounts or properties
                                                        added yet.</p>
                                                @endforelse
                                            </div>


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

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4">
                        <div class="card">
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
                    </div> -->
                </div>
            </div>
        </div>


    </div>

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
            <input type="hidden" name="add_asset_value" id="add_asset_value">
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

                <div id="addBankAccountFields" class="hidden">
                    <div class="form-group mb-3">
                        <label for="add_bank_name">Bank name</label>
                        <input type="text" class="form-control" name="bank_name" id="add_bank_name" placeholder="e.g. HSBC">
                        <div class="text-danger" id="error-add_bank_name"></div>
                    </div>
                </div>

                <div id="addPensionFields" class="hidden">
                    <div class="form-group mb-3">
                        <label for="add_pension_provider">Provider</label>
                        <input type="text" class="form-control" name="pension_provider" id="add_pension_provider" placeholder="e.g. Aviva">
                        <div class="text-danger" id="error-add_pension_provider"></div>
                    </div>
                </div>

                <div id="addLifeInsuranceFields" class="hidden">
                    <div class="form-group mb-3">
                        <label for="add_life_insurance_provider">Provider</label>
                        <input type="text" class="form-control" name="life_insurance_provider" id="add_life_insurance_provider" placeholder="e.g. Legal & General">
                        <div class="text-danger" id="error-add_life_insurance_provider"></div>
                    </div>
                </div>

                <div id="addStocksAndSharesFields" class="hidden">
                    <div class="form-group mb-3">
                        <label for="add_company_name">Company name</label>
                        <input type="text" class="form-control" name="company_name" id="add_company_name" placeholder="e.g. Invesco">
                        <div class="text-danger" id="error-add_company_name"></div>
                    </div>
                </div>

                <div id="addPropertyFields" class="hidden">
                    <div class="form-group mb-3">
                        <label for="add_property_address">Address</label>
                        <input type="text" class="form-control" name="property_address" id="add_property_address" placeholder="e.g. 27 Downham Road, London, N1 5AA">
                        <div class="text-danger" id="error-add_property_address"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Does this property have a mortgage?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="has_mortgage" value="yes"> Yes</label>
                            <label><input type="radio" name="has_mortgage" value="no"> No</label>
                            <label><input type="radio" name="has_mortgage" value="unknown"> I don't know</label>
                        </div>
                        <div class="text-danger" id="error-add_has_mortgage"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label>Who owns this property?</label>
                        <div class="radio-group">
                            <label><input type="radio" name="ownership_type" value="sole"> I am the only owner</label>
                            <label><input type="radio" name="ownership_type" value="joint"> I own it jointly with someone else</label>
                            <label><input type="radio" name="ownership_type" value="unknown"> I don't know</label>
                        </div>
                        <div class="text-danger" id="error-add_ownership_type"></div>
                    </div>
                </div>

                <div id="addOtherFields" class="hidden">
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

                        <div id="editBankAccountFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_bank_name">Bank name</label>
                                <input type="text" class="form-control" name="bank_name" id="edit_bank_name" placeholder="e.g. HSBC">
                                <div class="text-danger" id="error-edit_bank_name"></div>
                            </div>
                        </div>

                        <div id="editPensionFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_pension_provider">Provider</label>
                                <input type="text" class="form-control" name="pension_provider" id="edit_pension_provider" placeholder="e.g. Aviva">
                                <div class="text-danger" id="error-edit_pension_provider"></div>
                            </div>
                        </div>

                        <div id="editLifeInsuranceFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_life_insurance_provider">Provider</label>
                                <input type="text" class="form-control" name="life_insurance_provider" id="edit_life_insurance_provider" placeholder="e.g. Legal & General">
                                <div class="text-danger" id="error-edit_life_insurance_provider"></div>
                            </div>
                        </div>

                        <div id="editStocksAndSharesFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_company_name">Company name</label>
                                <input type="text" class="form-control" name="company_name" id="edit_company_name" placeholder="e.g. Invesco">
                                <div class="text-danger" id="error-edit_company_name"></div>
                            </div>
                        </div>

                        <div id="editPropertyFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_property_address">Address</label>
                                <input type="text" class="form-control" name="property_address" id="edit_property_address" placeholder="e.g. 27 Downham Road, London, N1 5AA">
                                <div class="text-danger" id="error-edit_property_address"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Does this property have a mortgage?</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="edit_has_mortgage" value="yes" > Yes</label>
                                    <label><input type="radio" name="edit_has_mortgage" value="no"> No</label>
                                    <label><input type="radio" name="edit_has_mortgage" value="unknown"> I don't know</label>
                                </div>
                                <div class="text-danger" id="error-edit_has_mortgage"></div>
                            </div>
                            <div class="form-group mb-3">
                                <label>Who owns this property?</label>
                                <div class="radio-group">
                                    <label><input type="radio" name="edit_ownership_type" value="sole"> I am the only owner</label>
                                    <label><input type="radio" name="edit_ownership_type" value="joint"> I own it jointly with someone else</label>
                                    <label><input type="radio" name="edit_ownership_type" value="unknown"> I don't know</label>
                                </div>
                                <div class="text-danger" id="error-edit_ownership_type"></div>
                            </div>
                        </div>

                        <div id="editOtherFields" class="hidden">
                            <div class="form-group mb-3">
                                <label for="edit_other_description">Description</label>
                                <input type="text" class="form-control" name="other_description" id="edit_other_description" placeholder="e.g. Money under the mattress">
                                <div class="text-danger" id="error-edit_other_description"></div>
                            </div>
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

        // Get the select element for ADD modal
        const addAssetTypeSelect = $('#add_asset_type_select');
        // Get all the specific field containers for ADD modal
        const addBankAccountFields = $('#addBankAccountFields');
        const addPensionFields = $('#addPensionFields');
        const addLifeInsuranceFields = $('#addLifeInsuranceFields');
        const addStocksAndSharesFields = $('#addStocksAndSharesFields');
        const addPropertyFields = $('#addPropertyFields');
        const addOtherFields = $('#addOtherFields');
        // Get the container for the Estimated Value field for ADD modal
        const addAssetValueFieldContainer = $('#addAssetValueFieldContainer');

        // Get the select element for EDIT modal
        const editAssetTypeSelect = $('#edit_asset_type_select');
        // Get all the specific field containers for EDIT modal
        const editBankAccountFields = $('#editBankAccountFields');
        const editPensionFields = $('#editPensionFields');
        const editLifeInsuranceFields = $('#editLifeInsuranceFields');
        const editStocksAndSharesFields = $('#editStocksAndSharesFields');
        const editPropertyFields = $('#editPropertyFields');
        const editOtherFields = $('#editOtherFields');
        // Get the container for the Estimated Value field for EDIT modal
        const editAssetValueFieldContainer = $('#editAssetValueFieldContainer');


        // Generic function to toggle fields based on a given select element and field prefixes
        function toggleFields(selectElement, typePrefix, valueContainer) {
            const selectedValue = selectElement.val();

            // Hide all potential field containers for this modal
            $(`#${typePrefix}BankAccountFields, #${typePrefix}PensionFields, #${typePrefix}LifeInsuranceFields, #${typePrefix}StocksAndSharesFields, #${typePrefix}PropertyFields, #${typePrefix}OtherFields`)
                .addClass('hidden');

            // Hide the Estimated Value field by default
            if (valueContainer.length) {
                valueContainer.addClass('hidden');
            }

            // Show the relevant container(s) based on the selected value
            if (selectedValue === 'bankAccount') {
                $(`#${typePrefix}BankAccountFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            } else if (selectedValue === 'pension') {
                $(`#${typePrefix}PensionFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            } else if (selectedValue === 'lifeInsurance') {
                $(`#${typePrefix}LifeInsuranceFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            } else if (selectedValue === 'stocksAndShares') {
                $(`#${typePrefix}StocksAndSharesFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            } else if (selectedValue === 'property') {
                $(`#${typePrefix}PropertyFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            } else if (selectedValue === 'other') {
                $(`#${typePrefix}OtherFields`).removeClass('hidden');
                if (valueContainer.length) valueContainer.removeClass('hidden');
            }
        }


        // Attach the event listener to the "Add" dropdown
        addAssetTypeSelect.on('change', function() {
            toggleFields(addAssetTypeSelect, 'add', addAssetValueFieldContainer);
        });

        // Attach the event listener to the "Edit" dropdown
        editAssetTypeSelect.on('change', function() {
            toggleFields(editAssetTypeSelect, 'edit', editAssetValueFieldContainer);
        });

        // Initial calls to set the correct state when the page loads
        toggleFields(addAssetTypeSelect, 'add', addAssetValueFieldContainer);
        toggleFields(editAssetTypeSelect, 'edit', editAssetValueFieldContainer); // For edit modal on page load


        // --- Bootstrap Modal Show Event ---
        $('#addWillAssetModal').on('show.bs.modal', function () {
            // Reset the dropdown to "Select..."
            addAssetTypeSelect.val('select');
            // Trigger the change handler to hide all fields
            toggleFields(addAssetTypeSelect, 'add', addAssetValueFieldContainer);
            // Clear any previous input values within the form
            $('#addWillAssetForm')[0].reset();
            // Clear previous error messages
            clearAddErrors();
        });

        $('#editWillAssetModal').on('show.bs.modal', function () {

            clearEditErrors();

        });


        // --- Add Asset Form Submission (already good) ---
        $('#addWillAssetForm').on('submit', function(e) {
            var will_user_id=$("#will_user_id").val();
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
                    postData.asset_value = $('#add_bank_name').val();
                    break;
                case 'pension':
                    postData.asset_value = $('#add_pension_provider').val();
                    break;
                case 'lifeInsurance':
                    postData.asset_value = $('#add_life_insurance_provider').val();
                    break;
                case 'stocksAndShares':
                    postData.asset_value = $('#add_company_name').val();
                    break;
                case 'property':
                    postData.asset_value = $('#add_property_address').val();
                    postData.has_mortgage = $('input[name="add_has_mortgage"]:checked').val(); // Ensure input names are distinct for add/edit
                    postData.ownership_type = $('input[name="add_ownership_type"]:checked').val(); // Ensure input names are distinct for add/edit
                    break;
                case 'other':
                    postData.other_description = $('#add_other_description').val();
                    postData.asset_value = $('#add_other_description').val();
                    break;
            }

            $.ajax({
                url: "{{route('partner.will_generator.account_properties.store','')}}/"+will_user_id,
                method: 'POST',
                data: postData,
                dataType: 'json',
                success: function(response) {
                    $('#addWillAssetModal').click();
                    $('#existingAssetsList').html(response.data);
                    Swal.fire('Success!', 'Asset added successfully!', 'success');
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
                        if (errors.asset_value) { $('#error-add_asset_value').text(errors.asset_value); } // For generic asset_value
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
                        Swal.fire('Error!', errorMessage, 'error'); // Use Swal for errors too
                        console.error("AJAX Error:", jqXHR);
                    }
                }
            });
        });

        // --- Populate Edit Modal ---
        $(document).on('click', '.edit_asset_button', function() {
            clearEditErrors();
            const id = $(this).data('id');
            const type = $(this).data('type');
            const name = $(this).data('name');
            const value = $(this).data('value'); // For the general estimated value
            const hasMortgage = $(this).data('mortgage'); // Make sure you pass this data
            const ownershipType = $(this).data('owner'); // Make sure you pass this data


            $('#edit_asset_id').val(id);
            // Set type and trigger change to toggle fields *first*
            $('#edit_asset_type_select').val(type).trigger('change');

            // Then populate specific fields based on the type
            switch (type) {
                case 'bankAccount':
                    $('#edit_bank_name').val(value); // 'name' could be the bank name
                    break;
                case 'pension':
                    $('#edit_pension_provider').val(value); // 'name' could be the provider
                    break;
                case 'lifeInsurance':
                    $('#edit_life_insurance_provider').val(value); // 'name' could be the provider
                    break;
                case 'stocksAndShares':
                    $('#edit_company_name').val(value); // 'name' could be the company name
                    break;
                case 'property':
                    $('#edit_property_address').val(value); // 'name' could be the address
                    // Set radio buttons for property
                    if (hasMortgage !== undefined) {
                        $(`input[name="edit_has_mortgage"][value="${hasMortgage}"]`).prop('checked', true);
                    }
                    if (ownershipType !== undefined) {
                        $(`input[name="edit_ownership_type"][value="${ownershipType}"]`).prop('checked', true);
                    }
                    break;
                case 'other':
                    $('#edit_other_description').val(value); // 'name' could be the description
                    break;
            }
            // Populate the generic estimated value field
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
                _method: 'PUT', // Important for Laravel if using Route::put
                id: assetId,
                asset_type: assetType,
                asset_value: $('#edit_asset_value').val()
            };

            // Add specific fields based on asset type for update
            switch (assetType) {
                case 'bankAccount':
                    postData.asset_value = $('#edit_bank_name').val(); // Ensure you're sending the correct value for asset_value
                    break;
                case 'pension':
                    postData.asset_value = $('#edit_pension_provider').val();
                    break;
                case 'lifeInsurance':
                    postData.asset_value = $('#edit_life_insurance_provider').val();
                    break;
                case 'stocksAndShares':
                    postData.asset_value = $('#edit_company_name').val();
                    break;
                case 'property':
                    postData.asset_value = $('#edit_property_address').val();
                    postData.has_mortgage = $('input[name="edit_has_mortgage"]:checked').val();
                    postData.ownership_type = $('input[name="edit_ownership_type"]:checked').val();
                    break;
                case 'other':
                    postData.other_description = $('#edit_other_description').val();
                    break;
            }

            $.ajax({
                url: "{{route('partner.will_generator.account_properties.update')}}",
                method: 'POST',
                data: postData,
                dataType: 'json',
                success: function(response) {
                    $('#editWillAssetModal').click();
                    $('#existingAssetsList').html(response.data);
                    Swal.fire('Updated!', 'Your asset has been updated successfully.', 'success');
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
                        if (errors.asset_type) { $('#error-edit_asset_type').text(errors.asset_type); }
                        if (errors.asset_value) { $('#error-edit_asset_value').text(errors.asset_value); } // For generic asset_value
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
                        Swal.fire('Error!', errorMessage, 'error');
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
                        url: "{{route('partner.will_generator.account_properties.delete','')}}/"+assetId , // Correct route with ID
                        method: 'POST', // Use POST for _method: 'DELETE'
                        data: {
                            _token: csrfToken,
                            _method: 'DELETE' // Method spoofing for DELETE
                        },
                        dataType: 'json',
                        success: function(response) {
                            $('#editWillAssetModal').click();
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
                                if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
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
