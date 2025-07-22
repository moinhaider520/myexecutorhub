<script src="https://cdn.tailwindcss.com"></script>
<div class="stepper-four row g-3 needs-validation custom-input" novalidate="" style="display: none;">
    <div class="col-sm-12">

        <h1 id="childrenQuestion" class="text-2xl sm:text-2xl font-bold text-gray-800 mb-4">
            Do you have any children?<span class="txt-danger">*</span>
        </h1>
        <p class="text-gray-600 mb-2">
            If your first child is on the way, select "No" for now. You can always update this in the future.
        </p>
        <p class="text-gray-600 mb-2">
            Add all your biological and legally adopted children, whether or not you want to leave things to them in
            your will.
        </p>
        <p class="text-gray-600 mb-6">
            Do not add any step children here. You can add them later if you wish to leave them part of your estate.
        </p>

        <!-- Radio Button Style Selection -->
        <div class="space-y-4 mb-8">
            <!-- Yes Option -->
            <div id="yesOption"
                class="cursor-pointer p-4 rounded-lg border-2 transition-all duration-200 border-gray-300 bg-gray-50 hover:bg-gray-100"
                onclick="handleSelection('yes')">
                <span class="font-medium text-gray-800">
                    Yes
                </span>
            </div>

            <!-- No Option -->
            <div id="noOption"
                class="cursor-pointer p-4 rounded-lg border-2 transition-all duration-200 border-gray-300 bg-gray-50 hover:bg-gray-100"
                onclick="handleSelection('no')">
                <span class="font-medium text-gray-800">
                    No
                </span>
            </div>
            <input type="hidden" name="children" id="children">
        </div>

        <!-- Conditional Rendering of Child Details -->
        <div id="childDetails" class="bg-white p-4 rounded-lg shadow-md border border-gray-200 hidden mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <p class="font-semibold text-gray-900">Melyssa Workman</p>
                    <p class="text-sm text-gray-600">23/05/1997</p>
                </div>
                <button type="button" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
                    <!-- Edit Icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" class="inline-block mr-1">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                    </svg>
                    Edit details
                </button>
            </div>
        </div>

        <div id="addChildButtonContainer" class="hidden" style="display: none;">
            <button type="button"
                class="w-full py-3 px-4 bg-white border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-700 transition-all duration-200 flex items-center justify-center"
                data-toggle="modal" data-target="#addWillChildModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="inline-block mr-2">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Add child
            </button>
        </div>
    </div>

</div>
<div class="modal" id="addWillChildModal" tabindex="-1" role="dialog" aria-labelledby="addWillChildModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="addWillChildForm"> 
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addWillChildModalLabel">Add a child</h5>
        </div>
        <div class="modal-body">
          <div class="form-group mb-3">
            <label for="name">Child Full Name</label>
            <input type="text" class="form-control" name="name" id="name"
              placeholder="Enter Child Name" required>
            <div class="text-danger" id="error-name"></div>
          </div>
          <div class="form-group mb-3">
            <label for="date_of_birth">Date Of Birth</label>
            <input type="text" class="form-control" name="child_date_of_birth" id="date_of_birth"
              placeholder="Enter Date of birth" required>
            <div class="text-danger" id="error-date_of_birth"></div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="saveChildButton">Save changes</button>
        </div>
      </div>
    </form> 
  </div>
</div>

<script>
    // Get references to the DOM elements
    const yesOption = document.getElementById('yesOption');
    const noOption = document.getElementById('noOption');
    const childDetails = document.getElementById('childDetails');
    const addChildButtonContainer = document.getElementById('addChildButtonContainer'); // Get the new button container

    // Variable to store the current selection
    let hasChildren = null; // 'yes', 'no', or null

    // Function to handle the selection
    function handleSelection(selection) {
        hasChildren = selection; // Update the selection state

        // Reset styles for both options
        yesOption.classList.remove('border-blue-500', 'bg-blue-50', 'shadow-inner');
        yesOption.classList.add('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
        yesOption.querySelector('span').classList.remove('text-blue-700');
        yesOption.querySelector('span').classList.add('text-gray-800');

        noOption.classList.remove('border-blue-500', 'bg-blue-50', 'shadow-inner');
        noOption.classList.add('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
        noOption.querySelector('span').classList.remove('text-blue-700');
        noOption.querySelector('span').classList.add('text-gray-800');

        // Apply selected styles based on the current selection
        if (hasChildren === 'yes') {
            yesOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
            yesOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
            yesOption.querySelector('span').classList.add('text-blue-700');
            yesOption.querySelector('span').classList.remove('text-gray-800');
        } else if (hasChildren === 'no') {
            noOption.classList.add('border-blue-500', 'bg-blue-50', 'shadow-inner');
            noOption.classList.remove('border-gray-300', 'bg-gray-50', 'hover:bg-gray-100');
            noOption.querySelector('span').classList.add('text-blue-700');
            noOption.querySelector('span').classList.remove('text-gray-800');
        }

        // Show/hide child details and "Add child" button based on selection
        if (hasChildren === 'yes') {
            childDetails.classList.remove('hidden');
            childDetails.style.display = 'block'; // Ensure it's block for visibility

            addChildButtonContainer.classList.remove('hidden');
            addChildButtonContainer.style.display = 'block'; // Show the add child button
        } else {
            childDetails.classList.add('hidden');
            childDetails.style.display = 'none'; // Ensure it's none for hiding

            addChildButtonContainer.classList.add('hidden');
            addChildButtonContainer.style.display = 'none'; // Hide the add child button
        }
        $("#children").val(hasChildren);
    }

    // Call handleSelection on window load to set initial state
    window.onload = function() {
        handleSelection(null); // Ensures no option is selected and child details/button are hidden initially
    };
   $(document).ready(function() {
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });

        function clearAddErrors() {
            $('#error-name').text('');
            $('#error-date_of_birth').text('');
        }

        $('#saveChildButton').on('click', function(e) {
            e.preventDefault();
            clearAddErrors();

            var childName = $('#name').val();
            var childDateOfBirth = $('#date_of_birth').val();

            var postData = {
                name: childName,
                date_of_birth: childDateOfBirth
            };

            console.log("Data being sent:", postData);

            $.ajax({
                url: "{{ route('partner.will_generator.user_child.store') }}",
                method: 'POST',
                data: postData,
                dataType: 'json',

                success: function(response) {
                    if (response.success) {
                        $('#addWillChildModal').modal('hide');
                        alert('Child added successfully!');
                    } else {
                        alert(response.message || 'An unknown error occurred during processing.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status === 419) {
                        alert('Your session has expired or the security token is invalid. Please refresh the page and try again.');
                        location.reload();
                    } else if (jqXHR.status === 422) {
                        var errors = jqXHR.responseJSON.errors;
                        if (errors.name) {
                            $('#error-name').text(errors.name);
                        }
                        if (errors.date_of_birth) {
                            $('#error-date_of_birth').text(errors.date_of_birth);
                        }
                    } else {
                        var errorMessage = 'An unexpected error occurred.';
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        } else if (errorThrown) {
                            errorMessage = errorThrown;
                        }
                        alert(errorMessage);
                        console.error("AJAX Error:", jqXHR, textStatus, errorThrown);
                    }
                }
            });
        });
    });
</script>
</div>