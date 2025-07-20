                </div> <!-- end page content-->
            </div> <!-- end main content-->
        </div> <!-- end layout-wrapper -->


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
<script src="{{ asset('assets/js/menu-fix.js') }}"></script>
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

<!-- Merchant Dashboard Custom Styling -->
<style>
    /* Dashboard Card Enhancement */
    .dashboard-card {
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
        transition: all 0.3s ease;
        border: none;
        overflow: hidden;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    }

    /* Soft background styles */
    .bg-soft-primary {
        background-color: rgba(var(--merchant-primary-rgb, 58, 124, 253), 0.1) !important;
    }

    .bg-soft-success {
        background-color: rgba(16, 185, 129, 0.1) !important;
    }

    .bg-soft-info {
        background-color: rgba(59, 130, 246, 0.1) !important;
    }

    .bg-soft-warning {
        background-color: rgba(245, 158, 11, 0.1) !important;
    }

    .bg-soft-danger {
        background-color: rgba(239, 68, 68, 0.1) !important;
    }

    /* Avatar styling */
    .avatar-sm {
        height: 3rem;
        width: 3rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }

    .avatar-title {
        height: 100%;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Enhanced table styling */
    .table-hover tbody tr:hover {
        background-color: rgba(var(--merchant-primary-rgb, 58, 124, 253), 0.03);
    }

    .table th {
        font-weight: 600;
        color: #6c757d;
        border-top: 0;
    }

    /* Button enhancements */
    .btn-soft-primary {
        background-color: rgba(var(--merchant-primary-rgb, 58, 124, 253), 0.1);
        color: var(--merchant-primary, #3a7cfd);
        border: none;
    }

    .btn-soft-primary:hover {
        background-color: var(--merchant-primary, #3a7cfd);
        color: #fff;
    }

    .btn-soft-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        border: none;
    }

    .btn-soft-secondary:hover {
        background-color: #6c757d;
        color: #fff;
    }

    /* Improved badge styling */
    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
        border-radius: 30px;
    }

    /* Dropdown menu enhancements */
    .dropdown-menu {
        border: none;
        border-radius: 0.5rem;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .dropdown-item:hover {
        background-color: rgba(var(--merchant-primary-rgb, 58, 124, 253), 0.05);
    }

    .dropdown-item.active, .dropdown-item:active {
        background-color: var(--merchant-primary, #3a7cfd);
    }

    /* Modal improvements */
    .modal-content {
        border: none;
        border-radius: 1rem;
    }

    .modal-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .modal-footer {
        border-top: 1px solid rgba(0, 0, 0, 0.05);
    }

    /* Pink accent color styling for Settings */
    li a[href*="site_setting"],
    li a[href*="edit_profile"] {
        position: relative;
    }

    li a[href*="site_setting"] i,
    li a[href*="edit_profile"] i {
        background-color: rgba(244, 106, 155, 0.1);
        color: #f46a9b;
    }

    li a[href*="site_setting"]:hover i,
    li a[href*="edit_profile"]:hover i {
        background-color: #f46a9b;
        color: white !important;
    }

    /* Fix for Fund Wallet menu item */
    li a[href*="Fund_Wallet"] {
        position: relative;
    }

    li a[href*="Fund_Wallet"] i {
        background-color: rgba(88, 103, 221, 0.1);
        color: #5867dd;
    }

    li a[href*="Fund_Wallet"]:hover i {
        background-color: #5867dd;
        color: white !important;
    }

    /* Special styling for wallet summary */
    li a[href*="walletSummary"] i {
        background-color: rgba(255, 184, 34, 0.1);
        color: #ffb822;
    }

    li a[href*="walletSummary"]:hover i {
        background-color: #ffb822;
        color: white !important;
    }

    /* Fix for logout menu item */
    li a[onclick*="logout-form"] {
        color: #f64e60 !important;
        margin-top: 10px;
    }

    li a[onclick*="logout-form"] i {
        background-color: rgba(246, 78, 96, 0.1);
        color: #f64e60 !important;
    }

    li a[onclick*="logout-form"]:hover i {
        background-color: #f64e60;
        color: white !important;
    }

    /* Fix for submenu appearance */
    .metismenu .mm-collapse:not(.mm-show) {
        display: none;
    }

    .metismenu .mm-collapse {
        list-style: none;
        position: static;
        padding-left: 0;
    }

    .metismenu .mm-collapse.mm-show {
        display: block;
    }

    /* Fixed positioning for submenus */
    .vertical-menu #sidebar-menu ul li {
        position: relative;
        white-space: nowrap;
    }

    .vertical-menu #sidebar-menu ul li .sub-menu {
        position: static;
        left: 0;
        width: 100%;
        margin-top: 0;
        background-color: transparent;
        box-shadow: none;
        padding-left: 0;
        max-height: none;
        overflow: visible;
    }

    /* Adding spacing between menu sections */
    #sidebar-menu .menu-title {
        margin-top: 15px;
        margin-bottom: 5px;
    }

    /* Fix for the menu icon in the image */
    #sidebar-menu ul li a i.bi-grid,
    #sidebar-menu ul li a i.ri-wallet-3-line,
    #sidebar-menu ul li a i.ri-settings-4-line {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

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

