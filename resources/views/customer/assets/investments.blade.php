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
              Add Investment
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4>Investments</h4>
                <span>List of Investments.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Product Provider</th>
                          <th>Investment Type</th>
                          <th>Account Number</th>
                          <th>Account Reference</th>
                          <th>Valuation</th>
                          <th>Valuation Date</th>
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
        <h5 class="modal-title" id="addBankAccountModalLabel">Add Investment</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="productProvider">Product Provider</label>
            <input type="text" class="form-control" id="productProvider" placeholder="Enter Product Provider">
          </div>
          <div class="form-group">
            <label for="investmentType">Investment Type</label>
            <select class="form-control" id="investmentType">
              <option value="OEIC">OEIC</option>
              <option value="Unit Thrust">Unit Thrust</option>
              <option value="ISA">ISA</option>
              <option value="Bond">Bond</option>
              <option value="VCT's">VCT's</option>
              <option value="Others">Others</option>
            </select>
          </div>
          <div class="form-group">
            <label for="accountNumber">Account Number</label>
            <input type="text" class="form-control" id="accountNumber" placeholder="Enter account number">
          </div>
          <div class="form-group">
            <label for="accountNumber">Account Reference</label>
            <input type="text" class="form-control" id="accountReference" placeholder="Account Reference">
          </div>
          <div class="form-group">
            <label for="valuation">Valuation $</label>
            <input type="number" class="form-control" id="valuation" placeholder="Enter Valuation">
          </div>
          <div class="form-group">
            <label for="balance">Valuation Date</label>
            <input type="date" class="form-control" id="valuationdate">
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