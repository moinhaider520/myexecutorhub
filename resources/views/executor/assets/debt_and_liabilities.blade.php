@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDebtLiabilityModal">
              Add Debt & Liabilities
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Debt & Liabilities</h4>
                <span>List of Debt & Liabilities.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Type of Debt/Liability</th>
                          <th>Reference Number</th>
                          <th>Loan Provider</th>
                          <th>Contact Details</th>
                          <th>Amount Outstanding</th>
                          <th>Entry Date and Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($debtsLiabilities as $debtLiability)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $debtLiability->debt_type }}</td>
                          <td>{{ $debtLiability->reference_number }}</td>
                          <td>{{ $debtLiability->loan_provider }}</td>
                          <td>{{ $debtLiability->contact_details }}</td>
                          <td>£{{ number_format($debtLiability->amount_outstanding, 0, '.', ',') }}</td>
                          <td>{{ $debtLiability->created_at->format('d/m/Y \a\t H:i') }}</td>
                          <td style="display: flex;">
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editDebtLiabilityModal" data-id="{{ $debtLiability->id }}" data-debt_type="{{ $debtLiability->debt_type }}" data-reference_number="{{ $debtLiability->reference_number }}" data-loan_provider="{{ $debtLiability->loan_provider }}" data-contact_details="{{ $debtLiability->contact_details }}" data-amount_outstanding="{{ $debtLiability->amount_outstanding }}">Edit</button>
                            <form action="{{ route('executor.debt_and_liabilities.destroy', $debtLiability->id) }}" method="POST" style="display:inline;">
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

