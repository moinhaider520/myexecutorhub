@extends('layouts.will_generator')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Base styles for the overall layout */
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f8f8f8;
        /* Light grey background */
    }

    .container-fluid {
        padding: 1.5rem;
    }

    .card {
        background-color: #ffffff;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 1.5rem;
    }

    .card-body {
        padding: 1.5rem;
    }

    /* Custom styles for the top banner message */
    .banner-message {
        background-color: #d1fae5;
        /* Light green */
        color: #065f46;
        /* Dark green text */
        padding: 1rem;
        text-align: center;
        font-weight: 500;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        border: 1px solid #a7f3d0;
        /* Green border */
    }

    /* Custom styling for radio buttons to match the image's appearance */
    input[type="radio"] {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        display: inline-block;
        width: 1rem;
        height: 1rem;
        border-radius: 50%;
        border: 2px solid #d1d5db;
        /* Light gray border */
        background-color: #fff;
        position: relative;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease-in-out;
    }

    input[type="radio"]:checked {
        border-color: #4f46e5;
        /* Indigo-600 border when checked */
        background-color: #4f46e5;
        /* Indigo-600 background when checked */
    }

    input[type="radio"]:checked::before {
        content: '';
        display: block;
        width: 0.5rem;
        height: 0.5rem;
        background-color: #fff;
        /* White dot inside when checked */
        border-radius: 50%;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    input[type="radio"]:focus {
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5);
        /* Focus ring for accessibility */
    }
    .executor-details {
        display: none; /* Hidden by default */
        margin-top: 0.5rem;
        padding: 0.75rem;
        background-color: #f0f4f8; /* Light blue-gray background */
        border-left: 4px solid #4f46e5; /* Indigo border */
        border-radius: 0.25rem;
        font-size: 0.9rem;
        color: #4a5568;
    }
    /* Added for the details section to be hidden by default */
    .excluded-details-section {
        display: none; /* This ensures the section is hidden initially */
    }
</style>

<div class="container-fluid default-dashboard">
    <div class="row widget-grid flex justify-center"> {{-- Centering the single column --}}
        <div class="w-full max-w-2xl p-3"> {{-- Main content area, adjusted for single column --}}
            <!-- Your Estate Summary Section -->
            <section class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Your estate summary</h2>

                <div class="space-y-4 mb-6">
                    {{-- Your existing foreach loop for beneficiaries --}}
                    @forelse($beneficiaries as $beneficiary)
                    <div class="flex justify-between items-center border-b pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <p class="text-gray-700 font-medium">
                                @if(isset($beneficiary->type) && $beneficiary->type === 'charity')
                                £ {{ $beneficiary->name }}
                                @else
                                {{ $beneficiary->getNameAttribute() }}
                                @endif
                            </p>
                            @if(isset($beneficiary->death_backup_plan))
                            <p class="text-sm text-gray-500">Backups: {{ $beneficiary->death_backup_plan }}</p>
                            @endif
                        </div>
                        <span class="text-gray-700 font-semibold">{{ number_format($beneficiary->share_percentage, 2) }}%</span>
                    </div>
                    @empty
                    <p class="text-gray-500">No beneficiaries added yet.</p>
                    @endforelse
                </div>

                <button class="w-full py-3 px-4 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150 shadow-sm">
                    Make changes
                </button>
            </section>

            <!-- Excluded Individuals Section -->
            <section class="bg-white p-6 rounded-lg shadow-md mb-8">
                <form action="{{route('customer.will_generator.estate.store_estate_summary')}}" method="post">
                    @csrf
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Is there anyone you've specifically chosen to leave out of your will?</h2>
                <p class="text-gray-600 mb-4">Such as close family, partners or someone who relies on you financially.</p>

                <div class="flex items-center space-x-4 mb-6">
                    <label class="inline-flex items-center">
                        <input type="radio" name="excluded_choice" value="no" class="form-radio" checked>
                        <span class="ml-2 text-gray-700">No</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="excluded_choice" value="yes" class="form-radio">
                        <span class="ml-2 text-gray-700">Yes</span>
                    </label>
                </div>

                {{-- This section will be conditionally displayed based on radio button selection --}}
                <div id="excludedDetailsSection" class="excluded-details-section">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Please give more details about your choice below</h2>
                    <p class="text-gray-600 mb-4">Include who you have not put into your will and why. This is important evidence to support your will if someone ever challenges it.</p>
                    <p class="text-gray-600 mb-4">It can help to explain why you've chosen other people or charities instead of the person you've not put in the will.</p>

                    <textarea class="w-full p-3 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 resize-y mb-6 min-h-[100px]" placeholder="TEST" name="will_estate_reason"></textarea>

                    <p class="text-sm text-gray-500 mb-2 executor-message-toggle" id="executorMessageToggle">
                        Your message will only be seen by your executors <span class="ml-1">&#9660;</span>
                    </p>

                    {{-- Hidden message to be toggled --}}
                    <div class="executor-details" id="executorDetails">
                        They are the people dealing with your estate after you die. They will decide whether it’s absolutely necessary to share this message or not if someone challenges your will.
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button class="py-2 px-4 bg-gray-200 text-gray-700 font-semibold rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150 shadow-sm">
                        &larr; Back
                    </button>
                    <button class="py-2 px-6 bg-yellow-400 text-gray-800 font-semibold rounded-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300 focus:ring-opacity-50 transition ease-in-out duration-150 shadow-sm">
                        Done
                    </button>
                    </form>
                </div>
            </section>
        </div>
    </div>
</div>

{{-- Scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Toggle functionality for executor message
        $('#executorMessageToggle').on('click', function() {
            $('#executorDetails').slideToggle(); // Smoothly slide up/down
        });

        const excludedDetailsSection = $('#excludedDetailsSection');
        const excludedChoiceRadios = $('input[name="excluded_choice"]');

        // Function to show/hide the details section
        function toggleExcludedDetails() {
            if ($('input[name="excluded_choice"]:checked').val() === 'yes') {
                excludedDetailsSection.slideDown();
            } else {
                excludedDetailsSection.slideUp();
            }
        }

        // Initial check on page load
        toggleExcludedDetails(); // Call on page load to set initial visibility

        // Listen for changes on the radio buttons
        excludedChoiceRadios.on('change', function() {
            toggleExcludedDetails();
        });
    });
</script>
@endsection
