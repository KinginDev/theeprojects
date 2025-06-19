<!doctype html>
<html lang="en">

<head>
    @php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <meta charset="utf-8" />
    <title>Login page | {{ $configuration->site_name }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Stylesheets -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('/assets/style/cost.css') }}">

    <!-- Custom CSS -->
    <style>
        /* Background Style */
        body.auth-body-bg {
            background: {{ $configuration->template_color }};
            background-attachment: fixed;
            padding: 12px;
        }

        /* Card Style */
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        /* Form Style */
        .form-control {
            border-radius: 8px;
            padding: 15px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
            font-size: 16px;
        }

        /* Button Style */
        .btn-org {
            background-color: {{ $configuration->template_color }};
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-org:hover {
            background-color: #e55c00;
        }

        .custom-checkbox .custom-control-input:checked~.custom-control-label::before {
            background-color: {{ $configuration->template_color }};
            border-color: {{ $configuration->template_color }};
        }

        /* Link Style */
        .text-muted a {
            color: {{ $configuration->template_color }};
            transition: color 0.3s ease;
        }

        .text-muted a:hover {
            color: #e55c00;
            text-decoration: none;
        }

        /* Icon Style */
        .mdi {
            color: {{ $configuration->template_color }};
        }

        /* Logo Style */
        .auth-logo img {
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.3));
        }

        /* Text Style for Bold, Large Text */
        .text-bold {
            color: {{ $configuration->test_color }};
            font-weight: bold;
        }

        /* Footer background */
        footer {
            background-color: {{ $configuration->template_color }};
        }

        /* Additional Spacing */
        .mt-5 {
            margin-top: 3rem !important;
        }
    </style>

</head>

<body class="auth-body-bg">
    <div class="bg-overlay"></div>
    <div class="wrapper-page">
        <div class="container-fluid p-0">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mt-4">
                        <div class="mb-3">
                            <a href="" class="auth-logo">
                                <img src="{{ asset('storage/' . $configuration->site_logo) }}" height="50"
                                    class="logo-dark mx-auto" alt="">
                                <img src="{{ asset('storage/' . $configuration->site_logo) }}" height="50"
                                    class="logo-light mx-auto" alt="">
                            </a>
                        </div>
                    </div>

                    <div class="container mt-5">
                        <div class="mt-5">
                            @if ($errors->any())
                                <div class="col-12">
                                    @foreach ($errors->all() as $error)
                                        <div class="alert alert-danger">
                                            {{ $error }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if (session('success'))
                                <div class="col-12">
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 class="text-center font-size-18 text-bold"><b>Sign In</b></h4>

                    <div class="p-3">
                        <form action="{{ route('loginAction') }}" method="post">
                            @csrf
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" type="text" required
                                        placeholder="Email or Phone number" id="user" name="emailTel">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control" type="password" required placeholder="Password"
                                        id="pass" name="password">
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="remember"
                                            name="checkbox">
                                        <label class="form-label ms-1" for="customCheck1">Remember me</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3 text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-org w-100 waves-effect waves-light" type="submit">Log
                                        In</button>
                                </div>
                            </div>

                            <div class="form-group mb-0 row mt-2">
                                <div class="col-sm-7 mt-3">
                                    <a href="{{ route('forget_password') }}" class="text-muted"><i
                                            class="mdi mdi-lock"></i> Forgot your password?</a>
                                </div>
                                <div class="col-sm-5 mt-3">
                                    <a href="{{ route('registration',) }}" class="text-muted"><i
                                            class="mdi mdi-account-circle"></i> Create an account</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end -->
                </div>
                <!-- end cardbody -->
            </div>
            <!-- end card -->
        </div>
        <!-- end container -->
    </div>
    <!-- end -->

    <!-- Footer -->
    <footer class="text-white py-3">
        <div class="container text-center">
            <p>&copy; 2024 Your Company. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- CSRF for AJAX -->
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>

</html>
