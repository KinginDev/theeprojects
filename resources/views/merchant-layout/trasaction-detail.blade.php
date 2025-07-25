<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8" />
    <title>Transaction View page | Eproject </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <meta content="" name="description" /> -->
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.png">

    <!-- jquery.vectormap css -->
    <link href="assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet"
        type="text/css" />

    <!-- DataTables -->
    <link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"
        type="text/css" />

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="/assets/style/cost.css">

</head>

<body data-topbar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

    <!-- Begin page -->
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-dark.png" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="assets/images/logo-sm.png" alt="logo-sm-light" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="assets/images/logo-light.png" alt="logo-light" height="35">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect"
                        id="vertical-menu-btn">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>


                </div>


                <!-- Container holding profiles-->

                <div class="d-flex">


                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="notification.html" class="small"> View All</a>
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
                                            <h6 class="mb-1">Data 500MB</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">Your MTN Data Purchase was successful.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>


                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="notification.html">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-3.png"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">Nemerem</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Account
                                Setting</a>
                            <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My
                                Wallet</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item text-danger" href="/index.html"><i
                                    class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                            <i class="ri-settings-2-line"></i>
                        </button>
                    </div>

                </div>

                <!-- Container holding profiles ends here-->

            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        <li class="menu-title">Menu</li>

                        <li>
                            <a href="dashboard.html" class="waves-effect">
                                <i class="bi bi-grid"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>


                        <li>
                            <a href="airtime.html" class="waves-effect">
                                <i class="ri-phone-line"></i>
                                <span>Buy Airtime</span>
                            </a>
                        </li>

                        <li>
                            <a href="data.html" class=" waves-effect">
                                <i class=" ri-wifi-line"></i>
                                <span>Buy Internet Data</span>
                            </a>
                        </li>

                        <li>
                            <a href="electricity.html" class=" waves-effect">
                                <i class=" ri-lightbulb-flash-line"></i>
                                <span>Buy Electricity</span>
                            </a>
                        </li>

                        <li>
                            <a href="tv.html" class=" waves-effect">
                                <i class=" ri-tv-line"></i>
                                <span>Buy Tv Subscription</span>
                            </a>
                        </li>


                        <li>
                            <a href="javascript: void(0);" class="has-arrow waves-effect">
                                <i class="ri-bill-line"></i>
                                <span>Pay Bills</span>
                            </a>
                            <ul class="sub-menu" aria-expanded="false">
                                <li> <a href="betting.html">Betting</a></li>
                                <li><a href="Flight.html">Book Flight</a></li>
                            </ul>
                        </li>

                        <li class="menu-title">Others</li>

                        <li>
                            <a href="tv.html" class=" waves-effect">
                                <i class=" ri-history-line"></i>
                                <span>Transaction History</span>
                            </a>
                        </li>

                        <li>
                            <a href="tv.html" class=" waves-effect">
                                <i class="ri-shut-down-line"></i>
                                <span>Logout</span>
                            </a>
                        </li>

                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>
        <!-- Left Sidebar End -->



        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h4 class="mb-sm-0">Transaction View</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                        <li class="breadcrumb-item active">Trasaction view</li>
                                    </ol>
                                </div>



                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <!-- Container to hold the main page elements-->

                    <div class="container main-tags">
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="h6">
                                    Please Confirm your Transaction Details are as Follows:
                                </div> <br>

                                <div class="card  moni-card">
                                    <div class="tran-items">

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Product Name</p>
                                            <p class="d-flex"> <img src="/assets/images/brands/Airtel.png" width="20"
                                                    alt=""> <span class="ms-2">Airtel Airtime</span></p>
                                        </div>

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Phone number</p>
                                            <p class="d-flex"> <span class="ms-2">09021233422</span></p>
                                        </div>

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Amount</p>
                                            <p class="d-flex"> <span class="ms-2">₦2000</span> </p>
                                        </div>


                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Transaction Fee</p>
                                            <p class="d-flex"> <span class="ms-2">₦0</span> </p>
                                        </div>

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Total Amount</p>
                                            <p class="d-flex"> <span class="ms-2">₦2000</span></p>
                                        </div>

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Transaction ID </p>
                                            <p class="d-flex"> <span class="ms-2">45678987654324562</span></p>
                                        </div>

                                        <div class="d-flex tran-item">
                                            <p class="text-gray">Status</p>
                                            <p class="d-flex"> <span class="ms-2">Initiated</span></p>
                                        </div>




                                    </div>
                                    <button class="btn p-12 btn-org"> Confirm</button>
                                </div>
                            </div>




                        </div>
                    </div>
                    <!-- Container to hold the main page elements ends here-->

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <script>document.write(new Date().getFullYear())</script> © {{ $configuration->site_name }}.
                        </div>

                    </div>
                </div>
            </footer>

        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->

    <!-- Right Sidebar -->
    <div class="right-bar">
        <div data-simplebar class="h-100">
            <div class="rightbar-title d-flex align-items-center px-3 py-4">

                <h5 class="m-0 me-2">Settings</h5>

                <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                    <i class="mdi mdi-close noti-icon"></i>
                </a>
            </div>

            <!-- Settings -->
            <hr class="mt-0" />
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <div class="p-4">
                <div class="mb-2">
                    <img src="assets/images/layouts/layout-1.jpg" class="img-fluid img-thumbnail" alt="layout-1">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-2.jpg" class="img-fluid img-thumbnail" alt="layout-2">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch"
                        data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <div class="mb-2">
                    <img src="assets/images/layouts/layout-3.jpg" class="img-fluid img-thumbnail" alt="layout-3">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch"
                        data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>


            </div>

        </div> <!-- end slimscroll-menu-->
    </div>
    <!-- /Right-bar -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <!-- JAVASCRIPT -->
    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="assets/libs/simplebar/simplebar.min.js"></script>
    <script src="assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>
