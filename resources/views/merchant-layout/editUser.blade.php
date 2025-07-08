@extends('merchant-layout.layouts.app')

@section('title', 'Edit Merchant Profile')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
 <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0" style="color: #FF6600 !important;">Profile Update</h4>
                            <div class="page-title-right">
                                {!!Helper::generateBreadCrumbs( 'Profile Update')!!}
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
                                <form action="{{ route('merchant.update.profile', $merchant->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ old('name', $merchant->name) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tel" class="form-label">Phone Number</label>
                                        <input type="tel" class="form-control" id="tel" name="tel"
                                            value="{{ old('tel', $merchant->tel) }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <textarea class="form-control" id="address" name="address"
                                            required>{{ old('address', $merchant->address) }}</textarea>
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

                                    <button type="submit" class="btn btn-primary">Update Merchant</button>
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
