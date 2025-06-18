<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Your Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <!-- CSS Dependencies -->
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/assets/style/cost.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://sdk.monnify.com/plugin/monnify.js"></script>
</head>

<body data-topbar="dark">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="logo-light" width="100%">
                            </span>
                        </a>
                    </div>
                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>
                </div>
                <div class="d-flex">
                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>
                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-3.png" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">{{ auth()->user()->username }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('user.setting') }}"><i class="ri-user-line align-middle me-1"></i> Edit Profile</a>
                            <a class="dropdown-item" href="{{ route('usersupport') }}"><i class="ri-mail-send-line align-middle me-1"></i> Support</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="{{ route('logout') }}"><i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                        </div>
                    </div>
                    <div class="dropdown d-inline-block">
                        <a href="{{ route('user.setting') }}"><button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="ri-settings-2-line"></i>
                        </button></a>
                    </div>
                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">
            <div data-simplebar class="h-100">
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        @php
                            // Retrieve the currently authenticated user
                            $user = auth()->user();

                            // Retrieve active pages for the authenticated user
                            $pages = \App\Models\merchants::where('action', 1)->get(); // Adjust the model path if necessary
                        @endphp

                        <!-- Check if user role is Merchant (1) -->
                        @if ($user->role == 2)
                            @foreach ($pages as $page)
                                @if ($page->id >= 18 && $page->id <= 32)
                                    <li>
                                        <a href="{{ route($page->pages_id) }}" class="waves-effect">
                                            <i class="ri-icon-name"></i> <!-- Replace with actual icon -->
                                            <span>{{ $page->pages }}</span>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <!-- For other roles, display all menu items -->
                            <li>
                                <a href="{{ route('dashboard') }}" class="waves-effect">
                                    <i class="bi bi-grid"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('airtime') }}" class="waves-effect">
                                    <i class="ri-phone-line"></i>
                                    <span>Buy Airtime</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('data') }}" class="waves-effect">
                                    <i class="ri-wifi-line"></i>
                                    <span>Buy Internet Data</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('electricity') }}" class="waves-effect">
                                    <i class="ri-lightbulb-flash-line"></i>
                                    <span>Buy Electricity</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('tv') }}" class="waves-effect">
                                    <i class="ri-tv-line"></i>
                                    <span>Buy TV Subscription</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('education') }}" class="waves-effect">
                                    <i class="ri-book-line"></i>
                                    <span>Education</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('insurance') }}" class="waves-effect">
                                    <i class="ri-shield-line"></i>
                                    <span>Insurance</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="ri-bill-line"></i>
                                    <span>Fund Wallet</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('dashboard', ['action' => 'showModal']) }}">ATM/Transfer Funding</a></li>
                                    <li><a href="#">Automated Bank Funding</a></li>
                                    <li><a href="#">Manual Bank Funding</a></li>
                                </ul>
                            </li>

                            <li class="menu-title">Others</li>

                            <li>
                                <a href="{{ route('usertransactions') }}" class="waves-effect">
                                    <i class="ri-history-line"></i>
                                    <span>Transaction History</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('usersupport') }}" class="waves-effect">
                                    <i class="ri-customer-service-line"></i>
                                    <span>Support</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('user.setting') }}" class="waves-effect">
                                    <i class="ri-settings-line"></i>
                                    <span>Setting</span>
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
        <!-- Left Sidebar End -->
    </div>
</body>
</html>
