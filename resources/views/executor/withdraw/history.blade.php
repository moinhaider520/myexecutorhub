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
                <h4>Withdrawal History</h4>
                <span>List of all your withdrawal requests.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Amount Requested</th>
                          <th>Status</th>
                          <th>Requested At</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($withdrawals as $withdrawal)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $withdrawal->amount_requested }}</td>
                          <td>{{ ucfirst($withdrawal->status) }}</td>
                          <td>{{ $withdrawal->created_at->format('Y-m-d H:i:s') }}</td>
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
