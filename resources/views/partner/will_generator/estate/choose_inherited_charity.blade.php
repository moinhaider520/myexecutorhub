I apologize for the previous code not meeting your expectations. I understand you want to implement a flow where users can either search for a charity or, if not found, manually add the charity's details, with the modal changing accordingly.

Let's refine the frontend code to achieve this. We'll implement two distinct modals and manage their visibility with JavaScript.

Here's the revised Blade template and JavaScript, incorporating the search and manual add modals:

```blade
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
                            <form action="#" method="POST">
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
                                    <button type="button" id="yesButton" class="yes-no-button selected" data-value="yes">Yes</button>
                                    <button type="button" id="noButton" class="yes-no-button" data-value="no">No</button>
                                    <input type="hidden" name="leave_to_charity" id="leaveToCharityInput" value="yes">
                                </div>

                                {{-- Charity Selection Grid (initially visible if "Yes" is selected) --}}
                                <div id="charitySelectionContainer">
                                    <div class="charity-grid">
                                        {{-- Example Charity 1: Macmillan Cancer Support --}}
                                        <label for="macmillan" class="charity-item">
                                            <input type="checkbox" id="macmillan" name="charities[]" value="macmillan" checked>
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 2: RNLI Lifeguards (with separate "Lifeguards" text) --}}
                                        <label for="rnli" class="charity-item">
                                            <input type="checkbox" id="rnli" name="charities[]" value="rnli" checked>
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3-eu-west-1.amazonaws.com/site/charity_assets/royal_national_lifeboat_institution.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 3: Great Ormond Street Hospital Charity --}}
                                        <label for="gosh" class="charity-item">
                                            <input type="checkbox" id="gosh" name="charities[]" value="gosh">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 4: Marie Curie --}}
                                        <label for="marieCurie" class="charity-item">
                                            <input type="checkbox" id="marieCurie" name="charities[]" value="marie_curie">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 5: Shelter --}}
                                        <label for="shelter" class="charity-item">
                                            <input type="checkbox" id="shelter" name="charities[]" value="shelter">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 6: Alzheimer's Society --}}
                                        <label for="alzheimers" class="charity-item">
                                            <input type="checkbox" id="alzheimers" name="charities[]" value="alzheimers">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 7: WWF --}}
                                        <label for="wwf" class="charity-item">
                                            <input type="checkbox" id="wwf" name="charities[]" value="wwf">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 8: NSPCC --}}
                                        <label for="nspcc" class="charity-item">
                                            <input type="checkbox" id="nspcc" name="charities[]" value="nspcc">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 9: British Heart Foundation --}}
                                        <label for="bhf" class="charity-item">
                                            <input type="checkbox" id="bhf" name="charities[]" value="bhf">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                        {{-- Example Charity 10: Action for Children --}}
                                        <label for="actionForChildren" class="charity-item">
                                            <input type="checkbox" id="actionForChildren" name="charities[]" value="action_for_children">
                                            <div class="charity-logo-wrapper">
                                                <img alt="" class="charity-logo" src="https://farewill-app.s3.eu-west-1.amazonaws.com/site/charity_assets/macmillan_cancer_support_1686228850951.png">
                                            </div>
                                        </label>

                                    </div>

                                    {{-- Other Charities (non-logo based) --}}
                                    <div class="mt-6 space-y-3">
                                        <label for="edhiFoundation" class="charity-text-item">
                                            <input type="checkbox" id="edhiFoundation" name="charities[]" value="edhi_foundation" checked>
                                            <div class="charity-text-details">
                                                <span class="charity-text-name">Edhi International Foundation UK</span>
                                            </div>
                                        </label>

                                        <label for="sdfsfw34234" class="charity-text-item">
                                            <input type="checkbox" id="sdfsfw34234" name="charities[]" value="sdfsfw34234">
                                            <div class="charity-text-details">
                                                <span class="charity-text-name">sdfsfw34234</span>
                                            </div>
                                        </label>

                                        <label for="charitiesAidFoundation" class="charity-text-item">
                                            <input type="checkbox" id="charitiesAidFoundation" name="charities[]" value="charities_aid_foundation" checked>
                                            <div class="charity-text-details">
                                                <span class="charity-text-name">The Charities Aid Foundation</span>
                                            </div>
                                        </label>
                                    </div>

                                    {{-- Add your own charity button --}}
                                    <button type="button" class="add-own-charity-button" id="addYourOwnCharityButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                            {{-- These items will be dynamically updated by JavaScript --}}
                            {{-- Initial items for demo, based on your screenshot's summary --}}
                            <li>Keane Woodward</li>
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
    </div>
</div>

{{-- SEARCH CHARITY MODAL --}}
<div id="searchCharityModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add a new charity</h3>
            <button type="button" class="modal-close-button" id="closeSearchCharityModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <label for="charitySearchInput">Search for a charity</label>
            <input type="text" id="charitySearchInput" placeholder="Enter charity name or registration number">
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" id="searchCharityButton">Search</button>
            </div>
            <div class="text-center mt-3">
                <p>Can't find it?</p>
                <button type="button" class="btn btn-primary" id="openManualAddCharityModal">Add your own charity</button>
            </div>
        </div>
    </div>
</div>

{{-- MANUAL ADD CHARITY MODAL --}}
<div id="manualAddCharityModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add your own charity details</h3>
            <button type="button" class="modal-close-button" id="closeManualAddCharityModal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div class="modal-body">
            <form id="addManualCharityForm">
                @csrf
                <div class="form-group mb-3">
                    <label for="manualCharityName">Charity Name</label>
                    <input type="text" class="form-control" name="name" id="manualCharityName" placeholder="Enter charity name" required>
                    <div class="text-danger" id="manual-error-name"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="manualRegistrationNumber">Registration Number (Optional)</label>
                    <input type="text" class="form-control" name="registration_number" id="manualRegistrationNumber" placeholder="Enter registration number">
                    <div class="text-danger" id="manual-error-registration_number"></div>
                </div>
                <div class="form-group mb-3">
                    <label for="manualCharityEmail">Email Address (Optional)</label>
                    <input type="email" class="form-control" name="email" id="manualCharityEmail" placeholder="Enter email address">
                    <div class="text-danger" id="manual-error-email"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="backToSearchCharityModal">Back to Search</button>
                    <button type="submit" class="btn btn-primary">Add Charity</button>
                </div>
            </form>
        </div>
    </div>
</div>


{{-- Scripts --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
{{-- You might not need Popper.js and Bootstrap JS if you're using pure Tailwind for modals --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script> --}}
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // --- Yes/No Button Logic ---
        $('#yesButton').on('click', function() {
            $(this).addClass('selected');
            $('#noButton').removeClass('selected');
            $('#leaveToCharityInput').val('yes');
            $('#charitySelectionContainer').show(); // Show charity selection
            updateInheritanceSummary(); // Update summary
        });

        $('#noButton').on('click', function() {
            $(this).addClass('selected');
            $('#yesButton').removeClass('selected');
            $('#leaveToCharityInput').val('no');
            $('#charitySelectionContainer').hide(); // Hide charity selection
            $('input[name="charities[]"]:checked').prop('checked', false); // Uncheck all selected charities
            updateInheritanceSummary(); // Update summary to reflect no charities
        });

        // Initial state based on the value (assuming "Yes" by default as per screenshot)
        if ($('#leaveToCharityInput').val() === 'yes') {
            $('#yesButton').addClass('selected');
            $('#charitySelectionContainer').show();
        } else {
            $('#noButton').addClass('selected');
            $('#charitySelectionContainer').hide();
        }

        // --- Inheritance Summary Update Logic ---
        function updateInheritanceSummary() {
            const summaryList = $('#inheritanceSummaryList');
            summaryList.empty(); // Clear existing list

            // Add people from the previous step (hardcoded for demo based on screenshot)
            summaryList.append('<li>Keane Woodward</li>');
            summaryList.append('<li>Thane Dillard</li>');
            summaryList.append('<li>Lane Rodgers</li>');

            // Add selected charities if "Yes" is chosen
            if ($('#leaveToCharityInput').val() === 'yes') {
                $('input[name="charities[]"]:checked').each(function() {
                    let charityName;
                    // For logo-based charities
                    if ($(this).closest('.charity-item').length) {
                        const mainName = $(this).closest('.charity-item').find('.charity-name').text();
                        const additionalText = $(this).closest('.charity-item').find('.charity-additional-text').text();
                        // If additional text exists (like "Lifeguards"), prepend it
                        charityName = additionalText ? `${additionalText} ${mainName}` : mainName;
                    }
                    // For text-based charities
                    else if ($(this).closest('.charity-text-item').length) {
                        charityName = $(this).closest('.charity-text-item').find('.charity-text-name').text();
                    }

                    if (charityName) {
                        summaryList.append(`<li>${charityName}</li>`);
                    }
                });
            }

            if (summaryList.children().length === 0) {
                summaryList.append('<li>None selected</li>'); // Or a more appropriate message
            }
        }

        // Initial update when the page loads
        updateInheritanceSummary();

        // Update summary when a charity checkbox is changed
        $('input[name="charities[]"]').on('change', function() {
            updateInheritanceSummary();
        });

        // --- Modal Logic ---
        const searchCharityModal = $('#searchCharityModal');
        const manualAddCharityModal = $('#manualAddCharityModal');

        const addYourOwnCharityButton = $('#addYourOwnCharityButton');
        const closeSearchCharityModalButton = $('#closeSearchCharityModal');
        const openManualAddCharityModalButton = $('#openManualAddCharityModal');
        const closeManualAddCharityModalButton = $('#closeManualAddCharityModal');
        const backToSearchCharityModalButton = $('#backToSearchCharityModal');

        // Open search charity modal
        addYourOwnCharityButton.on('click', function() {
            searchCharityModal.addClass('active');
        });

        // Close search charity modal
        closeSearchCharityModalButton.on('click', function() {
            searchCharityModal.removeClass('active');
            $('#charitySearchInput').val(''); // Clear search input
        });

        // Open manual add charity modal from search modal
        openManualAddCharityModalButton.on('click', function() {
            searchCharityModal.removeClass('active');
            manualAddCharityModal.addClass('active');
        });

        // Close manual add charity modal
        closeManualAddCharityModalButton.on('click', function() {
            manualAddCharityModal.removeClass('active');
            $('#addManualCharityForm')[0].reset(); // Clear form
            $('.text-danger').text(''); // Clear validation errors
        });

        // Back to search charity modal from manual add modal
        backToSearchCharityModalButton.on('click', function() {
            manualAddCharityModal.removeClass('active');
            searchCharityModal.addClass('active');
            $('#addManualCharityForm')[0].reset(); // Clear manual form
            $('.text-danger').text(''); // Clear validation errors
        });


        // Close modals when clicking outside of them
        searchCharityModal.on('click', function(e) {
            if ($(e.target).is(searchCharityModal)) {
                searchCharityModal.removeClass('active');
                $('#charitySearchInput').val(''); // Clear search input
            }
        });

        manualAddCharityModal.on('click', function(e) {
            if ($(e.target).is(manualAddCharityModal)) {
                manualAddCharityModal.removeClass('active');
                $('#addManualCharityForm')[0].reset(); // Clear form
                $('.text-danger').text(''); // Clear validation errors
            }
        });

        // Close modals with Escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                if (searchCharityModal.hasClass('active')) {
                    searchCharityModal.removeClass('active');
                    $('#charitySearchInput').val('');
                } else if (manualAddCharityModal.hasClass('active')) {
                    manualAddCharityModal.removeClass('active');
                    $('#addManualCharityForm')[0].reset();
                    $('.text-danger').text('');
                }
            }
        });

        // --- AJAX for adding manual charity ---
        $('#addManualCharityForm').on('submit', function(e) {
            e.preventDefault();

            // Clear previous errors
            $('.text-danger').text('');

            const formData = $(this).serialize();

            $.ajax({
                url: '#', // Adjust this to your actual route for storing charities
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Charity Added!',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            manualAddCharityModal.removeClass('active');
                            $('#addManualCharityForm')[0].reset();
                            // Optionally, append the new charity to the list on the main page
                            // This would involve creating a new charity-text-item element
                            const newCharityHtml = `
                                <label for="charity_${response.charity.id}" class="charity-text-item">
                                    <input type="checkbox" id="charity_${response.charity.id}" name="charities[]" value="${response.charity.id}" checked>
                                    <div class="charity-text-details">
                                        <span class="charity-text-name">${response.charity.name}</span>
                                        ${response.charity.registration_number ? `<span class="charity-text-registration">${response.charity.registration_number}</span>` : ''}
                                    </div>
                                </label>
                            `;
                            // Prepend or append to an appropriate container, e.g., the last div in charitySelectionContainer
                            $('#charitySelectionContainer .space-y-3:last').append(newCharityHtml);
                            updateInheritanceSummary(); // Refresh the summary list
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: response.message || 'Something went wrong.',
                        });
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) { // Validation errors
                        const errors = xhr.responseJSON.errors;
                        for (const field in errors) {
                            if (errors.hasOwnProperty(field)) {
                                $(`#manual-error-${field}`).text(errors[field][0]);
                            }
                        }
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'An error occurred while adding the charity. Please try again.',
                        });
                    }
                }
            });
        });

        // --- Placeholder for Search Functionality (backend integration needed) ---
        $('#searchCharityButton').on('click', function() {
            const searchTerm = $('#charitySearchInput').val();
            if (searchTerm.trim() === '') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Search Empty',
                    text: 'Please enter a charity name or registration number to search.',
                });
                return;
            }
            console.log("Searching for charity:", searchTerm);
            // In a real application, you would make an AJAX call here
            // to your backend to search for charities.
            // Example:
            /*
            $.ajax({
                url: '/api/search-charities', // Your API endpoint
                method: 'GET',
                data: { query: searchTerm },
                success: function(response) {
                    if (response.charities && response.charities.length > 0) {
                        // Display search results in the modal, possibly in a scrollable area
                        // If a charity is found and selected, you might close this modal
                        // and add it to the main list.
                        console.log('Search results:', response.charities);
                        Swal.fire('Found Charities', 'Displaying search results...', 'info');
                        // Example: populate a results div within searchCharityModal
                        // $('#searchResultsDiv').empty();
                        // response.charities.forEach(charity => {
                        //     $('#searchResultsDiv').append(`<p>${charity.name} (${charity.registration_number})</p>`);
                        // });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'No Charity Found',
                            text: 'No charities matched your search. Please try a different term or add your own.',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Search Error',
                        text: 'Failed to perform search. Please try again later.',
                    });
                }
            });
            */
            // For now, simulate no results and suggest manual add
            Swal.fire({
                icon: 'info',
                title: 'No Charity Found',
                text: 'No charities matched your search. Please try a different term or click "Add your own charity".',
            });
        });
    });
</script>
@endsection
```