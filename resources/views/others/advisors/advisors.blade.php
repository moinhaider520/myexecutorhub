@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <!-- Add button removed -->
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Advisers</h4>
                <span>List of Advisers.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Adviser Type</th>
                          <th>Name</th>
                          <th>Practice Name</th>
                          <th>Practice Address</th>
                          <th>Email Address</th>
                          <th>Phone Number</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($advisors as $advisor)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ implode(', ', $advisor->getRoleNames()->toArray()) }}</td>
                          <td>{{ $advisor->name }}</td>
                          <td>{{ $advisor->practice_name }}</td>
                          <td>{{ $advisor->practice_address }}</td>
                          <td>{{ $advisor->email }}</td>
                          <td>{{ $advisor->contact_number }}</td>
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