@extends('layouts.will_generator')

@section('title', 'Choose your executors')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- Using Tailwind CSS directly as per the screenshot's design language --}}
<script src="https://cdn.tailwindcss.com"></script>
<style>
    /* Custom styles to match the screenshot more closely */
    body {
        background-color: #f5f5f5;
        /* Light grey background for the whole page */
    }

    .executor-card {
        background-color: #ffffff;
        /* White background for individual executor cards */
        border: 1px solid #e0e0e0;
        /* Light border */
        border-radius: 0.5rem;
        /* Rounded corners */
        padding: 1rem 1.5rem;
        margin-bottom: 0.75rem;
        /* Reduced margin for closer packing */
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Vertically align items */
        justify-content: space-between;
        /* Space between content and edit button */
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        /* Subtle shadow */
    }

    .executor-card:hover {
        border-color: #a0aec0;
        /* Darker border on hover */
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        /* Slightly more prominent shadow */
    }

    .executor-card input[type="checkbox"] {
        /* Custom checkbox styling to match the screenshot */
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        width: 1.25rem;
        /* Adjust size */
        height: 1.25rem;
        /* Adjust size */
        border: 2px solid #a0aec0;
        /* Border color */
        border-radius: 0.25rem;
        /* Slightly rounded corners */
        outline: none;
        cursor: pointer;
        position: relative;
        margin-right: 1rem;
        /* Space between checkbox and text */
        flex-shrink: 0;
        /* Prevent checkbox from shrinking */
    }

    .executor-card input[type="checkbox"]:checked {
        background-color: #F6E05E;
        /* Yellow background when checked */
        border-color: #F6E05E;
        /* Yellow border when checked */
    }

    .executor-card input[type="checkbox"]:checked::after {
        /* Checkmark for the custom checkbox */
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0.5rem;
        height: 0.75rem;
        border: solid #1a202c;
        /* Dark color for checkmark */
        border-width: 0 2px 2px 0;
        transform: translate(-50%, -60%) rotate(45deg);
    }

    .executor-card label {
        display: flex;
        align-items: center;
        flex-grow: 1;
        /* Allow label to take available space */
        cursor: pointer;
    }

    .executor-details {
        display: flex;
        flex-direction: column;
    }

    .executor-name {
        font-weight: 600;
        /* Semi-bold for name */
        color: #2d3748;
        /* Dark text color */
    }

    .executor-contact {
        font-size: 0.875rem;
        /* Smaller font for contact info */
        color: #718096;
        /* Lighter text color */
    }

    .edit-button {
        color: #4299e1;
        /* Blue for "Edit" link */
        font-weight: 500;
        text-decoration: none;
        margin-left: 1rem;
        flex-shrink: 0;
        /* Prevent button from shrinking */
    }

    .edit-button:hover {
        text-decoration: underline;
    }

    .add-someone-new {
        color: #4299e1;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        margin-top: 1rem;
        padding: 0.5rem 0;
    }

    .add-someone-new:hover {
        text-decoration: underline;
    }

    /* Styles for the "Back" and "Save and Continue" buttons */
    .back-button {
        background: none;
        border: none;
        color: #4299e1;
        /* Blue for links */
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        transition: color 0.2s ease-in-out;
    }

    .back-button:hover {
        color: #2b6cb0;
        /* Darker blue on hover */
        text-decoration: underline;
    }

    .save-continue-button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 2rem;
        /* Adjusted padding */
        border: 1px solid transparent;
        font-size: 1rem;
        /* Base font size */
        font-weight: 500;
        border-radius: 0.375rem;
        /* Medium rounded corners */
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        /* Shadow */
        color: #1a202c;
        /* Dark text for button */
        background-color: #F6E05E;
        /* Yellow background */
        cursor: pointer;
        transition: background-color 0.15s ease-in-out;
    }

    .save-continue-button:hover {
        background-color: #ECC94B;
        /* Darker yellow on hover */
    }

    .save-continue-button:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(252, 211, 77, 0.5);
        /* Focus ring */
    }

    /* Global styling adjustments for better visual hierarchy */
    h1,
    h2 {
        font-weight: 700;
        /* Bold for headings */
        color: #1a202c;
        /* Darker heading color */
    }

    p,
    li {
        color: #4a5568;
        /* Slightly lighter text for body */
    }
</style>

