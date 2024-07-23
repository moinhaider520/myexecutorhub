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
                <h4>Digital Assets</h4>
                <span>List of Digital Assets.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Asset Type</th>
                          <th>Asset Name</th>
                          <th>Username</th>
                          <th>Password</th>
                          <th>Email Used to create Account</th>
                          <th>Value</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($digitalAssets as $digitalAsset)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $digitalAsset->asset_type }}</td>
                          <td>{{ $digitalAsset->asset_name }}</td>
                          <td>{{ $digitalAsset->username }}</td>
                          <td>{{ $digitalAsset->password }}</td>
                          <td>{{ $digitalAsset->email_used }}</td>
                          <td>{{ $digitalAsset->value }}</td>
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
