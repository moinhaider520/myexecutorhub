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
              Add Digital Asset
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Digital Assets</h4>
                <span>List of Digital Assets.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Asset Type</th>
                          <th>Asset Name</th>
                          <th>Username</th>
                          <th>Password</th>
                          <th>Email Used to create Account</th>
                          <th>Value</th>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Digital Asset</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="businessType">Type of Asset</label>
            <select class="form-control">
              <option value="Online Banking Account">Online Banking Account</option>
              <option value="Investment Account">Investment Account</option>
              <option value="Digital Wallet">Digital Wallet</option>
              <option value="Social Media Account">Social Media Account</option>
              <option value="Digital Media">Digital Media</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="businessName">Asset Name</label>
            <input type="text" class="form-control" id="businessName" placeholder="Enter Asset Name">
          </div>
          <div class="form-group mb-4">
            <label for="shares">Username</label>
            <input type="text" class="form-control" id="shares" placeholder="Enter Username">
          </div>
          <div class="form-group mb-4">
            <label for="businessValue">Password</label>
            <input type="text" class="form-control" id="businessValue" placeholder="Enter Password">
          </div>
          <div class="form-group mb-4">
            <label for="shareValue">Email Used?</label>
            <input type="text" class="form-control" id="shareValue" placeholder="Email Used to Create Account?">
          </div>
          <div class="form-group mb-4">
            <label for="shareValue">Value in GBP</label>
            <input type="text" class="form-control" id="shareValue" placeholder="Value in GBP">
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