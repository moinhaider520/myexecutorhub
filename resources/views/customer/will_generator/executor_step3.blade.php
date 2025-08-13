@extends('layouts.will_generator')

@section('title', 'Choosing your executors')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
    /* Custom styles for the radio buttons to make them look like block-level buttons */
    .executor-option-card {
        background-color: #f8f8f8; /* Light gray background for options */
        border: 1px solid #e0e0e0; /* Light border */
        border-radius: 0.5rem; /* Rounded corners */
        padding: 1rem 1.5rem;
        margin-bottom: 1rem;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        display: block; /* Make it a block element */
        width: 100%;
        text-align: left; /* Align text to the left */
    }

    .executor-option-card:hover {
        border-color: #a0aec0; /* Darker border on hover */
        background-color: #edf2f7; /* Slightly darker background on hover */
    }

    /* Hide the native radio button input */
   .executor-option-card input[type="radio"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    position: absolute;
    opacity: 0;
    width: 0;
    height: 0;
    pointer-events: none;
}

    /* Style the card when it has the 'selected-card' class (applied by JavaScript) */
    .executor-option-card.selected-card {
        background-color: #F6E05E; /* Yellow background for selected card */
        border-color: #D6BC2B; /* Darker yellow border for selected card */
    }

    /* Style the text inside the selected card to be bold */
    .executor-option-card.selected-card span {
        font-weight: bold;
        color: #2D3748; /* Dark text on yellow background */
    }

  .executor-option-card input[type="radio"]:checked + span {
    font-weight: bold;
    color: #2D3748;
}
    .hidden {
        display: none !important;
    }

    /* Styles for the "Back" and "Continue" buttons for consistency */
    .back-button {
        background: none;
        border: none;
        color: #4299e1; /* Blue for links */
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 500;
        transition: color 0.2s ease-in-out;
    }

    .back-button:hover {
        color: #2b6cb0; /* Darker blue on hover */
        text-decoration: underline;
    }
</style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8"> {{-- Main content area --}}
                        <div class="card height-equal">
                            <div class="card-header">
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form id="executorChoiceForm" class="needs-validation" novalidate
                                    action="{{route('customer.will_generator.get_executor_step3')}}" method="POST">
                                    @csrf

                                    <script src="https://cdn.tailwindcss.com"></script>
                                    <input type="hidden" name="will_user_id" value="{{ $will_user_id }}">
                                    <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                        <div class="col-sm-12">
                                            {{-- Content from the screenshot starts here --}}

                                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                                Choosing your executors
                                            </h1>
                                            <p class="text-gray-700 leading-relaxed mb-8">
                                                We recommend choosing more than one executor, especially if any beneficiaries of your will are currently under 18.
                                            </p>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                                                Choosing friends & family
                                            </h2>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                Being an executor is a big responsibility. There are a few important things to consider if you’re choosing friends or family:
                                            </p>
                                            <ul class="list-disc list-inside text-gray-700 space-y-2 mb-8 ml-5">
                                                <li>they’re over 18</li>
                                                <li>you trust them</li>
                                                <li>they’re good with finances and paperwork</li>
                                                <li>they’re happy to take on the legal responsibility</li>
                                                <li>you’re happy to tell them you’ve chosen them</li>
                                            </ul>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                                                Choosing Executorhub Trustees
                                            </h2>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                Executorhub Trustees are professional executors. They can:
                                            </p>
                                            <ul class="list-disc list-inside text-gray-700 space-y-2 mb-8 ml-5">
                                                <li>be the sole executor or a co-executor</li>
                                                <li>take the stress away from family and friends</li>
                                                <li>act as a fair, objective third party if conflict happens</li>
                                                <li>resolve the probate process quickly and professionally</li>
                                            </ul>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                                                Choosing friends & family and Executorhub Trustees
                                            </h2>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                Bringing together people who knew you personally with a professional to take care of the legal and financial paperwork can provide balance and make things less stressful. Executorhubs Trustees share the work fairly and appropriately based on who is best for each task.
                                            </p>
                                            <p class="text-gray-700 leading-relaxed mb-8">
                                                <span class="font-bold">No hard commitments</span>
                                                <br>
                                                Executorhub Trustees will step aside if it’s in the best interest of the estate, and their services aren’t needed. In a few cases, they may not be able to step aside, for example, if there are no other executors.
                                            </p>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
                                                Who would you like to be your executors?
                                            </h2>

                                            <div class="executor-options-group mb-8">
                                                <label class="executor-option-card">
                                                    <input type="radio" name="executor_type" value="friends_family" required>
                                                    <span>Friends & family</span>
                                                </label>
                                                <label class="executor-option-card">
                                                    <input type="radio" name="executor_type" value="farewill_trustees" required>
                                                    <span>Executorhub Trustees (Professional executors)</span>
                                                </label>
                                                <label class="executor-option-card">
                                                    <input type="radio" name="executor_type" value="friends_family_and_trustees" required>
                                                    <span>Friends & family and Executorhub Trustees</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-5 items-center">
                                        <a onclick="history.back()" class="back-button">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                            </svg>
                                            Back
                                        </a>
                                        <button class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                            Continue
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4"> {{-- Sidebar area (inherited from layout) --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Questions?</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-gray-700 mb-2">
                                    Call us on <a href="tel:02045387294" class="text-blue-600 hover:underline">020 4538 7294</a>
                                </p>
                                <p class="text-gray-700">
                                    <a href="mailto:info@farewill.com" class="text-blue-600 hover:underline flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Email us
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    {{-- Script includes --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Optional: Add a class to the selected card for more prominent styling if needed
            $('input[name="executor_type"]').on('change', function() {
                $('.executor-option-card').removeClass('selected-card'); // Remove from all
                if ($(this).is(':checked')) {
                    $(this).closest('.executor-option-card').addClass('selected-card'); // Add to selected
                }
            });
        });
    </script>
@endsection
