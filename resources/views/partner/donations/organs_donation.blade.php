@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addDonationModal">
              Add Organ's Donation
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Organ's Donation</h4>
                <span>List of Organ's Donation.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Donate Organs?</th>
                          <th>Organs to Donate</th>
                          <th>Organs to Not Donate</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($organ_donations as $donation)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $donation->donation }}</td>
                <td>{{ $donation->organs_to_donate }}</td>
                <td>{{ $donation->organs_to_not_donate }}</td>
                <td>
                <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                  data-target="#editDonationModal" data-id="{{ $donation->id }}"
                  data-donation="{{ $donation->donation }}"
                  data-organs_to_donate="{{ $donation->organs_to_donate }}"
                  data-organs_to_not_donate="{{ $donation->organs_to_not_donate }}">Edit</button>
                <form action="{{ route('customer.organs_donation.destroy', $donation->id) }}" method="POST"
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

<!-- ADD BANK ACCOUNT -->
<div class="modal fade" id="addDonationModal" tabindex="-1" role="dialog" aria-labelledby="addDonationModalModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addDonationModalModalLabel">Add Organ Donation</h5>
      </div>
      <div class="modal-body">
        <form id="addDonationForm">
          @csrf
          <div class="form-group mb-2">
            <label for="accountType">Donation?</label>
            <select class="form-control" name="donation" id="donation" required>
              <option value="" selected disabled>--Select--</option>
              <option value="I am happy for my organs to be donated">I am happy for my organs to be donated</option>
              <option value="I am not happy for my organs to be donated">I am not happy for my organs to be donated</option>
            </select>
            <span class="text-danger" id="donation"></span>
          </div>
          <div class="form-group mb-2">
            <label for="bankName">Organs to Donate</label>
            <input type="text" class="form-control" name="organs_to_donate" id="organs_to_donate" placeholder="Enter Organs to Donate"
              required>
            <span class="text-danger" id="organs_to_donate_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="sortCode">Organs to Not Donate</label>
            <input type="text" class="form-control" name="organs_to_not_donate" id="organs_to_not_donate" placeholder="Enter Organs to Not Donate"
              required>
            <span class="text-danger" id="organs_to_not_donate_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveBankAccount">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT BANK ACCOUNT -->
<div class="modal fade" id="editDonationModal" tabindex="-1" role="dialog"
  aria-labelledby="editDonationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editDonationModalLabel">Edit Donation</h5>
      </div>
      <div class="modal-body">
        <form id="editDonationForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editDonationId">
          <div class="form-group mb-2">
            <label for="editDonation">Donation?</label>
            <select class="form-control" name="donation" id="editDonation" required>
              <option value="" selected disabled>--Select--</option>
              <option value="I am happy for my organs to be donated">I am happy for my organs to be donated</option>
              <option value="I am not happy for my organs to be donated">I am not happy for my organs to be donated</option>
            </select>
            <span class="text-danger" id="edit_donation_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="edit_organs_to_donate">Organs to Donate</label>
            <input type="text" class="form-control" name="organs_to_donate" id="edit_organs_to_donate" placeholder="Enter Organs to Donate"
              required>
            <span class="text-danger" id="edit_organs_to_donate_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="edit_organs_to_not_donate">Organs to Not Donate</label>
            <input type="text" class="form-control" name="edit_organs_to_not_donate" id="edit_organs_to_not_donate" placeholder="Enter Organs to Not Donate"
              required>
            <span class="text-danger" id="edit_organs_to_not_donate_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateBankAccount">Save changes</button>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
  $(document).ready(function () {
    $('#saveBankAccount').on('click', function () {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.organs_donation.store') }}",
        data: $('#addDonationForm').serialize(),
        success: function (response) {
          location.reload();
        },
        error: function (response) {
          var errors = response.responseJSON.errors;
          if (errors.donation) $('#donation_error').text(errors.donation[0]);
          if (errors.organs_to_donate) $('#organs_to_donate_error').text(errors.organs_to_donate[0]);
          if (errors.organs_to_not_donate) $('#organs_to_not_donate_error').text(errors.organs_to_not_donate[0]);
        }
      });
    });

    $('.edit-button').on('click', function () {
      var id = $(this).data('id');
      var donation = $(this).data('donation');
      var organs_to_donate = $(this).data('organs_to_donate');
      var organs_to_not_donate = $(this).data('organs_to_not_donate');

      $('#editDonationId').val(id);
      $('#edit_donation').val(donation);
      $('#edit_organs_to_donate').val(organs_to_donate);
      $('#edit_organs_to_not_donate').val(organs_to_not_donate);
    });

    $('#updateBankAccount').on('click', function () {
      var id = $('#editDonationId').val();
      $.ajax({
        type: 'POST',
        url: '/customer/organs_donation/update/' + id,
        data: $('#editDonationForm').serialize(),
        success: function (response) {
          location.reload();
        },
        error: function (response) {
          var errors = response.responseJSON.errors;
          if (errors.donation) $('#edit_donation_error').text(errors.donation[0]);
          if (errors.organs_to_donate) $('#edit_organs_to_donate_error').text(errors.organs_to_donate[0]);
          if (errors.organs_to_not_donate) $('#edit_organs_to_not_donate_error').text(errors.organs_to_not_donate[0]);
        }
      });
    });


  });
</script>
@endsection