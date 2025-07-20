@php
    use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Insurance Services')

@push('after_styles')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    @include('users-layout.dashboard.partials.insurance.style')
@endpush

@section('content')
    <div class="main-content insurance-page">
        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">Insurance Services</h4>
                        <p class="text-gray-500">Purchase insurance policies for your needs</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('Insurance Services') !!}
                </div>

                <div class="row">
                    <!-- Wallet Balance Card -->
                    <x-users.wallet-balance></x-users.wallet-balance>

                    <!-- Left Column: Insurance Service Form -->
                    <div class="col-lg-8">
                        <!-- Service Provider Tabs -->
                        <div class="insurance-card">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item custom-tab-item" data-service="third-party" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#third-party" role="tab">
                                        <img src="{{ asset('assets/images/brands/universal-insurance.png') }}" alt=""
                                            class="provider-icon" alt="Third Party Insurance">
                                        Third Party Insurance
                                    </a>
                                </li>
                                <li class="nav-item custom-tab-item" data-service="personal-accident" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#personal-accident" role="tab">
                                        <img src="{{ asset('assets/images/brands/personal-insurance.png') }}" alt=""
                                            class="provider-icon" alt="Personal Accident Insurance">
                                        Personal Accident
                                    </a>
                                </li>
                                <li class="nav-item custom-tab-item" data-service="home-cover" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#home-cover" role="tab">
                                        <img src="{{ asset('assets/images/brands/home-insurance.png') }}" alt=""
                                            class="provider-icon" alt="Home Cover Insurance">
                                        Home Cover
                                    </a>
                                </li>
                            </ul>

                            <!-- Tab Content -->
                            <div class="tab-content">
                                @include('users-layout.dashboard.partials.insurance.third-party')
                                @include('users-layout.dashboard.partials.insurance.personal-accident')
                                @include('users-layout.dashboard.partials.insurance.home-cover')
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Transaction History -->
                    @include('users-layout.dashboard.partials.insurance.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('users-layout.dashboard.partials.insurance.modals')
@endsection

@section('scripts')
    {{-- <script>
        window.InsuranceConfig = {
            purchaseApiUrl: "{{ route('users.insurance.purchase') }}",
            verifyUrl: "{{ route('users.insurance.verify') }}",
            queryTrxUrl: "{{ route('users.insurance.query.transaction') }}",
            userBalance: {{ Auth::user()->wallet->balance }},
            csrfToken: "{{ csrf_token() }}",
            transactionHistory: "",
            variationsUrl: "https://sandbox.vtpass.com/api/service-variations"
        }
    </script>
    <script src="{{ asset('assets/js/users/insurance.js') }}"></script> --}}
@endsection
