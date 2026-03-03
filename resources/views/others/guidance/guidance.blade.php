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
                  <h4>Guidance For Guardians</h4>
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
                          @foreach($guidance as $document)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $document->description }}</td>
                              <td>
                                @if ($document->media->isNotEmpty())
                                  @foreach($document->media as $media)
                                    @php
                                      $fileUrl = filter_var($media->file_path, FILTER_VALIDATE_URL)
                                        ? $media->file_path
                                        : asset('assets/upload/' . basename($media->file_path));
                                      $mediaExt = strtolower(pathinfo(parse_url($fileUrl, PHP_URL_PATH) ?? '', PATHINFO_EXTENSION));
                                    @endphp
                                    @if (in_array($mediaExt, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                      <!-- For image -->
                                      <a href="{{ $fileUrl }}" target="_blank">
                                        <img src="{{ $fileUrl }}" alt="Media" style="width: 100px;">
                                      </a>
                                    @elseif (in_array($mediaExt, ['mp4', 'mov', 'avi', 'mkv', 'webm']))
                                      <!-- For video -->
                                      <a href="{{ $fileUrl }}" target="_blank">
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
