@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- ONBOARDING SECTION -->
        @if (!collect($guide)->every(fn($completed) => $completed))
            <div class="container">
                <div class="row">
                    <div class="card">
                        <h2 class="p-2">Onboarding Guide</h2>
                        <br />
                        <ol>
                            @foreach ($guide as $task => $completed)
                                @if ($completed)
                                    <li style="color: green;">{{ $task }} (Completed)</li>
                                @else
                                    <li style="color: red;">{{ $task }}</li>
                                @endif
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        @endif
        <!-- Coupon Section -->
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <h5>Your Coupon Code:</h5>
                    <p class="lead">{{ auth()->user()->coupon_code ?? 'No Coupon Code Available' }}</p>
                </div>
                <div class="col text-center">
                    <h5>Your Commission Amount:</h5>
                    <p class="lead">£{{ number_format(auth()->user()->commission_amount, 2) }}</p>
                </div>
            </div>
        </div>
        <!-- Coupon Section end-->
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body student">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <h2>£{{ number_format($totalBankBalance, 2) }}</h2>
                                            <p class="mb-0 text-truncate"> Total Assets Networth</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body student-2">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <h2>£{{ number_format($totalDebt, 2) }}</h2>
                                            <p class="mb-0 text-truncate"> Liabilities Net Worth</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-3/icon/coin1.png"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body student-3">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <h2>{{ $totalDocuments }}</h2>
                                            <p class="mb-0 text-truncate"> Documents Uploaded</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-sm-6">
                            <div class="card">
                                <div class="card-body student-4">
                                    <div class="d-flex gap-2 align-items-end">
                                        <div class="flex-grow-1">
                                            <h2>{{ $totalExecutors }}</h2>
                                            <p class="mb-0 text-truncate"> Executors </p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
                                                alt=""></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Users Referred with Your Coupon</h5>
                                <div class="card-body">
                                    @if($referredUsers->isEmpty())
                                        <p>No users have used your coupon yet.</p>
                                    @else
                                        <div class="table-responsive theme-scrollbar">
                                            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                                                <table class="display dataTable no-footer" id="basic-1" role="grid"
                                                    aria-describedby="basic-1_info">
                                                    <thead>
                                                        <tr role="row">
                                                            <th>#</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Signup Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($referredUsers as $index => $referral)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $referral->user->name ?? '-' }}</td>
                                                                <td>{{ $referral->user->email ?? '-' }}</td>
                                                                <td>{{ $referral->created_at->format('d M Y') }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h4>Location of My Documents</h4>
                                <span>Add and manage storage locations</span>
                            </div>
                            <form method="POST" action="{{ route('partner.dashboard.store-location') }}" class="d-flex">
                                @csrf
                                <input type="text" name="location" class="form-control me-2" placeholder="Add new location"
                                    required>
                                @error('location')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                        <div class="card-body">
                            @if($documentLocations->isEmpty())
                                <p>No locations added yet.</p>
                            @else
                                <div class="table-responsive theme-scrollbar">
                                    <table class="display dataTable no-footer" id="document-locations-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Location</th>
                                                <th>Added At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($documentLocations as $index => $location)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $location->location }}</td>
                                                    <td>{{ $location->created_at->format('d M Y, H:i') }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning edit-location-button"
                                                            data-toggle="modal" data-target="#editLocationModal"
                                                            data-id="{{ $location->id }}"
                                                            data-location="{{ $location->location }}">Edit</button>

                                                        <form
                                                            action="{{ route('partner.dashboard.delete-location', $location->id) }}"
                                                            method="POST" style="display: inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this location?')">Delete</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- EDIT LOCATION MODAL -->
        <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog" aria-labelledby="editLocationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLocationModalLabel">Edit Location</h5>
                    </div>
                    <div class="modal-body">
                        <form id="editLocationForm">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="id" id="editLocationId">
                            <div class="form-group mb-2">
                                <label for="editLocation">Location</label>
                                <input type="text" class="form-control" name="location" id="editLocation"
                                    placeholder="Enter location" required>
                                <span class="text-danger" id="edit_location_error"></span>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="updateLocation">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Document Reminders Section -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Document Status & Reminders</h4>
                            <span>Get reminders for documents you need to upload</span>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive theme-scrollbar">
                                <table class="display dataTable no-footer" id="document-reminders-table">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Status</th>
                                            <th>Reminder Frequency</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allDocumentTypes as $documentType)
                                            <tr>
                                                <td>{{ $documentType }}</td>
                                                <td>
                                                    @if(isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'not_required')
                                                        <span class="badge badge-secondary">Not Required</span>
                                                    @elseif(in_array($documentType, $uploadedDocumentTypes))
                                                        <span class="badge badge-success">Uploaded</span>
                                                    @else
                                                        <span class="badge badge-danger">Not Uploaded</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <select class=" reminder-frequency" data-document-type="{{ $documentType }}"
                                                        {{ in_array($documentType, $uploadedDocumentTypes) ? 'disabled' : '' }}>
                                                        <option value="not_required" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'not_required' ? 'selected' : '' }}>Not Required</option>
                                                        <option value="weekly" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'weekly' ? 'selected' : '' }}>
                                                            Weekly</option>
                                                        <option value="fortnightly" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'fortnightly' ? 'selected' : '' }}>Fortnightly</option>
                                                        <option value="monthly" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'monthly' ? 'selected' : '' }}>
                                                            Monthly</option>
                                                        <option value="quarterly" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'quarterly' ? 'selected' : '' }}>
                                                            Quarterly</option>
                                                        <option value="annually" {{ isset($documentReminders[$documentType]) && $documentReminders[$documentType] == 'annually' ? 'selected' : '' }}>
                                                            Annually</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    @if(!in_array($documentType, $uploadedDocumentTypes))
                                                        <a href="{{ route('partner.documents.view') }}"
                                                            class="btn btn-success btn-sm">
                                                            Upload Document
                                                        </a>
                                                    @else
                                                        <a href="{{ route('partner.documents.view') }}" class="btn btn-info btn-sm">
                                                            View Document
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>

    <!-- Scripts for Document Reminders -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function () {
            // Enable table sorting
            $('#document-reminders-table').DataTable({
                "ordering": true,
                "paging": true,
                "searching": true
            });

            $('#document-locations-table').DataTable({
                "ordering": true,
                "paging": true,
                "searching": true
            });

            // Handle reminder frequency changes
            $('.reminder-frequency').on('change', function () {
                const documentType = $(this).data('document-type');
                const frequency = $(this).val();

                $.ajax({
                    url: "{{ route('partner.dashboard.update-reminder') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        document_type: documentType,
                        frequency: frequency
                    },
                    success: function (response) {
                        if (response.success) {
                            // Show success notification
                            Toastify({
                                text: "Reminder settings updated successfully!",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4caf50"
                            }).showToast();
                        }
                    },
                    error: function (xhr) {
                        // Show error notification
                        Toastify({
                            text: "Error updating reminder settings",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#f44336"
                        }).showToast();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Handle edit button click to populate modal
            $('.edit-location-button').on('click', function () {
                var id = $(this).data('id');
                var location = $(this).data('location');

                $('#editLocationId').val(id);
                $('#editLocation').val(location);
            });

            // Handle update location
            $('#updateLocation').on('click', function () {
                var id = $('#editLocationId').val();

                $.ajax({
                    type: 'POST',
                    url: '/partner/dashboard/update-location/' + id,
                    data: $('#editLocationForm').serialize(),
                    success: function (response) {
                        Toastify({
                            text: "Location updated successfully!",
                            duration: 3000,
                            gravity: "top",
                            position: "right",
                            backgroundColor: "#4caf50"
                        }).showToast();

                        // Optional: reload after short delay to let user see toast
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    },
                    error: function (response) {
                        var errors = response.responseJSON.errors;
                        if (errors && errors.location) {
                            $('#edit_location_error').text(errors.location[0]);
                        } else {
                            Toastify({
                                text: "Failed to update location",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#f44336"
                            }).showToast();
                        }
                    }
                });
            });

        });
    </script>
@endsection