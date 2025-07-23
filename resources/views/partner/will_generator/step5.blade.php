@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* ... existing styles ... */
        .pet-details-wrapper {
            display: none;
            /* Initially hidden */
        }

        .pet-detail-item {
            margin-bottom: 20px;
            /* Add some spacing between pet items */
        }
    </style>


    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card height-equal">
                            <div class="card-header">
                                <h4>About You</h4>
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form id="msform" class="needs-validation" novalidate
                                    action="{{ route('partner.will_generator.store_step5') }}" method="POST">
                                    @csrf
                                    <script src="https://cdn.tailwindcss.com"></script>
                                    <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                        <div class="col-sm-12">

                                            <h1 id="PetQuestion" class="text-2xl sm:text-2xl font-bold text-gray-800 mb-4">
                                                Do you have any pets?<span class="txt-danger">*</span>
                                            </h1>
                                            <p class="text-gray-600 mb-2">
                                                You can choose guardians for your pets in the next section.
                                            </p>
                                            <div class="space-y-4 mb-8">
                                                <div id="yesOption"
                                                    class="cursor-pointer p-4 rounded-lg border-2 transition-all duration-200 border-gray-300 bg-gray-50 hover:bg-gray-100"
                                                    onclick="handleSelection('yes')">
                                                    <span class="font-medium text-gray-800">
                                                        Yes
                                                    </span>
                                                </div>

                                                <div id="noOption"
                                                    class="cursor-pointer p-4 rounded-lg border-2 transition-all duration-200 border-gray-300 bg-gray-50 hover:bg-gray-100"
                                                    onclick="handleSelection('no')">
                                                    <span class="font-medium text-gray-800">
                                                        No
                                                    </span>
                                                </div>
                                                <input type="hidden" name="pets" id="pets">
                                            </div>

                                            <div id="petContentWrapper" class="pet-details-wrapper">
                                                <div id="existingPetList">
                                                    @foreach ($pets as $pet)
                                                        <div id="petDetails"
                                                            class="pet-detail-item bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-8">
                                                            <div class="flex justify-between items-center">
                                                                <div>
                                                                    <p class="font-semibold text-gray-900">
                                                                        {{ @$pet->pet_name }}</p>

                                                                </div>
                                                                <button type="button" data-toggle="modal"
                                                                    data-target="#editWillPetModal"
                                                                    data-id="{{ $pet->id }}"
                                                                    data-name="{{ $pet->pet_name }}"
                                                                    data-will="{{ $pet->will_user_id }}"
                                                                    class="edit_button text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
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
                                                    @endforeach
                                                </div>

                                                <div id="addPetButtonContainer">
                                                    <button type="button"
                                                        class="w-full py-3 px-4 bg-white border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-700 transition-all duration-200 flex items-center justify-center"
                                                        data-toggle="modal" data-target="#addWillPetModal">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                            height="20" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="inline-block mr-2">
                                                            <line x1="12" y1="5" x2="12"
                                                                y2="19">
                                                            </line>
                                                            <line x1="5" y1="12" x2="19"
                                                                y2="12">
                                                            </line>
                                                        </svg>
                                                        Add a pet
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                            <div class="wizard-footer d-flex gap-2 justify-content-end m-4">
                                <button class="btn badge-light-primary" id="backbtn" onclick="backStep()"
                                    disabled=""> Back</button>
                                <button type="submit" class="btn btn-primary" id="nextbtn">Finish</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
