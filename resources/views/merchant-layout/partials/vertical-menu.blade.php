<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <!-- Merchant Profile Summary -->
        <div class="p-3 d-none d-md-block">
            <div class="merchant-profile-summary">
                <div class="d-flex align-items-center p-3">
                    <div class="flex-shrink-0">
                        <div class="avatar-md rounded-circle bg-white shadow-sm">
                            <img src="{{ asset('assets/images/users/avatar-1.png') }}" alt="Profile"
                                class="img-fluid rounded-circle">
                        </div>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-1 text-primary">{{ Auth::guard('merchant')->user()->name ?? 'Merchant' }}</h6>

                    </div>
                </div>
                <div class="row g-0 text-center border-top">
                    <div class="col-6 border-end">
                        <div class="p-2">
                            <h6 class="mb-1">
                                ₦{{ number_format(Auth::guard('merchant')->user()->wallet->balance ?? 0, 2) }}</h6>
                            <p class="text-muted mb-0 font-size-12">Balance</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2">
                            <h6 class="mb-1">{{ Auth::guard('merchant')->user()->users_count ?? 0 }}</h6>
                            <p class="text-muted mb-0 font-size-12">Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">
                    <span>MAIN MENU</span>
                </li>

                <!-- Dashboard -->
                <li>
                    <a href="{{ route('merchant.dashboard') }}" class="waves-effect" data-title="Dashboard">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <!-- User Management Section -->
                <li class="menu-title">
                    <span>USER MANAGEMENT</span>
                </li>
                <li>
                    <a href="{{ route('merchant.users', Auth::guard('merchant')->user()->id) }}" class="waves-effect"
                        data-title="Manage Users">
                        <i class="ri-user-line"></i>
                        <span>Manage Users</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.credit.user') }}" class="waves-effect" data-title="Credit User">
                        <i class="ri-wallet-3-line"></i>
                        <span>Credit User</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.transactions') }}" class="waves-effect" data-title="Transactions">
                        <i class="ri-exchange-dollar-line"></i>
                        <span>Transactions</span>
                    </a>
                </li>

                <!-- Services Section -->
                <li class="menu-title">
                    <span>SERVICES</span>
                </li>
                <li>
                    <a href="{{ route('merchant.airtime') }}" class="waves-effect" data-title="Airtime">
                        <i class="ri-phone-line"></i>
                        <span>Airtime</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.data') }}" class="waves-effect" data-title="Internet Data">
                        <i class="ri-wifi-line"></i>
                        <span>Internet Data</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.electricity') }}" class="waves-effect" data-title="Electricity">
                        <i class="ri-lightbulb-flash-line"></i>
                        <span>Electricity</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.tv') }}" class="waves-effect" data-title="TV Subscription">
                        <i class="ri-tv-2-line"></i>
                        <span>TV Subscription</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.education') }}" class="waves-effect" data-title="Education">
                        <i class="ri-book-2-line"></i>
                        <span>Education</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('merchant.insurance') }}" class="waves-effect" data-title="Insurance">
                        <i class="ri-shield-check-line"></i>
                        <span>Insurance</span>
                    </a>
                </li>

                <!-- CMS Section -->
                <li class="menu-title">
                    <span>CMS</span>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" data-title="Content">
                        <i class="ri-pages-line"></i>
                        <span>Content</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" data-title="Content">
                        <li><a href="{{ route('merchant.pages.index') }}">Pages</a></li>
                        <li><a href="{{ route('merchant.menus.index') }}">Menus</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" data-title="Sub Merchants">
                        <i class="ri-team-line"></i>
                        <span>Sub Merchants</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" data-title="Sub Merchants">
                        <li><a href="{{ route('merchant.manage-merchants') }}">View All</a></li>
                        <li><a href="{{ route('merchant.manage-roles') }}">Roles</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" data-title="Contact Users">
                        <i class="ri-message-3-line"></i>
                        <span>Contact Users</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" data-title="Contact Users">
                        <li><a href="{{ route('merchant.message') }}">Messages</a></li>
                        <li><a href="{{ route('merchant.notification') }}">Notifications</a></li>
                    </ul>
                </li>

                <!-- Settings Section -->
                <li class="menu-title">
                    <span>SETTINGS</span>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" data-title="Settings">
                        <i class="ri-settings-4-line"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" data-title="Settings">
                        <li><a href="{{ route('merchant.site_setting') }}">Site Settings</a></li>
                        <li><a href="{{ route('merchant.edit_profile') }}">Edit Profile</a></li>
                    </ul>
                </li>

                <!-- Finance Section -->
                <li class="menu-title">
                    <span>FINANCE</span>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect" data-title="Fund Wallet">
                        <i class="ri-bank-card-line"></i>
                        <span>Fund Wallet</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false" data-title="Fund Wallet">
                        <li><a href="{{ route('merchant.dashboard', ['action' => 'showModal']) }}">ATM/Transfer
                                Funding</a></li>
                        <li><a href="#">Automated Bank Funding</a></li>
                        <li><a href="#">Manual Bank Funding</a></li>
                    </ul>
                </li>
                <li>
                    <a href="{{ route('merchant.walletSummary') }}" class="waves-effect"
                        data-title="Wallet Summary">
                        <i class="ri-history-line"></i>
                        <span>Wallet Summary</span>
                    </a>
                </li>

                <li class="menu-title">
                    <span>ACCOUNT</span>
                </li>
                <li>
                    <form id="logout-form" action="{{ route('merchant.logout') }}" method="POST"
                        style="display: none;">
                        @csrf
                    </form>
                    <a href="#" class="waves-effect text-danger" data-title="Logout"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="ri-shut-down-line"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
