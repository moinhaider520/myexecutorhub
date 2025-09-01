@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="page-body">
    <div class="container">
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
            <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/invoice.png" alt=""></div>
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
            <div class="flex-shrink-0"><img src="../assets/images/dashboard-4/icon/teacher.png" alt=""></div>
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
  <!-- Container-fluid Ends-->
</div>
@endsection