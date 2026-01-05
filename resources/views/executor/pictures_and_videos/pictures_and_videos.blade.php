@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDocumentModal">
              Add Picture/Video
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Files</h4>
                <span>List of Pictures & Videos.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>File Name</th>
                          <th>Description</th>
                          <th>Download Link</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pictures_and_videos as $document)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $document->name }}</td>
                <td>{{ $document->description }}</td>
                <td><a href="{{ asset('assets/upload/' . basename($document->file_path)) }}"
                  target="_blank">Download</a></td>
                <td>
                <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                  data-target="#editDocumentModal" data-id="{{ $document->id }}"
                  data-document_type="{{ $document->name }}"
                  data-description="{{ $document->description }}">Edit</button>
                <form action="{{ route('executor.pictures_and_videos.destroy', $document->id) }}"
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

<!-- ADD DOCUMENT MODAL -->
<div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDocumentModalLabel">Add File</h5>
      </div>
      <div class="modal-body">
        <form id="addDocumentForm" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-4">
            <label for="documentType">File Name</label>
            <input type="text" class="form-control" name="document_type" i d="documentType"
              placeholder="Enter File Name" required>
            <span class="text-danger" id="document_type_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="file">Upload File</label>
            <input type="file" class="form-control" name="file" id="file" accept="image/*,video/*">
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

<!-- EDIT DOCUMENT MODAL -->
<div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDocumentModalLabel">Edit File</h5>
      </div>
      <div class="modal-body">
        <form id="editDocumentForm" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editDocumentId">
          <div class="form-group mb-4">
            <label for="editDocumentType">File Name</label>
            <input type="text" class="form-control" name="document_type" id="editDocumentType"
              placeholder="Enter File Name" required>
            <span class="text-danger" id="edit_document_type_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="editFile">Upload File</label>
            <input type="file" class="form-control" name="file" id="editFile" accept="image/*,video/*">
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
    // Handle Add Document form submission
    $('#addDocumentForm').on('submit', function (e) {
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
        url: "{{ route('executor.pictures_and_videos.store') }}",
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
            Swal.fire('Error', 'An error occurred while adding the document.', 'error');
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


    // Handle Edit Document button click
    $('.edit-button').on('click', function () {
      const id = $(this).data('id');
      const documentType = $(this).data('document_type');
      const description = $(this).data('description');

      $('#editDocumentId').val(id);
      $('#editDocumentType').val(documentType);
      $('#editDescription').val(description);
    });

    // Handle Edit Document form submission
    $('#editDocumentForm').on('submit', function (e) {
      e.preventDefault();

      clearEditErrors(); // Clear previous error messages

      var formData = new FormData(this);
      var documentId = $('#editDocumentId').val(); // Get the document ID

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
        url: "{{ url('executor/pictures_and_videos/update') }}" + '/' + documentId, // Include the ID in the URL
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
            Swal.fire('Error', 'An error occurred while editing the document.', 'error');
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
      $('#document_type_error').text('');
      $('#description_error').text('');
      $('#file_error').text('');
    }

    function clearEditErrors() {
      $('#edit_document_type_error').text('');
      $('#edit_description_error').text('');
      $('#edit_file_error').text('');
    }

    // Display error messages
    function displayErrors(errors) {
      if (errors.document_type) {
        $('#document_type_error').text(errors.document_type[0]);
      }
      if (errors.description) {
        $('#description_error').text(errors.description[0]);
      }
      if (errors.file) {
        $('#file_error').text(errors.file[0]);
      }
    }

    function displayEditErrors(errors) {
      if (errors.document_type) {
        $('#edit_document_type_error').text(errors.document_type[0]);
      }
      if (errors.description) {
        $('#edit_description_error').text(errors.description[0]);
      }
      if (errors.file) {
        $('#edit_file_error').text(errors.file[0]);
      }
    }
  });

  $('#documentType').change(function () {
    if ($(this).val() === 'Others') {
      $('#customDocumentTypeInput').show();
    } else {
      $('#customDocumentTypeInput').hide();
    }
  });

  $('#editDocumentType').change(function () {
    if ($(this).val() === 'Others') {
      $('#editcustomDocumentTypeInput').show();
    } else {
      $('#editcustomDocumentTypeInput').hide();
    }
  });

</script>
@endsection
