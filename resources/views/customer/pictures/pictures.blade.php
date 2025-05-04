@extends('layouts.master')

@section('content')
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
                          <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $picture->name }}</td>
                            <td>{{ $picture->description }}</td>
                            <td><img src="{{ asset('assets/upload/' . basename($picture->file_path)) }}" alt="{{ $picture->name }}" style="max-width: 100px; max-height: 100px;"></td>
                            <td>
                              <a href="{{ asset('assets/upload/' . basename($picture->file_path)) }}" target="_blank">Download</a>
                            </td>
                            <td>
                              <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                                data-target="#editPictureModal" data-id="{{ $picture->id }}"
                                data-name="{{ $picture->name }}"
                                data-description="{{ $picture->description }}">Edit</button>
                              <form action="{{ route('customer.pictures.destroy', $picture->id) }}"
                                method="POST" style="display:inline;">
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
            <input type="text" class="form-control" name="name" id="name"
              placeholder="Enter Picture Name" required>
            <span class="text-danger" id="name_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="file">Upload Picture</label>
            <input type="file" class="form-control" name="file" id="file" accept="image/*">
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
            <input type="text" class="form-control" name="name" id="editName"
              placeholder="Enter Picture Name" required>
            <span class="text-danger" id="edit_name_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="editFile">Upload Picture</label>
            <input type="file" class="form-control" name="file" id="editFile" accept="image/*">
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

    // Display error messages
    function displayErrors(errors) {
      if (errors.name) {
        $('#name_error').text(errors.name[0]);
      }
      if (errors.description) {
        $('#description_error').text(errors.description[0]);
      }
      if (errors.file) {
        $('#file_error').text(errors.file[0]);
      }
    }

    function displayEditErrors(errors) {
      if (errors.name) {
        $('#edit_name_error').text(errors.name[0]);
      }
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
