@extends('users-layout.dashboard.layouts.app')

@section('title', 'Transaction History')

@section('content')
    @php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Page Header -->
                <div class="row">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-4">Transaction History</h4>
                        </div>
                    </div>
                </div>
                <!-- End Page Header -->

                <!-- Main Content -->
                <div class="container main-tags">
                    <!-- User Information -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h5>{{ $userData->username }}</h5>
                                    <p class="mb-0">Balance: ₦{{ number_format($userData->account_balance, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Account History and Activities -->
                    <h3>Your Account History And Activities</h3>
                    <div class="d-flex flex-wrap mt-3">
                        <span class="btn btn-primary me-2 mb-2" id="airtime-payment-badge">Airtime</span>
                        <span class="btn btn-primary me-2 mb-2" id="data-payment-badge">Data</span>
                        <span class="btn btn-primary me-2 mb-2" id="electricity-payment-badge">Electricity</span>
                        <span class="btn btn-primary me-2 mb-2" id="tv-payment-badge">TV Subscription</span>
                        <span class="btn btn-primary me-2 mb-2" id="education-payment-badge">Education</span>
                        <span class="btn btn-primary me-2 mb-2" id="insurance-payment-badge">Insurance</span>
                        <span class="btn btn-primary me-2 mb-2" id="fund-payment-badge">Bank Payment</span>

                    </div>

                    <!-- Airtime Payment Table -->
                    <div class="table-responsive mt-4" id="airtime-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Network</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="airtime-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Data Payment Table -->
                    <div class="table-responsive mt-4" id="data-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Network</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Plan</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="data-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Electricity Payment Table -->
                    <div class="table-responsive mt-4" id="electricity-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Token</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="electricity-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- TV Payment Table -->
                    <div class="table-responsive mt-4" id="tv-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Network</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Plan</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tv-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Education Payment Table -->
                    <div class="table-responsive mt-4" id="education-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="education-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Insurance Payment Table -->
                    <div class="table-responsive mt-4" id="insurance-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="insurance-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Insurance Payment Table -->
                    <div class="table-responsive mt-4" id="fund-payment-table" style="display:none;">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product Name</th>
                                    <th>Amount</th>
                                    <th>Phone Number</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="fund-payment-tbody">
                                <!-- Data will be populated here by AJAX -->
                            </tbody>
                        </table>
                    </div>


                </div>
                <!-- End Main Content -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ $configuration->site_name }}.
                    </div>
                </div>
            </div>
        </footer>

    </div>
    <script>
        $(document).ready(function() {
            // Fetch and display Airtime transactions
            $('#airtime-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-airtime-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#airtime-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                                <tr>
                                    <td>${transaction.transaction_id}</td>
                                    <td>${transaction.network}</td>
                                    <td>₦${transaction.amount}</td>
                                    <td>${transaction.tel}</td>
                                    <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                                    <td><span class="badge bg-${
                                        transaction.status.toLowerCase() === 'successful' ||
                                        transaction.status.toLowerCase() === 'delivered'
                                            ? 'success'
                                            : 'danger'
                                    }">
                                        ${transaction.status}
                                    </span></td>
                                    <td><a href="transactionview?hash=${transaction.transaction_id}"><button class="btn btn-primary btn-sm">View</button></a></td>
                                </tr>
                            `);
                            });
                            $('#airtime-payment-table').show(); // Show the table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').show(); // Show the table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display Data transactions
            $('#data-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-data-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#data-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                // Determine the network name based on the network ID
                                let networkName;
                                switch (transaction.network) {
                                    case '1':
                                        networkName = 'mtn';
                                        break;
                                    case '2':
                                        networkName = 'glo';
                                        break;
                                    case '6':
                                        networkName = '9mobile';
                                        break;
                                    case '4':
                                        networkName = 'airtel';
                                        break;
                                    default:
                                        networkName = transaction
                                            .network; // or you can set it to 'Unknown'
                                }

                                tbody.append(`
            <tr>
                <td>${transaction.transaction_id}</td>
                <td>${networkName}</td>
                <td>₦${transaction.amount}</td>
                <td>${transaction.tel}</td>
                <td>${transaction.plan}</td>
                <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                <td>
                    <span class="badge bg-${transaction.status.toLowerCase() === 'successful' || transaction.status.toLowerCase() === 'delivered' ? 'success' : 'danger'}">
                        ${transaction.status}
                    </span>
                </td>
                <td>
                    <a href="transactionview?hash=${transaction.transaction_id}">
                        <button class="btn btn-primary btn-sm">View</button>
                    </a>
                </td>
            </tr>
        `);
                            });

                            $('#airtime-payment-table').hide(); // Hide other tables
                            $('#data-payment-table').show(); // Show the data payment table
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        } else {
                            tbody.append(
                                '<tr><td colspan="8" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').show(); // Show the table
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display Electricity transactions
            $('#electricity-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-electricity-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#electricity-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                                <tr>
                                    <td>${transaction.transaction_id}</td>
                                    <td>${transaction.purchased_code}</td>
                                    <td>₦${transaction.amount}</td>
                                    <td>${transaction.tel}</td>
                                    <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                                    <td><span class="badge bg-${
                                        transaction.status.toLowerCase() === 'successful' ||
                                        transaction.status.toLowerCase() === 'delivered'
                                            ? 'success'
                                            : 'danger'
                                    }">
                                        ${transaction.status}
                                    </span></td>
                                    <td><a href="transactionview?hash=${transaction.transaction_id}"><button class="btn btn-primary btn-sm">View</button></a></td>
                                </tr>
                            `);
                            });
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').show(); // Show the table
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').show(); // Show the table
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display TV transactions
            $('#tv-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-tv-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#tv-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                                <tr>
                                    <td>${transaction.transaction_id}</td>
                                    <td>${transaction.network}</td>
                                    <td>₦${transaction.amount}</td>
                                    <td>${transaction.tel}</td>
                                    <td>${transaction.plan}</td>
                                    <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                                    <td><span class="badge bg-${
                                        transaction.status.toLowerCase() === 'successful' ||
                                        transaction.status.toLowerCase() === 'delivered'
                                            ? 'success'
                                            : 'danger'
                                    }">
                                        ${transaction.status}
                                    </span></td>
                                    <td><a href="transactionview?hash=${transaction.transaction_id}"><button class="btn btn-primary btn-sm">View</button></a></td>
                                </tr>
                            `);
                            });
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').show(); // Show the table
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        } else {
                            tbody.append(
                                '<tr><td colspan="8" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').show(); // Show the table
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display Education transactions
            $('#education-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-education-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#education-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                                <tr>
                                    <td>${transaction.transaction_id}</td>
                                    <td>${transaction.product_name}</td>
                                    <td>₦${transaction.amount}</td>
                                    <td>${transaction.tel}</td>
                                    <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                                    <td><span class="badge bg-${
                                        transaction.status.toLowerCase() === 'successful' ||
                                        transaction.status.toLowerCase() === 'delivered'
                                            ? 'success'
                                            : 'danger'
                                    }">
                                        ${transaction.status}
                                    </span></td>
                                   <td><a href="transactionview?hash=${transaction.transaction_id}"><button class="btn btn-primary btn-sm">View</button></a></td>
                                </tr>
                            `);
                            });
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').hide(); // Hide other table
                            $('#education-payment-table').show(); // Show the table
                            $('#insurance-payment-table').hide();
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').hide(); // Hide other table
                            $('#education-payment-table').show(); // Show the table
                            $('#insurance-payment-table').hide();
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display Insurance transactions
            $('#insurance-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-insurance-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#insurance-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                                <tr>
                                    <td>${transaction.transaction_id}</td>
                                    <td>${transaction.product_name}</td>
                                    <td>₦${transaction.amount}</td>
                                    <td>${transaction.tel}</td>
                                    <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                                    <td><span class="badge bg-${
                                        transaction.status.toLowerCase() === 'successful' ||
                                        transaction.status.toLowerCase() === 'delivered'
                                            ? 'success'
                                            : 'danger'
                                    }">
                                        ${transaction.status}
                                    </span></td>
                                    <td><button class="btn btn-primary btn-sm">View</button></td>
                                </tr>
                            `);
                            });
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').hide(); // Hide other table
                            $('#education-payment-table').hide(); // Hide other table
                            $('#insurance-payment-table').show(); // Show the table
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other table
                            $('#data-payment-table').hide(); // Hide other table
                            $('#electricity-payment-table').hide(); // Hide other table
                            $('#tv-payment-table').hide(); // Hide other table
                            $('#education-payment-table').hide(); // Hide other table
                            $('#insurance-payment-table').show(); // Show the table
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });

            // Fetch and display Fund transactions
            $('#fund-payment-badge').on('click', function() {
                $.ajax({
                    url: '{{ route('fetch-fund-transactions') }}',
                    type: 'GET',
                    success: function(data) {
                        var tbody = $('#fund-payment-tbody');
                        tbody.empty(); // Clear any existing data

                        if (data.length > 0) {
                            $.each(data, function(index, transaction) {
                                tbody.append(`
                        <tr>
                            <td>${transaction.transaction_id}</td>
                            <td>${transaction.identity}</td>
                            <td>₦${transaction.amount}</td>
                            <td>${transaction.tel}</td>
                            <td>${new Date(transaction.created_at).toLocaleDateString('en-GB')} ${new Date(transaction.created_at).toLocaleTimeString('en-GB')}</td>
                            <td><span class="badge bg-${
                                transaction.status.toLowerCase() === 'success' ||
                                transaction.status.toLowerCase() === 'delivered'
                                    ? 'success'
                                    : 'danger'
                            }">
                                ${transaction.status}
                            </span></td>
                           <td><a href="transactionview?hash=${transaction.transaction_id}"><button class="btn btn-primary btn-sm">View</button></a></td>
                        </tr>
                    `);
                            });
                            $('#airtime-payment-table').hide(); // Hide other tables
                            $('#data-payment-table').hide();
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                            $('#fund-payment-table').show(); // Show the fund table
                        } else {
                            tbody.append(
                                '<tr><td colspan="7" class="text-center">No transactions found.</td></tr>'
                            );
                            $('#airtime-payment-table').hide(); // Hide other tables
                            $('#data-payment-table').hide();
                            $('#electricity-payment-table').hide();
                            $('#tv-payment-table').hide();
                            $('#education-payment-table').hide();
                            $('#insurance-payment-table').hide();
                            $('#fund-payment-table').show(); // Show the fund table
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('Failed to fetch transactions.');
                    }
                });
            });
        });
    </script>
@endsection
