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
                <h4>Withdrawal Requests</h4>
                <span>List of all withdrawal requests.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>User</th>
                          <th>Amount Requested</th>
                          <th>Status</th>
                          <th>Requested At</th>
                          <th>Approved By</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($withdrawals as $withdrawal)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $withdrawal->user->name }}</td>
                          <td>{{ $withdrawal->amount_requested }}</td>
                          <td>{{ ucfirst($withdrawal->status) }}</td>
                          <td>{{ $withdrawal->created_at->format('Y-m-d H:i:s') }}</td>
                          <td>{{ $withdrawal->approved_by ? $withdrawal->approver->name : '-' }}</td>
                          <td>
                            <form action="{{ route('admin.withdraw.update', $withdrawal->id) }}" method="POST">
                              @csrf
                              @method('PATCH')
                              <select name="status" onchange="this.form.submit()">
                                <option value="" disabled selected>--Choose--</option>
                                <option value="pending" {{ $withdrawal->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ $withdrawal->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ $withdrawal->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                              </select>
                            </form>
                          </td>
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
