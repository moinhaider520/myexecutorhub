@extends('layouts.master')

@section('content')
<div class="page-body">
  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
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
                    <table class="display dataTable no-footer" id="basic-1" role="grid">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Type of Debt/Liability</th>
                          <th>Reference Number</th>
                          <th>Loan Provider</th>
                          <th>Contact Details</th>
                          <th>Amount Outstanding</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($debtsLiabilities as $debtLiability)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $debtLiability->debt_type }}</td>
                          <td>{{ $debtLiability->reference_number }}</td>
                          <td>{{ $debtLiability->loan_provider }}</td>
                          <td>{{ $debtLiability->contact_details }}</td>
                          <td>{{ $debtLiability->amount_outstanding }}</td>
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
@endsection
