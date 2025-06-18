@extends('users-layout.dashboard.layouts.app')

@section('title', 'Setting')

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
                @if ($errors->any())
                <div class="col-12">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger">
                            {{ $error }}
                        </div>
                    @endforeach
                </div>
            @endif

            @if (session('success'))
                <div class="col-12">
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                </div>
            @endif
                <!-- Edit User Form -->
                <div class="row">
                    <div class="col-lg-8 mx-auto">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('users.update.profile', $userData->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $userData->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tel" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="tel" name="tel"
                                            value="{{ old('tel', $userData->tel) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address" required>{{ old('address', $userData->address) }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Old Password</label>
                                        <input type="password" class="form-control" id="oldpassword" name="oldpassword">
                                        <small class="form-text text-muted">Leave blank if you don't want to change the
                                            password.</small>
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
                                        <label for="created_at" class="form-label">Created At</label>
                                        <input type="datetime-local" class="form-control" id="created_at" name="created_at"
                                            value="{{ $userData->created_at->format('Y-m-d\TH:i') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="updated_at" class="form-label">Updated At</label>
                                        <input type="datetime-local" class="form-control" id="updated_at" name="updated_at"
                                            value="{{ $userData->updated_at->format('Y-m-d\TH:i') }}" readonly>
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
