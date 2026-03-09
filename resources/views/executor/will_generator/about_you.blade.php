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
              <form id="msform" class="needs-validation" novalidate action="{{route('customer.will_generator.store_about_you')}}" method="POST">
                @csrf
                @include('customer.will_generator.partials.about_you_partials.step1')
                @include('executor.will_generator.partials.about_you_partials.step2')

              </form>
              <div class="wizard-footer d-flex gap-2 justify-content-end mt-2 m-4">
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
    nextBtn.textContent = (index === steps.length - 1) ? 'Next' : 'Next';
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

  const ukPostcodeRegex = /\b(?:GIR\s?0AA|(?:(?:[A-PR-UWYZ][0-9][0-9]?|[A-PR-UWYZ][A-HK-Y][0-9][0-9]?|[A-PR-UWYZ][0-9][A-HJKSTUW]|[A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])\s?[0-9][ABD-HJLNP-UW-Z]{2}))\b/i;
  const ukCountryRegex = /\b(UNITED\s+KINGDOM|UK|GREAT\s+BRITAIN|ENGLAND|SCOTLAND|WALES|NORTHERN\s+IRELAND)\b/i;

  function isLikelyUkAddress(rawValue) {
    const value = (rawValue || '').trim();
    if (value.length < 8) return false;
    return ukPostcodeRegex.test(value) || ukCountryRegex.test(value);
  }

  function updateExecutorAboutYouUkNudge() {
    const addressLine1 = document.getElementById('executor_address_line_1')?.value || '';
    const city = document.getElementById('executor_city')?.value || '';
    const postCode = document.getElementById('executor_post_code')?.value || '';
    const combined = `${addressLine1} ${city} ${postCode}`.trim();
    const nudge = document.getElementById('executor_about_you_uk_nudge');
    if (!nudge) return;
    nudge.classList.toggle('d-none', !isLikelyUkAddress(combined));
  }

  ['executor_address_line_1', 'executor_city', 'executor_post_code'].forEach((id) => {
    const el = document.getElementById(id);
    if (!el) return;
    el.addEventListener('input', updateExecutorAboutYouUkNudge);
    el.addEventListener('blur', updateExecutorAboutYouUkNudge);
  });

  // Initialize first step
  showStep(currentStep);
  updateExecutorAboutYouUkNudge();
</script>



@endsection
