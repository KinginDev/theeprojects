@php
use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Cable Tv Subscription')

@push('after_styles')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $configuration->template_color ?? '#4F46E5' }};
            --primary-hover: {{ $configuration->template_color ? 'color-mix(in srgb, ' . $configuration->template_color . ' 80%, black)' : '#4338CA' }};
            --surface-color: #FFFFFF;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-300: #D1D5DB;
            --gray-400: #9CA3AF;
            --gray-500: #6B7280;
            --gray-600: #4B5563;
            --gray-700: #374151;
            --gray-800: #1F2937;
            --success-color: #10B981;
            --warning-color: #F59E0B;
            --error-color: #EF4444;
            --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --input-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --card-border-radius: 16px;
            --input-border-radius: 12px;
            --button-border-radius: 12px;
        }

        .tv-page {
            padding: 2rem;
            background-color: var(--gray-50);
        }

        .tv-card {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
             transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .tv-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        .provider-icon{
            width: 100px;
            height: 40px;
            border-radius: 20%;
        }

        .form-control {
            border: 2px solid var(--gray-200);
            border-radius: var(--input-border-radius);
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--surface-color);
            box-shadow: var(--input-shadow);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary-color) 15%, transparent);
            outline: none;
        }

        .form-label {
            font-weight: 500;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
            display: block;
        }

        .provider-select {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .provider-option {
            background: var(--surface-color);
            border: 2px solid var(--gray-200);
            border-radius: var(--card-border-radius);
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 120px;
        }

        .provider-option:hover {
            transform: translateY(-2px);
            border-color: var(--primary-color);
        }

        .provider-option.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--primary-color) 3%, transparent),
                color-mix(in srgb, var(--primary-color) 5%, transparent)
            );
        }

        .provider-logo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin: 0 auto 0.5rem;
            padding: 8px;
            background: var(--gray-100);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .submit-button {
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--button-border-radius);
            padding: 1.25rem;
            width: 100%;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .submit-button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .submit-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transform: translateX(-100%);
        }

        .submit-button:hover::before {
            transform: translateX(100%);
            transition: transform 0.5s ease;
        }

        .customer-info-card {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .customer-info-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .customer-info-item:last-child {
            border-bottom: none;
        }

        .nav-pills {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            padding: 0.5rem;
            box-shadow: var(--card-shadow);
            margin-bottom: 1.5rem;
            display: flex;
            overflow-x: auto;
        }

        .nav-pills .nav-link {
            border-radius: var(--input-border-radius);
            padding: 1rem 1.5rem;
            margin: 0 0.25rem;
            font-weight: 500;
            color: var(--gray-700);
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .nav-pills .nav-link:hover {
            color: var(--primary-color);
            background-color: var(--gray-50);
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        #preloader {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        #preloader .spinner-border {
            width: 3rem;
            height: 3rem;
            margin-bottom: 1rem;
        }

        .quick-amount {
            padding: 0.75rem 1.5rem;
            border-radius: var(--button-border-radius);
            border: 2px solid var(--primary-color);
            background: transparent;
            color: var(--primary-color);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .quick-amount:hover, .quick-amount.active {
            background: var(--primary-color);
            color: white;
        }

        .bouquet-list {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid var(--gray-200);
            border-radius: var(--input-border-radius);
        }

        .bouquet-item {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .bouquet-item:hover {
            background: var(--gray-50);
        }

        .bouquet-item.active {
            background: color-mix(in srgb, var(--primary-color) 10%, transparent);
            border-left: 4px solid var(--primary-color);
        }

        .bouquet-item:last-child {
            border-bottom: none;
        }

        .validation-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            transition: all 0.3s ease;
        }

        .validation-icon.valid {
            color: var(--success-color);
        }

        .validation-icon.invalid {
            color: var(--error-color);
        }

        .is-validating {
            border-color: var(--warning-color) !important;
        }

        .is-validating + .validation-icon {
            color: var(--warning-color);
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }

        .verified-button {
            background: var(--success-color) !important;
            transition: all 0.3s ease;
        }

        .verified-button:hover {
            background: color-mix(in srgb, var(--success-color) 80%, black) !important;
        }

        .recent-transaction {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            transition: all 0.3s ease;
        }

        .recent-transaction:hover {
            background: var(--gray-50);
        }

        .recent-transaction:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .provider-select {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
@endpush

@section('content')
    <div class="main-content tv-page">
        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">TV Subscription</h4>
                        <p class="text-gray-500">Purchase subscriptions for your TV decoder</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('TV Subscription') !!}
                </div>

                <div class="row">
                    <!-- Wallet Balance Card -->
                    <x-users.wallet-balance></x-users.wallet-balance>

                    <!-- Left Column: TV Subscription Form -->
                    <div class="col-lg-8">
                        <!-- Service Provider Tabs -->
                        <div class="tv-card">
                            <ul class="nav nav-pills" role="tablist">
                                <!-- Tabs will be dynamically generated by JavaScript -->
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            <!-- DSTV Tab -->
                            <div class="tab-pane fade show active" id="dstv" role="tabpanel">
                                <div class="tv-card">
                                    <form class="custom-validation" id="dstvForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Smart Card Number</label>
                                            <div class="position-relative">
                                                <input type="text" class="form-control" required
                                                    placeholder="Enter valid DSTV smartcard number" id="dstvBillersCode"
                                                    name="billersCode" />
                                                <span class="validation-icon material-icons-round">credit_card</span>
                                            </div>
                                            <small class="text-muted">Enter the smartcard number printed on your DSTV decoder</small>
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="submit-button" id="checkBillCodeButton">
                                                <span class="material-icons-round me-2">search</span>
                                                Verify Smart Card
                                            </button>
                                        </div>

                                        <!-- Customer Information (Hidden by default) -->
                                        <div class="hideInnerForm" id="dstvInnerForm" style="display:none">
                                            <div class="customer-info-card mb-4">
                                                <h5 class="p-3 border-bottom">Customer Information</h5>
                                                <div class="customer-info-item">
                                                    <span class="text-gray-600">Name</span>
                                                    <span class="text-gray-800 fw-bold" id="customerName"></span>
                                                </div>
                                                <div class="customer-info-item">
                                                    <span class="text-gray-600">Current Bouquet</span>
                                                    <span class="text-gray-800" id="currentBouquet"></span>
                                                </div>
                                                <div class="customer-info-item">
                                                    <span class="text-gray-600">Due Date</span>
                                                    <span class="text-gray-800" id="dueDate"></span>
                                                </div>
                                                <div class="customer-info-item">
                                                    <span class="text-gray-600">Renewal Amount</span>
                                                    <span class="text-gray-800 fw-bold" id="renewalAmount"></span>
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">What do you want to do?</label>
                                                <select class="form-select form-control" disabled id="validationCustom03"
                                                    name="bouquet" required>
                                                    <option selected disabled value="">Select an option</option>
                                                    <option value="renew">Renew Current Bouquet</option>
                                                    <option value="change">Change Bouquet</option>
                                                </select>
                                            </div>

                                            <div id="selectBouquetContainer" style="display: none;" class="mb-4">
                                                <label class="form-label">Select a Bouquet</label>
                                                <select class="form-select form-control" id="selectBouquet"
                                                    name="selectBouquet" required>
                                                    <option selected disabled value="">Please select type...</option>
                                                </select>
                                            </div>

                                            <div id="amountContainer" style="display: none;" class="mb-4">
                                                <label class="form-label">Amount</label>
                                                <div class="position-relative">
                                                    <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                                                    <input type="text" class="form-control ps-4" id="amount" readonly
                                                        name="amount">
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label class="form-label">Phone Number</label>
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" required
                                                        placeholder="Recipient phone number" name="tel" />
                                                    <span class="validation-icon material-icons-round">phone</span>
                                                </div>
                                                <small class="text-muted">You'll receive a confirmation on this number</small>
                                            </div>

                                            <div class="mb-3">
                                                <button type="button" class="submit-button" id="submitDstv">
                                                    <span class="material-icons-round me-2">shopping_cart</span>
                                                    Complete Payment
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- GOTV Tab -->
                           @include('users-layout.dashboard.partials.tv.tabs.gotv')

                            <!-- Startimes Tab -->
                            @include('users-layout.dashboard.partials.tv.tabs.startimes')


                            <!-- Showmax Tab -->
                             @include('users-layout.dashboard.partials.tv.tabs.showmax')
                        </div>
                    </div>

                    <!-- Right Column: Transaction History -->
                    <div class="col-lg-4">
                        <!-- Transaction History -->
                        <div class="tv-card">
                            <h5 class="mb-4">Recent Subscriptions</h5>
                            <div id="transactionHistory">
                                <!-- Transaction history will be populated here -->
                            </div>
                        </div>

                        <!-- Help & Support -->
                        <div class="tv-card">
                            <h5 class="mb-4">Help & Support</h5>
                            <div class="mb-4">
                                <h6 class="mb-2">Having trouble with your subscription?</h6>
                                <p class="text-muted mb-3">Our support team is available 24/7 to help you with any issues you may encounter.</p>
                                <a href="#" class="submit-button d-flex align-items-center justify-content-center">
                                    <span class="material-icons-round me-2">support_agent</span>
                                    Contact Support
                                </a>
                            </div>
                            <div class="mb-2">
                                <h6 class="mb-2">Frequently Asked Questions</h6>
                                <div class="accordion" id="faqAccordion">
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                How long does it take to activate my subscription?
                                            </button>
                                        </h2>
                                        <div id="collapseOne" class="accordion-collapse collapse"
                                            aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body text-muted">
                                                Your subscription is usually activated within 5-10 minutes after successful payment.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item border-0 mb-2">
                                        <h2 class="accordion-header" id="headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                Can I change my subscription plan?
                                            </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse"
                                            aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body text-muted">
                                                Yes, you can change your subscription plan by selecting the "Change Bouquet" option
                                                after verifying your smartcard number.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
      @include('users-layout.dashboard.partials.tv.modals')
@endsection

@section('scripts')
<script>
window.TVPurchaseConfig = {
    purchaseApiUrl: "{{ route('users.tv.purchase') }}",
    verifyUrl: "{{ route('users.tv.verify') }}",
    userBalance: {{ Auth::user()->wallet->balance }},
    csrfToken: "{{ csrf_token() }}",
}
</script>
<script src="{{ asset('assets/js/users/tv.js') }}"></script>
@endsection
