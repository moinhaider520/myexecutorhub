@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Videos</h4>
                <span>List of Videos.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <table class="display dataTable" id="basic-1">
                    <thead>
                      <tr>
                        <th>Sr</th>
                        <th>Video Name</th>
                        <th>Description</th>
                        <th>Preview</th>
                        <th>Download Link</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($videos as $video)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $video->name }}</td>
                        <td>{{ $video->description }}</td>
                        <td>
                          <video width="150" height="100" controls>
                            <source src="{{ asset('assets/upload/' . basename($video->file_path)) }}" type="video/mp4">
                            Your browser does not support the video tag.
                          </video>
                        </td>
                        <td>
                          <a href="{{ asset('assets/upload/' . basename($video->file_path)) }}" target="_blank">Download</a>
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
@endsection
