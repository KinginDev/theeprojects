<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $configuration->site_description ?? 'Authentication page' }}">
    <meta name="author" content="{{ $configuration->site_author ?? 'Themesdesign' }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Login') | {{ $configuration->site_name }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- Core CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet">

    <!-- Additional CSS -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/style/cost.css') }}">

    <!-- Custom Styles -->
    <style>
        /* Background Style */
        body.auth-body-bg {
            background: {{ $configuration->template_color ?? '#f8f8f8' }};
            background-attachment: fixed;
            padding: 12px;
        }

        /* Card Style */
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }

        /* Form Style */
        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        /* Button Style */
        .btn-org {
            background-color: {{ $configuration->template_color ?? '#ff6b00' }};
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-org:hover {
            background-color: {{ $configuration->template_hover_color ?? '#e55c00' }};
            transform: translateY(-1px);
        }

        /* Checkbox Style */
        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: {{ $configuration->template_color ?? '#ff6b00' }};
            border-color: {{ $configuration->template_color ?? '#ff6b00' }};
        }

        /* Link Style */
        .text-muted a {
            color: {{ $configuration->template_color ?? '#ff6b00' }};
            transition: color 0.3s ease;
        }

        .text-muted a:hover {
            color: {{ $configuration->template_hover_color ?? '#e55c00' }};
            text-decoration: none;
        }

        /* Text Style */
        .text-bold {
            color: {{ $configuration->test_color ?? '#333333' }};
            font-weight: 700;
        }

        /* Alert Styles */
        .alert {
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 1rem;
        }

        /* Footer Style */
        footer {
            background-color: {{ $configuration->template_color ?? '#ff6b00' }};
            position: relative;
            padding: 1rem 0;
        }

        /* Logo Style */
        .auth-logo img {
            max-height: 60px;
            width: auto;
            filter: drop-shadow(1px 2px 3px rgba(0, 0, 0, 0.2));
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .wrapper-page {
                width: 95%;
                margin: 0 auto;
            }

            .card-body {
                padding: 1.5rem;
            }
        }
    </style>

    @yield('page_css')
</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-2">
                        <div class="mb-4">
                            <a href="{{ url('/') }}" class="auth-logo">
                                @if(isset($configuration->site_logo))
                                    <img src="{{ asset('storage/' . $configuration->site_logo) }}"
                                         alt="{{ $configuration->site_name ?? 'Site Logo' }}"
                                         class="logo-dark mx-auto">
                                @else
                                    <h3 class="text-bold">{{ $configuration->site_name ?? 'Site Name' }}</h3>
                                @endif
                            </a>
                        </div>
                    </div>

                    {{-- Alert Messages --}}
                    @if($errors->any() || session('success') || session('error') || session('warning') || session('info'))
                    <div class="alert-container">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @foreach(['success', 'error', 'warning', 'info'] as $type)
                            @if(session($type))
                                <div class="alert alert-{{ $type === 'error' ? 'danger' : $type }}">
                                    {{ session($type) }}
                                </div>
                            @endif
                        @endforeach
                    </div>
                    @endif

                    {{-- Main Content --}}
                    @yield('content')
                </div>
            </div>

            @yield('additional_content')
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-white">
        <div class="container text-center">
            <p class="mb-0">&copy; {{date('Y')}} {{ $configuration->site_name ?? 'Your Company' }}. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Common JS Functions -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            if (input) {
                input.type = input.type === 'password' ? 'text' : 'password';

                const icon = event.currentTarget.querySelector('i');
                if (icon) {
                    icon.classList.toggle('bi-eye');
                    icon.classList.toggle('bi-eye-slash');
                }
            }
        }

        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert:not(.alert-danger)').fadeOut('slow');
        }, 5000);
    </script>

    @yield('page_js')
</body>
</html>
