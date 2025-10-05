@extends('layouts.will_generator')

@section('content')
    {{-- Include Tailwind CSS if it's not in your main layout. Remove this if already included. --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="min-h-screen bg-gray-50 flex flex-col pt-10">

        {{-- Header Section --}}
        <header class="w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-gray-900">Will Generate</h1>
        </header>

        {{-- Main Content Area - Mimics the white card structure --}}
        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
            <div class="bg-white shadow-lg rounded-lg p-6 sm:p-10 border border-gray-200">

                {{-- Breadcrumb/Root Directory --}}
                <div class="mb-6 text-sm text-gray-500">
                    New Will
                </div>

                <div class="flex flex-col items-center justify-center min-h-[500px] text-center">

                    {{-- Illustration (Box) --}}
                    <div class="mb-6">
                        {{-- This SVG is a simplified, non-code representation of the box image --}}
                        <svg class="mx-auto w-32 h-32 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12.89 2.05l-7 14A1 1 0 0 0 6 18h12a1 1 0 0 0 .73-.41L12.89 2.05z" />
                            <polyline points="20.5 8 16 12 11.5 8" />
                            <path d="M2.5 17.5l9.5-4 9.5 4-9.5 4z" />
                            <path d="M12 2v20" />
                            <circle cx="12" cy="12" r="10" stroke-width="1.5" stroke="gray" fill="none" />
                            <path d="M5 3s4 0 7 7 7 7 7 7" stroke="gray" />
                            <path d="M19 19s-4 0-7-7-7-7-7-7" stroke="gray" />
                            <path d="M5 19l14-14" stroke="gray" />
                            <rect x="2" y="7" width="20" height="15" rx="2" ry="2" fill="white"
                                stroke="currentColor" />
                            <path d="M18 10h-2M10 10H8M14 10h-2" />
                            <path d="M2 7l10-5 10 5" />
                            <path d="M12 12L12 17" />
                            <path d="M9 15L15 15" />
                            <path d="M6 10H4a2 2 0 0 0-2 2v2" />
                            <path d="M22 10h-2v4a2 2 0 0 0 2-2v-2" />
                            <circle cx="12" cy="17" r="1" />
                            <circle cx="12" cy="17" r="1" />
                            <path stroke="black" d="M3 7h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V8a1 1 0 0 1 1-1z"
                                fill="white" stroke-width="1.5" />
                            <path stroke="black" d="M2 7l10-5 10 5" fill="white" stroke-width="1.5" />
                            <path stroke="black" d="M18 10H6" stroke-dasharray="4 4" stroke-width="1" />
                            <path stroke="black" d="M18 15H6" stroke-dasharray="4 4" stroke-width="1" />
                            <path stroke="black" d="M18 10h-2" stroke-width="1" />
                            <path stroke="black" d="M6 10h2" stroke-width="1" />
                            <path stroke="black" d="M12 10V5.5" stroke-width="1" />
                            <circle cx="12" cy="8" r="1.5" fill="none" stroke="black" stroke-width="1" />
                            <path stroke="black" d="M16 10.5l-2-2m-4 2l2-2" stroke-width="1" />
                            <path d="M10 10.5h4" stroke="black" stroke-width="1" />
                            <path d="M12 12.5v4" stroke="black" stroke-width="1" />
                            <path d="M10 14.5h4" stroke="black" stroke-width="1" />
                        </svg>
                    </div>

                    {{-- Main Text --}}
                    <h2 class="text-xl font-bold text-gray-800 mb-2">
                        No Will has been created here yet
                    </h2>

                    <p class="text-gray-600 mb-8 max-w-md">
                        Will has been created by the recipe using Workato FileStorage will appear here. You can also
                        manually upload file and create directory here.
                    </p>

                    {{-- Buttons --}}
                    <div class="flex space-x-4">
                        <form id="willUploadForm" action="{{ route('customer.will_generator.will_pdf_generate_ai') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf {{-- Laravel CSRF protection --}}

                            {{-- 2. Hidden File Input with the onchange handler --}}
                            <input type="file" id="will_upload_input" class="hidden" name="file"
                                onchange="this.form.submit();">

                            {{-- 3. Visible Button that triggers the file input via JavaScript --}}
                            <button type="button" onclick="document.getElementById('will_upload_input').click();"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                Upload file
                            </button>
                        </form>
                        {{-- The link to your "Create Will Manually" page --}}
                        <a href="{{ route('customer.will_generator.about_you') }}"
                            class="inline-flex items-center px-4 py-2 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                            Create will manually
                        </a>
                    </div>

                </div>
            </div>
        </main>
    </div>
@endsection
