@extends('layouts.will_generator')

@section('title', 'Farewill Trustees')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
   <style>
        /* Custom styles to match the previous pages and the screenshot */
        body {
            background-color: #f5f5f5; /* Light grey background for the whole page */
        }
        .content-card {
            background-color: #ffffff; /* White background for the main content card */
            border-radius: 0.5rem; /* Rounded corners */
            padding: 2rem; /* Increased padding for main content */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* Subtle shadow */
        }

        /* Checkbox styling (reused from previous design) */
        .custom-checkbox-container {
            display: flex;
            align-items: flex-start; /* Align text to the top of the checkbox */
            margin-bottom: 1.5rem; /* Space between checkboxes */
            cursor: pointer;
        }

        .custom-checkbox-container input[type="checkbox"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 1.25rem; /* Adjust size */
            height: 1.25rem; /* Adjust size */
            border: 2px solid #a0aec0; /* Border color */
            border-radius: 0.25rem; /* Slightly rounded corners */
            outline: none;
            cursor: pointer;
            position: relative;
            flex-shrink: 0; /* Prevent checkbox from shrinking */
            margin-right: 1rem; /* Space between checkbox and text */
            margin-top: 0.25rem; /* Align checkbox vertically with text */
        }
        .custom-checkbox-container input[type="checkbox"]:checked {
            background-color: #F6E05E; /* Yellow background when checked */
            border-color: #F6E05E; /* Yellow border when checked */
        }
        .custom-checkbox-container input[type="checkbox"]:checked::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0.5rem;
            height: 0.75rem;
            border: solid #1a202c; /* Dark color for checkmark */
            border-width: 0 2px 2px 0;
            transform: translate(-50%, -60%) rotate(45deg);
        }

        .custom-checkbox-container label {
            font-size: 1rem;
            color: #4a5568; /* Text color for checkbox label */
            line-height: 1.5; /* Improve readability */
            cursor: pointer;
        }

        /* Styles for buttons (reused from previous design) */
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

        .done-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 2rem; /* Adjusted padding */
            border: 1px solid transparent;
            font-size: 1rem; /* Base font size */
            font-weight: 500;
            border-radius: 0.375rem; /* Medium rounded corners */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* Shadow */
            color: #1a202c; /* Dark text for button */
            background-color: #F6E05E; /* Yellow background */
            cursor: pointer;
            transition: background-color 0.15s ease-in-out;
        }
        .done-button:hover {
            background-color: #ECC94B; /* Darker yellow on hover */
        }
        .done-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(252, 211, 77, 0.5); /* Focus ring */
        }

        /* Global styling adjustments for better visual hierarchy */
        h1, h2, h4 {
            font-weight: 700; /* Bold for headings */
            color: #1a202c; /* Darker heading color */
        }
        p, li {
            color: #4a5568; /* Slightly lighter text for body */
        }
        a.text-blue-600:hover {
            text-decoration: underline;
        }
    </style>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 my-lg-5">
        <div class="flex flex-col lg:flex-row lg:space-x-8">
            {{-- Main content area --}}
            <div class="lg:w-2/3">
                <div class="content-card">
                    <h1 class="text-3xl font-bold text-gray-800 mb-4">
                        Farewill Trustees
                    </h1>
                    <p class="text-gray-700 leading-relaxed mb-4">
                        As a professional executor and part of the Farewill group, Farewill Trustees believes in absolute transparency over how the service works.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        For this reason, we want you to confirm you understand how Farewill Trustees do things.
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-8">
                        You should <a href="#" class="text-blue-600 hover:underline">read our full terms and conditions</a>. We recommend you print a copy of our terms. If our terms change in the future, we’ll let you know when you next log in to your account.
                    </p>

                    <form id="farewillTrusteesForm" action="{{ route('customer.will_generator.store_executor') }}" method="POST">
                        @csrf
                        <input type="hidden" name="farewill_trustees" value="farewill_trustees">
                        <input type="hidden" name="will_user_id" value="{{ $will_user_id }}">
                        <div class="space-y-4">
                            <div class="custom-checkbox-container">
                                <input type="checkbox" id="understand_charge" name="acknowledgements[]" value="understand_charge" required>
                                <label for="understand_charge">I understand I am appointing a professional executor who will charge for their services</label>
                            </div>

                            <div class="custom-checkbox-container">
                                <input type="checkbox" id="no_fees_until_die" name="acknowledgements[]" value="no_fees_until_die" required>
                                <label for="no_fees_until_die">I understand that no fees are paid from my estate to Farewill Trustees until after I die</label>
                            </div>

                            <div class="custom-checkbox-container">
                                <input type="checkbox" id="read_terms" name="acknowledgements[]" value="read_terms" required>
                                <label for="read_terms">I have read Farewill Trustees’ current terms and understand that their terms at the date of my death will apply</label>
                            </div>
                        </div>

                        <div class="flex justify-between items-center mt-8">
                            <a onclick="history.back()" class="back-button">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                                Back
                            </a>
                            <button type="submit" class="done-button">
                                Done
                            </button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- <div class="lg:w-1/3 mt-8 lg:mt-0">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h4 class="text-lg font-semibold text-gray-800 mb-4">Questions?</h4>
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
            </div> -->
        </div>
    </div>

    {{-- Script includes --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#farewillTrusteesForm').on('submit', function(e) {
                // Prevent default form submission to handle validation
                e.preventDefault();

                const checkedAcknowledgements = $('input[name="acknowledgements[]"]:checked').length;
                const totalAcknowledgements = $('input[name="acknowledgements[]"]').length;

                if (checkedAcknowledgements < totalAcknowledgements) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Information',
                        text: 'Please check all boxes to confirm your understanding.',
                    });
                    return false; // Prevent form submission
                }

                this.submit(); // Submit the form normally

            });
        });
    </script>
