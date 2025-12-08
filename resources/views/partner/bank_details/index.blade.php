@extends('layouts.master')

@section('content')
<div class="page-body">
    <div class="container-fluid default-dashboard">

        <div class="row widget-grid">
            <div class="col-xl-12 box-col-12">

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Stripe Payout Account</h4>
                    </div>

                    <div class="card-body">


                        @if(!$user->stripe_connect_account_id)
                            <div class="alert alert-info">
                                <strong>Setup Required</strong><br>
                                Connect your Stripe payout account.
                            </div>

                            <a href="{{ route('partner.bank_details.connect') }}" class="btn btn-primary">
                                <i class="fa fa-link"></i> Connect Stripe Account
                            </a>
                        @endif

                        @if($user->stripe_connect_account_id && !$user->payouts_enabled)
                            <div class="alert alert-warning">
                                <strong>You're almost done!</strong><br>
                                Stripe account created, verification incomplete.
                            </div>

                            <a href="{{ route('partner.bank_details.connect') }}" class="btn btn-warning">
                                <i class="fa fa-exclamation-circle"></i> Continue Verification
                            </a>

                            <table class="table table-bordered mt-4">
                                <tr>
                                    <th>Stripe Account ID</th>
                                    <td>{{ $user->stripe_connect_account_id }}</td>
                                </tr>
                                <tr>
                                    <th>Payout Status</th>
                                    <td><span class="badge badge-warning">Pending Verification</span></td>
                                </tr>
                            </table>
                        @endif

                        @if($user->stripe_connect_account_id && $user->payouts_enabled)
                            <div class="alert alert-success">
                                <strong>Payouts Enabled</strong><br>
                                Commissions will be transferred automatically.
                            </div>

                            <table class="table table-bordered mt-4">
                                <tr>
                                    <th>Stripe Account ID</th>
                                    <td>{{ $user->stripe_connect_account_id }}</td>
                                </tr>
                                <tr>
                                    <th>Default Bank Last 4</th>
                                    <td>{{ $user->default_bank_last4 ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><span class="badge badge-success">Active</span></td>
                                </tr>
                            </table>

                            <a href="{{ route('partner.bank_details.connect') }}" class="btn btn-info mt-3">
                                <i class="fa fa-edit"></i> Update Bank Details
                            </a>

                            @if(isset($stripe_banks) && count($stripe_banks) > 0)
                                <h5 class="mt-4">Connected Bank Accounts</h5>

                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Bank</th>
                                            <th>Account Holder</th>
                                            <th>Last 4</th>
                                            <th>Currency</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($stripe_banks as $bank)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ strtoupper($bank->bank_name ?? 'N/A') }}</td>
                                                <td>{{ $bank->account_holder_name ?? 'N/A' }}</td>
                                                <td>**** {{ $bank->last4 }}</td>
                                                <td>{{ strtoupper($bank->currency) }}</td>
                                                <td>
                                                    @if($bank->default_for_currency)
                                                        <span class="badge badge-success">Default</span>
                                                    @else
                                                        <span class="badge badge-secondary">Available</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
