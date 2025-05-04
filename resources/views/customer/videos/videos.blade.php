@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVideoModal">
              Add Video
            </button>
          </div>
        </div>

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
                        <th>Action</th>
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
                        <td>
                          <button type="button" class="btn btn-warning btn-sm edit-video-button"
                            data-toggle="modal" data-target="#editVideoModal"
                            data-id="{{ $video->id }}"
                            data-name="{{ $video->name }}"
                            data-description="{{ $video->description }}">
                            Edit
                          </button>
                          <form action="{{ route('customer.videos.destroy', $video->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                          </form>
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

<!-- Add Video Modal -->
<div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="addVideoForm" action="{{ route('customer.videos.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Video</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Video Name</label>
            <input type="text" class="form-control" name="name" required>
            <span id="video_name_error" class="text-danger"></span>
          </div>
          <div class="form-group">
            <label for="description">Video Description</label>
            <textarea class="form-control" name="description" rows="3"></textarea>
            <span id="video_description_error" class="text-danger"></span>
          </div>
          <div class="form-group">
            <label for="file">Video File</label>
            <input type="file" class="form-control" name="file" accept="video/mp4" required>
            <span id="video_file_error" class="text-danger"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Upload</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Edit Video Modal -->
<div class="modal fade" id="editVideoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="editVideoForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('POST')
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Video</h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="video_id" id="editVideoId">
          <div class="form-group">
            <label for="edit_name">Video Name</label>
            <input type="text" class="form-control" name="name" id="edit_name" required>
            <span id="edit_video_name_error" class="text-danger"></span>
          </div>
          <div class="form-group">
            <label for="edit_description">Video Description</label>
            <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
            <span id="edit_video_description_error" class="text-danger"></span>
          </div>
          <div class="form-group">
            <label for="edit_file">Replace Video File (optional)</label>
            <input type="file" class="form-control" name="file" accept="video/mp4">
            <span id="edit_video_file_error" class="text-danger"></span>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function () {

  // Open edit modal with prefilled values
  $('.edit-video-button').on('click', function () {
    $('#editVideoId').val($(this).data('id'));
    $('#edit_name').val($(this).data('name'));
    $('#edit_description').val($(this).data('description'));
    $('#editVideoForm').attr('action', '/customer/videos/update/' + $(this).data('id'));
  });

  $('#addVideoForm').on('submit', function (e) {
    e.preventDefault();
    clearVideoErrors();

    let formData = new FormData(this);

    Swal.fire({ title: 'Uploading...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    $.ajax({
      url: "{{ route('customer.videos.store') }}",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.close();
        if (response.success) {
          location.reload();
        } else {
          Swal.fire('Error', 'Failed to upload video.', 'error');
        }
      },
      error: function (xhr) {
        Swal.close();
        if (xhr.status === 422) {
          displayVideoErrors(xhr.responseJSON.errors);
        } else {
          Swal.fire('Error', 'Something went wrong.', 'error');
        }
      }
    });
  });

  $('#editVideoForm').on('submit', function (e) {
    e.preventDefault();
    clearEditVideoErrors();

    let formData = new FormData(this);
    let url = $(this).attr('action');

    Swal.fire({ title: 'Updating...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    $.ajax({
      url: url,
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.close();
        if (response.success) {
          location.reload();
        } else {
          Swal.fire('Error', 'Failed to update video.', 'error');
        }
      },
      error: function (xhr) {
        Swal.close();
        if (xhr.status === 422) {
          displayEditVideoErrors(xhr.responseJSON.errors);
        } else {
          Swal.fire('Error', 'Something went wrong.', 'error');
        }
      }
    });
  });

  function clearVideoErrors() {
    $('#video_name_error').text('');
    $('#video_description_error').text('');
    $('#video_file_error').text('');
  }

  function clearEditVideoErrors() {
    $('#edit_video_name_error').text('');
    $('#edit_video_description_error').text('');
    $('#edit_video_file_error').text('');
  }

  function displayVideoErrors(errors) {
    if (errors.name) $('#video_name_error').text(errors.name[0]);
    if (errors.description) $('#video_description_error').text(errors.description[0]);
    if (errors.file) $('#video_file_error').text(errors.file[0]);
  }

  function displayEditVideoErrors(errors) {
    if (errors.name) $('#edit_video_name_error').text(errors.name[0]);
    if (errors.description) $('#edit_video_description_error').text(errors.description[0]);
    if (errors.file) $('#edit_video_file_error').text(errors.file[0]);
  }

});
</script>
@endsection
