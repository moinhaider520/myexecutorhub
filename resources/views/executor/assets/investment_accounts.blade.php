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
                <h4>Investment Accounts</h4>
                <span>List of Investment Accounts.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Investment Type</th>
                          <th>Company Name</th>
                          <th>Account/Reference Number</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($investmentAccounts as $investmentAccount)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $investmentAccount->investment_type }}</td>
                          <td>{{ $investmentAccount->company_name }}</td>
                          <td>{{ $investmentAccount->account_number }}</td>
                          <td>{{ $investmentAccount->balance }}</td>
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
