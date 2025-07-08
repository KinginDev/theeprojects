<!-- HTML and other content here... -->
</div>
<!-- MOdal for Send-->
@php
    // Fetch the first configuration from the settings table
    $configuration = \App\Models\Setting::first();
@endphp

<!-- WhatsApp Widget Script -->
<script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
<script>
    var wa_btnSetting = {
        "btnColor": "#16BE45",
        "ctaText": "WhatsApp Us",
        "cornerRadius": 40,
        "marginBottom": 20,
        "marginLeft": 20,
        "marginRight": 20,
        "btnPosition": "right",
        "whatsAppNumber": '{{ $configuration->whatsapp_number ?? '+00000000000' }}', // Fallback if null
        "welcomeMessage": '{{ $configuration->welcome_message ?? 'Hello! How can we assist you?' }}',
        "zIndex": 999999,
        "btnColorScheme": "light"
    };

    window.onload = () => {
        _waEmbed(wa_btnSetting); // Initialize the WhatsApp widget with the settings
    };
</script>


<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
<script>
    new DataTable('#example');
    new DataTable('#example2');
</script>
<script src="{{ secure_asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ secure_asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ secure_asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
<script src="{{ secure_asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ secure_asset('assets/libs/node-waves/waves.min.js') }}"></script>

<script src="{{ secure_asset('assets/js/app.js') }}"></script>
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

@yield('scripts')
</body>

</html>
