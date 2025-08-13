@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* ... existing styles ... */
        .child-details-wrapper {
            display: none;
            /* Initially hidden */
        }

        .child-detail-item {
            margin-bottom: 20px;
            /* Add some spacing between child items */
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
                                    action="{{ route('customer.will_generator.store_step4') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="will_user_id" id="will_user_id" value="{{$will_user_id}}">
                                    <script src="https://cdn.tailwindcss.com"></script>
                                    <div class="stepper row g-3 needs-validation custom-input" novariate="">
                                        <div class="col-sm-12">

                                            <h1 id="childrenQuestion"
                                                class="text-2xl sm:text-2xl font-bold text-gray-800 mb-4">
                                                Do you have any children?<span class="txt-danger">*</span>
                                            </h1>
                                            <p class="text-gray-600 mb-2">
                                                If your first child is on the way, select "No" for now. You can always
                                                update this in the future.
                                            </p>
                                            <p class="text-gray-600 mb-2">
                                                Add all your biological and legally adopted children, whether or not you
                                                want to leave things to them in
                                                your will.
                                            </p>
                                            <p class="text-gray-600 mb-6">
                                                Do not add any step children here. You can add them later if you wish to
                                                leave them part of your estate.
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
                                                <input type="hidden" name="children" id="children">
                                            </div>

                                            <div id="childrenContentWrapper" class="child-details-wrapper">
                                                <div id="existingChildrenList">

                                                    @include('customer.will_generator.ajax.children_list', ['children' => $children])
                                                </div>

                                                <div id="addChildButtonContainer">
                                                    <button type="button"
                                                        class="w-full py-3 px-4 bg-white border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-700 transition-all duration-200 flex items-center justify-center"
                                                        data-toggle="modal" data-target="#addWillChildModal">
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
                                                        Add child
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                            </div>
                            <div class="wizard-footer d-flex gap-2 justify-content-end mt-2 m-4">
                                <button class="btn badge-light-primary" id="backbtn" onclick="history.back()" >
                                    Back</button>
                                <button class="btn btn-primary"
                                    id="nextbtn">Next</button>
                            </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal" id="addWillChildModal" tabindex="-1" role="dialog" aria-labelledby="addWillChildModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="addWillChildForm">
                @csrf
                <input type="hidden" name="will_user_id" id="will_user_id" value="{{$will_user_id}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addWillChildModalLabel">Add a child
                        </h5>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Child Full Name</label>
                            <input type="text" class="form-control" name="name" id="name"
                                placeholder="Enter Child Name" required>
                            <div class="text-danger" id="error-add-name"></div> {{-- Changed ID for clarity --}}
                        </div>
                        <div class="form-group mb-3">
                            <label for="date_of_birth">Date Of Birth</label>
                            <input type="date" class="form-control" name="child_date_of_birth" id="date_of_birth"
                                placeholder="Enter Date of birth" required>
                            <div class="text-danger" id="error-add-date_of_birth"></div> {{-- Changed ID for clarity --}}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChildButton">Save changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="modal" id="editWillChildModal" tabindex="-1" role="dialog" aria-labelledby="editWillChildModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form id="editWillChildForm">
                @csrf
                <input type="hidden" name="will_user_id" id="will_user_id" value="{{$will_user_id}}">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editWillChildModalLabel">Edit Child
                        </h5>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="child_id" id="edit_child_id">
                        <div class="form-group mb-3">
                            <label for="name">Child Name</label>
                            <input type="text" class="form-control" name="child_name" id="edit_child_name"
                                placeholder="Enter Child Name" required>
                            <div class="text-danger" id="error-edit-name"></div> {{-- Changed ID for clarity --}}
                        </div>
                        <div class="form-group mb-3">
                            <label for="edit_child_date_of_birth">Date Of Birth</label>
                            <input type="date" class="form-control" name="edit_child_date_of_birth"
                                id="edit_child_date_of_birth" placeholder="Enter Date of birth" required>
                            <div class="text-danger" id="error-edit-date_of_birth"></div> {{-- Changed ID for clarity --}}
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="deleteChildButton">Remove Child</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateChildButton">Update changes</button>
                    </div>
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
        // Get references to the DOM elements
        const yesOption = document.getElementById('yesOption');
        const noOption = document.getElementById('noOption');
        const childrenContentWrapper = document.getElementById('childrenContentWrapper');
        const existingChildrenList = document.getElementById('existingChildrenList');
        let hasChildren = null;

        function handleSelection(selection) {
            hasChildren = selection; // Update the selection state

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
            if (hasChildren === 'yes') {
                yesOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
                yesOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
                yesOption.querySelector('span').classList.add('text-blue-700');
                yesOption.querySelector('span').classList.remove('text-gray-800');

                // Show the entire wrapper containing child details and add button
                childrenContentWrapper.style.display = 'block';
            } else if (hasChildren === 'no') {
                noOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
                noOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
                noOption.querySelector('span').classList.add('text-blue-700');
                noOption.querySelector('span').classList.remove('text-gray-800');

                // Hide the entire wrapper
                childrenContentWrapper.style.display = 'none';
            }
            $("#children").val(hasChildren);
        }
        window.onload = function() {
            // Include existing children by including the list partial
            @if (count($children) > 0)
                handleSelection('yes');
                $("#children").val('yes');
            @else
                handleSelection(null);
            @endif
        };

        $(document).ready(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            // Helper function for AJAX calls
            function performAjaxCall(url, method, data, successCallback, errorCallback) {
                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status) {
                            $('#existingChildrenList').html(response.data); // Update the list
                            if (response.message) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                            successCallback(response); // Execute specific success logic
                        } else {
                            if (response.message) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: response.message,
                                });
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status === 419) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Session Expired!',
                                text: 'Your session has expired. Please refresh the page.',
                                confirmButtonText: 'Refresh'
                            }).then(() => {
                                location.reload();
                            });
                        } else if (jqXHR.status === 422) {
                            var errors = jqXHR.responseJSON.errors;
                            // Call the provided error callback to handle specific error messages
                            if (errorCallback) {
                                errorCallback(errors);
                            } else {
                                // Fallback for general validation errors if no specific handler
                                let errorMessages = '';
                                for (let field in errors) {
                                    errorMessages += errors[field].join('<br>') + '<br>';
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error!',
                                    html: errorMessages,
                                });
                            }
                        } else {
                            var errorMessage = 'An unexpected error occurred.';
                            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                                errorMessage = jqXHR.responseJSON.message;
                            } else if (errorThrown) {
                                errorMessage = errorThrown;
                            }
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: errorMessage,
                            });
                            console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
                        }
                    }
                });
            }

            // Clear validation error messages in the add modal
            function clearAddErrors() {
                $('#error-add-name').text('');
                $('#error-add-date_of_birth').text('');
            }

            // Clear validation error messages in the edit modal
            function clearEditErrors() {
                $('#error-edit-name').text('');
                $('#error-edit-date_of_birth').text('');
            }


            $('#saveChildButton').on('click', function(e) {
                e.preventDefault();
                clearAddErrors(); // Clear previous errors
                var childName = $('#name').val();
                var childDateOfBirth = $('#date_of_birth').val();
                var will_user_id = $('#will_user_id').val();
                var postData = {
                    name: childName, // 'name' for store action (matches config in controller)
                    date_of_birth: childDateOfBirth,
                    will_user_id: will_user_id
                };

                performAjaxCall(
                    "{{ route('customer.will_generator.user_child.store') }}", // Use the existing route name
                    'POST',
                    postData,
                    function(response) {
                        // Success callback: clear fields and close modal
                        $('#name').val('');
                        $('#date_of_birth').val('');
                        $('#addWillChildModal').click(); // Use Bootstrap's modal hide
                        handleSelection('yes'); // Ensure 'yes' is selected and details shown
                    },
                    function(errors) {
                        // Error callback: display specific validation errors
                        if (errors.name) {
                            $('#error-add-name').text(errors.name);
                        }
                        if (errors.date_of_birth) {
                            $('#error-add-date_of_birth').text(errors.date_of_birth);
                        }
                    }
                );
            });


            $('#updateChildButton').on('click', function(e) {
                e.preventDefault();
                clearEditErrors(); // Clear previous errors
                var childName = $('#edit_child_name').val();
                var childId = $('#edit_child_id').val();
                var edit_child_date_of_birth = $('#edit_child_date_of_birth').val();
                var will_user_id=$("#will_user_id").val();
                var postData = {
                    child_name: childName, // 'child_name' for edit action (matches config in controller)
                    child_id: childId,
                    edit_child_date_of_birth: edit_child_date_of_birth,
                    will_user_id: will_user_id
                };

                performAjaxCall(
                    "{{ route('customer.will_generator.user_child.edit') }}", // Use the existing route name
                    'POST',
                    postData,
                    function(response) {
                        // Success callback: clear fields and close modal
                        $('#edit_child_name').val('');
                        $('#edit_child_id').val('');
                        $('#edit_child_date_of_birth').val('');
                        $('#editWillChildModal').click(); // Use Bootstrap's modal hide
                        // Re-evaluate if 'yes' should be selected based on remaining children (optional)
                        // If there are no children left after deletion, you might want to switch to 'no'.
                        // This might require re-fetching the list or checking its content.
                    },
                    function(errors) {
                        // Error callback: display specific validation errors
                        if (errors.child_name) { // Note: now checking 'child_name' not 'name' due to controller config
                            $('#error-edit-name').text(errors.child_name);
                        }
                        if (errors.edit_child_date_of_birth) {
                            $('#error-edit-date_of_birth').text(errors.edit_child_date_of_birth);
                        }
                    }
                );
            });

            // Populate edit modal when edit button is clicked
            $(document).on('click', '.edit_button', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var date_of_birth = $(this).data('date');
                $('#edit_child_id').val(id);
                $('#edit_child_name').val(name);
                $('#edit_child_date_of_birth').val(date_of_birth);
                clearEditErrors(); // Clear errors when opening modal
            });


            $('#deleteChildButton').on('click', function(e) {
                e.preventDefault();

                // SweetAlert confirmation
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
                        var childId = $('#edit_child_id').val();
                        var will_user_id=$("#will_user_id").val();
                        var postData = {
                            child_id: childId, // Matches the expected parameter in the controller
                            will_user_id: will_user_id,
                        };

                        performAjaxCall(
                            "{{ route('customer.will_generator.user_child.delete') }}", // Use the existing route name
                            'POST',
                            postData,
                            function(response) {
                                // Success callback: close modal
                                $('#editWillChildModal').click(); // Use Bootstrap's modal hide
                                // Check if the list is empty after deletion and adjust selection
                                if ($('#existingChildrenList').children().length === 0) {
                                    handleSelection('no'); // Switch to 'No' if no children remain
                                }
                            }
                            // No specific error callback needed for delete if generic handles it well
                        );
                    }
                });
            });
        });
    </script>
@endsection
