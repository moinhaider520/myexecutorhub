
<style>
  .add-partner-card {
    border: 1px solid #ced4da;
    width: 30%;
    /* A solid, light grey border */
    border-radius: 8px;
    /* Slightly rounded corners */
    padding: 20px;
    /* Padding inside the card */
    margin-top: 15px;
    /* Spacing from the element above */
    text-align: center;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
  }

  .add-partner-card:hover {
    background-color: #f8f9fa;
    /* Light grey background on hover */
    border-color: #a0aec0;
    /* Darker border on hover */
  }

  .add-partner-link {
    display: flex;

    align-items: center;
    /* Centers items horizontally */
    color: #495057;
    /* Dark text color */
    text-decoration: none;
    /* Removes underline from the link */
    font-weight: bold;
  }

  .add-partner-link svg {
    width: 32px;
    height: 32px;
    stroke: #495057;
    /* Dark color for the plus icon */
    margin-bottom: 5px;
    /* Space between the icon and text */
  }

  .add-partner-text {
    font-size: 1rem;
  }

  .add-new-button {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.5rem 2rem;
    /* Adjusted padding for less height and more length */
    border: 1px solid #a0aec0;
    /* Changed from dashed to solid border to match the screenshot */
    border-radius: 0.375rem;
    color: #4299e1;
    /* Changed color to blue to match the screenshot */
    background-color: #ffffff;
    /* White background to match the screenshot */
    cursor: pointer;
    transition: all 0.2s ease-in-out;
    margin-top: 1.5rem;
    width: 100%;
    /* Ensure the button takes up the full width */
  }

  .add-new-button:hover {
    background-color: #ebf4ff;
    border-color: #4299e1;
    color: #4299e1;
  }

  .add-new-button svg {
    margin-right: 0.5rem;
  }
</style>
<div class="stepper-three row g-3 needs-validation custom-input" novalidate="" style="display: none;">
  <div class="form-group mb-3 col-sm-6">
    <label for="form-label">Martial Status</label>
    <p>Select your current legal status, even if you know it’s going to change soon. You can always update this in the future.</p>
    <select class="form-control" name="martial_status" id="martial_status" required>
      <option value="" disabled selected>-- Select --</option>
      <option value="Single">Single</option>
      <option value="Living with partner but not married">Living with partner but not married</option>
      <option value="Married">Married</option>
      <option value="Civil Partnership">Civil Partnership</option>
      <option value="Engaged">Engaged</option>
      <option value="Widowed">Widowed</option>
      <option value="Widowed and Remarried">Widowed and Remarried</option>
      <option value="Married but separate">Married but separate</option>
      <option value="Civil Partnership but separate">Civil Partnership but separate</option>
      <option value="Divorced">Divorced</option>
    </select>
    <div class="text-danger" id="error-martial-status"></div>
  </div>

  {{-- This div will be shown/hidden by JavaScript --}}
  <div id="partnerContainer" style="display: none;">
    <div id="existingPartnerList">
      @forelse ($partners as $partner)
      <div class="partner-card">
        <label>
          <input type="checkbox" name="family_friends[]" value="{{ $partner->id }}">
          <div class="partner-details">
            <span class="partner-name">{{ $partner->first_name }} {{ $partner->last_name }}</span>
            <span class="partner-contact">{{ $partner->email }}</span>
          </div>
        </label>
        <a data-toggle="modal" data-target="#editExecutorModal" data-id="{{ $partner->id }}" data-name="{{ $partner->first_name }}" data-lastname="{{ $partner->last_name }}" data-email="{{ $partner->email }}" data-relationship="{{ $partner->type }}" data-phone_number="{{ $partner->phone }}" class="edit-button">Edit</a>
      </div>
      @empty
      <p class="text-gray-600 italic">No Partner added yet</p>
      @endforelse
    </div>

    <div class="card add-partner-card">
      <a href="#" class="add-partner-link" id="addNewInheritor" data-toggle="modal" data-target="#addExecutorModal">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        </svg>
        <span class="add-partner-text">Add someone new</span>
      </a>
    </div>
  </div>
</div>

