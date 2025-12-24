@extends('layouts.master')

@section('content')
  <style>
    .dropdown-menu {
      max-height: 300px;
      overflow-y: auto;
    }

    .dropdown-item {
      padding: 0.5rem 1rem;
    }

    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
  </style>
  <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
      <div class="row widget-grid">
        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-end p-2">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPictureModal">
                Add Picture
              </button>
            </div>
          </div>
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
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($pictures as $picture)
                            @php
                              // Decode the file_path JSON to get array of paths
                              $filePaths = json_decode($picture->file_path, true);
                              // Handle backward compatibility for single file path
                              if (!is_array($filePaths)) {
                                $filePaths = [$picture->file_path];
                              }
                            @endphp
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $picture->name }}</td>
                              <td>{{ $picture->description }}</td>
                              <td>
                                <div style="display: flex; flex-wrap: wrap; gap: 5px;">
                                  @foreach($filePaths as $index => $path)
                                    <div style="position: relative;">
                                      <img src="{{ asset('assets/upload/' . basename($path)) }}"
                                        alt="{{ $picture->name }} - {{ $index + 1 }}"
                                        style="max-width: 80px; max-height: 80px; object-fit: cover; border: 1px solid #ddd; border-radius: 4px; cursor: pointer;"
                                        onclick="openImageModal('{{ asset('assets/upload/' . basename($path)) }}', '{{ $picture->name }} - {{ $index + 1 }}')">
                                      <span
                                        style="position: absolute; top: 2px; right: 2px; background: rgba(0,0,0,0.6); color: white; padding: 2px 5px; border-radius: 3px; font-size: 10px;">
                                        {{ $index + 1 }}
                                      </span>
                                    </div>
                                  @endforeach
                                </div>
                                @if(count($filePaths) > 1)
                                  <small class="text-muted">{{ count($filePaths) }} images</small>
                                @endif
                              </td>
                              <td>
                                @if(count($filePaths) === 1)
                                  <a href="{{ asset('assets/upload/' . basename($filePaths[0])) }}"
                                    class="btn btn-sm btn-info" download="{{ $picture->name }}">
                                    <i class="fa fa-download"></i> Download
                                  </a>
                                @else
                                  <div class="dropdown">
                                    <button class="btn btn-sm btn-info dropdown-toggle" type="button"
                                      id="downloadDropdown{{ $picture->id }}" data-toggle="dropdown" aria-haspopup="true"
                                      aria-expanded="false">
                                      <i class="fa fa-download"></i> Download ({{ count($filePaths) }})
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="downloadDropdown{{ $picture->id }}">
                                      @foreach($filePaths as $index => $path)
                                        <a class="dropdown-item" href="{{ asset('assets/upload/' . basename($path)) }}"
                                          download="{{ $picture->name }}_{{ $index + 1 }}">
                                          Image {{ $index + 1 }}
                                        </a>
                                      @endforeach
                                      <div class="dropdown-divider"></div>
                                      <a class="dropdown-item" href="#"
                                        onclick="downloadAllImages({{ $picture->id }}, {{ json_encode($filePaths) }}, '{{ $picture->name }}'); return false;">
                                        <strong>Download All</strong>
                                      </a>
                                    </div>
                                  </div>
                                @endif
                              </td>
                              <td>
                                <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                                  data-target="#editPictureModal" data-id="{{ $picture->id }}"
                                  data-name="{{ $picture->name }}" data-description="{{ $picture->description }}">
                                  Edit
                                </button>
                                <form action="{{ route('customer.pictures.destroy', $picture->id) }}" method="POST"
                                  style="display:inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this picture and all its images?');">
                                  @csrf
                                  @method('DELETE')
                                  <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>

                      <!-- Image Preview Modal -->
                      <div class="modal fade" id="imagePreviewModal" tabindex="-1" role="dialog"
                        aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="imagePreviewModalLabel">Image Preview</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body text-center">
                              <img id="previewImage" src="" alt=""
                                style="max-width: 100%; max-height: 70vh; object-fit: contain;">
                            </div>
                          </div>
                        </div>
                      </div>
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

  <!-- ADD PICTURE MODAL -->
  <div class="modal fade" id="addPictureModal" tabindex="-1" role="dialog" aria-labelledby="addPictureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addPictureModalLabel">Add Picture</h5>
        </div>
        <div class="modal-body">
          <form id="addPictureForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
              <label for="name">Picture Name</label>
              <input type="text" class="form-control" name="name" id="name" placeholder="Enter Picture Name" required>
              <span class="text-danger" id="name_error"></span>
            </div>
            <div class="form-group mb-4">
              <label for="description">Description</label>
              <textarea class="form-control" name="description" id="description" required></textarea>
              <span class="text-danger" id="description_error"></span>
            </div>
            <div class="form-group mb-4">
              <label for="file">Upload Picture</label>
              <input type="file" class="form-control" name="file[]" id="file" accept="image/*" multiple>
              <span class="text-danger" id="file_error"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- EDIT PICTURE MODAL -->
  <div class="modal fade" id="editPictureModal" tabindex="-1" role="dialog" aria-labelledby="editPictureModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editPictureModalLabel">Edit Picture</h5>
        </div>
        <div class="modal-body">
          <form id="editPictureForm" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editPictureId">
            <div class="form-group mb-4">
              <label for="editName">Picture Name</label>
              <input type="text" class="form-control" name="name" id="editName" placeholder="Enter Picture Name" required>
              <span class="text-danger" id="edit_name_error"></span>
            </div>
            <div class="form-group mb-4">
              <label for="editDescription">Description</label>
              <textarea class="form-control" name="description" id="editDescription" required></textarea>
              <span class="text-danger" id="edit_description_error"></span>
            </div>
            <div class="form-group mb-4">
              <label for="editFile">Upload Picture</label>
              <input type="file" class="form-control" name="file[]" id="editFile" accept="image/*" multiple>
              <span class="text-danger" id="edit_file_error"></span>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
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
    $(document).ready(function () {
      // Handle Add Picture form submission
      $('#addPictureForm').on('submit', function (e) {
        e.preventDefault();

        clearErrors(); // Clear previous error messages

        var formData = new FormData(this);

        // Show the "Please Wait" alert
        Swal.fire({
          title: 'Please Wait',
          text: 'Your request is being processed...',
          icon: 'info',
          allowOutsideClick: false,
          showConfirmButton: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: "{{ route('customer.pictures.store') }}",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            // Close the "Please Wait" alert
            Swal.close();

            if (response.success) {
              location.reload();
            } else {
              Swal.fire('Error', 'An error occurred while adding the picture.', 'error');
            }
          },
          error: function (xhr) {
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

      // Handle Edit Picture button click
      $('.edit-button').on('click', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');

        $('#editPictureId').val(id);
        $('#editName').val(name);
        $('#editDescription').val(description);
      });

      // Handle Edit Picture form submission
      $('#editPictureForm').on('submit', function (e) {
        e.preventDefault();

        clearEditErrors(); // Clear previous error messages

        var formData = new FormData(this);
        var pictureId = $('#editPictureId').val(); // Get the picture ID

        // Show the "Please Wait" alert
        Swal.fire({
          title: 'Please Wait',
          text: 'Your request is being processed...',
          icon: 'info',
          allowOutsideClick: false,
          showConfirmButton: false,
          onBeforeOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          url: "{{ url('customer/pictures/update') }}" + '/' + pictureId, // Include the ID in the URL
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          success: function (response) {
            // Close the "Please Wait" alert
            Swal.close();

            if (response.success) {
              location.reload();
            } else {
              Swal.fire('Error', 'An error occurred while editing the picture.', 'error');
            }
          },
          error: function (xhr) {
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
        $('#name_error').text('');
        $('#description_error').text('');
        $('#file_error').text('');
      }

      function clearEditErrors() {
        $('#edit_name_error').text('');
        $('#edit_description_error').text('');
        $('#edit_file_error').text('');
      }

      // Display error messages for file array
      function displayErrors(errors) {
        if (errors.name) {
          $('#name_error').text(errors.name[0]);
        }
        if (errors.description) {
          $('#description_error').text(errors.description[0]);
        }
        // Handle file array errors (file.0, file.1, etc.) or general file error
        if (errors.file) {
          $('#file_error').text(errors.file[0]);
        } else {
          // Check for array-based errors
          let fileErrors = [];
          Object.keys(errors).forEach(function (key) {
            if (key.startsWith('file.')) {
              fileErrors.push(errors[key][0]);
            }
          });
          if (fileErrors.length > 0) {
            $('#file_error').text(fileErrors.join(', '));
          }
        }
      }

      function displayEditErrors(errors) {
        if (errors.name) {
          $('#edit_name_error').text(errors.name[0]);
        }
        if (errors.description) {
          $('#edit_description_error').text(errors.description[0]);
        }
        // Handle file array errors
        if (errors.file) {
          $('#edit_file_error').text(errors.file[0]);
        } else {
          // Check for array-based errors
          let fileErrors = [];
          Object.keys(errors).forEach(function (key) {
            if (key.startsWith('file.')) {
              fileErrors.push(errors[key][0]);
            }
          });
          if (fileErrors.length > 0) {
            $('#edit_file_error').text(fileErrors.join(', '));
          }
        }
      }
    });
  </script>

  <script>
    // Function to open image preview modal
    function openImageModal(imageSrc, imageAlt) {
      $('#previewImage').attr('src', imageSrc).attr('alt', imageAlt);
      $('#imagePreviewModalLabel').text(imageAlt);
      $('#imagePreviewModal').modal('show');
    }

    // Function to download all images
    function downloadAllImages(pictureId, filePaths, pictureName) {
      filePaths.forEach(function (path, index) {
        setTimeout(function () {
          var link = document.createElement('a');
          link.href = '{{ asset('assets/upload') }}/' + path.split('/').pop();
          link.download = pictureName + '_' + (index + 1);
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        }, index * 200); // Stagger downloads by 200ms
      });
    }
  </script>
@endsection