<!-- ADD DEBT & LIABILITY -->
<div class="modal fade" id="addDebtLiabilityModal" tabindex="-1" role="dialog" aria-labelledby="addDebtLiabilityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDebtLiabilityModalLabel">Add Debt/Liability</h5>
      </div>
      <div class="modal-body">

        <form id="addDebtLiabilityForm">
          @csrf
          <div class="form-group mb-2">
            <label for="debtType">Type of Debt/Liability</label>
            <select class="form-control" name="debt_type" id="debtType" required>
              <option value="" selected disabled>--Select Type of Debt/Liability--</option>
              <option value="Mortgages">Mortgages</option>
              <option value="Personal loans">Personal loans</option>
              <option value="Credit card debt">Credit card debt</option>
              <option value="Outstanding bills and utilities">Outstanding bills and utilities</option>

              @foreach($debtAndLiabilitiesTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="debt_type_error"></span>
          </div>
          <div class="form-group mb-2" id="customDebtTypeInput" style="display: none;">
            <label for="custom_debt_type">Custom Debt & Liabilities Type</label>
            <input type="text" class="form-control" name="custom_debt_type" id="custom_debt_type"
              placeholder="Enter Custom Debt & Liabilities Type">
            <button type="button" class="btn btn-primary mt-2" id="saveDebtInsuranceType">Save Custom Type</button>
            <span class="text-danger" id="custom_debt_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="referenceNumber">Reference Number</label>
            <input type="text" class="form-control" name="reference_number" id="referenceNumber" placeholder="Enter Reference Number" required>
            <span class="text-danger" id="reference_number_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="loanProvider">Loan Provider</label>
            <input type="text" class="form-control" name="loan_provider" id="loanProvider" placeholder="Enter Loan Provider" required>
            <span class="text-danger" id="loan_provider_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="contactDetails">Contact Details</label>
            <input type="text" class="form-control" name="contact_details" id="contactDetails" placeholder="Enter Contact Details" required>
            <span class="text-danger" id="contact_details_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="amountOutstanding">Amount Outstanding</label>
            <input type="text" class="form-control" name="amount_outstanding" id="amountOutstanding" placeholder="Amount Outstanding" required>
            <span class="text-danger" id="amount_outstanding_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveDebtLiability">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT DEBT & LIABILITY -->
<div class="modal fade" id="editDebtLiabilityModal" tabindex="-1" role="dialog" aria-labelledby="editDebtLiabilityModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDebtLiabilityModalLabel">Edit Debt/Liability</h5>
      </div>
      <div class="modal-body">
        <form id="editDebtLiabilityForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editDebtLiabilityId">
          <div class="form-group mb-2">
            <label for="editDebtType">Type of Debt/Liability</label>
            <select class="form-control" name="debt_type" id="editDebtType" required>
              <option value="" selected disabled>--Select Type of Debt/Liability--</option>
              <option value="Mortgages">Mortgages</option>
              <option value="Personal loans">Personal loans</option>
              <option value="Credit card debt">Credit card debt</option>
              <option value="Outstanding bills and utilities">Outstanding bills and utilities</option>
              @foreach($debtAndLiabilitiesTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_debt_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editcustomDebtTypeInput" style="display: none;">
            <label for="edit_custom_debt_type">Custom Debt & Liabilities Type</label>
            <input type="text" class="form-control" name="custom_debt_type" id="edit_custom_debt_type" placeholder="Enter Custom Debt & Liabilities Type">
            <button type="button" class="btn btn-primary mt-2" id="editsaveDebtInsuranceType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_debt_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editReferenceNumber">Reference Number</label>
            <input type="text" class="form-control" name="reference_number" id="editReferenceNumber" placeholder="Enter Reference Number" required>
            <span class="text-danger" id="edit_reference_number_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editLoanProvider">Loan Provider</label>
            <input type="text" class="form-control" name="loan_provider" id="editLoanProvider" placeholder="Enter Loan Provider" required>
            <span class="text-danger" id="edit_loan_provider_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editContactDetails">Contact Details</label>
            <input type="text" class="form-control" name="contact_details" id="editContactDetails" placeholder="Enter Contact Details" required>
            <span class="text-danger" id="edit_contact_details_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAmountOutstanding">Amount Outstanding</label>
            <input type="text" class="form-control" name="amount_outstanding" id="editAmountOutstanding" placeholder="Amount Outstanding" required>
            <span class="text-danger" id="edit_amount_outstanding_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateDebtLiability">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $('#saveDebtLiability').on('click', function() {
    var formData = $('#addDebtLiabilityForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("executor.debt_and_liabilities.store") }}',
      data: formData,
      success: function(response) {
        // Reset form fields if needed
        $('#addDebtLiabilityForm')[0].reset();
        $('#addDebtLiabilityModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function(xhr) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#debt_type_error').text(err.errors.debt_type ? err.errors.debt_type[0] : '');
          $('#reference_number_error').text(err.errors.reference_number ? err.errors.reference_number[0] : '');
          $('#loan_provider_error').text(err.errors.loan_provider ? err.errors.loan_provider[0] : '');
          $('#contact_details_error').text(err.errors.contact_details ? err.errors.contact_details[0] : '');
          $('#amount_outstanding_error').text(err.errors.amount_outstanding ? err.errors.amount_outstanding[0] : '');
        }
      }
    });
  });

  // Edit Debt/Liability Modal Populate Data
  $('#editDebtLiabilityModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var debt_type = button.data('debt_type');
    var reference_number = button.data('reference_number');
    var loan_provider = button.data('loan_provider');
    var contact_details = button.data('contact_details');
    var amount_outstanding = button.data('amount_outstanding');

    var modal = $(this);
    modal.find('.modal-title').text('Edit Debt/Liability');
    modal.find('#editDebtLiabilityId').val(id);
    modal.find('#editDebtType').val(debt_type);
    modal.find('#editReferenceNumber').val(reference_number);
    modal.find('#editLoanProvider').val(loan_provider);
    modal.find('#editContactDetails').val(contact_details);
    modal.find('#editAmountOutstanding').val(amount_outstanding);
  });

  // Update Debt/Liability Form Submission
  $('#updateDebtLiability').on('click', function() {
    var id = $('#editDebtLiabilityId').val();
    var formData = $('#editDebtLiabilityForm').serialize();
    $.ajax({
      type: 'POST',
      url: '/executor/debt_and_liabilities/update/' + id,
      data: formData,
      success: function(response) {
        // Reset form fields if needed
        $('#editDebtLiabilityForm')[0].reset();
        $('#editDebtLiabilityModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function(xhr) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#edit_debt_type_error').text(err.errors.debt_type ? err.errors.debt_type[0] : '');
          $('#edit_reference_number_error').text(err.errors.reference_number ? err.errors.reference_number[0] : '');
          $('#edit_loan_provider_error').text(err.errors.loan_provider ? err.errors.loan_provider[0] : '');
          $('#edit_contact_details_error').text(err.errors.contact_details ? err.errors.contact_details[0] : '');
          $('#edit_amount_outstanding_error').text(err.errors.amount_outstanding ? err.errors.amount_outstanding[0] : '');
        }
      }
    });
  });


  $('#debtType').change(function () {
      if ($(this).val() === 'Others') {
        $('#customDebtTypeInput').show();
      } else {
        $('#customDebtTypeInput').hide();
      }
    });

    $('#editDebtType').change(function () {
      if ($(this).val() === 'Others') {
        $('#editcustomDebtTypeInput').show();
      } else {
        $('#editcustomDebtTypeInput').hide();
      }
    });

    $('#saveDebtInsuranceType').on('click', function () {
      const customDebtType = $('#custom_debt_type').val();
      if (customDebtType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('executor.debt_and_liabilities.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_debt_and_liabilities_type: customDebtType
          },
          success: function (response) {
            if (response.success) {
              $('#debtType').append(new Option(customDebtType, customDebtType));
              $('#debtType').val(customDebtType);
              $('#customDebtTypeInput').hide();
            } else {
              $('#custom_debt_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#custom_debt_type_error').text('An error occurred while saving the custom bank type.');
          }
        });
      } else {
        $('#custom_debt_type_error').text('Custom Investment type cannot be empty.');
      }
    });

    $('#editsaveDebtInsuranceType').on('click', function () {
      const customDebtType = $('#edit_custom_debt_type').val();
      if (customDebtType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('executor.debt_and_liabilities.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_debt_and_liabilities_type: customDebtType
          },
          success: function (response) {
            if (response.success) {
              $('#editDebtType').append(new Option(customDebtType, customDebtType));
              $('#editDebtType').val(customDebtType);
              $('#editcustomDebtTypeInput').hide();
            } else {
              $('#edit_custom_debt_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#edit_custom_debt_type_error').text('An error occurred while saving the custom Investment type.');
          }
        });
      } else {
        $('#edit_custom_debt_type_error').text('Custom Investment type cannot be empty.');
      }
    });

</script>
@endsection
