@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addExecutorModal">
              Add Executor
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Executors</h4>
                <span>List of Executors.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Title</th>
                          <th>First Name</th>
                          <th>Last Name</th>
                          <th>How Acting?</th>
                          <th>Email Address</th>
                          <th>Contact Number(s)</th>
                          <th>Relationship</th>
                          <th>Access Type</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($executors as $executor)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $executor->title }}</td>
                          <td>{{ $executor->name }}</td>
                          <td>{{ $executor->lastname }}</td>
                          <td>{{ $executor->how_acting }}</td>
                          <td>{{ $executor->email }}</td>
                          <td>{{ $executor->phone_number }}</td>
                          <td>{{ $executor->relationship }}</td>
                          <td>{{ $executor->status == 'N' ? 'Upon Death' : 'Immediate Access' }}</td>
                          <td style="display:flex;">
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editExecutorModal" data-id="{{ $executor->id }}" data-name="{{ $executor->name }}" data-lastname="{{ $executor->lastname }}" data-how_acting="{{ $executor->how_acting }}" data-email="{{ $executor->email }}" data-relationship="{{ $executor->relationship }}" data-status="{{ $executor->status }}" data-title="{{ $executor->title }}" data-phone_number="{{ $executor->phone_number }}">Edit</button>
                            <form action="{{ route('customer.executors.destroy', $executor->id) }}" method="POST" style="display:inline;">
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
</div>

<!-- ADD EXECUTOR MODAL -->
<div class="modal fade" id="addExecutorModal" tabindex="-1" role="dialog" aria-labelledby="addExecutorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addExecutorModalLabel">Add Executor</h5>
      </div>
      <div class="modal-body">
        <form id="addExecutorForm">
          @csrf
          <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title" required>
            <div class="text-danger" id="error-title"></div>
          </div>
          <div class="form-group mb-3">
            <label for="name">First Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter First Name" required>
            <div class="text-danger" id="error-name"></div>
          </div>
          <div class="form-group mb-3">
            <label for="lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Enter Last Name" required>
            <div class="text-danger" id="error-lastname"></div>
          </div>
          <div class="form-group mb-3">
            <label for="how_acting">How Acting?</label>
            <select class="form-control" name="how_acting" id="how_acting" required>
            <option value="" disabled>-- Select --</option>
              <option value="Solely">Solely</option>
              <option value="Main">Main</option>
              <option value="Reserve">Reserve</option>
            </select>
            <div class="text-danger" id="error-how_acting"></div>
          </div>
          <div class="form-group mb-3">
            <label for="phone_number">Contact Number(s)</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Contact Number" required>
            <div class="text-danger" id="error-title"></div>
          </div>
          <div class="form-group mb-3">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email Address" required>
            <div class="text-danger" id="error-email"></div>
          </div>
          <div class="form-group mb-3">
            <label for="relationship">Relationship</label>
            <select class="form-control" name="relationship" id="relationship" required>
              <option value="Family">Family</option>
              <option value="Friend">Friend</option>
              <option value="Other">Other</option>
            </select>
            <div class="text-danger" id="error-relationship"></div>
          </div>
          <div class="form-group mb-3">
            <label for="status">Access Type</label>
            <select class="form-control" name="status" id="status" required>
              <option value="A">Immediate Access</option>
              <option value="N">Upon Death</option>
            </select>
            <div class="text-danger" id="error-status"></div>
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

