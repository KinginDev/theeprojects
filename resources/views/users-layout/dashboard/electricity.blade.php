@php
use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Electricity Page')

@section('styles')
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- ApexCharts -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

        .electricity-page {
            padding: 2rem;
            background-color: var(--gray-50);
        }



        .wallet-balance {
            background: linear-gradient(135deg, var(--primary-color) 0%, color-mix(in srgb, var(--primary-color) 60%, black) 100%);
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            color: white;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .wallet-balance::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20L0 20z' fill='%23fff' fill-opacity='.05'/%3E%3C/svg%3E") repeat;
            opacity: 0.5;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
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

        .disco-select {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .disco-option {
            background: var(--surface-color);
            border: 2px solid var(--gray-200);
            border-radius: var(--card-border-radius);
            padding: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .disco-option:hover {
            transform: translateY(-2px);
            border-color: var(--primary-color);
        }

        .disco-option.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--primary-color) 3%, transparent),
                color-mix(in srgb, var(--primary-color) 5%, transparent)
            );
        }

        .disco-logo {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            margin: 0 auto 0.5rem;
            padding: 8px;
            background: var(--gray-100);
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

        .meter-info-card {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .meter-info-item {
            display: flex;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--gray-200);
        }

        .meter-info-item:last-child {
            border-bottom: none;
        }

        .recent-purchases {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            box-shadow: var(--card-shadow);
        }

        .purchase-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .purchase-item:hover {
            background: var(--gray-50);
        }

        .purchase-item:last-child {
            border-bottom: none;
        }

        .auto-purchase-toggle {
            background: var(--gray-100);
            border-radius: var(--card-border-radius);
            padding: 1rem;
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .toggle-switch {
            position: relative;
            width: 50px;
            height: 28px;
        }

        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: var(--gray-300);
            transition: .4s;
            border-radius: 34px;
        }

        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 20px;
            width: 20px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .toggle-slider {
            background-color: var(--primary-color);
        }

        input:checked + .toggle-slider:before {
            transform: translateX(22px);
        }

        @media (max-width: 768px) {
            .disco-select {
                grid-template-columns: repeat(2, 1fr);
            }

            .wallet-balance {
                margin: 1rem;
            }
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

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .success-animation {
            animation: pulse 0.5s ease-in-out;
        }
    </style>
@endsection

@section('content')
    <div class="main-content ">
        <div class="page-content">
            <div class="container-fluid">
               <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">Buy Electricity</h4>
                        <p class="text-gray-500">Purchase electricity for your home</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('Electricity') !!}
                </div>
            </div>
        </div>
<div class="container-fluid">
                <div class="row">
                    <!-- Left Column: Purchase Form -->
                    <div class="col-lg-8">
                        <!-- Wallet Balance Card -->
                        <div class="wallet-balance mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="text-white mb-1 opacity-90">Wallet Balance</p>
                                    <h3 class="text-white mb-0">₦{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</h3>
                                </div>
                                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#fundWalletModal">
                                    <span class="material-icons-round align-middle me-1" style="font-size: 18px;">add</span>
                                    Fund Wallet
                                </button>
                            </div>
                        </div>

                        <!-- Purchase Form Card -->
                        <div class="meter-info-card">
                            <form id="electricityForm" class="custom-validation">
                                @csrf
                                <!-- Disco Selection -->
                                <div class="mb-4">
                                    <label class="form-label">Select Distribution Company</label>
                                    <div class="disco-select">
                                        @foreach ($products as $product)
                                            <div class="disco-option" data-disco="{{ $product->slug }}">
                                                <div class="disco-logo">
                                                    <img src="{{ asset('assets/images/brands/' . $product->name . '.png') }}"
                                                         alt="{{ $product->name }}" class="img-fluid">
                                                </div>
                                                <h6 class="mb-0">{{ $product->name }}</h6>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="distributionCompany" name="distribution_company" required>
                                </div>

                                <!-- Meter Type Selection -->
                                <div class="mb-4">
                                    <label class="form-label">Meter Type</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="prepaid" value="prepaid" required>
                                            <label class="form-check-label" for="prepaid">Prepaid</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="type" id="postpaid" value="postpaid">
                                            <label class="form-check-label" for="postpaid">Postpaid</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Meter Number Input -->
                                <div class="mb-4">
                                    <label class="form-label">Meter Number</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="meter_number" name="meter_number"
                                               required placeholder="Enter your meter number">
                                        <span class="validation-icon material-icons-round">check_circle</span>
                                    </div>
                                    <small class="text-muted">Enter the meter number printed on your meter</small>
                                </div>

                                <!-- Continue Button -->
                                <button type="button" class="submit-button" id="checkBillcode">
                                    <span class="material-icons-round me-2">bolt</span>
                                    Verify Meter
                                </button>
                            </form
                        </div>

                        <!-- Meter Information Card -->
                        <div class="meter-info-card" id="meterInfo" style="display: none;">
                            <h5 class="mb-4">Meter Information</h5>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Customer Name</span>
                                <span class="text-gray-800" id="customerName"></span>
                            </div>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Address</span>
                                <span class="text-gray-800" id="customerAddress"></span>
                            </div>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Meter Number</span>
                                <span class="text-gray-800" id="meterNumberConfirm"></span>
                            </div>
                        </div>

                        <!-- Quick Amounts -->
                        <div class="mb-4">
                            <label class="form-label">Quick Amounts</label>
                            <div class="d-flex gap-3 flex-wrap">
                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="1000">₦1,000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="2000">₦2,000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="5000">₦5,000</button>
                                <button type="button" class="btn btn-outline-primary quick-amount" data-amount="10000">₦10,000</button>
                            </div>
                        </div>

                        <!-- Auto Purchase Toggle -->
                        <div class="auto-purchase-toggle">
                            <div>
                                <input type="checkbox" id="autoPurchase" class="toggle-switch">
                                <label for="autoPurchase" class="ms-2">Auto Purchase</label>
                            </div>
                            <small class="text-muted">Enable to automatically purchase electricity when balance is low</small>
                        </div>

                        <!-- Submit Purchase Button -->
                        <button type="button" class="submit-button" id="submitPurchase">
                            <span class="material-icons-round me-2">shopping_cart</span>
                            Purchase Electricity
                        </button>
                    </div>


                </div>
                 <!-- Right Column: Usage Chart & Recent Purchases -->
                    <div class="col-lg-4">
                        <!-- Usage Chart Card -->
                        <div class="meter-info-card mb-4">
                            <h5 class="mb-4">Usage Chart</h5>
                            <div id="usageChart"></div>
                        </div>

                        <!-- Recent Purchases Card -->
                        <div class="recent-purchases meter-info-card">
                            <h5 class="mb-4">Recent Purchases</h5>
                            <div class="purchase-item">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-gray-600">Electricity Purchase</span>
                                        <span class="text-gray-800">₦2,500</span>
                                    </div>
                                    <div class="text-muted">Meter: 1234567890</div>
                                </div>
                                <div>
                                    <span class="badge bg-success">Delivered</span>
                                </div>
                            </div>
                            <div class="purchase-item">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-gray-600">Electricity Purchase</span>
                                        <span class="text-gray-800">₦1,000</span>
                                    </div>
                                    <div class="text-muted">Meter: 0987654321</div>
                                </div>
                                <div>
                                    <span class="badge bg-danger">Failed</span>
                                </div>
                            </div>
                            <div class="purchase-item">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="text-gray-600">Electricity Purchase</span>
                                        <span class="text-gray-800">₦3,000</span>
                                    </div>
                                    <div class="text-muted">Meter: 1122334455</div>
                                </div>
                                <div>
                                    <span class="badge bg-success">Delivered</span>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
    </div>
        <!-- Success Modal -->
        <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel">Success</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Your transaction was successful!</p>
                        <p>Transaction ID: <strong id="transactionId"></strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Error Modal -->
        <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="errorModalLabel">Error</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>There was an error processing your request. Please try again.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    <script>
        $(document).ready(function () {
            // Show preloader before making the API call
            $('#checkBillcode').on('click', function (event) {
                event.preventDefault();

                var billerCode = $('#meter_number').val();
                var meterType = $('#meterType').val();
                var distributionCompany = $('#distributionCompany').val();

                if (!billerCode || !meterType || !distributionCompany) {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill in all required fields.",
                        icon: "error"
                    });
                    return;
                }

                // Show preloader
                $('#preloader').css('display', 'flex');

                $.ajax({
                    url: '/tv/billcode/electricity',
                    method: 'POST',
                    data: {
                        billerCode: billerCode,
                        meterType: meterType,
                        distributionCompany: distributionCompany,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response.result);

                        // Ensure response.data exists
                        if (response && response.result) {
                            if (response.result.content.error) {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message ||
                                        "Invalid Meter Number. Please check and Try Again",
                                    icon: "error"
                                });
                            } else {
                                $('#customerName').text(response.result.content
                                    .Customer_Name);
                                $('#currentBouquet').text(response.result.content.Address);
                                $('#dueDate').text(response.result.content
                                    .Customer_District);
                                $('#renewalAmount').text(response.result.content
                                    .Meter_Number);

                                // Show the inner form and card
                                $('.hideInnerForm').css("display", "block");
                                $('.electricCard').css("display", "block");

                            }

                        } else {
                            Swal.fire({
                                title: "Error",
                                text: response.message ||
                                    "Invalid response structure received.",
                                icon: "error"
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: "An error occurred",
                            text: "Please try again.",
                            icon: "error"
                        });
                    },
                    complete: function () {
                        // Hide preloader after the response
                        $('#preloader').hide();
                    }
                });
            });

            // Handle form submission
            $('#submitForm').click(function (e) {
                e.preventDefault();

                Swal.fire({
                    title: "Processing...",
                    html: "Please wait...",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // Show preloader before submission
                        $('#preloader').css('display', 'flex');
                        var formData = $('#electricityForm').serialize();
                        console.log(formData);

                        $.ajax({
                            url: '{{ route('users.electricity.purchase', [
        'slug' => Helper::merchant()->slug
    ]) }}',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function (response) {
                                console.log(response);
                                if (response.status === 'delivered') {
                                    Swal.fire({
                                        title: "Success!!!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.href =
                                            '/success?hash=' +
                                            encodeURIComponent(
                                                response.result
                                                    .requestId);
                                    });
                                } else if (response.status === 'failed') {
                                    Swal.fire({
                                        title: "Error, Please try again!!!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function (error) {
                                console.log(error);
                                Swal.fire({
                                    title: "An error occurred",
                                    text: "Please try again.",
                                    icon: "error"
                                });
                            },
                            complete: function () {
                                // Hide preloader after form submission is complete
                                $('#preloader').hide();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    let selectedDisco = '';
    let meterInfo = null;

    // Chart initialization
    const options = {
        series: [{
            name: 'Usage',
            data: [30, 40, 35, 50, 49, 60, 70],
        }],
        chart: {
            type: 'line',
            height: 300,
            toolbar: {
                show: false
            },
            zoom: {
                enabled: false
            }
        },
        stroke: {
            curve: 'smooth',
            width: 3,
            colors: [getComputedStyle(document.documentElement).getPropertyValue('--primary-color').trim()]
        },
        grid: {
            borderColor: 'var(--gray-200)',
            strokeDashArray: 4,
            padding: {
                left: 20,
                right: 20
            }
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 6,
            colors: ['#fff'],
            strokeColors: 'var(--primary-color)',
            strokeWidth: 3
        },
        tooltip: {
            theme: 'dark',
            y: {
                formatter: function(value) {
                    return value + ' kWh'
                }
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.3,
                stops: [0, 90, 100]
            }
        },
        xaxis: {
            categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            labels: {
                style: {
                    colors: 'var(--gray-500)'
                }
            },
            axisBorder: {
                show: false
            }
        },
        yaxis: {
            labels: {
                formatter: function(value) {
                    return value + ' kWh';
                },
                style: {
                    colors: 'var(--gray-500)'
                }
            }
        }
    };

    const chart = new ApexCharts(document.querySelector("#usageChart"), options);
    chart.render();

    // Event Handlers
    const discoOptions = document.querySelectorAll('.disco-option');
    const meterNumberInput = document.querySelector('#meter_number');
    const checkBillcodeBtn = document.querySelector('#checkBillcode');
    const submitPurchaseBtn = document.querySelector('#submitPurchase');
    const quickAmountBtns = document.querySelectorAll('.quick-amount');

    // Disco selection
    discoOptions.forEach(option => {
        option.addEventListener('click', function() {
            discoOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
            selectedDisco = this.dataset.disco;
            document.querySelector('#distributionCompany').value = selectedDisco;
        });
    });

    // Meter number validation
    let meterValidationTimeout;
    meterNumberInput.addEventListener('input', function() {
        clearTimeout(meterValidationTimeout);
        const value = this.value.trim();

        // Update UI to show typing state
        this.classList.remove('is-valid', 'is-invalid');
        if (value) {
            this.classList.add('is-validating');

            // Debounce the validation
            meterValidationTimeout = setTimeout(() => validateMeterNumber(value), 500);
        } else {
            this.classList.remove('is-validating');
        }

        validateForm();
    });

    // Quick amount selection
    quickAmountBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            quickAmountBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            document.querySelector('#amount').value = this.dataset.amount;
            validateForm();
        });
    });

    // Form validation
    function validateForm() {
        const selectedDisco = document.querySelector('.disco-option.active');
        const meterNumber = meterNumberInput.value.trim();
        const amount = document.querySelector('#amount').value;

        submitPurchaseBtn.disabled = !selectedDisco || !meterNumber || !amount || meterNumberInput.classList.contains('is-invalid');
    }

    // Meter number validation
    async function validateMeterNumber(meterNumber) {
        try {
            const selectedDisco = document.querySelector('.disco-option.active');
            if (!selectedDisco) {
                showError('Please select a disco first');
                return;
            }

            // Show loading state
            meterNumberInput.classList.add('is-validating');
            checkBillcodeBtn.disabled = true;

            // API call would go here
            // For demo, simulate API call
            await new Promise(resolve => setTimeout(resolve, 1000));

            // Success
            meterNumberInput.classList.remove('is-validating', 'is-invalid');
            meterNumberInput.classList.add('is-valid');

            // Update chart with new data
            updateUsageHistory(meterNumber);

        } catch (error) {
            meterNumberInput.classList.remove('is-validating', 'is-valid');
            meterNumberInput.classList.add('is-invalid');
            showError('Invalid meter number');
        } finally {
            checkBillcodeBtn.disabled = false;
        }
    }

    // Update usage history chart
    function updateUsageHistory(meterNumber) {
        // Simulate API call
        const mockData = [25, 35, 30, 45, 40, 50, 45];
        chart.updateSeries([{
            data: mockData
        }]);
    }

    // Helper functions
    function validateForm() {
        if (!selectedDisco) {
            showError('Please select a distribution company');
            return false;
        }

        if (!document.querySelector('input[name="type"]:checked')) {
            showError('Please select a meter type');
            return false;
        }

        if (!meterNumberInput.value || meterNumberInput.value.length < 10) {
            showError('Please enter a valid meter number');
            return false;
        }

        return true;
    }

    function displayMeterInfo(info) {
        document.querySelector('#customerName').textContent = info.Customer_Name;
        document.querySelector('#customerAddress').textContent = info.Address;
        document.querySelector('#meterNumberConfirm').textContent = info.Meter_Number;
    }

    // Utility Functions
    function showError(message) {
        // Create error notification
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-dismissible fade show';
        errorDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        // Insert at top of form
        const form = document.querySelector('form');
        form.insertBefore(errorDiv, form.firstChild);

        // Auto dismiss after 5 seconds
        setTimeout(() => {
            errorDiv.classList.remove('show');
            setTimeout(() => errorDiv.remove(), 150);
        }, 5000);
    }

    // Format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN'
        }).format(amount);
    }

    // Add loading spinner
    function showLoading(element) {
        const spinner = document.createElement('span');
        spinner.className = 'spinner-border spinner-border-sm ms-1';
        spinner.setAttribute('role', 'status');
        spinner.innerHTML = '<span class="visually-hidden">Loading...</span>';
        element.appendChild(spinner);
        return () => spinner.remove();
    }

    // Auto-resize meter input
    meterNumberInput.addEventListener('input', function() {
        this.style.width = Math.max(8, this.value.length) + 'ch';
    });

    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>
@endsection
