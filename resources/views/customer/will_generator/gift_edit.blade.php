@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Using Tailwind CSS directly --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Your existing CSS styles remain here */
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
        .card-body {
            padding: 1.5rem;
        }

        /* Input field styles */
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #cbd5e0; /* Gray border */
            border-radius: 0.375rem; /* Rounded corners */
            font-size: 1rem;
            color: #2d3748;
            outline: none;
            transition: border-color 0.2s ease;
        }
        .form-input:focus {
            border-color: #4299e1; /* Blue border on focus */
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.5);
        }
        textarea.form-input {
            min-height: 8rem; /* Tall enough for messages */
            resize: vertical; /* Allow vertical resizing */
        }

        /* Specificity Guidance Styles */
        .guidance-section {
            margin-bottom: 1.5rem;
        }
        .guidance-section p {
            line-height: 1.5;
        }
        .guidance-section .font-semibold {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        .guidance-section .do-say {
            color: #2f855a; /* Green for "Do say" */
        }
        .guidance-section .dont-say {
            color: #e53e3e; /* Red for "Don't say" */
        }
        .guidance-section .bullet {
            font-weight: 700;
            margin-right: 0.5rem;
        }

        /* Executor Card Styles */
        .executor-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            margin-bottom: 0.75rem;
            background-color: #fff;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }
        .executor-card:hover {
            background-color: #f7fafc; /* Lighter background on hover */
        }

        .executor-card label {
            display: flex; /* Make the label a flex container to align checkbox and details */
            align-items: center;
            width: 100%; /* Make label take full width of card */
            cursor: pointer;
        }

        .executor-card input[type="checkbox"] {
            margin-right: 1rem; /* Space between checkbox and text */
            transform: scale(1.2); /* Slightly larger checkbox */
        }

        .executor-details {
            flex-grow: 1; /* Allow details to take available space */
            display: flex;
            flex-direction: column;
        }

        .executor-name {
            font-weight: 600;
            color: #1a202c;
        }

        .executor-contact {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .edit-button {
            padding: 0.5rem 1rem;
            background-color: #edf2f7; /* Light gray */
            color: #2d3748; /* Dark text */
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .edit-button:hover {
            background-color: #e2e8f0;
        }

        /* Add Someone New Button */
        .add-new-person-button {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.5rem;
            background-color: #f7fafc; /* Very light gray */
            border: 1px dashed #cbd5e0; /* Dashed gray border */
            border-radius: 0.375rem;
            color: #4a5568;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            margin-top: 1rem;
        }
        .add-new-person-button:hover {
            background-color: #edf2f7;
            border-color: #a0aec0;
        }
        .add-new-person-button svg {
            margin-right: 0.5rem;
            color: #a0aec0; /* Gray plus icon */
        }

        /* Bottom navigation buttons */
        .bottom-nav-buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 2rem;
            border-top: 1px solid #edf2f7;
            margin-top: 3rem;
        }

        .back-button {
            padding: 0.75rem 1.5rem;
            background-color: transparent;
            color: #4a5568;
            border: none;
            border-radius: 0.375rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .back-button:hover {
            background-color: #edf2f7;
        }

        .save-continue-button {
            padding: 0.75rem 2.5rem;
            border-radius: 0.375rem;
            background-color: #fbd38d; /* Yellow from screenshot */
            color: #2d3748; /* Dark text */
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            border: none; /* No border for this button */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
        .save-continue-button:hover {
            background-color: #f6ad55; /* Darker yellow on hover */
        }

        /* Related Articles Sidebar Styles */
        .related-articles-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content; /* Ensure it doesn't take full height if content is small */
            position: sticky; /* Makes it stick when scrolling */
            top: 1.5rem; /* Distance from top of viewport */
        }

        .related-articles-card h4 {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #2d3748;
        }

        .related-articles-card ul li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #edf2f7;
        }

        .related-articles-card ul li:last-child {
            border-bottom: none;
        }

        .related-articles-card ul li a {
            color: #4299e1; /* Blue link color */
            text-decoration: none;
            font-size: 0.95rem;
        }

        .related-articles-card ul li a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-8">
                <div class="card height-equal">
                    <form method="POST" action="{{ route('customer.will_generator.gift.update_gift', $gift->id) }}">
                        @csrf
                        <input type="hidden" name="type" value="{{ $gift->gift_type ?? $type }}">

                        <div class="card-body basic-wizard important-validation">
                            {{-- Dynamic Title based on gift type --}}
                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                @if(isset($gift))
                                    Edit {{ ucfirst($gift->gift_type) }} Gift
                                @elseif($type == 'one-off')
                                    Leave a one-off item as a gift
                                @elseif($type == 'collection')
                                    Leave a collection of items as a gift
                                @elseif($type == 'vehicle')
                                    Leave a vehicle as a gift
                                @elseif($type == 'money')
                                    Leave a sum of money as a gift
                                @else
                                    Add a Gift
                                @endif
                            </h1>

                            {{-- Dynamic "Be specific" guidance --}}
                            <div class="guidance-section text-red-600 mb-4">
                                <p class="font-semibold mb-1">Be specific</p>
                                @php
                                    // Determine the type for guidance display
                                    $currentType = isset($gift) ? $gift->gift_type : $type;
                                @endphp
                                @if($currentType == 'one-off')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "Painting signed by A. F. Digby, of an old man eating breadcrumbs."</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "Painting"</p>
                                @elseif($currentType == 'collection')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My books, jewellery or a shelf full of vinyls, wherever they are kept at the date of my death" to make sure you're leaving your full collection.</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "All my books"</p>
                                @elseif($currentType == 'vehicle')
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My car, registration number FW1 1AA"</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "My car"</p>
                                @endif
                            </div>

                            {{-- General descriptive text for one-off/collection/vehicle --}}
                            @if($currentType == 'one-off')
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    You may only have one painting now, but if you buy another one in the
                                    future, your administrators won't know which one you mean. Always be
                                    as specific as possible so that your wishes are easy to understand.
                                </p>
                            @elseif($currentType == 'collection')
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    If you want to leave all your personal possessions write "personal
                                    possessions as defined by section 55 Administration of Estates Act".
                                </p>
                            @elseif($currentType == 'vehicle')
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    The first example ensures your beneficiary will only inherit the car if
                                    you still own it when you die. The second example means you will give
                                    the last car you own as a gift, even if it's different from the one you
                                    own now.
                                </p>
                                <p class="text-gray-700 leading-relaxed mb-6">
                                    If you want to leave whichever car you have when you die
                                </p>
                                <div class="guidance-section text-red-600 mb-4">
                                    <p class="do-say"><span class="bullet text-green-500">&bull;</span>Do say: "My car at the date of my death"</p>
                                    <p class="dont-say"><span class="bullet text-red-500">&bull;</span>Don't say: "My car"</p>
                                </div>
                            @endif

                            {{-- What's the item/collection/vehicle/amount? --}}
                            <div class="mb-6">
                                <label for="itemDescription" class="block text-gray-700 text-sm font-semibold mb-2">
                                    @if($currentType == 'one-off')
                                        Description of item
                                    @elseif($currentType == 'collection')
                                        Description of collection
                                    @elseif($currentType == 'vehicle')
                                        Description of the vehicle
                                    @elseif($currentType == 'money')
                                        Amount
                                    @endif
                                </label>
                                @if($currentType == 'money')
                                    <input type="number" step="0.01" id="itemDescription" name="item_description" class="form-input" placeholder="e.g. 500" value="{{ old('item_description', $gift->gift_name ?? '') }}" required>
                                @else
                                    <input type="text" id="itemDescription" name="item_description" class="form-input" placeholder="My watch" value="{{ old('item_description', $gift->gift_name ?? '') }}" required>
                                @endif
                            </div>

                            {{-- Who would you like to leave it to? (Common Section) --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    Who would you like to leave it to?
                                </h3>
                                <p class="text-gray-700 text-sm mb-4">
                                    Select one or more people or add someone new
                                </p>

                                <div id="peopleList" class="space-y-3">
                                    @forelse ($executors as $executor)
                                        <div class="executor-card">
                                            <label>

                                                <input type="checkbox" name="recipients[]" value="{{$executor->id}}" class="form-checkbox text-indigo-600"
                                                    @if(isset($selectedRecipientIds) && in_array($executor->id, $selectedRecipientIds)) checked @endif>
                                                <div class="executor-details">
                                                    <span class="executor-name">{{ $executor->name }} {{ $executor->lastname }}</span>
                                                    <span class="executor-contact">{{ $executor->email ?? 'No email available' }}</span>
                                                </div>
                                            </label>
                                            <button type="button" class="edit-button"
                                                data-toggle="modal" data-target="#editExecutorModal"
                                                data-id="{{ $executor->id }}" data-name="{{ $executor->name }}"
                                                data-lastname="{{ $executor->lastname }}"
                                                data-how_acting="{{ $executor->how_acting ?? '' }}"
                                                data-email="{{ $executor->email ?? '' }}"
                                                data-relationship="{{ $executor->relationship ?? '' }}"
                                                data-status="{{ $executor->status ?? '' }}" data-title="{{ $executor->title ?? '' }}"
                                                data-phone_number="{{ $executor->phone_number ?? '' }}">
                                                Edit
                                            </button>
                                        </div>
                                    @empty
                                        <p class="text-gray-600 italic">No friends or family added yet. Click "Add
                                            someone new" to get started.</p>
                                    @endforelse

                                    <button type="button" class="add-new-person-button" id="addNewPersonButton">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Add someone new
                                    </button>
                                </div>
                            </div>

                            {{-- Leave a message (Optional) (Common Section) --}}
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-800 mb-4">
                                    Leave a message
                                </h3>
                                <p class="text-gray-700 leading-relaxed mb-4">
                                    Tell them what you're leaving and why you're leaving it to them. You
                                    can also say something you'd like them to do with it, although they
                                    won't be legally obliged to carry out your wishes.
                                </p>
                                <label for="messageOptional" class="block text-gray-700 text-sm font-semibold mb-2">
                                    Your message (optional)
                                </label>
                                <textarea id="messageOptional" name="message" class="form-input" rows="4" placeholder="e.g. This watch was given to me by my father...">{{ old('message', $gift->leave_message ?? '') }}</textarea>
                            </div>

                            {{-- Bottom Navigation (Common Section) --}}
                            <div class="bottom-nav-buttons">
                                <button type="button" class="back-button" onclick="history.back()">
                                    &larr; Back
                                </button>
                                <button type="submit" class="save-continue-button">
                                    Update
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-4"> {{-- Sidebar area (Common Section) --}}
                <div class="related-articles-card">
                    <h4>Related articles</h4>
                    <ul>
                        <li><a href="#" class="text-blue-600 hover:underline">Leaving gifts in your will</a></li>
                        {{-- More related articles would go here --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Handle "Edit" button click for existing people
            $('#peopleList').on('click', '.edit-button', function(event) {
                event.stopPropagation(); // Prevent label click if it's within a label

                const data = $(this).data();

                Swal.fire({
                    icon: 'info',
                    title: 'Edit Executor',
                    html: `This would open a modal to edit details for: <br>
                            <strong>${data.name} ${data.lastname}</strong><br>
                            Email: ${data.email || 'N/A'}<br>
                            Relationship: ${data.relationship || 'N/A'}<br>
                            Phone: ${data.phoneNumber || 'N/A'}`,
                    showConfirmButton: false,
                    timer: 3000
                });
            });

            // Handle "Add someone new" button click
            $('#addNewPersonButton').on('click', function() {
                Swal.fire({
                    icon: 'info',
                    title: 'Add New Person',
                    text: 'This would open a form to add a new person.',
                    showConfirmButton: false,
                    timer: 2000
                });

            });

            // Handle form submission
            $('form').on('submit', function(event) {
                event.preventDefault(); // Prevent default form submission initially

                const itemDescription = $('#itemDescription').val();
                const selectedRecipientIds = $('input[name="recipients[]"]:checked').map(function() {
                    return $(this).val();
                }).get();
                const message = $('#messageOptional').val();
                // Use the type from the hidden input, which will be accurate for both add and edit
                const giftType = $('input[name="type"]').val();

                // Validation: Check if an item description is provided
                if (!itemDescription) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: `Please provide a description for the ${giftType} gift!`,
                    });
                    return; // Stop form submission
                }

                // Validation: Check if at least one recipient is selected
                if (selectedRecipientIds.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please select at least one recipient for this gift!',
                    });
                    return; // Stop form submission
                }

                // If validation passes, show success SweetAlert and then submit the form programmatically
                Swal.fire({
                    icon: 'success',
                    title: 'Updating Gift...',
                    text: `Preparing to save your ${giftType} gift details.`,
                    showConfirmButton: false,
                    timer: 1500, // Short timer before actual submission
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then(() => {
                    // Now, submit the form
                    this.submit();
                });
            });
        });
    </script>
@endsection
