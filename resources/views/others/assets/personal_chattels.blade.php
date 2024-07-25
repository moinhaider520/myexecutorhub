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
                <h4>Personal Chattels</h4>
                <span>List of Personal Chattels.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Chattel Type</th>
                          <th>Chattel Description</th>
                          <th>Photos</th>
                          <th>Value (GBP)</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($personalChattels as $chattel)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $chattel->chattel_type }}</td>
                          <td>{{ $chattel->description }}</td>
                          <td>
                            @php
                            $photos = json_decode($chattel->photos);
                            @endphp

                            @if (!empty($photos))
                            @foreach($photos as $photo)
                            @if (!empty($photo))
                            <a href="{{ asset('assets/upload/' . $photo) }}" target="_blank">
                              <img src="{{ asset('assets/upload/' . $photo) }}" width="50" height="50" alt="Chattel Photo">
                            </a>
                            @endif
                            @endforeach
                            @else
                            No photos
                            @endif
                          </td>
                          <td>{{ $chattel->value }}</td>
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
