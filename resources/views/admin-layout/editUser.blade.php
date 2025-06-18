@extends('admin-layout.layouts.app')

@section('title', 'Dashboard Page')

@section('content')
@php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Edit User</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Edit User</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Edit User Form -->
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('adminupdates.profile', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $user->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tel" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="tel" name="tel"
                                            value="{{ old('tel', $user->tel) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" required>{{ old('address', $user->address) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the
                                            password.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the
                                            password.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label for="upgrade" class="form-label">Upgrade User</label>
                                        <select name="upgrade" id="upgrade" class="form-control">
                                            <option selected disabled>Select Upgrade</option>
                                            <option value="1" {{ old('upgrade', $user->smart_earners == 1 ? 1 : null) == 1 ? 'selected' : '' }}>Smart Earners</option>
                                            <option value="2" {{ old('upgrade', $user->topuser_earners == 1 ? 2 : null) == 2 ? 'selected' : '' }}>Top-User Earners</option>
                                            <option value="3" {{ old('upgrade', $user->api_earners == 1 ? 3 : null) == 3 ? 'selected' : '' }}>Api Earners</option>
                                        </select>
                                    </div>
                                    
                                    

                                    <div class="mb-3">
                                        <label for="created_at" class="form-label">Created At</label>
                                        <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                                            value="{{ $user->created_at->format('Y-m-d\TH:i') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="updated_at" class="form-label">Updated At</label>
                                        <input type="datetime-local" class="form-control" id="updated_at" name="updated_at"
                                            value="{{ $user->updated_at->format('Y-m-d\TH:i') }}" readonly>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Edit User Form -->

            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-md-12 text-center">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © {{ $configuration->site_name }}.
                    </div>
                </div>
            </div>
        </footer>

    </div>
@endsection
