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
                <h4>Pensions</h4>
                <span>List of Pensions.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Pension Provider</th>
                          <th>Pension Reference Number</th>
                          <th>Pensions</th>
                          <th>Entry Date and Time</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pensions as $pension)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $pension->pension_provider }}</td>
                          <td>{{ $pension->pension_reference_number }}</td>
                          <td>{{ $pension->pensions }}</td>
                          <td>{{ $pension->created_at->format('d/m/Y \a\t H:i') }}</td>
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
