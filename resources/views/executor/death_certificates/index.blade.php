@extends('layouts.master')

@section('content')
  <div class="page-body">
    <div class="container-fluid default-dashboard">
      <div class="row widget-grid">
        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-end p-2">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDeathCertificateModal">
                Add Death Certificate
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Death Certificate</h4>
                  <span>List of Death Certificate uploads.</span>
                </div>
                <div class="card-body">
                  <div class="table-responsive theme-scrollbar">
                    <div class="dataTables_wrapper no-footer">
                      <table class="display dataTable no-footer" id="basic-1" role="grid">
                        <thead>
                          <tr role="row">
                            <th>Sr</th>
                            <th>Description</th>
                            <th>Download Link</th>
                            <th>Processing</th>
                            <th>Verification</th>
                            <th>Confidence Score</th>
                            <th>Reasons</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($verifications as $verification)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $verification->document->description ?? 'Death certificate upload' }}</td>
                              <td>
                                @php
                                  $files = json_decode($verification->document->file_path ?? '[]', true);
                                  if (!is_array($files)) {
                                    $files = !empty($verification->document->file_path) ? [$verification->document->file_path] : [];
                                  }
                                @endphp
                                @foreach($files as $file)
                                  @php
                                    $fileUrl = is_array($file)
                                      ? ($file['url'] ?? null)
                                      : (filter_var($file, FILTER_VALIDATE_URL) ? $file : asset('assets/upload/' . $file));
                                  @endphp
                                  @if($fileUrl)
                                    <a href="{{ $fileUrl }}" target="_blank">View File</a><br>
                                  @endif
                                @endforeach
                              </td>
                              <td>{{ str_replace('_', ' ', $verification->processing_status) }}</td>
                              <td>{{ str_replace('_', ' ', $verification->verification_status) }}</td>
                              <td>{{ $verification->confidence_score ?? 'N/A' }}</td>
                              <td>
                                @if(($verification->mismatch_reasons ?? []) !== [])
                                  {{ implode(' | ', $verification->mismatch_reasons) }}
                                @else
                                  No issues recorded
                                @endif
                              </td>
                              <td>
                                <form action="{{ route('executor.death_certificates.destroy', $verification) }}" method="POST" style="display:inline;">
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

  <div class="modal fade" id="addDeathCertificateModal" tabindex="-1" role="dialog" aria-labelledby="addDeathCertificateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Death Certificate</h5>
        </div>
        <div class="modal-body">
          <form id="addDeathCertificateForm" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-4">
              <label for="file">Upload Certificate</label>
              <input type="file" class="form-control" name="files[]" id="file" multiple required>
              <span class="text-danger" id="file_error"></span>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#addDeathCertificateForm').on('submit', function (e) {
        e.preventDefault();

        $('#file_error').text('');

        var formData = new FormData(this);

        $.ajax({
          url: "{{ route('executor.death_certificates.store') }}",
          type: "POST",
          data: formData,
          contentType: false,
          processData: false,
          beforeSend: function () {
            Swal.fire({
              title: 'Please wait...',
              text: 'Uploading your death certificate',
              allowOutsideClick: false,
              allowEscapeKey: false,
              didOpen: () => Swal.showLoading()
            });
          },
          success: function () {
            Swal.close();
            location.reload();
          },
          error: function (xhr) {
            Swal.close();
            if (xhr.status === 422) {
              var errors = xhr.responseJSON.errors;
              if (errors.files || errors['files.0']) {
                $('#file_error').text((errors.files && errors.files[0]) || errors['files.0'][0]);
              }
              return;
            }

            Swal.fire('Error', 'An error occurred. Please try again.', 'error');
          }
        });
      });
    });
  </script>
@endsection
