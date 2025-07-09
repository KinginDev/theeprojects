@extends('merchant-layout.layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4>Create New Sub-Merchant</h4>
                                <a href="{{ route('merchant.manage-merchants') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left"></i> Back to List
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-info">
                                    <p>Creating sub-merchant account
                                </div>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('merchant.store-sub-merchant') }}"
                                    method="POST">
                                    @csrf

                                    <div class="form-group row my-3">
                                        <label class="col-sm-3 col-form-label">Merchant Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}" required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">This will be used for the sub-merchant's
                                                business
                                                name</small>
                                        </div>
                                    </div>
                                    <div class="form-group row my-3">
                                        <label class="col-sm-3 col-form-label">Merchant Email</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">This will be used for the sub-merchant's
                                                business
                                                email</small>
                                        </div>
                                    </div>

                                    <div class="form-group row my-3">
                                        <label class="col-sm-3 col-form-label">Phone Number</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="phone"
                                                class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row my-3">
                                        <label class="col-sm-3 col-form-label">Role</label>
                                        <div class="col-sm-9">
                                            <select name="role_id" id="role"
                                                class="form-control @error('role_id') is-invalid @enderror" required>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                                <option value="custom">Custom Permissions</option>
                                            </select>
                                            @error('role_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div id="custom-permissions-section" class="form-group row my-3 d-none">
                                        <label
                                            class="col-sm-3 col-form-label @error('custom_permissions') is-invalid

                                        @enderror">Custom
                                            Permissions</label>
                                        <div class="col-sm-9">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="manage_users"
                                                    class="custom-control-input" id="perm_manage_users">
                                                <label class="custom-control-label" for="perm_manage_users">Manage
                                                    Users</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="manage_merchants"
                                                    class="custom-control-input" id="perm_manage_merchants">
                                                <label class="custom-control-label" for="perm_manage_merchants">Manage
                                                    Sub-Merchants</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="manage_roles"
                                                    class="custom-control-input" id="perm_manage_roles">
                                                <label class="custom-control-label" for="perm_manage_roles">Manage
                                                    Roles</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="view_transactions"
                                                    class="custom-control-input" id="perm_view_transactions">
                                                <label class="custom-control-label" for="perm_view_transactions">View
                                                    Transactions</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="fund_users"
                                                    class="custom-control-input" id="perm_fund_users">
                                                <label class="custom-control-label" for="perm_fund_users">Fund User
                                                    Accounts</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="view_reports"
                                                    class="custom-control-input" id="perm_view_reports">
                                                <label class="custom-control-label" for="perm_view_reports">View
                                                    Reports</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]"
                                                    value="manage_settings" class="custom-control-input"
                                                    id="perm_manage_settings">
                                                <label class="custom-control-label" for="perm_manage_settings">Manage
                                                    Settings</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]"
                                                    value="manage_services" class="custom-control-input"
                                                    id="perm_manage_services">
                                                <label class="custom-control-label" for="perm_manage_services">Manage
                                                    Services</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="custom_permissions[]" value="view_dashboard"
                                                    class="custom-control-input" id="perm_view_dashboard" checked
                                                    disabled>
                                                <label class="custom-control-label" for="perm_view_dashboard">View
                                                    Dashboard
                                                    (Always enabled)</label>
                                                <input type="hidden" name="custom_permissions[]" value="view_dashboard">
                                            </div>
                                        </div>
                                        @error('custom_permissions')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="form-group row my-3">
                                        <div class="col-sm-9 offset-sm-3">
                                            <button type="submit" class="btn btn-primary">Create Sub-Merchant</button>
                                            <a href="{{ route('merchant.manage-merchants') }}"
                                                class="btn btn-secondary ml-2">Cancel</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @push('after_scripts')
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const roleSelect = document.getElementById('role');
                    const customPermissionsSection = document.getElementById('custom-permissions-section');

                    roleSelect.addEventListener('change', function() {
                        if (this.value === 'custom') {
                            customPermissionsSection.classList.remove('d-none');
                        } else {
                            customPermissionsSection.classList.add('d-none');
                        }
                    });
                });
            </script>
        @endpush
    @endsection
