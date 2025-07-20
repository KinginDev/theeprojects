@php
    use App\Classes\Helper;
@endphp

@extends('users-layout.dashboard.layouts.app')

@section('title', 'Dashboard Page')

@section('styles')
<style>
    :root {
        --primary-color: {{ $configuration->template_color }};
        --primary-rgb: 59, 125, 221;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --info-color: #17a2b8;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
    }

    /* Modern Dashboard Styles */
    body {
        background: #f8f9fa;
    }

    .card {
        border: none;
        border-radius: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.08) !important;
    }

    .stat-card {
        overflow: hidden;
    }

    .stat-card .card-body {
        position: relative;
        z-index: 1;
    }

    .stat-card .card-body:before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 120px;
        height: 100%;
        transform: skewX(-15deg);
        background: linear-gradient(to right, transparent, rgba(255,255,255,0.1));
        z-index: -1;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }

    .chart-card {
        min-height: 400px;
    }

    .activity-item {
        padding: 1rem;
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        background: #fff;
        border: 1px solid rgba(0,0,0,.05);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        transform: translateX(5px);
        border-color: var(--primary-color);
    }

    .quick-action {
        text-align: center;
        padding: 1.5rem;
        border-radius: 1rem;
        background: #fff;
        transition: all 0.3s ease;
    }

    .quick-action:hover {
        background: var(--primary-color);
        color: #fff;
    }

    .quick-action:hover i {
        color: #fff !important;
    }

    .avatar-sm {
        height: 2.5rem;
        width: 2.5rem;
    }

    .avatar-title {
        align-items: center;
        background-color: var(--primary-color);
        color: #fff;
        display: flex;
        font-weight: 500;
        height: 100%;
        justify-content: center;
        width: 100%;
    }

    /* Progress bar styling */
    .progress {
        height: 8px;
        border-radius: 4px;
        background-color: rgba(var(--primary-rgb), 0.1);
    }

    .progress-bar {
        border-radius: 4px;
        background-color: var(--primary-color);
    }

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar {
        width: 6px;
        height: 6px;
    }

    .custom-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,.2);
        border-radius: 10px;
    }

    .custom-scroll::-webkit-scrollbar-track {
        background-color: rgba(0,0,0,.05);
    }

    /* Responsive Typography */
    @media (max-width: 768px) {
        h3 {
            font-size: 1.5rem;
        }
        h4 {
            font-size: 1.25rem;
        }
        .stat-card {
            margin-bottom: 1rem;
        }
    }

    /* Marquee Animation */
    @keyframes marquee {
        0% { transform: translateX(100%); }
        100% { transform: translateX(-100%); }
    }

    .referral-marquee {
        overflow: hidden;
        white-space: nowrap;
    }

    .referral-marquee .text {
        display: inline-block;
        animation: marquee 20s linear infinite;
    }

    .marquee-container {
        position: relative;
        width: 100%;
    }
</style>
@endsection

