@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addChattelModal">
              Add Personal Chattel
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Personal Chattels</h4>
                <span>List of Personal Chattels.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Chattel Type</th>
                          <th>Chattel Description</th>
                          <th>Photos</th>
                          <th>Value (GBP)</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($personalChattels as $chattel)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $chattel->chattel_type }}</td>
                          <td>{{ $chattel->description }}</td>
                          <td>
                            @php
                            $photos = json_decode($chattel->photos);
                            @endphp

                            @if (!empty($photos))
                            @foreach($photos as $photo)
                            @if (!empty($photo))
                            <a href="{{ asset('assets/upload/' . $photo) }}" target="_blank">
                              <img src="{{ asset('assets/upload/' . $photo) }}" width="50" height="50" alt="Chattel Photo">
                            </a>
                            @endif
                            @endforeach
                            @else
                            No photos
                            @endif
                          </td>
                          <td>£{{ number_format($chattel->value, 0, '.', ',') }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editChattelModal" data-id="{{ $chattel->id }}" data-chattel_type="{{ $chattel->chattel_type }}" data-description="{{ $chattel->description }}" data-value="{{ $chattel->value }}">Edit</button>
                            <form action="{{ route('partner.personal_chattels.destroy', $chattel->id) }}" method="POST" style="display:inline;">
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

<!-- ADD PERSONAL CHATTEL -->
<div class="modal fade" id="addChattelModal" tabindex="-1" role="dialog" aria-labelledby="addChattelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addChattelModalLabel">Add Personal Chattel</h5>
      </div>
      <div class="modal-body">
        <form id="addChattelForm">
          @csrf
          <div class="form-group mb-2">
            <label for="chattelType">Chattel Type</label>
            <select class="form-control" name="chattel_type" id="chattelType" required>
              <option value="" selected disabled>--Select Chattel Type--</option>
              @foreach($chattelTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>

            <span class="text-danger" id="chattel_type_error"></span>
          </div>
          <div class="form-group mb-2" id="customChattelTypeInput" style="display: none;">
            <label for="custom_chattel_type">Custom Chattel Type</label>
            <input type="text" class="form-control" name="custom_chattel_type" id="custom_chattel_type" placeholder="Enter Custom Chattel Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomChattelType">Save Custom Type</button>
            <span class="text-danger" id="custom_chattel_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" required></textarea>
            <span class="text-danger" id="description_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="photos">Upload Photos</label>
            <input type="file" class="form-control" name="photos[]" id="photos" multiple required>
            <span class="text-danger" id="photos_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="value">Value (GBP)</label>
            <input type="text" class="form-control" name="value" id="value" placeholder="Enter Value in GBP" required>
            <span class="text-danger" id="value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveChattel">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT PERSONAL CHATTEL -->
<div class="modal fade" id="editChattelModal" tabindex="-1" role="dialog" aria-labelledby="editChattelModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editChattelModalLabel">Edit Personal Chattel</h5>
      </div>
      <div class="modal-body">
        <form id="editChattelForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editChattelId">
          <div class="form-group mb-2">
            <label for="editChattelType">Chattel Type</label>
            <select class="form-control" name="chattel_type" id="editChattelType" required>
              <option value="" selected disabled>--Select Chattel Type--</option>
              @foreach($chattelTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_chattel_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editCustomChattelTypeInput" style="display: none;">
            <label for="edit_custom_chattel_type">Custom Chattel Type</label>
            <input type="text" class="form-control" name="custom_chattel_type" id="edit_custom_chattel_type" placeholder="Enter Custom Chattel Type">
            <button type="button" class="btn btn-primary mt-2" id="editSaveCustomChattelType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_chattel_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editDescription">Description</label>
            <textarea class="form-control" name="description" id="editDescription" required></textarea>
            <span class="text-danger" id="edit_description_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPhotos">Upload Photos</label>
            <input type="file" class="form-control" name="photos[]" id="editPhotos" multiple>
            <span class="text-danger" id="edit_photos_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editValue">Value (GBP)</label>
            <input type="text" class="form-control" name="value" id="editValue" placeholder="Enter Value in GBP" required>
            <span class="text-danger" id="edit_value_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateChattel">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#saveChattel').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.personal_chattels.store') }}",
        data: new FormData($('#addChattelForm')[0]),
        contentType: false,
        processData: false,
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.chattel_type) $('#chattel_type_error').text(errors.chattel_type[0]);
          if (errors.description) $('#description_error').text(errors.description[0]);
          if (errors.photos) $('#photos_error').text(errors.photos[0]);
          if (errors.value) $('#value_error').text(errors.value[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      const id = $(this).data('id');
      $('#editChattelId').val(id);
      $('#editChattelType').val($(this).data('chattel_type'));
      $('#editDescription').val($(this).data('description'));
      $('#editValue').val($(this).data('value'));
      
      if ($('#editChattelType').val() === 'Others') {
        $('#editCustomChattelTypeInput').show();
      } else {
        $('#editCustomChattelTypeInput').hide();
      }
    });

    $('#updateChattel').on('click', function() {
      const id = $('#editChattelId').val();
      $.ajax({
        type: 'POST',
        url: "{{ url('customer/personal_chattels/update') }}/" + id,
        data: new FormData($('#editChattelForm')[0]),
        contentType: false,
        processData: false,
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.chattel_type) $('#edit_chattel_type_error').text(errors.chattel_type[0]);
          if (errors.description) $('#edit_description_error').text(errors.description[0]);
          if (errors.photos) $('#edit_photos_error').text(errors.photos[0]);
          if (errors.value) $('#edit_value_error').text(errors.value[0]);
        }
      });
    });
  });

  $('#chattelType').change(function() {
    if ($(this).val() === 'Others') {
      $('#customChattelTypeInput').show();
    } else {
      $('#customChattelTypeInput').hide();
    }
  });

  $('#editChattelType').change(function() {
    if ($(this).val() === 'Others') {
      $('#editCustomChattelTypeInput').show();
    } else {
      $('#editCustomChattelTypeInput').hide();
    }
  });

  $('#saveCustomChattelType').on('click', function() {
    const customChattelType = $('#custom_chattel_type').val();
    if (customChattelType) {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.personal_chattels.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_chattel_type: customChattelType
        },
        success: function(response) {
          if (response.success) {
            $('#chattelType').append(new Option(customChattelType, customChattelType));
            $('#chattelType').val(customChattelType);
            $('#customChattelTypeInput').hide();
          } else {
            $('#custom_chattel_type_error').text(response.message);
          }
        },
        error: function(response) {
          $('#custom_chattel_type_error').text('An error occurred while saving the custom chattel type.');
        }
      });
    } else {
      $('#custom_chattel_type_error').text('Custom chattel type cannot be empty.');
    }
  });

  $('#editSaveCustomChattelType').on('click', function() {
    const customChattelType = $('#edit_custom_chattel_type').val();
    if (customChattelType) {
      $.ajax({
        type: 'POST',
        url: "{{ route('partner.personal_chattels.save_custom_type') }}",
        data: {
          _token: "{{ csrf_token() }}",
          custom_chattel_type: customChattelType
        },
        success: function(response) {
          if (response.success) {
            $('#editChattelType').append(new Option(customChattelType, customChattelType));
            $('#editChattelType').val(customChattelType);
            $('#editCustomChattelTypeInput').hide();
          } else {
            $('#edit_custom_chattel_type_error').text(response.message);
          }
        },
        error: function(response) {
          $('#edit_custom_chattel_type_error').text('An error occurred while saving the custom chattel type.');
        }
      });
    } else {
      $('#edit_custom_chattel_type_error').text('Custom chattel type cannot be empty.');
    }
  });
</script>

@endsection
