@extends('merchant-layout.layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Manage Roles</h2>
                    <div>
                        <a href="{{ route('merchant.create-role-form') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Role
                        </a>
                        <a href="{{ route('merchant.manage-merchants') }}" class="btn btn-secondary ml-2">
                            <i class="fas fa-arrow-left"></i> Back to Sub-Merchants
                        </a>
                    </div>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Available Roles</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Permissions</th>
                                                <th>Default</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($roles as $role)
                                                <tr>
                                                    <td>{{ $role->name }}</td>
                                                    <td>{{ $role->description }}</td>
                                                    <td>
                                                        @foreach ($role->permissions as $permission)
                                                            <span
                                                                class="badge badge-info">{{ str_replace('_', ' ', ucfirst($permission)) }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @if ($role->is_default)
                                                            <span class="badge badge-success">Default</span>
                                                        @else
                                                            <span class="badge badge-secondary">Custom</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('merchant.edit-role', $role->id) }}"
                                                            class="btn btn-sm btn-info">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        @if (!$role->is_default)
                                                            <form action="{{ route('merchant.delete-role', $role->id) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this role?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">No roles found</td>
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
