@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBusinessInterestModal">
              Add Business Interest
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Business Interests</h4>
                <span>List of Business Interests.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Business Type</th>
                          <th>Business Name</th>
                          <th>Shares %</th>
                          <th>Business Value (GBP)</th>
                          <th>Shares Value (GBP)</th>
                          <th>Who to Contact?</th>
                          <th>Plan For Shares</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($businessInterests as $businessInterest)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $businessInterest->business_type }}</td>
                          <td>{{ $businessInterest->business_name }}</td>
                          <td>{{ $businessInterest->shares }}</td>
                          <td>{{ $businessInterest->business_value }}</td>
                          <td>{{ $businessInterest->share_value }}</td>
                          <td>{{ $businessInterest->contact }}</td>
                          <td>{{ $businessInterest->plan_for_shares }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editBusinessInterestModal" data-id="{{ $businessInterest->id }}" data-business_type="{{ $businessInterest->business_type }}" data-business_name="{{ $businessInterest->business_name }}" data-shares="{{ $businessInterest->shares }}" data-business_value="{{ $businessInterest->business_value }}" data-share_value="{{ $businessInterest->share_value }}" data-contact="{{ $businessInterest->contact }}" data-plan_for_shares="{{ $businessInterest->plan_for_shares }}">Edit</button>
                            <form action="{{ route('customer.business_interests.destroy', $businessInterest->id) }}" method="POST" style="display:inline;">
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

<!-- ADD BUSINESS INTEREST -->
<div class="modal fade" id="addBusinessInterestModal" tabindex="-1" role="dialog" aria-labelledby="addBusinessInterestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBusinessInterestModalLabel">Add Business Interest</h5>
      </div>
      <div class="modal-body">
        <form id="addBusinessInterestForm">
          @csrf
          <div class="form-group mb-2">
            <label for="businessType">Business Type</label>
            <select class="form-control" name="business_type" id="businessType" required>
              <option value="" selected disabled>--Select Business Type--</option>
              <option value="Ownership in privately held businesses">Ownership in privately held businesses</option>
              <option value="Partnership interests">Partnership interests</option>
              <option value="Shares in family businesses">Shares in family businesses</option>
            </select>
            <span class="text-danger" id="business_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="businessName">Business Name</label>
            <input type="text" class="form-control" name="business_name" id="businessName" placeholder="Enter Business name" required>
            <span class="text-danger" id="business_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="sharesPercentage">Amount of Shares (%)</label>
            <input type="number" class="form-control" name="shares" id="sharesPercentage" placeholder="Enter Amount of Shares in %" required>
            <span class="text-danger" id="shares_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="businessValue">Business Value (GBP)</label>
            <input type="number" class="form-control" name="business_value" id="businessValue" placeholder="Enter Business Value" required>
            <span class="text-danger" id="business_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="sharesValue">Value of Shares (GBP)</label>
            <input type="number" class="form-control" name="share_value" id="sharesValue" placeholder="Enter Value of Shares" required>
            <span class="text-danger" id="share_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="contact">Who to Contact?</label>
            <input type="text" class="form-control" name="contact" id="contact" placeholder="Who to Contact?" required>
            <span class="text-danger" id="contact_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="planForShares">Plan For Shares</label>
            <input type="text" class="form-control" name="plan_for_shares" id="planForShares" placeholder="Plan For Shares?" required>
            <span class="text-danger" id="plan_for_shares_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveBusinessInterest">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT BUSINESS INTEREST -->
<div class="modal fade" id="editBusinessInterestModal" tabindex="-1" role="dialog" aria-labelledby="editBusinessInterestModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editBusinessInterestModalLabel">Edit Business Interest</h5>
      </div>
      <div class="modal-body">
        <form id="editBusinessInterestForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editBusinessInterestId">
          <div class="form-group mb-2">
            <label for="editBusinessType">Business Type</label>
            <select class="form-control" name="business_type" id="editBusinessType" required>
              <option value="" selected disabled>--Select Business Type--</option>
              <option value="Ownership in privately held businesses">Ownership in privately held businesses</option>
              <option value="Partnership interests">Partnership interests</option>
              <option value="Shares in family businesses">Shares in family businesses</option>
            </select>
            <span class="text-danger" id="edit_business_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editBusinessName">Business Name</label>
            <input type="text" class="form-control" name="business_name" id="editBusinessName" placeholder="Enter Business name" required>
            <span class="text-danger" id="edit_business_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editSharesPercentage">Amount of Shares (%)</label>
            <input type="number" class="form-control" name="shares" id="editSharesPercentage" placeholder="Enter Amount of Shares in %" required>
            <span class="text-danger" id="edit_shares_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editBusinessValue">Business Value (GBP)</label>
            <input type="number" class="form-control" name="business_value" id="editBusinessValue" placeholder="Enter Business Value" required>
           
            <span class="text-danger" id="edit_business_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editSharesValue">Value of Shares (GBP)</label>
            <input type="number" class="form-control" name="share_value" id="editSharesValue" placeholder="Enter Value of Shares" required>
            <span class="text-danger" id="edit_share_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editContact">Who to Contact?</label>
            <input type="text" class="form-control" name="contact" id="editContact" placeholder="Who to Contact?" required>
            <span class="text-danger" id="edit_contact_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPlanForShares">Plan For Shares</label>
            <input type="text" class="form-control" name="plan_for_shares" id="editPlanForShares" placeholder="Plan For Shares?" required>
            <span class="text-danger" id="edit_plan_for_shares_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateBusinessInterest">Update</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  // Add Business Interest Form Submission
  $('#saveBusinessInterest').on('click', function () {
    var formData = $('#addBusinessInterestForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("customer.business_interests.store") }}',
      data: formData,
      success: function (response) {
        // Reset form fields if needed
        $('#addBusinessInterestForm')[0].reset();
        $('#addBusinessInterestModal').modal('hide');
        // Update table or refresh page
        location.reload(); // Example: You can replace this with specific DOM update
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#business_type_error').text(err.errors.business_type ? err.errors.business_type[0] : '');
          $('#business_name_error').text(err.errors.business_name ? err.errors.business_name[0] : '');
          $('#shares_error').text(err.errors.shares ? err.errors.shares[0] : '');
          $('#business_value_error').text(err.errors.business_value ? err.errors.business_value[0] : '');
          $('#share_value_error').text(err.errors.share_value ? err.errors.share_value[0] : '');
          $('#contact_error').text(err.errors.contact ? err.errors.contact[0] : '');
          $('#plan_for_shares_error').text(err.errors.plan_for_shares ? err.errors.plan_for_shares[0] : '');
        }
      }
    });
  });

  // Edit Business Interest Modal Populate Data
  $('#editBusinessInterestModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var business_type = button.data('business_type');
    var business_name = button.data('business_name');
    var shares = button.data('shares');
    var business_value = button.data('business_value');
    var share_value = button.data('share_value');
    var contact = button.data('contact');
    var plan_for_shares = button.data('plan_for_shares');

    var modal = $(this);
    modal.find('.modal-title').text('Edit Business Interest');
    modal.find('#editBusinessInterestId').val(id);
    modal.find('#editBusinessType').val(business_type);
    modal.find('#editBusinessName').val(business_name);
    modal.find('#editSharesPercentage').val(shares);
    modal.find('#editBusinessValue').val(business_value);
    modal.find('#editSharesValue').val(share_value);
    modal.find('#editContact').val(contact);
    modal.find('#editPlanForShares').val(plan_for_shares);
  });

  // Update Business Interest Form Submission
  $('#updateBusinessInterest').on('click', function () {
    var id = $('#editBusinessInterestId').val();
    var formData = $('#editBusinessInterestForm').serialize();
    $.ajax({
      type: 'POST',
      url: '/customer/business_interests/update/' + id,
      data: formData,
      success: function (response) {
        // Reset form fields if needed
        $('#editBusinessInterestForm')[0].reset();
        $('#editBusinessInterestModal').modal('hide');
        // Update table or refresh page
        location.reload(); // Example: You can replace this with specific DOM update
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#edit_business_type_error').text(err.errors.business_type ? err.errors.business_type[0] : '');
          $('#edit_business_name_error').text(err.errors.business_name ? err.errors.business_name[0] : '');
          $('#edit_shares_error').text(err.errors.shares ? err.errors.shares[0] : '');
          $('#edit_business_value_error').text(err.errors.business_value ? err.errors.business_value[0] : '');
          $('#edit_share_value_error').text(err.errors.share_value ? err.errors.share_value[0] : '');
          $('#edit_contact_error').text(err.errors.contact ? err.errors.contact[0] : '');
          $('#edit_plan_for_shares_error').text(err.errors.plan_for_shares ? err.errors.plan_for_shares[0] : '');
        }
      }
    });
  });

</script>
@endsection