{{-- Include necessary scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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


    }

    function clearEditErrors() {
      $('#error-title').text('');
      $('#edit-error-first_name').text('');
      $('#edit-error-lastname').text('');
      $('#error-phone_number').text('');
      $('#edit-error-email').text('');
      $('#edit-error-relationship').text('');
      $('#edit-error-status').text('');


    }

    // Handle submission of add executor form
    $('#addExecutorForm').on('submit', function(e) {
      e.preventDefault();
      clearAddErrors(); // Clear previous error messages

      $.ajax({
        url: "{{ route('partner.will_generator.user_partner.store') }}",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          console.log(response);
          $('#addExecutorModal').click();
          $('#existingPartnerList').html(response.data);
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          $('#error-title').text(errors.title);
          $('#error-name').text(errors.name);
          $('#error-lastname').text(errors.lastname);
          $('#error-email').text(errors.email);
          $('#error-relationship').text(errors.relationship);
          $('#error-status').text(errors.status);


        }
      });
    });

    // Handle click on edit button for executor
    $(document).on('click', '.edit-button', function() {
      var id = $(this).data('id');
      // var title = $(this).data('title'); // Removed, as 'title' input is not in your current modal
      var name = $(this).data('name');
      var lastname = $(this).data('lastname');
      var phone_number = $(this).data('phone_number');
      var email = $(this).data('email');
      var relationship = $(this).data('relationship');
      // var status = $(this).data('status'); // Removed, as 'status' input is not in your current modal

      $('#editExecutorId').val(id);
      // $('#edit_title').val(title); // Removed
      $('#edit_first_name').val(name);
      $('#edit_last_name').val(lastname);
      $('#edit_phone_number').val(phone_number);
      $('#edit_email').val(email);
      $('#edit_relationship').val(relationship);
      clearEditErrors();
      $('#editExecutorModal').click();
    });

    // Handle submission of edit executor form
    $('#editExecutorForm').on('submit', function(e) {
      e.preventDefault();
      var id = $('#editExecutorId').val();
      clearEditErrors(); // Clear previous error messages

      $.ajax({
        url: "/partner/will_generator/user_partner/edit",
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
          $('#editExecutorModal').click();
          $('#existingPartnerList').html(response.data);
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          $('#edit-error-name').text(errors.name);
          $('#edit-error-lastname').text(errors.lastname);
          $('#edit-error-email').text(errors.email);
          $('#edit-error-relationship').text(errors.relationship);
          $('#edit-error-status').text(errors.status);

        }
      });
    });
  });

  $(document).ready(function() {
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': csrfToken
      }
    });
    $('#executorChoiceForm').on('submit', function(e) {

      const selectedfamily_friends = $('input[name="family_friends[]"]:checked').map(function() {
        return $(this).val();
      }).get();

      console.log("Selected family_friends:", selectedfamily_friends);

      if (selectedfamily_friends.length === 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Oops...',
          text: 'Please select at least one executor!',
        });
        return false;
      }

    });
    $('#deletePersonButton').on('click', function(e) {
      e.preventDefault();
      var person_id = $('#editExecutorId').val();
      var postData = {
        id: person_id,

      };
      $.ajax({
        url: "{{ route('partner.will_generator.user_partner.delete') }}",
        method: 'Delete',
        data: postData,
        dataType: 'json',

        success: function(response) {
          $('#editExecutorId').val('');
          $('#edit_title').val('');
          $('#edit_first_name').val('');
          $('#edit_last_name').val('');
          $('#edit_phone_number').val('');
          $('#edit_email').val('');
          $('#edit_relationship').val('');
          $('#editExecutorModal').click();
          $('#existingPartnerList').html(response.data);
        },
        error: function(jqXHR, textStatus, errorThrown) {
          if (jqXHR.status === 419) {
            alert(
              'Your session has expired or the security token is invalid. Please refresh the page and try again.'
            );
            location.reload();
          } else if (jqXHR.status === 422) {
            var errors = jqXHR.responseJSON.errors;
            if (errors.name) {
              $('#error-name').text(errors.name);
            }
            if (errors.date_of_birth) {
              $('#error-date_of_birth').text(errors.date_of_birth);
            }
          } else {
            var errorMessage = 'An unexpected error occurred.';
            if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
              errorMessage = jqXHR.responseJSON.message;
            } else if (errorThrown) {
              errorMessage = errorThrown;
            }
            alert(errorMessage);
            console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
          }
        }
      });
    });
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const martialStatusSelect = document.getElementById('martial_status');
    const partnerContainer = document.getElementById('partnerContainer');

    function togglePartnerSection() {
      const selectedStatus = martialStatusSelect.value;

      // List of statuses that should show the partner section
      const statusesWithPartners = [
        'Living with partner but not married',
        'Married',
        'Civil Partnership',
        'Engaged',
        'Widowed and Remarried',
        'Married but separate',
        'Civil Partnership but separate',
      ];

      if (statusesWithPartners.includes(selectedStatus)) {
        partnerContainer.style.display = 'block';
      } else {
        partnerContainer.style.display = 'none';
      }
    }

    // Add event listener for when the selection changes
    martialStatusSelect.addEventListener('change', togglePartnerSection);

    // Call on page load to set the initial state
    togglePartnerSection();
  });
</script>