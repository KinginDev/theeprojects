@php
    use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Education Services')

@push('after_styles')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    @include('users-layout.dashboard.partials.education.style')
@endpush

@section('content')
    <div class="main-content education-page">
        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">Education Services</h4>
                        <p class="text-gray-500">Purchase examination pins and result checking cards</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('Education Services') !!}
                </div>

                <div class="row">
                    <!-- Wallet Balance Card -->
                    <x-users.wallet-balance></x-users.wallet-balance>

                    <!-- Left Column: Education Service Form -->
                    <div class="col-lg-8">
                        <!-- Service Provider Tabs -->
                        <div class="education-card">
                            <ul class="nav nav-pills" role="tablist">
                                <li class="nav-item custom-tab-item" data-service="waec" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#waec" role="tab">
                                        <img src="{{ asset('assets/images/brands/waec.png') }}" alt=""
                                            class="provider-icon" alt="WAEC">
                                        WAEC
                                    </a>
                                </li>
                                <li class="nav-item custom-tab-item" data-service="jamb" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#jamb" role="tab">
                                        <img src="{{ asset('assets/images/brands/jamb.png') }}" alt=""
                                            class="provider-icon" alt="JAMB">
                                        JAMB
                                    </a>
                                </li>
                                <li class="nav-item custom-tab-item" data-service="neco" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#neco" role="tab">
                                        <img src="{{ asset('assets/images/brands/neco.png') }}" alt=""
                                            class="provider-icon" alt="NECO">
                                        NECO
                                    </a>
                                </li>
                                <li class="nav-item custom-tab-item" data-service="nabteb" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#nabteb" role="tab">
                                        <img src="{{ asset('assets/images/brands/nabteb.png') }}" alt=""
                                            class="provider-icon" alt="NABTEB">
                                        NABTEB
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content">
                            @include('users-layout.dashboard.partials.education.waec')
                            @include('users-layout.dashboard.partials.education.jamb')
                            @include('users-layout.dashboard.partials.education.neco')
                            @include('users-layout.dashboard.partials.education.nabteb')
                        </div>
                    </div>

                    <!-- Right Column: Transaction History -->
                    @include('users-layout.dashboard.partials.education.sidebar')
                </div>
            </div>
        </div>
    </div>

    @include('users-layout.dashboard.partials.education.modals')
@endsection

@section('scripts')
    <script>
        window.EducationConfig = {
            purchaseApiUrl: "{{ route('users.education.purchase') }}",
            jambVerifyUrl: "{{ route('users.education.verify') }}",
            waecResultUrl: "{{ route('users.education.check.result') }}",
            queryTrxUrl: "{{ route('users.education.query.transaction') }}",
            userBalance: {{ Auth::user()->wallet->balance }},
            csrfToken: "{{ csrf_token() }}",
            transactionHistory: "",
            variationsUrl: "https://sandbox.vtpass.com/api/service-variations"
        }
    </script>
    <script src="{{ asset('assets/js/users/education.js') }}"></script>
@endsection
