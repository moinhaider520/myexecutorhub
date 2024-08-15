@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addInsurancePolicyModal">
              Add Insurance Policy
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Insurance Policies</h4>
                <span>List of Insurance Policies.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Insurance Type</th>
                          <th>Name of Provider</th>
                          <th>Policy/Reference Number</th>
                          <th>Sum Insured</th>
                          <th>Contact Details of Provider</th>
                          <th>Named Beneficiaries?</th>
                          <th>Policy End/Renewal Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($insurancePolicies as $insurancePolicy)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $insurancePolicy->insurance_type }}</td>
                          <td>{{ $insurancePolicy->provider_name }}</td>
                          <td>{{ $insurancePolicy->policy_number }}</td>
                          <td>{{ $insurancePolicy->sum_insured }}</td>
                          <td>{{ $insurancePolicy->contact_details }}</td>
                          <td>{{ $insurancePolicy->beneficiaries }}</td>
                          <td>{{ $insurancePolicy->policy_end_date }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editInsurancePolicyModal" data-id="{{ $insurancePolicy->id }}" data-insurance_type="{{ $insurancePolicy->insurance_type }}" data-provider_name="{{ $insurancePolicy->provider_name }}" data-policy_number="{{ $insurancePolicy->policy_number }}" data-sum_insured="{{ $insurancePolicy->sum_insured }}" data-contact_details="{{ $insurancePolicy->contact_details }}" data-beneficiaries="{{ $insurancePolicy->beneficiaries }}" data-policy_end_date="{{ $insurancePolicy->policy_end_date }}">Edit</button>
                            <form action="{{ route('partner.insurance_policies.destroy', $insurancePolicy->id) }}" method="POST" style="display:inline;">
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

<!-- ADD INSURANCE POLICY -->
<div class="modal fade" id="addInsurancePolicyModal" tabindex="-1" role="dialog" aria-labelledby="addInsurancePolicyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addInsurancePolicyModalLabel">Add Insurance Policy</h5>
      </div>
      <div class="modal-body">
        <form id="addInsurancePolicyForm">
          @csrf
          <div class="form-group mb-2">
            <label for="insuranceType">Insurance Type</label>
            <select class="form-control" name="insurance_type" id="insuranceType" required>
              <option value="" selected disabled>--Select Insurance Type--</option>
              <option value="Life Insurance">Life Insurance</option>
              <option value="Health Insurance">Health Insurance</option>
              <option value="Home Insurance">Home Insurance</option>
              <option value="Car Insurance">Car Insurance</option>
              <option value="While of life cover">While of life cover</option>
              <option value="Pet insurance">Pet insurance</option>
              <option value="Funeral plan">Funeral plan</option>
              @foreach($insuranceTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="insuranceTypeError"></span>
          </div>
          <div class="form-group mb-2" id="customInsuranceTypeInput" style="display: none;">
            <label for="custom_insurance_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_insurance_type" id="custom_insurance_type"
              placeholder="Enter Custom Insurance Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomInsuranceType">Save Custom Type</button>
            <span class="text-danger" id="custom_insurance_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="providerName">Name of Provider</label>
            <input type="text" class="form-control" name="provider_name" id="providerName" placeholder="Enter Name of Provider" required>
            <span class="text-danger" id="providerNameError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="policyNumber">Policy/Reference Number</label>
            <input type="text" class="form-control" name="policy_number" id="policyNumber" placeholder="Enter Policy/Reference Number" required>
            <span class="text-danger" id="policyNumberError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="sumInsured">SUM Insured</label>
            <input type="number" class="form-control" name="sum_insured" id="sumInsured" placeholder="Enter SUM Insured" required>
            <span class="text-danger" id="sumInsuredError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="contactDetails">Contact Details of Provider</label>
            <input type="text" class="form-control" name="contact_details" id="contactDetails" placeholder="Contact Details of Provider" required>
            <span class="text-danger" id="contactDetailsError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="beneficiaries">Named Beneficiaries</label>
            <input type="text" class="form-control" name="beneficiaries" id="beneficiaries" placeholder="Named Beneficiaries" required>
            <span class="text-danger" id="beneficiariesError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="policyEndDate">Policy End/Renewal Date</label>
            <input type="date" class="form-control" name="policy_end_date" id="policyEndDate" required>
            <span class="text-danger" id="policyEndDateError"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveInsurancePolicy">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT INSURANCE POLICY -->
<div class="modal fade" id="editInsurancePolicyModal" tabindex="-1" role="dialog" aria-labelledby="editInsurancePolicyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editInsurancePolicyModalLabel">Edit Insurance Policy</h5>
      </div>
      <div class="modal-body">
        <form id="editInsurancePolicyForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editInsurancePolicyId">
          <div class="form-group mb-2">
            <label for="editInsuranceType">Insurance Type</label>
            <select class="form-control" name="insurance_type" id="editInsuranceType" required>
              <option value="" selected disabled>--Select Insurance Type--</option>
              <option value="Life Insurance">Life Insurance</option>
              <option value="Health Insurance">Health Insurance</option>
              <option value="Home Insurance">Home Insurance</option>
              <option value="Car Insurance">Car Insurance</option>
              <option value="While of life cover">While of life cover</option>
              <option value="Pet insurance">Pet insurance</option>
              <option value="Funeral plan">Funeral plan</option>
              @foreach($insuranceTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="editInsuranceTypeError"></span>
          </div>
          <div class="form-group mb-2" id="editcustomInsuranceTypeInput" style="display: none;">
            <label for="edit_custom_insurance_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_insurance_type" id="edit_custom_insurance_type" placeholder="Enter Custom Insurance Type">
            <button type="button" class="btn btn-primary mt-2" id="editsaveCustomInsuranceType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_insurance_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editProviderName">Name of Provider</label>
            <input type="text" class="form-control" name="provider_name" id="editProviderName" placeholder="Enter Name of Provider" required>
            <span class="text-danger" id="editProviderNameError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPolicyNumber">Policy/Reference Number</label>
            <input type="text" class="form-control" name="policy_number" id="editPolicyNumber" placeholder="Enter Policy/Reference Number" required>
            <span class="text-danger" id="editPolicyNumberError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editSumInsured">SUM Insured</label>
            <input type="number" class="form-control" name="sum_insured" id="editSumInsured" placeholder="Enter SUM Insured" required>
            <span class="text-danger" id="editSumInsuredError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editContactDetails">Contact Details of Provider</label>
            <input type="text" class="form-control" name="contact_details" id="editContactDetails" placeholder="Contact Details of Provider" required>
            <span class="text-danger" id="editContactDetailsError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editBeneficiaries">Named Beneficiaries</label>
            <input type="text" class="form-control" name="beneficiaries" id="editBeneficiaries" placeholder="Named Beneficiaries" required>
            <span class="text-danger" id="editBeneficiariesError"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPolicyEndDate">Policy End/Renewal Date</label>
            <input type="date" class="form-control" name="policy_end_date" id="editPolicyEndDate" required>
            <span class="text-danger" id="editPolicyEndDateError"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateInsurancePolicy">Update changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  // Add Insurance Policy Form Submission
  $('#saveInsurancePolicy').on('click', function() {
    var formData = $('#addInsurancePolicyForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("partner.insurance_policies.store") }}',
      data: formData,
      success: function(response) {
        // Reset form fields if needed
        $('#addInsurancePolicyForm')[0].reset();
        $('#addInsurancePolicyModal').modal('hide');
        // Update table or refresh page
        location.reload(); // Example: You can replace this with specific DOM update
      },
      error: function(xhr) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#insuranceTypeError').text(err.errors.insurance_type ? err.errors.insurance_type[0] : '');
          $('#providerNameError').text(err.errors.provider_name ? err.errors.provider_name[0] : '');
          $('#policyNumberError').text(err.errors.policy_number ? err.errors.policy_number[0] : '');
          $('#sumInsuredError').text(err.errors.sum_insured ? err.errors.sum_insured[0] : '');
          $('#contactDetailsError').text(err.errors.contact_details ? err.errors.contact_details[0] : '');
          $('#beneficiariesError').text(err.errors.beneficiaries ? err.errors.beneficiaries[0] : '');
          $('#policyEndDateError').text(err.errors.policy_end_date ? err.errors.policy_end_date[0] : '');
        }
      }
    });
  });

  // Edit Insurance Policy Modal Populate Data
  $('#editInsurancePolicyModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var insurance_type = button.data('insurance_type');
    var provider_name = button.data('provider_name');
    var policy_number = button.data('policy_number');
    var sum_insured = button.data('sum_insured');
    var contact_details = button.data('contact_details');
    var beneficiaries = button.data('beneficiaries');
    var policy_end_date = button.data('policy_end_date');

    var modal = $(this);
    modal.find('.modal-title').text('Edit Insurance Policy');
    modal.find('#editInsurancePolicyId').val(id);
    modal.find('#editInsuranceType').val(insurance_type);
    modal.find('#editProviderName').val(provider_name);
    modal.find('#editPolicyNumber').val(policy_number);
    modal.find('#editSumInsured').val(sum_insured);
    modal.find('#editContactDetails').val(contact_details);
    modal.find('#editBeneficiaries').val(beneficiaries);
    modal.find('#editPolicyEndDate').val(policy_end_date);
  });

  // Update Insurance Policy Form Submission
  $('#updateInsurancePolicy').on('click', function() {
    var id = $('#editInsurancePolicyId').val();
    var formData = $('#editInsurancePolicyForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("partner.insurance_policies.update", "") }}/' + id,
      data: formData,
      success: function(response) {
        // Reset form fields if needed
        $('#editInsurancePolicyForm')[0].reset();
        $('#editInsurancePolicyModal').modal('hide');
        // Update table or refresh page
        location.reload(); // Example: You can replace this with specific DOM update
      },
      error: function(xhr) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#editInsuranceTypeError').text(err.errors.insurance_type ? err.errors.insurance_type[0] : '');
          $('#editProviderNameError').text(err.errors.provider_name ? err.errors.provider_name[0] : '');
          $('#editPolicyNumberError').text(err.errors.policy_number ? err.errors.policy_number[0] : '');
          $('#editSumInsuredError').text(err.errors.sum_insured ? err.errors.sum_insured[0] : '');
          $('#editContactDetailsError').text(err.errors.contact_details ? err.errors.contact_details[0] : '');
          $('#editBeneficiariesError').text(err.errors.beneficiaries ? err.errors.beneficiaries[0] : '');
          $('#editPolicyEndDateError').text(err.errors.policy_end_date ? err.errors.policy_end_date[0] : '');
        }
      }
    });
  });

  $('#insuranceType').change(function () {
      if ($(this).val() === 'Others') {
        $('#customInsuranceTypeInput').show();
      } else {
        $('#customInsuranceTypeInput').hide();
      }
    });

    $('#editInsuranceType').change(function () {
      if ($(this).val() === 'Others') {
        $('#editcustomInsuranceTypeInput').show();
      } else {
        $('#editcustomInsuranceTypeInput').hide();
      }
    });

    $('#saveCustomInsuranceType').on('click', function () {
      const customInsuranceType = $('#custom_insurance_type').val();
      if (customInsuranceType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.insurance_policies.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_insurance_type: customInsuranceType
          },
          success: function (response) {
            if (response.success) {
              $('#insuranceType').append(new Option(customInsuranceType, customInsuranceType));
              $('#insuranceType').val(customInsuranceType);
              $('#customInsuranceTypeInput').hide();
            } else {
              $('#custom_insurance_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#custom_insurance_type_error').text('An error occurred while saving the custom bank type.');
          }
        });
      } else {
        $('#custom_insurance_type_error').text('Custom Investment type cannot be empty.');
      }
    });

    $('#editsaveCustomInsuranceType').on('click', function () {
      const customInsuranceType = $('#edit_custom_insurance_type').val();
      if (customInsuranceType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.insurance_policies.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_insurance_type: customInsuranceType
          },
          success: function (response) {
            if (response.success) {
              $('#editInsuranceType').append(new Option(customInsuranceType, customInsuranceType));
              $('#editInsuranceType').val(customInsuranceType);
              $('#editcustomInsuranceTypeInput').hide();
            } else {
              $('#edit_custom_insurance_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#edit_custom_insurance_type_error').text('An error occurred while saving the custom Investment type.');
          }
        });
      } else {
        $('#edit_custom_insurance_type_error').text('Custom Investment type cannot be empty.');
      }
    });

</script>

@endsection