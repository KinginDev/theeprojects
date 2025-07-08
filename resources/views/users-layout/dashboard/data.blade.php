@php
    use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Purchase Data Page')

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

        .data-card {
            background: var(--surface-color);
            border-radius: var(--card-border-radius);
            box-shadow: var(--card-shadow);
            border: 1px solid var(--gray-200);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .data-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }

        .wallet-balance {
            background: linear-gradient(135deg, var(--primary-color) 0%, color-mix(in srgb, var(--primary-color) 60%, black) 100%);
            border-radius: var(--card-border-radius);
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
            box-shadow: var(--card-shadow);
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

        .network-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .network-card {
            background: var(--surface-color);
            border: 2px solid var(--gray-200);
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .network-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .network-card.active {
            border-color: var(--primary-color);
            background: linear-gradient(
                135deg,
                color-mix(in srgb, var(--primary-color) 3%, transparent),
                color-mix(in srgb, var(--primary-color) 5%, transparent)
            );
            transform: translateY(-2px);
            box-shadow: var(--card-shadow);
        }

        .network-logo {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            padding: 8px;
            background: var(--gray-100);
            margin: 0 auto 1rem;
            transition: transform 0.2s ease;
        }

        .plan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 1rem;
            margin: 1rem 0;
        }

        .plan-card {
            background: var(--surface-color);
            border: 2px solid var(--gray-200);
            border-radius: var(--card-border-radius);
            padding: 1.25rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .plan-card:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .plan-card.active {
            border-color: var(--primary-color);
            background: linear-gradient(135deg,
                color-mix(in srgb, var(--primary-color) 3%, transparent),
                color-mix(in srgb, var(--primary-color) 5%, transparent)
            );
        }

        .plan-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary-color);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.3s ease;
        }

        .plan-card:hover::before {
            transform: scaleX(1);
        }

        .recipient-toggle {
            display: flex;
            gap: 0.5rem;
            background: var(--gray-100);
            padding: 0.25rem;
            border-radius: var(--card-border-radius);
            margin-bottom: 1.5rem;
        }

        .recipient-toggle button {
            flex: 1;
            padding: 0.75rem 1rem;
            border: none;
            border-radius: var(--button-border-radius);
            background: transparent;
            font-weight: 500;
            color: var(--gray-700);
            transition: all 0.3s ease;
        }

        .recipient-toggle button.active {
            background: var(--surface-color);
            color: var(--primary-color);
            box-shadow: var(--card-shadow);
        }

        .custom-input {
            border: 2px solid var(--gray-200);
            border-radius: var(--input-border-radius);
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

        .purchase-btn {
            background: var(--primary-color);
            color: white;
            border-radius: var(--button-border-radius);
            padding: 1.25rem;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .purchase-btn:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .purchase-btn::before {
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
            transition: transform 0.5s ease;
        }

        .purchase-btn:hover::before {
            transform: translateX(100%);
        }

        .quick-help {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .quick-help-btn {
            width: 56px;
            height: 56px;
            border-radius: 28px;
            background: var(--primary-color);
            color: white;
            border: none;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
        }

        .quick-help-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .plan-card {
            animation: slideIn 0.3s ease;
        }

        @media (max-width: 768px) {
            .network-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .plan-grid {
                grid-template-columns: 1fr;
            }

            .wallet-balance {
                padding: 1rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">Buy Internet Data</h4>
                        <p class="text-gray-500">Purchase data bundles for any network</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('Data Bundle') !!}
                </div>

                <div class="row">
                    <!-- Left Column: Purchase Form -->
                    <div class="col-lg-8">
                        <!-- Wallet Balance Card -->
                        <div class="wallet-balance mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div>
                                    <p class="text-white mb-1 opacity-90">Wallet Balance</p>
                                    <h3 class="text-white mb-0">₦{{ number_format(auth('web')->user()->wallet->balance ?? 0, 2) }}</h3>
                                </div>
                                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#fundWalletModal">
                                    <span class="material-icons-round align-middle me-1" style="font-size: 18px;">add</span>
                                    Fund Wallet
                                </button>
                            </div>
                        </div>

                        <!-- Purchase Form Card -->
                        <div class="data-card p-4">
                            <form id="dataForm" class="custom-validation">
                                @csrf
                                <!-- Recipient Selection -->
                                <div class="recipient-toggle mb-4">
                                    <button type="button" class="active" data-recipient="self">
                                        <span class="material-icons-round me-2">person</span>
                                        For Myself
                                    </button>
                                    <button type="button" data-recipient="other">
                                        <span class="material-icons-round me-2">people</span>
                                        For Others
                                    </button>
                                </div>

                                <!-- Network Selection -->
                                <div class="mb-4">
                                    <label class="form-label d-flex justify-content-between">
                                        <span>Select Network Provider</span>
                                        <span class="text-primary" style="cursor: pointer;" data-bs-toggle="tooltip"
                                              title="Choose your network provider">
                                            <span class="material-icons-round" style="font-size: 18px;">info</span>
                                        </span>
                                    </label>
                                    <div class="network-grid">
                                        @php
                                            $networkIcons = [
                                                '1' => ['name' => 'MTN', 'color' => '#ffc107'],
                                                '2' => ['name' => 'GLO', 'color' => '#28a745'],
                                                '4' => ['name' => 'Airtel', 'color' => '#dc3545'],
                                                '6' => ['name' => '9mobile', 'color' => '#20c997']
                                            ];
                                        @endphp

                                        @foreach ($networkIcons as $id => $network)
                                            <div class="network-card" data-network="{{ $id }}">
                                             <div class="network-logo" style="background: {{ $network['color'] }}20;">
                                                    <img src="{{ asset('assets/images/brands/' . Str::title($network['name']) . '.png') }}"
                                                         alt="{{ $network['name'] }}" class="img-fluid">
                                                </div>
                                                <h6 class="mb-0">{{ $network['name'] }}</h6>
                                            </div>
                                        @endforeach
                                    </div>
                                    <input type="hidden" id="networkSelect" name="network" required>
                                </div>

                                <!-- Data Type Selection -->
                                <div class="mb-4" id="dataTypeContainer" >
                                    <label class="form-label">Select Data Type</label>
                                    <select class="form-select custom-input" id="dataTypeSelect" required name="networkType">
                                     <option selected disabled value="">Choose data type...</option>
                                    @foreach ($data_types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach

                                    </select>
                                </div>

                                <!-- Data Plans -->
                                <div id="dataPlanSection" style="display: none;">
                                    <label class="form-label">Select Data Plan</label>
                                    <div class="plan-grid" id="dataPlanGrid">
                                        <!-- Data plans will be dynamically populated here -->
                                    </div>
                                    <input type="hidden" id="selectedPlan" name="type" required>
                                    <input type="hidden" id="amountInput" name="amount" required>
                                </div>

                                   <div class="mb-3" id="typeSelectContainer" style="display:none">
                                <label for="serviceVariation" class="form-label">Data bundle</label>
                                <select class="form-select p-12" id="serviceVariation" name="type">
                                    <option selected disabled value="">Data bundle...</option>
                                </select>
                            </div>

                            <div class="mb-3" id="typeSelectContainer2" style="display:none">
                                <label for="serviceVariation" class="form-label">Select Plan</label>
                                <select class="form-select p-12" id="typeSelect" name="plan">
                                    <option selected disabled value="">Data bundle...</option>
                                </select>
                            </div>

                                <!-- Phone Number -->
                                <div class="mb-4">
                                    <label class="form-label">
                                        <span class="recipient-label">Your</span> Phone Number
                                    </label>
                                    <div class="input-group">
                                        <input type="tel" class="form-control custom-input" id="tel" name="tel"
                                               required placeholder="Enter phone number">
                                        <button class="btn btn-outline-secondary" type="button" id="pickContact">
                                            <span class="material-icons-round">contacts</span>
                                        </button>
                                    </div>
                                </div>



                                <!-- Submit Button -->
                                <button type="submit" class="purchase-btn mt-2" id="submitForm">
                                    <span class="material-icons-round me-2">shopping_cart</span>
                                    Purchase Data Bundle
                                </button>
                            </form>
                        </div>

                        <!-- Data Usage Chart -->
                        <div class="data-card p-4 mt-4">
                            <h5 class="mb-3">Data Usage Insights</h5>
                            <div class="data-usage-chart" id="dataUsageChart"></div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-lg-4">
                        <!-- Recent Purchases -->
                        <div class="data-card p-4">
                            <h5 class="mb-3">Recent Purchases</h5>
                            <div class="recent-transactions">
                                @forelse($transactions as $transaction)
                                    <div class="p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ asset('assets/images/networks/' . strtolower($transaction->network) . '.png') }}"
                                                     alt="{{ $transaction->network }}" class="network-logo me-3" style="width: 32px; height: 32px;">
                                                <div>
                                                    <p class="mb-0 text-gray-700">{{ $transaction->tel }}</p>
                                                    <small class="text-gray-500">{{ $transaction->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                            <span class="badge bg-success">₦{{ number_format($transaction->amount) }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge bg-light text-dark">{{ $transaction->plan }}</span>
                                            <button class="btn btn-sm btn-outline-primary" onclick="reorderData('{{ $transaction->tel }}', '{{ $transaction->network }}')">
                                                <span class="material-icons-round" style="font-size: 16px;">refresh</span>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-4">
                                        <span class="material-icons-round mb-2" style="font-size: 48px; color: var(--gray-300);">receipt_long</span>
                                        <p class="text-gray-500">No recent transactions</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Promo Banner -->
                        <div class="data-card p-4 mt-4" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                            <div class="text-white">
                                <h5 class="mb-2">Special Offer! 🎉</h5>
                                <p class="mb-3">Get 10% extra data on all bundles above ₦2000</p>
                                <button class="btn btn-light btn-sm">Learn More</button>
                            </div>
                        </div>

                        <!-- Quick FAQs -->
                        <div class="data-card p-4 mt-4">
                            <h5 class="mb-3">Quick Help</h5>
                            <div class="accordion" id="faqAccordion">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#faq1">
                                            How to check data balance?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled mb-0">
                                                <li class="mb-2">MTN: *461*4#</li>
                                                <li class="mb-2">Airtel: *140#</li>
                                                <li class="mb-2">Glo: *127*0#</li>
                                                <li>9mobile: *228#</li>
                                            </ul>
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

    <!-- Quick Help Button -->
    <div class="quick-help">
        <button class="quick-help-btn" data-bs-toggle="modal" data-bs-target="#helpModal">
            <span class="material-icons-round">help</span>
        </button>
    </div>

    <!-- Preloader -->
    <div id="preloader" class="justify-content-center align-items-center"
         style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-body p-4">
                    <h5 class="mb-4">Confirm Purchase</h5>
                    <div class="transaction-details">
                        <div class="d-flex justify-content-between py-3 border-bottom">
                            <span class="text-gray-500">Network</span>
                            <span class="text-gray-700" id="confirmNetwork"></span>
                        </div>
                        <div class="d-flex justify-content-between py-3 border-bottom">
                            <span class="text-gray-500">Data Plan</span>
                            <span class="text-gray-700" id="confirmPlan"></span>
                        </div>
                        <div class="d-flex justify-content-between py-3 border-bottom">
                            <span class="text-gray-500">Phone Number</span>
                            <span class="text-gray-700" id="confirmPhone"></span>
                        </div>
                        <div class="d-flex justify-content-between py-3 border-bottom">
                            <span class="text-gray-500">Amount</span>
                            <span class="text-gray-700" id="confirmAmount"></span>
                        </div>
                    </div>
                    <div class="d-flex gap-3 mt-4">
                        <button type="button" class="btn btn-light flex-grow-1" data-bs-dismiss="modal">
                            <span class="material-icons-round me-2">arrow_back</span>
                            Back
                        </button>
                        <button type="button" id="confirmPurchase" class="purchase-btn flex-grow-1">
                            <span class="material-icons-round me-2">check_circle</span>
                            Confirm Purchase
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            // Define the percentages for different user types
            var userPercentages = @json($percentages);

            // Create a mapping of services to their percentages
            var percentageMap = {};
            userPercentages.forEach(function(item) {
                percentageMap[item.service] = parseFloat(item.percent);
            });

            $('#networkSelect').change(function() {
                var network = $(this).val();
                var options;

                if (network === '1') { // MTN
                    options = ['SME', 'SME 2', 'GIFTING', 'CORPORATE GIFTING'];
                } else { // Other networks
                    options = ['GIFTING', 'CORPORATE GIFTING'];
                }

                // Clear previous options
                $('#dataTypeSelect').empty();

                // Add a default option
                $('#dataTypeSelect').append(
                    '<option selected disabled value="">Choose data type...</option>'
                );

                // Add new options
                options.forEach(function(option) {
                    $('#dataTypeSelect').append('<option value="' + option + '">' + option +
                        '</option>');
                });
            });

            $('#networkSelect, #dataTypeSelect').change(function() {
                var network = $('#networkSelect').val();
                var networkType = $('#dataTypeSelect').val();

                if (network && networkType) {
                    $('#preloader').css('display', 'flex'); // Show preloader
                    console.log(network + " " + networkType);

                    if ((network == 1 && networkType == 'GIFTING') || (network == 4 && networkType ==
                            'GIFTING')) {
                        $('#preloader').css('display', 'flex'); // Show preloader

                        $.ajax({
                            url: '/user/network/plans',
                            type: 'GET',
                            data: {
                                network: network,
                                networkType: networkType,
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // Ensure CSRF token is correctly passed
                            },
                            success: function(response) {
                                console.log("Response:", response);

                                // Check for success and the presence of variations
                                if (
                                    response.status === "success" &&
                                    response.data &&
                                    response.data.content &&
                                    response.data.content.variations
                                ) {
                                    const variations = response.data.content.variations;
                                    const profitPercentage = response.profitPercentage ||
                                    0; // Default to 0 if undefined

                                    console.log("Variations:", variations);
                                    console.log("Profit Percentage:", profitPercentage);

                                    // Clear previous options
                                    $("#serviceVariation").empty();
                                    $("#typeSelect").empty();

                                    // Add default options
                                    $("#serviceVariation").append(
                                        '<option selected disabled value="">Select Data Bundle...</option>'
                                    );
                                    $("#typeSelect").append(
                                        '<option selected disabled value="">Select Data Type...</option>'
                                    );

                                    // Iterate through variations and process them
                                    variations.forEach((variation) => {
                                        let {
                                            name,
                                            variation_amount,
                                            variation_code
                                        } = variation;

                                        // Parse and calculate the final amount after deducting profit
                                        const amount = parseFloat(variation_amount
                                            .replace(/,/g, "")).toFixed(2);
                                        const profit = (profitPercentage / 100) *
                                        amount;
                                        const finalAmount = Math.ceil(amount - profit);

                                        // Update the name with the calculated final amount
                                        name = name.replace(
                                            /N(\d{1,3}(,\d{3})*|\d+)(\.?\d*)/, // Matches "N<amount>" format
                                            `N${finalAmount}` // Replace with the calculated amount
                                        );

                                        // Append the variation to the dropdown
                                        $("#serviceVariation").append(
                                            $("<option></option>")
                                            .val(variation_code)
                                            .text(name)
                                            .data("amount", finalAmount)
                                        );
                                    });

                                    // Enable the dropdowns and show the container
                                    $("#serviceVariation, #typeSelect").prop("disabled", false);
                                    $("#typeSelectContainer").show();
                                } else {
                                    // Handle errors gracefully
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Failed, Selected network is down. Try again later.",
                                        icon: "error",
                                    });

                                    // Hide the dropdown container
                                    $("#typeSelectContainer").hide();
                                }
                            },



                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed, Selected network is down try again later.",
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                $('#preloader')
                                    .hide(); // Hide preloader after request completes
                            }
                        });
                    } else {
                        // Fetch the plans via AJAX
                        $.ajax({
                            url: '/user/network/plans',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                var NETWORK_PLAN = '';
                                switch (parseInt(network)) {
                                    case 1:
                                        NETWORK_PLAN = 'MTN_PLAN';
                                        break;
                                    case 2:
                                        NETWORK_PLAN = 'GLO_PLAN';
                                        break;
                                    case 4:
                                        NETWORK_PLAN = 'AIRTEL_PLAN';
                                        break;
                                    case 6:
                                        NETWORK_PLAN = '9MOBILE_PLAN';
                                        break;
                                    default:
                                        NETWORK_PLAN = 'UNKNOWN_PLAN';
                                        break;
                                }

                                if (NETWORK_PLAN !== 'UNKNOWN_PLAN' && response
                                    .hasOwnProperty(NETWORK_PLAN)) {
                                    var variations = response[NETWORK_PLAN];
                                    console.log(variations);

                                    // Filter variations based on network and plan_type
                                    var filteredVariations = variations.filter(
                                        function(variation) {
                                            return variation.network ==
                                                network && variation
                                                .plan_type == networkType;
                                        });

                                    // Clear previous options
                                    $('#serviceVariation').empty();
                                    $('#typeSelect').empty();

                                    // Add a default option
                                    $('#serviceVariation').append(
                                        '<option selected disabled value="">Data bundle...</option>'
                                    );
                                    $('#typeSelect').append(
                                        '<option selected disabled value="">Data bundle...</option>'
                                    );

                                    // Show the proper container and append options
                                    $.each(filteredVariations, function(index,
                                        variation) {
                                        var baseAmount = parseFloat(
                                            variation.plan_amount);
                                        var serviceKey = getServiceKey(
                                            network, networkType);
                                        var percentage = percentageMap[
                                            serviceKey] || 0;
                                        var finalAmount = baseAmount + (
                                            baseAmount * percentage /
                                            100);

                                        $('#serviceVariation').append(
                                            $('<option></option>')
                                            .val(variation
                                                .id
                                            ) // The value will be the plan's id
                                            .text(
                                                `${variation.plan} ${variation.plan_type} - ₦${Math.ceil(finalAmount)} ${variation.month_validate || ''}`
                                            ) // Properly formats the plan details
                                            .data('amount', Math.ceil(variation
                                                .plan_amount
                                            )) // Rounds to nearest whole number and stores it in data attribute
                                        );


                                    });

                                    $('#serviceVariation, #typeSelect').prop(
                                        'disabled', false);
                                    $('#typeSelectContainer').show();
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed, Selected network is down try again later.",
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                $('#preloader')
                                    .hide(); // Hide preloader after request completes
                            }
                        });
                    }
                }

            });

            // Update the amount field based on selected plan
            $('#serviceVariation').change(function() {
                var selectedVariationId = $(this).val();

                if (selectedVariationId) {
                    var selectedOption = $(this).find('option:selected');
                    var selectedPlanAmount = selectedOption.data('amount');

                    $('#amountInput').val(
                        selectedPlanAmount); // Set amount based on the selected variation
                }
            });

            // Handle form submission
            $('#dataForm').submit(function(e) {
                e.preventDefault();

                console.log("-----> #dataForm submitted");
                console.log($(this).serialize());

                $('#preloader').css('display', 'flex'); // Show preloader during form submission

                var formData = $(this).serialize(); // Serialize the form data
                var network = $("#networkSelect").val();
                var dataTypeSelect = $("#dataTypeSelect").val();


                console.log(formData);
                console.log(network);
                console.log(dataTypeSelect);

                var submitUrl = ((network == 1 && dataTypeSelect == "GIFTING") || (network ==
                        4 &&
                        dataTypeSelect == "GIFTING")) ?
                    '{{ route('users.data.purchase.mtn.airtel.data', [
                    'slug' => Helper::merchant()->slug
                    ]) }}' :
                    '{{ route('users.data.purchase', [
                    'slug' => Helper::merchant()->slug
                    ]) }}';

                $.ajax({
                    url: submitUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'delivered') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message,
                                icon: "success",
                            }).then(() => {
                                window.location.href =
                                    '/transactionview?hash=' +
                                    encodeURIComponent(response.result
                                        .content.transactions.transactionId);
                            });
                        } else if (response.status === 'failed') {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(error) {
                        // Log the full error object for detailed debugging
                        console.error("Error object:", error);

                        // Build a detailed error message
                        let errorMessage = `
        <strong>Status:</strong> ${error.status || "N/A"}<br>
        <strong>Status Text:</strong> ${error.statusText || "N/A"}<br>
    `;

                        if (error.responseJSON) {
                            errorMessage += `
            <strong>Response JSON:</strong> ${JSON.stringify(error.responseJSON, null, 2)}<br>
        `;
                        }

                        if (error.responseText) {
                            errorMessage += `
            <strong>Response Text:</strong> ${error.responseText}<br>
        `;
                        }

                        // Show error details in Swal alert
                        Swal.fire({
                            title: "Error Details",
                            html: errorMessage, // Allows HTML content in Swal
                            icon: "error",
                            width: "600px", // Adjust width for better readability
                        });
                    },


                    complete: function() {
                        $('#preloader')
                            .hide(); // Hide preloader after submission completes
                    }
                });
            });

            function getServiceKey(network, type) {
                var serviceKeyMap = {
                    '1': 'MTN',
                    '2': 'GLO',
                    '4': 'Airtel',
                    '6': '9mobile'
                };

                var networkName = serviceKeyMap[network] || '';

                if (type === 'SME 2') {
                    type = 'SME2';
                }
                if (type === 'CORPORATE GIFTING') {
                    type = 'CORPORATE_GIFTING';
                }

                return networkName + '_' + type + '_Data';
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            const tooltips = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            tooltips.forEach(tooltip => new bootstrap.Tooltip(tooltip));

            // Network Selection
            const networkCards = document.querySelectorAll('.network-card');
            const networkInput = document.getElementById('networkSelect');
            const dataTypeContainer = document.getElementById('dataTypeContainer');
            const dataPlanSection = document.getElementById('dataPlanSection');

            networkCards.forEach(card => {
                card.addEventListener('click', function() {
                    networkCards.forEach(c => c.classList.remove('active'));
                    this.classList.add('active');
                    networkInput.value = this.dataset.network;
                    dataTypeContainer.style.display = 'block';
                    dataPlanSection.style.display = 'none';

                    // Populate data types based on network
                    populateDataTypes(this.dataset.network);
                });
            });

            function populateDataTypes(network) {
                const dataTypeSelect = document.getElementById('dataTypeSelect');
                dataTypeSelect.innerHTML = ''; // Clear previous options

                if (network === '1') { // MTN
                    dataTypeSelect.innerHTML = `
                        <option value="">--Choose data type--</option>
                        <option value="SME">SME</option>
                        <option value="SME 2">SME 2</option>
                        <option value="GIFTING">GIFTING</option>
                        <option value="CORPORATE GIFTING">CORPORATE GIFTING</option>
                    `;
                }
                else if (network !== '1') { // GLO
                    dataTypeSelect.innerHTML = `
                        <option value="">--Choose data type--</option>
                        <option value="GIFTING">GIFTING</option>
                        <option value="CORPORATE GIFTING">CORPORATE GIFTING</option>
                    `;
                }

                dataTypeContainer.style.display = 'block';
            }

            // Recipient Toggle
            const recipientButtons = document.querySelectorAll('.recipient-toggle button');
            const recipientLabel = document.querySelector('.recipient-label');
            let isForSelf = true;

            recipientButtons.forEach(button => {
                button.addEventListener('click', function() {
                    recipientButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    isForSelf = this.dataset.recipient === 'self';
                    recipientLabel.textContent = isForSelf ? 'Your' : "Recipient's";
                });
            });

            // Data Plan Selection


            // Form Validation and Submission
            const dataForm = document.getElementById('dataForm');
            dataForm.addEventListener('submit', function(e) {
                e.preventDefault();

                console.log("----> data form 2222 submiited")
                console.log($(this).serialize());

                if (!validateForm()) {
                    Swal.fire({
                        title: "Validation Error",
                        text: "Please fill all required fields correctly.",
                        icon: "error"
                    });
                    return;
                }

                // Show confirmation modal
                const modal = new bootstrap.Modal(document.getElementById('confirmationModal'));

                // Populate confirmation details
                document.getElementById('confirmNetwork').textContent = document.querySelector('.network-card.active h6').textContent;
                document.getElementById('confirmPlan').textContent = document.querySelector('.plan-card.active h6').textContent;
                document.getElementById('confirmPhone').textContent = document.getElementById('tel').value;
                document.getElementById('confirmAmount').textContent = '₦' + Number(document.getElementById('amountInput').value).toLocaleString();

                modal.show();
            });

            // Handle Purchase Confirmation
            document.getElementById('confirmPurchase').addEventListener('click', function() {
                const formData = new FormData(dataForm);
                const network = document.getElementById('networkSelect').value;
                const dataType = document.getElementById('dataTypeSelect').value;

                document.getElementById('preloader').style.display = 'flex';

                 var submitUrl = ((network == 1 && dataTypeSelect == "GIFTING") || (network ==
                        4 &&
                        dataTypeSelect == "GIFTING")) ?
                    '{{ route('users.data.purchase.mtn.airtel.data', [
                    'slug' => Helper::merchant()->slug
                    ]) }}' :
                    '{{ route('users.data.purchase', [
                    'slug' => Helper::merchant()->slug
                    ]) }}';

                fetch(submitUrl, {
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
                            html: `${response.message}
                                  <div class="success-checkmark mt-3">
                                      <span class="material-icons-round" style="font-size: 48px; color: var(--success-color);">
                                          check_circle
                                      </span>
                                  </div>`,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(() => {
                            window.location.reload();
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
            });

            // Initialize Data Usage Chart
            const dataUsageOptions = {
                series: [44, 55, 13, 43],
                chart: {
                    height: 300,
                    type: 'pie',
                },
                labels: ['MTN', 'Airtel', 'Glo', '9mobile'],
                colors: ['#ffc107', '#dc3545', '#28a745', '#20c997'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 250
                        }
                    }
                }]
            };

            const dataUsageChart = new ApexCharts(document.getElementById('dataUsageChart'), dataUsageOptions);
            dataUsageChart.render();

            // Contact Picker (if supported)
            if ('contacts' in navigator && 'ContactsManager' in window) {
                document.getElementById('pickContact').addEventListener('click', async () => {
                    try {
                        const contacts = await navigator.contacts.select(['tel']);
                        if (contacts.length > 0 && contacts[0].tel.length > 0) {
                            document.getElementById('tel').value = contacts[0].tel[0];
                        }
                    } catch (err) {
                        console.log('Contact picker failed:', err);
                    }
                });
            } else {
                document.getElementById('pickContact').style.display = 'none';
            }

            // Helper function to reorder data
            window.reorderData = function(phone, network) {
                document.getElementById('tel').value = phone;
                const networkCard = document.querySelector(`[data-network="${network}"]`);
                if (networkCard) {
                    networkCard.click();
                }
            };
        });
    </script>
@endsection
