@extends('layouts.master')

@section('content')
  <style>
    .ck-editor__editable_inline {
    min-height: 300px;
    }
  </style>
  <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
      <div class="row">
        <div class="col-md-12">
        <div class="card">
          <div class="card-header">
          <h4>Executor Hub Membership</h4>
          </div>
          <div class="card-body pricing-content">
          @if(Auth::user()->subscribed_package == "free_trial" || Auth::user()->stripe_subscription_id == null)
        <div class="row mb-3">
        <div class="col-md-12">
        <p>You are Currently on {{ Auth::user()->subscribed_package }} Plan and It will expire on
          {{ Auth::user()->trial_ends_at }}. Make sure to Upgrade your plan to continue using Executor Hub.
        </p>
        </div>
        </div>
        <div class="row g-sm-4 g-3">
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height:400px;">
          <h4>Basic</h4>
          <h5>£8</h5>
          <h6 class="mb-0">Per Month</h6>
          <ul>
          <li>Assign Executors</li>
          <li>Record Assets & Liabilities</li>
          </ul>
          </div>
          <form id='checkout-form' method='post' action="{{ route('stripe.resubscribe') }}">
          @csrf
          <input type="hidden" name="email" value={{ Auth::user()->email }}>
          <input type="hidden" name="plan" value="price_1R4UE4SBn09iuv4xvH0KeSEJ">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height:400px;">
          <h4>Standard</h4>
          <h5>£20</h5>
          <h6 class="mb-0">Per Month</h6>
          <ul>
          <li>Assign Executors</li>
          <li>Assign Advisers</li>
          <li>Document Uploads</li>
          <li>Record Assets & Liabilities</li>
          <li>Access to Secure Messaging System</li>
          </ul>
          </div>
          <form id='checkout-form' method='post' action="{{ route('stripe.resubscribe') }}">
          @csrf
          <input type="hidden" name="email" value={{ Auth::user()->email }}>
          <input type="hidden" name="plan" value="price_1R4UEjSBn09iuv4xIez1NWXm">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height: 400px;">
          <h4>Premium </h4>
          <h5>£40</h5>
          <h6 class="mb-0">Per Month</h6>
          <ul>
          <li>Assign Executors</li>
          <li>Assign Advisers</li>
          <li>Document Uploads</li>
          <li>Record Assets & Liabilities</li>
          <li>Access to Secure Messaging System</li>
          <li>Record Donations</li>
          <li>Record Life Notes</li>
          <li>Record Wishes</li>
          <li>Access to Executor Hub AI</li>
          </ul>
          </div>
          <form id='checkout-form' method='post' action="{{ route('stripe.resubscribe') }}">
          @csrf
          <input type="hidden" name="email" value={{ Auth::user()->email }}>
          <input type="hidden" name="plan" value="price_1R4UFCSBn09iuv4xWmFqEjqr">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        </div>

      @else
      <div class="row mb-3">
      <div class="col-md-12">
      <p>You are Currently on {{ Auth::user()->subscribed_package }} and it will automatically renew on
        {{ Auth::user()->trial_ends_at }}. To Cancel Your Subscription please use the form below.
      </p>
      <p>Please Note that when you cancel your subscription you can still use Executor Hub until the
        expiry date of the purchased plan.</p>
      </div>
      </div>
      <div class="row g-sm-4 g-3">
      <div class="col-lg-12 col-sm-6 box-col-3">
      <form action="{{ route('subscription.cancel') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Cancel Subscription</button>
      </form>

      </div>
      </div>
    @endif
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