{{-- The main container div should structure the content like the screenshot --}}
<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row lg:space-x-8">
        {{-- Main content area --}}
        <div class="lg:w-2/3">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Choose your executors
                </h1>
                <p class="text-gray-700 leading-relaxed mb-8">
                    You can choose between one and four executors. We recommend choosing more than one, especially if
                    any beneficiaries of your will are currently under 18.
                </p>

                <form id="executorChoiceForm" class="space-y-6"
                    action="{{ route('partner.will_generator.store_executor') }}" method="POST">
                    @csrf
                    <input type="hidden" name="will_user_id" value="{{ $will_user_id }}">
                    <input type="hidden" name="friends_and_family" value="friends_and_family">
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Friends and family</h2>
                        <div class="space-y-3">
                            <div id="existingPartnerList">
                                @forelse ($executors as $executor)
                                <div class="executor-card">
                                    <label>
                                        <input type="checkbox" name="executors[]" value="{{ $executor->id }}">
                                        <div class="executor-details">
                                            <span class="executor-name">{{ $executor->first_name }}
                                                {{ $executor->last_name }}</span>
                                            <span class="executor-contact">{{ $executor->email }}</span>
                                        </div>
                                    </label>
                                    <a data-toggle="modal" data-target="#editExecutorModal"
                                        data-id="{{ $executor->id }}" data-name="{{ $executor->first_name }}"
                                        data-lastname="{{ $executor->last_name }}"
                                        data-email="{{ $executor->email }}"
                                        data-relationship="{{ $executor->type }}"
                                        data-phone_number="{{ $executor->phone }}" class="edit-button">Edit</a>
                                </div>
                                @empty
                                <p class="text-gray-600 italic">No friends or family executors added yet. Click "Add
                                    someone new" to get started.</p>
                                @endforelse
                            </div>
                            {{-- End example executor cards --}}
                        </div>
                        <a href="#" class="add-someone-new" data-toggle="modal" data-target="#addExecutorModal">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                            Add someone new
                        </a>
                    </div>

                    {{-- Professional executors section --}}
                    @if (isset($showProfessionalExecutors) && $showProfessionalExecutors)
                    <div class="mb-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Professional executors</h2>
                        <div class="space-y-3">
                            <div class="executor-card">
                                <input type="hidden" name="farewill_trustees" value="farewill_trustees">
                                <label>
                                    <input type="checkbox" name="farewill_trustees[]" value="farewill_trustees">
                                    <div class="executor-details">
                                        <span class="executor-name">Farewill Trustees</span>
                                    </div>
                                </label>
                                {{-- No edit button for professional executors based on screenshot --}}
                            </div>
                        </div>
                    </div>
                    @endif


                    {{-- Action buttons --}}
                    <div class="flex justify-between items-center mt-8">
                        <a href="#" class="back-button">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Back
                        </a>
                        <button type="submit" class="save-continue-button">
                            Save and continue
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Sidebar area --}}
        <!-- <div class="lg:w-1/3 mt-8 lg:mt-0">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Questions?</h4>
                    <p class="text-gray-700 mb-2">
                        Call us on <a href="tel:02045387294" class="text-blue-600 hover:underline">020 4538 7294</a>
                    </p>
                    <p class="text-gray-700">
                        <a href="mailto:info@farewill.com" class="text-blue-600 hover:underline flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline-block" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Email us
                        </a>
                    </p>
                </div>
            </div> -->
    </div>
</div>

