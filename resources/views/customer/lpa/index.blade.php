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
                <h4>LPA Videos</h4>
                <span>List of Recorded LPA Videos.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Date of Recording</th>
                          <th>LPA Video</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      <tr>
                          <td>1</td>
                          <td>2024-12-12</td>
                          <td>View Video</td>
                          <td>
                            <form action="{{ route('customer.advisors.destroy', 1) }}" method="POST" style="display:inline;">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                          </td>
                        </tr>
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

<!-- ADD ADVISOR MODAL -->
<div class="modal fade" id="addAdvisorModal" tabindex="-1" role="dialog" aria-labelledby="addAdvisorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAdvisorModalLabel">Add Adviser</h5>
      </div>
      <div class="modal-body">
        <form id="addAdvisorForm">
          @csrf
          <div class="form-group mb-2">
            <label for="adviserType">Adviser Type</label>
            <select class="form-control" name="adviser_type" id="adviserType" required>
              <option value="" selected disabled>--Select Adviser Type--</option>
              <option value="Solicitors">Solicitors</option>
              <option value="Accountants">Accountants</option>
              <option value="Stock Brokers">Stock Brokers</option>
              <option value="Will Writers">Will Writers</option>
              <option value="Financial Advisers">Financial Advisers</option>
            </select>
            <span class="text-danger" id="adviser_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
            <span class="text-danger" id="name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="practice_name">Practice Name</label>
            <input type="text" class="form-control" name="practice_name" id="practice_name" placeholder="Enter Practice Name" required>
            <span class="text-danger" id="practice_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="practice_address">Practice Address</label>
            <input type="text" class="form-control" name="practice_address" id="practice_address" placeholder="Enter Practice Address" required>
            <span class="text-danger" id="practice_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="email_address">Email Address</label>
            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Email Address" required>
            <span class="text-danger" id="email_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number" required>
            <span class="text-danger" id="phone_number_error"></span>
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

<!-- EDIT ADVISOR MODAL -->
<div class="modal fade" id="editAdvisorModal" tabindex="-1" role="dialog" aria-labelledby="editAdvisorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdvisorModalLabel">Edit Adviser</h5>
      </div>
      <div class="modal-body">
        <form id="editAdvisorForm">
          @csrf
          <input type="hidden" name="id" id="editAdvisorId">

          <div class="form-group mb-2">
            <label for="editAdviserType">Adviser Type</label>
            <select class="form-control" name="adviser_type" id="editAdviserType" required>
              <option value="" selected disabled>--Select Adviser Type--</option>
              <option value="Solicitors">Solicitors</option>
              <option value="Accountants">Accountants</option>
              <option value="Stock Brokers">Stock Brokers</option>
              <option value="Will Writers">Will Writers</option>
              <option value="Financial Advisers">Financial Advisers</option>
            </select>
            <span class="text-danger" id="edit_adviser_type_error"></span>
          </div>

          <div class="form-group mb-2">
            <label for="editName">Name</label>
            <input type="text" class="form-control" name="name" id="editName" placeholder="Enter Name" required>
            <span class="text-danger" id="edit_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPracticeName">Practice Name</label>
            <input type="text" class="form-control" name="practice_name" id="editPracticeName" placeholder="Enter Practice Name" required>
            <span class="text-danger" id="edit_practice_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPracticeAddress">Practice Address</label>
            <input type="text" class="form-control" name="practice_address" id="editPracticeAddress" placeholder="Enter Practice Address" required>
            <span class="text-danger" id="edit_practice_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editEmailAddress">Email Address</label>
            <input type="email" class="form-control" name="email_address" id="editEmailAddress" placeholder="Email Address" required>
            <span class="text-danger" id="edit_email_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPhoneNumber">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="editPhoneNumber" placeholder="Enter Phone Number" required>
            <span class="text-danger" id="edit_phone_number_error"></span>
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
    function clearAddAdvisorErrors() {
      $('#adviser_type_error').text('');
      $('#name_error').text('');
      $('#practice_name_error').text('');
      $('#practice_address_error').text('');
      $('#email_address_error').text('');
      $('#phone_number_error').text('');
    }

    // Clear previous error messages for edit form
    function clearEditAdvisorErrors() {
      $('#edit_adviser_type_error').text('');
      $('#edit_name_error').text('');
      $('#edit_practice_name_error').text('');
      $('#edit_practice_address_error').text('');
      $('#edit_email_address_error').text('');
      $('#edit_phone_number_error').text('');
    }

    // Handle submission of add advisor form
    $('#addAdvisorForm').on('submit', function(e) {
      e.preventDefault();
      clearAddAdvisorErrors(); // Clear previous error messages

      $.ajax({
        url: "{{ route('customer.advisors.store') }}",
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
          $('#adviser_type_error').text(errors.adviser_type);
          $('#name_error').text(errors.name);
          $('#practice_name_error').text(errors.practice_name);
          $('#practice_address_error').text(errors.practice_address);
          $('#email_address_error').text(errors.email_address);
          $('#phone_number_error').text(errors.phone_number);
        }
      });
    });

    // Handle click on edit button for advisor
    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var adviser_type = $(this).data('adviser_type');
      var name = $(this).data('name');
      var practice_name = $(this).data('practice_name');
      var practice_address = $(this).data('practice_address');
      var email = $(this).data('email');
      var contact_number = $(this).data('contact_number');

      $('#editAdvisorId').val(id);
      $('#editAdviserType').val(adviser_type);
      $('#editName').val(name);
      $('#editPracticeName').val(practice_name);
      $('#editPracticeAddress').val(practice_address);
      $('#editEmailAddress').val(email);
      $('#editPhoneNumber').val(contact_number);
      clearEditAdvisorErrors(); // Clear previous error messages
    });

    // Handle submission of edit advisor form
    $('#editAdvisorForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#editAdvisorId').val();
      clearEditAdvisorErrors(); // Clear previous error messages

      $.ajax({
        url: "/customer/advisors/update/" + id,
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