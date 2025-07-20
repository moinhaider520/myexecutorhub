@extends('layouts.will_generator')

@section('content')
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    #dummy-text {
    margin-bottom: 20px;
    font-size: 18px;
    }

    canvas,
    video {
    border: 1px solid #ddd;
    background-color: #000;
    }

    .canvas-container {
    position: relative;
    display: none;
    }

    canvas {
    width: 640px;
    height: 360px;
    }

    video.preview {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 150px;
    height: 90px;
    display: none;
    }

    .controls {
    display: flex;
    justify-content: space-between;
    width: 640px;
    margin-top: 10px;
    }
  </style>


  <!-- Container-fluid starts-->
  <div class="container-fluid default-dashboard">
    <div class="row widget-grid">
    <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
      <div class="row">
      <div class="col-xl-12">
        <div class="card height-equal">
        <div class="card-header">
          <h4>About You</h4>
        </div>
        <div class="card-body basic-wizard important-validation">
          <form id="msform" class="needs-validation" novalidate>
          @include('partner.will_generator.partials.about_you_partials.step1')
          @include('partner.will_generator.partials.about_you_partials.step2')
          @include('partner.will_generator.partials.about_you_partials.step3')
          @include('partner.will_generator.partials.about_you_partials.step4')
          </form>
          <div class="wizard-footer d-flex gap-2 justify-content-end mt-2">
          <button class="btn badge-light-primary" id="backbtn" onclick="backStep()" disabled=""> Back</button>
          <button class="btn btn-primary" id="nextbtn" onclick="nextStep()">Next</button>
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



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    let currentStep = 0;
    const steps = document.querySelectorAll('#msform > div');

    const steppers = document.querySelectorAll('.stepper-horizontal .step');
    const nextBtn = document.getElementById('nextbtn');
    const backBtn = document.getElementById('backbtn');

    function showStep(index) {
    steps.forEach((step, i) => {
      step.style.display = (i === index) ? 'flex' : 'none';
    });

    steppers.forEach((stepper, i) => {
      stepper.classList.toggle('active', i <= index);
    });

    backBtn.disabled = index === 0;
    nextBtn.textContent = (index === steps.length - 1) ? 'Finish' : 'Next';
    }

    function nextStep() {
    const form = document.getElementById('msform'); // your single form

    // Only validate inputs in the current step
    const currentInputs = steps[currentStep].querySelectorAll('input, select, textarea');
    let isValid = true;

    currentInputs.forEach(input => {
      if (!input.checkValidity()) {
      isValid = false;
      }
    });

    // Show browser validation if needed
    if (!isValid) {
      form.reportValidity();
      return;
    }


    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    } else {
      document.getElementById('msform').submit();
      // Or use AJAX here instead if you prefer
    }
    }

    function backStep() {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
    }

    // Initialize first step
    showStep(currentStep);
  </script>



@endsection