<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title',  $configuration->site_name) - Merchant Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Merchant Dashboard" name="description" />
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSS Dependencies -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('assets/style/cost.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.2/css/dataTables.bootstrap5.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
    <!-- ApexCharts -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.41.0/dist/apexcharts.css" rel="stylesheet">

    @stack('before_styles')
    @yield('styles')
    <style>
        :root {
            --merchant-primary: {{ $configuration->template_color ?? '#3a7cfd' }};
            --merchant-primary-rgb: 58, 124, 253;
            --merchant-secondary: {{ $configuration->header_color ?? '#2c3e50' }};
            --merchant-text: {{ $configuration->test_color ?? '#333' }};
            --merchant-light: #f8f9fa;
            --merchant-dark: #343a40;
            --merchant-success: #10b981;
            --merchant-info: #3b82f6;
            --merchant-warning: #f59e0b;
            --merchant-danger: #ef4444;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* Modern Header Styles for Merchant */
        #page-topbar {
            backdrop-filter: blur(10px);
            background: var(--merchant-secondary) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            height: 70px;
        }

        .logo-lg {
            height: 40px !important;
            transition: all 0.3s ease;
        }

        .navbar-header {
            padding: 0 1.5rem;
            height: 70px;
        }

        .header-item {
            height: 70px;
            display: flex;
            align-items: center;
        }

        /* Merchant-specific styling */
        .merchant-badge {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            font-size: 0.7rem;
            padding: 0.2rem 0.6rem;
            border-radius: 1rem;
            margin-left: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Simplified Sidebar Navigation Styling */
        .vertical-menu {
            width: 250px;
            background: #ffffff;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.03);
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            z-index: 1000;
            transition: width 0.25s ease-in-out;
            overflow: hidden;
        }

        /* Fix for collapsed state */
        body.vertical-collpsed .vertical-menu {
            overflow: visible;
        }

        body[data-sidebar="dark"] .vertical-menu {
            background: #2a3042;
        }

        #layout-wrapper {
            min-height: 100vh;
            overflow: hidden;
        }

        .main-content {
            margin-left: 250px;
            padding: 90px 24px 60px;
            transition: margin-left 0.25s ease-in-out;
        }

        .vertical-menu-enable .main-content {
            margin-left: 250px;
        }

        body.sidebar-enable .vertical-menu {
            left: 0;
        }

        /* Vertical menu overlay for mobile */
        .vertical-menu-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
            transition: all 0.3s;
        }

        .vertical-menu-overlay.active {
            display: block;
        }

        /* Improved icon alignment in collapsed state */
        body.vertical-collpsed #sidebar-menu ul li {
            position: relative;
            text-align: center;
        }

        body.vertical-collpsed #sidebar-menu ul li a {
            padding: 15px 0;
            text-align: center;
        }

        body.vertical-collpsed #sidebar-menu ul li a i {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            float: none;
        }

        /* General Menu Transition Effects */
        .vertical-menu {
            transition: width 0.25s ease-in-out;
        }

        #sidebar-menu ul li a span {
            transition: opacity 0.25s ease-in-out;
        }

        #sidebar-menu ul li a i {
            transition: all 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .main-content {
            transition: margin-left 0.25s ease-in-out;
        }

        /* Improved vertical-collapsed mode transition */
        body.vertical-collpsed .vertical-menu {
            overflow: visible;
        }

        @media (max-width: 991.98px) {
            .vertical-menu {
                left: -250px;
            }

            .main-content {
                margin-left: 0;
                padding: 90px 12px 60px;
            }

            body.sidebar-enable .vertical-menu {
                left: 0;
            }
        }        #sidebar-menu ul li a {
            padding: 0.85rem 1.2rem;
            color: #555;
            font-weight: 500;
            position: relative;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin: 0 10px 3px;
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #sidebar-menu ul li a i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 32px;
            width: 32px;
            min-width: 32px;
            background: rgba(var(--merchant-primary-rgb), 0.1);
            border-radius: 8px;
            color: var(--merchant-primary);
            margin-right: 10px;
            transition: all 0.3s;
        }        /* Simplified collapsed menu styles */
        body.vertical-collpsed .vertical-menu {
            width: 70px !important;
            z-index: 5;
            overflow: visible;
        }

        body.vertical-collpsed .main-content {
            margin-left: 70px;
        }

        body.vertical-collpsed #sidebar-menu ul li a {
            padding: 15px 0;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50px;
            position: relative;
        }

        body.vertical-collpsed #sidebar-menu ul li a i {
            margin: 0 auto !important;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            min-width: 36px;
            position: relative;
            border-radius: 8px;
        }

        body.vertical-collpsed #sidebar-menu ul li a span {
            display: none;
            opacity: 0;
        }

        body.vertical-collpsed #sidebar-menu .menu-title {
            display: none;
        }

        body.vertical-collpsed #sidebar-menu ul li.mm-active .sub-menu {
            display: none;
        }

        /* Show submenu on hover for collapsed menu */
        body.vertical-collpsed #sidebar-menu ul li {
            position: relative;
        }        body.vertical-collpsed #sidebar-menu ul li:hover > a {
            position: relative;
            color: var(--merchant-primary);
            width: auto;
            background-color: rgba(var(--merchant-primary-rgb), 0.08);
            border-left: 3px solid var(--merchant-primary);
        }

        /* Enhanced visual indicator for menu items with submenus */
        body.vertical-collpsed #sidebar-menu ul li a.has-arrow:after {
            display: none;
        }

        body.vertical-collpsed #sidebar-menu ul li a.has-arrow:before {
            content: '\F0142';
            font-family: "Material Design Icons";
            position: absolute;
            right: 5px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 18px;
            opacity: 0;
            transition: all 0.2s ease;
        }

        body.vertical-collpsed #sidebar-menu ul li:hover > a.has-arrow:before {
            opacity: 1;
            right: 10px;
        }

        /* Add visual indicator for items with submenus */
        body.vertical-collpsed #sidebar-menu ul li a.has-arrow:after {
            content: '';
            position: absolute;
            top: 12px;
            right: 12px;
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: var(--merchant-primary);
            display: block;
            opacity: 0.7;
        }

        /* Improve submenu active state */
        body.vertical-collpsed #sidebar-menu ul li.submenu-active > a {
            background-color: rgba(var(--merchant-primary-rgb), 0.08);
        }        /* Simplified tooltip on hover */
        body.vertical-collpsed #sidebar-menu ul li a:not(.has-arrow):hover:after {
            content: attr(data-title);
            position: absolute;
            left: 70px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1001;
            background: white;
            padding: 8px 12px;
            border-radius: 4px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            white-space: nowrap;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            pointer-events: none;
            opacity: 1;
            visibility: visible;
            border-left: 3px solid var(--merchant-primary);
            max-width: 200px;
            text-overflow: ellipsis;
            overflow: hidden;
        }/* Improved icon centering in collapsed mode */
        body.vertical-collpsed #sidebar-menu ul li a i {
            display: flex !important;
            align-items: center;
            justify-content: center;
            margin: 0 auto !important;
            float: none;
            height: 36px;
            width: 36px;
            min-width: 36px;
            line-height: 36px;
            position: relative;
            font-size: 17px;
            border-radius: 10px;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        /* Enhanced icon alignment and hover effects */
        body.vertical-collpsed #sidebar-menu ul li a {
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0;
            margin: 3px 0;
            position: relative;
        }

        /* Improved hover effect for icons in collapsed mode */
        body.vertical-collpsed #sidebar-menu ul li a:hover i {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(var(--merchant-primary-rgb), 0.2);
        }

        /* Enhanced active menu state in collapsed mode */
        body.vertical-collpsed #sidebar-menu ul li.mm-active > a {
            border-left: 3px solid var(--merchant-primary);
            background: rgba(var(--merchant-primary-rgb), 0.08);
            position: relative;
        }

        body.vertical-collpsed #sidebar-menu ul li.mm-active > a:after {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background-color: var(--merchant-primary);
        }

        body.vertical-collpsed #sidebar-menu ul li.mm-active > a i {
            background: var(--merchant-primary);
            color: white;
            box-shadow: 0 4px 10px rgba(var(--merchant-primary-rgb), 0.3);
        }

        body.vertical-collpsed #sidebar-menu ul li:hover > ul.sub-menu {
            display: block !important;
            left: 70px;
            position: absolute;
            width: 220px;
            height: auto !important;
            top: 0;
            z-index: 1001;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 0 8px 8px 0;
            padding: 10px 0;
            margin-top: 0;
            margin-left: 0;
            border-left: 3px solid var(--merchant-primary);
            animation: fadeInRight 0.2s ease-out;
            opacity: 1;
            visibility: visible;
        }

        /* Fix for submenu initial state */
        body.vertical-collpsed #sidebar-menu ul li ul.sub-menu {
            display: none;
            opacity: 0;
            visibility: hidden;
        }

        /* Enhanced Submenu CSS Rules */
        #sidebar-menu ul li ul.sub-menu {
            padding: 0;
            margin-left: 42px;
            list-style: none;
            transition: all 0.2s ease-in-out;
        }

        #sidebar-menu ul li ul.sub-menu.mm-show {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
        }

        #sidebar-menu ul li ul.sub-menu:not(.mm-show) {
            display: none !important;
        }

        /* Improved submenu styling in expanded mode */
        #sidebar-menu ul li ul.sub-menu li a {
            padding: 8px 15px;
            font-size: 0.875rem;
            color: #555;
            display: block;
            position: relative;
            margin-bottom: 5px;
            transition: all 0.2s ease-in-out;
            border-radius: 6px;
        }

        #sidebar-menu ul li ul.sub-menu li a:hover {
            color: var(--merchant-primary);
            background-color: rgba(var(--merchant-primary-rgb), 0.08);
            padding-left: 18px;
        }

        /* Fix for collapsed mode submenu display */
        body.vertical-collpsed #sidebar-menu > ul > li > ul.sub-menu {
            position: absolute;
            left: 70px;
            top: 0;
            width: 220px;
            background: #fff;
            padding: 10px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border-radius: 0 8px 8px 0;
            border-left: 3px solid var(--merchant-primary);
            margin-left: 0;
        }

        /* Active menu item styling */
        #sidebar-menu ul li.mm-active > a {
            color: var(--merchant-primary);
            background-color: rgba(var(--merchant-primary-rgb), 0.1);
            font-weight: 600;
        }

        #sidebar-menu ul li.mm-active > ul.sub-menu li.mm-active > a {
            color: var(--merchant-primary);
            font-weight: 600;
        }
        </style>
    @stack('after_styles')
