@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom styles for the checkbox and edit button layout */
        .person-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            margin-bottom: 0.75rem;
            background-color: #fff;
        }

        .person-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .person-info input[type="checkbox"] {
            margin-right: 1rem;
            width: 1.25rem; /* Make checkbox larger */
            height: 1.25rem;
            cursor: pointer;
        }

        .person-details {
            display: flex;
            flex-direction: column;
        }

        .person-name {
            font-weight: 600; /* Semi-bold */
            color: #1a202c; /* Dark text */
        }

        .person-additional-info {
            font-size: 0.875rem; /* Small text */
            color: #4a5568; /* Gray text */
        }

        .edit-button {
            background: none;
            border: none;
            color: #4299e1; /* Blue for links/actions */
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0; /* Remove default button padding */
            margin-left: 1rem; /* Space from content */
        }

        .edit-button:hover {
            color: #2b6cb0; /* Darker blue on hover */
        }

        .add-new-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 1px dashed #a0aec0; /* Dashed gray border */
            border-radius: 0.375rem;
            color: #4a5568;
            background-color: #f7fafc; /* Light background */
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 1.5rem;
        }

        .add-new-button:hover {
            border-color: #718096;
            color: #2d3748;
            background-color: #ebf4ff;
        }

        .add-new-button svg {
            margin-right: 0.5rem;
        }

        .inheritance-summary-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
        }

        .inheritance-summary-card h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .inheritance-summary-card ul li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .inheritance-summary-card ul li:last-child {
            border-bottom: none;
        }

        /* Adjustments for the main content width */
        .main-content-col {
            flex: 0 0 66.666667%; /* Equivalent to col-xl-8 */
            max-width: 66.666667%;
        }

        .sidebar-col {
            flex: 0 0 33.333333%; /* Equivalent to col-xl-4 */
            max-width: 33.333333%;
        }

        /* To center content vertically if it's less than full height */
        .height-equal {
            min-height: auto; /* Override default to prevent excessive height */
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8 main-content-col"> {{-- Adjusted column width for the main content --}}
                        <div class="card height-equal">
                            <div class="card-header">
                                Inheritors
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form action="{{route('partner.will_generator.store_family_friend')}}" method="POST">
                                    @csrf

                                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                        Who would you like to inherit your estate?
                                    </h1>
                                    <p class="text-gray-700 leading-relaxed mb-6">
                                        You can decide how much each person gets in the next step. You'll
                                        also be able to choose backups in case any of them die before you.
                                    </p>

                                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                                        Select a person or add someone new
                                    </h2>

                                    {{-- Existing People/Charities List --}}
                                    <div class="space-y-3 mb-6">
                                       @forelse ($executors as $executor)
                                     <label for="{{$executor->name}}" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="{{$executor->name}}" name="inheritors[]" value="{{$executor->id}}" checked>
                                                <div class="person-details">
                                                    <span class="person-name">{{$executor->name}}{{$executor->lastname}}</span>
                                                    <span class="person-additional-info">{{$executor->email}}</span>
                                                </div>
                                            </div>
                                            <a data-toggle="modal" data-target="#editExecutorModal"
                                            data-id="{{ $executor->id }}" data-name="{{ $executor->name }}"
                                            data-lastname="{{ $executor->lastname }}"
                                            data-how_acting="{{ $executor->how_acting }}"
                                            data-email="{{ $executor->email }}"
                                            data-relationship="{{ $executor->relationship }}"
                                            data-status="{{ $executor->status }}" data-title="{{ $executor->title }}"
                                            data-phone_number="{{ $executor->phone_number }}" class="edit-button">Edit</a>
                                        </label>
                                @empty
                                    <p class="text-gray-600 italic">No inherited person friend or family added yet. Click "Add
                                        someone new" to get started.</p>
                                @endforelse



                                    </div>

                                    {{-- Add someone new button --}}
                                    <button type="button" class="add-new-button" id="addNewInheritor" data-toggle="modal" data-target="#addExecutorModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add someone new
                                    </button>

                                    <p class="text-gray-700 leading-relaxed mt-8 mb-4">
                                        If you'd prefer to leave your estate to charity instead, just save and
                                        continue to the next page.
                                    </p>

                                    <div class="d-flex justify-content-between mt-5">
                                        <a href="{{ route('partner.will_generator.estates') }}"
                                            class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                            &larr; Back
                                        </a>

                                        <button type="submit"
                                            class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                            Save and continue
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 sidebar-col"> {{-- Adjusted column width for the sidebar --}}
                        <div class="inheritance-summary-card">
                            <h4>Inheriting your estate:</h4>
                            <ul id="inheritanceSummaryList">
                                {{-- These items will be dynamically updated by JavaScript --}}
                                <li>Keane Woodward</li>
                                <li>Thane Dillard</li>
                                <li>Lane Rodgers</li>
                                <li>The RNLI</li>
                                <li>Macmillan Cancer Support</li>
                                <li>Esdhi International Foundation UK</li>
                                <li>The Charities Aid Foundation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="addExecutorModal" tabindex="-1" role="dialog" aria-labelledby="addExecutorModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExecutorModalLabel">Add Executor</h5>
                </div>
                <div class="modal-body">
                    <form id="addExecutorForm">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                                placeholder="Enter Title" required>
                            <div class="text-danger" id="error-title"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="name">First Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter First Name" required>
                            <div class="text-danger" id="error-name"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="lastname"
                                placeholder="Enter Last Name" required>
                            <div class="text-danger" id="error-lastname"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="how_acting">How Acting?</label>
                            <select class="form-control" name="how_acting" id="how_acting" required>
                                <option value="" disabled>-- Select --</option>
                                <option value="Solely">Solely</option>
                                <option value="Main">Main</option>
                                <option value="Reserve">Reserve</option>
                            </select>
                            <div class="text-danger" id="error-how_acting"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number">Contact Number(s)</label>
                            <input type="text" class="form-control" name="phone_number" id="phone_number"
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
                            <select class="form-control" name="relationship" id="relationship" required>
                                <option value="Family">Family</option>
                                <option value="Friend">Friend</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="text-danger" id="error-relationship"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Access Type</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value="A">Immediate Access</option>
                                <option value="N">Upon Death</option>
                            </select>
                            <div class="text-danger" id="error-status"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Enter Password" required>
                            <div class="text-danger" id="error-password"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="password_confirmation" placeholder="Confirm Password" required>
                            <div class="text-danger" id="error-password_confirmation"></div>
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
        aria-labelledby="editExecutorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editExecutorModalLabel">Edit Executor</h5>
                </div>
                <div class="modal-body">
                    <form id="editExecutorForm">
                        @csrf
                        <input type="hidden" name="id" id="editExecutorId">
                        <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="edit_title"
                                placeholder="Enter Title" required>
                            <div class="text-danger" id="edit-error-title"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_name">First Name</label>
                            <input type="text" class="form-control" name="name" id="edit_name"
                                placeholder="Enter First Name" required>
                            <div class="text-danger" id="edit-error-name"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_lastname">Last Name</label>
                            <input type="text" class="form-control" name="lastname" id="edit_lastname"
                                placeholder="Enter Last Name" required>
                            <div class="text-danger" id="edit-error-lastname"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_how_acting">How Acting?</label>
                            <select class="form-control" name="how_acting" id="edit_how_acting" required>
                                <option value="" disabled>-- Select --</option>
                                <option value="Solely">Solely</option>
                                <option value="Main">Main</option>
                                <option value="Reserve">Reserve</option>
                            </select>
                            <div class="text-danger" id="error-edit_how_acting"></div>
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
                            <select class="form-control" name="relationship" id="edit_relationship" required>
                                <option value="Family">Family</option>
                                <option value="Friend">Friend</option>
                                <option value="Other">Other</option>
                            </select>
                            <div class="text-danger" id="edit-error-relationship"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_status">Access Type</label>
                            <select class="form-control" name="status" id="edit_status" required>
                                <option value="A">Immediate Access</option>
                                <option value="N">Upon Death</option>
                            </select>
                            <div class="text-danger" id="edit-error-status"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_password">Password</label>
                            <input type="password" class="form-control" name="password" id="edit_password"
                                placeholder="Enter Password">
                            <div class="text-danger" id="edit-error-password"></div>
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_password_confirmation">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation"
                                id="edit_password_confirmation" placeholder="Confirm Password">
                            <div class="text-danger" id="edit-error-password_confirmation"></div>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                    <form action="{{ route('partner.executors.destroy', $executor->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                </div>
            </div>
        </div>
    </div>
    {{-- Include necessary scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                $('#error-password').text('');
                $('#error-password_confirmation').text('');
                $('#error-how_acting').text('');
            }

            function clearEditErrors() {
                $('#error-title').text('');
                $('#edit-error-name').text('');
                $('#edit-error-lastname').text('');
                $('#error-phone_number').text('');
                $('#edit-error-email').text('');
                $('#edit-error-relationship').text('');
                $('#edit-error-status').text('');
                $('#edit-error-password').text('');
                $('#edit-error-password_confirmation').text('');
                $('#edit-error-how_acting').text('');
            }

            // Handle submission of add executor form
            $('#addExecutorForm').on('submit', function(e) {
                e.preventDefault();
                clearAddErrors(); // Clear previous error messages

                $.ajax({
                    url: "{{ route('partner.executors.store') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        $('#error-title').text(errors.title);
                        $('#error-name').text(errors.name);
                        $('#error-lastname').text(errors.lastname);
                        $('#error-email').text(errors.email);
                        $('#error-relationship').text(errors.relationship);
                        $('#error-status').text(errors.status);
                        $('#error-password').text(errors.password);
                        $('#error-password_confirmation').text(errors.password_confirmation);
                        $('#error-how_acting').text(errors.how_acting);
                    }
                });
            });

            // Handle click on edit button for executor
            $('.edit-button').on('click', function() {
                var id = $(this).data('id');
                var title = $(this).data('title');
                var name = $(this).data('name');
                var lastname = $(this).data('lastname');
                var phone_number = $(this).data('phone_number');
                var email = $(this).data('email');
                var relationship = $(this).data('relationship');
                var status = $(this).data('status');
                var how_acting = $(this).data('how_acting');

                $('#editExecutorId').val(id);
                $('#edit_title').val(title);
                $('#edit_name').val(name);
                $('#edit_lastname').val(lastname);
                $('#edit_phone_number').val(phone_number);
                $('#edit_email').val(email);
                $('#edit_relationship').val(relationship);
                $('#edit_status').val(status);
                $('#edit_how_acting').val(how_acting);
                clearEditErrors(); // Clear previous error messages
            });

            // Handle submission of edit executor form
            $('#editExecutorForm').on('submit', function(e) {
                e.preventDefault();
                var id = $('#editExecutorId').val();
                clearEditErrors(); // Clear previous error messages

                $.ajax({
                    url: "/partner/executors/update/" + id,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function(response) {
                        var errors = response.responseJSON.errors;
                        $('#edit-error-name').text(errors.name);
                        $('#edit-error-lastname').text(errors.lastname);
                        $('#edit-error-email').text(errors.email);
                        $('#edit-error-relationship').text(errors.relationship);
                        $('#edit-error-status').text(errors.status);
                        $('#edit-error-password').text(errors.password);
                        $('#edit-error-password_confirmation').text(errors
                            .password_confirmation);
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Function to update the inheritance summary list
            function updateInheritanceSummary() {
                const summaryList = $('#inheritanceSummaryList');
                summaryList.empty(); // Clear existing list

                // Get checked inheritors from the form
                $('input[name="inheritors[]"]:checked').each(function() {
                    const personName = $(this).closest('.person-item').find('.person-name').text();
                    summaryList.append(`<li>${personName}</li>`);
                });

                if ($('input[name="inheritors[]"]:checked').length > 0) {
                    summaryList.append(`<li>The RNLI</li>`);
                    summaryList.append(`<li>Macmillan Cancer Support</li>`);
                    summaryList.append(`<li>Esdhi International Foundation UK</li>`);
                    summaryList.append(`<li>The Charities Aid Foundation</li>`);
                } else {

                }

                if (summaryList.children().length === 0) {
                    summaryList.append('<li>None selected</li>');
                }
            }

            updateInheritanceSummary();


            $('input[name="inheritors[]"]').on('change', function() {
                updateInheritanceSummary();
            });


        });
    </script>
@endsection
