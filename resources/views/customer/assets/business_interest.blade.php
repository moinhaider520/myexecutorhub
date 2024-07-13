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
              Add Business Interest
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Business Interests</h4>
                <span>List of Business Interests.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Business Type</th>
                          <th>Business Name</th>
                          <th>Shares %</th>
                          <th>Business Value (GBP)</th>
                          <th>Shares Value (GBP)</th>
                          <th>Who to Contact?</th>
                          <th>Plan For Shares</th>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Business Interest</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="businessType">Business Type</label>
            <select class="form-control">
              <option value="Ownership in privately held businesses">Ownership in privately held businesses</option>
              <option value="Partnership interests">Partnership interests</option>
              <option value="Shares in family businesses">Shares in family businesses</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="businessName">Business Name</label>
            <input type="text" class="form-control" id="businessName" placeholder="Enter Business name">
          </div>
          <div class="form-group mb-4">
            <label for="shares">Amount of Shares (%)</label>
            <input type="text" class="form-control" id="shares" placeholder="Enter Amount of Shares in %">
          </div>
          <div class="form-group mb-4">
            <label for="businessValue">Business Value in GBP</label>
            <input type="text" class="form-control" id="businessValue" placeholder="Enter Business Value">
          </div>
          <div class="form-group mb-4">
            <label for="shareValue">Value of Shares in GBP</label>
            <input type="text" class="form-control" id="shareValue" placeholder="Enter Value of Shares">
          </div>
          <div class="form-group mb-4">
            <label for="contact">Who to Contact?</label>
            <input type="text" class="form-control" id="contact" placeholder="Who to Contact?">
          </div>
          <div class="form-group mb-4">
            <label for="plan_for_shares">Plan For Shares</label>
            <input type="text" class="form-control" id="plan_for_shares" placeholder="Plan For Shares?">
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