@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDigitalAssetModal">
              Add Digital Asset
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Digital Assets</h4>
                <span>List of Digital Assets.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Asset Type</th>
                          <th>Asset Name</th>
                          <th>Username</th>
                          <th>Password</th>
                          <th>Email Used to create Account</th>
                          <th>Value</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($digitalAssets as $digitalAsset)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $digitalAsset->asset_type }}</td>
                          <td>{{ $digitalAsset->asset_name }}</td>
                          <td>{{ $digitalAsset->username }}</td>
                          <td>{{ $digitalAsset->password }}</td>
                          <td>{{ $digitalAsset->email_used }}</td>
                          <td>{{ $digitalAsset->value }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editDigitalAssetModal" data-id="{{ $digitalAsset->id }}" data-asset_type="{{ $digitalAsset->asset_type }}" data-asset_name="{{ $digitalAsset->asset_name }}" data-username="{{ $digitalAsset->username }}" data-password="{{ $digitalAsset->password }}" data-email_used="{{ $digitalAsset->email_used }}" data-value="{{ $digitalAsset->value }}">Edit</button>
                            <form action="{{ route('customer.digital_assets.destroy', $digitalAsset->id) }}" method="POST" style="display:inline;">
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

<!-- ADD DIGITAL ASSET -->
<div class="modal fade" id="addDigitalAssetModal" tabindex="-1" role="dialog" aria-labelledby="addDigitalAssetModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDigitalAssetModalLabel">Add Digital Asset</h5>
      </div>
      <div class="modal-body">
        <form id="addDigitalAssetForm">
          @csrf
          <div class="form-group mb-2">
            <label for="assetType">Type of Asset</label>
            <select class="form-control" name="asset_type" id="assetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Online Banking Account">Online Banking Account</option>
              <option value="Investment Account">Investment Account</option>
              <option value="Digital Wallet">Digital Wallet</option>
              <option value="Social Media Account">Social Media Account</option>
              <option value="Digital Media">Digital Media</option>
            </select>
            <span class="text-danger" id="asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="assetName">Asset Name</label>
            <input type="text" class="form-control" name="asset_name" id="assetName" placeholder="Enter Asset Name" required>
            <span class="text-danger" id="asset_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username" required>
            <span class="text-danger" id="username_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="password">Password</label>
            <input type="text" class="form-control" name="password" id="password" placeholder="Enter Password" required>
            <span class="text-danger" id="password_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="emailUsed">Email Used?</label>
            <input type="text" class="form-control" name="email_used" id="emailUsed" placeholder="Email Used to Create Account?" required>
            <span class="text-danger" id="email_used_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="value">Value in GBP</label>
            <input type="text" class="form-control" name="value" id="value" placeholder="Value in GBP" required>
            <span class="text-danger" id="value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveDigitalAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT DIGITAL ASSET -->
<div class="modal fade" id="editDigitalAssetModal" tabindex="-1" role="dialog" aria-labelledby="editDigitalAssetModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDigitalAssetModalLabel">Edit Digital Asset</h5>
      </div>
      <div class="modal-body">
        <form id="editDigitalAssetForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editDigitalAssetId">
          <div class="form-group mb-2">
            <label for="editAssetType">Type of Asset</label>
            <select class="form-control" name="asset_type" id="editAssetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Online Banking Account">Online Banking Account</option>
              <option value="Investment Account">Investment Account</option>
              <option value="Digital Wallet">Digital Wallet</option>
              <option value="Social Media Account">Social Media Account</option>
              <option value="Digital Media">Digital Media</option>
            </select>
            <span class="text-danger" id="edit_asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAssetName">Asset Name</label>
            <input type="text" class="form-control" name="asset_name" id="editAssetName" placeholder="Enter Asset Name" required>
            <span class="text-danger" id="edit_asset_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editUsername">Username</label>
            <input type="text" class="form-control" name="username" id="editUsername" placeholder="Enter Username" required>
            <span class="text-danger" id="edit_username_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPassword">Password</label>
            <input type="text" class="form-control" name="password" id="editPassword" placeholder="Enter Password" required>
            <span class="text-danger" id="edit_password_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editEmailUsed">Email Used?</label>
            <input type="text" class="form-control" name="email_used" id="editEmailUsed" placeholder="Email Used to Create Account?" required>
            <span class="text-danger" id="edit_email_used_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editValue">Value in GBP</label>
            <input type="text" class="form-control" name="value" id="editValue" placeholder="Value in GBP" required>
            <span class="text-danger" id="edit_value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateDigitalAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  // Add Digital Asset Form Submission
  $('#saveDigitalAsset').on('click', function () {
    var formData = $('#addDigitalAssetForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("customer.digital_assets.store") }}',
      data: formData,
      success: function (response) {
        // Reset form fields
        $('#addDigitalAssetForm')[0].reset();
        $('#addDigitalAssetModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#asset_type_error').text(err.errors.asset_type ? err.errors.asset_type[0] : '');
          $('#asset_name_error').text(err.errors.asset_name ? err.errors.asset_name[0] : '');
          $('#username_error').text(err.errors.username ? err.errors.username[0] : '');
          $('#password_error').text(err.errors.password ? err.errors.password[0] : '');
          $('#email_used_error').text(err.errors.email_used ? err.errors.email_used[0] : '');
          $('#value_error').text(err.errors.value ? err.errors.value[0] : '');
        }
      }
    });
  });

  // Edit Digital Asset Modal Populate Data
  $('#editDigitalAssetModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var asset_type = button.data('asset_type');
    var asset_name = button.data('asset_name');
    var username = button.data('username');
    var password = button.data('password');
    var email_used = button.data('email_used');
    var value = button.data('value');

    var modal = $(this);
    modal.find('.modal-title').text('Edit Digital Asset');
    modal.find('#editDigitalAssetId').val(id);
    modal.find('#editAssetType').val(asset_type);
    modal.find('#editAssetName').val(asset_name);
    modal.find('#editUsername').val(username);
    modal.find('#editPassword').val(password);
    modal.find('#editEmailUsed').val(email_used);
    modal.find('#editValue').val(value);
  });

  // Update Digital Asset Form Submission
  $('#updateDigitalAsset').on('click', function () {
    var id = $('#editDigitalAssetId').val();
    var formData = $('#editDigitalAssetForm').serialize();
    $.ajax({
      type: 'POST',
      url: '/customer/digital_assets/update/' + id,
      data: formData,
      success: function (response) {
        // Reset form fields
        $('#editDigitalAssetForm')[0].reset();
        $('#editDigitalAssetModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#edit_asset_type_error').text(err.errors.asset_type ? err.errors.asset_type[0] : '');
          $('#edit_asset_name_error').text(err.errors.asset_name ? err.errors.asset_name[0] : '');
          $('#edit_username_error').text(err.errors.username ? err.errors.username[0] : '');
          $('#edit_password_error').text(err.errors.password ? err.errors.password[0] : '');
          $('#edit_email_used_error').text(err.errors.email_used ? err.errors.email_used[0] : '');
          $('#edit_value_error').text(err.errors.value ? err.errors.value[0] : '');
        }
      }
    });
  });
</script>
@endsection
