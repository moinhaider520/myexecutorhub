@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPensionModal">
              Add Pension
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Pensions</h4>
                <span>List of Pensions.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Pension Provider</th>
                          <th>Pension Reference Number</th>
                          <th>Pensions</th>
                          <th>Entry Date and Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($pensions as $pension)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $pension->pension_provider }}</td>
                          <td>{{ $pension->pension_reference_number }}</td>
                          <td>{{ $pension->pensions }}</td>
                          <td>{{ $pension->created_at->format('d/m/Y \a\t H:i') }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editPensionModal" data-id="{{ $pension->id }}" data-pensions="{{ $pension->pensions }}" data-pension_provider="{{ $pension->pension_provider }}" data-pension_reference_number="{{ $pension->pension_reference_number }}">Edit</button>
                            <form action="{{ route('partner.pensions.destroy', $pension->id) }}" method="POST" style="display:inline;">
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

<!-- ADD PENSION -->
<div class="modal fade" id="addPensionModal" tabindex="-1" role="dialog" aria-labelledby="addPensionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPensionModalLabel">Add Pension</h5>
      </div>
      <div class="modal-body">
        <form id="addPensionForm">
          @csrf
          <div class="form-group mb-2">
            <label for="pensions">Pensions</label>
            <input type="text" class="form-control" name="pensions" id="pensions" required>
            <span class="text-danger" id="pensions_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="pensionProvider">Pension Provider</label>
            <input type="text" class="form-control" name="pension_provider" id="pensionProvider" required>
            <span class="text-danger" id="pension_provider_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="pensionReferenceNumber">Pension Reference Number</label>
            <input type="text" class="form-control" name="pension_reference_number" id="pensionReferenceNumber" required>
            <span class="text-danger" id="pension_reference_number_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="savePension">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT PENSION -->
<div class="modal fade" id="editPensionModal" tabindex="-1" role="dialog" aria-labelledby="editPensionModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPensionModalLabel">Edit Pension</h5>
      </div>
      <div class="modal-body">
        <form id="editPensionForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editPensionId">
          <div class="form-group mb-2">
            <label for="editPensions">Pensions</label>
            <input type="text" class="form-control" name="pensions" id="editPensions" required>
            <span class="text-danger" id="edit_pensions_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPensionProvider">Pension Provider</label>
            <input type="text" class="form-control" name="pension_provider" id="editPensionProvider" required>
            <span class="text-danger" id="edit_pension_provider_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPensionReferenceNumber">Pension Reference Number</label>
            <input type="text" class="form-control" name="pension_reference_number" id="editPensionReferenceNumber" required>
            <span class="text-danger" id="edit_pension_reference_number_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updatePension">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#savePension').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.pensions.store') }}",
        data: $('#addPensionForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.pensions) $('#pensions_error').text(errors.pensions[0]);
          if (errors.pension_provider) $('#pension_provider_error').text(errors.pension_provider[0]);
          if (errors.pension_reference_number) $('#pension_reference_number_error').text(errors.pension_reference_number[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var pensions = $(this).data('pensions');
      var pension_provider = $(this).data('pension_provider');
      var pension_reference_number = $(this).data('pension_reference_number');

      $('#editPensionId').val(id);
      $('#editPensions').val(pensions);
      $('#editPensionProvider').val(pension_provider);
      $('#editPensionReferenceNumber').val(pension_reference_number);
    });

    $('#updatePension').on('click', function() {
      var id = $('#editPensionId').val();
      $.ajax({
        type: 'POST',
        url: '/partner/pension/update/' + id,
        data: $('#editPensionForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.pensions) $('#edit_pensions_error').text(errors.pensions[0]);
          if (errors.pension_provider) $('#edit_pension_provider_error').text(errors.pension_provider[0]);
          if (errors.pension_reference_number) $('#edit_pension_reference_number_error').text(errors.pension_reference_number[0]);
        }
      });
    });
  });
</script>

@endsection
