@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addOtherAssetModal">
              Add Other Type of Assets
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Other Type of Assets</h4>
                <span>List of Other Type of Assets.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Asset Type</th>
                          <th>Description</th>
                          <th>Entry Date n Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($otherAssets as $otherAsset)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $otherAsset->asset_type }}</td>
                          <td>{{ $otherAsset->description }}</td>
                          <td>{{ $otherAsset->created_at->format('d/m/Y \a\t H:i') }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editOtherAssetModal" data-id="{{ $otherAsset->id }}" data-asset_type="{{ $otherAsset->asset_type }}" data-description="{{ $otherAsset->description }}">Edit</button>
                            <form action="{{ route('partner.other_type_of_assets.destroy', $otherAsset->id) }}" method="POST" style="display:inline;">
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

<!-- ADD OTHER ASSET -->
<div class="modal fade" id="addOtherAssetModal" tabindex="-1" role="dialog" aria-labelledby="addOtherAssetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addOtherAssetModalLabel">Add Other Asset</h5>
      </div>
      <div class="modal-body">
        <form id="addOtherAssetForm">
          @csrf
          <div class="form-group mb-2">
            <label for="assetType">Asset Type</label>
            <select class="form-control" name="asset_type" id="assetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Safe deposit boxes and their contents">Safe deposit boxes and their contents</option>
              <option value="Annuities">Annuities</option>
              <option value="Pension benefits and lump sum payments">Pension benefits and lump sum payments</option>
              <option value="Trust interests">Trust interests</option>
              <option value="Foriegn Assets">Foriegn Assets</option>
              @foreach($otherAssetTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="asset_type_error"></span>
          </div>
          <div class="form-group mb-2" id="customAssetTypeInput" style="display: none;">
            <label for="custom_asset_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_asset_type" id="custom_asset_type"
              placeholder="Enter Custom Asset Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomAssetType">Save Custom Type</button>
            <span class="text-danger" id="custom_asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveOtherAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT OTHER ASSET -->
<div class="modal fade" id="editOtherAssetModal" tabindex="-1" role="dialog" aria-labelledby="editOtherAssetModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOtherAssetModalLabel">Edit Other Asset</h5>
      </div>
      <div class="modal-body">
        <form id="editOtherAssetForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editOtherAssetId">
          <div class="form-group mb-2">
            <label for="editAssetType">Asset Type</label>
            <select class="form-control" name="asset_type" id="editAssetType" required>
              <option value="" selected disabled>--Select Asset Type--</option>
              <option value="Safe deposit boxes and their contents">Safe deposit boxes and their contents</option>
              <option value="Annuities">Annuities</option>
              <option value="Pension benefits and lump sum payments">Pension benefits and lump sum payments</option>
              <option value="Trust interests">Trust interests</option>
              <option value="Foriegn Assets">Foriegn Assets</option>
              @foreach($otherAssetTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_asset_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editcustomAssetTypeInput" style="display: none;">
            <label for="edit_custom_asset_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_asset_type" id="edit_custom_asset_type" placeholder="Enter Custom Asset Type">
            <button type="button" class="btn btn-primary mt-2" id="editsaveCustomAssetType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_asset_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateOtherAsset">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#saveOtherAsset').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.other_type_of_assets.store') }}",
        data: $('#addOtherAssetForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.asset_type) $('#asset_type_error').text(errors.asset_type[0]);
          if (errors.description) $('#description_error').text(errors.description[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var asset_type = $(this).data('asset_type');
      var description = $(this).data('description');

      $('#editOtherAssetId').val(id);
      $('#editAssetType').val(asset_type);
      $('#editDescription').val(description);
    });

    $('#updateOtherAsset').on('click', function() {
      var id = $('#editOtherAssetId').val();
      $.ajax({
        type: 'POST',
        url: '/partner/other_type_of_assets/update/' + id,
        data: $('#editOtherAssetForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.asset_type) $('#edit_asset_type_error').text(errors.asset_type[0]);
          if (errors.description) $('#edit_description_error').text(errors.description[0]);
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
        $('#editcustomAssetTypeInput').show();
      } else {
        $('#editcustomAssetTypeInput').hide();
      }
    });

    $('#saveCustomAssetType').on('click', function () {
      const customAssetType = $('#custom_asset_type').val();
      if (customAssetType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.other_type_of_assets.save_custom_type') }}",
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
            $('#custom_asset_type_error').text('An error occurred while saving the custom bank type.');
          }
        });
      } else {
        $('#custom_asset_type_error').text('Custom Investment type cannot be empty.');
      }
    });

    $('#editsaveCustomAssetType').on('click', function () {
      const customAssetType = $('#edit_custom_asset_type').val();
      if (customAssetType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.other_type_of_assets.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_asset_type: customAssetType
          },
          success: function (response) {
            if (response.success) {
              $('#editAssetType').append(new Option(customAssetType, customAssetType));
              $('#editAssetType').val(customAssetType);
              $('#editcustomAssetTypeInput').hide();
            } else {
              $('#edit_custom_asset_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#edit_custom_asset_type_error').text('An error occurred while saving the custom Investment type.');
          }
        });
      } else {
        $('#edit_custom_asset_type_error').text('Custom Investment type cannot be empty.');
      }
    });


</script>
@endsection
