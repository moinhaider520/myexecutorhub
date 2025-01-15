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
                                        <div class="d-flex student-arrow text-truncate">
                                            <p class="mb-0 up-arrow bg-light-danger"><i
                                                    class="icon-arrow-down font-danger"></i></p>
                                            <span class="f-w-500 font-danger">- 17.06%</span> than last 6 Month
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/student.png"
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
                                            <p class="mb-0 up-arrow bg-light-success"><i
                                                    class="icon-arrow-up font-success"></i></p>
                                            <span class="f-w-500 font-success">+27.02%</span> than last 4 Month
                                        </div>
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
                                        <h2>{{ $totalDocuments }}</h2>
                                        <p class="mb-0 text-truncate"> Documents Uploaded</p>
                                        <div class="d-flex student-arrow text-truncate">
                                            <p class="mb-0 up-arrow bg-light-success"><i
                                                    class="icon-arrow-up font-success"></i></p>
                                            <span class="f-w-500 font-success">+ 12.01%</span> than last 8 Month
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/calendar.png"
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
                                        <div class="d-flex student-arrow text-truncate">
                                            <p class="mb-0 up-arrow bg-light-danger"><i
                                                    class="icon-arrow-down font-danger"></i></p>
                                            <span class="f-w-500 font-danger">- 15.02%</span> than last 5 Month
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png"
                                            alt=""></div>
                                </div>
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