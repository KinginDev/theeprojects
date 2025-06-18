@extends('admin-layout.layouts.app')

@section('title', 'Add Account Settings')

@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
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
                        <h4 class="mb-sm-0" style="color: #FF6600 !important;">Add Account Settings</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                <li class="breadcrumb-item active">Add Account Settings</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Flash Messages -->
            <div class="container main-tags">
                <div class="row">
                    <div class="col-lg-8 offset-lg-2">
                        <!-- Success Message -->
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Error Message -->
                        @if(session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                <h5 class="card-title mb-0">Add Account Settings</h5>
                            </div>
                            <div class="card-body">
                                <!-- Update the action attribute to point to your route -->
                                <form action="{{ route('admin.addnewAccount')}}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                           <select name="user_role" id="user_role" class="form-control" required>
                                            <option value="" selected disabled>Select Account Type</option>
                                            <option value="2">User</option>
                                            <option value="1">Merchant/Sub Admin</option>
                                           </select>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="text" required placeholder="Full Name" id="fname" name="fname" value="{{ old('fname') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="text" required placeholder="Username" id="username" name="username" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="email" required placeholder="Email" id="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input id="user" class="form-control" type="text" required placeholder="Phone number" name="tel" value="{{ old('tel') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="text" required placeholder="Address" id="address" name="address" value="{{ old('address') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="text" placeholder="Referral username [optional]" id="referral" name="referral" value="{{ old('referral') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="password" required placeholder="Password" id="pass" name="password">
                                        </div>
                                    </div>
                                    <div class="form-group mb-3 row">
                                        <div class="col-12">
                                            <input class="form-control" type="password" required placeholder="Confirm password" id="cpassword" name="cpassword">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn" style="background-color: #FF6600 !important; color: white;">Create Account</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
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
<!-- end main content-->
@endsection
