@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Using Tailwind CSS directly --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Base styles for the overall layout */
        .container-fluid {
            padding: 1.5rem;
            /* Adjust as needed for overall page padding */
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            /* Space between card and bottom content */
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Input field styles */
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e0;
            /* Gray border */
            border-radius: 0.375rem;
            /* Rounded corners */
            font-size: 1rem;
            color: #2d3748;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .form-input:focus {
            border-color: #4299e1;
            /* Blue border on focus */
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        textarea.form-input {
            min-height: 8rem;
            /* Tall enough for messages */
            resize: vertical;
            /* Allow vertical resizing */
        }

        /* Specificity Guidance Styles */
        .guidance-section {
            margin-bottom: 1.5rem;
        }

        .guidance-section p {
            line-height: 1.5;
        }

        .guidance-section .font-semibold {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .guidance-section .do-say {
            color: #2f855a;
            /* Green for "Do say" */
        }

        .guidance-section .dont-say {
            color: #e53e3e;
            /* Red for "Don't say" */
        }

        .guidance-section .bullet {
            font-weight: 700;
            margin-right: 0.5rem;
        }

        /* Executor Card Styles */
        .executor-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            /* Light gray border */
            border-radius: 0.375rem;
            /* Rounded corners */
            margin-bottom: 0.75rem;
            background-color: #fff;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }

        .executor-card:hover {
            background-color: #f7fafc;
            /* Lighter background on hover */
        }

        .executor-card label {
            display: flex;
            /* Make the label a flex container to align checkbox and details */
            align-items: center;
            width: 100%;
            /* Make label take full width of card */
            cursor: pointer;
        }

        .executor-card input[type="checkbox"] {
            margin-right: 1rem;
            /* Space between checkbox and text */
            transform: scale(1.2);
            /* Slightly larger checkbox */
        }

        .executor-details {
            flex-grow: 1;
            /* Allow details to take available space */
            display: flex;
            flex-direction: column;
        }

        .executor-name {
            font-weight: 600;
            color: #1a202c;
        }

        .executor-contact {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .edit-button {
            padding: 0.5rem 1rem;
            background-color: #edf2f7;
            /* Light gray */
            color: #2d3748;
            /* Dark text */
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .edit-button:hover {
            background-color: #e2e8f0;
        }

        /* Add Someone New Button */
        .add-new-person-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: #f7fafc;
            /* Very light gray */
            border: 1px dashed #cbd5e0;
            /* Dashed gray border */
            border-radius: 0.375rem;
            color: #4a5568;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 1rem;
        }

        .add-new-person-button:hover {
            background-color: #edf2f7;
            border-color: #a0aec0;
        }

        .add-new-person-button svg {
            margin-right: 0.5rem;
            color: #a0aec0;
            /* Gray plus icon */
        }

        /* Bottom navigation buttons */
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
            /* No border for this button */
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
            /* Ensure it doesn't take full height if content is small */
            position: sticky;
            /* Makes it stick when scrolling */
            top: 1.5rem;
            /* Distance from top of viewport */
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
            /* Blue link color */
            text-decoration: none;
            font-size: 0.95rem;
        }

        .related-articles-card ul li a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-8"> {{-- Main content area --}}
                <div class="card height-equal">
                    <form method="POST" action="{{ route('partner.will_generator.gift.store_add_gift',$will_user_id) }}" id="executorChoiceForm">
                        @csrf {{-- Don't forget the CSRF token! --}}

                        {{-- Hidden field to pass the 'type' to the controller --}}
                        <input type="hidden" name="type" value="{{ $type }}">

                        {{-- You might also need a hidden input for will_user_id if it's not determined from the session/auth --}}
                        {{-- Example: <input type="hidden" name="will_user_id" value="{{ $will_user_id ?? '' }}"> --}}

                        <div class="card-body basic-wizard important-validation">
                            {{-- Dynamic Title based on gift type --}}
                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                @if ($type == 'one-off')
                                    Leave a one-off item as a gift
                                @elseif($type == 'collection')
                                    Leave a collection of items as a gift
                                @elseif($type == 'vehicle')
                                    Leave a vehicle as a gift
                                @elseif($type == 'money')
                                    Leave a sum of money as a gift
                                @else
                                    Add a Gift
                                @endif
                            </h1>

                            {{-- Dynamic "Be specific" guidance --}}
                            <div class="guidance-section text-red-600 mb-4">
                                <p class="font-semibold mb-1">Be specific</p>
                                @if ($type == 'one-off')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "Painting
                                        signed by A. F. Digby, of an old man eating breadcrumbs."</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "Painting"
                                    </p>
                                @elseif($type == 'collection')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My books,
                                        jewellery or a shelf full of vinyls, wherever they are kept at the date of my death"
                                        to make sure you're leaving your full collection.</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "All my
                                        books"</p>
                                @elseif($type == 'vehicle')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My car,
                                        registration number FW1 1AA"</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "My car"
                                    </p>
                                @endif
                            </div>

                            {{-- General descriptive text for one-off/collection/vehicle --}}
                            @if ($type == 'one-off')
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    You may only have one painting now, but if you buy another one in the
                                    future, your administrators won't know which one you mean. Always be
                                    as specific as possible so that your wishes are easy to understand.
                                </p>
                            @elseif($type == 'collection')
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    If you want to leave all your personal possessions write "personal
                                    possessions as defined by section 55 Administration of Estates Act".
                                </p>
                            @elseif($type == 'vehicle')
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    The first example ensures your beneficiary will only inherit the car if
                                    you still own it when you die. The second example means you will give
                                    the last car you own as a gift, even if it's different from the one you
                                    own now.
                                </p>
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    If you want to leave whichever car you have when you die
                                </p>
                                <div class="guidance-section text-red-600 mb-4">
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My car at
                                        the date of my death"</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "My car"
                                    </p>
                                </div>
                            @endif

                            {{-- What's the item/collection/vehicle/amount? --}}
                            <div class="mb-6">
                                <label for="itemDescription" class="block text-gray-700 text-sm font-semibold mb-2">
                                    @if ($type == 'one-off')
                                        Description of item
                                    @elseif($type == 'collection')
                                        Description of collection
                                    @elseif($type == 'vehicle')
                                        Description of the vehicle
                                    @elseif($type == 'money')
                                        Amount
                                    @endif
                                </label>
                                @if ($type == 'money')
                                    <input type="number" step="0.01" id="itemDescription" name="item_description"
                                        class="form-input" placeholder="e.g. 500" required>
                                @else
                                    <input type="text" id="itemDescription" name="item_description" class="form-input"
                                        placeholder="My watch"
                                        value="{{ $type == 'one-off' ? 'My watch' : ($type == 'collection' ? 'All my books' : ($type == 'vehicle' ? 'My car' : '')) }}"
                                        required>
                                @endif
                            </div>

                            {{-- Who would you like to leave it to? (Common Section) --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    Who would you like to leave it to?
                                </h3>
                                <p class="text-gray-700 text-sm mb-4">
                                    Select one or more people or add someone new
                                </p>

                                <div id="existingPartnerList" class="space-y-3">
                                    @forelse ($executors as $executor)
                                        <div class="executor-card">
                                            <label>
                                                <input type="checkbox" name="executors[]" value="{{ $executor->id }}" required>
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

                                    <button type="button" class="add-new-person-button" data-toggle="modal"
                                        data-target="#addExecutorModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                            fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Add someone new
                                    </button>
                                </div>
                            </div>

                            {{-- Leave a message (Optional) (Common Section) --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    Leave a message
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    Tell them what you're leaving and why you're leaving it to them. You
                                    can also say something you'd like them to do with it, although they
                                    won't be legally obliged to carry out your wishes.
                                </p>
                                <label for="messageOptional" class="block text-gray-700 text-sm font-semibold mb-2">
                                    Your message (optional)
                                </label>
                                <textarea id="messageOptional" name="message" class="form-input" rows="4"
                                    placeholder="e.g. This watch was given to me by my father..."></textarea>
                            </div>

                            {{-- Bottom Navigation (Common Section) --}}
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

            <div class="col-xl-4"> {{-- Sidebar area (Common Section) --}}
                <div class="related-articles-card">
                    <h4>Related articles</h4>
                    <ul>
                        <li><a href="#" class="text-blue-600 hover:underline">Leaving gifts in your will</a></li>
                        {{-- More related articles would go here --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="addExecutorModal" tabindex="-1" role="dialog"
        aria-labelledby="addExecutorModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExecutorModalLabel">Add Person</h5>
                </div>
                <div class="modal-body">
                    <form id="addExecutorForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                placeholder="Enter First Name" required>
                            <div class="text-danger" id="error-name"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                placeholder="Enter Last Name" >
                            <div class="text-danger" id="error-lastname"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone_number">Contact Number(s)</label>
                            <input type="text" class="form-control" name="phone" id="phone_number"
                                placeholder="Enter Contact Number">
                            <div class="text-danger" id="error-title"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Email Address">
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

                        <div class="form-group mb-3">
                            <label for="edit_name">First Name</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name"
                                placeholder="Enter First Name" required>
                            <div class="text-danger" id="edit-error-first_name"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_lastname">Last Name</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name"
                                placeholder="Enter Last Name" >
                            <div class="text-danger" id="edit-error-lastname"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="phone_number">Contact Number(s)</label>
                            <input type="text" class="form-control" name="phone_number" id="edit_phone_number"
                                placeholder="Enter Contact Number" >
                            <div class="text-danger" id="error-title"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_email">Email Address</label>
                            <input type="email" class="form-control" name="email" id="edit_email"
                                placeholder="Email Address" >
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
                // var title = $(this).data('title'); // Removed, as 'title' input is not in your current modal
                var name = $(this).data('name');
                var lastname = $(this).data('lastname');
                var phone_number = $(this).data('phone_number');
                var email = $(this).data('email');
                var relationship = $(this).data('relationship');

                // var status = $(this).data('status'); // Removed, as 'status' input is not in your current modal

                $('#editExecutorId').val(id);
                // $('#edit_title').val(title); // Removed
                $('#edit_first_name').val(name);
                $('#edit_last_name').val(lastname);
                $('#edit_phone_number').val(phone_number);
                $('#edit_email').val(email);
                $('#edit_relationship').val(relationship);
                clearEditErrors();
                $('#editExecutorModal').click();
            });

            // Handle submission of edit executor form
            $('#editExecutorForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#editExecutorId').val();
                clearEditErrors(); // Clear previous error messages

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
                var postData = {
                    id: person_id,

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
