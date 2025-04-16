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
                <h4>Wishes</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Description</th>
                          <th>Files</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($wish as $document)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $document->description }}</td>
                          <td>
                            @if ($document->media->isNotEmpty())
                              @foreach($document->media as $media)
                                @if (in_array(pathinfo($media->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                  <!-- For image -->
                                  <a href="{{ asset('assets/upload/' . basename($media->file_path)) }}" target="_blank">
                                    <img src="{{ asset('assets/upload/' . basename($media->file_path)) }}" alt="Media" style="width: 100px;">
                                  </a>
                                @elseif (in_array(pathinfo($media->file_path, PATHINFO_EXTENSION), ['mp4', 'mov', 'avi', 'mkv']))
                                  <!-- For video -->
                                  <a href="{{ asset('assets/upload/' . basename($media->file_path)) }}" target="_blank">
                                    <button class="btn btn-primary btn-sm">View Video</button>
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