<!-- EDIT EXECUTOR MODAL -->
<div class="modal fade" id="editExecutorModal" tabindex="-1" role="dialog" aria-labelledby="editExecutorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editExecutorModalLabel">Edit Executor</h5>
      </div>
      <div class="modal-body">
        <form id="editExecutorForm">
          @csrf
          <input type="hidden" name="id" id="editExecutorId">
          <div class="form-group mb-3">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="edit_title" placeholder="Enter Title" required>
            <div class="text-danger" id="edit-error-title"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_name">First Name</label>
            <input type="text" class="form-control" name="name" id="edit_name" placeholder="Enter First Name" required>
            <div class="text-danger" id="edit-error-name"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_lastname">Last Name</label>
            <input type="text" class="form-control" name="lastname" id="edit_lastname" placeholder="Enter Last Name" required>
            <div class="text-danger" id="edit-error-lastname"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_how_acting">How Acting?</label>
            <select class="form-control" name="how_acting" id="edit_how_acting" required>
              <option value="" disabled>-- Select --</option>
              <option value="Solely">Solely</option>
              <option value="Main">Main</option>
              <option value="Reserve">Reserve</option>
            </select>
            <div class="text-danger" id="error-edit_how_acting"></div>
          </div>
          <div class="form-group mb-3">
            <label for="phone_number">Contact Number(s)</label>
            <input type="text" class="form-control" name="phone_number" id="edit_phone_number" placeholder="Enter Contact Number" required>
            <div class="text-danger" id="error-title"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_email">Email Address</label>
            <input type="email" class="form-control" name="email" id="edit_email" placeholder="Email Address" required>
            <div class="text-danger" id="edit-error-email"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_relationship">Relationship</label>
            <select class="form-control" name="relationship" id="edit_relationship" required>
              <option value="Family">Family</option>
              <option value="Friend">Friend</option>
              <option value="Other">Other</option>
            </select>
            <div class="text-danger" id="edit-error-relationship"></div>
          </div>
          <div class="form-group mb-3">
            <label for="edit_status">Access Type</label>
            <select class="form-control" name="status" id="edit_status" required>
              <option value="A">Immediate Access</option>
              <option value="N">Upon Death</option>
            </select>
            <div class="text-danger" id="edit-error-status"></div>
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
    // Clear previous error messages
    function clearAddErrors() {
      $('#error-title').text('');
      $('#error-name').text('');
      $('#error-lastname').text('');
      $('#error-phone_number').text('');
      $('#error-email').text('');
      $('#error-relationship').text('');
      $('#error-status').text('');
      $('#error-password').text('');
      $('#error-password_confirmation').text('');
      $('#error-how_acting').text('');
    }

    function clearEditErrors() {
      $('#error-title').text('');
      $('#edit-error-name').text('');
      $('#edit-error-lastname').text('');
      $('#error-phone_number').text('');
      $('#edit-error-email').text('');
      $('#edit-error-relationship').text('');
      $('#edit-error-status').text('');
      $('#edit-error-password').text('');
      $('#edit-error-password_confirmation').text('');
      $('#edit-error-how_acting').text('');
    }

    // Handle submission of add executor form
    $('#addExecutorForm').on('submit', function(e) {
      e.preventDefault();
      clearAddErrors(); // Clear previous error messages

      $.ajax({
        url: "{{ route('customer.executors.store') }}",
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
          $('#error-title').text(errors.title);
          $('#error-name').text(errors.name);
          $('#error-lastname').text(errors.lastname);
          $('#error-email').text(errors.email);
          $('#error-relationship').text(errors.relationship);
          $('#error-status').text(errors.status);
          $('#error-password').text(errors.password);
          $('#error-password_confirmation').text(errors.password_confirmation);
          $('#error-how_acting').text(errors.how_acting);
        }
      });
    });

    // Handle click on edit button for executor
    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var title = $(this).data('title');
      var name = $(this).data('name');
      var lastname = $(this).data('lastname');
      var phone_number = $(this).data('phone_number');
      var email = $(this).data('email');
      var relationship = $(this).data('relationship');
      var status = $(this).data('status');
      var how_acting = $(this).data('how_acting');

      $('#editExecutorId').val(id);
      $('#edit_title').val(title);
      $('#edit_name').val(name);
      $('#edit_lastname').val(lastname);
      $('#edit_phone_number').val(phone_number);
      $('#edit_email').val(email);
      $('#edit_relationship').val(relationship);
      $('#edit_status').val(status);
      $('#edit_how_acting').val(how_acting);
      clearEditErrors(); // Clear previous error messages
    });

    // Handle submission of edit executor form
    $('#editExecutorForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#editExecutorId').val();
      clearEditErrors(); // Clear previous error messages

      $.ajax({
        url: "/customer/executors/update/" + id,
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
          $('#edit-error-name').text(errors.name);
          $('#edit-error-lastname').text(errors.lastname);
          $('#edit-error-email').text(errors.email);
          $('#edit-error-relationship').text(errors.relationship);
          $('#edit-error-status').text(errors.status);
          $('#edit-error-password').text(errors.password);
          $('#edit-error-password_confirmation').text(errors.password_confirmation);
        }
      });
    });
  });
</script>
@endsection
