@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Using Tailwind CSS directly --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Base styles for the overall layout */
        .container-fluid {
            padding: 1.5rem; /* Adjust as needed for overall page padding */
        }
        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem; /* Space between card and bottom content */
        }
        .card-header {
            font-size: 1.125rem;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #edf2f7;
            color: #2d3748;
        }
        .card-body {
            padding: 1.5rem;
        }

        /* Percentage Input Item Styles */
        .percentage-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            background-color: #f7fafc; /* Light gray background */
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.75rem 1rem;
        }

        .percentage-item.total-row {
            background-color: #fff; /* White background for total row */
            font-weight: 600;
            border-color: #a0aec0; /* Slightly darker border */
            margin-top: 1.5rem; /* Space above total */
        }

        .percentage-input-wrapper {
            position: relative;
            width: 80px; /* Fixed width for the input field */
            margin-right: 1rem;
        }

        .percentage-input {
            width: 100%;
            padding: 0.5rem 1.8rem 0.5rem 0.5rem; /* Increased right padding to make space for the symbol */
            border: 1px solid #cbd5e0; /* Gray border */
            border-radius: 0.25rem;
            text-align: right; /* Align text to the right */
            font-size: 1rem;
            color: #2d3748;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .percentage-input:focus {
            border-color: #4299e1; /* Blue border on focus */
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        

        .percentage-symbol {
            position: absolute;
            right: 0.6rem; /* Adjusted right position slightly to match the screenshot */
            top: 50%;
            transform: translateY(-50%);
            color: #4a5568;
            font-weight: 600;
            pointer-events: none; /* Prevents the symbol from interfering with input clicks/focus */
        }

        .beneficiary-name {
            font-weight: 500;
            color: #2d3748;
            flex-grow: 1; /* Allows name to take remaining space */
        }

        /* Accordion/Collapsible styles for "Why do I have to share..." */
        .accordion-item {
            margin-top: 2rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .accordion-header {
            display: flex;
            align-items: center;
            cursor: pointer;
            padding: 0.5rem 0;
            font-weight: 600;
            color: #2b6cb0; /* Blue color for the header */
            transition: color 0.2s ease;
        }

        .accordion-header:hover {
            color: #2c5282; /* Darker blue on hover */
        }

        .accordion-icon {
            margin-left: 0.5rem;
            transition: transform 0.2s ease-in-out;
        }

        .accordion-icon.rotated {
            transform: rotate(90deg); /* Rotate icon when expanded */
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, padding 0.3s ease-out;
            padding-bottom: 0;
            padding-top: 0;
        }

        .accordion-content.expanded {
            max-height: 200px; /* Adjust based on content height */
            padding-bottom: 1rem; /* Padding when expanded */
        }

        .accordion-content p {
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        /* Sidebar styles (Inheriting your estate) */
        .inheritance-summary-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content; /* Ensure it doesn't take full height if content is small */
            position: sticky; /* Makes it stick when scrolling */
            top: 1.5rem; /* Distance from top of viewport */
        }

        .inheritance-summary-card h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .inheritance-summary-card ul li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #edf2f7;
            color: #4a5568;
            font-size: 0.95rem;
        }

        .inheritance-summary-card ul li:last-child {
            border-bottom: none;
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-7"> {{-- Main content area (using col-xl-7 as per previous discussion) --}}
                <div class="card height-equal">
                    <div class="card-body basic-wizard important-validation">
                        <form action="#" method="POST">
                            @csrf

                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                How would you like to share your estate?
                            </h1>
                            <p class="text-gray-700 leading-relaxed mb-6">
                                You can choose backups on the next page in case the people you've chosen die before you.
                            </p>

                            {{-- Percentage Input Fields --}}
                            <div id="percentageInputsContainer">
                                {{-- These will be dynamically generated by JS, but hardcode for initial display matching screenshot --}}
                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[thane_dillard]" value="16.67">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">Thane Dillard</span>
                                </div>

                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[lane_rodgers]" value="16.67">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">Lane Rodgers</span>
                                </div>

                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[the_rnli]" value="16.67">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">The RNLI</span>
                                </div>

                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[macmillan_cancer_support]" value="16.67">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">Macmillan Cancer Support</span>
                                </div>

                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[edhi_international_foundation_uk]" value="16.67">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">Edhi International Foundation UK</span>
                                </div>

                                <div class="percentage-item">
                                    <div class="percentage-input-wrapper">
                                        <input type="number" step="0.01" min="0" max="100" class="percentage-input" name="percentages[the_charities_aid_foundation]" value="16.65">
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">The Charities Aid Foundation</span>
                                </div>

                                {{-- Total Row --}}
                                <div class="percentage-item total-row">
                                    <div class="percentage-input-wrapper">
                                        <input type="text" class="percentage-input" id="totalPercentage" value="100" readonly>
                                        <span class="percentage-symbol">%</span>
                                    </div>
                                    <span class="beneficiary-name">Total</span>
                                </div>
                            </div>

                            {{-- Accordion for "Why do I have to share..." --}}
                            <div class="accordion-item">
                                <div class="accordion-header" id="accordionHeader">
                                    Why do I have to share my estate as a percentage?
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 accordion-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <div class="accordion-content" id="accordionContent">
                                    <p>When you divide your estate by percentage, it means that if the total value of your estate changes over time (which it often does), the proportions you've assigned to your beneficiaries will automatically adjust. This is generally the most flexible and robust way to divide your estate in a Will.</p>
                                    <p>For example, if you leave 50% to one person and 50% to another, and your estate doubles in value, each person will still receive half of the new, larger amount, rather than a fixed sum that might become a smaller proportion of your wealth.</p>
                                </div>
                            </div>


                            <div class="d-flex justify-content-between mt-8">
                                <a href="{{ route('partner.will_generator.choose_inherited_charity') }}"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    &larr; Back
                                </a>

                                <button type="submit"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                    Save and continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-5"> {{-- Sidebar area (using col-xl-5 as per previous discussion) --}}
                <div class="inheritance-summary-card">
                    <h4>Inheriting your estate:</h4>
                    <ul id="inheritanceSummaryList">
                        {{-- These items will be dynamically updated by JavaScript --}}
                        {{-- Initial items for demo, based on your screenshot's summary --}}
                        <li>Thane Dillard</li>
                        <li>Lane Rodgers</li>
                        <li>The RNLI</li>
                        <li>Macmillan Cancer Support</li>
                        <li>Edhi International Foundation UK</li>
                        <li>The Charities Aid Foundation</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            // --- Accordion/Collapsible Logic ---
            const accordionHeader = $('#accordionHeader');
            const accordionContent = $('#accordionContent');
            const accordionIcon = accordionHeader.find('.accordion-icon');

            accordionHeader.on('click', function() {
                accordionContent.toggleClass('expanded');
                accordionIcon.toggleClass('rotated');
            });

            // --- Dynamic Total Percentage Calculation (for future if values are not fixed) ---
            // This is just a placeholder for now as the screenshot shows fixed values
            function calculateTotalPercentage() {
                let total = 0;
                $('.percentage-input').not('#totalPercentage').each(function() {
                    const value = parseFloat($(this).val());
                    if (!isNaN(value)) {
                        total += value;
                    }
                });
                $('#totalPercentage').val(total.toFixed(2)); // Display with 2 decimal places
            }

            // Call on page load
            calculateTotalPercentage();

            // Update on input change (if values become editable)
            $('.percentage-input').not('#totalPercentage').on('input', function() {
                calculateTotalPercentage();
            });

            // --- Sidebar Inheritance Summary (Dynamic Population - Placeholder for now) ---
            // In a real application, you would fetch these beneficiaries from your backend
            // or pass them from the previous steps.
            // For now, it's hardcoded based on the screenshot.
            function updateInheritanceSummary() {
                // This function would typically retrieve selected beneficiaries from previous steps
                // and populate the sidebar list. Since we're just building the page,
                // the initial list is hardcoded to match the screenshot.
                // If you need it to be dynamic based on actual data, we'll need backend integration.
            }

            updateInheritanceSummary(); // Call on page load
        });
    </script>
@endsection