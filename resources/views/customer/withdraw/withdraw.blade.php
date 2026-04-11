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
                <h4>Withdraw Amount</h4>
                <span>Withdraw from your available referral wallet once your available balance reaches £100.</span>
              </div>
              <div class="card-body">
                <div class="table-responsive theme-scrollbar">
                  <div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
                    <div class="alert alert-light border">
                      <strong>Available Wallet:</strong> £{{ number_format($wallet->available_balance, 2) }}<br>
                      <strong>Pending Wallet:</strong> £{{ number_format($wallet->pending_balance, 2) }}<br>
                      <small>Pending wallet funds stay locked until the 14-day confirmation period passes.</small>
                    </div>
                    <form action="{{ route('customer.withdraw.process') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="amount">Enter Amount</label>
                        <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount') }}" required min="100" step="0.01">
                        @error('amount')
                          <div class="text-danger">{{ $message }}</div>
                        @enderror
                      </div>
                      <button type="submit" class="btn btn-primary mt-4" style="float:right;">Submit Withdrawal</button>
                    </form>
                  
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
