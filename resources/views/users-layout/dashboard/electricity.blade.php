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
    <!-- Noty Notification -->
    <link href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/themes/mint.css" rel="stylesheet">
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

        /* Chart animations */
        #usageChart.success-animation {
            position: relative;
        }

        #usageChart.success-animation::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            border-radius: var(--card-border-radius);
            animation: flash 0.8s ease-out;
            pointer-events: none;
        }

        @keyframes flash {
            0% { opacity: 0.8; }
            100% { opacity: 0; }
        }
    </style>
@endsection

@section('content')
    <div class="main-content electricity-page">
        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="text-xl font-semibold mb-1">Buy Electricity</h4>
                        <p class="text-gray-500">Purchase electricity for your home</p>
                    </div>
                    {!! Helper::generateBreadCrumbs('Electricity') !!}
                </div>

                <div class="row">

                    <!-- Wallet Balance Card -->
                    <x-users.wallet-balance></x-users.wallet-balance>
                    <!-- Left Column: Purchase Form -->
                    <div class="col-lg-8">


                        <!-- Purchase Form Card -->
                        <div class="meter-info-card">
                        <div class="custom-validation"></div>
                            <form id="electricityForm" class="">
                                @csrf
                                <!-- Disco Selection -->
                                <div class="mb-4">
                                    <label class="form-label">Select Distribution Company</label>
                                    <div class="disco-select">
                                        @foreach ($products as $product)
                                            <div class="disco-option" data-disco="{{ $product->service_name }}">
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
                            </form>
                        </div>

                        <!-- Meter Information Card -->
                        <div class="meter-info-card" id="meterInfo" style="display: none;">
                            <h5 class="mb-4">Meter Information</h5>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Customer Name</span>
                                <span class="text-gray-800 fw-bold" id="customerName"></span>
                            </div>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Address</span>
                                <span class="text-gray-800" id="customerAddress"></span>
                            </div>
                            <div class="meter-info-item">
                                <span class="text-gray-600">Meter Number</span>
                                <span class="text-gray-800 fw-bold" id="meterNumberConfirm"></span>
                            </div>
                        </div>

                        <div id="purchaseOptions" style="display: none;">
                            <!-- Quick Amounts -->
                            <div class="meter-info-card mb-4">
                                <h5 class="mb-3">Select Amount</h5>
                                <div class="d-flex gap-3 flex-wrap mb-3">
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="1000">₦1,000</button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="2000">₦2,000</button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="5000">₦5,000</button>
                                    <button type="button" class="btn btn-outline-primary quick-amount" data-amount="10000">₦10,000</button>
                                    <input type="hidden" id="amount" name="amount" value="">
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">₦</span>
                                    <input type="number" class="form-control" id="customAmount" placeholder="Enter custom amount">
                                </div>

                                <div class="input mb-3">
                                    <input type="text" class="form-control" id="phone" placeholder="enter phone number">
                                </div>


                            </div>

                            <!-- Submit Purchase Button -->
                            <button type="submit" class="submit-button" id="submitPurchase">
                                <span class="material-icons-round me-2">shopping_cart</span>
                                Purchase Electricity
                            </button>
                        </div>
                    </div>



                 <!-- Right Column: Usage Chart & Recent Purchases -->
                <div class="col-lg-4">
                    <!-- Usage Chart Card -->
                    <div class="meter-info-card mb-4">
                        <h5 class="mb-4">Purchase Chart</h5>
                        <div id="usageChart"></div>
                    </div>

                    <!-- Recent Purchases Card -->
                    <div class="recent-purchases meter-info-card">
                        <h5 class="mb-4">Recent Purchases</h5>

                        @forelse($recentTransactions  as $transaction)
                        <div class="purchase-item" id="{{ $transaction->id }}" data-id="{{ $transaction->id }}" data-token="{{ $transaction->purchased_code }}">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="text-gray-600">{{Str::title($transaction->meter_type)}} Purchase</span>
                                    <span class="text-gray-800">₦{{ number_format($transaction->amount ?? 0) }}</span>
                                </div>
                                <div class="text-muted"> Meter No.: {{ $transaction->identity ?? 'N/A' }}</div>

                            </div>
                            <div>
                                <span class="badge {{ $transaction->status === 'pending' ? 'bg-warning' : ($transaction->status === 'delivered' ? 'bg-success' : 'bg-danger') }}">{{ Str::title($transaction->status) }}</span>
                            </div>
                        </div>
                        @empty
                        <div class="text-muted">No recent purchases found.</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

  @include('users-layout.dashboard.partials.electricity.modals')

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/noty@3.2.0-beta/lib/noty.js"></script>
<script>
  window.ElectricityConfig = {
    validateMeterUrl: "{{ route('users.meterCodeVerify') }}",
    purchaseUrl:      "{{ route('users.electricity.purchase') }}",
    csrfToken:        "{{ csrf_token() }}",
    chartData: @json($trxChartData),
    chartLabels: {!! $chartLabels !!},
    chartValues: {!! $chartValues !!}
  };
