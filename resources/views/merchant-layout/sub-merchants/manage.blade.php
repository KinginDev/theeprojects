@extends('merchant-layout.layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Manage Sub-Merchants</h2>
                    <a href="{{ route('merchant.manage-roles') }}" class="btn btn-primary">
                        <i class="fas fa-user-tag"></i> Manage Roles
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <!-- Existing Sub-Merchants -->
                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-header justify-content-between d-flex align-items-center">
                                <h4 class="mb-0">Existing Sub-Merchants</h4>
                                <a href="{{ route('merchant.create-sub-merchant-form') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus"></i>
                                    Create New Sub-Merchant
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Domain</th>
                                                <th>Role</th>
                                                <th>Status</th>
                                                <th>Created</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($subMerchants as $subMerchant)
                                                <tr>
                                                    <td>{{ $subMerchant->name }}</td>
                                                    <td>{{ $subMerchant->email }}</td>
                                                    <td>{{ $subMerchant->domain }}</td>
                                                    <td><span
                                                            class="badge badge-info">{{ ucfirst($subMerchant->role) }}</span>
                                                    </td>
                                                    <td>
                                                        @if ($subMerchant->is_active)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $subMerchant->created_at->format('M d, Y') }}</td>
                                                    <td>
                                                        <a href="{{ route('merchant.edit-sub-merchant', $subMerchant->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        <a href="{{ route('merchant.toggle-sub-merchant-status', $subMerchant->id) }}"
                                                            class="btn btn-sm {{ $subMerchant->is_active ? 'btn-warning' : 'btn-success' }}"
                                                            onclick="return confirm('Are you sure you want to {{ $subMerchant->is_active ? 'deactivate' : 'activate' }} this sub-merchant?')">
                                                            <i
                                                                class="fas fa-{{ $subMerchant->is_active ? 'times' : 'check' }}"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="7" class="text-center">No sub-merchants found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    @endsection
