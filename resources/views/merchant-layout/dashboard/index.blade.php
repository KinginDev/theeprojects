@extends('merchant-layout.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">VTU Merchant Dashboard</h1>
    <div class="row mb-4">
        <!-- Summary Cards -->
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-primary h-100">
                <div class="card-body">
                    <h5 class="card-title">Wallet Balance</h5>
                    <p class="card-text display-6">&#8358;25,000.00</p>
                    <a href="" class="btn btn-light btn-sm mt-2">Top Up</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-success h-100">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text display-6">8</p>
                    <a href="" class="btn btn-light btn-sm mt-2">Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-info h-100">
                <div class="card-body">
                    <h5 class="card-title">Products</h5>
                    <p class="card-text display-6">5</p>
                    <a href="" class="btn btn-light btn-sm mt-2">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-white bg-warning h-100">
                <div class="card-body">
                    <h5 class="card-title">Transactions</h5>
                    <p class="card-text display-6">120</p>
                    <a href="" class="btn btn-light btn-sm mt-2">View All</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Table -->
    <div class="card mb-4">
        <div class="card-header">
            Recent Transactions
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Product</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example rows -->
                    <tr>
                        <td>TXN-001</td>
                        <td>Jane Doe</td>
                        <td>Airtime</td>
                        <td><span class="badge bg-success">Successful</span></td>
                        <td>2024-06-01</td>
                        <td>&#8358;500.00</td>
                        <td><a href="#" class="btn btn-sm btn-outline-primary">Details</a></td>
                    </tr>
                    <tr>
                        <td>TXN-002</td>
                        <td>John Smith</td>
                        <td>Data Bundle</td>
                        <td><span class="badge bg-warning text-dark">Pending</span></td>
                        <td>2024-06-02</td>
                        <td>&#8358;1,000.00</td>
                        <td><a href="#" class="btn btn-sm btn-outline-primary">Details</a></td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-md-3 mb-3">
            <a href="{{ route('merchant.users.create', Auth::guard('merchant')->user()->id) }}" class="btn btn-lg btn-block btn-outline-primary w-100">Add User</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="" class="btn btn-lg btn-block btn-outline-success w-100">Add Product</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="" class="btn btn-lg btn-block btn-outline-info w-100">Transfer Funds</a>
        </div>
        <div class="col-md-3 mb-3">
            <a href="" class="btn btn-lg btn-block btn-outline-secondary w-100">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
