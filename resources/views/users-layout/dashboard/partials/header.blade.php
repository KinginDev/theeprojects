@php
    use App\Classes\Helper;

@endphp

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Your Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ secure_asset('assets/images/favicon.png') }}">

    <!-- CSS Dependencies -->
    <link href="{{ secure_asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ secure_asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/style/cost.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <!-- ApexCharts -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.css" rel="stylesheet">
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
      <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <style>
        :root {
            --header-bg: {{ $configuration->header_color }};
            --primary-color: {{ $configuration->template_color }};
            --text-color: {{ $configuration->test_color }};
        }

        /* Modern Header Styles */
        #page-topbar {
            backdrop-filter: blur(10px);
            background: {{ $configuration->header_color }} !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }

        .navbar-header {
            padding: 0 1.5rem;
            height: 70px;
        }

        .header-profile-user {
            height: 40px;
            width: 40px;
            background-color:{{ $configuration->template_color }};
            padding: 3px;
            border: 2px solid rgba(255,255,255,0.2);
        }

        /* Modern Sidebar Styles */
        .vertical-menu {
            background: #fff;
            border-right: 1px solid rgba(0,0,0,0.05);
            box-shadow: 0 0 15px rgba(0,0,0,0.03);
        }

        #sidebar-menu ul li a {
            padding: .85rem 1.5rem;
            color: var(--text-color);
            font-size: .95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        #sidebar-menu ul li a i {
            height: 28px;
            width: 28px;
            background: rgba(var(--primary-color-rgb), 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            margin-right: 10px;
            font-size: 1.1rem;
            color: var(--primary-color);
            transition: all 0.3s ease;
        }

        #sidebar-menu ul li a:hover {
            color: var(--primary-color);
            background: rgba(var(--primary-color-rgb), 0.05);
        }

        #sidebar-menu ul li a:hover i {
            background: var(--primary-color);
            color: #fff;
        }

        #sidebar-menu ul li.mm-active > a {
            color: var(--primary-color);
            background: rgba(var(--primary-color-rgb), 0.05);
        }

        #sidebar-menu ul li.mm-active > a i {
            background: var(--primary-color);
            color: #fff;
        }

        .navbar-brand-box {
            background: transparent !important;
            padding: 1.5rem;
        }

        .logo-dark, .logo-light {
            height: 40px;
            transition: all 0.3s ease;
        }

        /* Modern Dropdown Styles */
        .dropdown-menu {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 1rem 0;
        }

        .dropdown-item {
            padding: .7rem 1.5rem;
            font-weight: 500;
            color: var(--primary-color);
        }

        /* Modern Button Styles */
        .header-item {
            color: rgba(255,255,255,0.85) !important;
            height: 70px;
            border: none;
            transition: all 0.3s ease;
        }

        .header-item:hover {
            color: #fff !important;
            background: rgba(255,255,255,0.1);
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .vertical-menu {
         }
        }

        /* Mobile Responsive */
        @media (max-width: 992px) {
            .vertical-menu {
                display: none;
            }

            .navbar-header {
                padding: 0 1rem;
            }

            #page-topbar {
                position: fixed;
                width: 100%;
                z-index: 1000;
            }

            .navbar-brand-box {
                padding: 1rem;
            }
        }
    </style>
    @yield('styles')
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.min.js"></script>
    <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
</head>

