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
              Add Insurance Policy
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Insurance Policies</h4>
                <span>List of Insurance Policies.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Insurance Type</th>
                          <th>Name of Provider</th>
                          <th>Policy/Reference Number</th>
                          <th>Sum Insured</th>
                          <th>Contact Details of Provider</th>
                          <th>Named Beneificiaries?</th>
                          <th>Policy End/Renewal Date</th>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Insurance Policy</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group mb-4">
            <label for="businessType">Insurance Type</label>
            <select class="form-control">
              <option value="Life Insurance">Life Insurance</option>
              <option value="Health Insurance">Health Insurance</option>
              <option value="Home Insurance">Home Insurance</option>
              <option value="Car Insurance">Car Insurance</option>
            </select>
          </div>
          <div class="form-group mb-4">
            <label for="businessName">Name of Provider</label>
            <input type="text" class="form-control" id="businessName" placeholder="Enter Name of Provider">
          </div>
          <div class="form-group mb-4">
            <label for="shares">Policy/Reference Number</label>
            <input type="text" class="form-control" id="shares" placeholder="Enter Policy/Reference Number">
          </div>
          <div class="form-group mb-4">
            <label for="businessValue">SUM Insured</label>
            <input type="text" class="form-control" id="businessValue" placeholder="Enter SUM Insured">
          </div>
          <div class="form-group mb-4">
            <label for="shareValue">Contact Details of Provider</label>
            <input type="text" class="form-control" id="shareValue" placeholder="Contact Details of Provider">
          </div>
          <div class="form-group mb-4">
            <label for="contact">Named Beneficiaries</label>
            <input type="text" class="form-control" id="contact" placeholder="Named Beneficiaries">
          </div>
          <div class="form-group mb-4">
            <label for="plan_for_shares">Policy End/Renewal Date</label>
            <input type="date" class="form-control" id="plan_for_shares">
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