@extends('layouts.master')

@section('content')
    <div class="page-body">
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Partner Customer Access</h4>
                            <span>Buy your own lifetime standard customer access for £99 + VAT and unlock the 6 month refund campaign.</span>
                        </div>
                        <div class="card-body">
                            <p>You will keep your partner login as <strong>{{ $partner->email }}</strong>.</p>
                            <p>After purchase, we will create a separate linked customer account and mailbox such as <strong>{{ preg_replace('/@.*/', '', $partner->email) }}@executorhub.co.uk</strong>. That mailbox will be used for both webmail and the customer dashboard.</p>
                            <p>If you onboard 10 new paying customers on <strong>lifetime standard</strong> or <strong>lifetime premium</strong> within 6 months of buying your own package, we will add <strong>£99</strong> back to your commission balance.</p>

                            @if($linkedCustomerAccount && $linkedCustomerAccount->provision_status === 'active')
                                <div class="alert alert-success">
                                    Your linked customer mailbox is active: <strong>{{ $linkedCustomerAccount->mailbox_email }}</strong>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('partner.customer_access.checkout') }}" class="row g-3">
                                @csrf
                                <div class="col-md-6">
                                    <label class="form-label" for="date_of_birth">Date of birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Proceed to Secure Checkout</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Campaign Progress</h4>
                        </div>
                        <div class="card-body">
                            @if($campaign)
                                <p><strong>Status:</strong> {{ ucfirst($campaign->status) }}</p>
                                <p><strong>Purchased:</strong> {{ $campaign->purchased_at?->format('d M Y') }}</p>
                                <p><strong>Deadline:</strong> {{ $campaign->qualification_deadline?->format('d M Y') }}</p>
                                <p><strong>Qualified customers:</strong> {{ $campaign->qualifying_referrals_count }}/{{ $campaign->qualifying_referrals_required }}</p>
                                <p><strong>Reward:</strong> £{{ number_format($campaign->reward_amount, 2) }}</p>
                            @else
                                <p>No active campaign yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
