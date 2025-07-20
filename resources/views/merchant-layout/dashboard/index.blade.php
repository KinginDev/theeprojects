@php
    use App\Classes\Helper;
@endphp

@extends('merchant-layout.layouts.app')

@section('title', 'Dashboard Page')

@section('content')
    <!-- ApexCharts -->
    <link href="https://cdn.jsdelivr.net/npm/apexcharts@3.40.0/dist/apexcharts.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.40.0/dist/apexcharts.min.js"></script>

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

    <div class="main-content">
        <div class="container-fluid">
            <!-- Welcome Section -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="mb-0 font-size-18">Welcome Back!</h4>
                            <p class="text-muted mb-0">{{ $user->name }}</p>
                            <p class="text-muted mb-0"><small><i
                                        class="ri-global-line me-1"></i>{{ Auth::guard('merchant')->user()->domain }}</small>
                            </p>
                        </div>
                        {!! Helper::generateBreadCrumbs('Dashboard Page') !!}
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="row mb-4">
                <!-- Total Balance -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 border-left-primary shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-xs font-weight-bold text-primary text-uppercase">
                                    Merchant Balance
                                </div>
                                <div class="avatar-sm rounded-circle bg-soft-primary">
                                    <i class="ri-wallet-3-line font-size-24 avatar-title text-primary"></i>
                                </div>
                            </div>
                            <div class="h5 mb-0 font-weight-bold">₦{{ number_format($merchantBalance, 2) }}</div>
                            <div class="text-sm text-muted mt-2">Available Balance</div>
                        </div>
                    </div>
                </div>

                <!-- Total Users -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 border-left-success shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-xs font-weight-bold text-success text-uppercase">
                                    Total Users
                                </div>
                                <div class="avatar-sm rounded-circle bg-soft-success">
                                    <i class="ri-team-line font-size-24 avatar-title text-success"></i>
                                </div>
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ number_format($userCount) }}</div>
                            <div class="text-sm text-muted mt-2">Registered Users</div>
                        </div>
                    </div>
                </div>

                <!-- Total Credited -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 border-left-info shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-xs font-weight-bold text-info text-uppercase">
                                    Total Credited
                                </div>
                                <div class="avatar-sm rounded-circle bg-soft-info">
                                    <i class="ri-arrow-up-circle-line font-size-24 avatar-title text-info"></i>
                                </div>
                            </div>
                            <div class="h5 mb-0 font-weight-bold">₦{{ number_format($totalCreditedAmount, 2) }}</div>
                            <div class="text-sm text-success mt-2">
                                <i class="ri-arrow-up-line"></i> Total Inflow
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Debited -->
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card h-100 border-left-warning shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="text-xs font-weight-bold text-warning text-uppercase">
                                    Total Debited
                                </div>
                                <div class="avatar-sm rounded-circle bg-soft-warning">
                                    <i class="ri-arrow-down-circle-line font-size-24 avatar-title text-warning"></i>
                                </div>
                            </div>
                            <div class="h5 mb-0 font-weight-bold">₦{{ number_format($totalDebitedAmount, 2) }}</div>
                            <div class="text-sm text-danger mt-2">
                                <i class="ri-arrow-down-line"></i> Total Outflow
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Row -->
            <div class="row mb-4">
                <!-- Transaction History Chart -->
                <div class="col-xl-8 col-lg-7">
                    <div class="card shadow-sm">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Transaction Overview</h6>
                        </div>
                        <div class="card-body">
                            <div id="transaction-history" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Service Distribution Chart -->
                <div class="col-xl-4 col-lg-5">
                    <div class="card shadow-sm">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Service Distribution</h6>
                        </div>
                        <div class="card-body">
                            <div id="service-distribution" style="height: 350px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions and Recent Transactions -->
            <div class="row">
                <!-- Quick Actions -->
                <div class="col-xl-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-4">
                                    <a href="{{ route('merchant.airtime') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-phone-line font-size-24 d-block mb-2 text-primary"></i>
                                        <span class="text-muted small">Airtime</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('merchant.data') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-wifi-line font-size-24 d-block mb-2 text-info"></i>
                                        <span class="text-muted small">Data</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('merchant.electricity') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-lightbulb-flash-line font-size-24 d-block mb-2 text-warning"></i>
                                        <span class="text-muted small">Power</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('merchant.tv') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-tv-line font-size-24 d-block mb-2 text-danger"></i>
                                        <span class="text-muted small">TV</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('merchant.insurance') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-shield-check-line font-size-24 d-block mb-2 text-success"></i>
                                        <span class="text-muted small">Insurance</span>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <a href="{{ route('merchant.education') }}"
                                        class="text-center d-block p-3 rounded hover-shadow">
                                        <i class="ri-book-open-line font-size-24 d-block mb-2 text-primary"></i>
                                        <span class="text-muted small">Education</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="col-xl-8 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Transactions</h6>
                            <a href="{{ route('merchant.transactions') }}" class="btn btn-sm btn-primary shadow-sm">
                                View All
                            </a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Flow</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentTransactions as $transaction)
                                            <tr>
                                                <td>{{ $transaction->owner->name }}</td>
                                                <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                <td>
                                                    @if($transaction->kind == 'credit')
                                                        <span class="badge bg-soft-success text-success">Credit</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Debit</span>
                                                    @endif
                                                </td>
                                                <td>{{ \Str::title($transaction->type) }}</td>
                                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Fund account with Monnify(ATM / BANK TRANSFER)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('merchant.make.payment') }}" method="post">
                        @csrf
                        <input type="hidden" name="type" value="wallet">
                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Account Username:</b> {{ $user->username }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Amount</label>
                            <div>
                                <input type="number" class="form-control p-12" required parsley-type="amount"
                                    placeholder="Enter amount" name="amount" id="amount" />
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <span>Transaction charge</span>
                            <span class="text-primary" id="transactionCharge">₦0</span>
                        </div>
                        <hr>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Total</span>
                            <span class="text-primary" id="total">₦0</span>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <button type="submit" class="btn btn-org w-100 p-2">Continue</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <style>
        .border-left-primary {
            border-left: 4px solid #4e73df !important;
        }

        .border-left-success {
            border-left: 4px solid #1cc88a !important;
        }

        .border-left-info {
            border-left: 4px solid #36b9cc !important;
        }

        .border-left-warning {
            border-left: 4px solid #f6c23e !important;
        }

        .bg-soft-primary {
            background-color: rgba(78, 115, 223, 0.1) !important;
        }

        .bg-soft-success {
            background-color: rgba(28, 200, 138, 0.1) !important;
        }

        .bg-soft-info {
            background-color: rgba(54, 185, 204, 0.1) !important;
        }

        .bg-soft-warning {
            background-color: rgba(246, 194, 62, 0.1) !important;
        }

        .hover-shadow:hover {
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15) !important;
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }

        .font-size-24 {
            font-size: 24px !important;
        }

        .avatar-sm {
            height: 3rem;
            width: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-title {
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <!-- Initialize Charts -->
    <script>
        $(document).ready(function () {
            // Function to get query parameters from URL
            function getQueryParam(param) {
                let searchParams = new URLSearchParams(window.location.search);
                return searchParams.get(param);
            }

            // Get hash from URL and tab from query parameter
            let hash = window.location.hash;
            let queryTab = getQueryParam('tab');

            // Determine which tab to show
            let tabId = '';
            if (hash) {
                tabId = hash.substring(1);
                // Remove query parameters while keeping the hash
                window.history.replaceState(null, null, window.location.pathname + hash);
            } else if (queryTab) {
                tabId = queryTab;
            }

            // Show the tab if we have an ID
            if (tabId) {
                let tabElement = $(`#entityDetailsTab a[href="#${tabId}"]`);
                if (tabElement.length) {
                    tabElement.tab('show');
                }
            }

            // Handle tab clicks
            $('#entityDetailsTab a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
                // Update URL hash without adding to browser history
                let tabId = $(this).attr('href').substring(1);
                window.history.replaceState(null, null, `#${tabId}`);
            });
        });
        document.addEventListener('DOMContentLoaded', function () {
            // Transaction History Chart
            var transactionOptions = {
                series: [{
                    name: 'Transactions',
                    data: @json($last6Months->pluck('amount'))
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: @json($last6Months->pluck('month'))
                },
                colors: ['#4e73df'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '₦' + val.toLocaleString()
                        }
                    }
                }
            };

            var transactionChart = new ApexCharts(document.querySelector("#transaction-history"), transactionOptions);
            transactionChart.render();

            // Service Distribution Chart
            var serviceData = @json($serviceTransactions);
            var serviceOptions = {
                series: Object.values(serviceData),
                chart: {
                    type: 'donut',
                    height: 350
                },
                labels: Object.keys(serviceData),
                colors: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }],
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return '₦' + val.toLocaleString()
                        }
                    }
                }
            };

            var serviceChart = new ApexCharts(document.querySelector("#service-distribution"), serviceOptions);
            serviceChart.render();
        });
    </script>
@endsection
