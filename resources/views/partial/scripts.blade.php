<!-- latest jquery-->
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<!-- Bootstrap js-->
<script src="{{ asset('assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
<!-- feather icon js-->
<script src="{{ asset('assets/js/icons/feather-icon/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/icons/feather-icon/feather-icon.js') }}"></script>
<!-- scrollbar js-->
<script src="{{ asset('assets/js/scrollbar/simplebar.js') }}"></script>
<script src="{{ asset('assets/js/scrollbar/custom.js') }}"></script>
<!-- Sidebar jquery-->
<script src="{{ asset('assets/js/config.js') }}"></script>
<!-- Plugins JS start-->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick/slick.js') }}"></script>
<script src="{{ asset('assets/js/header-slick.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<!-- calendar js-->
<!-- <script src="{{ asset('assets/js/notify/index.js') }}"></script> -->
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatables/datatable.custom1.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-range-picker/moment.min.js') }}"></script>
<script src="{{ asset('assets/js/datepicker/date-range-picker/datepicker-range-custom.js') }}"></script>
<script src="{{ asset('assets/js/height-equal.js') }}"></script>
<!-- Plugins JS Ends-->
<!-- Theme js-->
<script src="{{ asset('assets/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    /* Wait until Tidio is fully loaded */
document.addEventListener("DOMContentLoaded", function () {
    const interval = setInterval(function () {
        const tidioChat = document.querySelector("[id^=tidio-chat]");

        if (tidioChat) {
            // Stop the interval
            clearInterval(interval);

            // Apply center styling
            tidioChat.style.position = "fixed";
            tidioChat.style.top = "50%";
            tidioChat.style.left = "50%";
            tidioChat.style.transform = "translate(-50%, -50%)";
            tidioChat.style.zIndex = "9999";
        }
    }, 500);
});

</script>
</body>

</html>