@extends('layouts.master')

@section('content')
    <div class="page-body">
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row widget-grid">
                <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Customers Referred with {{ $subpartner->name }} Coupon Code</h5>
                                <div class="card-body">
                                    @if($referredUsers->isEmpty())
                                        <p>No customer has used {{ $subpartner->name }} coupon code yet.</p>
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
                                                            <th>Package Name</th>
                                                            <th>Signup Date</th>       
                                                            <th>Renewal Date</th>                                                     
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
                                                                <td @if($referral->user && $referral->user->trial_ends_at && \Carbon\Carbon::parse($referral->user->trial_ends_at)->lt(now()))
                                                                style="color:red;" @endif>
                                                                    {{ $referral->user->trial_ends_at ? \Carbon\Carbon::parse($referral->user->trial_ends_at)->format('Y-m-d') : '-' }}
                                                                </td>
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
        <!-- Container-fluid Ends-->
    </div>
@endsection