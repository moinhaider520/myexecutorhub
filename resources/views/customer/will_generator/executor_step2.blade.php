@extends('layouts.will_generator')

@section('title', 'Check if you need a professional executor')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- No specific inline styles needed for this page unless there are unique elements --}}

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid">
            <div class="col-xl-12 proorder-xl-12 box-col-12 proorder-md-5">
                <div class="row">
                    <div class="col-xl-8"> {{-- Main content area --}}
                        <div class="card height-equal">
                            <div class="card-header">
                                <h1>Executor</h1>
                            </div>
                            <div class="card-body basic-wizard important-validation">

                                    <script src="https://cdn.tailwindcss.com"></script>

                                    <div class="stepper row g-3 needs-validation custom-input" novalidate="">
                                        <div class="col-sm-12">
                                            {{-- Content from the screenshot starts here --}}

                                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                                Check if you need a professional executor
                                            </h1>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                You can choose between one and four executors. They could be friends and family, a professional executor or a mix of the two.
                                            </p>
                                            <p class="text-gray-700 leading-relaxed mb-4">
                                                Naming a professional executor in your will could be a good choice if you:
                                            </p>
                                            <ul class="list-disc list-inside text-gray-700 space-y-2 mb-8 ml-5">
                                                <li>think your family or friends may struggle with the responsibility</li>
                                                <li>need a fair, objective third party to help settle disagreements</li>
                                                <li>don't have any suitable friends or family to administer your estate</li>
                                                <li>would like a back-up, because you only have one executor or your other executors live abroad</li>
                                            </ul>

                                            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-4">
                                                Appointing a professional executor through Farewill
                                            </h2>
                                            <p class="text-gray-700 leading-relaxed mb-8">
                                                Farewill Trustees is a professional executor service available to everyone who writes a will with us. Founded on the same principles as Farewill, Farewill Trustees use technology and expertise to keep things simple and affordable.
                                            </p>

                                            {{-- Farewill Trustees Card --}}
                                            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-8">
                                                <h3 class="text-xl font-bold text-gray-800 mb-4">Farewill Trustees</h3>
                                                <div class="space-y-4 text-gray-700">
                                                    <div>
                                                        <h4 class="font-semibold mb-1">Legal expertise for peace of mind</h4>
                                                        <p>Farewill Trustees can act as co-executors to support either friends or family through the process.</p>
                                                        <p class="mt-2">When the time comes, if the other executors you’ve chosen find they don’t need professional support, and it’s in the best interest of the estate, Farewill Trustees will step aside. In a few cases, they may not be able to step aside, for example, if there are no other executors.</p>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold mb-1">No upfront payments</h4>
                                                        <p>They’ll agree a fixed fee before they start. No money is taken upfront, the cost is paid from your estate, not your executors’ pockets.</p>
                                                    </div>
                                                    <div>
                                                        <h4 class="font-semibold mb-1">Support every step of the way</h4>
                                                        <p>Farewill Trustees take on the legal responsibility of administering your estate to remove the burden from your loved ones.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Content from the screenshot ends here (main content) --}}
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between mt-5 items-center">
                                        <a href="#" class="text-blue-600 hover:underline flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                            </svg>
                                            Back
                                        </a>
                                        <a href="{{route('customer.will_generator.executor_step3')}}" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out">
                                            Next, choose executors
                                        </a>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4"> {{-- Sidebar area (inherited from layout, but explicitly shown here for structure) --}}
                        <div class="card">
                            <div class="card-header">
                                <h4>Questions?</h4>
                            </div>
                            <div class="card-body">
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

@endsection
