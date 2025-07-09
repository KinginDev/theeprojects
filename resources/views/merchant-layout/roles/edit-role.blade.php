@extends('merchant-layout.layouts.app')

@section('content')
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="section-title">Edit Role: {{ $role->name }}</h2>
                    <a href="{{ route('merchant.manage-roles') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Roles
                    </a>
                </div>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('merchant.update-role', $role->id) }}" method="POST">
                    @csrf

                    <div class="card">
                        <div class="card-header">
                            <h4>Role Details</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group my-3">
                                <label for="name">Role Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $role->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3 row">
                                <label for="description" class="col-sm-3 col-form-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                                        rows="3">{{ old('description', $role->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group my-3">
                                <label for="permissions">Permissions</label>
                                <select name="permissions[]" id="permissions"
                                    class="form-control select2 @error('permissions') is-invalid @enderror" multiple>
                                    @foreach ($availablePermissions as $permission)
                                        <option value="{{ $permission }}"
                                            {{ in_array($permission, old('permissions', $role->permissions)) ? 'selected' : '' }}>
                                            {{ str_replace('_', ' ', ucfirst($permission)) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('permissions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group my-3">
                                <label for="is_default">Default Role</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_default" name="is_default"
                                        value="1" {{ $role->is_default ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_default">Make this the default role</label>
                                </div>
                                @error('is_default')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Update Role</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
