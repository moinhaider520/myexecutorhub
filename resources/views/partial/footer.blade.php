<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 footer-copyright d-flex flex-wrap align-items-center justify-content-between">
                <p class="mb-0 f-w-600">Copyright 2024 © My Executor Hub</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <iframe
                    src="https://registry.blockmarktech.com/certificates/31675de8-268a-44e6-a850-d1defde5b758/widget/?tooltip_position=above&theme=transparent"
                    style="border:none;height:132px;width:132px;"></iframe>
            </div>
        </div>
    </div>
</footer>
</div>
</div>

<script>
    $(document).ready(function () {
        $(".onhover-dropdown").on("click", function (e) {
            e.stopPropagation(); // Prevents event bubbling
            let dropdown = $(this).children(".profile-dropdown");

            // Toggle between classes
            if (dropdown.hasClass("onhover-show-div-hidden")) {
                dropdown.removeClass("onhover-show-div-hidden").addClass("onhover-show-div");
            } else {
                dropdown.removeClass("onhover-show-div").addClass("onhover-show-div-hidden");
            }
        });

        // Close the dropdown when clicking outside
        $(document).on("click", function () {
            $(".profile-dropdown").removeClass("onhover-show-div").addClass("onhover-show-div-hidden");
        });
    });

</script>