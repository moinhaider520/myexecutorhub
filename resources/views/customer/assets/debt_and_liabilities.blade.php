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
              Add Debt & Liabilities
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Debt & Liabilities</h4>
                <span>List of Debt & Liabilities.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Type of Debt/Liability</th>
                          <th>Reference Number</th>
                          <th>Loan Provider</th>
                          <th>Contact Details</th>
                          <th>Amount Outstanding</th>
                          <th>Action</th>
                        </tr>
                      </thead>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Debt/Liability</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="businessType">Type of Debt/Liability</label>
            <select class="form-control">
              <option value="Mortgages">Mortgages</option>
              <option value="Personal loans">Personal loans</option>
              <option value="Credit card debt">Credit card debt</option>
              <option value="Outstanding bills and utilities">Outstanding bills and utilities</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="businessName">Reference Number</label>
            <input type="text" class="form-control" id="businessName" placeholder="Enter Reference Number">
          </div>
          <div class="form-group mb-4">
            <label for="shares">Loan Provider</label>
            <input type="text" class="form-control" id="shares" placeholder="Enter Loan Provider">
          </div>
          <div class="form-group mb-4">
            <label for="businessValue">Contact Details</label>
            <input type="text" class="form-control" id="businessValue" placeholder="Enter Contact Details">
          </div>
          <div class="form-group mb-4">
            <label for="shareValue">Amount Outstanding</label>
            <input type="text" class="form-control" id="shareValue" placeholder="Amount Outstanding">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection