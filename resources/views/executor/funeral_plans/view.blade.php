@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFuneralPlanModal">
              Add Funeral Plan
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Funeral Plans</h4>
                <span>List of Funeral Plans.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Funeral Plan Type</th>
                          <th>Download Link</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($funeralPlans as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $plan->funeral_plan }}</td>
                                <td>
                                @if($plan->file_path)
                                    <a href="{{ asset('assets/upload/' . basename($plan->file_path)) }}" target="_blank">Download</a>
                                @else
                                    No file attached
                                @endif
                                </td>
                                <td>
                                <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                                data-target="#editFuneralPlanModal" data-id="{{ $plan->id }}"
                                data-funeral_plan="{{ $plan->funeral_plan }}">Edit</button>
                                <form action="{{ route('executor.funeral_plans.destroy', $plan->id) }}" method="POST"
                                style="display:inline;">
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

<!-- ADD FUNERAL PLAN MODAL -->
<div class="modal fade" id="addFuneralPlanModal" tabindex="-1" role="dialog" aria-labelledby="addFuneralPlanModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addFuneralPlanModalLabel">Add Funeral Plan</h5>
      </div>
      <div class="modal-body">
        <form id="addFuneralPlanForm" enctype="multipart/form-data">
          @csrf
          <div class="form-group mb-4">
            <label for="funeralPlanType">Funeral Plan Type</label>
            <select class="form-control" name="funeral_plan" id="funeralPlanType" required>
              <option value="" selected disabled>--Select Funeral Plan Type--</option>
              <option value="Burial">Burial</option>
              <option value="Cremation">Cremation</option>
              <option value="Woodland burial">Woodland burial</option>
              @foreach($funeralPlanTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="funeral_plan_error"></span>
          </div>
          <div class="form-group mb-2" id="customFuneralPlanInput" style="display: none;">
            <label for="custom_funeral_plan">Custom Funeral Plan Type</label>
            <input type="text" class="form-control" name="custom_funeral_plan" id="custom_funeral_plan"
              placeholder="Enter Custom Funeral Plan Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomFuneralPlan">Save Custom Type</button>
            <span class="text-danger" id="custom_funeral_plan_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="file">Upload Document</label>
            <input type="file" class="form-control" name="file" id="file">
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

<!-- EDIT FUNERAL PLAN MODAL -->
<div class="modal fade" id="editFuneralPlanModal" tabindex="-1" role="dialog" aria-labelledby="editFuneralPlanModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editFuneralPlanModalLabel">Edit Funeral Plan</h5>
      </div>
      <div class="modal-body">
        <form id="editFuneralPlanForm" enctype="multipart/form-data">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editFuneralPlanId">
          <div class="form-group mb-4">
            <label for="editFuneralPlanType">Funeral Plan Type</label>
            <select class="form-control" name="funeral_plan" id="editFuneralPlanType" required>
              <option value="" selected disabled>--Select Funeral Plan Type--</option>
              <option value="Burial">Burial</option>
              <option value="Cremation">Cremation</option>
              <option value="Woodland burial">Woodland burial</option>
              @foreach($funeralPlanTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_funeral_plan_error"></span>
          </div>
          <div class="form-group mb-2" id="editCustomFuneralPlanInput" style="display: none;">
            <label for="edit_custom_funeral_plan">Custom Funeral Plan Type</label>
            <input type="text" class="form-control" name="custom_funeral_plan" id="edit_custom_funeral_plan"
              placeholder="Enter Custom Funeral Plan Type">
            <button type="button" class="btn btn-primary mt-2" id="editSaveCustomFuneralPlan">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_funeral_plan_error"></span>
          </div>
          <div class="form-group mb-4">
            <label for="editFile">Upload Document</label>
            <input type="file" class="form-control" name="file" id="editFile">
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


<script>
  $(document).ready(function () {
    // Handle Add Funeral Plan form submission
    $('#addFuneralPlanForm').on('submit', function (e) {
      e.preventDefault();

      clearErrors(); // Clear previous error messages

      var formData = new FormData(this);

      $.ajax({
        url: "{{ route('executor.funeral_plans.store') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            alert('An error occurred while adding the funeral plan.');
          }
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            displayErrors(errors);
          } else {
            alert('An error occurred. Please try again.');
          }
        }
      });
    });

    // Handle Edit Funeral Plan button click
    $('.edit-button').on('click', function () {
      const id = $(this).data('id');
      const funeralPlan = $(this).data('funeral_plan');

      $('#editFuneralPlanId').val(id);
      $('#editFuneralPlanType').val(funeralPlan);
    });

    // Handle Edit Funeral Plan form submission
    $('#editFuneralPlanForm').on('submit', function (e) {
      e.preventDefault();

      clearEditErrors(); // Clear previous error messages

      var formData = new FormData(this);
      var funeralPlanId = $('#editFuneralPlanId').val(); // Get the funeral plan ID

      $.ajax({
        url: "{{ url('executor/funeral_plans/update') }}" + '/' + funeralPlanId, // Include the ID in the URL
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          if (response.success) {
            location.reload();
          } else {
            alert('An error occurred while editing the funeral plan.');
          }
        },
        error: function (xhr) {
          if (xhr.status === 422) {
            var errors = xhr.responseJSON.errors;
            displayEditErrors(errors);
          } else {
            alert('An error occurred. Please try again.');
          }
        }
      });
    });

    // Clear error messages
    function clearErrors() {
      $('#funeral_plan_error').text('');
      $('#file_error').text('');
    }

    function clearEditErrors() {
      $('#edit_funeral_plan_error').text('');
      $('#edit_file_error').text('');
    }

    // Display error messages
    function displayErrors(errors) {
      if (errors.funeral_plan) {
        $('#funeral_plan_error').text(errors.funeral_plan[0]);
      }
      if (errors.file) {
        $('#file_error').text(errors.file[0]);
      }
    }

    function displayEditErrors(errors) {
      if (errors.funeral_plan) {
        $('#edit_funeral_plan_error').text(errors.funeral_plan[0]);
      }
      if (errors.file) {
        $('#edit_file_error').text(errors.file[0]);
      }
    }
  });

  $('#funeralPlanType').change(function () {
    if ($(this).val() === 'Others') {
      $('#customFuneralPlanInput').show();
    } else {
      $('#customFuneralPlanInput').hide();
    }
  });

  $('#editFuneralPlanType').change(function () {
    if ($(this).val() === 'Others') {
      $('#editCustomFuneralPlanInput').show();
    } else {
      $('#editCustomFuneralPlanInput').hide();
    }
  });

  $('#saveCustomFuneralPlan').on('click', function () {
    const customFuneralPlan = $('#custom_funeral_plan').val();
    if (customFuneralPlan) {
      $.ajax({
        type: 'POST',
        url: "{{ route('executor.funeral_plans.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_funeral_plan: customFuneralPlan
        },
        success: function (response) {
          if (response.success) {
            $('#funeralPlanType').append(new Option(customFuneralPlan, customFuneralPlan));
            $('#funeralPlanType').val(customFuneralPlan);
            $('#customFuneralPlanInput').hide();
          } else {
            $('#custom_funeral_plan_error').text(response.message);
          }
        },
        error: function (response) {
          $('#custom_funeral_plan_error').text('An error occurred while saving the custom funeral plan type.');
        }
      });
    } else {
      $('#custom_funeral_plan_error').text('Custom funeral plan type cannot be empty.');
    }
  });

  $('#editSaveCustomFuneralPlan').on('click', function () {
    const customFuneralPlan = $('#edit_custom_funeral_plan').val();
    if (customFuneralPlan) {
      $.ajax({
        type: 'POST',
        url: "{{ route('executor.funeral_plans.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_funeral_plan: customFuneralPlan
        },
        success: function (response) {
          if (response.success) {
            $('#editFuneralPlanType').append(new Option(customFuneralPlan, customFuneralPlan));
            $('#editFuneralPlanType').val(customFuneralPlan);
            $('#editCustomFuneralPlanInput').hide();
          } else {
            $('#edit_custom_funeral_plan_error').text(response.message);
          }
        },
        error: function (response) {
          $('#edit_custom_funeral_plan_error').text('An error occurred while saving the custom funeral plan type.');
        }
      });
    } else {
      $('#edit_custom_funeral_plan_error').text('Custom funeral plan type cannot be empty.');
    }
  });


</script>
@endsection
