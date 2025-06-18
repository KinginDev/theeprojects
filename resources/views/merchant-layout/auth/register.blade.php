<!doctype html>
<html lang="en">
@php
    $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
@endphp

<head>
    <meta charset="utf-8" />
    <title>Register | {{ $configuration->site_name }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
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

        /* Bold and Large Text Style */
        .text-bold-large {
            color: {{ $configuration->test_color }};
            font-weight: bold;
            font-size: 1.25rem;
        }

        /* Logo Style */
        .auth-logo img {
            filter: drop-shadow(2px 4px 6px rgba(0, 0, 0, 0.3));
        }

        /* Additional Spacing */
        .mt-5 {
            margin-top: 3rem !important;
        }

        /* Additional Styles for Labels and Errors */
        .form-label {
            font-size: 14px;
            color: #555;
        }

        .alert {
            margin-bottom: 20px;
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
                        </div>
                    </div>

                    <h4 class="text-center font-size-18 text-bold-large"><b>Register as a Merchant</b></h4>

                    <div class="p-3">
                        <form action="{{ route('merchant.register.submit') }}" method="post">
                            @csrf
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('name') is-invalid @enderror" type="text" required="" placeholder="Merchant Name"
                                        id="name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('email') is-invalid @enderror" type="email" required="" placeholder="Email"
                                        id="email" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input id="user" class="form-control @error('tel') is-invalid @enderror" type="text" required=""
                                        placeholder="Phone number" name="tel" value="{{ old('tel') }}">
                                    @error('tel')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('address') is-invalid @enderror" type="text" required="" placeholder="Address"
                                        id="address" name="address" value="{{ old('address') }}">
                                    @error('address')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            @php
                                $referral = request('ref'); // Get the 'ref' parameter from the URL
                            @endphp
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('referral') is-invalid @enderror" type="text"
                                        placeholder="Referral username [optional]" id="referral" name="referral"
                                        value="{{ old('referral', $referral) }}">
                                    @error('referral')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <!-- Set value to the 'ref' parameter if available, or leave it empty -->
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password" required=""
                                        placeholder="Password" id="password" name="password">
                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" required=""
                                        placeholder="Confirm password" id="password_confirmation" name="password_confirmation">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mb-3 row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input @error('terms') is-invalid @enderror" id="remember"
                                            name="terms">
                                        <label class="form-label ms-1 fw-normal" for="customCheck1">I accept <a
                                                href="#" class="text-muted">Terms and Conditions</a></label>
                                        @error('terms')
                                            <span class="invalid-feedback d-block" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center row mt-3 pt-1">
                                <div class="col-12">
                                    <button class="btn btn-org w-100 waves-effect waves-light"
                                        type="submit">Register</button>
                                </div>
                            </div>
                            <div class="form-group mt-2 mb-0 row">
                                <div class="col-12 mt-3 text-center">
                                    <a href="{{ route('merchant.login') }}" class="text-muted">Already have an account?</a>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".alert").delay(5000).fadeOut(300, function() {
                $(this).remove();
            });
        });
    </script>
</body>

</html>
