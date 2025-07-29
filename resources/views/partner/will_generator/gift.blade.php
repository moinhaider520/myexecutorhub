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

        /* Gift Item Styles */
        .gift-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0; /* Light gray border */
            border-radius: 0.375rem; /* Rounded corners */
            margin-bottom: 0.75rem;
            background-color: #fff;
        }

        .gift-details {
            flex-grow: 1;
        }

        .gift-name {
            font-weight: 600;
            color: #1a202c;
        }

        .gift-recipient {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .gift-actions {
            display: flex;
            gap: 0.5rem;
        }

        .gift-action-button {
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        .remove-button {
            background-color: #fbd38d; /* Light orange/yellow */
            color: #9c4221; /* Darker text */
            border: 1px solid #f6ad55;
        }
        .remove-button:hover {
            background-color: #f6ad55;
        }

        .edit-button {
            background-color: #edf2f7; /* Light gray */
            color: #2d3748; /* Dark text */
            border: 1px solid #e2e8f0;
        }
        .edit-button:hover {
            background-color: #e2e8f0;
        }

        /* Add Gift Type Styles */
        .add-gift-type-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 0.375rem;
            margin-bottom: 0.75rem;
            background-color: #fff;
        }

        .add-gift-info {
            display: flex;
            align-items: center;
            flex-grow: 1;
        }

        .add-gift-icon {
            margin-right: 1rem;
            color: #4a5568;
            font-size: 1.5rem; /* Adjust icon size */
        }

        .add-gift-text {
            display: flex;
            flex-direction: column;
        }

        .add-gift-title {
            font-weight: 600;
            color: #1a202c;
        }

        .add-gift-example {
            font-size: 0.875rem;
            color: #4a5568;
        }

        .add-gift-button {
            padding: 0.5rem 1.5rem;
            background-color: #edf2f7;
            color: #2d3748;
            border: 1px solid #e2e8f0;
            border-radius: 0.25rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .add-gift-button:hover {
            background-color: #e2e8f0;
        }

        /* Done Button */
        .done-button {
            display: block;
            width: fit-content; /* Adjust width to content */
            margin: 2rem auto 0 auto; /* Center horizontally */
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
        .done-button:hover {
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
            <div class="col-xl-8"> {{-- Main content area --}}
                <div class="card height-equal">
                    <div class="card-body basic-wizard important-validation">
                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                            Are there any gifts you'd like to leave?
                        </h1>
                        <p class="text-gray-700 leading-relaxed mb-4">
                            Everything you own has a story behind it. That's why so many people
                            choose to leave gifts to their loved ones in their will.
                        </p>
                        <p class="text-gray-700 leading-relaxed mb-6">
                            It could be a memory you shared, something they always cherished, or
                            simply a little token for them to remember you by.
                        </p>

                        <h2 class="text-2xl font-bold text-gray-800 mb-4">
                            Physical gifts
                        </h2>

                        {{-- Existing Physical Gifts List (Dynamic) --}}
                        <div id="physicalGiftsList" class="space-y-3 mb-8">
                            @forelse($physicalGifts as $gift)
                                <div class="gift-item" data-gift-id="{{ $gift->id }}">
                                    <div class="gift-details">
                                        <span class="gift-name">{{ $gift->gift_name }}</span>
                                        {{-- You might need to fetch the recipient's name based on family_inherited_id --}}
                                        <span class="gift-recipient block">
                                            @if($gift->family_inherited_id)
                                                {{-- Assuming you have a way to get the family member's name, e.g., through a relationship --}}
                                                {{-- For now, let's just display the ID, or you can add logic to fetch the name --}}
                                                Recipient ID: {{ $gift->family_inherited_id }}
                                            @else
                                                No specific recipient
                                            @endif
                                        </span>
                                    </div>
                                    <div class="gift-actions">
                                        <button type="button" class="gift-action-button remove-button">Remove</button>
                                        <button type="button" class="gift-action-button edit-button">Edit</button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-600">No physical gifts added yet.</p>
                            @endforelse
                        </div>

                        <h2 class="text-2xl font-bold text-gray-800 mb-4">
                            Add a gift
                        </h2>

                        {{-- Add Gift Type Options --}}
                        <div class="space-y-3">
                            <div class="add-gift-type-item">
                                <div class="add-gift-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 add-gift-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c1.657 0 3 .895 3 2s-1.343 2-3 2-3-.895-3-2 1.343-2 3-2z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 17a2 2 0 100-4 2 2 0 000 4z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v.01M12 20v.01M4.01 12H4m20 .01h-.01M6.01 6.01L6 6m12 12l.01-.01M6.01 17.99L6 18m12-12l.01.01" />
                                    </svg>
                                    <div class="add-gift-text">
                                        <span class="add-gift-title">A one-off item</span>
                                        <span class="add-gift-example">e.g. Wedding ring, a piece of art...</span>
                                    </div>
                                </div>
                                <button type="button" class="add-gift-button" data-gift-type="one-off">Add</button>
                            </div>

                            <div class="add-gift-type-item">
                                <div class="add-gift-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 add-gift-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 13v-1m4 1v-1m4 1v-1M3 21h18M5 10V7a2 2 0 012-2h10a2 2 0 012 2v3m-2 2H7a2 2 0 00-2 2v4h14v-4a2 2 0 00-2-2z" />
                                    </svg>
                                    <div class="add-gift-text">
                                        <span class="add-gift-title">A collection of items</span>
                                        <span class="add-gift-example">e.g. Record collection, mug collection...</span>
                                    </div>
                                </div>
                                <button type="button" class="add-gift-button" data-gift-type="collection">Add</button>
                            </div>

                            <div class="add-gift-type-item">
                                <div class="add-gift-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 add-gift-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <div class="add-gift-text">
                                        <span class="add-gift-title">A vehicle</span>
                                        <span class="add-gift-example">e.g. Car, van, bike, yacht...</span>
                                    </div>
                                </div>
                                <button type="button" class="add-gift-button" data-gift-type="vehicle">Add</button>
                            </div>

                            <div class="add-gift-type-item">
                                <div class="add-gift-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 add-gift-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <div class="add-gift-text">
                                        <span class="add-gift-title">Some money</span>
                                        <span class="add-gift-example">e.g. £500...</span>
                                    </div>
                                </div>
                                <button type="button" class="add-gift-button" data-gift-type="money">Add</button>
                            </div>
                        </div>

                        <button type="button" class="done-button" id="doneButton">
                            Done
                        </button>

                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="related-articles-card">
                    <h4>Related articles</h4>
                    <ul>
                        <li><a href="#" class="text-blue-600 hover:underline">Leaving gifts in your will</a></li>

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
            // Handle "Remove" button click for physical gifts
            $('#physicalGiftsList').on('click', '.remove-button', function() {
                const giftItem = $(this).closest('.gift-item');
                const giftId = giftItem.data('gift-id'); // Get the gift ID
                const giftName = giftItem.find('.gift-name').text();

                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to remove "${giftName}"?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // In a real application, you would send an AJAX request to your backend to delete the gift from the database.
                        // Example AJAX call:
                        $.ajax({
                            url: '/partner/will_generator/gift/delete/' + giftId, // Your API endpoint for deleting gifts
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                giftItem.remove(); // Remove the gift item from the DOM on success
                                Swal.fire(
                                    'Removed!',
                                    `"${giftName}" has been removed.`,
                                    'success'
                                );
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    'Failed to remove gift. Please try again.',
                                    'error'
                                );
                                console.error('Error removing gift:', xhr.responseText);
                            }
                        });
                    }
                });
            });

            // Handle "Edit" button click for physical gifts
            $('#physicalGiftsList').on('click', '.edit-button', function() {
                const giftItem = $(this).closest('.gift-item');
                const giftId = giftItem.data('gift-id'); // Get the gift ID
                const giftName = giftItem.find('.gift-name').text();

                // Redirect to an edit page for the specific gift
                window.location.href = "{{ url('partner/will_generator/gift/edit_add_gift') }}/" + giftId;
            });

            // Handle "Add" button click for different gift types
            $('.add-gift-button').on('click', function() {
                const giftType = $(this).data('gift-type');

                window.location.href = "{{ url('partner/will_generator/gift/add') }}/" + giftType;
            });

            // Handle "Done" button click
            $('#doneButton').on('click', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Gifts Saved!',
                    text: 'Your gift preferences have been saved. Proceeding to the next step.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                   
                    window.location.href = "{{route('partner.will_generator.create')}}";
                });
            });
        });
    </script>
@endsection