@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Custom styles for the checkbox and edit button layout */
        .person-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            margin-bottom: 0.75rem;
            background-color: #fff;
        }

        .person-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .person-info input[type="checkbox"] {
            margin-right: 1rem;
            width: 1.25rem; /* Make checkbox larger */
            height: 1.25rem;
            cursor: pointer;
        }

        .person-details {
            display: flex;
            flex-direction: column;
        }

        .person-name {
            font-weight: 600; /* Semi-bold */
            color: #1a202c; /* Dark text */
        }

        .person-additional-info {
            font-size: 0.875rem; /* Small text */
            color: #4a5568; /* Gray text */
        }

        .edit-button {
            background: none;
            border: none;
            color: #4299e1; /* Blue for links/actions */
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.9rem;
            padding: 0; /* Remove default button padding */
            margin-left: 1rem; /* Space from content */
        }

        .edit-button:hover {
            color: #2b6cb0; /* Darker blue on hover */
        }

        .add-new-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border: 1px dashed #a0aec0; /* Dashed gray border */
            border-radius: 0.375rem;
            color: #4a5568;
            background-color: #f7fafc; /* Light background */
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 1.5rem;
        }

        .add-new-button:hover {
            border-color: #718096;
            color: #2d3748;
            background-color: #ebf4ff;
        }

        .add-new-button svg {
            margin-right: 0.5rem;
        }

        .inheritance-summary-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
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

        /* Adjustments for the main content width */
        .main-content-col {
            flex: 0 0 66.666667%; /* Equivalent to col-xl-8 */
            max-width: 66.666667%;
        }

        .sidebar-col {
            flex: 0 0 33.333333%; /* Equivalent to col-xl-4 */
            max-width: 33.333333%;
        }

        /* To center content vertically if it's less than full height */
        .height-equal {
            min-height: auto; /* Override default to prevent excessive height */
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8 main-content-col"> {{-- Adjusted column width for the main content --}}
                        <div class="card height-equal">
                            <div class="card-header">
                                Inheritors
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <form action="#" method="POST">
                                    @csrf

                                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                        Who would you like to inherit your estate?
                                    </h1>
                                    <p class="text-gray-700 leading-relaxed mb-6">
                                        You can decide how much each person gets in the next step. You'll
                                        also be able to choose backups in case any of them die before you.
                                    </p>

                                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                                        Select a person or add someone new
                                    </h2>

                                    {{-- Existing People/Charities List --}}
                                    <div class="space-y-3 mb-6">
                                        {{-- Example Person 1 (Keane Woodward) --}}
                                        <label for="keaneWoodward" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="keaneWoodward" name="inheritors[]" value="keane_woodward" checked>
                                                <div class="person-details">
                                                    <span class="person-name">Keane Woodward</span>
                                                    <span class="person-additional-info">dashoccsaur@mailinator.com</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>

                                        {{-- Example Person 2 (Thane Dillard) --}}
                                        <label for="thaneDillard" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                {{-- Added checkmark icon inside the checkbox for visual consistency with screenshot --}}
                                                <input type="checkbox" id="thaneDillard" name="inheritors[]" value="thane_dillard" checked>
                                                <div class="person-details">
                                                    <span class="person-name">Thane Dillard</span>
                                                    <span class="person-additional-info">xyytyp@mailinator.com</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>

                                        {{-- Example Person 3 (Lane Rodgers) --}}
                                        <label for="laneRodgers" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="laneRodgers" name="inheritors[]" value="lane_rodgers" checked>
                                                <div class="person-details">
                                                    <span class="person-name">Lane Rodgers</span>
                                                    <span class="person-additional-info">ruici@mailinator.com</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>

                                        {{-- Example Person 4 (Melyssa Workman - Unchecked) --}}
                                        <label for="melyssaWorkman" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="melyssaWorkman" name="inheritors[]" value="melyssa_workman">
                                                <div class="person-details">
                                                    <span class="person-name">Melyssa Workman</span>
                                                    <span class="person-additional-info">23/09/1997</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>

                                        {{-- Example Person 5 (Timon Brock - Unchecked) --}}
                                        <label for="timonBrock" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="timonBrock" name="inheritors[]" value="timon_brock">
                                                <div class="person-details">
                                                    <span class="person-name">Timon Brock</span>
                                                    <span class="person-additional-info">nosic@mailinator.com</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>

                                        {{-- Example Person 6 (Blair Bruce - Unchecked) --}}
                                        <label for="blairBruce" class="person-item cursor-pointer">
                                            <div class="person-info">
                                                <input type="checkbox" id="blairBruce" name="inheritors[]" value="blair_bruce">
                                                <div class="person-details">
                                                    <span class="person-name">Blair Bruce</span>
                                                    <span class="person-additional-info">07/02/1980</span>
                                                </div>
                                            </div>
                                            <button type="button" class="edit-button">Edit</button>
                                        </label>
                                    </div>

                                    {{-- Add someone new button --}}
                                    <button type="button" class="add-new-button" id="addNewInheritor">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add someone new
                                    </button>

                                    <p class="text-gray-700 leading-relaxed mt-8 mb-4">
                                        If you'd prefer to leave your estate to charity instead, just save and
                                        continue to the next page.
                                    </p>

                                    <div class="d-flex justify-content-between mt-5">
                                        <a href="{{ route('partner.will_generator.estates') }}"
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

                    <div class="col-xl-4 sidebar-col"> {{-- Adjusted column width for the sidebar --}}
                        <div class="inheritance-summary-card">
                            <h4>Inheriting your estate:</h4>
                            <ul id="inheritanceSummaryList">
                                {{-- These items will be dynamically updated by JavaScript --}}
                                <li>Keane Woodward</li>
                                <li>Thane Dillard</li>
                                <li>Lane Rodgers</li>
                                <li>The RNLI</li>
                                <li>Macmillan Cancer Support</li>
                                <li>Esdhi International Foundation UK</li>
                                <li>The Charities Aid Foundation</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Include necessary scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Function to update the inheritance summary list
            function updateInheritanceSummary() {
                const summaryList = $('#inheritanceSummaryList');
                summaryList.empty(); // Clear existing list

                // Get checked inheritors from the form
                $('input[name="inheritors[]"]:checked').each(function() {
                    const personName = $(this).closest('.person-item').find('.person-name').text();
                    summaryList.append(`<li>${personName}</li>`);
                });

                // Add static charity/organization names (as they appear in the screenshot)
                // You might fetch these dynamically or have them pre-listed based on your application logic
                // For demonstration, these are hardcoded as they seem to be fixed examples in the screenshot's summary.
                if ($('input[name="inheritors[]"]:checked').length > 0) { // Only add if some people are selected
                    summaryList.append(`<li>The RNLI</li>`);
                    summaryList.append(`<li>Macmillan Cancer Support</li>`);
                    summaryList.append(`<li>Esdhi International Foundation UK</li>`);
                    summaryList.append(`<li>The Charities Aid Foundation</li>`);
                } else {
                    // If no people are selected, maybe display a message or only the charities if that's the default
                    // For now, if no people are checked, only charities will show if you modify this logic.
                    // Based on the screenshot, it shows both people and charities when people are selected.
                    // If no people are selected, the summary might be empty or show only "charity instead" message.
                }

                if (summaryList.children().length === 0) {
                    summaryList.append('<li>None selected</li>'); // Or a more appropriate message
                }
            }

            // Initial update when the page loads
            updateInheritanceSummary();

            
            $('input[name="inheritors[]"]').on('change', function() {
                updateInheritanceSummary();
            });

            // Handle "Add someone new" button click
            $('#addNewInheritor').on('click', function() {
                // Here you would typically open a modal or redirect to a page
                // to add a new person or charity.
                // For demonstration, we'll just show an alert.
                Swal.fire({
                    icon: 'info',
                    title: 'Add New Inheritor',
                    text: 'This would open a form to add a new person or charity.',
                    showConfirmButton: false,
                    timer: 2000
                });
    
            });

            // Handle "Edit" button clicks (these currently do nothing but trigger an alert)
            $('.edit-button').on('click', function(e) {
                e.preventDefault(); // Prevent default button action if inside a form
                const personName = $(this).siblings('.person-info').find('.person-name').text();
                Swal.fire({
                    icon: 'info',
                    title: 'Edit Person',
                    text: `This would open an edit form for ${personName}.`,
                    showConfirmButton: false,
                    timer: 2000
                });

            });
        });
    </script>
@endsection