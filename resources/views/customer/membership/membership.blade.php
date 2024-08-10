@extends('layouts.master')

@section('content')
<style>
  .ck-editor__editable_inline {
    min-height: 300px;
  }
</style>
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Executor Hub Membership</h4>
              </div>
              <div class="card-body pricing-content">
                <div class="row g-sm-4 g-3">
                  <div class="col-lg-4 col-sm-6 box-col-3">
                    <div class="card text-center pricing-simple">
                      <div class="card-body" style="height:400px;">
                        <h4>Basic</h4>
                        <h5>£8</h5>
                        <h6 class="mb-0">Per Month</h6>
                        <ul>
                        <li>Assign Executors</li>
                        <li>Record Assets & Liabilities</li>
                        </ul>
                      </div><a class="btn btn-lg btn-primary btn-block"
                        href="{{ route('stripe') }}">Purchase</a>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-6 box-col-3">
                    <div class="card text-center pricing-simple">
                      <div class="card-body" style="height:400px;">
                        <h4>Standard</h4>
                        <h5>£20</h5>
                        <h6 class="mb-0">Per Month</h6>
                        <ul>
                          <li>Assign Executors</li>
                          <li>Assign Advisers</li>
                          <li>Document Uploads</li>
                          <li>Record Assets & Liabilities</li>
                          <li>Access to Secure Messaging System</li>
                        </ul>
                      </div><a class="btn btn-lg btn-primary btn-block"
                        href="{{ route('stripe') }}">Purchase</a>
                    </div>
                  </div>
                  <div class="col-lg-4 col-sm-6 box-col-3">
                    <div class="card text-center pricing-simple">
                      <div class="card-body" style="height: 400px;">
                        <h4>Premium </h4>
                        <h5>£40</h5>
                        <h6 class="mb-0">Per Month</h6>
                        <ul>
                          <li>Assign Executors</li>
                          <li>Assign Advisers</li>
                          <li>Document Uploads</li>
                          <li>Record Assets & Liabilities</li>
                          <li>Access to Secure Messaging System</li>
                          <li>Record Donations</li>
                          <li>Record Life Notes</li>
                          <li>Record Wishes</li>
                          <li>Access to Executor Hub AI</li>
                        </ul>
                      </div><a class="btn btn-lg btn-primary btn-block"
                        href="{{ route('stripe') }}">Purchase</a>
                    </div>
                  </div>
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