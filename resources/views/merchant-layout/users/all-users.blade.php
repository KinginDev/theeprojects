@extends('merchant-layout.layouts.app')

@section('title', 'Manage Merchant Account')

@section('content')
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.bootstrap5.min.css" rel="stylesheet">

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Manage Users</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ Str::title(basename(parse_url(url()->previous(), PHP_URL_PATH))) }}</a></li>
                                    <li class="breadcrumb-item active">Manage Users</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="row mb-4">
                    <!-- Total Users Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 border-left-primary shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase">
                                        Total Users
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-soft-primary">
                                        <i class="ri-team-line font-size-24 avatar-title text-primary"></i>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($totalUsers) }}</div>
                                <div class="text-sm text-muted mt-2">Registered Users</div>
                            </div>
                        </div>
                    </div>

                    <!-- Active Users Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 border-left-success shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-xs font-weight-bold text-success text-uppercase">
                                        Active Users
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-soft-success">
                                        <i class="ri-user-follow-line font-size-24 avatar-title text-success"></i>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($activeUsers) }}</div>
                                <div class="text-sm text-success mt-2">
                                    <i class="ri-arrow-up-line"></i> Active Accounts
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Balance Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 border-left-info shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-xs font-weight-bold text-info text-uppercase">
                                        Total Balance
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-soft-info">
                                        <i class="ri-wallet-3-line font-size-24 avatar-title text-info"></i>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold">₦{{ number_format($totalBalance, 2) }}</div>
                                <div class="text-sm text-info mt-2">All Users Combined</div>
                            </div>
                        </div>
                    </div>

                    <!-- New Users Card -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card h-100 border-left-warning shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase">
                                        New Users
                                    </div>
                                    <div class="avatar-sm rounded-circle bg-soft-warning">
                                        <i class="ri-user-add-line font-size-24 avatar-title text-warning"></i>
                                    </div>
                                </div>
                                <div class="h5 mb-0 font-weight-bold">{{ number_format($newUsersThisMonth) }}</div>
                                <div class="text-sm text-warning mt-2">This Month</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Users Table Card -->
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h5 class="mb-0">All Users</h5>
                                <a href="{{ route('merchant.create.user', Auth::guard('merchant')->user()->id) }}"
                                   class="btn btn-primary btn-sm">
                                    <i class="ri-user-add-line align-middle me-1"></i>
                                    Add New User
                                </a>
                            </div>
                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible fade show">
                                        {{ session('success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-centered table-hover dt-responsive nowrap" id="users-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User</th>
                                                <th>Contact</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                                <th>Referrals</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm me-3">
                                                                <div class="avatar-title bg-soft-primary rounded-circle text-primary font-size-18">
                                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <h5 class="font-size-14 mb-1">{{ $user->name }}</h5>
                                                                <p class="text-muted mb-0">{{ $user->username }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="mb-1"><i class="ri-mail-line me-1"></i>{{ $user->email }}</p>
                                                        <p class="mb-0"><i class="ri-phone-line me-1"></i>{{ $user->tel }}</p>
                                                    </td>
                                                    <td>
                                                        <h5 class="font-size-14 mb-1">₦{{ number_format($user->wallet?->balance, 2) }}</h5>
                                                    </td>
                                                    <td>
                                                        @if ($user->cal == 1)
                                                            <span class="badge bg-success-subtle text-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <p class="mb-1">Referred by: {{ $user->refferal_user ?: 'None' }}</p>
                                                        <p class="mb-0">Bonus: ₦{{ number_format($user->refferal_bonus, 2) }}</p>
                                                    </td>
                                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                                <i class="ri-more-fill align-middle"></i>
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('merchant.edit.user', $user->id) }}">
                                                                        <i class="ri-edit-2-line align-middle me-1"></i> Edit
                                                                    </a>
                                                                </li>
                                                                @if ($user->cal == 0)
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('merchant.activate', $user->id) }}">
                                                                            <i class="ri-checkbox-circle-line align-middle me-1"></i> Activate
                                                                        </a>
                                                                    </li>
                                                                @else
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('merchant.deactivate', $user->id) }}">
                                                                            <i class="ri-close-circle-line align-middle me-1"></i> Deactivate
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <a class="dropdown-item" href="{{ route('merchant.fund.user', $user->id) }}">
                                                                        <i class="ri-money-dollar-circle-line align-middle me-1"></i> Fund Account
                                                                    </a>
                                                                </li>
                                                                <li><hr class="dropdown-divider"></li>
                                                                <li>
                                                                    <a class="dropdown-item text-danger" href="{{ route('merchant.delete', $user->id) }}"
                                                                       onclick="return confirm('Are you sure you want to delete this user?')">
                                                                        <i class="ri-delete-bin-line align-middle me-1"></i> Delete
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions Card -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header py-3">
                                <h5 class="mb-0">Recent Transactions</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>User</th>
                                                <th>Flow</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentTransactions as $transaction)
                                                <tr>
                                                    <td>{{ $transaction->owner->name }}</td>
                                                    <td>
                                                        @if($transaction->kind == 'credit')
                                                            <span class="badge bg-success-subtle text-success">Credit</span>
                                                        @else
                                                            <span class="badge bg-danger-subtle text-danger">Debit</span>
                                                        @endif
                                                    </td>
                                                    <td>{{Str::title($transaction->type)}}</td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>{{ $transaction->created_at->diffAsCarbonInterval() }}</td>
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
    </div>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#users-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'collection',
                        text: 'Export',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print'
                        ]
                    }
                ],
                pageLength: 10,
                order: [[5, 'desc']], // Sort by created date by default
                responsive: true
            });
        });
    </script>

    <style>
        .border-left-primary { border-left: 4px solid #4e73df !important; }
        .border-left-success { border-left: 4px solid #1cc88a !important; }
        .border-left-info { border-left: 4px solid #36b9cc !important; }
        .border-left-warning { border-left: 4px solid #f6c23e !important; }
        .bg-soft-primary { background-color: rgba(78, 115, 223, 0.1) !important; }
        .bg-soft-success { background-color: rgba(28, 200, 138, 0.1) !important; }
        .bg-soft-info { background-color: rgba(54, 185, 204, 0.1) !important; }
        .bg-soft-warning { background-color: rgba(246, 194, 62, 0.1) !important; }
        .avatar-sm {
            height: 3rem;
            width: 3rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .font-size-14 { font-size: 14px !important; }
        .font-size-18 { font-size: 18px !important; }
        .font-size-24 { font-size: 24px !important; }
        .dropdown-item { cursor: pointer; }
        .table td { vertical-align: middle; }
    </style>
@endsection
