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
                <h4>Bank Accounts</h4>
                <span>List of Bank Accounts.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Account Type</th>
                          <th>Bank Name</th>
                          <th>Sort Code</th>
                          <th>Account Name</th>
                          <th>Account Number</th>
                          <th>Balance</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($bankAccounts as $bankAccount)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $bankAccount->account_type }}</td>
                          <td>{{ $bankAccount->bank_name }}</td>
                          <td>{{ $bankAccount->sort_code }}</td>
                          <td>{{ $bankAccount->account_name }}</td>
                          <td>{{ $bankAccount->account_number }}</td>
                          <td>{{ $bankAccount->balance }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editBankAccountModal" data-id="{{ $bankAccount->id }}" data-account_type="{{ $bankAccount->account_type }}" data-bank_name="{{ $bankAccount->bank_name }}" data-sort_code="{{ $bankAccount->sort_code }}" data-account_name="{{ $bankAccount->account_name }}" data-account_number="{{ $bankAccount->account_number }}" data-balance="{{ $bankAccount->balance }}">Edit</button>
                            <form action="{{ route('customer.bank_accounts.destroy', $bankAccount->id) }}" method="POST" style="display:inline;">
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
<div class="modal fade" id="addBankAccountModal" tabindex="-1" role="dialog" aria-labelledby="addBankAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Bank Account</h5>
      </div>
      <div class="modal-body">
        <form id="addBankAccountForm">
          @csrf
          <div class="form-group mb-3">
            <label for="accountType">Account Type</label>
            <select class="form-control" name="account_type" id="accountType" required>
              <option value="" selected disabled>--Select Account Type--</option>
              <option value="Current Account">Current Account</option>
              <option value="Savings Account">Savings Account</option>
              <option value="Fixed-Term Deposits">Fixed-Term Deposits</option>
            </select>
            <span class="text-danger" id="account_type_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="bankName">Bank Name</label>
            <input type="text" class="form-control" name="bank_name" id="bankName" placeholder="Enter Bank name" required>
            <span class="text-danger" id="bank_name_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="sortCode">Sort Code</label>
            <input type="text" class="form-control" name="sort_code" id="sortCode" placeholder="Enter Sort Code" required>
            <span class="text-danger" id="sort_code_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="accountNumber">Account Number</label>
            <input type="text" class="form-control" name="account_number" id="accountNumber" placeholder="Enter account number" required>
            <span class="text-danger" id="account_number_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="accountName">Name(s) on the account</label>
            <input type="text" class="form-control" name="account_name" id="accountName" placeholder="Name(s) on the account" required>
            <span class="text-danger" id="account_name_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="balance">Balance (GBP)</label>
            <input type="number" class="form-control" name="balance" id="balance" placeholder="Enter balance" required>
            <span class="text-danger" id="balance_error"></span>
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
<div class="modal fade" id="editBankAccountModal" tabindex="-1" role="dialog" aria-labelledby="editBankAccountModalLabel" aria-hidden="true">
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
          <div class="form-group mb-3">
            <label for="editAccountType">Account Type</label>
            <select class="form-control" name="account_type" id="editAccountType" required>
              <option value="" selected disabled>--Select Account Type--</option>
              <option value="Current Account">Current Account</option>
              <option value="Savings Account">Savings Account</option>
              <option value="Fixed-Term Deposits">Fixed-Term Deposits</option>
            </select>
            <span class="text-danger" id="edit_account_type_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="editBankName">Bank Name</label>
            <input type="text" class="form-control" name="bank_name" id="editBankName" placeholder="Enter Bank name" required>
            <span class="text-danger" id="edit_bank_name_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="editSortCode">Sort Code</label>
            <input type="text" class="form-control" name="sort_code" id="editSortCode" placeholder="Enter Sort Code" required>
            <span class="text-danger" id="edit_sort_code_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="editAccountNumber">Account Number</label>
            <input type="text" class="form-control" name="account_number" id="editAccountNumber" placeholder="Enter account number" required>
            <span class="text-danger" id="edit_account_number_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="editAccountName">Name(s) on the account</label>
            <input type="text" class="form-control" name="account_name" id="editAccountName" placeholder="Name(s) on the account" required>
            <span class="text-danger" id="edit_account_name_error"></span>
          </div>
          <div class="form-group mb-3">
            <label for="editBalance">Balance (GBP)</label>
            <input type="number" class="form-control" name="balance" id="editBalance" placeholder="Enter balance" required>
            <span class="text-danger" id="edit_balance_error"></span>
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
  $(document).ready(function() {
    $('#saveBankAccount').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.bank_accounts.store') }}",
        data: $('#addBankAccountForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.account_type) $('#account_type_error').text(errors.account_type[0]);
          if (errors.bank_name) $('#bank_name_error').text(errors.bank_name[0]);
          if (errors.sort_code) $('#sort_code_error').text(errors.sort_code[0]);
          if (errors.account_number) $('#account_number_error').text(errors.account_number[0]);
          if (errors.account_name) $('#account_name_error').text(errors.account_name[0]);
          if (errors.balance) $('#balance_error').text(errors.balance[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var account_type = $(this).data('account_type');
      var bank_name = $(this).data('bank_name');
      var sort_code = $(this).data('sort_code');
      var account_name = $(this).data('account_name');
      var account_number = $(this).data('account_number');
      var balance = $(this).data('balance');

      $('#editBankAccountId').val(id);
      $('#editAccountType').val(account_type);
      $('#editBankName').val(bank_name);
      $('#editSortCode').val(sort_code);
      $('#editAccountName').val(account_name);
      $('#editAccountNumber').val(account_number);
      $('#editBalance').val(balance);
    });

    $('#updateBankAccount').on('click', function() {
      var id = $('#editBankAccountId').val();
      $.ajax({
        type: 'POST',
        url: '/customer/bank_accounts/update/' + id,
        data: $('#editBankAccountForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.account_type) $('#edit_account_type_error').text(errors.account_type[0]);
          if (errors.bank_name) $('#edit_bank_name_error').text(errors.bank_name[0]);
          if (errors.sort_code) $('#edit_sort_code_error').text(errors.sort_code[0]);
          if (errors.account_number) $('#edit_account_number_error').text(errors.account_number[0]);
          if (errors.account_name) $('#edit_account_name_error').text(errors.account_name[0]);
          if (errors.balance) $('#edit_balance_error').text(errors.balance[0]);
        }
      });
    });
  });
</script>
@endsection