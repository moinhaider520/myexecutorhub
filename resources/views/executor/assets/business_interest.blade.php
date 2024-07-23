@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Business Interests</h4>
                <span>List of Business Interests.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Business Type</th>
                          <th>Business Name</th>
                          <th>Company Number</th>
                          <th>Shares %</th>
                          <th>Business Value (GBP)</th>
                          <th>Shares Value (GBP)</th>
                          <th>Who to Contact?</th>
                          <th>Plan For Shares</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($businessInterests as $businessInterest)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $businessInterest->business_type }}</td>
                          <td>{{ $businessInterest->business_name }}</td>
                          <td>{{ $businessInterest->company_number }}</td>
                          <td>{{ $businessInterest->shares }}</td>
                          <td>{{ $businessInterest->business_value }}</td>
                          <td>{{ $businessInterest->share_value }}</td>
                          <td>{{ $businessInterest->contact }}</td>
                          <td>{{ $businessInterest->plan_for_shares }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
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
