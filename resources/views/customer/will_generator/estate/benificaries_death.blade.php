@extends('layouts.will_generator')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Base styles for the overall layout */
        body {
            font-family: 'Inter', sans-serif;
        }

        .container-fluid {
            padding: 1.5rem;
        }

        .card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        /* Inheritance Option Card Styles */
        .inheritance-option-card {
            background-color: #f7fafc; /* Light gray background */
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-bottom: 1rem;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .inheritance-option-card:hover {
            border-color: #a0aec0; /* Darker gray on hover */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .inheritance-option-card.selected {
            background-color: #4c51bf; /* Indigo-700 */
            border-color: #4c51bf;
            color: #ffffff;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .inheritance-option-card.selected .option-text {
            color: #ffffff;
        }

        .inheritance-option-card.selected .arrow-icon {
            color: #ffffff;
        }

        .option-text {
            font-weight: 600;
            color: #2d3748; /* Dark gray */
            flex-grow: 1;
        }

        .arrow-icon {
            color: #a0aec0; /* Light gray arrow */
            transition: transform 0.2s ease-in-out;
        }

        /* Sidebar styles (Inheriting your estate) */
        .inheritance-summary-card {
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            height: fit-content;
            position: sticky;
            top: 1.5rem;
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
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .inheritance-summary-card ul li:last-child {
            border-bottom: none;
        }

        .beneficiary-info {
            display: flex;
            flex-direction: column;
        }

        .beneficiary-name-summary {
            font-weight: 500;
            color: #2d3748;
        }

        .beneficiary-backup-status {
            font-size: 0.85rem;
            color: #6b7280; /* Gray-500 */
        }

        .beneficiary-percentage-summary {
            font-weight: 600;
            color: #2d3748;
        }
    </style>

    <div class="container-fluid default-dashboard">
        <div class="row widget-grid flex flex-col xl:flex-row"> {{-- Use flexbox for responsive columns --}}
            <div class="w-full xl:w-7/12 p-3"> {{-- Main content area --}}
                <div class="card height-equal">
                    <div class="card-body basic-wizard important-validation">
                        <form id="backupBeneficiaryForm" action="{{route('customer.will_generator.store_benificaries_death_backup')}}" method="POST">
                            @csrf

                            <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">
                                If {{$beneficiary->getNameAttribute()}} dies before you, who should inherit their share of the estate instead?
                            </h1>
                            <p class="text-gray-700 leading-relaxed mb-6">
                                Writing a will is all about being prepared for the unexpected. This is why we also ask you to name back-ups in case your chosen beneficiary dies before you. These are known as secondary beneficiaries.
                            </p>

                            {{-- Inheritance Options --}}
                            <div class="space-y-4">
                                <div class="inheritance-option-card" data-option="their_children">
                                    <span class="option-text">Their children</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>

                                <div class="inheritance-option-card" data-option="split_remaining">
                                    <span class="option-text">Split between remaining beneficiaries</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 arrow-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>

                            <input type="hidden" name="selected_backup_option" id="selectedBackupOption">
                            <input type="hidden" name="current_beneficiary_id" value="{{$beneficiary->id}}">

                            <p class="text-gray-600 italic mt-6">
                                Selecting 'Their children' includes all {{$beneficiary->getNameAttribute()}}'s biological and legally adopted children but not step-children.
                            </p>

                            <p class="text-gray-600 italic mt-4">
                                If both your original and back-up beneficiaries die before you, this share of your estate will be divided between your other beneficiaries (the people you've chosen to inherit your estate).
                            </p>

                            <div class="flex justify-between mt-8">
                                <a href="#"
                                    class="inline-flex items-center justify-center px-8 py-3 border border-gray-300 text-base font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                    &larr; Back
                                </a>

                                <button type="submit" id="saveAndContinueBtn" disabled
                                    class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-gray-900 bg-yellow-400 hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed">
                                    Save and continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="w-full xl:w-5/12 p-3"> {{-- Sidebar area --}}
                <div class="inheritance-summary-card">
                    <h4>Inheriting your estate:</h4>
                    <ul id="inheritanceSummaryList">
                       @forelse ($allBeneficiaries->beneficiaries as $beneficiaries)
                            <li>
                                <div class="beneficiary-info">
                                    <span class="beneficiary-name-summary">{{ $beneficiaries->getNameAttribute()}}</span>
                                    @if ($beneficiaries->id === $beneficiary->id)
                                        <span class="beneficiary-backup-status">Backups: selecting now</span>
                                    @endif
                                </div>
                                <span class="beneficiary-percentage-summary">{{ number_format($beneficiaries->share_percentage, 2) }}%</span>
                            </li>
                        @empty
                            <li>No beneficiaries added yet.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            const optionCards = $('.inheritance-option-card');
            const selectedBackupOptionInput = $('#selectedBackupOption');
            const saveAndContinueBtn = $('#saveAndContinueBtn');

            optionCards.on('click', function() {
                // Remove 'selected' class from all cards
                optionCards.removeClass('selected');
                // Add 'selected' class to the clicked card
                $(this).addClass('selected');

                // Set the hidden input value
                selectedBackupOptionInput.val($(this).data('option'));

                // Enable the save button
                saveAndContinueBtn.prop('disabled', false);
            });

            // Initial state: disable button if no option is pre-selected
            if (selectedBackupOptionInput.val() === '') {
                saveAndContinueBtn.prop('disabled', true);
            }
        });
    </script>
@endsection
