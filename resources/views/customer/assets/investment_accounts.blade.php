@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
        <div class="row">
          <div class="col-md-12 d-flex justify-content-end p-2">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addInvestmentAccountModal">
              Add Investment Account
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Investment Accounts</h4>
                <span>List of Investment Accounts.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Investment Type</th>
                          <th>Company Name</th>
                          <th>Account/Reference Number</th>
                          <th>Balance</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($investmentAccounts as $investmentAccount)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $investmentAccount->investment_type }}</td>
                          <td>{{ $investmentAccount->company_name }}</td>
                          <td>{{ $investmentAccount->account_number }}</td>
                          <td>{{ $investmentAccount->balance }}</td>
                          <td>
                            <button type="button" class="btn btn-warning btn-sm edit-button" data-toggle="modal" data-target="#editInvestmentAccountModal" data-id="{{ $investmentAccount->id }}" data-investment_type="{{ $investmentAccount->investment_type }}" data-company_name="{{ $investmentAccount->company_name }}" data-account_number="{{ $investmentAccount->account_number }}" data-balance="{{ $investmentAccount->balance }}">Edit</button>
                            <form action="{{ route('customer.investment_accounts.destroy', $investmentAccount->id) }}" method="POST" style="display:inline;">
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

<!-- ADD INVESTMENT ACCOUNT -->
<div class="modal fade" id="addInvestmentAccountModal" tabindex="-1" role="dialog" aria-labelledby="addInvestmentAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addInvestmentAccountModalLabel">Add Investment Account</h5>
      </div>
      <div class="modal-body">
        <form id="addInvestmentAccountForm">
          @csrf
          <div class="form-group mb-2">
            <label for="investmentType">Investment Type</label>
            <select class="form-control" name="investment_type" id="investmentType" required>
            <option value="" selected disabled>--Select Investment Type--</option>
              @foreach($investmentTypes as $type)
                <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="investment_type_error"></span>
          </div>
          <div class="form-group mb-2" id="custominvestmentTypeInput" style="display: none;">
            <label for="custom_investment_type">Custom Investment Type</label>
            <input type="text" class="form-control" name="custom_investment_type" id="custom_investment_type"
              placeholder="Enter Custom Investment Type">
            <button type="button" class="btn btn-primary mt-2" id="saveCustomInvestmentType">Save Custom Type</button>
            <span class="text-danger" id="custom_investment_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="companyName">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="companyName" placeholder="Enter Company name" required>
            <span class="text-danger" id="company_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="accountReferenceNumber">Account/Reference Number</label>
            <input type="text" class="form-control" name="account_number" id="accountReferenceNumber" placeholder="Enter Account/Reference Number" required>
            <span class="text-danger" id="account_number_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="balance">Balance (GBP)</label>
            <input type="number" class="form-control" name="balance" id="balance" placeholder="Enter Balance" required>
            <span class="text-danger" id="balance_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="saveInvestmentAccount">Save changes</button>
      </div>
    </div>
  </div>
</div>

