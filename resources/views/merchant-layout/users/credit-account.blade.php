@extends('merchant-layout.layouts.app')

@section('title', 'Credit User Accounts')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">User Credit Management</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Users</a></li>
                                    <li class="breadcrumb-item active">Credit Management</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Credit List -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">User Credit Management</h5>
                                    <div class="search-box">
                                        <div class="position-relative">
                                            <input type="text" class="form-control rounded bg-light border-0"
                                                id="userSearch" placeholder="Search users...">
                                            <i class="ri-search-line search-icon"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-hover dt-responsive nowrap" id="users-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Balance</th>
                                                <th scope="col">Role</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-xs me-2">
                                                                <span
                                                                    class="avatar-title bg-soft-primary text-primary rounded-circle">
                                                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                                                </span>
                                                            </div>
                                                            <span>{{ $user->username }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0">₦{{ number_format($user->account_balance, 2) }}</h6>
                                                    </td>
                                                    <td>
                                                        @if ($user->role == 0)
                                                            <span class="badge bg-primary">Admin</span>
                                                        @elseif ($user->role == 1)
                                                            <span class="badge bg-info">Sub Admin</span>
                                                        @else
                                                            <span class="badge bg-secondary">User</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($user->cal == 0)
                                                            <span class="badge bg-danger">Inactive</span>
                                                        @else
                                                            <span class="badge bg-success">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('merchant.add.fund', $user->id) }}"
                                                            class="btn btn-primary btn-sm">
                                                            <i class="ri-money-dollar-circle-line align-middle me-1"></i>Add
                                                            Fund
                                                        </a>
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

                <!-- Pending Approvals -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="card-title mb-0">Pending Fund Approvals</h5>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-hover dt-responsive nowrap"
                                        id="approvals-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Username</th>
                                                <th scope="col">Phone</th>
                                                <th scope="col">Reference</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($fundAccount as $fund)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $fund->username }}</td>
                                                    <td>{{ $fund->tel }}</td>
                                                    <td>
                                                        <code>{{ $fund->reference }}</code>
                                                    </td>
                                                    <td>
                                                        <h6 class="mb-0">₦{{ number_format($fund->amount, 2) }}</h6>
                                                    </td>
                                                    <td>
                                                        @if($fund->status == 'Pending')
                                                            <span class="badge bg-warning">{{ $fund->status }}</span>
                                                        @elseif($fund->status == 'Success')
                                                            <span class="badge bg-success">{{ $fund->status }}</span>
                                                        @else
                                                            <span class="badge bg-danger">{{ $fund->status }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('merchant.approve.fund', $fund->id) }}"
                                                            class="btn btn-success btn-sm">
                                                            <i class="ri-check-line align-middle me-1"></i>Approve
                                                        </a>
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
            </div>
        </div>
    </div>

    <!-- Custom styles for the search box -->
    <style>
        .search-box {
            max-width: 300px;
        }

        .search-box .form-control:focus {
            border-color: #556ee6;
            box-shadow: none;
        }

        .search-box .search-icon {
            position: absolute;
            right: 13px;
            top: 50%;
            transform: translateY(-50%);
            color: #74788d;
        }
    </style>

    @push('scripts')
        <script>
            $(document).ready(function () {
                // Initialize DataTables
                $('#users-table, #approvals-table').DataTable({
                    language: {
                        search: "",
                        searchPlaceholder: "Search..."
                    },
                    dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    buttons: ['copy', 'excel', 'pdf', 'print'],
                    order: [[0, 'asc']],
                    pageLength: 10,
                    responsive: true
                });
            });
        </script>
    @endpush
@endsection
