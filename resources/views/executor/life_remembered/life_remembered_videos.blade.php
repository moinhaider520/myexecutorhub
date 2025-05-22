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
                <h4>Life Remembered - Videos</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Description</th>
                          <th>Videos</th>
                        </tr>
                      </thead>
                      @foreach($lifeRememberedVideos as $video)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $video->description }}</td>
                        <td>
                          @if ($video->media->isNotEmpty())
                          @foreach($video->media as $media)
                          @if (in_array(pathinfo($media->file_path, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv']))
                          <!-- For video -->
                          <video controls style="width: 200px; height: 150px;" class="mb-2">
                            <source src="{{ asset('assets/upload/' . basename($media->file_path)) }}" type="{{ $media->file_type }}">
                            Your browser does not support the video tag.
                          </video>
                          <br>
                          <a href="{{ asset('assets/upload/' . basename($media->file_path)) }}" target="_blank">
                            <button class="btn btn-info btn-sm">Open Full Video</button>
                          </a>
                          @else
                          N/A
                          @endif
                          @endforeach
                          @else
                          N/A
                          @endif
                        </td>
                      </tr>
                      @endforeach
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