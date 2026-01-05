@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addVideoModal">
              Add Videos
            </button>
          </div>
        </div>
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
                          <th>Action</th>
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
                        <td>
                          <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                            data-target="#editVideoModal" data-id="{{ $video->id }}"
                            data-description="{{ $video->description }}">
                            Edit
                          </button>
                          <form action="{{ route('executor.life_remembered_videos.destroy', $video->id) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this video entry?')">Delete</button>
                          </form>
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

<!-- ADD VIDEO MODAL -->
<div class="modal fade" id="addVideoModal" tabindex="-1" role="dialog" aria-labelledby="addVideoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addVideoModalLabel">Add Video Memory</h5>
      </div>
      <div class="modal-body">
        <form id="addVideoForm" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-4">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required placeholder="Describe your video memory..."></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="file">Upload Videos</label>
            <input type="file" class="form-control" name="file[]" id="file" accept="video/*" multiple>
            <small class="form-text text-muted">Supported formats: MP4, MOV, AVI, MKV, WEBM, FLV, WMV (Max: 100MB per video)</small>
            <span class="text-danger" id="file_error"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Video Memory</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- EDIT VIDEO MODAL -->
<div class="modal fade" id="editVideoModal" tabindex="-1" role="dialog" aria-labelledby="editVideoModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editVideoModalLabel">Edit Video Memory</h5>
      </div>
      <div class="modal-body">
        <form id="editVideoForm" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editVideoId">
          <div class="form-group mb-4">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
          <div class="form-group mb-4" id="existingVideoSection" style="display: none;">
            <label>Existing Videos</label>
            <div class="row" id="videoPreviewContainer"></div>
          </div>

          <div class="form-group mb-4">
            <label for="editFile">Upload Additional Videos</label>
            <input type="file" class="form-control" name="file[]" id="editFile" accept="video/*" multiple>
            <small class="form-text text-muted">Supported formats: MP4, MOV, AVI, MKV, WEBM, FLV, WMV (Max: 100MB per video)</small>
            <span class="text-danger" id="edit_file_error"></span>
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Video Memory</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
<script>
  $(document).ready(function() {
    // Handle Add Video form submission
    $('#addVideoForm').on('submit', function(e) {
      e.preventDefault();

      clearErrors(); // Clear previous error messages

      var formData = new FormData(this);

      // Show the "Please Wait" alert
      Swal.fire({
        title: 'Please Wait',
        text: 'Your videos are being uploaded...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: "{{ route('executor.life_remembered_videos.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Close the "Please Wait" alert
          Swal.close();

          if (response.success) {
            Swal.fire('Success', response.message, 'success').then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', 'An error occurred while adding the video.', 'error');
          }
        },
        error: function(xhr) {
          // Close the "Please Wait" alert
          Swal.close();

          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            displayErrors(errors);
          } else {
            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
          }
        }
      });
    });

    // Handle Edit Video button click
    $('.edit-button').on('click', function() {
      const id = $(this).data('id');
      const description = $(this).data('description');

      $('#editVideoId').val(id);
      $('#editDescription').val(description);
      $('#videoPreviewContainer').html('');
      $('#existingVideoSection').hide();

      // Fetch existing media
      $.get(`/executor/life_remembered_videos/${id}/media`, function(media) {
        if (media.length > 0) {
          $('#existingVideoSection').show();
        }

        media.forEach(file => {
          const ext = file.file_path.split('.').pop().toLowerCase();
          let content = '';

          if (['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'].includes(ext)) {
            content = `<video controls style="max-height: 150px; width: 100%;" class="mb-2">
                        <source src="/assets/upload/${file.file_path}" type="${file.file_type}">
                        Your browser does not support the video tag.
                      </video>`;
          } else {
            content = `<p class="text-muted">Unsupported format: ${ext}</p>`;
          }

         const preview = `
            <div class="col-md-6 text-center mb-3" id="video-${file.id}">
                ${content}
                <br>
                <button type="button" class="btn btn-sm btn-danger delete-video" data-id="${file.id}">Delete Video</button>
            </div>
            `;
          $('#videoPreviewContainer').append(preview);
        });
      });
    });

    // Handle video deletion
    $(document).on('click', '.delete-video', function() {
      const videoId = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: `/executor/life_remembered_videos/media/${videoId}`,
            type: 'DELETE',
            data: {
              _token: '{{ csrf_token() }}'
            },
            success: function() {
              $(`#video-${videoId}`).remove();
              Swal.fire('Deleted!', 'Your video has been deleted.', 'success');
            },
            error: function() {
              Swal.fire('Error', 'Failed to delete video.', 'error');
            }
          });
        }
      });
    });

    // Handle Edit Video form submission
    $('#editVideoForm').on('submit', function(e) {
      e.preventDefault();

      clearEditErrors();
      var formData = new FormData(this);
      var videoId = $('#editVideoId').val();

      // Show the "Please Wait" alert
      Swal.fire({
        title: 'Please Wait',
        text: 'Your videos are being updated...',
        icon: 'info',
        allowOutsideClick: false,
        showConfirmButton: false,
        onBeforeOpen: () => {
          Swal.showLoading();
        }
      });

      $.ajax({
        url: "{{ url('executor/life_remembered_videos/update') }}" + '/' + videoId,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(response) {
          // Close the "Please Wait" alert
          Swal.close();

          if (response.success) {
            Swal.fire('Success', response.message, 'success').then(() => {
              location.reload();
            });
          } else {
            Swal.fire('Error', 'An error occurred while updating the video.', 'error');
          }
        },
        error: function(xhr) {
          // Close the "Please Wait" alert
          Swal.close();

          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            displayEditErrors(errors);
          } else {
            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
          }
        }
      });
    });

    // Clear error messages
    function clearErrors() {
      $('#description_error').text('');
      $('#file_error').text('');
    }

    function clearEditErrors() {
      $('#edit_description_error').text('');
      $('#edit_file_error').text('');
    }

    // Display error messages
    function displayErrors(errors) {
      if (errors.description) {
        $('#description_error').text(errors.description[0]);
      }
      if (errors.file) {
        $('#file_error').text(errors.file[0]);
      }
    }

    function displayEditErrors(errors) {
      if (errors.description) {
        $('#edit_description_error').text(errors.description[0]);
      }
      if (errors.file) {
        $('#edit_file_error').text(errors.file[0]);
      }
    }
  });
</script>
@endsection