<!-- MetisMenu Initialization Script -->
<script>
    $(document).ready(function() {
        // Initialize MetisMenu
        $("#side-menu").metisMenu();

        // Add active class to current menu item based on URL
        var currentPage = window.location.href;

        // Handle menu items highlighting
        $("#sidebar-menu a").each(function() {
            var menuUrl = $(this).attr("href");
            if (menuUrl && currentPage.indexOf(menuUrl) > -1) {
                $(this).addClass("active");

                // If it's a submenu item
                if ($(this).parent().parent().hasClass("sub-menu")) {
                    $(this).parent().addClass("mm-active");
                    $(this).parent().parent().addClass("mm-show");
                    $(this).parent().parent().prev().addClass("active").addClass("mm-active");
                }

                // If it has siblings with the has-arrow class
                if ($(this).siblings().hasClass("has-arrow")) {
                    $(this).parent().addClass("mm-active");
                }
            }
        });

        // Handle the sidebar toggle
        $("#vertical-menu-btn").on("click", function() {
            $("body").toggleClass("sidebar-enable");

            if ($(window).width() >= 992) {
                $("body").toggleClass("vertical-collpsed");

                // Toggle the menu width
                if ($("body").hasClass("vertical-collpsed")) {
                    $(".vertical-menu").css("width", "70px");
                    $(".main-content").css("margin-left", "70px");

                    // Hide text, show only icons
                    $("#sidebar-menu span, #sidebar-menu .menu-title").hide();
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "0",
                        "display": "block"
                    });
                } else {
                    $(".vertical-menu").css("width", "250px");
                    $(".main-content").css("margin-left", "250px");

                    // Show text and icons
                    $("#sidebar-menu span, #sidebar-menu .menu-title").show();
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "10px",
                        "display": "inline-flex"
                    });
                }
            }
        });

        // Handle window resize
        $(window).on("resize", function() {
            if ($(window).width() < 992) {
                $("body").addClass("vertical-collpsed");
                $(".vertical-menu").css("width", "70px");
                $(".main-content").css("margin-left", "0");

                if (!$("body").hasClass("sidebar-enable")) {
                    $(".vertical-menu").css("left", "-70px");
                }
            } else {
                if (!$("body").hasClass("vertical-collpsed")) {
                    $("body").removeClass("vertical-collpsed");
                    $(".vertical-menu").css("width", "250px");
                    $(".main-content").css("margin-left", "250px");

                    // Show text and icons
                    $("#sidebar-menu span, #sidebar-menu .menu-title").show();
                    $("#sidebar-menu ul li a i").css({
                        "margin-right": "10px",
                        "display": "inline-flex"
                    });
                }
            }
        }).trigger("resize");
    });
</script>

@stack('before_scripts')
@yield('scripts')
@stack('after_scripts')
</body>

</html>
