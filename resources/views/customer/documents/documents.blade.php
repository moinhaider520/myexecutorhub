@extends('layouts.master')

@section('content')
  <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
      <div class="row">
        <div class="col-md-12 d-flex justify-content-end p-2">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDocumentModal">
          Add Document
        </button>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
        <div class="card">
          <div class="card-header">
          <h4>Documents</h4>
          <span>List of Documents.</span>
          </div>
          <div class="card-body">
          <div class="table-responsive theme-scrollbar">
            <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
            <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
              <thead>
              <tr role="row">
                <th>Sr</th>
                <th>Document Type</th>
                <th>Description</th>
                <th>Download Link</th>
                <th>Reminder Date</th>
                <th>Reviews</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach($documents as $document)
          <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $document->document_type }}</td>
          <td>{{ $document->description }}</td>
          <td><a href="{{ asset('assets/upload/' . basename($document->file_path)) }}"
            target="_blank">Download</a></td>
          <td>
          {{ $document->reminder_date ? date('d M Y', strtotime($document->reminder_date)) : 'Not set' }}
          </td>
          <td><button type="button" class="btn btn-secondary btn-sm edit-button" data-toggle="modal"
            data-target="#ReviewModal" data-id="{{ $document->id }}">View Reviews</button></td>
          <td>
          <button type="button" class="btn btn-primary btn-sm edit-button" data-toggle="modal"
            data-target="#AddReviewModal" data-id="{{ $document->id }}">Add Reviews</button>
          <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
            data-target="#editDocumentModal" data-id="{{ $document->id }}"
            data-document_type="{{ $document->document_type }}"
            data-description="{{ $document->description }}"
            data-reminder_date="{{ $document->reminder_date }}"
            data-reminder_type="{{ $document->reminder_type }}">Edit</button>
          <form action="{{ route('customer.documents.destroy', $document->id) }}" method="POST"
            style="display:inline;">
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

  <!-- ADD DOCUMENT MODAL -->
  <div class="modal fade" id="addDocumentModal" tabindex="-1" role="dialog" aria-labelledby="addDocumentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Add Document</h5>
      </div>
      <div class="modal-body">
      <form id="addDocumentForm" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-4">
        <label for="documentType">Document Type</label>
        <select class="form-control" name="document_type" id="documentType" required>
          <option value="" selected disabled>--Select Document Type--</option>
          @php
      $defaultTypes = [
        "Property deeds and titles",
        "Tax returns and tax documents",
        "Loan agreements",
        "Business contracts",
        "DEEDS",
        "Life insurance",
        "Mortgage",
        "Draft Document",
        "Will",
        "Foreign Wills",
        "Will register certificate",
        "Will commentary",
        "Glossary",
        "Will clarity statement",
        "Trust",
        "Lasting power of attorney property & finance",
        "Lasting power of attorney health & welfare",
        "Advanced directive property & finance",
        "Advance directive health & welfare",
        "Letter of exclusion",
        "Memorandum of wishes"
      ];
      @endphp
          @foreach($defaultTypes as $type)
        <option value="{{ $type }}">
        {{ $type }}{{ in_array($type, $usedDocumentTypes) ? ' ✓' : ' (n/a)' }}
        </option>

      @endforeach
          @foreach($documentTypes as $type)
        <option value="{{ $type->name }}">
        {{ $type->name }}{{ in_array($type->name, $usedDocumentTypes) ? ' ✓' : ' (n/a)' }}
        </option>
      @endforeach
          <option value="Others">Others</option>
        </select>
        <span class="text-danger" id="document_type_error"></span>
        </div>

        <div class="form-group mb-2" id="customDocumentTypeInput" style="display: none;">
        <label for="custom_document_type">Custom Document Type</label>
        <input type="text" class="form-control" name="custom_document_type" id="custom_document_type"
          placeholder="Enter Custom Document Type">
        <button type="button" class="btn btn-primary mt-2" id="saveCustomDocumentType">Save Custom Type</button>
        <span class="text-danger" id="custom_document_type_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="description">Description</label>
        <textarea class="form-control" name="description" id="description" required></textarea>
        <span class="text-danger" id="description_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="file">Upload Document</label>
        <input type="file" class="form-control" name="file" id="file">
        <span class="text-danger" id="file_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="reminder_date">Reminder Date</label>
        <input type="date" class="form-control" name="reminder_date" id="reminder_date">
        <span class="text-danger" id="reminder_date_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="reminder_date">Reminder Type</label>
        <select class="form-control" name="reminder_type">
          <option value="" selected disabled>Choose Reminder Type</option>
          <option value="mobile">Mobile Notification</option>
          <option value="email">Email Notification</option>
        </select>
        <span class="text-danger" id="reminder_type_error"></span>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>

  <!-- EDIT DOCUMENT MODAL -->
  <div class="modal fade" id="editDocumentModal" tabindex="-1" role="dialog" aria-labelledby="editDocumentModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title">Edit Document</h5>
      </div>
      <div class="modal-body">
      <form id="editDocumentForm" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <input type="hidden" name="id" id="editDocumentId">
        <div class="form-group mb-4">
        <label for="editDocumentType">Document Type</label>
        <select class="form-control" name="document_type" id="editDocumentType" required>
          <option value="" selected disabled>--Select Document Type--</option>
          @foreach($defaultTypes as $type)
        <option value="{{ $type }}">
        {{ $type }}{{ in_array($type, $usedDocumentTypes) ? ' ✓' : ' (n/a)' }}
        </option>
      @endforeach

          @foreach($documentTypes as $type)
        <option value="{{ $type->name }}">
        {{ $type->name }}{{ in_array($type->name, $usedDocumentTypes) ? ' ✓' : ' (n/a)' }}
        </option>
      @endforeach
          <option value="Others">Others</option>
        </select>
        <span class="text-danger" id="edit_document_type_error"></span>
        </div>

        <div class="form-group mb-2" id="editcustomDocumentTypeInput" style="display: none;">
        <label for="edit_custom_document_type">Custom Document Type</label>
        <input type="text" class="form-control" name="custom_document_type" id="edit_custom_document_type"
          placeholder="Enter Custom Document Type">
        <button type="button" class="btn btn-primary mt-2" id="editsaveCustomDocumentType">Save Custom Type</button>
        <span class="text-danger" id="edit_custom_document_type_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="editDescription">Description</label>
        <textarea class="form-control" name="description" id="editDescription" required></textarea>
        <span class="text-danger" id="edit_description_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="editFile">Upload Document</label>
        <input type="file" class="form-control" name="file" id="editFile">
        <span class="text-danger" id="edit_file_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="editReminderDate">Reminder Date</label>
        <input type="date" class="form-control" name="reminder_date" id="editReminderDate">
        <span class="text-danger" id="edit_reminder_date_error"></span>
        </div>

        <div class="form-group mb-4">
        <label for="reminder_date">Reminder Type</label>
        <select class="form-control" name="edit_reminder_type" id="edit_reminder_type">
          <option value="" selected disabled>Choose Reminder Type</option>
          <option value="mobile">Mobile Notification</option>
          <option value="email">Email Notification</option>
        </select>
        <span class="text-danger" id="edit_reminder_type_error"></span>
        </div>

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>

  <!-- ADD Reviews -->
  <div class="modal fade" id="AddReviewModal" tabindex="-1" role="dialog" aria-labelledby="AddReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="AddReviewModalLabel">Add Review</h5>
      </div>
      <div class="modal-body">
      <form id="addReviewForm" action="{{ route('customer.reviews.store') }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="document_id" id="reviewDocumentId">

        <div class="form-group mb-4">
        <label for="description">Write Your Review/Notes</label>
        <textarea class="form-control" name="description" id="description" required></textarea>
        <span class="text-danger" id="description_error"></span>
        </div>

        <div class="wrapper" style="border:1px solid #000;">
        <canvas id="signature-pad" class="signature-pad" width="400" height="200"></canvas>
        </div>

        <input type="hidden" id="signature-result" name="signature_image">
        <!-- Hidden field to store the signature -->

        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" id="clear" class="btn btn-sm btn-secondary">Clear</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
      </div>
    </div>
    </div>
  </div>

  <!-- Review Modal -->
  <div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="ReviewModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="ReviewModalLabel">Document Reviews</h5>
      </div>
      <div class="modal-body" id="reviewsContainer">
      <!-- Reviews will be dynamically loaded here -->
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
  <script>
    $(function () {
    var signaturePad = new SignaturePad(document.getElementById('signature-pad'), {
      backgroundColor: 'rgba(255, 255, 255, 0)',
      penColor: 'rgb(0, 0, 0)'
    });

    function getSignatureData() {
      if (!signaturePad.isEmpty()) {
      var imageData = signaturePad.toDataURL('image/png'); // Get image data as Base64
      $('#signature-result').val(imageData); // Store Base64 image in hidden input
      $('#signature-img-result').attr('src', imageData).show(); // Optional: Show image preview
      } else {
      alert("Please provide a signature.");
      }
    }

    // Clear the signature pad when "Clear" button is clicked
    $('#clear').click(function (e) {
      e.preventDefault();
      signaturePad.clear();
    });

    $('#addReviewForm').on('submit', function (e) {
      getSignatureData(); // Capture the signature as Base64
    });

    });
  </script>
  <script>
    $(document).ready(function () {
    // Handle Add Document form submission
    $('#addDocumentForm').on('submit', function (e) {
      e.preventDefault();

      clearErrors(); // Clear previous error messages

      var formData = new FormData(this);

      $.ajax({
      url: "{{ route('customer.documents.store') }}",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
        location.reload();
        } else {
        alert('An error occurred while adding the document.');
        }
      },
      error: function (xhr) {
        if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        displayErrors(errors);
        } else {
        alert('An error occurred. Please try again.');
        }
      }
      });
    });

    // Handle Edit Document button click
    $('.edit-button').on('click', function () {
      const id = $(this).data('id');
      const documentType = $(this).data('document_type');
      const description = $(this).data('description');
      const reminderDate = $(this).data('reminder_date');
      const reminder_type = $(this).data('reminder_type');


      $('#editDocumentId').val(id);
      $('#editDocumentType').val(documentType);
      $('#editDescription').val(description);
      $('#editReminderDate').val(reminderDate);
      $('#edit_reminder_type').val(reminder_type);
    });

    // Handle Edit Document form submission
    $('#editDocumentForm').on('submit', function (e) {
      e.preventDefault();

      clearEditErrors(); // Clear previous error messages

      var formData = new FormData(this);
      var documentId = $('#editDocumentId').val(); // Get the document ID

      $.ajax({
      url: "{{ url('customer/documents/update') }}" + '/' + documentId, // Include the ID in the URL
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        if (response.success) {
        location.reload();
        } else {
        alert('An error occurred while editing the document.');
        }
      },
      error: function (xhr) {
        if (xhr.status === 422) {
        var errors = xhr.responseJSON.errors;
        displayEditErrors(errors);
        } else {
        alert('An error occurred. Please try again.');
        }
      }
      });
    });

    // Clear error messages
    function clearErrors() {
      $('#document_type_error').text('');
      $('#description_error').text('');
      $('#file_error').text('');
      $('#reminder_date_error').text('');
      $('#reminder_type_error').text('');

    }

    function clearEditErrors() {
      $('#edit_document_type_error').text('');
      $('#edit_description_error').text('');
      $('#edit_file_error').text('');
      $('#edit_reminder_date_error').text('');
      $('#edit_reminder_type_error').text('');

    }

    // Display error messages
    function displayErrors(errors) {
      if (errors.document_type) {
      $('#document_type_error').text(errors.document_type[0]);
      }
      if (errors.description) {
      $('#description_error').text(errors.description[0]);
      }
      if (errors.file) {
      $('#file_error').text(errors.file[0]);
      }
      if (errors.reminder_date) {
      $('#reminder_date_error').text(errors.reminder_date[0]);
      }
      if (errors.reminder_type) {
      $('#reminder_type_error').text(errors.reminder_type[0]);
      }

    }

    function displayEditErrors(errors) {
      if (errors.document_type) {
      $('#edit_document_type_error').text(errors.document_type[0]);
      }
      if (errors.description) {
      $('#edit_description_error').text(errors.description[0]);
      }
      if (errors.file) {
      $('#edit_file_error').text(errors.file[0]);
      }
      if (errors.reminder_date) {
      $('#edit_reminder_date_error').text(errors.reminder_date[0]);
      }
      if (errors.reminder_type) {
      $('#edit_reminder_type_error').text(errors.reminder_type[0]);
      }

    }
    });

    $('#documentType').change(function () {
    if ($(this).val() === 'Others') {
      $('#customDocumentTypeInput').show();
    } else {
      $('#customDocumentTypeInput').hide();
    }
    });

    $('#editDocumentType').change(function () {
    if ($(this).val() === 'Others') {
      $('#editcustomDocumentTypeInput').show();
    } else {
      $('#editcustomDocumentTypeInput').hide();
    }
    });

    $('#saveCustomDocumentType').on('click', function () {
    const customDocumentType = $('#custom_document_type').val();
    if (customDocumentType) {
      $.ajax({
      type: 'POST',
      url: "{{ route('customer.documents.save_custom_type') }}",
      data: {
        _token: "{{ csrf_token() }}",
        custom_document_type: customDocumentType
      },
      success: function (response) {
        if (response.success) {
        $('#documentType').append(new Option(customDocumentType, customDocumentType));
        $('#documentType').val(customDocumentType);
        $('#customDocumentTypeInput').hide();
        } else {
        $('#custom_document_type_error').text(response.message);
        }
      },
      error: function (response) {
        $('#custom_document_type_error').text('An error occurred while saving the custom bank type.');
      }
      });
    } else {
      $('#custom_document_type_error').text('Custom Investment type cannot be empty.');
    }
    });

    $('#editsaveCustomDocumentType').on('click', function () {
    const customDocumentType = $('#edit_custom_document_type').val();
    if (customDocumentType) {
      $.ajax({
      type: 'POST',
      url: "{{ route('customer.documents.save_custom_type') }}",
      data: {
        _token: "{{ csrf_token() }}",
        custom_document_type: customDocumentType
      },
      success: function (response) {
        if (response.success) {
        $('#editDocumentType').append(new Option(customDocumentType, customDocumentType));
        $('#editDocumentType').val(customDocumentType);
        $('#editcustomDocumentTypeInput').hide();
        } else {
        $('#edit_custom_document_type_error').text(response.message);
        }
      },
      error: function (response) {
        $('#edit_custom_document_type_error').text('An error occurred while saving the custom Investment type.');
      }
      });
    } else {
      $('#edit_custom_document_type_error').text('Custom Investment type cannot be empty.');
    }
    });

    $('#ReviewModal').on('show.bs.modal', function (e) {
    var documentId = $(e.relatedTarget).data('id');
    $('#reviewsContainer').html(''); // Clear previous reviews

    $.ajax({
      url: "{{ route('customer.reviews.show', '') }}/" + documentId,
      type: "GET",
      success: function (response) {
      let reviews = response.reviews;
      if (reviews.length > 0) {
        reviews.forEach(function (review) {
        var signatureImageUrl = review.signature_image ? `/assets/upload/${review.signature_image}` : '';

        var reviewHtml = `
      <div class="form-group mb-4">
      <b>${review.user.name} - ${new Date(review.created_at).toLocaleString()}</b>
      <p>${review.description}</p>
      ${signatureImageUrl ? `<div class="mb-2"><img src="${signatureImageUrl}" alt="Signature" style="max-width: 100%; height: auto;" /></div>` : ''}
      ${review.user_id === {{ Auth::id() }} ?
          ` < form action = "{{ route('reviews.destroy', '') }}/${review.id}"
      method = "POST"
      style = "display:inline;" >
      @csrf
      @method('DELETE') <
      button type = "submit"
      class = "btn btn-danger btn-sm" > Delete Review < /button> <
      /form>` : ''} <
      /div>`;
        $('#reviewsContainer').append(reviewHtml);
        });
      } else {
        $('#reviewsContainer').html('<p>No reviews available for this document.</p>');
      }
      },
      error: function () {
      $('#reviewsContainer').html('<p>An error occurred while fetching reviews.</p>');
      }
    });

    });

    // Handle Add Review button click
    $('#AddReviewModal').on('show.bs.modal', function (e) {
    var documentId = $(e.relatedTarget).data('id');
    $('#reviewDocumentId').val(documentId);
    });
  </script>
@endsection