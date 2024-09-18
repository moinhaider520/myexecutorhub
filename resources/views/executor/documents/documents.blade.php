@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
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
                <td><button type="button" class="btn btn-secondary btn-sm edit-button" id="viewReviewsButton"
                data-toggle="modal" data-target="#ReviewModal" data-id="{{ $document->id }}">View Reviews</button></td>
                <td>
                <button type="button" class="btn btn-primary btn-sm edit-button" id="launchModalButton"
                  data-toggle="modal" data-target="#AddReviewModal" data-id="{{ $document->id }}">Add
                  Reviews</button>
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

<!-- ADD Reviews -->
<div class="modal fade" id="AddReviewModal" tabindex="-1" role="dialog" aria-labelledby="AddReviewModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddReviewModalLabel">Add Review</h5>
      </div>
      <div class="modal-body">
        <form id="addReviewForm" action="{{ route('executor.reviews.store') }}" method="POST">
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
    document.getElementById('viewReviewsButton').onclick = function () {
      var documentId = this.getAttribute('data-id');
      $('#reviewsContainer').html(''); // Clear previous reviews
      console.log(documentId);
      $.ajax({
      url: "{{ route('executor.reviews.show', '') }}/" + documentId,
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
                `<form action="{{ route('reviews.destroy', '') }}/${review.id}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete Review</button>
              </form>` : ''}
          </div>`;
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
    };
  </script>

<script>
  document.getElementById('launchModalButton').onclick = function () {
    var documentId = this.getAttribute('data-id');
    document.getElementById('reviewDocumentId').value = documentId;
  };
</script>
@endsection