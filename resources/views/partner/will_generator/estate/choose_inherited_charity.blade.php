@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Base styles for the overall layout */
        .container-fluid {
            padding: 1.5rem;
            width: 75%;
            /* Adjust as needed for overall page padding */
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            /* Space between card and bottom content */
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

        /* Styles for Yes/No buttons */
        .yes-no-button-container {
            display: flex;
            gap: 0.75rem;
            /* Space between Yes/No buttons */
            margin-bottom: 1.5rem;
        }

        .yes-no-button {
            flex: 1;
            /* Make buttons take equal width */
            padding: 1rem 1.5rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            background-color: #fff;
            color: #4a5568;
            font-weight: 600;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .yes-no-button.selected {
            border-color: #4299e1;
            /* Blue border for selected */
            background-color: #ebf4ff;
            /* Light blue background for selected */
            color: #2b6cb0;
        }

        /* Charity Grid Styles for the logo-based charities */
        .charity-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* This will create exactly two equal columns */
            gap: 0.75rem;
            /* Smaller gap between items */
            margin-top: 1.5rem;
        }

        .charity-item {
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            padding: 0.75rem;
            /* Slightly less padding */
            display: flex;
            flex-direction: column;
            /* Stack logo and text vertically */
            align-items: center;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            background-color: #fff;
            position: relative;
            /* For checkbox positioning */
            min-height: 120px;
            /* Ensure consistent height for grid items */
            justify-content: space-between;
            /* Pushes logo to top, text to bottom */
            box-sizing: border-box;
            /* Include padding in height calculation */
        }

        .charity-item:hover {
            border-color: #a0aec0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
        }

        /* Custom Checkbox Styling - Crucial for matching the screenshot */
        .charity-item input[type="checkbox"] {
            /* Hide default checkbox */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            position: absolute;
            top: 0.5rem;
            left: 0.5rem;
            width: 1.25rem;
            height: 1.25rem;
            border: 1px solid #a0aec0;
            /* Gray border for unchecked */
            border-radius: 0.25rem;
            cursor: pointer;
            outline: none;
            z-index: 10;
            /* Ensure it's above other content */
            background-color: #fff;
            transition: background-color 0.2s, border-color 0.2s;
        }

        .charity-item input[type="checkbox"]:checked {
            background-color: #4299e1;
            /* Blue background when checked */
            border-color: #4299e1;
        }

        /* Checkmark icon using pseudo-elements */
        .charity-item input[type="checkbox"]::before {
            content: '';
            display: block;
            width: 0.75rem;
            height: 0.75rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="white"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            /* Initially hidden */
            opacity: 0;
            transition: transform 0.2s ease-in-out, opacity 0.2s ease-in-out;
        }

        .charity-item input[type="checkbox"]:checked::before {
            transform: translate(-50%, -50%) scale(1);
            /* Show checkmark */
            opacity: 1;
        }

        .charity-logo-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            /* Ensures it takes full width of the parent box */
            flex-grow: 1;
            /* Allows it to take up available space in the column */
            min-height: 60px;
            /* Increased min-height to give more room for larger logos */
            margin-bottom: 0.5rem;
            /* Space between logo and text */
            padding: 0.5rem;
            /* Add some padding inside the wrapper */
            box-sizing: border-box;
            /* Include padding in height/width */
        }

        .charity-logo {
            max-width: 100px;
            /* Allow image to be as wide as its wrapper */
            max-height: 100px;
            /* Allow image to be as tall as its wrapper */
            object-fit: contain;
            /* Ensures the image scales down to fit without cropping */
        }

        .charity-text-content {
            width: 100%;
            /* Ensure text content takes full width */
            text-align: center;
            display: flex;
            flex-direction: column;
            /* Stack name and registration vertically */
            align-items: center;
            /* Center text within the column */
            justify-content: flex-end;
            /* Push text content to the bottom of the item */
            flex-grow: 1;
            /* Allow text content to take remaining vertical space */
        }

        .charity-name {
            font-weight: 600;
            color: #1a202c;
            font-size: 0.875rem;
            /* Smaller font for name */
            line-height: 1.2;
            /* Tighter line height */
        }

        .charity-additional-text {
            /* For "Lifeguards" or other specific text above name */
            font-size: 0.75rem;
            /* Even smaller */
            color: #4a5568;
            margin-top: 0;
            /* No top margin, as it's meant to be close to the name */
            line-height: 1.2;
        }

        .charity-registration {
            font-size: 0.7rem;
            /* Smallest for registration number */
            color: #718096;
            margin-top: 0.25rem;
        }

        /* Styles for the non-logo based charities (like Edhi, sdfsfw, Charities Aid) */
        .charity-text-item {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            /* Align checkbox and text to start */
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            margin-bottom: 0.75rem;
            background-color: #fff;
            cursor: pointer;
        }

        .charity-text-item input[type="checkbox"] {
            /* Hide default checkbox */
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            margin-right: 1rem;
            width: 1.25rem;
            height: 1.25rem;
            border: 1px solid #a0aec0;
            /* Gray border for unchecked */
            border-radius: 0.25rem;
            cursor: pointer;
            outline: none;
            background-color: #fff;
            transition: background-color 0.2s, border-color 0.2s;
            position: relative;
            /* For pseudo-element checkmark */
            flex-shrink: 0;
            /* Prevent it from shrinking */
        }

        .charity-text-item input[type="checkbox"]:checked {
            background-color: #4299e1;
            /* Blue background when checked */
            border-color: #4299e1;
        }

        .charity-text-item input[type="checkbox"]::before {
            content: '';
            display: block;
            width: 0.75rem;
            height: 0.75rem;
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="white"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>');
            background-size: cover;
            background-repeat: no-repeat;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
            transition: transform 0.2s ease-in-out, opacity 0.2s ease-in-out;
        }

        .charity-text-item input[type="checkbox"]:checked::before {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }

        .charity-text-details {
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            /* Allows text to take available space */
        }

        .charity-text-name {
            font-weight: 600;
            color: #1a202c;
        }

        .charity-text-registration {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .add-own-charity-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 1px dashed #a0aec0;
            border-radius: 0.375rem;
            color: #4a5568;
            background-color: #f7fafc;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 1.5rem;
            width: 100%;
        }

        .add-own-charity-button:hover {
            border-color: #718096;
            color: #2d3748;
            background-color: #ebf4ff;
        }

        .add-own-charity-button svg {
            margin-right: 0.5rem;
        }

        /* Sidebar styles (Inheriting your estate) */
        .inheritance-summary-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content;
            /* Ensure it doesn't take full height if content is small */
            position: sticky;
            /* Makes it stick when scrolling */
            top: 1.5rem;
            /* Distance from top of viewport */
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

        /* Modal specific styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-content {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            width: 90%;
            max-width: 500px;
            padding: 1.5rem;
            position: relative;
            transform: translateY(-20px);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .modal-header h3 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #1a202c;
        }

        .modal-close-button {
            background: none;
            border: none;
            cursor: pointer;
            padding: 0.5rem;
            color: #a0aec0;
        }

        .modal-close-button:hover {
            color: #718096;
        }

        .modal-body label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        .modal-body input[type="text"],
        .modal-body input[type="email"] {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            font-size: 1rem;
            color: #4a5568;
            outline: none;
            transition: border-color 0.2s ease;
        }

        .modal-body input[type="text"]:focus,
        .modal-body input[type="email"]:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
            margin-top: 1.5rem;
        }

        .btn-secondary {
            background-color: #e2e8f0;
            color: #2d3748;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background-color: #cbd5e0;
        }

        .btn-primary {
            background-color: #4299e1;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: #2b6cb0;
        }

        /* Utility class for hiding elements */
        .hidden {
            display: none !important;
        }

        /* Specific styles for the "Back to search for a charity" link in manual add modal */
        .manual-add-charity-section .back-to-search {
            display: block;
            color: #4299e1;
            /* Blue link color */
            text-decoration: none;
            font-weight: 600;
            margin-bottom: 1.5rem;
            cursor: pointer;
        }

        .manual-add-charity-section .back-to-search:hover {
            text-decoration: underline;
        }

        /* Styles for the "I do not know the charity number" expandable section */
        .charity-number-toggle {
            cursor: pointer;
            display: flex;
            align-items: center;
            margin-top: 1rem;
            color: #4a5568;
            font-weight: 600;
        }

        .charity-number-toggle svg {
            margin-right: 0.5rem;
            transition: transform 0.2s ease;
        }

        .charity-number-toggle.expanded svg {
            transform: rotate(90deg);
        }

        .charity-number-details {
            margin-top: 1rem;
            padding-left: 1.5rem;
            /* Indent the content slightly */
            border-left: 2px solid #e2e8f0;
            /* Visual cue for expanded section */
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-7">{{-- Main content area --}}
                        <div class="card height-equal">
                            <div class="card-header">
                                Charity Gifts
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form action="{{route('partner.will_generator.process_inherited_charity')}}" method="POST">
                                    @csrf

                                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                        Would you like to leave a gift to charity?
                                    </h1>
                                    <p class="text-gray-700 leading-relaxed mb-6">
                                        Many people leave part of their estate to charity to give back to
                                        causes they're passionate about.
                                    </p>

                                    {{-- Yes/No Buttons --}}
                                    <div class="yes-no-button-container">
                                        <button type="button" id="yesButton" class="yes-no-button selected"
                                            data-value="yes">Yes</button>
                                        <button type="button" id="noButton" class="yes-no-button"
                                            data-value="no">No</button>
                                        <input type="hidden" name="leave_to_charity" id="leaveToCharityInput"
                                            value="yes">
                                    </div>

                                    {{-- Charity Selection Grid (initially visible if "Yes" is selected) --}}
                                    <div id="charitySelectionContainer">
                                        <div class="charity-grid">
                                            {{-- Example Charity 1: Macmillan Cancer Support --}}
                                            <label for="macmillan" class="charity-item">
                                                <input type="checkbox" id="macmillan" name="charities[]" value="macmillan"
                                                    checked>
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 2: RNLI Lifeguards (with separate "Lifeguards" text) --}}
                                            <label for="rnli" class="charity-item">
                                                <input type="checkbox" id="rnli" name="charities[]" value="rnli"
                                                    checked>
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3-eu-west-1.amazonaws.com/site/charity_assets/royal_national_lifeboat_institution.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 3: Great Ormond Street Hospital Charity --}}
                                            <label for="gosh" class="charity-item">
                                                <input type="checkbox" id="gosh" name="charities[]" value="gosh">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 4: Marie Curie --}}
                                            <label for="marieCurie" class="charity-item">
                                                <input type="checkbox" id="marieCurie" name="charities[]"
                                                    value="marie_curie">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 5: Shelter --}}
                                            <label for="shelter" class="charity-item">
                                                <input type="checkbox" id="shelter" name="charities[]" value="shelter">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 6: Alzheimer's Society --}}
                                            <label for="alzheimers" class="charity-item">
                                                <input type="checkbox" id="alzheimers" name="charities[]"
                                                    value="alzheimers">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 7: WWF --}}
                                            <label for="wwf" class="charity-item">
                                                <input type="checkbox" id="wwf" name="charities[]" value="wwf">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 8: NSPCC --}}
                                            <label for="nspcc" class="charity-item">
                                                <input type="checkbox" id="nspcc" name="charities[]" value="nspcc">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 9: British Heart Foundation --}}
                                            <label for="bhf" class="charity-item">
                                                <input type="checkbox" id="bhf" name="charities[]" value="bhf">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                            {{-- Example Charity 10: Action for Children --}}
                                            <label for="actionForChildren" class="charity-item">
                                                <input type="checkbox" id="actionForChildren" name="charities[]"
                                                    value="action_for_children">
                                                <div class="charity-logo-wrapper">
                                                    <img alt="" class="charity-logo"
                                                        src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                                </div>
                                            </label>

                                        </div>

                                        {{-- Other Charities (non-logo based) --}}
                                        <div class="mt-6 space-y-3">
                                            <div id="charity_manual">
                                            @foreach ($charities as $charity)
                                                <label for="{{ $charity->name }}" class="charity-text-item">
                                                    <input type="checkbox" id="{{ $charity->name }}" name="charities[]"
                                                        value="{{ $charity->id }}" checked>
                                                    <div class="charity-text-details">
                                                        <span class="charity-text-name">{{ $charity->name }}</span>
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        </div>

                                        {{-- Add your own charity button --}}
                                        <button type="button" class="add-own-charity-button"
                                            id="addYourOwnCharityButton">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Add your own charity
                                        </button>
                                    </div> {{-- End charitySelectionContainer --}}

                                    <div class="d-flex justify-content-between mt-8">
                                        <a href="{{ route('partner.will_generator.choose_inherited_persons') }}"
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

                    <div class="col-xl-5"> {{-- Sidebar area --}}
                        <div class="inheritance-summary-card">
                            <h4>Inheriting your estate:</h4>
                            <ul id="inheritanceSummaryList">
                                @foreach( $inheritedPersons as $person)
                                    <li>{{ $person->name }}</li>
                                @endforeach
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Charity Modal --}}
    <div id="charityModal" class="modal-overlay"> {{-- Added 'modal-overlay' for general modal styling --}}
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add a new charity</h3>
                <button type="button" class="modal-close-button" id="closeCharityModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- SEARCH CHARITY SECTION (Initially visible when modal opens) --}}
            <div id="searchCharitySection" class="modal-body">
                <label for="charitySearchInput">Search for a charity</label>
                <input type="text" id="charitySearchInput" placeholder="e.g. Macmillan Cancer Support">
                <div class="text-xs text-gray-500 mt-1">e.g. Macmillan Cancer Support</div>

                {{-- Search Results Placeholder --}}
                <div id="searchResults" class="mt-4">
                    {{-- Dynamic results will be inserted here --}}
                    <div class="no-results-message text-red-500 text-sm mt-2 hidden">No results returned for ""</div>
                </div>

                <div class="text-center mt-6">
                    <p class="text-gray-600 mb-2">Can't find your charity?</p>
                    <button type="button" class="btn-primary inline-flex items-center justify-center px-4 py-2"
                        id="openManualAddCharityButton">
                        Enter charity information manually
                    </button>
                </div>
            </div>

            {{-- MANUAL ADD CHARITY SECTION (Initially hidden) --}}
            <div id="manualAddCharitySection" class="modal-body hidden">
                <a href="#" class="back-to-search" id="backToSearchCharityLink">&larr; Back to search for a
                    charity</a>

                <form id="addManualCharityForm">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="manualCharityName">Your charity's name</label>
                        <input type="text" class="form-control" name="name" id="manualCharityName"
                            placeholder="e.g. Macmillan Cancer Support" required>
                        <div class="text-xs text-gray-500 mt-1">e.g. Macmillan Cancer Support</div>
                        <div class="text-danger text-sm mt-1" id="manual-error-name"></div>
                    </div>
                    <div class="form-group mb-4">
                        <label for="manualRegistrationNumber">Registered charity number (6 or 7 digits)</label>
                        <input type="text" class="form-control" name="registration_number"
                            id="manualRegistrationNumber" placeholder="e.g. 261017">
                        <div class="text-xs text-gray-500 mt-1">e.g. 261017</div>
                        <div class="text-danger text-sm mt-1" id="manual-error-registration_number"></div>

                        <div class="charity-number-toggle" id="charityNumberToggle">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4 transform transition-transform duration-200" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            I do not know the charity number
                        </div>
                        <div class="charity-number-details hidden">
                            <p class="text-sm text-gray-600 mt-2">
                                Most charities are registered with the Charity Commission. You can often find their
                                registration number on their website or by searching the Charity Commission's online
                                register.
                            </p>
                            <a href="https://www.gov.uk/find-charity-information" target="_blank"
                                class="text-blue-600 text-sm mt-2 inline-block">Find a charity on GOV.UK</a>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-center">
                        <button type="submit" class="btn-primary inline-flex items-center justify-center px-6 py-2">Save
                            charity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
      
            const yesButton = document.getElementById('yesButton');
            const noButton = document.getElementById('noButton');
            const leaveToCharityInput = document.getElementById('leaveToCharityInput');
            const charitySelectionContainer = document.getElementById('charitySelectionContainer');
            const inheritedPersonsHTML = document.createElement('div');
        inheritedPersonsHTML.innerHTML = document.getElementById('inheritanceSummaryList').innerHTML;
            if (yesButton && noButton && leaveToCharityInput && charitySelectionContainer) {
                yesButton.addEventListener('click', function() {
                    yesButton.classList.add('selected');
                    noButton.classList.remove('selected');
                    leaveToCharityInput.value = 'yes';
                    charitySelectionContainer.classList.remove('hidden');
                });

                noButton.addEventListener('click', function() {
                    noButton.classList.add('selected');
                    yesButton.classList.remove('selected');
                    leaveToCharityInput.value = 'no';
                    charitySelectionContainer.classList.add('hidden');
                });

                if (leaveToCharityInput.value === 'no') {
                    charitySelectionContainer.classList.add('hidden');
                    noButton.classList.add('selected');
                    yesButton.classList.remove('selected');
                } else {
                    charitySelectionContainer.classList.remove('hidden');
                    yesButton.classList.add('selected');
                    noButton.classList.remove('selected');
                }
            }

            document.querySelectorAll('.charity-item, .charity-text-item').forEach(item => {
            const checkbox = item.querySelector('input[type="checkbox"]');
            item.addEventListener('click', function(e) {
                if (e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                }
                updateInheritanceSummary(inheritedPersonsHTML);
            });
            checkbox.addEventListener('change', () => updateInheritanceSummary(inheritedPersonsHTML));
        });

            function updateInheritanceSummary(initialList) {
            const summaryList = document.getElementById('inheritanceSummaryList');
            if (!summaryList) return;

            // 1. Clear the entire list first
            summaryList.innerHTML = '';
            
            // 2. Add the inherited persons back
            summaryList.innerHTML = initialList.innerHTML;

            // 3. Add all selected charities (both pre-defined and manual)
            document.querySelectorAll(
                '.charity-item input[type="checkbox"]:checked, .charity-text-item input[type="checkbox"]:checked'
            ).forEach(checkbox => {
                let charityName = 'Unnamed Charity';
                const parentItem = checkbox.closest('.charity-item, .charity-text-item');

                if (parentItem) {
                    const textNameElement = parentItem.querySelector('.charity-text-name');
                    if (textNameElement) {
                        charityName = textNameElement.textContent.trim();
                    } else {
                        const charityId = checkbox.value;
                        switch (charityId) {
                            case 'macmillan': charityName = 'Macmillan Cancer Support'; break;
                            case 'rnli': charityName = 'The RNLI'; break;
                            case 'gosh': charityName = 'Great Ormond Street Hospital Charity'; break;
                            case 'marie_curie': charityName = 'Marie Curie'; break;
                            case 'shelter': charityName = 'Shelter'; break;
                            case 'alzheimers': charityName = 'Alzheimer\'s Society'; break;
                            case 'wwf': charityName = 'WWF'; break;
                            case 'nspcc': charityName = 'NSPCC'; break;
                            case 'bhf': charityName = 'British Heart Foundation'; break;
                            case 'action_for_children': charityName = 'Action for Children'; break;
                            default: charityName = checkbox.value; break; // Fallback
                        }
                    }
                }
                
                // Add the charity to the summary list
                const listItem = document.createElement('li');
                listItem.textContent = charityName;
                summaryList.appendChild(listItem);
            });
        }
        
        // Call the function once on page load to set the initial state
        updateInheritanceSummary(inheritedPersonsHTML);
            const charityModal = document.getElementById('charityModal');
            const closeCharityModalButton = document.getElementById('closeCharityModal');
            const addYourOwnCharityButton = document.getElementById('addYourOwnCharityButton'); // Main page button

            const searchCharitySection = document.getElementById('searchCharitySection');
            const manualAddCharitySection = document.getElementById('manualAddCharitySection');
            const openManualAddCharityButton = document.getElementById(
            'openManualAddCharityButton'); // Button inside search modal
            const backToSearchCharityLink = document.getElementById(
                'backToSearchCharityLink'); // Link inside manual add modal

            const modalTitle = document.getElementById('modalTitle');
            const charitySearchInput = document.getElementById('charitySearchInput');
            const searchResults = document.getElementById('searchResults');
            const noResultsMessage = searchResults.querySelector('.no-results-message');

            function openCharityModal() {
                charityModal.classList.add('active'); 
                showSearchCharitySection(); 
            }

            function closeCharityModal() {
                charityModal.classList.remove('active'); 
                charitySearchInput.value = '';
                document.getElementById('manualCharityName').value = '';
                document.getElementById('manualRegistrationNumber').value = '';
                const manualCharityEmail = document.getElementById('manualCharityEmail');
                if (manualCharityEmail) {
                    manualCharityEmail.value = '';
                }
               
                noResultsMessage.classList.add('hidden');
               
                document.getElementById('manual-error-name').textContent = '';
                document.getElementById('manual-error-registration_number').textContent = '';
                const manualErrorEmail = document.getElementById('manual-error-email');
                if (manualErrorEmail) {
                    manualErrorEmail.textContent = '';
                }
                searchResults.innerHTML = '';
                noResultsMessage.textContent = 'No results returned for ""'; 
            }

            function showSearchCharitySection() {
                manualAddCharitySection.classList.add('hidden');
                searchCharitySection.classList.remove('hidden');
                modalTitle.textContent = 'Add a new charity';
            }

            // Function to show the manual add charity section
            function showManualAddCharitySection() {
                searchCharitySection.classList.add('hidden');
                manualAddCharitySection.classList.remove('hidden');
                modalTitle.textContent = 'Add a new charity'; 
                const charityNumberToggle = document.getElementById('charityNumberToggle');
                const charityNumberDetails = document.querySelector('.charity-number-details');
                if (charityNumberToggle) { 
                    charityNumberToggle.classList.remove('expanded');
                }
                if (charityNumberDetails) { 
                    charityNumberDetails.classList.add('hidden');
                }
            }
            if (addYourOwnCharityButton) {
                addYourOwnCharityButton.addEventListener('click', openCharityModal);
            }
            closeCharityModalButton.addEventListener('click', closeCharityModal);
            openManualAddCharityButton.addEventListener('click', showManualAddCharitySection);
            backToSearchCharityLink.addEventListener('click', function(e) {
                e.preventDefault(); 
                showSearchCharitySection();
            });

            charityModal.addEventListener('click', function(e) {
                if (e.target === charityModal) {
                    closeCharityModal();
                }
            });

         
            const charityNumberToggle = document.getElementById('charityNumberToggle');
            const charityNumberDetails = document.querySelector('.charity-number-details');

            if (charityNumberToggle) { // Check if element exists
                charityNumberToggle.addEventListener('click', function() {
                    charityNumberToggle.classList.toggle('expanded');
                    if (charityNumberDetails) {
                        charityNumberDetails.classList.toggle('hidden');
                    }
                });
            }


            const addManualCharityForm = document.getElementById('addManualCharityForm');
            $(addManualCharityForm).on('submit', function(e) {
                e.preventDefault();

                const charityNameInput = document.getElementById('manualCharityName');
                const charityRegistrationNumberInput = document.getElementById('manualRegistrationNumber');
                const charityEmailInput = document.getElementById(
                'manualCharityEmail'); 

                let isValid = true;

                // Clear previous errors
                $('#manual-error-name').text('');
                $('#manual-error-registration_number').text('');
                
                const manualErrorEmailSpan = $('#manual-error-email');
                if (manualErrorEmailSpan.length) {
                    manualErrorEmailSpan.text('');
                }

                if (charityNameInput.value.trim() === '') {
                    $('#manual-error-name').text('Charity Name is required.');
                    isValid = false;
                }
                const regNumber = charityRegistrationNumberInput.value.trim();
                // Basic validation for registration number (e.g., if it's not empty, it should be digits)
                if (regNumber !== '' && !/^\d+$/.test(regNumber)) {
                    $('#manual-error-registration_number').text(
                        'Registration number must contain only digits.');
                    isValid = false;
                }


                if (isValid) {
                    const charityData = {
                        name: charityNameInput.value.trim(),
                        registration_number: regNumber,
                       
                        email: charityEmailInput ? charityEmailInput.value.trim() : ''
                    };
                    const csrfToken = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: "{{ route('partner.will_generator.store_charity') }}",
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },
                        contentType: 'application/json',
                        data: JSON.stringify(charityData),
                        dataType: 'json',
                        success: function(response) {
                            closeCharityModal();
                            $("#charity_manual").html(response.data);

                            if (response.charity && response.charity.name) {
                             
                                updateInheritanceSummary
                            (); 
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error adding charity:', jqXHR.responseJSON || jqXHR
                                .responseText || errorThrown);

                            const responseData = jqXHR.responseJSON;

                            if (jqXHR.status === 422 && responseData && responseData.errors) {
                                // Handle Laravel validation errors
                                for (const field in responseData.errors) {
                                    const errorSpan = $(`#manual-error-${field}`);
                                    if (errorSpan.length) {
                                        errorSpan.text(responseData.errors[field][0]);
                                    }
                                }
                            } else {
                                const errorMessage = responseData && responseData.message ?
                                    responseData.message : 'An unknown error occurred.';
                                Swal.fire({ // Changed alert to SweetAlert2
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Failed to add charity: ' + errorMessage
                                });
                                // You might still want to display generic error under a field or as a general modal error
                                $('#manual-error-name').text(errorMessage).css('color', 'red');
                            }
                        }
                    });
                }
            });

            charitySearchInput.addEventListener('input', function() {
                const query = this.value.trim();
                // Clear previous search results
                searchResults.innerHTML = '';
                noResultsMessage.classList.add('hidden'); // Always hide initially on new input

                if (query.length > 0) {
                    // Simulate search results based on a simple condition
                    if (query.toLowerCase().includes('dgdg')) {
                        noResultsMessage.classList.remove('hidden');
                        noResultsMessage.textContent =
                        `No results returned for "${query}"`; // Update message
                    } else if (query.toLowerCase().includes('macmillan')) {
                        // Simulate a found result
                        searchResults.innerHTML = `
                        <div class="p-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100" data-charity-id="macmillan_search" data-charity-name="Macmillan Cancer Support (Search)">
                            Macmillan Cancer Support (Registered: 261017)
                        </div>
                    `;
                        
                    }
                   
                } else {
                    noResultsMessage.classList.add('hidden');
                    searchResults.innerHTML = ''; // Clear results if input is empty
                }
            });

        }); 
    </script>
@endsection
