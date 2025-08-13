@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
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
                                Executor
                            </div>
                            <div class="card-body basic-wizard important-validation">
                                    <script src="https://cdn.tailwindcss.com"></script>
                                    <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                        <div class="col-sm-12">

                                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                                What is an executor?
                                            </h1>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                An executor is someone you choose to be legally responsible for dealing with
                                                your estate after you've died. Your estate is everything you own, for
                                                example, your personal possessions, money and property.
                                            </p>
                                            <p class="text-gray-700 leading-relaxed mb-8">
                                                Executors can be your friends and family, a professional, or a mix of the
                                                two. Some people choose a professional executor to take the responsibility
                                                off their loved ones.
                                            </p>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                                                What does an executor do?
                                            </h2>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                Everybody's estate is different, but here is a list of common tasks an
                                                executor will carry out:
                                            </p>
                                            <ul id="executorTasksList"
                                                class="list-disc list-inside text-gray-700 space-y-2 mb-6 ml-5">
                                                {{-- Visible items --}}
                                                <li class="visible-list-item">register the death and get the death
                                                    certificate</li>
                                                <li class="visible-list-item">arrange the funeral and final resting place
                                                </li>
                                                <li class="visible-list-item">find the original will and get copies</li>
                                                <li class="visible-list-item">apply for a grant of probate, which legally
                                                    appoints the executor</li>
                                                <li class="visible-list-item">pay any outstanding debts, fees or expenses
                                                </li>
                                                <li class="visible-list-item">prepare a detailed list of the property,
                                                    money, possessions and debts in the estate</li>
                                                <li class="visible-list-item">work out the inheritance tax due and arrange
                                                    to pay it</li>
                                                <li class="visible-list-item">maintain detailed records of all financial
                                                    transactions</li>

                                                {{-- Initially hidden items --}}
                                                <li class="hidden-list-item">transfer or sell assets as set out in the will
                                                </li>
                                                <li class="hidden-list-item">distribute gifts to named beneficiaries</li>
                                                <li class="hidden-list-item">communicate regularly with beneficiaries and
                                                    respond to any queries</li>
                                                <li class="hidden-list-item">secure and manage any property until it can be
                                                    distributed or sold</li>
                                                <li class="hidden-list-item">cancel relevant subscriptions and memberships
                                                </li>
                                                <li class="hidden-list-item">notify banks, financial institutions,
                                                    government agencies and utilities</li>
                                            </ul>
                                            <button type="button" id="toggleTasksButton" class="show-more-less-button">Show
                                                more</button>

                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-5">
                                        <a href="{{route('customer.will_generator.executor_step2',$will_user_id)}}"
                                            class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                            Continue
                                    </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="col-xl-4">
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
                    </div> -->
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
            const toggleButton = $('#toggleTasksButton');
            const hiddenItems = $('.hidden-list-item');
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
        });
    </script>
@endsection