<div class="modal" id="addWillPetModal" tabindex="-1" role="dialog"
                                        aria-labelledby="addWillPetModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form id="addWillPetForm">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addWillPetModalLabel">Add a pet
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="form-group mb-3">
                                                            <label for="name">Pet Name</label>
                                                            <input type="text" class="form-control" name="pet_name"
                                                                id="name" placeholder="Enter Pet Name" required>
                                                            <div class="text-danger" id="error-name"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary"
                                                            id="savePetButton">Save changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="modal" id="editWillPetModal" tabindex="-1" role="dialog"
                                        aria-labelledby="editWillPetModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <form id="editWillPetForm">
                                                @csrf
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editWillPetModalLabel">Edit a pet
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <input type="hidden" name="pet_id" id="edit_pet_id">
                                                        <div class="form-group mb-3">
                                                            <label for="name">Pet Name</label>
                                                            <input type="text" class="form-control" name="pet_name"
                                                                id="edit_pet_name" placeholder="Enter Pet Name" required>
                                                            <div class="text-danger" id="error-name"></div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger"
                                                            id="deletePetButton">Remove Pet</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary"
                                                            id="updatePetButton">Update changes</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
    <!-- Container-fluid Ends-->
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Get references to the DOM elements
        const yesOption = document.getElementById('yesOption');
        const noOption = document.getElementById('noOption');
        const petContentWrapper = document.getElementById('petContentWrapper');
        const existingPetList = document.getElementById('existingPetList');
        let hasPet = null;

        function handleSelection(selection) {
            hasPet = selection; // Update the selection state

            // Reset styles for both options
            yesOption.classList.remove('border-blue-500', 'bg-blue-50', 'shadow-inner');
            yesOption.classList.add('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
            yesOption.querySelector('span').classList.remove('text-blue-700');
            yesOption.querySelector('span').classList.add('text-gray-800');

            noOption.classList.remove('border-blue-500', 'bg-blue-50', 'shadow-inner');
            noOption.classList.add('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
            noOption.querySelector('span').classList.remove('text-blue-700');
            noOption.querySelector('span').classList.add('text-gray-800');

            // Apply selected styles based on the current selection
            if (hasPet === 'yes') {
                yesOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
                yesOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
                yesOption.querySelector('span').classList.add('text-blue-700');
                yesOption.querySelector('span').classList.remove('text-gray-800');

                // Show the entire wrapper containing pet details and add button
                petContentWrapper.style.display = 'block';
            } else if (hasPet === 'no') {
                noOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
                noOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
                noOption.querySelector('span').classList.add('text-blue-700');
                noOption.querySelector('span').classList.remove('text-gray-800');

                // Hide the entire wrapper
                petContentWrapper.style.display = 'none';
            }
            $("#pets").val(hasPet);
        }
        window.onload = function() {
            const initialPetCount = existingPetList.pet.length;
            if (initialPetCount > 0) {
                handleSelection('yes');
                $("#pets").val('yes');
            } else {
                handleSelection(null);
            }
        };

        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            function clearAddErrors() {
                $('#error-name').text('');
                $('#error-date_of_birth').text('');
            }
            $('#savePetButton').on('click', function(e) {
                e.preventDefault();
                clearAddErrors();
                var petName = $('#name').val();

                var postData = {
                    name: petName,

                };
                $.ajax({
                    url: "{{ route('partner.will_generator.user_pet.store') }}",
                    method: 'POST',
                    data: postData,
                    dataType: 'json',

                    success: function(response) {
                        $('#name').val('');

                        $('#addWillPetModal').click();
                        $('#existingPetList').html(response.data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 419) {
                            alert(
                                'Your session has expired or the security token is invalid. Please refresh the page and try again.'
                            );
                            location.reload();
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            if (errors.name) {
                                $('#error-name').text(errors.name);
                            }
                            if (errors.date_of_birth) {
                                $('#error-date_of_birth').text(errors.date_of_birth);
                            }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                            alert(errorMessage);
                            console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
                        }
                    }
                });
            });

            $('#updatePetButton').on('click', function(e) {
                e.preventDefault();
                clearAddErrors();
                var petName = $('#edit_pet_name').val();
                var petId = $('#edit_pet_id').val()
                var postData = {
                    name: petName,
                    pet_id: petId,

                };
                $.ajax({
                    url: "{{ route('partner.will_generator.user_pet.edit') }}",
                    method: 'POST',
                    data: postData,
                    dataType: 'json',

                    success: function(response) {
                        $('#edit_pet_name').val('');
                        $('#edit_pet_id').val('');
                        $('#editWillPetModal').click();
                        $('#existingPetList').html(response.data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 419) {
                            alert(
                                'Your session has expired or the security token is invalid. Please refresh the page and try again.'
                            );
                            location.reload();
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            if (errors.name) {
                                $('#error-name').text(errors.name);
                            }
                            if (errors.date_of_birth) {
                                $('#error-date_of_birth').text(errors.date_of_birth);
                            }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                            alert(errorMessage);
                            console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
                        }
                    }
                });
            });
            $(document).on('click', '.edit_button', function() {

                var id = $(this).data('id');
                var name = $(this).data('name');

                $('#edit_pet_id').val(id);
                $('#edit_pet_name').val(name);
                // The modal will open automatically because of data-target="#editWillPetModal"
            });


            $('#deletePetButton').on('click', function(e) {
                e.preventDefault();
                clearAddErrors();
                var petId = $('#edit_pet_id').val()
                var postData = {
                    pet_id: petId,

                };
                $.ajax({
                    url: "{{ route('partner.will_generator.user_pet.delete') }}",
                    method: 'POST',
                    data: postData,
                    dataType: 'json',

                    success: function(response) {
                        $('#edit_pet_name').val('');
                        $('#edit_pet_id').val('');
                        $('#editWillPetModal').click();
                        $('#existingPetList').html(response.data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 419) {
                            alert(
                                'Your session has expired or the security token is invalid. Please refresh the page and try again.'
                            );
                            location.reload();
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            if (errors.name) {
                                $('#error-name').text(errors.name);
                            }
                            if (errors.date_of_birth) {
                                $('#error-date_of_birth').text(errors.date_of_birth);
                            }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                            alert(errorMessage);
                            console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
                        }
                    }
                });
            });
        });
    </script>
@endsection