<div class="modal fade" id="addExecutorModal" tabindex="-1" role="dialog" aria-labelledby="addExecutorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExecutorModalLabel">Add Person</h5>
            </div>
            <div class="modal-body">
                <form id="addExecutorForm">
                    @csrf
                    <input type="hidden" name="will_user_id" value="{{ $will_user_id }}">
                    <div class="form-group mb-3">
                        <label for="name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="first_name"
                            placeholder="Enter First Name" required>
                        <div class="text-danger" id="error-name"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="last_name"
                            placeholder="Enter Last Name" required>
                        <div class="text-danger" id="error-lastname"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone_number">Contact Number(s)</label>
                        <input type="text" class="form-control" name="phone" id="phone_number"
                            placeholder="Enter Contact Number" required>
                        <div class="text-danger" id="error-title"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="email"
                            placeholder="Email Address" required>
                        <div class="text-danger" id="error-email"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="relationship">Relationship</label>
                        <select class="form-control" name="type" id="relationship">
                            <option value="partner">Partner</option>
                            <option value="child">Child</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="text-danger" id="error-relationship"></div>
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- EDIT EXECUTOR MODAL -->
<div class="modal fade" id="editExecutorModal" tabindex="-1" role="dialog"
    aria-labelledby="editExecutorModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExecutorModalLabel">Edit Person</h5>
            </div>
            <div class="modal-body">
                <form id="editExecutorForm">
                    @csrf
                    <input type="hidden" name="id" id="editExecutorId">
                    <input type="hidden" name="will_user_id" id="will_user_id" value="{{ $will_user_id }}">
                    <div class="form-group mb-3">
                        <label for="edit_name">First Name</label>
                        <input type="text" class="form-control" name="first_name" id="edit_first_name"
                            placeholder="Enter First Name" required>
                        <div class="text-danger" id="edit-error-first_name"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_lastname">Last Name</label>
                        <input type="text" class="form-control" name="last_name" id="edit_last_name"
                            placeholder="Enter Last Name" required>
                        <div class="text-danger" id="edit-error-lastname"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone_number">Contact Number(s)</label>
                        <input type="text" class="form-control" name="phone_number" id="edit_phone_number"
                            placeholder="Enter Contact Number" required>
                        <div class="text-danger" id="error-title"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="edit_email"
                            placeholder="Email Address" required>
                        <div class="text-danger" id="edit-error-email"></div>
                    </div>
                    <div class="form-group mb-3">
                        <label for="edit_relationship">Relationship</label>
                        <select class="form-control" name="relationship" id="edit_relationship">
                            <option value="partner">Partner</option>
                            <option value="child">Child</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="text-danger" id="edit-error-relationship"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deletePersonButton">Remove Child</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Update changes</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        // Clear previous error messages
        function clearAddErrors() {
            $('#error-title').text('');
            $('#error-name').text('');
            $('#error-lastname').text('');
            $('#error-phone_number').text('');
            $('#error-email').text('');
            $('#error-relationship').text('');
            $('#error-status').text('');


        }

        function clearEditErrors() {
            $('#error-title').text('');
            $('#edit-error-first_name').text('');
            $('#edit-error-lastname').text('');
            $('#error-phone_number').text('');
            $('#edit-error-email').text('');
            $('#edit-error-relationship').text('');
            $('#edit-error-status').text('');


        }

        // Handle submission of add executor form
        $('#addExecutorForm').on('submit', function(e) {
            e.preventDefault();
            clearAddErrors(); // Clear previous error messages

            $.ajax({
                url: "{{ route('partner.will_generator.user_partner.store') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    $('#addExecutorModal').click();
                    $('#existingPartnerList').html(response.data);
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $('#error-title').text(errors.title);
                    $('#error-name').text(errors.name);
                    $('#error-lastname').text(errors.lastname);
                    $('#error-email').text(errors.email);
                    $('#error-relationship').text(errors.relationship);
                    $('#error-status').text(errors.status);


                }
            });
        });

        // Handle click on edit button for executor
        $(document).on('click', '.edit-button', function() {
            var id = $(this).data('id');
           
            var name = $(this).data('name');
            var lastname = $(this).data('lastname');
            var phone_number = $(this).data('phone_number');
            var email = $(this).data('email');
            var relationship = $(this).data('relationship');
            $('#editExecutorId').val(id);
            $('#edit_first_name').val(name);
            $('#edit_last_name').val(lastname);
            $('#edit_phone_number').val(phone_number);
            $('#edit_email').val(email);
            $('#edit_relationship').val(relationship);
            clearEditErrors();
            $('#editExecutorModal').click();
        });

     
        $('#editExecutorForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#editExecutorId').val();
            clearEditErrors(); 

            $.ajax({
                url: "/partner/will_generator/user_partner/edit",
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#editExecutorModal').click();
                    $('#existingPartnerList').html(response.data);
                },
                error: function(response) {
                    var errors = response.responseJSON.errors;
                    $('#edit-error-name').text(errors.name);
                    $('#edit-error-lastname').text(errors.lastname);
                    $('#edit-error-email').text(errors.email);
                    $('#edit-error-relationship').text(errors.relationship);
                    $('#edit-error-status').text(errors.status);

                }
            });
        });
    });

    $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        $('#executorChoiceForm').on('submit', function(e) {

            const selectedExecutors = $('input[name="executors[]"]:checked').map(function() {
                return $(this).val();
            }).get();

            console.log("Selected Executors:", selectedExecutors);

            if (selectedExecutors.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Oops...',
                    text: 'Please select at least one executor!',
                });
                return false;
            }

        });
        $('#deletePersonButton').on('click', function(e) {
            e.preventDefault();
            var person_id = $('#editExecutorId').val();
            var will_user_id = $('#will_user_id').val();
            var postData = {
                id: person_id,
                will_user_id: will_user_id
            };
            $.ajax({
                url: "{{ route('partner.will_generator.user_partner.delete') }}",
                method: 'Delete',
                data: postData,
                dataType: 'json',

                success: function(response) {
                    $('#editExecutorId').val('');
                    $('#edit_title').val('');
                    $('#edit_first_name').val('');
                    $('#edit_last_name').val('');
                    $('#edit_phone_number').val('');
                    $('#edit_email').val('');
                    $('#edit_relationship').val('');
                    $('#editExecutorModal').click();
                    $('#existingPartnerList').html(response.data);
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