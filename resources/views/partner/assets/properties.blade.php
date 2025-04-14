@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPropertyModal">
              Add Property (ies) Owned
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Property (ies) Owned</h4>
                <span>List of Property (ies) Owned.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Property Type</th>
                          <th>Property Address</th>
                          <th>Owner Name(s)</th>
                          <th>How Owned?</th>
                          <th>Value</th>
                          <th>Entry Date and Time</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($properties as $property)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $property->property_type }}</td>
                          <td>{{ $property->address }}</td>
                          <td>{{ $property->owner_names }}</td>
                          <td>{{ $property->how_owned }}</td>
                          <td>£{{ number_format($property->value, 0, '.', ',') }}</td>
                          <td>{{ $property->created_at->format('d/m/Y \a\t H:i') }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editPropertyModal" data-id="{{ $property->id }}" data-property_type="{{ $property->property_type }}" data-address="{{ $property->address }}" data-owner_names="{{ $property->owner_names }}" data-how_owned="{{ $property->how_owned }}" data-value="{{ $property->value }}">Edit</button>
                            <form action="{{ route('partner.properties.destroy', $property->id) }}" method="POST" style="display:inline;">
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

<!-- ADD PROPERTY MODAL -->
<div class="modal fade" id="addPropertyModal" tabindex="-1" role="dialog" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPropertyModalLabel">Add Property (ies) Owned</h5>
      </div>
      <div class="modal-body">
        <form id="addPropertyForm">
          @csrf
          <div class="form-group mb-2">
            <label>Property Type</label>
            <select class="form-control" name="property_type" id="propertyType" required>
              <option value="" selected disabled>--Select Property Type--</option>
              <option value="Primary Residence">Primary Residence</option>
              <option value="Secondary Homes (Holiday Homes)">Secondary Homes (Holiday Homes)</option>
              <option value="Buy-to-let Property">Buy-to-let Property</option>
              <option value="Land & Other Property Interests">Land & Other Property Interests</option>
              @foreach($propertyTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="property_type_error"></span>
          </div>
          <div class="form-group mb-2" id="customPropertyTypeInput" style="display: none;">
            <label for="custom_property_type">Custom Investment Type</label>
            <input type="text" class="form-control" name="custom_property_type" id="custom_property_type"
              placeholder="Enter Custom Property Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomPropertyType">Save Custom Type</button>
            <span class="text-danger" id="custom_property_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="propertyAddress">Property Address</label>
            <input type="text" class="form-control" name="address" id="propertyAddress" placeholder="Enter Property Address" required>
            <span class="text-danger" id="address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="ownerName">Owner Name(s)</label>
            <input type="text" class="form-control" name="owner_names" id="ownerName" placeholder="Owner Name(s)" required>
            <span class="text-danger" id="owner_names_error"></span>
          </div>
          <div class="form-group mb-2">
            <label>How Owned?</label>
            <select class="form-control" name="how_owned" id="howOwned" required>
              <option value="" selected disabled>--Select Ownership--</option>
              <option value="Solely">Solely</option>
              <option value="Joint Tenants">Joint Tenants</option>
              <option value="Tenants in Common">Tenants in Common</option>
            </select>
            <span class="text-danger" id="how_owned_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="valuation">Value (GBP)</label>
            <input type="number" class="form-control" name="value" id="valuation" placeholder="Enter Value" required>
            <span class="text-danger" id="value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveProperty">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT PROPERTY MODAL -->
<div class="modal fade" id="editPropertyModal" tabindex="-1" role="dialog" aria-labelledby="editPropertyModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editPropertyModalLabel">Edit Property (ies) Owned</h5>
      </div>
      <div class="modal-body">
        <form id="editPropertyForm">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="editPropertyId">
          <div class="form-group mb-2">
            <label>Property Type</label>
            <select class="form-control" name="property_type" id="editPropertyType" required>
              <option value="" selected disabled>--Select Property Type--</option>
              <option value="Primary Residence">Primary Residence</option>
              <option value="Secondary Homes (Holiday Homes)">Secondary Homes (Holiday Homes)</option>
              <option value="Buy-to-let Property">Buy-to-let Property</option>
              <option value="Land & Other Property Interests">Land & Other Property Interests</option>
              @foreach($propertyTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_property_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editCustomPropertyTypeInput" style="display: none;">
            <label for="edit_custom_property_type">Custom Property Type</label>
            <input type="text" class="form-control" name="custom_property_type" id="edit_custom_property_type" placeholder="Enter Custom Property Type">
            <button type="button" class="btn btn-primary mt-2" id="editsaveCustomPropertyType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_property_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPropertyAddress">Property Address</label>
            <input type="text" class="form-control" name="address" id="editPropertyAddress" placeholder="Enter Property Address" required>
            <span class="text-danger" id="edit_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editOwnerName">Owner Name(s)</label>
            <input type="text" class="form-control" name="owner_names" id="editOwnerName" placeholder="Owner Name(s)" required>
            <span class="text-danger" id="edit_owner_names_error"></span>
          </div>
          <div class="form-group mb-2">
            <label>How Owned?</label>
            <select class="form-control" name="how_owned" id="editHowOwned" required>
              <option value="" selected disabled>--Select Ownership--</option>
              <option value="Solely">Solely</option>
              <option value="Joint Tenants">Joint Tenants</option>
              <option value="Tenants in Common">Tenants in Common</option>
            </select>
            <span class="text-danger" id="edit_how_owned_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editValuation">Value (GBP)</label>
            <input type="number" class="form-control" name="value" id="editValuation" placeholder="Enter Value" required>
            <span class="text-danger" id="edit_value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateProperty">Update changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function() {
    $('#saveProperty').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.properties.store') }}",
        data: $('#addPropertyForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          const errors = response.responseJSON.errors;
          if (errors.property_type) $('#property_type_error').text(errors.property_type[0]);
          if (errors.address) $('#address_error').text(errors.address[0]);
          if (errors.owner_names) $('#owner_names_error').text(errors.owner_names[0]);
          if (errors.how_owned) $('#how_owned_error').text(errors.how_owned[0]);
          if (errors.value) $('#value_error').text(errors.value[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      const id = $(this).data('id');
      $('#editPropertyId').val(id);
      $('#editPropertyType').val($(this).data('property_type'));
      $('#editPropertyAddress').val($(this).data('address'));
      $('#editOwnerName').val($(this).data('owner_names'));
      $('#editHowOwned').val($(this).data('how_owned'));
      $('#editValuation').val($(this).data('value'));
    });

    $('#updateProperty').on('click', function() {
      const id = $('#editPropertyId').val();
      $.ajax({
        type: 'PUT',
        url: "{{ url('customer/properties/update') }}/" + id,
        data: $('#editPropertyForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          const errors = response.responseJSON.errors;
          if (errors.property_type) $('#edit_property_type_error').text(errors.property_type[0]);
          if (errors.address) $('#edit_address_error').text(errors.address[0]);
          if (errors.owner_names) $('#edit_owner_names_error').text(errors.owner_names[0]);
          if (errors.how_owned) $('#edit_how_owned_error').text(errors.how_owned[0]);
          if (errors.value) $('#edit_value_error').text(errors.value[0]);
        }
      });
    });

    $('#propertyType').change(function () {
      if ($(this).val() === 'Others') {
        $('#customPropertyTypeInput').show();
      } else {
        $('#customPropertyTypeInput').hide();
      }
    });

    $('#editPropertyType').change(function () {
      if ($(this).val() === 'Others') {
        $('#editCustomPropertyTypeInput').show();
      } else {
        $('#editCustomPropertyTypeInput').hide();
      }
    });

    $('#saveCustomPropertyType').on('click', function () {
      const customInvestmentType = $('#custom_property_type').val();
      if (customInvestmentType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.properties.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_property_type: customInvestmentType
          },
          success: function (response) {
            if (response.success) {
              $('#propertyType').append(new Option(customInvestmentType, customInvestmentType));
              $('#propertyType').val(customBankType);
              $('#customPropertyTypeInput').hide();
            } else {
              $('#custom_property_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#custom_property_type_error').text('An error occurred while saving the custom bank type.');
          }
        });
      } else {
        $('#custom_property_type_error').text('Custom Investment type cannot be empty.');
      }
    });

    $('#editsaveCustomPropertyType').on('click', function () {
      const customInvestmentType = $('#edit_custom_property_type').val();
      if (customInvestmentType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('partner.properties.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_property_type: customInvestmentType
          },
          success: function (response) {
            if (response.success) {
              $('#editPropertyType').append(new Option(customInvestmentType, customInvestmentType));
              $('#editPropertyType').val(customInvestmentType);
              $('#editCustomPropertyTypeInput').hide();
            } else {
              $('#edit_custom_property_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#edit_custom_property_type_error').text('An error occurred while saving the custom Investment type.');
          }
        });
      } else {
        $('#edit_custom_property_type_error').text('Custom Investment type cannot be empty.');
      }
    });

  });
</script>
@endsection