<body data-topbar="dark" data-layout="vertical" data-layout-mode="light">
    <div id="layout-wrapper">
        <!-- Header -->
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex align-items-center">
                    <!-- Logo -->
                    <div class="navbar-brand-box">
                        <a href="{{ route('users.dashboard', ['slug' => Helper::merchant()->slug]) }}" class="logo">
                            <span class="logo-sm">
                                <img src="{{ asset('storage/' . $configuration->site_logo) }}" alt="logo" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('storage/' . $configuration->site_logo) }}" alt="logo" height="40">
                            </span>
                        </a>
                    </div>

                    <!-- Menu Toggle -->
                    <button type="button" class="btn btn-sm header-item" id="vertical-menu-btn">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                </div>

                <div class="d-flex align-items-center">
                    <!-- Fullscreen Toggle -->
                    <button type="button" class="btn header-item noti-icon" data-toggle="fullscreen">
                        <i class="bi bi-arrows-fullscreen"></i>
                    </button>

                    <!-- Dark Mode Toggle -->
                    <button type="button" class="btn header-item noti-icon" id="mode-setting-btn">
                        <i class="bi bi-moon"></i>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item d-flex align-items-center"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                 src="{{ asset('assets/images/users/avatar-3.png') }}"
                                 alt="Profile">
                            <span class="d-none d-xl-inline-block ms-2 fw-medium">
                                {{ auth()->user()->username }}
                            </span>
                            <i class="bi bi-chevron-down d-none d-xl-inline-block ms-1"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ route('users.user.setting', ['slug' => Helper::merchant()->slug]) }}">
                                <i class="bi bi-person me-2"></i> Profile
                            </a>
                            <a class="dropdown-item d-flex align-items-center"
                               href="{{ route('users.usersupport', ['slug' => Helper::merchant()->slug]) }}">
                                <i class="bi bi-headset me-2"></i> Support
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item d-flex align-items-center text-danger"
                               href="{{ route('logout', ['slug' => Helper::merchant()->slug]) }}">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </div>
                    </div>

                    <!-- Settings -->
                    <button type="button" class="btn header-item noti-icon"
                            onclick="window.location.href='{{ route('users.user.setting', ['slug' => Helper::merchant()->slug]) }}'">
                        <i class="bi bi-gear"></i>
                    </button>
                </div>
            </div>
        </header>

        <!-- Sidebar -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title"><span>MAIN MENU</span></li>

                        <li>
                            <a href="{{ route('users.dashboard', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-grid"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title"><span>SERVICES</span></li>

                        <li>
                            <a href="{{ route('users.airtime', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-phone"></i>
                                <span>Airtime</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.data', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-wifi"></i>
                                <span>Internet Data</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.electricity', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-lightning-charge"></i>
                                <span>Electricity</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.tv', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-tv"></i>
                                <span>TV Subscription</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.education', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-book"></i>
                                <span>Education</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.insurance', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-shield-check"></i>
                                <span>Insurance</span>
                            </a>
                        </li>

                        <li class="menu-title"><span>FINANCE</span></li>

                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="bi bi-wallet2"></i>
                                <span>Fund Wallet</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li>
                                    <a href="{{ route('users.dashboard', ['action' => 'showModal', 'slug' => Helper::merchant()->slug]) }}">
                                        Quick Fund
                                    </a>
                                </li>
                                <li><a href="#">Bank Transfer</a></li>
                            </ul>
                        </li>

                        <li class="menu-title"><span>ACCOUNT</span></li>

                        <li>
                            <a href="{{ route('users.usertransactions', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-clock-history"></i>
                                <span>History</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.usersupport', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-headset"></i>
                                <span>Support</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('users.user.setting', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect">
                                <i class="bi bi-gear"></i>
                                <span>Settings</span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('logout', ['slug' => Helper::merchant()->slug]) }}" class="waves-effect text-danger">
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dark mode toggle
        document.getElementById('mode-setting-btn').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            const icon = this.querySelector('i');
            if (document.body.classList.contains('dark-mode')) {
                icon.classList.remove('bi-moon');
                icon.classList.add('bi-sun');
            } else {
                icon.classList.remove('bi-sun');
                icon.classList.add('bi-moon');
            }
        });

        // Mobile menu toggle
        document.getElementById('vertical-menu-btn').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-enable');
        });

        // Fullscreen toggle
        document.querySelector('[data-toggle="fullscreen"]').addEventListener('click', function() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen();
                this.querySelector('i').classList.remove('bi-arrows-fullscreen');
                this.querySelector('i').classList.add('bi-fullscreen-exit');
            } else {
                document.exitFullscreen();
                this.querySelector('i').classList.remove('bi-fullscreen-exit');
                this.querySelector('i').classList.add('bi-arrows-fullscreen');
            }
        });
    </script>
</body>
</html>