<!-- EDIT INVESTMENT ACCOUNT -->
<div class="modal fade" id="editInvestmentAccountModal" tabindex="-1" role="dialog" aria-labelledby="editInvestmentAccountModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editInvestmentAccountModalLabel">Edit Investment Account</h5>
      </div>
      <div class="modal-body">
        <form id="editInvestmentAccountForm">
          @csrf
          @method('POST')
          <input type="hidden" name="id" id="editInvestmentAccountId">
          <div class="form-group mb-2">
            <label for="editInvestmentType">Investment Type</label>
            <select class="form-control" name="investment_type" id="editInvestmentType" required>
              <option value="" selected disabled>--Select Investment Type--</option>
              @foreach($investmentTypes as $type)
              <option value="{{ $type->name }}">{{ $type->name }}</option>
              @endforeach
              <option value="Others">Others</option>
            </select>
            <span class="text-danger" id="edit_investment_type_error"></span>
          </div>
          <div class="form-group mb-2" id="editCustomInvestmentTypeInput" style="display: none;">
            <label for="edit_custom_investment_type">Custom Investment Type</label>
            <input type="text" class="form-control" name="custom_investment_type" id="edit_custom_investment_type" placeholder="Enter Custom Investment Type">
            <button type="button" class="btn btn-primary mt-2" id="editSaveCustomInvestmentType">Save Custom Type</button>
            <span class="text-danger" id="edit_custom_investment_type_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editCompanyName">Company Name</label>
            <input type="text" class="form-control" name="company_name" id="editCompanyName" placeholder="Enter Company name" required>
            <span class="text-danger" id="edit_company_name_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editAccountReferenceNumber">Account/Reference Number</label>
            <input type="text" class="form-control" name="account_number" id="editAccountReferenceNumber" placeholder="Enter Account/Reference Number" required>
            <span class="text-danger" id="edit_account_number_error"></span>
          </div>
          <div class="form-group mb-2">
            <label for="editBalance">Balance (GBP)</label>
            <input type="number" class="form-control" name="balance" id="editBalance" placeholder="Enter Balance" required>
            <span class="text-danger" id="edit_balance_error"></span>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="updateInvestmentAccount">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
  $(document).ready(function() {
    $('#saveInvestmentAccount').on('click', function() {
      $.ajax({
        type: 'POST',
        url: "{{ route('customer.investment_accounts.store') }}",
        data: $('#addInvestmentAccountForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.investment_type) $('#investment_type_error').text(errors.investment_type[0]);
          if (errors.company_name) $('#company_name_error').text(errors.company_name[0]);
          if (errors.account_number) $('#account_number_error').text(errors.account_number[0]);
          if (errors.balance) $('#balance_error').text(errors.balance[0]);
        }
      });
    });

    $('.edit-button').on('click', function() {
      var id = $(this).data('id');
      var investment_type = $(this).data('investment_type');
      var company_name = $(this).data('company_name');
      var account_number = $(this).data('account_number');
      var balance = $(this).data('balance');

      $('#editInvestmentAccountId').val(id);
      $('#editInvestmentType').val(investment_type);
      $('#editCompanyName').val(company_name);
      $('#editAccountReferenceNumber').val(account_number);
      $('#editBalance').val(balance);
    });

    $('#updateInvestmentAccount').on('click', function() {
      var id = $('#editInvestmentAccountId').val();
      $.ajax({
        type: 'POST',
        url: '/customer/investment_accounts/update/' + id,
        data: $('#editInvestmentAccountForm').serialize(),
        success: function(response) {
          location.reload();
        },
        error: function(response) {
          var errors = response.responseJSON.errors;
          if (errors.investment_type) $('#edit_investment_type_error').text(errors.investment_type[0]);
          if (errors.company_name) $('#edit_company_name_error').text(errors.company_name[0]);
          if (errors.account_number) $('#edit_account_number_error').text(errors.account_number[0]);
          if (errors.balance) $('#edit_balance_error').text(errors.balance[0]);
        }
      });
    });

    $('#investmentType').change(function () {
      if ($(this).val() === 'Others') {
        $('#custominvestmentTypeInput').show();
      } else {
        $('#custominvestmentTypeInput').hide();
      }
    });

    $('#editInvestmentType').change(function () {
      if ($(this).val() === 'Others') {
        $('#editCustomInvestmentTypeInput').show();
      } else {
        $('#editCustomInvestmentTypeInput').hide();
      }
    });

    $('#saveCustomInvestmentType').on('click', function () {
      const customInvestmentType = $('#custom_investment_type').val();
      if (customInvestmentType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('customer.investment_accounts.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_investment_type: customInvestmentType
          },
          success: function (response) {
            if (response.success) {
              $('#investmentType').append(new Option(customInvestmentType, customInvestmentType));
              $('#investmentType').val(customBankType);
              $('#custominvestmentTypeInput').hide();
            } else {
              $('#custom_investment_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#custom_investment_type_error').text('An error occurred while saving the custom bank type.');
          }
        });
      } else {
        $('#custom_investment_type_error').text('Custom Investment type cannot be empty.');
      }
    });

    $('#editSaveCustomInvestmentType').on('click', function () {
      const customInvestmentType = $('#edit_custom_investment_type').val();
      if (customInvestmentType) {
        $.ajax({
          type: 'POST',
          url: "{{ route('customer.investment_accounts.save_custom_type') }}",
          data: {
            _token: "{{ csrf_token() }}",
            custom_investment_type: customInvestmentType
          },
          success: function (response) {
            if (response.success) {
              $('#editInvestmentType').append(new Option(customInvestmentType, customInvestmentType));
              $('#editInvestmentType').val(customInvestmentType);
              $('#editCustomInvestmentTypeInput').hide();
            } else {
              $('#edit_custom_investment_type_error').text(response.message);
            }
          },
          error: function (response) {
            $('#edit_custom_investment_type_error').text('An error occurred while saving the custom Investment type.');
          }
        });
      } else {
        $('#edit_custom_investment_type_error').text('Custom Investment type cannot be empty.');
      }
    });

  });
</script>
@endsection