</script>

<script src="{{ asset('assets/js/users/electricity-chart.js') }}"></script>
<script src="{{ asset('assets/js/users/electricity.js') }}"></script>

<script>
// Fix for accessibility issue with modal focus management
document.addEventListener('DOMContentLoaded', function() {
  const successModal = document.getElementById('successModal');
  const errorModal = document.getElementById('errorModal');
  let previousFocusElement = null;

  // Save original aria-hidden values before Bootstrap modifies them
  document.querySelectorAll('[aria-hidden]').forEach(element => {
    if (!element.hasAttribute('data-aria-hidden-original')) {
      element.setAttribute('data-aria-hidden-original', element.getAttribute('aria-hidden'));
    }
  });

  // Helper function to manage focus trapping in a modal
  function setupFocusTrap(modal) {
    if (!modal) return;

    // Get focusable elements, prioritize those with data-focus-first attribute
    const focusableElements = modal.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
    let firstFocusableElement = null;
    let lastFocusableElement = null;

    // First check if we have an element with data-focus-first
    const priorityFocusElement = modal.querySelector('[data-focus-first="true"]');
    if (priorityFocusElement) {
      firstFocusableElement = priorityFocusElement;
    } else if (focusableElements.length > 0) {
      firstFocusableElement = focusableElements[0];
    }

    if (focusableElements.length > 0) {
      lastFocusableElement = focusableElements[focusableElements.length - 1];
    }

    if (!firstFocusableElement || !lastFocusableElement) return;

    // Setup keyboard handling for focus trapping
    modal.addEventListener('keydown', function(e) {
      if (e.key === 'Tab') {
        if (e.shiftKey) { // Shift + Tab
          if (document.activeElement === firstFocusableElement) {
            lastFocusableElement.focus();
            e.preventDefault();
          }
        } else { // Just Tab
          if (document.activeElement === lastFocusableElement) {
            firstFocusableElement.focus();
            e.preventDefault();
          }
        }
      } else if (e.key === 'Escape') {
        // Close the modal on Escape
        const bootstrapModal = bootstrap.Modal.getInstance(modal);
        if (bootstrapModal) {
          bootstrapModal.hide();
        }
      }
    });
  }

  // Setup focus management for success modal
  if (successModal) {
    setupFocusTrap(successModal);

    successModal.addEventListener('shown.bs.modal', function() {
      // Store the previously focused element
      previousFocusElement = document.activeElement;

      // Focus on the download receipt button when the modal is shown
      const downloadBtn = document.getElementById('downloadReceipt');
      if (downloadBtn) {
        downloadBtn.focus();
      }
    });

    successModal.addEventListener('hidden.bs.modal', function() {
      // Delay the focus restoration to ensure the modal is fully closed
      setTimeout(() => {
        // Return focus to the element that had focus before the modal opened
        if (previousFocusElement && typeof previousFocusElement.focus === 'function') {
          previousFocusElement.focus();
          // Set a small timeout to ensure focus isn't immediately moved elsewhere
          setTimeout(() => {
            if (document.activeElement !== previousFocusElement) {
              previousFocusElement.focus();
            }
          }, 10);
        }

        // Reset document-wide aria-hidden attributes that might have been set by Bootstrap
        document.querySelectorAll('[aria-hidden="true"]').forEach(element => {
          // Only remove aria-hidden from elements that are outside our modal
          // and are not naturally aria-hidden elements
          if (!successModal.contains(element) && element !== successModal &&
              !element.hasAttribute('data-aria-hidden-original')) {
            element.removeAttribute('aria-hidden');
          }
        });
      }, 100);
    });
  }

  // Setup focus management for error modal
  if (errorModal) {
    setupFocusTrap(errorModal);

    errorModal.addEventListener('shown.bs.modal', function() {
      // Store the previously focused element
      previousFocusElement = document.activeElement;

      // Focus on the retry button when the modal is shown
      const retryBtn = document.getElementById('retryButton');
      if (retryBtn) {
        retryBtn.focus();
      }
    });

    errorModal.addEventListener('hidden.bs.modal', function() {
      // Delay the focus restoration to ensure the modal is fully closed
      setTimeout(() => {
        // Return focus to the element that had focus before the modal opened
        if (previousFocusElement && typeof previousFocusElement.focus === 'function') {
          previousFocusElement.focus();
          // Set a small timeout to ensure focus isn't immediately moved elsewhere
          setTimeout(() => {
            if (document.activeElement !== previousFocusElement) {
              previousFocusElement.focus();
            }
          }, 10);
        }

        // Reset document-wide aria-hidden attributes that might have been set by Bootstrap
        document.querySelectorAll('[aria-hidden="true"]').forEach(element => {
          // Only remove aria-hidden from elements that are outside our modal
          // and are not naturally aria-hidden elements
          if (!errorModal.contains(element) && element !== errorModal &&
              !element.hasAttribute('data-aria-hidden-original')) {
            element.removeAttribute('aria-hidden');
          }
        });
      }, 100);
    });
  }
});
</script>
@endsection
