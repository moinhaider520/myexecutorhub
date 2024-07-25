@extends('layouts.master')

@section('content')
<div class="page-body">
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
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
                    <table class="display dataTable no-footer" id="basic-1" role="grid">
                      <thead>
                        <tr role="row">
                          <th>Sr</th>
                          <th>Insurance Type</th>
                          <th>Name of Provider</th>
                          <th>Policy/Reference Number</th>
                          <th>Sum Insured</th>
                          <th>Contact Details of Provider</th>
                          <th>Named Beneficiaries?</th>
                          <th>Policy End/Renewal Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($insurancePolicies as $insurancePolicy)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $insurancePolicy->insurance_type }}</td>
                          <td>{{ $insurancePolicy->provider_name }}</td>
                          <td>{{ $insurancePolicy->policy_number }}</td>
                          <td>{{ $insurancePolicy->sum_insured }}</td>
                          <td>{{ $insurancePolicy->contact_details }}</td>
                          <td>{{ $insurancePolicy->beneficiaries }}</td>
                          <td>{{ $insurancePolicy->policy_end_date }}</td>
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
</div>
@endsection
