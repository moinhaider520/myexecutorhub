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

        <!-- Coupon Section -->
        <div class="container">
            <div class="row mb-4">
                <div class="col text-center">
                    <h5>Your Coupon Code:</h5>
                    <p class="lead" id="couponCode">{{ auth()->user()->coupon_code ?? 'No Coupon Code Available' }}</p>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#assignModal">Copy Affiliate
                        Link</button>
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
                                            <h2>{{ $subpartners }}</h2>
                                            <p class="mb-0 text-truncate">Total Partners</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>{{ $customers_invited }}</h2>
                                            <p class="mb-0 text-truncate">Total Customers</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>{{ $subscribed_customers_invited }}</h2>
                                            <p class="mb-0 text-truncate">Active customers</p>
                                        </div>
                                        <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png"
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
                                            <h2>£{{ number_format(auth()->user()->commission_amount, 2) }}</h2>
                                            <p class="mb-0 text-truncate">Revenue </p>
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
                                <h5 class="card-header">Customers Referred with Your Coupon Code (Directly)</h5>
                                <div class="card-body">
                                    @if($referredUsers->isEmpty())
                                        <p>No customer has used your coupon code yet.</p>
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
                                                            <th>Package</th>
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
                                                                <td>{{ $referral->user->subscribed_package ?? '-' }} Package</td>
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
                            <h4>Step 1 – Welcome</h4>
                            <p>Welcome to Executor Hub for Partners.</p>
                            <p>You’re joining a platform that simplifies estate administration for your clients — while
                                creating a steady stream of passive income for you.</p>
                            <p>We’ll get you set up in a few quick steps so you can start earning today.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio2.mp3') }}">
                            <h4>Step 2 – Dashboard Overview</h4>
                            <p>From your Dashboard you can:</p>
                            <ol>
                                <li>See your total, active, and inactive customers</li>
                                <li>View your revenue this month</li>
                                <li>Monitor referrals and client activity</li>
                                <li>Receive notifications when clients upload documents</li>
                            </ol>
                            <p>Tip: This is your home base — check here regularly to track earnings and follow up with
                                clients.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio3.mp3') }}">
                            <h4>Step 3 – Invite Other Partners & Advisers</h4>
                            <ol>
                                <li>Go to Partners in the left menu.</li>
                                <li>Click Add Partner.</li>
                                <li>Enter their name, email, and role.</li>
                                <li>Click Send Invite.</li>
                            </ol>
                            <p>Why? You’ll earn commission from the clients they refer — building a passive income stream.
                            </p>
                            <p>Example: Invite 5 partners who each sign up 10 clients = extra commission every month without
                                you signing up those clients yourself.</p>
                            <video id="referralsVideo" style="width:100%;height:450px;" autoplay muted playsinline>
                                <source src="{{ asset('assets/invite_partners.mkv') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio4.mp3') }}">
                            <h4>Step 4 – Add Your Bank Details</h4>
                            <ol>
                                <li>Click Withdrawals in the left menu.</li>
                                <li>Enter your bank details securely.</li>
                                <li>Save changes.</li>
                            </ol>
                            <p>Why? Without this step, we can’t pay your commission. Set it up now to avoid delays.</p>
                            <video id="referralsVideo" style="width:100%;height:450px;" autoplay muted playsinline>
                                <source src="{{ asset('assets/add_bank_account.mkv') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio5.mp3') }}">
                            <h4>Step 5 – Invite Your First Clients</h4>
                            <ol>
                                <li>Click Invite Friends in the left menu.</li>
                                <li>Copy your affiliate link or coupon code.</li>
                                <li>Share it by email, text, or social media.</li>
                            </ol>
                            <p>Tip: Only clients who sign up using your link or code will be counted for your commission.
                            </p>
                            <video id="referralsVideo" style="width:100%;height:450px;" autoplay muted playsinline>
                                <source src="{{ asset('assets/invite_customers.mkv') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio6.mp3') }}">
                            <h4>Step 6 – Manage Your Customers</h4>
                            <ol>
                                <li>Click Customers in the menu.</li>
                                <li>Use the list to follow up with clients.</li>
                                <li>Re-engage inactive customers to increase platform usage.</li>
                            </ol>
                            <p>Why? The more active your clients are, the more opportunities you have to offer services —
                                and earn.
                            </p>
                            <video id="customersVideo" style="width:100%;height:450px;" autoplay muted playsinline>
                                <source src="{{ asset('assets/view_customers.mkv') }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio7.mp3') }}">
                            <h4>Step 7 – Track Activity & Earnings</h4>
                            <ol>
                                <li>Notifications: Alerts you when clients upload key documents.</li>
                                <li>Revenue This Month: Shows your current earnings in real time.</li>
                            </ol>
                            <p>Tip: Use notifications as prompts to offer extra services or schedule reviews.</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio8.mp3') }}">
                            <h4>Step 8 – You’re Ready to Go 🚀</h4>
                            <ol>
                                <li>Partner profile set up</li>
                                <li>Bank details saved</li>
                                <li>First client invite ready</li>
                            </ol>
                            <p>Next step: Invite as many clients as you see appropriate and start earning whilst giving them
                                peace of mind .</p>
                            <button type="button" class="btn btn-outline-secondary repeatBtn mt-2">Repeat</button>
                        </div>

                        <div class="step" data-audio="{{ asset('assets/partner_guide_audios/audio9.mp3') }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <h2 class="p-2">Video Title: Partner Welcome</h2>
                                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                                            <source src="{{ asset('assets/knowledgebase/video1.mp4') }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h2 class="p-2">Title: Earn with us!</h2>
                                    <video id="earningVideo" style="width:100%;height:210px;" controls>
                                        <source src="{{ asset('assets/earning_video.mp4') }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <h2 class="p-2">Title: How to Introduce Executor Hub to Clients</h2>
                                        @if(auth()->user()->profession == "General")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/video2.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Solicitors")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/solicitor.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Will writers")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/willwriters.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Estate planners")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/estate_planners.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Financial advisers")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/financial_advisers.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Ifas")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/ifas.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Life insurance specialists")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/life_insurance_specialists.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Accountants")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/accountants.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Networks")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/networks.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Societies")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/socities.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>

                                        @elseif(auth()->user()->profession == "Regulatory bodies")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/regulators.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @elseif(auth()->user()->profession == "Institutes")
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/institues.mp4') }}"
                                                    type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @else
                                            <video id="earningVideo" style="width:100%;height:390px;" controls>
                                                <source src="{{ asset('assets/knowledgebase/video2.mp4') }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <h2 class="p-2">Video Title: Client Explainer</h2>
                                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                                            <source src="{{ asset('assets/knowledgebase/video3.mp4') }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <h2 class="p-2">Video Title: Partner Success & Commission</h2>
                                        <video id="earningVideo" style="width:100%;height:390px;" controls>
                                            <source src="{{ asset('assets/knowledgebase/video4.mp4') }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                </div>
                            </div>
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
        const video = document.getElementById('customersVideo');

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