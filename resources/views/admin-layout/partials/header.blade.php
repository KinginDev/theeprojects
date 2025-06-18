<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Your Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- CSS Dependencies -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet"
        type="text/css" />
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>
</head>

<body data-topbar="dark">
    @php

        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <div id="layout-wrapper">
        <header id="page-topbar" style="background-color:{{ $configuration->header_color }}">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ route('admin.dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                            </span>
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm-light" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('storage/' . $configuration->site_logo) }}" alt="logo-light"
                                    width="100%">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>


                        @php
                            // Retrieve the currently authenticated user
                            $user = auth()->user();

                            // Retrieve active pages for the authenticated user
                            $pages = \App\Models\merchants::where('action', 1)->get(); // Adjust the model path if necessary
                        @endphp
                        <!-- Check if user role is Merchant (1) -->
                        @php
                            $icons = [
                                'admin.dashboard' => 'bi bi-grid', // Dashboard
                                'manage' => 'ri-user-line', // Manage users
                                'creditUserAccount' => 'ri-user-line', // Credit User account
                                'adminAirtime' => 'ri-phone-line', // Airtime
                                'adminData' => 'ri-wifi-line', // Internet Data
                                'adminElectricity' => 'ri-lightbulb-flash-line', // Electricity
                                'adminTv' => 'ri-tv-line', // Tv Subscription
                                'adminEducation' => 'ri-book-line', // Education
                                'adminInsurance' => 'ri-shield-line', // Insurance
                                'message' => 'ri-message-line', // Messages
                                'notification' => 'ri-notification-line', // Notifications
                                'site_setting' => 'ri-settings-line', // Site Setting
                                'edit_profile' => 'ri-pencil-line', // Edit Profile
                                'add_account' => 'ri-add-line', // Add New User/Merchant
                                'marchant' => 'ri-store-line', // View Merchant
                                'walletSummary.admin' => 'ri-history-line', // Wallet summary
                                'logout' => 'ri-shut-down-line', // Logout
                            ];

                        @endphp

                        @if ($user->role == 1)
                            @foreach ($pages as $page)
                                @if ($page->id >= 1 && $page->id <= 17)
                                    <li class="nav-item">
                                        <a href="{{ route($page->pages_id) }}"
                                            class="nav-link waves-effect d-flex align-items-center">
                                            <i class="{{ $icons[$page->pages_id] ?? 'ri-menu-line' }} me-2"></i>
                                            <span>{{ $page->pages }}</span>
                                            <span
                                                class="badge rounded-pill bg-info ms-auto">{{ $page->action ? 'Active' : 'Inactive' }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <!-- For other roles, display all menu items -->
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                                    <i class="bi bi-grid"></i>
                                    <span>Dashbaord</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('manage') }}" class="waves-effect">
                                    <i class="ri-user-line"></i>
                                    <span>Manage users</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('creditUserAccount') }}" class="waves-effect">
                                    <i class="ri-user-line"></i>
                                    <span>Credit User account</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminAirtime') }}" class="waves-effect">
                                    <i class="ri-phone-line"></i>
                                    <span>Airtime</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminData') }}" class="waves-effect">
                                    <i class="ri-wifi-line"></i>
                                    <span>Internet Data</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminElectricity') }}" class="waves-effect">
                                    <i class="ri-lightbulb-flash-line"></i>
                                    <span>Electricity</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminTv') }}" class="waves-effect">
                                    <i class="ri-tv-line"></i>
                                    <span>Tv Subscription</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminEducation') }}" class="waves-effect">
                                    <i class="ri-tv-line"></i>
                                    <span>Education</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('adminInsurance') }}" class="waves-effect">
                                    <i class="ri-tv-line"></i>
                                    <span>Insurance</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-bill-line"></i>
                                    <span>Contact Users</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('message') }}">Messages</a></li>
                                    <li><a href="{{ route('notification') }}">Notifications</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-bill-line"></i>
                                    <span>Settings</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('site_setting') }}">Site Setting</a></li>
                                    <li><a href="{{ route('edit_profile') }}">Edit Profile</a></li>
                                    <li><a href="{{ route('add_account') }}">Add New User/Marchant</a></li>
                                    <li><a href="{{ route('marchant') }}">View Marchant</a></li>
                                </ul>
                            </li>
                            <li class="menu-title">Others</li>
                            <li>
                                <a href="{{ route('walletSummary.admin') }}" class="waves-effect">
                                    <i class="ri-history-line"></i>
                                    <span>Wallet summary</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}" class="waves-effect">
                                    <i class="ri-shut-down-line"></i>
                                    <span>Logout</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
