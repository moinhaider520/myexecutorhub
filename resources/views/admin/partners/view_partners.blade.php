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
                                <h5 class="card-header">Partners Referred with Your Coupon</h5>
                                <div class="card-body">
                                    @if($partners->isEmpty())
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
                                                        @foreach ($partners as $index => $referral)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $referral->name ?? '-' }}</td>
                                                                <td>{{ $referral->email ?? '-' }}</td>
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
        <!-- Container-fluid Ends-->
    </div>
@endsection