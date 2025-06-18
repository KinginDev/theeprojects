@extends('users-layout.dashboard.layouts.app')

@section('title', 'User Communication')

@section('content')
@php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">User Communication</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">User Communication</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <!-- Add this at the top of your Blade template -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="row">
                        <!-- User Message Form -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Send User Message</h5>
                                    <form action="{{ route('message.send') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                readonly value="{{ $userData->username }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Message</button>
                                    </form>
                                    <small class="form-text text-muted mt-2">Admin will reply within 24 hours.</small>
                                </div>
                            </div>
                        </div>
                        <!-- End User Message Form -->

                        <!-- User Email Form -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Send User Email</h5>
                                    <form action="{{ route('email.send') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                readonly value="{{ $userData->email }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email-message" class="form-label">Message</label>
                                            <textarea class="form-control" id="email-message" name="message" rows="4" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Send Email</button>
                                    </form>
                                    <small class="form-text text-muted mt-2">Admin will reply within 24 hours.</small>
                                </div>
                            </div>
                        </div>
                        <!-- End User Email Form -->
                    </div>
                </div>
                <!-- Container to hold the main page elements ends here-->

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
