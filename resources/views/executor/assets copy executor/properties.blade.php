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
                <h4>Property (ies) Owned</h4>
                <span>List of Property (ies) Owned.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Property Type</th>
                          <th>Property Address</th>
                          <th>Owner Name(s)</th>
                          <th>How Owned?</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($properties as $property)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $property->property_type }}</td>
                          <td>{{ $property->address }}</td>
                          <td>{{ $property->owner_names }}</td>
                          <td>{{ $property->how_owned }}</td>
                          <td>{{ $property->value }}</td>
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
