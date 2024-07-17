@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addIntellectualPropertyModal">
              Add Intellectual Property
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Intellectual Properties</h4>
                <span>List of Intellectual Properties.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-2_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-2" role="grid" aria-describedby="basic-2_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Property Type</th>
                          <th>Description</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <!-- Data will be dynamically loaded here -->
                        @foreach($intellectualProperties as $property)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $property->property_type }}</td>
                          <td>{{ $property->description }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editIntellectualPropertyModal"
                              data-id="{{ $property->id }}" data-property_type="{{ $property->property_type }}" data-description="{{ $property->description }}">Edit</button>
                            <form action="{{ route('customer.intellectual_properties.destroy', $property->id) }}" method="POST" style="display:inline;">
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

<!-- ADD INTELLECTUAL PROPERTY -->
<div class="modal fade" id="addIntellectualPropertyModal" tabindex="-1" role="dialog" aria-labelledby="addIntellectualPropertyModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addIntellectualPropertyModalLabel">Add Intellectual Property</h5>
      </div>
      <div class="modal-body">
        <form id="addIntellectualPropertyForm">
          @csrf
          <div class="form-group mb-2">
            <label for="propertyType">Property Type</label>
            <select class="form-control" name="property_type" id="propertyType" required>
              <option value="" selected disabled>--Select Property Type--</option>
              <option value="Copyrights">Copyrights</option>
              <option value="Trademarks">Trademarks</option>
              <option value="Patents">Patents</option>
              <option value="Royalties">Royalties</option>
              @foreach($intellectualPropertyTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="propertyType_error"></span>
          </div>
          <div class="form-group mb-2" id="customPropertyTypeInput" style="display: none;">
            <label for="custom_property_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_property_type" id="custom_property_type"
              placeholder="Enter Custom Property Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomPropertyType">Save Custom Type</button>
            <span class="text-danger" id="custom_property_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="Enter Description" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveIntellectualProperty">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT INTELLECTUAL PROPERTY -->
<div class="modal fade" id="editIntellectualPropertyModal" tabindex="-1" role="dialog" aria-labelledby="editIntellectualPropertyModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editIntellectualPropertyModalLabel">Edit Intellectual Property</h5>
      </div>
      <div class="modal-body">
        <form id="editIntellectualPropertyForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editIntellectualPropertyId">
          <div class="form-group mb-2">
            <label for="editPropertyType">Property Type</label>
            <select class="form-control" name="property_type" id="editPropertyType" required>
              <option value="" selected disabled>--Select Property Type--</option>
              <option value="Copyrights">Copyrights</option>
              <option value="Trademarks">Trademarks</option>
              <option value="Patents">Patents</option>
              <option value="Royalties">Royalties</option>
              @foreach($intellectualPropertyTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_propertyType_error"></span>
          </div>
          <div class="form-group mb-2" id="editcustomPropertyTypeInput" style="display: none;">
            <label for="edit_custom_property_type">Custom Insurance Type</label>
            <input type="text" class="form-control" name="custom_property_type" id="edit_custom_property_type" placeholder="Enter Custom Property Type">
            <button type="button" class="btn btn-primary mt-2" id="editsaveCustomPropertyType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_property_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" placeholder="Enter Description" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateIntellectualProperty">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  // Add Intellectual Property Form Submission
  $('#saveIntellectualProperty').on('click', function () {
    var formData = $('#addIntellectualPropertyForm').serialize();
    $.ajax({
      type: 'POST',
      url: '{{ route("customer.intellectual_properties.store") }}',
      data: formData,
      success: function (response) {
        // Reset form fields
        $('#addIntellectualPropertyForm')[0].reset();
        $('#addIntellectualPropertyModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#propertyType_error').text(err.errors.property_type ? err.errors.property_type[0] : '');
          $('#description_error').text(err.errors.description ? err.errors.description[0] : '');
        }
      }
    });
  });

  // Edit Intellectual Property Modal Populate Data
  $('#editIntellectualPropertyModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var property_type = button.data('property_type');
    var description = button.data('description');

    var modal = $(this);
    modal.find('.modal-title').text('Edit Intellectual Property');
    modal.find('#editIntellectualPropertyId').val(id);
    modal.find('#editPropertyType').val(property_type);
    modal.find('#editDescription').val(description);
  });

  // Update Intellectual Property Form Submission
  $('#updateIntellectualProperty').on('click', function () {
    var id = $('#editIntellectualPropertyId').val();
    var formData = $('#editIntellectualPropertyForm').serialize();
    $.ajax({
      type: 'POST',
      url: '/customer/intellectual_properties/update/' + id,
      data: formData,
      success: function (response) {
        // Reset form fields
        $('#editIntellectualPropertyForm')[0].reset();
        $('#editIntellectualPropertyModal').modal('hide');
        // Update table or refresh page
        location.reload();
      },
      error: function (xhr, status, error) {
        // Handle validation errors
        var err = JSON.parse(xhr.responseText);
        if (err.errors) {
          $('#edit_propertyType_error').text(err.errors.property_type ? err.errors.property_type[0] : '');
          $('#edit_description_error').text(err.errors.description ? err.errors.description[0] : '');
        }
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
        $('#editcustomPropertyTypeInput').show();
      } else {
        $('#editcustomPropertyTypeInput').hide();
      }
    });

    $('#saveCustomPropertyType').on('click', function () {
      const customPropertyType = $('#custom_property_type').val();
      if (customPropertyType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('customer.intellectual_properties.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_intellectual_property_type: customPropertyType
          },
          success: function (response) {
            if (response.success) {
              $('#propertyType').append(new Option(customPropertyType, customPropertyType));
              $('#propertyType').val(customPropertyType);
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
      const customPropertyType = $('#edit_custom_property_type').val();
      if (customPropertyType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('customer.intellectual_properties.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_intellectual_property_type: customPropertyType
          },
          success: function (response) {
            if (response.success) {
              $('#editPropertyType').append(new Option(customPropertyType, customPropertyType));
              $('#editPropertyType').val(customPropertyType);
              $('#editcustomPropertyTypeInput').hide();
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


</script>
@endsection