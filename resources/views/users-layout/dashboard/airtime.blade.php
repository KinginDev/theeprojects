@php
    use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Airtime Page')

@section('styles')
    <!-- Phone number input with country flag -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.8/css/intlTelInput.css">


    <style>
        :root {
            --primary-color: {{ $configuration->template_color ?? '#4F46E5' }};
            --primary-hover: {{ $configuration->template_color ? 'color-mix(in srgb, ' . $configuration->template_color . ' 80%, black)' : '#4338CA' }};
            --surface-color: #ffffff;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-500: #6b7280;
            --gray-700: #374151;
            --success-color: #10b981;
            --error-color: #ef4444;
            --card-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            --input-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
        }

        .airtime-card {
            background: var(--surface-color);
            border-radius: 24px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid var(--gray-200);
            backdrop-filter: blur(10px);
        }

        .airtime-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }

        .wallet-balance {
            background: linear-gradient(135deg,
                var(--primary-color),
                color-mix(in srgb, var(--primary-color) 60%, black)
            );
            position: relative;
            overflow: hidden;
            color: white;
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .wallet-balance::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at top right,
                rgba(255, 255, 255, 0.2) 0%,
                transparent 60%);
            pointer-events: none;
        }

        .network-option {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            transition: all 0.2s ease;
        }

        .network-logo {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            box-shadow: var(--input-shadow);
            padding: 6px;
            background: var(--gray-100);
            transition: transform 0.2s ease;
        }

        .network-logo:hover {
            transform: scale(1.05);
        }

        .amount-btn {
            background: var(--surface-color);
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .amount-btn:hover {
            border-color: var(--primary-color);
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--primary-color) 10%, white),
                color-mix(in srgb, var(--primary-color) 5%, white)
            );
            transform: translateY(-1px);
        }

        .amount-btn.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .custom-input {
            border: 2px solid var(--gray-200);
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: var(--surface-color);
            box-shadow: var(--input-shadow);
        }

        .custom-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px color-mix(in srgb, var(--primary-color) 15%, transparent);
            transform: translateY(-1px);
        }

        .primary-button {
            background: var(--primary-color);
            color: white;
            border-radius: 12px;
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .primary-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .primary-button:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
        }

        .primary-button:hover::before {
            transform: translateX(100%);
        }

        .primary-button:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .recent-transactions {
            margin-top: 2rem;
        }

        .transaction-item {
            display: flex;
            align-items: center;
            padding: 1.25rem;
            border-bottom: 1px solid var(--gray-200);
            transition: all 0.2s ease;
        }

        .transaction-item:hover {
            background: linear-gradient(to right,
                color-mix(in srgb, var(--primary-color) 5%, white),
                var(--surface-color)
            );
            transform: translateX(4px);
        }

        @keyframes checkmark {
            0% { transform: scale(0) rotate(-45deg); opacity: 0; }
            50% { transform: scale(1.2) rotate(0deg); }
            100% { transform: scale(1) rotate(0deg); }
        }

        .success-checkmark {
            color: var(--success-color);
            animation: checkmark 0.5s cubic-bezier(0.19, 1, 0.22, 1);
        }

        .page-title-box h4 {
            font-size: 1.5rem;
            font-weight: 600;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        /* Form label styling */
        .form-label {
            font-weight: 500;
            font-size: 0.95rem;
            margin-bottom: 0.75rem;
            color: var(--gray-700);
        }

        /* Custom scrollbar */
        .recent-transactions::-webkit-scrollbar {
            width: 6px;
        }

        .recent-transactions::-webkit-scrollbar-track {
            background: var(--gray-100);
            border-radius: 10px;
        }

        .recent-transactions::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 10px;
        }

        .recent-transactions::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }

        @media (max-width: 768px) {
            .amount-buttons {
                grid-template-columns: repeat(2, 1fr);
            }

            .wallet-balance {
                padding: 1.5rem;
            }

            .airtime-card {
                border-radius: 20px;
            }
        }

        /* Loading animation */
        @keyframes pulse {
            0% { transform: scale(0.95); opacity: 0.5; }
            50% { transform: scale(1); opacity: 1; }
            100% { transform: scale(0.95); opacity: 0.5; }
        }

        .spinner-border {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>
@endsection

@section('content')

    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <form class="custom-validation" id="airtimeForm">
        @csrf
        <div class="main-content" id="isSubmitForm">
            <div class="page-content">
                <div class="container-fluid">
                    <!-- Page Title -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="text-xl font-semibold">Buy Airtime</h4>
                        {!! Helper::merchant()->slug !!}
                    </div>

                    <div class="row">
                        <!-- Left Column: Purchase Form -->
                        <div class="col-lg-8">
                            <!-- Wallet Balance Card -->
                            <div class="wallet-balance mb-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h5 class="text-white mb-0">Wallet Balance</h5>
                                    <button class="btn btn-light btn-sm">Fund Wallet</button>
                                </div>
                                <h3 class="text-white mb-0">₦{{ number_format($user->wallet->balance ?? 0, 2) }}</h3>
                            </div>

                            <!-- Purchase Form Card -->
                            <div class="airtime-card p-4">
                                <!-- Network Selection -->
                                <div class="mb-4">
                                    <label class="form-label text-gray-700">Select Network</label>
                                    <select class="form-select custom-input" id="network" required name="network">
                                        <option selected disabled value="">Choose network...</option>
                                        @foreach ($airtimeProducts as $airtimeProduct)
                                            <option value="{{ $airtimeProduct->slug }}" class="network-option">
                                                <span class="material-icons-round me-2">{{ $airtimeProduct->icon }}</span>
                                                {{ $airtimeProduct->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Phone Number -->
                                <div class="mb-4">
                                    <label class="form-label text-gray-700">Phone Number</label>
                                    <input type="tel" class="form-control custom-input" id="tel" name="tel" required>
                                </div>

                                <!-- Amount Selection -->
                                <div class="mb-4">
                                    <label class="form-label text-gray-700">Amount</label>
                                    <div class="amount-buttons grid gap-2 mb-3" style="grid-template-columns: repeat(4, 1fr);">
                                        <button type="button" class="amount-btn" data-amount="100">₦100</button>
                                        <button type="button" class="amount-btn" data-amount="200">₦200</button>
                                        <button type="button" class="amount-btn" data-amount="500">₦500</button>
                                        <button type="button" class="amount-btn" data-amount="1000">₦1000</button>
                                    </div>
                                    <input type="number" class="form-control custom-input" id="amount" name="amount"
                                        placeholder="Enter custom amount" required>
                                </div>

                                <!-- Submit Button -->
                                <button type="button" id="showTransaction" class="primary-button">
                                    <span class="material-icons-round me-2">shopping_cart</span>
                                    Buy Airtime
                                </button>
                            </div>
                        </div>

                        <!-- Right Column: Recent Transactions -->
                        <div class="col-lg-4">
                            <div class="airtime-card p-4">
                                <h5 class="mb-3">Recent Transactions</h5>
                                <div class="recent-transactions">
                                    @foreach($recentTransactions ?? [] as $transaction)
                                        <div class="transaction-item">
                                            <img src="{{ $transaction->network_logo }}" alt="{{ $transaction->network }}" class="network-logo me-3">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <p class="mb-0 text-gray-700">{{ $transaction->phone_number }}</p>
                                                        <small class="text-gray-500">{{ $transaction->created_at->diffForHumans() }}</small>
                                                    </div>
                                                    <span class="text-gray-700">₦{{ number_format($transaction->amount) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transaction Confirmation Modal -->
        <div class="main-content" id="transactions" style="display:none">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="airtime-card p-4">
                                <h5 class="mb-4">Confirm Transaction</h5>
                                <div class="transaction-details">
                                    <div class="d-flex justify-content-between py-3 border-bottom">
                                        <span class="text-gray-500">Network</span>
                                        <span class="text-gray-700" id="networkTransaction"></span>
                                    </div>
                                    <div class="d-flex justify-content-between py-3 border-bottom">
                                        <span class="text-gray-500">Phone Number</span>
                                        <span class="text-gray-700" id="phoneNumberTransaction"></span>
                                    </div>
                                    <div class="d-flex justify-content-between py-3 border-bottom">
                                        <span class="text-gray-500">Amount</span>
                                        <span class="text-gray-700" id="amountTransaction"></span>
                                    </div>
                                    <div class="d-flex justify-content-between py-3 border-bottom">
                                        <span class="text-gray-500">Transaction Fee</span>
                                        <span class="text-gray-700">₦0</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-3 mt-4">
                                    <button type="button" class="btn btn-light flex-grow-1" onclick="$('#transactions').hide(); $('#isSubmitForm').show();">
                                        <span class="material-icons-round me-2">arrow_back</span>
                                        Back
                                    </button>
                                    <button type="button" id="submitForm" class="primary-button flex-grow-1">
                                        <span class="material-icons-round me-2">check_circle</span>
                                        Confirm Purchase
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Loading Spinner -->
    <div id="preloader" class="justify-content-center align-items-center" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.9); z-index:9999;">
        <div class="d-flex flex-column align-items-center">
            <div class="spinner-border text-primary mb-2" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="text-gray-700">Processing your request...</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize phone number input with country flags
            const phoneInput = window.intlTelInput(document.querySelector("#tel"), {
                initialCountry: "ng",
                preferredCountries: ["ng"],
                utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/19.2.8/js/utils.js",
            });

            // Handle amount button clicks
            document.querySelectorAll('.amount-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const amount = this.dataset.amount;
                    document.getElementById('amount').value = amount;
                    document.querySelectorAll('.amount-btn').forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Function to show the SweetAlert2 alert
            function showAutoCloseAlert() {
                Swal.fire({
                    title: "Processing...",
                    html: "Please wait while we process your request...",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }

            // Function to validate form inputs
            function validateForm() {
                const network = document.getElementById('network').value;
                const phone = phoneInput.getNumber();
                const amount = document.getElementById('amount').value;

                if (!network || !phone || !amount) {
                    return false;
                }
                return true;
            }

            // Function to populate transaction details
            function populateTransactionDetails() {
                const network = document.querySelector('#network option:checked').text;
                const phone = phoneInput.getNumber();
                const amount = document.getElementById('amount').value;

                document.getElementById('networkTransaction').textContent = network;
                document.getElementById('phoneNumberTransaction').textContent = phone;
                document.getElementById('amountTransaction').textContent = '₦' + amount;

                document.getElementById('transactions').style.display = 'block';
                document.getElementById('isSubmitForm').style.display = 'none';
            }

            // Handle show transaction details
            document.getElementById('showTransaction').addEventListener('click', function(e) {
                e.preventDefault();
                if (validateForm()) {
                    populateTransactionDetails();
                } else {
                    Swal.fire({
                        title: "Validation Error",
                        text: "Please fill all required fields correctly.",
                        icon: "error"
                    });
                }
            });

            // Handle form submission
            document.getElementById('submitForm').addEventListener('click', function(e) {
                e.preventDefault();
                if (validateForm()) {
                    document.getElementById('preloader').style.display = 'flex';

                    const formData = new FormData(document.getElementById('airtimeForm'));
                    formData.set('tel', phoneInput.getNumber());

                    fetch('{{ route('users.airtime.purchase', ['slug' => Helper::merchant()->slug]) }}', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    })
                    .then(response => response.json())
                    .then(response => {
                        if (response.status === 'delivered') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message +
                                    '<div class="success-checkmark mt-3"><span class="material-icons-round" style="font-size: 48px;">check_circle</span></div>' +
                                    '<a href="{{ route('users.airtime', ['slug' => Helper::merchant()->slug]) }}" class="btn btn-primary mt-3">Buy More Airtime</a>',
                                showConfirmButton: false,
                                allowOutsideClick: false
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message || "Transaction failed. Please try again.",
                                icon: "error"
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            title: "Error!",
                            text: "An error occurred. Please try again.",
                            icon: "error"
                        });
                    })
                    .finally(() => {
                        document.getElementById('preloader').style.display = 'none';
                    });
                }
            });
        });
    </script>

@endsection
