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
                <h4>Pictures</h4>
                <span>List of Pictures.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Picture Name</th>
                          <th>Description</th>
                          <th>Preview</th>
                          <th>Download Link</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pictures as $picture)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $picture->name }}</td>
                          <td>{{ $picture->description }}</td>
                          <td><img src="{{ asset('assets/upload/' . basename($picture->file_path)) }}" alt="{{ $picture->name }}" style="max-width: 100px; max-height: 100px;"></td>
                          <td>
                            <a href="{{ asset('assets/upload/' . basename($picture->file_path)) }}" target="_blank">Download</a>
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