</head>

<body data-topbar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex align-items-center">
                    <div class="navbar-brand-box">

                        <a href="{{ route('merchant.dashboard') }}" class="logo logo-light">

                            <span class="logo-lg d-flex align-items-center">
                                @if(isset($configuration->site_logo))
                                    <img src="{{ asset('storage/' . $configuration->site_logo) }}" alt="logo-light" height="32">
                                @else
                                    <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo-light" height="32">
                                @endif
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn header-item waves-effect ms-2"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <!-- Wallet Balance -->
                    <div class="d-none d-md-block ms-3 me-3">
                        <div class="bg-soft-primary px-3 py-1 rounded-pill d-flex align-items-center">
                            <i class="ri-wallet-3-fill me-1 text-primary"></i>
                            <span class="fw-semibold">₦{{ number_format(Auth::guard('merchant')->user()->wallet->balance ?? 0, 2) }}</span>
                            <a href="#" class="btn btn-sm btn-primary ms-2 rounded-pill px-2 py-0" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center1">
                                <i class="ri-add-line"></i> Fund
                            </a>
                        </div>
                    </div>

                    <!-- Notifications -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-lg p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="d-flex align-items-center">
                                    <h6 class="mb-0">Notifications</h6>
                                    <div class="ms-auto">
                                        <a href="#" class="small">Mark all as read</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-shopping-cart-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">New transaction completed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Transaction ID: #TRX123456</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hour ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <a class="btn btn-sm btn-link font-size-14 w-100 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> View More
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- User profile -->
                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="d-none d-xl-inline-block ms-1 me-1">{{ Auth::guard('merchant')->user()->name ?? 'Merchant' }}</span>
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/avatar-1.png') }}"
                                alt="Header Avatar">
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
                            <a class="dropdown-item d-block" href="#"><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('merchant.logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>


        <!-- ========== Left Sidebar Start ========== -->
        @include('merchant-layout.partials.vertical-menu')
        <!-- Left Sidebar End -->

        <div class="vertical-menu-overlay"></div>

