@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addForeignAssetModal">
              Add Foreign Asset
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Foreign Assets</h4>
                <span>List of Foreign Assets.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Foreign Asset</th>
                          <th>Asset Type</th>
                          <th>Asset Location</th>
                          <th>Asset Value</th>
                          <th>Contact Details</th>
                          <th>Entry Date and Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($foreignAssets as $foreignAsset)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $foreignAsset->foreign_asset }}</td>
                          <td>{{ $foreignAsset->asset_type }}</td>
                          <td>{{ $foreignAsset->asset_location }}</td>
                          <td>{{ $foreignAsset->asset_value }}</td>
                          <td>{{ $foreignAsset->contact_details }}</td>
                          <td>{{ $foreignAsset->created_at->format('d/m/Y \a\t H:i') }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editForeignAssetModal" 
                              data-id="{{ $foreignAsset->id }}" 
                              data-foreign_asset="{{ $foreignAsset->foreign_asset }}"
                              data-asset_type="{{ $foreignAsset->asset_type }}"
                              data-asset_location="{{ $foreignAsset->asset_location }}"
                              data-asset_value="{{ $foreignAsset->asset_value }}"
                              data-contact_details="{{ $foreignAsset->contact_details }}">
                              Edit
                            </button>
                            <form action="{{ route('customer.foreign_assets.destroy', $foreignAsset->id) }}" method="POST" style="display:inline;">
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

<!-- ADD FOREIGN ASSET -->
<div class="modal fade" id="addForeignAssetModal" tabindex="-1" role="dialog" aria-labelledby="addForeignAssetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addForeignAssetModalLabel">Add Foreign Asset</h5>
      </div>
      <div class="modal-body">
        <form id="addForeignAssetForm">
          @csrf
          <div class="form-group mb-2">
            <label for="foreignAsset">Foreign Asset</label>
            <input type="text" class="form-control" name="foreign_asset" id="foreignAsset" required>
            <span class="text-danger" id="foreign_asset_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="assetType">Asset Type</label>
            <select class="form-control" name="asset_type" id="assetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Real Estate">Real Estate</option>
              <option value="Bank Account">Bank Account</option>
              <option value="Investment Account">Investment Account</option>
              <option value="Business Interest">Business Interest</option>
              @foreach($assetTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="asset_type_error"></span>
          </div>
          <div class="form-group mb-2" id="customAssetTypeInput" style="display: none;">
            <label for="custom_asset_type">Custom Asset Type</label>
            <input type="text" class="form-control" name="custom_asset_type" id="custom_asset_type"
              placeholder="Enter Custom Asset Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomAssetType">Save Custom Type</button>
            <span class="text-danger" id="custom_asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="assetLocation">Asset Location</label>
            <input type="text" class="form-control" name="asset_location" id="assetLocation" required>
            <span class="text-danger" id="asset_location_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="assetValue">Asset Value</label>
            <input type="text" class="form-control" name="asset_value" id="assetValue" required>
            <span class="text-danger" id="asset_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="contactDetails">Contact Details</label>
            <textarea class="form-control" name="contact_details" id="contactDetails" required></textarea>
            <span class="text-danger" id="contact_details_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveForeignAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT FOREIGN ASSET -->
<div class="modal fade" id="editForeignAssetModal" tabindex="-1" role="dialog" aria-labelledby="editForeignAssetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editForeignAssetModalLabel">Edit Foreign Asset</h5>
      </div>
      <div class="modal-body">
        <form id="editForeignAssetForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editForeignAssetId">
          <div class="form-group mb-2">
            <label for="editForeignAsset">Foreign Asset</label>
            <input type="text" class="form-control" name="foreign_asset" id="editForeignAsset" required>
            <span class="text-danger" id="edit_foreign_asset_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAssetType">Asset Type</label>
            <select class="form-control" name="asset_type" id="editAssetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Real Estate">Real Estate</option>
              <option value="Bank Account">Bank Account</option>
              <option value="Investment Account">Investment Account</option>
              <option value="Business Interest">Business Interest</option>
              @foreach($assetTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_asset_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editCustomAssetTypeInput" style="display: none;">
            <label for="edit_custom_asset_type">Custom Asset Type</label>
            <input type="text" class="form-control" name="custom_asset_type" id="edit_custom_asset_type" 
              placeholder="Enter Custom Asset Type">
            <button type="button" class="btn btn-primary mt-2" id="editSaveCustomAssetType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAssetLocation">Asset Location</label>
            <input type="text" class="form-control" name="asset_location" id="editAssetLocation" required>
            <span class="text-danger" id="edit_asset_location_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAssetValue">Asset Value</label>
            <input type="text" class="form-control" name="asset_value" id="editAssetValue" required>
            <span class="text-danger" id="edit_asset_value_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editContactDetails">Contact Details</label>
            <textarea class="form-control" name="contact_details" id="editContactDetails" required></textarea>
            <span class="text-danger" id="edit_contact_details_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateForeignAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#saveForeignAsset').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.foreign_assets.store') }}",
        data: $('#addForeignAssetForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.foreign_asset) $('#foreign_asset_error').text(errors.foreign_asset[0]);
          if (errors.asset_type) $('#asset_type_error').text(errors.asset_type[0]);
          if (errors.asset_location) $('#asset_location_error').text(errors.asset_location[0]);
          if (errors.asset_value) $('#asset_value_error').text(errors.asset_value[0]);
          if (errors.contact_details) $('#contact_details_error').text(errors.contact_details[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var foreign_asset = $(this).data('foreign_asset');
      var asset_type = $(this).data('asset_type');
      var asset_location = $(this).data('asset_location');
      var asset_value = $(this).data('asset_value');
      var contact_details = $(this).data('contact_details');

      $('#editForeignAssetId').val(id);
      $('#editForeignAsset').val(foreign_asset);
      $('#editAssetType').val(asset_type);
      $('#editAssetLocation').val(asset_location);
      $('#editAssetValue').val(asset_value);
      $('#editContactDetails').val(contact_details);
    });

    $('#updateForeignAsset').on('click', function() {
      var id = $('#editForeignAssetId').val();
      $.ajax({
        type: 'POST',
        url: '/customer/foreign_assets/update/' + id,
        data: $('#editForeignAssetForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.foreign_asset) $('#edit_foreign_asset_error').text(errors.foreign_asset[0]);
          if (errors.asset_type) $('#edit_asset_type_error').text(errors.asset_type[0]);
          if (errors.asset_location) $('#edit_asset_location_error').text(errors.asset_location[0]);
          if (errors.asset_value) $('#edit_asset_value_error').text(errors.asset_value[0]);
          if (errors.contact_details) $('#edit_contact_details_error').text(errors.contact_details[0]);
        }
      });
    });
  });

  $('#assetType').change(function () {
    if ($(this).val() === 'Others') {
      $('#customAssetTypeInput').show();
    } else {
      $('#customAssetTypeInput').hide();
    }
  });

  $('#editAssetType').change(function () {
    if ($(this).val() === 'Others') {
      $('#editCustomAssetTypeInput').show();
    } else {
      $('#editCustomAssetTypeInput').hide();
    }
  });

  $('#saveCustomAssetType').on('click', function () {
    const customAssetType = $('#custom_asset_type').val();
    if (customAssetType) {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.foreign_assets.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_asset_type: customAssetType
        },
        success: function (response) {
          if (response.success) {
            $('#assetType').append(new Option(customAssetType, customAssetType));
            $('#assetType').val(customAssetType);
            $('#customAssetTypeInput').hide();
          } else {
            $('#custom_asset_type_error').text(response.message);
          }
        },
        error: function (response) {
          $('#custom_asset_type_error').text('An error occurred while saving the custom asset type.');
        }
      });
    } else {
      $('#custom_asset_type_error').text('Custom asset type cannot be empty.');
    }
  });

  $('#editSaveCustomAssetType').on('click', function () {
    const customAssetType = $('#edit_custom_asset_type').val();
    if (customAssetType) {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.foreign_assets.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_asset_type: customAssetType
        },
        success: function (response) {
          if (response.success) {
            $('#editAssetType').append(new Option(customAssetType, customAssetType));
            $('#editAssetType').val(customAssetType);
            $('#editCustomAssetTypeInput').hide();
          } else {
            $('#edit_custom_asset_type_error').text(response.message);
          }
        },
        error: function (response) {
          $('#edit_custom_asset_type_error').text('An error occurred while saving the custom asset type.');
        }
      });
    } else {
      $('#edit_custom_asset_type_error').text('Custom asset type cannot be empty.');
    }
  });
</script>
@endsection