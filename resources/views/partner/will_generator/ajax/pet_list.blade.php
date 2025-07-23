@isset($pets)


@foreach ($pets as $pet)
    <div id="petDetails" class="pet-detail-item bg-white p-4 rounded-lg shadow-md border border-gray-200 mb-8">
        <div class="flex justify-between items-center">
            <div>
                <p class="font-semibold text-gray-900">
                    {{ @$pet->pet_name }}</p>

            </div>
            <button type="button" data-toggle="modal" data-target="#editWillPetModal" data-id="{{ $pet->id }}"
                data-name="{{ $pet->pet_name }}" data-will="{{ $pet->will_user_id }}"
                class="edit_button text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="inline-block mr-1">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7">
                    </path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z">
                    </path>
                </svg>
                Edit details
            </button>
        </div>
    </div>
@endforeach
@endisset
