<!-- HTML and other content here... -->
</div>
<!-- MOdal for Send-->


<!-- JAVASCRIPT -->
{{--
<script src="https://code.jquery.com/jquery-3.7.1.js"></script> --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
    new DataTable('#example2');
    new DataTable('#transactionsTable');
</script>

<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ asset('assets/js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script src="https://sandbox.sdk.monnify.com/plugin/monnify.js"></script> <!-- Include Monnify SDK -->

<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;

        const icon = event.currentTarget.querySelector('i');
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    }

</script>

<!-- Toast notifications for session messages -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success message
        @if(session('success'))
            Swal.fire({
                toast: true,
                icon: 'success',
                title: "{{ session('success') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true
            });
        @endif

        // Check for error message
        @if(session('error'))
            Swal.fire({
                toast: true,
                icon: 'error',
                title: "{{ session('error') }}",
                position: 'top-end',
                showConfirmButton: false,
                timer: 20000,
                timerProgressBar: true
            });
        @endif
    });
</script>

@stack('before_scripts')
@yield('scripts')
@stack('after_scripts')
</body>

</html>
