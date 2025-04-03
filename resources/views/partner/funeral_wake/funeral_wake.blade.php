@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFuneralWakeModal">
              Add Funeral Wake
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Funeral Wake</h4>
                <span>List of Playlists For Funeral / Wake.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Playlist Name</th>
                          <th>Link</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($funeralwakes as $funeralwake)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $funeralwake->name }}</td>
                          <td><a href="{{ $funeralwake->link }}" target="_blank" rel="noopener noreferrer">View Playlist</a></td>

                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editFuneralWakeModal" data-id="{{ $funeralwake->id }}" data-name="{{ $funeralwake->name }}" data-link="{{ $funeralwake->link }}">Edit</button>
                            <form action="{{ route('partner.funeral_wake.destroy', $funeralwake->id) }}" method="POST" style="display:inline;">
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

<!-- ADD FuneralWake MODAL -->
<div class="modal fade" id="addFuneralWakeModal" tabindex="-1" role="dialog" aria-labelledby="addFuneralWakeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFuneralWakeModalLabel">Add Funeral Wake</h5>
      </div>
      <div class="modal-body">
        <form id="addFuneralWakeForm">
          @csrf
          <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
            <span class="text-danger" id="name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="link">Link</label>
            <input type="text" class="form-control" name="link" id="link" placeholder="Enter Playlist Link" pattern="https?://.+" title="Please enter a valid URL starting with http:// or https://" required>
            <span class="text-danger" id="link_error"></span>
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

<!-- EDIT FuneralWake MODAL -->
<div class="modal fade" id="editFuneralWakeModal" tabindex="-1" role="dialog" aria-labelledby="editFuneralWakeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFuneralWakeModalLabel">Edit Funeral Wake</h5>
      </div>
      <div class="modal-body">
        <form id="editFuneralWakeForm">
          @csrf
          <input type="hidden" name="id" id="editFuneralWakeId">

          <div class="form-group mb-2">
            <label for="editName">Name</label>
            <input type="text" class="form-control" name="name" id="editName" placeholder="Enter Name" required>
            <span class="text-danger" id="edit_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editLink">Link</label>
            <input type="text" class="form-control" name="link" id="editLink" placeholder="Enter Link" pattern="https?://.+" title="Please enter a valid URL starting with http:// or https://" required>
            <span class="text-danger" id="edit_link_error"></span>
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

<script>
  $(document).ready(function() {
    // Clear previous error messages for add form
    function clearAddFuneralWakeErrors() {
      $('#name_error').text('');
      $('#link_error').text('');
    }

    // Clear previous error messages for edit form
    function clearEditFuneralWakeErrors() {
      $('#edit_name_error').text('');
      $('#edit_link_error').text('');
    }

    // Handle submission of add FuneralWake form
    $('#addFuneralWakeForm').on('submit', function(e) {
      e.preventDefault();
      clearAddFuneralWakeErrors(); // Clear previous error messages

      $.ajax({
        url: "{{ route('partner.funeral_wake.store') }}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.success) {
            location.reload();
          } else {
            alert(response.message);
          }
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          $('#name_error').text(errors.name);
          $('#link_error').text(errors.link);
        }
      });
    });

    // Handle click on edit button for FuneralWake
    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var link = $(this).data('link');
      var name = $(this).data('name');

      $('#editFuneralWakeId').val(id);
      $('#editLink').val(link);
      $('#editName').val(name);
      clearEditFuneralWakeErrors(); // Clear previous error messages
    });

    // Handle submission of edit FuneralWake form
    $('#editFuneralWakeForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#editFuneralWakeId').val();
      clearEditFuneralWakeErrors(); // Clear previous error messages

      $.ajax({
        url: "/partner/funeral_wake/update/" + id,
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          if (response.success) {
            location.reload();
          } else {
            alert(response.message);
          }
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          $('#edit_adviser_type_error').text(errors.adviser_type);
          $('#edit_name_error').text(errors.name);
          $('#edit_practice_name_error').text(errors.practice_name);
          $('#edit_practice_address_error').text(errors.practice_address);
          $('#edit_email_address_error').text(errors.email_address);
          $('#edit_phone_number_error').text(errors.phone_number);
        }
      });
    });
  });
</script>
@endsection