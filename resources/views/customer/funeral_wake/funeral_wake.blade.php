
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
              Add Funeral Wishes & Notes
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Funeral</h4>
                <span>List of Playlists For Funeral.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Playlist Name</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($funeralwakes as $funeralwake)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $funeralwake->name }}</td>
                          <td>{{ $funeralwake->description }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editFuneralWakeModal" data-id="{{ $funeralwake->id }}" data-name="{{ $funeralwake->name }}" data-description="{{ $funeralwake->description }}">Edit</button>
                            <form action="{{ route('customer.funeral_wake.destroy', $funeralwake->id) }}" method="POST" style="display:inline;">
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
        <h5 class="modal-title" id="addFuneralWakeModalLabel">Add Funeral Wishes & Notes</h5>
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
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="Enter Description" rows="3" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add Funeral Wishes & Notes</button>
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
        <h5 class="modal-title" id="editFuneralWakeModalLabel">Edit Funeral Wishes & Notes</h5>
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
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" placeholder="Enter Description" rows="3" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Update Funeral Wishes & Notes</button>
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
    function clearAddFuneralWakeErrors() {
      $('#name_error').text('');
      $('#description_error').text('');
    }

    function clearEditFuneralWakeErrors() {
      $('#edit_name_error').text('');
      $('#edit_description_error').text('');
    }

    $('#addFuneralWakeForm').on('submit', function(e) {
      e.preventDefault();
      clearAddFuneralWakeErrors();

      $.ajax({
        url: "{{ route('customer.funeral_wake.store') }}",
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
          $('#description_error').text(errors.description);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var description = $(this).data('description');
      var name = $(this).data('name');

      $('#editFuneralWakeId').val(id);
      $('#editDescription').val(description);
      $('#editName').val(name);
      clearEditFuneralWakeErrors();
    });

    $('#editFuneralWakeForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#editFuneralWakeId').val();
      clearEditFuneralWakeErrors();

      $.ajax({
        url: "/customer/funeral_wake/update/" + id,
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
          $('#edit_name_error').text(errors.name);
          $('#edit_description_error').text(errors.description);
        }
      });
    });
  });
</script>
@endsection
