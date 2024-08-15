@if(session('error') || session('success'))
<script>
    $(document).ready(function() {
        @if(session('error'))
            toastr.error("Error", "{{ Session::get('error') }}", {
                progressBar: true
            });
        @endif

        @if(session('success'))
            toastr.success("{{ Session::get('success') }}", {
                progressBar: true
            });
        @endif
    });
</script>
@endif
