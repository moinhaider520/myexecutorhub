@extends('layouts.master')

@section('content')
  <style>
    .ck-editor__editable_inline {
    min-height: 300px;
    }
    .lifetime-subscription-section {
      margin-top: 30px;
      padding: 20px;
      background-color: #f8f9fa;
      border-radius: 8px;
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
          @php
            $willUserInfo = \App\Models\WillUserInfo::where('user_id', Auth::user()->id)->first();
            $dateOfBirth = $willUserInfo->date_of_birth ?? old('date_of_birth');
          @endphp

          @if(Auth::user()->subscribed_package == "free_trial" || Auth::user()->stripe_subscription_id == null)
        <div class="row mb-3">
        <div class="col-md-12">
        <p>You are currently on {{ str_replace('_', ' ', Auth::user()->subscribed_package) }} plan and it will expire on
          {{ Auth::user()->trial_ends_at }}. Make sure to Upgrade your plan to continue using Executor Hub.
        </p>
        </div>
        </div>

        <!-- Monthly Subscription Plans -->
        <div class="row mb-4">
          <div class="col-md-12">
            <h5 class="mb-3">Monthly Subscription Plans</h5>
          </div>
        </div>
        <div class="row g-sm-4 g-3">
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height:400px;">
          <h4>Basic</h4>
          <h5>£5.99</h5>
          <h6 class="mb-0">Per Month</h6>
          <ul>
          <li>Assign Executors</li>
          <li>Record Assets & Liabilities</li>
          </ul>
          </div>
          <form id='checkout-form' method='post' action="{{ route('stripe.resubscribe') }}">
          @csrf
          <input type="hidden" name="email" value={{ Auth::user()->email }}>
          <input type="hidden" name="plan" value="price_1R6CY5A22YOnjf5ZrChFVLg2">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height:400px;">
          <h4>Standard</h4>
          <h5>£11.99</h5>
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
          <input type="hidden" name="plan" value="price_1R6CZDA22YOnjf5ZUEFGbQOE">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        <div class="col-lg-4 col-sm-6 box-col-3">
        <div class="card text-center pricing-simple">
          <div class="card-body" style="height: 400px;">
          <h4>Premium </h4>
          <h5>£19.99</h5>
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
          <input type="hidden" name="plan" value="price_1R6CaeA22YOnjf5Z0sW3CZ9F">
          <button id='pay-btn' class="btn btn-success mt-3" type="submit"
          style="margin-top: 20px; width: 100%; padding: 7px;">Subscribe</button>
          </form>
        </div>
        </div>
        </div>

        <!-- Lifetime Subscription Option -->
        <div class="lifetime-subscription-section">
          <div class="row">
            <div class="col-md-12">
              <h5 class="mb-3">💰 Lifetime Subscription</h5>
              <p class="mb-3">Can work out up to 80% cheaper than paying monthly long-term. Get lifetime access to all features with a one-time payment. No recurring fees, no hassle.</p>
              
              @if ($errors->lifetime->any())
                <div class="alert alert-danger" role="alert">
                  <ul class="mb-0 ps-3">
                    @foreach ($errors->lifetime->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form id="lifetimeStep1Form" method="POST" action="{{ route('stripe.lifetime.step1') }}" class="row g-3">
                @csrf
                <div class="col-md-6">
                  <label for="lifetimeDob" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                  <input type="date" class="form-control" id="lifetimeDob" name="date_of_birth" value="{{ $dateOfBirth }}" required>
                  @error('date_of_birth', 'lifetime')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                  @enderror
                  <small class="form-text text-muted">Select your date of birth to see lifetime pricing options.</small>
                </div>
                <div class="col-md-12 mt-3">
                  <button type="submit" class="btn btn-primary btn-lg">
                    View Lifetime Pricing
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>

      @else
      <div class="row mb-3">
      <div class="col-md-12">
      <p>You are Currently on {{ Auth::user()->subscribed_package }} and it will automatically renew on
        {{ Auth::user()->trial_ends_at }}. 
      </p>
      <p>You can cancel your monthly subscription or switch to a lifetime subscription below.</p>
      <p class="text-muted"><small>Please Note that when you cancel your subscription you can still use Executor Hub until the expiry date of the purchased plan.</small></p>
      </div>
      </div>
      <div class="row g-sm-4 g-3 mb-4">
      <div class="col-lg-6 col-sm-6 box-col-3">
      <form action="{{ route('subscription.cancel') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger btn-lg w-100">Cancel Monthly Subscription</button>
      </form>
      </div>
      </div>

      <!-- Lifetime Subscription Option for Active Subscribers -->
      <div class="lifetime-subscription-section">
        <div class="row">
          <div class="col-md-12">
            <h5 class="mb-3">💰 Switch to Lifetime Subscription</h5>
            <p class="mb-3">Save money long-term! Switch from monthly payments to a one-time lifetime payment. Can work out up to 80% cheaper than paying monthly long-term.</p>
            
            @if ($errors->lifetime->any())
              <div class="alert alert-danger" role="alert">
                <ul class="mb-0 ps-3">
                  @foreach ($errors->lifetime->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form id="lifetimeStep1FormActive" method="POST" action="{{ route('stripe.lifetime.step1') }}" class="row g-3">
              @csrf
              <div class="col-md-6">
                <label for="lifetimeDobActive" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="lifetimeDobActive" name="date_of_birth" value="{{ $dateOfBirth }}" required>
                @error('date_of_birth', 'lifetime')
                  <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <small class="form-text text-muted">Select your date of birth to see lifetime pricing options.</small>
              </div>
              <div class="col-md-12 mt-3">
                <button type="submit" class="btn btn-primary btn-lg">
                  View Lifetime Pricing & Switch
                </button>
              </div>
            </form>
          </div>
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

  <script>
    // Handle lifetime subscription form submission
    document.addEventListener('DOMContentLoaded', function () {
      const lifetimeForms = document.querySelectorAll('#lifetimeStep1Form, #lifetimeStep1FormActive');
      
      lifetimeForms.forEach(function(form) {
        if (form) {
          form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Basic validation - if HTML5 validation passes, proceed
            if (form.checkValidity()) {
              // Show loading state
              if (submitBtn) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Processing...';

                // Re-enable after 5 seconds as fallback (in case redirect fails)
                setTimeout(function () {
                  submitBtn.disabled = false;
                  submitBtn.textContent = originalText;
                }, 5000);
              }
              // Allow form to submit normally
              return true;
            } else {
              // HTML5 validation failed - prevent submission and show errors
              e.preventDefault();
              e.stopPropagation();
              form.classList.add('was-validated');
              return false;
            }
          });
        }
      });
    });
  </script>
@endsection