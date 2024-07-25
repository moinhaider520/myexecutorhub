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
                <h4>Bank Accounts</h4>
                <span>List of Bank Accounts.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Account Type</th>
                          <th>Bank Name</th>
                          <th>Sort Code</th>
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Balance</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($bankAccounts as $bankAccount)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $bankAccount->account_type }}</td>
                          <td>{{ $bankAccount->bank_name }}</td>
                          <td>{{ $bankAccount->sort_code }}</td>
                          <td>{{ $bankAccount->account_name }}</td>
                          <td>{{ $bankAccount->account_number }}</td>
                          <td>{{ $bankAccount->balance }}</td>
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