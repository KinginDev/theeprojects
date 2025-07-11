<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>@yield('title', 'Your Default Title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
    <script src="https://sdk.monnify.com/plugin/monnify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.2/js/dataTables.bootstrap5.js"></script>

    @stack('before_styles')
    @yield('styles')
    @stack('after_styles')
</head>

<body data-topbar="dark">

    <div id="layout-wrapper">
        <header id="page-topbar" style="background-color:{{ $configuration->header_color }}">
            <div class="navbar-header">
                <div class="d-flex">
                    <div class="navbar-brand-box">
                        <a href="{{ route('merchant.dashboard') }}" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo-sm.png') }}" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo-dark" height="20">
                            </span>
                        </a>
                        <a href="{{ route('merchant.dashboard') }}" class="logo logo-light">
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


                <!-- For other roles, display all menu items -->
                <li>
                    <a href="{{ route('merchant.dashboard') }}" class="waves-effect">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.users', Auth::guard('merchant')->user()->id) }}"
                    class="waves-effect">
                    <i class="ri-user-line"></i>
                    <span>Manage users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.credit.user') }}" class="waves-effect">
                    <i class="ri-user-line"></i>
                    <span>Credit User account</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.transactions') }}" class="waves-effect">
                    <i class="ri-tv-line"></i>
                    <span>Transactions</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.airtime') }}" class="waves-effect">
                    <i class="ri-phone-line"></i>
                    <span>Airtime</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('merchant.data') }}" class="waves-effect">
                    <i class="ri-wifi-line"></i>
                    <span>Internet Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.electricity') }}" class="waves-effect">
                    <i class="ri-lightbulb-flash-line"></i>
                    <span>Electricity</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.tv') }}" class="waves-effect">
                    <i class="ri-tv-line"></i>
                    <span>Tv Subscription</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.education') }}" class="waves-effect">
                    <i class="ri-tv-line"></i>
                    <span>Education</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.insurance') }}" class="waves-effect">
                    <i class="ri-tv-line"></i>
                    <span>Insurance</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ri-pages-line"></i>
                    <span>CMS</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('merchant.pages.index') }}">Pages</a></li>
                    <li><a href="{{ route('merchant.menus.index') }}">Menus</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ri-bill-line"></i>
                    <span>Sub Merchants</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('merchant.manage-merchants') }}">View All</a></li>
                    <li><a href="{{ route('merchant.manage-roles') }}">Roles</a></li>
                    </ul>
                </li>
                 <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ri-bill-line"></i>
                    <span>Contact Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('merchant.message') }}">Messages</a></li>
                    <li><a href="{{ route('merchant.notification') }}">Notifications</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ri-bill-line"></i>
                    <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('merchant.site_setting') }}">Site Setting</a></li>
                    <li><a href="{{ route('merchant.edit_profile') }}">Edit Profile</a></li>

                </li>

                <li class="menu-title">Others</li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="ri-bill-line"></i>
                    <span>Fund Wallet</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                    <li><a href="{{ route('merchant.dashboard', ['action' => 'showModal']) }}">ATM/Transfer
                        Funding</a></li>
                    <li><a href="#">Automated Bank Funding</a></li>
                    <li><a href="#">Manual Bank Funding</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('merchant.walletSummary') }}" class="waves-effect">
                    <i class="ri-history-line"></i>
                    <span>Wallet summary</span>
                    </a>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('merchant.logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                    <a href="#" class="waves-effect" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="ri-shut-down-line"></i>
                    <span>Logout</span>
                    </a>
                </li>
                </ul>
            </div>
            </div>
        </div>
    </div>
</body>

</html>
