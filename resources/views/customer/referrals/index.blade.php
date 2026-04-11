@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Referral Hub</h4>
                        <span>Invite executors and advisers, track active invites, and monitor wallet rewards.</span>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3 mb-4">
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Rewarded Referrals</small>
                                    <h2 class="mb-1">{{ $referralsUsed }}/10</h2>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $progressPercent }}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Available Wallet</small>
                                    <h2 class="mb-0">£{{ number_format($wallet->available_balance, 2) }}</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Pending Wallet</small>
                                    <h2 class="mb-0">£{{ number_format($wallet->pending_balance, 2) }}</h2>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <small class="text-muted d-block">Pending Rewards</small>
                                    <h2 class="mb-0">{{ $pendingRewards }}</h2>
                                </div>
                            </div>
                        </div>

                        <div class="border rounded p-3 mb-4">
                            <label for="personalReferralLink" class="form-label">Personal referral link</label>
                            <div class="input-group">
                                <input type="text" readonly class="form-control" id="personalReferralLink" value="{{ $personalReferralLink }}">
                                <button class="btn btn-outline-primary" type="button" id="copyReferralLink">Copy</button>
                            </div>
                            <small class="text-muted d-block mt-2">Referral code: {{ $referralCode }}</small>
                        </div>

                        <ul class="nav nav-tabs" id="referralTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="executor-tab" data-bs-toggle="tab" data-bs-target="#executor-panel" type="button" role="tab">Executor</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="advisor-tab" data-bs-toggle="tab" data-bs-target="#advisor-panel" type="button" role="tab">Advisor</button>
                            </li>
                        </ul>

                        <div class="tab-content border border-top-0 rounded-bottom p-4 mb-4">
                            <div class="tab-pane fade show active" id="executor-panel" role="tabpanel">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                                    <div>
                                        <h5 class="mb-1">Invite an executor</h5>
                                        <p class="text-muted mb-0">Use the same executor modal here so the referral flow captures the full executor details and can link existing executor accounts safely.</p>
                                    </div>
                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        data-toggle="modal"
                                        data-target="#referralExecutorModal"
                                        data-bs-toggle="modal"
                                        data-bs-target="#referralExecutorModal"
                                    >
                                        Add Executor
                                    </button>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="advisor-panel" role="tabpanel">
                                <form method="POST" action="{{ route('customer.referrals.advisors.store') }}">
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Adviser type</label>
                                            <select class="form-control" name="adviser_type" required>
                                                <option value="Solicitors">Solicitors</option>
                                                <option value="Accountants">Accountants</option>
                                                <option value="Stock Brokers">Stock Brokers</option>
                                                <option value="Will Writers">Will Writers</option>
                                                <option value="Financial Advisers">Financial Advisers</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Practice name</label>
                                            <input type="text" name="practice_name" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Practice address</label>
                                            <input type="text" name="practice_address" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Phone number</label>
                                            <input type="text" name="phone_number" class="form-control" required>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-3">Send Advisor Invite</button>
                                </form>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Invitee</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Discount</th>
                                        <th>Expires</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($invites as $invite)
                                        <tr>
                                            <td>
                                                <strong>{{ $invite->name ?: 'Pending contact' }}</strong><br>
                                                <small class="text-muted">{{ $invite->email }}</small>
                                            </td>
                                            <td>{{ ucfirst($invite->invite_type) }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $invite->status)) }}</td>
                                            <td>{{ $invite->discount_percent }}%</td>
                                            <td>
                                                {{ $invite->expires_at?->format('d M Y, H:i') }}<br>
                                                @if ($invite->expires_at && $invite->expires_at->isFuture())
                                                    <small class="text-muted">{{ $invite->expires_at->diffForHumans() }}</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">No invites sent yet.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="referralExecutorModal" tabindex="-1" role="dialog" aria-labelledby="referralExecutorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="referralExecutorModalLabel">Add Executor</h5>
            </div>
            <div class="modal-body">
                <form id="referralExecutorForm">
                    @csrf
                    <input type="hidden" name="confirm_existing_executor" id="referral_confirm_existing_executor" value="0">

                    <div class="form-group mb-3">
                        <label for="referral_title">Title</label>
                        <input type="text" class="form-control" name="title" id="referral_title" placeholder="Enter Title" required>
                        <div class="text-danger" id="referral-error-title"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_name">First Name</label>
                        <input type="text" class="form-control" name="name" id="referral_name" placeholder="Enter First Name" required>
                        <div class="text-danger" id="referral-error-name"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_lastname">Last Name</label>
                        <input type="text" class="form-control" name="lastname" id="referral_lastname" placeholder="Enter Last Name" required>
                        <div class="text-danger" id="referral-error-lastname"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_how_acting">How Acting?</label>
                        <select class="form-control" name="how_acting" id="referral_how_acting" required>
                            <option value="" disabled selected>-- Select --</option>
                            <option value="Solely">Solely</option>
                            <option value="Main">Main</option>
                            <option value="Reserve">Reserve</option>
                        </select>
                        <div class="text-danger" id="referral-error-how_acting"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_phone_number">Contact Number(s)</label>
                        <input type="text" class="form-control" name="phone_number" id="referral_phone_number" placeholder="Enter Contact Number" required>
                        <div class="text-danger" id="referral-error-phone_number"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_email">Email Address</label>
                        <input type="email" class="form-control" name="email" id="referral_email" placeholder="Email Address" required>
                        <div class="text-danger" id="referral-error-email"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_relationship">Relationship</label>
                        <select class="form-control" name="relationship" id="referral_relationship" required>
                            <option value="Family">Family</option>
                            <option value="Friend">Friend</option>
                            <option value="Other">Other</option>
                        </select>
                        <div class="text-danger" id="referral-error-relationship"></div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="referral_status">Access Type</label>
                        <select class="form-control" name="status" id="referral_status" required>
                            <option value="A">Immediate Access</option>
                            <option value="N">Upon Death</option>
                        </select>
                        <div class="text-danger" id="referral-error-status"></div>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Send Executor Invite</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('copyReferralLink').addEventListener('click', function () {
        const input = document.getElementById('personalReferralLink');
        navigator.clipboard.writeText(input.value);
        this.textContent = 'Copied';

        setTimeout(() => {
            this.textContent = 'Copy';
        }, 1500);
    });

    $(document).ready(function () {
        function clearReferralExecutorErrors() {
            $('#referral-error-title').text('');
            $('#referral-error-name').text('');
            $('#referral-error-lastname').text('');
            $('#referral-error-how_acting').text('');
            $('#referral-error-phone_number').text('');
            $('#referral-error-email').text('');
            $('#referral-error-relationship').text('');
            $('#referral-error-status').text('');
        }

        $('#referralExecutorModal').on('show.bs.modal', function () {
            $('#referralExecutorForm')[0].reset();
            $('#referral_confirm_existing_executor').val('0');
            clearReferralExecutorErrors();
        });

        $('#referralExecutorForm').on('submit', function (e) {
            e.preventDefault();
            clearReferralExecutorErrors();

            const form = $(this);

            $.ajax({
                url: "{{ route('customer.referrals.executors.store') }}",
                method: 'POST',
                data: form.serialize(),
                success: function (response) {
                    if (response.success) {
                        window.location.href = "{{ route('customer.referrals.index') }}";
                    }
                },
                error: function (response) {
                    const responseJson = response.responseJSON || {};

                    if (response.status === 409 && responseJson.requires_confirmation) {
                        Swal.fire({
                            title: 'Existing Executor Found',
                            text: responseJson.message,
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'OK',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $('#referral_confirm_existing_executor').val('1');
                                form.trigger('submit');
                            }
                        });

                        return;
                    }

                    if (responseJson.message && !responseJson.errors) {
                        Swal.fire({
                            title: 'Unable to send invite',
                            text: responseJson.message,
                            icon: 'error'
                        });
                        return;
                    }

                    const errors = responseJson.errors || {};
                    $('#referral-error-title').text(errors.title);
                    $('#referral-error-name').text(errors.name);
                    $('#referral-error-lastname').text(errors.lastname);
                    $('#referral-error-how_acting').text(errors.how_acting);
                    $('#referral-error-phone_number').text(errors.phone_number);
                    $('#referral-error-email').text(errors.email);
                    $('#referral-error-relationship').text(errors.relationship);
                    $('#referral-error-status').text(errors.status);
                }
            });
        });
    });
</script>
@endsection
