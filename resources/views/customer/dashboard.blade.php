@extends('layouts.master')

@section('content')
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }
    </style>
    <div class="page-body">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Executor Hub – what is it?</h4>
                        </div>
                        <div class="card-body">

                            <p>Executor Hub is your personal vault and instruction manual for the people you leave behind.
                                It stores your important documents securely, helps your executors know exactly what to do,
                                and gives your loved ones clarity when they need it most.</p>
                            <p>Rather than leaving them to play detective at a difficult time, Executor Hub gives you the
                                peace of mind that everything’s organised, accessible, and explained.</p>
                            <p>It’s not just storage – it’s guidance, structure, and a helping hand for the people you care
                                about most. It can save time, money, stress – and even help avoid family fallouts.</p>
                            <p>It’s one of the most thoughtful things you can leave behind.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="card">
                        <h3 class="text-center pt-2 pb-2">
                            Download the App on App Store -
                            <span> <a href="https://apps.apple.com/us/app/executor-hub/id6737507623" target="_blank"
                                    class="text-center" style="font-size: 18px;">Click Here to Download!</a></span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        @if($user->referrer)
            <div class="container">
                <div class="row">
                    <div class="card">
                        <h2 class="p-2">You Are Referred By: {{ $user->referrer->name }}</h2>
                    </div>
                </div>
            </div>
        @endif

        <!-- ONBOARDING SECTION -->
        <div class="container">
            <div class="row">
                <div class="card">
                    <h2 class="p-2">Onboarding Guide</h2>
                    <button class="btn btn-primary mt-3" id="viewGuideBtn" style="">View Guide</button>
                    <br />
                    <ol>
                        @foreach ($guide as $task)
                            <li style="color: {{ $task['completed'] ? 'green' : 'red' }}">
                                {{ $task['label'] }}
                                @if ($task['completed'])
                                    (Completed)
                                @endif
                                - <a href="{{ $task['url'] }}">View Page</a>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
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
                                            <div class="d-flex student-arrow text-truncate">
                                            </div>
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
                            <form method="POST" action="{{ route('customer.dashboard.store-location') }}" class="d-flex">
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
                                                            action="{{ route('customer.dashboard.delete-location', $location->id) }}"
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
                                                        <a href="{{ route('customer.documents.view') }}"
                                                            class="btn btn-success btn-sm">
                                                            Upload Document
                                                        </a>
                                                    @else
                                                        <a href="{{ route('customer.documents.view') }}"
                                                            class="btn btn-info btn-sm">
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

        <!-- GUIDE MODAL -->
        <div class="modal fade" id="guideModal" tabindex="-1" aria-labelledby="guideModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Executor Hub Onboarding Guide</h5>
                        <button type="button" class="btn-close" aria-label="Close" id="modalCloseBtn"></button>

                    </div>
                    <div class="modal-body">
                        <!-- Step Contents -->
                        <div class="step active" data-audio="{{ asset('assets/customer_guide_audios/audio1.mp3') }}">
                            <h4>Welcome & Get Set Up</h4>
                            <p>Welcome to Executor Hub!</p>
                            <p>Before you start, download our mobile app for easy access anywhere, anytime.</p>
                            <p>Enable notifications so you never miss a reminder or update.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio2.mp3') }}">
                            <h4>Your Portal</h4>
                            <p>This is your Customer Portal — it’s not for managing an estate (that’s the Executor Portal).
                            </p>
                            <p>Here, you’ll record important details, documents, and wishes to make the process as easy as
                                possible for those left behind.</p>
                            <p>It’s one of the most thoughtful things you can do for your executor.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio3.mp3') }}">
                            <h4>Your Onboarding Steps</h4>
                            <p>Follow the Onboarding Guide:</p>
                            <ul>
                                <li>Navigate using the left-hand menu or click the steps listed.</li>
                                <li>Take your time and complete each section as thoroughly as possible.</li>
                                <li>You can set your own reminder frequency to keep everything up to date.</li>
                                <li>Each tab has extra help available if you need it.</li>
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio4.mp3') }}">
                            <h4>Capacity Proof Videos</h4>
                            <p>Complete your Capacity Proof Videos — short, guided recordings that help show you had full
                                mental capacity when making your plans.</p>
                            <p>This extra step can be invaluable for protecting your wishes.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio5.mp3') }}">
                            <h4>Trusted Advisors</h4>
                            <p>Add your Trusted Advisors — professionals or loved ones who can help manage your affairs if
                                needed.</p>
                            <p>You control what they can see and do by setting their permissions.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio6.mp3') }}">
                            <h4>Life Remembered</h4>
                            <p>This is your personal memory vault.</p>
                            <p>Store photos, videos, and voice notes here to share treasured memories, messages, or final
                                words with loved ones.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio7.mp3') }}">
                            <h4>Save & Return Anytime</h4>
                            <p>You don’t need to complete everything in one go.</p>
                            <p>Your progress is saved automatically — come back anytime to add or update information.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio8.mp3') }}">
                            <h4>Getting Help</h4>
                            <p>If you need assistance:</p>
                            <p>Use the Live Chat button</p>
                            <p>Email us at hello@executorhub.co.uk</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio9.mp3') }}">
                            <h4>Review Regularly</h4>
                            <p>Keep your information up to date.</p>
                            <p>We recommend reviewing your portal at least once a year or whenever there’s a major life
                                change.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/customer_guide_audios/audio10.mp3') }}">
                            <h4>Share the Gift</h4>
                            <p>Tell your loved ones about Executor Hub and encourage them to subscribe.</p>
                            <p>It’s a simple way for them to give the same thoughtful gift of preparation to their
                                executors.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-secondary" id="prevBtn" disabled>Previous</button>
                        <button class="btn btn-primary" id="nextBtn">Next</button>
                        <button class="btn btn-success d-none" id="finishBtn">Finish</button>
                    </div>
                </div>
            </div>
        </div>
        <audio id="stepAudio" autoplay hidden></audio>
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
                    url: "{{ route('customer.dashboard.update-reminder') }}",
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
                    url: '/customer/dashboard/update-location/' + id,
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

    <script>
        const steps = document.querySelectorAll('.step');
        const nextBtn = document.getElementById('nextBtn');
        const prevBtn = document.getElementById('prevBtn');
        const finishBtn = document.getElementById('finishBtn');
        const viewGuideBtn = document.getElementById('viewGuideBtn');
        const guideModal = new bootstrap.Modal(document.getElementById('guideModal'));
        const stepAudio = document.getElementById('stepAudio');
        const repeatButtons = document.querySelectorAll('.repeatBtn');
        let currentStep = 0;

        repeatButtons.forEach((btn, index) => {
            btn.addEventListener('click', () => {
                const audio = steps[index].getAttribute('data-audio');
                if (audio) {
                    stepAudio.src = audio;
                    stepAudio.play();
                }
            });
        });


        function showStep(index) {
            steps.forEach((step, i) => {
                step.classList.remove('active');
                if (i === index) {
                    step.classList.add('active');
                    let audio = step.getAttribute('data-audio');
                    if (audio) {
                        stepAudio.src = audio;
                        stepAudio.play();
                    }
                }
            });

            prevBtn.disabled = index === 0;
            nextBtn.classList.toggle('d-none', index === steps.length - 1);
            finishBtn.classList.toggle('d-none', index !== steps.length - 1);
        }

        nextBtn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });

        prevBtn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });

        viewGuideBtn.addEventListener('click', () => {
            currentStep = 0;
            showStep(currentStep);
            guideModal.show();
        });

        function stopAudio() {
            const audio = document.getElementById('stepAudio');
            if (audio) {
                audio.pause();
                audio.currentTime = 0;
            }
        }

        document.getElementById('modalCloseBtn').addEventListener('click', () => {
            stopAudio();
            guideModal.hide();
        });

        document.getElementById('finishBtn').addEventListener('click', () => {
            stopAudio();
            guideModal.hide();
        });

        document.addEventListener("DOMContentLoaded", function () {
            // Show modal only on first visit
            if (!localStorage.getItem('hasVisited')) {
                guideModal.show();
                showStep(currentStep); // ✅ move inside
                localStorage.setItem('hasVisited', 'true');
            }
        });

    </script>

@endsection