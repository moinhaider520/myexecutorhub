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
                <h4>Intellectual Properties</h4>
                <span>List of Intellectual Properties.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-2_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-2" role="grid" aria-describedby="basic-2_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Property Type</th>
                          <th>Description</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data will be dynamically loaded here -->
                        @foreach($intellectualProperties as $property)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $property->property_type }}</td>
                          <td>{{ $property->description }}</td>
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
