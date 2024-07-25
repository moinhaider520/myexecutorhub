@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Executors</h4>
                <span>List of Executors.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Title</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>How Acting?</th>
                          <th>Email Address</th>
                          <th>Contact Number(s)</th>
                          <th>Relationship</th>
                          <th>Access Type</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($executors as $executor)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $executor->title }}</td>
                          <td>{{ $executor->name }}</td>
                          <td>{{ $executor->lastname }}</td>
                          <td>{{ $executor->how_acting }}</td>
                          <td>{{ $executor->email }}</td>
                          <td>{{ $executor->phone_number }}</td>
                          <td>{{ $executor->relationship }}</td>
                          <td>{{ $executor->status }}</td>
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
</div>
@endsection