@section('content')
    @if (isset($hideModal) && $hideModal)
        <script>
            $(document).ready(function () {
                $('.bs-example-modal-center1').modal('hide');
            });
        </script>
    @elseif(isset($showModal) && $showModal)
        <script>
            $(document).ready(function () {
                $('.bs-example-modal-center1').modal('show');
            });
        </script>
    @endif

    <!-- Main content -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Welcome Section -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm border-0 overflow-hidden">
                            <div class="card-body py-4">
                                <div class="row align-items-center">
                                    <div class="col-sm-8">
                                        <h4 class="mb-2 fw-semibold">Welcome back, {{ $userData->username }}! 👋</h4>
                                        <p class="text-muted mb-0">Your wallet balance is
                                            <span class="fw-semibold text-success">₦{{ number_format($walletBalance, 2) }}</span>
                                        </p>
                                    </div>
                                    <div class="col-sm-4 text-sm-end mt-4 mt-sm-0">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center1">
                                            <i class="bi bi-plus-circle me-1"></i> Quick Fund
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute top-0 end-0 start-0 h-100" style="background: linear-gradient(45deg, {{ $configuration->template_color }}15 0%, {{ $configuration->template_color }}05 100%);"></div>
                        </div>
                    </div>
                </div>

                <!-- Referral Announcement -->
                <div class="card bg-primary border-0 mb-4">
                    <div class="card-body py-2 px-3">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-megaphone-fill text-white me-2"></i>
                            <div class="marquee-container overflow-hidden">
                                <div class="text-white" style="white-space: nowrap; animation: marquee 20s linear infinite;">
                                    🎁 Refer friends to E Project - Get 5% of their first funding + ₦500 bonus on TopUser upgrade (Max ₦1,500) 🎁
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Section -->
                <div class="row g-3 mb-4">
                    <!-- Total Balance -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                                        <i class="bi bi-wallet2"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Total Balance</h6>
                                        <h4 class="mb-0 mt-1">₦{{ number_format($walletBalance, 2) }}</h4>
                                        <div class="progress mt-3" style="height:4px;">
                                            <div class="progress-bar" style="width: 100%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Credited -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                                        <i class="bi bi-arrow-up-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Total Credited</h6>
                                        <h4 class="mb-0 mt-1">₦{{ number_format($totalCreditedAmount, 2) }}</h4>
                                        <p class="text-muted mt-2 mb-0 small">
                                            <span class="text-success me-2">
                                                <i class="bi bi-arrow-up"></i> {{ $totalCreditedTransactions }}
                                            </span>
                                            Transactions
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Debited -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                                        <i class="bi bi-arrow-down-circle"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Total Debited</h6>
                                        <h4 class="mb-0 mt-1">₦{{ number_format($totalDebitedAmount, 2) }}</h4>
                                        <p class="text-muted mt-2 mb-0 small">
                                            <span class="text-danger me-2">
                                                <i class="bi bi-arrow-down"></i> {{ $totalTransactions }}
                                            </span>
                                            Transactions
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Referral Balance -->
                    <div class="col-sm-6 col-xl-3">
                        <div class="card stat-card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-start">
                                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h6 class="text-muted mb-0">Referral Bonus</h6>
                                        <h4 class="mb-0 mt-1">₦{{ number_format($userData->refferal_bonus, 2) }}</h4>
                                        <p class="text-muted mt-2 mb-0 small">
                                            Total Referrals: {{ $userData->refferal }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts & Quick Actions -->
                <div class="row g-3 mb-4">
                    <!-- Transaction Chart -->
                    <div class="col-xl-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-transparent">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0">Transaction Analytics</h5>
                                    <div class="ms-auto">
                                        <select class="form-select form-select-sm" id="chartPeriod">
                                            <option value="7">Last 7 Days</option>
                                            <option value="30">Last 30 Days</option>
                                            <option value="90">Last 3 Months</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="transactionChart" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>



                     <!-- Referral Section -->
                    <div class="col-xl-4">
                        <div class="card shadow-sm">
                            <div class="card-header bg-transparent border-bottom">
                                <h5 class="mb-0">Referral Program</h5>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <div class="avatar-lg mx-auto mb-3">
                                        <div class="avatar-title rounded-circle bg-primary bg-opacity-10 text-primary">
                                            <i class="bi bi-people-fill display-5"></i>
                                        </div>
                                    </div>
                                    <h4 class="mb-1">₦{{ number_format($userData->refferal_bonus, 2) }}</h4>
                                    <p class="text-muted mb-0">Total Referral Earnings</p>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Your Referral Link</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="referral_link"
                                               value="{{ url('/registration') . '?ref=' . (auth()->user()->user_id ?? 'defaultID') }}"
                                               readonly>
                                        <button class="btn btn-primary" type="button" id="copy_link_btn"
                                                onclick="copyToElementToClipboard('referral_link', 'copy_link_btn')">
                                            <i class="bi bi-clipboard me-1"></i>
                                            Copy
                                        </button>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Referral Code</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="referral_code"
                                               value="{{ auth()->user()->user_id ?? 'defaultID' }}"
                                               readonly>
                                        <button class="btn btn-primary" type="button" id="copy_code_btn"
                                                onclick="copyToElementToClipboard('referral_code', 'copy_code_btn')">
                                            <i class="bi bi-clipboard me-1"></i>
                                            Copy
                                        </button>
                                    </div>
                                </div>

                                @if (isset($userData) && $userData->topuser_earners == 0)
                                    <div class="mt-4">
                                        <div class="alert alert-info mb-3">
                                            <i class="bi bi-info-circle me-2"></i>
                                            Upgrade to Top User to earn more from referrals!
                                        </div>
                                        <button class="btn btn-primary w-100 upgradeTopUser">
                                            <i class="bi bi-arrow-up-circle me-1"></i>
                                            Upgrade Now (₦1,500)
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions & Referral -->
                <div class="row g-3">
                    <!-- Recent Transactions -->
                    <div class="col-xl-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-transparent border-bottom">
                                <div class="d-flex align-items-center">
                                    <h5 class="mb-0">Recent Transactions</h5>
                                    <a href="{{ route('users.usertransactions', ['slug' => Helper::merchant()->slug]) }}"
                                       class="btn btn-link ms-auto">View All</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="border-top-0">Type</th>
                                                <th class="border-top-0">Amount</th>
                                                <th class="border-top-0">Date</th>
                                                <th class="border-top-0">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-xs me-2">
                                                                <span class="avatar-title rounded-circle bg-{{
                                                                    $transaction->type === 'airtime' ? 'primary' :
                                                                    ($transaction->type === 'data' ? 'info' :
                                                                    ($transaction->type === 'electricity' ? 'warning' :
                                                                    ($transaction->type === 'tv' ? 'danger' : 'secondary')))
                                                                }} bg-opacity-10 text-{{
                                                                    $transaction->type === 'airtime' ? 'primary' :
                                                                    ($transaction->type === 'data' ? 'info' :
                                                                    ($transaction->type === 'electricity' ? 'warning' :
                                                                    ($transaction->type === 'tv' ? 'danger' : 'secondary')))
                                                                }}">
                                                                    <i class="bi bi-{{
                                                                        $transaction->type === 'airtime' ? 'phone' :
                                                                        ($transaction->type === 'data' ? 'wifi' :
                                                                        ($transaction->type === 'electricity' ? 'lightning-charge' :
                                                                        ($transaction->type === 'tv' ? 'tv' : 'arrow-left-right')))
                                                                    }}"></i>
                                                                </span>
                                                            </div>
                                                            <div>
                                                                <h6 class="mb-0">{{ ucfirst($transaction->type) }}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <span class="badge bg-{{
                                                            $transaction->status === 'success' ? 'success' :
                                                            ($transaction->status === 'pending' ? 'warning' : 'danger')
                                                        }} bg-opacity-10 text-{{
                                                            $transaction->status === 'success' ? 'success' :
                                                            ($transaction->status === 'pending' ? 'warning' : 'danger')
                                                        }} px-2 py-1">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-xl-4 my-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-transparent">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="p-3">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a href="{{ route('users.airtime', ['slug' => Helper::merchant()->slug]) }}"
                                               class="card shadow-none border text-center h-100">
                                                <div class="card-body">
                                                    <div class="avatar-sm mx-auto mb-2">
                                                        <span class="avatar-title rounded-circle bg-primary bg-opacity-10 text-primary">
                                                            <i class="bi bi-phone"></i>
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-0">Airtime</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('users.data', ['slug' => Helper::merchant()->slug]) }}"
                                               class="card shadow-none border text-center h-100">
                                                <div class="card-body">
                                                    <div class="avatar-sm mx-auto mb-2">
                                                        <span class="avatar-title rounded-circle bg-info bg-opacity-10 text-info">
                                                            <i class="bi bi-wifi"></i>
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-0">Data</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('users.electricity', ['slug' => Helper::merchant()->slug]) }}"
                                               class="card shadow-none border text-center h-100">
                                                <div class="card-body">
                                                    <div class="avatar-sm mx-auto mb-2">
                                                        <span class="avatar-title rounded-circle bg-warning bg-opacity-10 text-warning">
                                                            <i class="bi bi-lightning-charge"></i>
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-0">Electricity</h6>
                                                </div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('users.tv', ['slug' => Helper::merchant()->slug]) }}"
                                               class="card shadow-none border text-center h-100">
                                                <div class="card-body">
                                                    <div class="avatar-sm mx-auto mb-2">
                                                        <span class="avatar-title rounded-circle bg-danger bg-opacity-10 text-danger">
                                                            <i class="bi bi-tv"></i>
                                                        </span>
                                                    </div>
                                                    <h6 class="mb-0">TV</h6>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <script>document.write(new Date().getFullYear())</script> © {{ $configuration->site_name }}
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Funding Modal -->
    <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Quick Fund</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.make.payment', ['slug' => Helper::merchant()->slug]) }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="wallet">

                        <div class="mb-4">
                            <div class="alert alert-info d-flex align-items-center">
                                <i class="bi bi-info-circle fs-4 me-2"></i>
                                <div>
                                    <strong>Account Username:</strong><br>
                                    {{ $userData->username }}
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Amount to Fund</label>
                            <div class="input-group">
                                <span class="input-group-text">₦</span>
                                <input type="number" class="form-control" name="amount"
                                       required min="100" placeholder="Enter amount"
                                       id="amount">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Transaction Charge</span>
                            <span class="fw-medium text-primary" id="transactionCharge">₦0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="fw-medium">Total Amount</span>
                            <span class="fw-bold text-primary" id="total">₦0.00</span>
                            <input type="hidden" id="totalAmount" name="totalAmount" >
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-wallet2 me-1"></i>
                            Proceed to Payment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Manual Bank Transfer Modal -->
    <div class="modal fade mySmallModalfund" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Bank Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        Transfer to any of our bank accounts below. Your wallet will be credited automatically.
                    </div>

                    <div class="list-group mb-4">
                        <!-- Bank details will be populated here -->
                    </div>

                    <div class="alert alert-warning">
                        <h6 class="alert-heading fw-bold mb-2">Important Notes:</h6>
                        <ul class="mb-0 ps-3">
                            <li>Use your username as payment reference</li>
                            <li>Funds are typically credited within 5-10 minutes</li>
                            <li>Contact support if you need assistance</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize charts
        document.addEventListener('DOMContentLoaded', function() {
            // Transaction Chart
            var options = {
                series: [{
                    name: 'Credits',
                    data: [30, 40, 45, 50, 49, 60, 70]
                }, {
                    name: 'Debits',
                    data: [20, 35, 40, 45, 40, 50, 60]
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#28a745', '#dc3545'],
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                grid: {
                    borderColor: '#f1f1f1',
                },
                markers: {
                    size: 4
                },
                xaxis: {
                    categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                }
            };

            var chart = new ApexCharts(document.querySelector("#transactionChart"), options);
            chart.render();
        });

        // Fund wallet amount calculator
        document.getElementById('amount').addEventListener('input', function() {
            const amount = parseFloat(this.value) || 0;
            const charge = Math.min(Math.max(amount * 0.015, 50), 2000); // 1.5% charge, min 50, max 2000
            const total = amount + charge;

            document.getElementById('transactionCharge').textContent = '₦' + charge.toFixed(2);
            document.getElementById('total').textContent = '₦' + total.toFixed(2);
            document.getElementById('totalAmount').value = total.toFixed(2);
        });


    </script>
@endsection
