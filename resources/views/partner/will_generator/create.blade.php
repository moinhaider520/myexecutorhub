@extends('layouts.master')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
      <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
      <div class="row">
        <!-- STEPS -->
        <div class="col-md-6">
        <div class="card">
          <div class="card-header">
          <h4>STEP 1 - About You</h4>
          </div>
          <div class="card-body">
          <p>Karen Roberts</p>
          <p>04/11/2000</p>
          <p>XYZ Street</p>
          <p>Is Single</p>
          <p>The Parent of Melissa</p>
          <p>No Pets</p>
          <a href="{{ route('partner.will_generator.about_you') }}">Edit</a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h4>STEP 2 - Accounts and Property</h4>
          </div>
          <div class="card-body">
          <p>Test Property</p>
          <a href="{{ route('partner.will_generator.account_properties') }}">Edit</a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h4>STEP 3 - Your Estate</h4>
          </div>
          <div class="card-body">
          <p>Thane Dillards ............... 16.67%</p>
          <p>The RNLI ............... 16.67%</p>
          <p>Macmillan Cancer Support ............... 16.67%</p>
          <p>The Charities Aid Foundation ............... 16.67%</p>
          <a href="{{ route('partner.will_generator.about_you') }}">Edit</a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h4>STEP 4 - Executors</h4>
          </div>
          <div class="card-body">
          <p>Your Executor is Thimoty</p>
          <a href="{{ route('partner.will_generator.about_you') }}">Edit</a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h4>Gifts (Optional)</h4>
          </div>
          <div class="card-body">
          <p>£50000 to Keane Woodward</p>
          <p>My Watch to Keane Woodward</p>
          <a href="{{ route('partner.will_generator.about_you') }}">Edit</a>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
          <h4>Funeral wishes (Optional)</h4>
          </div>
          <div class="card-body">
          <p>Give your family less to worry about. Add your wishes so they know what to do when the time comes.
          </p>
          <a href="{{ route('partner.will_generator.about_you') }}">Edit</a>
          </div>
        </div>
        </div>
        <!-- ACTION BUTTONS -->
        <div class="col-md-6">
        Your Progress
        <div class="progress" style="height: 25px;">
          <div class="progress-bar bg-success" role="progressbar" id="myProgressBar" style="width: 0%;"
          aria-valuemin="0" aria-valuemax="100">
          0%
          </div>
        </div>
        <img
          src="https://res.cloudinary.com/dwr27vxv7/image/upload/c_scale,f_auto,q_auto,w_600/illustrations/experts.png" />
        <button class="btn btn-primary w-100">Download Your Will</button>
        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- Container-fluid Ends-->
  </div>



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function setProgress(percent) {
    var progressBar = document.getElementById('myProgressBar');
    progressBar.style.width = percent + '%';
    progressBar.innerText = percent + '%';
    progressBar.setAttribute('aria-valuenow', percent);
    }

    // Example usage:
    setProgress(70); // sets it to 70%
  </script>

@endsection
