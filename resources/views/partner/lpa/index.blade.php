@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>LPA Videos</h4>
                <span>List of Recorded LPA Videos.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Date of Recording</th>
                          <th>LPA Video</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach($lpas as $lpa)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $lpa->created_at }}</td>
                          <td><a target="_blank" href="{{ $lpa->url }}">View Video</a></td>
                          <td>
                            <form action="{{ route('partner.lpa.destroy', $lpa->id) }}" method="POST" style="display:inline;">
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

<!-- ADD ADVISOR MODAL -->
<div class="modal fade" id="addAdvisorModal" tabindex="-1" role="dialog" aria-labelledby="addAdvisorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAdvisorModalLabel">Add Adviser</h5>
      </div>
      <div class="modal-body">
        <form id="addAdvisorForm">
          @csrf
          <div class="form-group mb-2">
            <label for="adviserType">Adviser Type</label>
            <select class="form-control" name="adviser_type" id="adviserType" required>
              <option value="" selected disabled>--Select Adviser Type--</option>
              <option value="Solicitors">Solicitors</option>
              <option value="Accountants">Accountants</option>
              <option value="Stock Brokers">Stock Brokers</option>
              <option value="Will Writers">Will Writers</option>
              <option value="Financial Advisers">Financial Advisers</option>
            </select>
            <span class="text-danger" id="adviser_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" required>
            <span class="text-danger" id="name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="practice_name">Practice Name</label>
            <input type="text" class="form-control" name="practice_name" id="practice_name" placeholder="Enter Practice Name" required>
            <span class="text-danger" id="practice_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="practice_address">Practice Address</label>
            <input type="text" class="form-control" name="practice_address" id="practice_address" placeholder="Enter Practice Address" required>
            <span class="text-danger" id="practice_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="email_address">Email Address</label>
            <input type="email" class="form-control" name="email_address" id="email_address" placeholder="Email Address" required>
            <span class="text-danger" id="email_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="phone_number">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter Phone Number" required>
            <span class="text-danger" id="phone_number_error"></span>
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

<!-- EDIT ADVISOR MODAL -->
<div class="modal fade" id="editAdvisorModal" tabindex="-1" role="dialog" aria-labelledby="editAdvisorModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdvisorModalLabel">Edit Adviser</h5>
      </div>
      <div class="modal-body">
        <form id="editAdvisorForm">
          @csrf
          <input type="hidden" name="id" id="editAdvisorId">

          <div class="form-group mb-2">
            <label for="editAdviserType">Adviser Type</label>
            <select class="form-control" name="adviser_type" id="editAdviserType" required>
              <option value="" selected disabled>--Select Adviser Type--</option>
              <option value="Solicitors">Solicitors</option>
              <option value="Accountants">Accountants</option>
              <option value="Stock Brokers">Stock Brokers</option>
              <option value="Will Writers">Will Writers</option>
              <option value="Financial Advisers">Financial Advisers</option>
            </select>
            <span class="text-danger" id="edit_adviser_type_error"></span>
          </div>

          <div class="form-group mb-2">
            <label for="editName">Name</label>
            <input type="text" class="form-control" name="name" id="editName" placeholder="Enter Name" required>
            <span class="text-danger" id="edit_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPracticeName">Practice Name</label>
            <input type="text" class="form-control" name="practice_name" id="editPracticeName" placeholder="Enter Practice Name" required>
            <span class="text-danger" id="edit_practice_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPracticeAddress">Practice Address</label>
            <input type="text" class="form-control" name="practice_address" id="editPracticeAddress" placeholder="Enter Practice Address" required>
            <span class="text-danger" id="edit_practice_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editEmailAddress">Email Address</label>
            <input type="email" class="form-control" name="email_address" id="editEmailAddress" placeholder="Email Address" required>
            <span class="text-danger" id="edit_email_address_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editPhoneNumber">Phone Number</label>
            <input type="text" class="form-control" name="phone_number" id="editPhoneNumber" placeholder="Enter Phone Number" required>
            <span class="text-danger" id="edit_phone_number_error"></span>
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
@endsection