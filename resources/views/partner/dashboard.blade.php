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
            <div class="row">
                <div class="card">
                    <video id="earningVideo" style="width:100%;height:450px;" controls>
    <source src="{{ asset('assets/earning_video.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
</video>

                </div>
            </div>
        </div>
        <!-- ONBOARDING SECTION -->
        <div class="container">
            <div class="row">
                <div class="card">
                    <h2 class="p-2">Onboarding Guide</h2>
                    <button class="btn btn-primary mt-3" id="viewGuideBtn" style="">View Guide</button>
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
        <!-- Coupon Section -->
        <div class="container">
            <div class="row mb-4">
                <div class="col text-center">
                    <h5>Your Coupon Code:</h5>
                    <p class="lead" id="couponCode">{{ auth()->user()->coupon_code ?? 'No Coupon Code Available' }}</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#assignModal">Copy Affiliate
                        Link</button>
                </div>
                <div class="col text-center">
                    <h5>Your Commission Amount:</h5>
                    <p class="lead">£{{ number_format(auth()->user()->commission_amount, 2) }}</p>
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
                                        <p>No Users have used your coupon yet.</p>
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
                                                            <th>Reffered By</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($referredUsers as $index => $referral)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $referral->user->name ?? '-' }}</td>
                                                                <td>{{ $referral->user->email ?? '-' }}</td>
                                                                <td>{{ $referral->created_at->format('d M Y') }}</td>
                                                                <td>{{ $referral->user->reffered_by ?? '-' }}</td>
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
                        <div class="step active" data-audio="{{ asset('assets/partner_guide_audios/audio1.mp3') }}">
                            <h4>Welcome to Executor Hub for Partners</h4>
                            <p>You’re joining a digital platform built to simplify estate administration for your clients
                                and grow your business with passive income opportunities. Let's get started.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio2.mp3') }}">
                            <h4>Account Setup</h4>
                            <p>Please go to the Advisers Tab from the sidemenu. Click on Add Adviser and choose your partner
                                type. For example an Adviser, Will Writer or a Solicitor. Enter your Partner details and
                                click on save to send them an invite.</p>
                            <h5>Step 1:</h5>
                            <img src="{{ asset('assets/partner_guide_images/image1.png') }}"
                                style="width:100%;height:450px;" />
                            <h5>Step 2:</h5>
                            <img src="{{ asset('assets/partner_guide_images/image2.png') }}"
                                style="width:100%;height:450px;" />
                            <h5>Step 3:</h5>
                            <img src="{{ asset('assets/partner_guide_images/image3.png') }}"
                                style="width:100%;height:450px;" />

                            <h5>How to view my referrals? (Click on the Video to Pause/UnPause)</h5>
                            <video id="referralsVideo" style="width:100%;height:450px;">
                                <source src="{{ asset('assets/view_refferals.mkv') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio3.mp3') }}">
                            <h4>Your Dashboard</h4>
                            <p>Your Dashboard gives you an overview of your networth, documents uploaded, executors and
                                tasks that need to be completed. You can have an overview of the commission you've earned
                                and see your coupon code that you can use to invite clients.</p>
                            <img src="{{ asset('assets/partner_guide_images/image4.png') }}"
                                style="width:100%;height:450px;" />

                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio4.mp3') }}">
                            <h4>Invite Your First Client</h4>
                            <ul>
                                <p>You can copy your coupon code from your main dashboard and share it with your clients via
                                    email, text or any other platform. Your client can then enter the coupon code at the
                                    time of sign up allowing you to earn your commission.</p>
                                <img src="{{ asset('assets/partner_guide_images/image5.png') }}"
                                    style="width:100%;height:450px;" />
                            </ul>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio5.mp3') }}">
                            <h4>Benefits Overview</h4>
                            <ul>
                                <p>You can get automated email notifications when your client uploads a key document. You
                                    can access your annual review of documents, LPA's and investment prompts. Your Digital
                                    journey is aligned with UK digital ID plans (Wallet-ready)</p>
                            </ul>
                            <h4>See why professionals are partnering with Executor Hub</h4>
                            <div class="row justify-content-center">
                                <div class="col">
                                    <div class="bc-5-img bc-5-tablet img-block-hidden video-preview wow fadeInUp">
                                        <video width="100%" controls poster="optional-poster.jpg">
                                            <source src="{{ asset('assets/frontend/partner.mp4') }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            </div>
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

        <!-- AFFILIATE MODAL -->
        <!-- Modal -->
        <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignModalLabel">Assign To Staff Member</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="text" id="staffMemberName" class="form-control"
                            placeholder="Enter staff member name (optional)">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="generateAndCopyLink()">Copy Affiliate
                            Link</button>
                    </div>
                </div>
            </div>
        </div>

        <audio id="stepAudio" autoplay hidden></audio>
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

    <script>
        function generateAndCopyLink() {
            var couponCode = document.getElementById('couponCode').innerText.trim();
            var staffName = document.getElementById('staffMemberName').value.trim();

            if (couponCode && couponCode !== 'No Coupon Code Available') {
                var url = "{{ url('/partner_registration') }}" + "?coupon_code=" + encodeURIComponent(couponCode);
                if (staffName) {
                    url += "&assigned_to=" + encodeURIComponent(staffName);
                }

                navigator.clipboard.writeText(url).then(function () {
                    alert('Affiliate link copied to clipboard!');
                    var modal = bootstrap.Modal.getInstance(document.getElementById('assignModal'));
                    modal.hide(); // Close modal after copying
                }, function (err) {
                    alert('Failed to copy: ' + err);
                });
            } else {
                alert('No valid coupon code available.');
            }
        }
    </script>

    <script>
        const video = document.getElementById('referralsVideo');

        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    </script>

    <script>
        const video = document.getElementById('earningVideo');

        video.addEventListener('click', () => {
            if (video.paused) {
                video.play();
            } else {
                video.pause();
            }
        });
    </script>

@endsection