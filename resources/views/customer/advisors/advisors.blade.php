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
              Add Adviser
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Advisers</h4>
                <span>List of Advisers.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Adviser Type</th>
                          <th>Name</th>
                          <th>Practice Name</th>
                          <th>Practice Address</th>
                          <th>Email Address</th>
                          <th>Phone Number</th>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Adviser</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="accountType">Adviser Type</label>
            <select class="form-control">
              <option value="Solicitors">Solicitors</option>
              <option value="Accountants">Accountants</option>
              <option value="Stock Brokers">Stock Brokers</option>
              <option value="Will Writers">Will Writers</option>
              <option value="Financial Advisers">Financial Advisers</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="accountName">Name</label>
            <input type="text" class="form-control" id="bankName" placeholder="Enter Name">
          </div>
          <div class="form-group mb-4">
            <label for="accountName">Practice Name</label>
            <input type="text" class="form-control" id="sortCode" placeholder="Enter Practice Name">
          </div>
          <div class="form-group mb-4">
            <label for="accountNumber">Practice Address</label>
            <input type="text" class="form-control" id="accountNumber" placeholder="Enter Practice Address">
          </div>
          <div class="form-group mb-4">
            <label for="accountNumber">Email Address</label>
            <input type="text" class="form-control" id="accountName" placeholder="Email Address">
          </div>
          <div class="form-group mb-4">
            <label for="balance">Phone Number</label>
            <input type="text" class="form-control" id="balance" placeholder="Enter Phone Number">
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