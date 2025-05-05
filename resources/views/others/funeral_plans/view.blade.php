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
                <h4>Funeral Plans</h4>
                <span>List of Funeral Plans.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Funeral Plan Type</th>
                          <th>Download Link</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($funeralPlans as $plan)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $plan->funeral_plan }}</td>
                          <td>
                            @if($plan->file_path)
                            <a href="{{ asset('assets/upload/' . basename($plan->file_path)) }}" target="_blank">Download</a>
                            @else
                            No file attached
                            @endif
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