@extends('layouts.master')

@section('content')
  <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
      <div class="row widget-grid">
        <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
          <div class="row">
            <div class="col-md-12 d-flex justify-content-end p-2">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBankAccountModal">
                Add Bank Account
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Bank Account</h4>
                  <span>Details of Bank Accounts.</span>
                </div>
                <div class="card-body">
                  <div class="table-responsive theme-scrollbar">
                    <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                      <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                        <thead>
                          <tr role="row">
                            <th>Sr</th>
                            <th>Bank Name</th>
                            <th>IBAN Number</th>
                            <th>Sort Code</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($bankdetails as $bankAccount)
                            <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $bankAccount->bank_name }}</td>
                              <td>{{ $bankAccount->iban }}</td>
                              <td>{{ $bankAccount->sort_code }}</td>
                              <td>
                                <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal"
                                  data-target="#editBankAccountModal" data-id="{{ $bankAccount->id }}"
                                  data-bank_name="{{ $bankAccount->bank_name }}"
                                  data-sort_code="{{ $bankAccount->sort_code }}"
                                  data-iban="{{ $bankAccount->iban }}">Edit</button>
                                <form action="{{ route('partner.bank_account.destroy', $bankAccount->id) }}" method="POST"
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
  <div class="modal fade" id="addBankAccountModal" tabindex="-1" role="dialog" aria-labelledby="addBankAccountModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addBankAccountModalLabel">Add Bank Account</h5>
        </div>
        <div class="modal-body">
          <form id="addBankAccountForm">
            @csrf
            <div class="form-group mb-2">
              <label for="bankName">Bank Name</label>
              <input type="text" class="form-control" name="bank_name" id="bankName" placeholder="Enter Bank name"
                required>
              <span class="text-danger" id="bank_name_error"></span>
            </div>
            <div class="form-group mb-2">
              <label for="Iban">IBAN Number</label>
              <input type="text" class="form-control" name="iban" id="Iban" placeholder="Enter IBAN Number" required>
              <span class="text-danger" id="iban_error"></span>
            </div>
            <div class="form-group mb-2">
              <label for="sortCode">Sort Code</label>
              <input type="text" class="form-control" name="sort_code" id="sortCode" placeholder="Enter Sort Code"
                required>
              <span class="text-danger" id="sort_code_error"></span>
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
  <div class="modal fade" id="editBankAccountModal" tabindex="-1" role="dialog"
    aria-labelledby="editBankAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editBankAccountModalLabel">Edit Bank Account</h5>
        </div>
        <div class="modal-body">
          <form id="editBankAccountForm">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="editBankAccountId">
            <div class="form-group mb-2">
              <label for="editBankName">Bank Name</label>
              <input type="text" class="form-control" name="bank_name" id="editBankName" placeholder="Enter Bank name"
                required>
              <span class="text-danger" id="edit_bank_name_error"></span>
            </div>
            <div class="form-group mb-2">
              <label for="editIban">Iban Number</label>
              <input type="text" class="form-control" name="iban" id="editIban" placeholder="Enter IBAN Number" required>
              <span class="text-danger" id="edit_iban_error"></span>
            </div>
            <div class="form-group mb-2">
              <label for="editSortCode">Sort Code</label>
              <input type="text" class="form-control" name="sort_code" id="editSortCode" placeholder="Enter Sort Code"
                required>
              <span class="text-danger" id="edit_sort_code_error"></span>
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
          url: "{{ route('partner.bank_account.store') }}",
          data: $('#addBankAccountForm').serialize(),
          success: function (response) {
            location.reload();
          },
          error: function (response) {
            var errors = response.responseJSON.errors;
            if (errors.bank_name) $('#bank_name_error').text(errors.bank_name[0]);
            if (errors.sort_code) $('#sort_code_error').text(errors.sort_code[0]);
            if (errors.iban) $('#iban_error').text(errors.iban[0]);
          }
        });
      });

      $('.edit-button').on('click', function () {
        var id = $(this).data('id');
        var bank_name = $(this).data('bank_name');
        var sort_code = $(this).data('sort_code');
        var iban = $(this).data('iban');

        $('#editBankAccountId').val(id);
        $('#editBankName').val(bank_name);
        $('#editSortCode').val(sort_code);
        $('#editIban').val(iban);
      });

      $('#updateBankAccount').on('click', function () {
        var id = $('#editBankAccountId').val();
        $.ajax({
          type: 'POST',
          url: '/partner/bank_account/update/' + id,
          data: $('#editBankAccountForm').serialize(),
          success: function (response) {
            location.reload();
          },
          error: function (response) {
            var errors = response.responseJSON.errors;
            if (errors.bank_name) $('#edit_bank_name_error').text(errors.bank_name[0]);
            if (errors.sort_code) $('#edit_sort_code_error').text(errors.sort_code[0]);
            if (errors.iban) $('#edit_iban_error').text(errors.iban[0]);
          }
        });
      });

    });
  </script>
@endsection