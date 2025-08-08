@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Your existing CSS for show-more-less-button, visible-list-item, hidden-list-item */
        .show-more-less-button {
            background: none;
            text-decoration-line: underline;
            border: none;
            border-radius: 0.25rem;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            color: #4a5568;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .show-more-less-button:hover {
            border-color: #6b7280;
            color: #2d3748;
        }

        .visible-list-item {
            display: list-item;
        }
        .hidden-list-item {
            display: none;
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8">
                        <div class="card height-equal">
                            <div class="card-header">
                                Your estate
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                <script src="https://cdn.tailwindcss.com"></script>
                                <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                    <div class="col-sm-12">

                                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                            Your estate
                                        </h1>
                                        <p class="text-gray-700 leading-relaxed mb-4">
                                            Your estate is everything you own apart from any specific gifts you
                                            decide to leave to people later on. This is known as your residuary
                                            estate.
                                        </p>
                                        <p class="text-gray-700 leading-relaxed mb-4">
                                            In this section you'll be able to divide your residuary estate between
                                            people and even charities.
                                        </p>
                                        <p class="text-gray-700 leading-relaxed mb-8">
                                            You'll be able to add your gifts later.
                                        </p>

                                        <h2 class="text-2xl sm:text-xl font-bold text-gray-800 mb-3 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            What your residuary estate includes
                                        </h2>
                                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 ml-5">
                                            <li>Your bank accounts and ISAs</li>
                                            <li>Stocks and shares</li>
                                            <li>Property when you own it by yourself</li>
                                            <li>Property when you own a specific percentage of it (also known as
                                                tenants in common)</li>
                                            <li>Any other assets in your sole name, or your share of those assets</li>
                                        </ul>

                                        <h2 class="text-2xl sm:text-xl font-bold text-gray-800 mb-3 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            What your residuary estate does not include
                                        </h2>
                                        <ul class="list-disc list-inside text-gray-700 space-y-2 mb-6 ml-5">
                                            <li>Gifts of specific items, like jewellery</li>
                                            <li>Gifts of specific sums of money (cash gifts)</li>
                                            <li>Most pension plans</li>
                                            <li>Most life insurance</li>
                                            <li>Property when you own it together with someone else (also known
                                                as joint tenants)</li>
                                            <li>Joint bank accounts</li>
                                        </ul>

                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mt-5">
                                    <a href="{{ route('customer.will_generator.choose_inherited_persons') }}"
                                        class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                        Next
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Questions?</h4>
                            </div>
                            <div class="card-body">
                                <p class="text-gray-700 mb-2">
                                    Call us on <a href="tel:02045387294" class="text-blue-600 hover:underline">020 4538
                                        7294</a>
                                </p>
                                <p class="text-gray-700">
                                    <a href="mailto:info@farewill.com"
                                        class="text-blue-600 hover:underline flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 inline-block"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        Email us
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // There's no "show more/less" for the estate details in the image,
            // but if you later add a long list here and want to implement it,
            // you can use the same logic as your executor page.
            // For now, this script block will just be present but not actively controlling hidden/visible items
            // unless you add elements with 'hidden-list-item' class.
            const toggleButton = $('#toggleTasksButton'); // This ID is not present in the new content.
            const hiddenItems = $('.hidden-list-item'); // This class is not used in the new content for initial state.

            if (toggleButton.length && hiddenItems.length) { // Only run if elements exist
                toggleButton.on('click', function() {
                    if (hiddenItems.first().is(':hidden')) {
                        hiddenItems.each(function() {
                            $(this).removeClass('hidden-list-item').addClass('visible-list-item');
                        });
                        toggleButton.text('Show less');
                    } else {
                        hiddenItems.each(function() {
                            $(this).removeClass('visible-list-item').addClass('hidden-list-item');
                        });
                        toggleButton.text('Show more');
                    }
                });
            }
        });
    </script>
@endsection
