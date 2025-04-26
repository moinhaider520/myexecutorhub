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
    <!-- Container-fluid Ends-->
</div>
@endsection