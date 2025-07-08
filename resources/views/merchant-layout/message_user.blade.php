@extends('merchant-layout.layouts.app')

@section('title', 'Send Message to User')

@section('content')

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
                            <h4 class="mb-sm-0" style="color: #FF6600 !important;">Send Message</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Send Message</li>
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
                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!-- Error Message -->
                            @if(session('error'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="card">
                                <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                    <h5 class="card-title mb-0">Send Message to User</h5>
                                </div>
                                <div class="card-body">
                                    <!-- Update the action attribute to point to your route -->
                                    <form action="{{ route('admin.sendMessage', ['id' => $user->id]) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                placeholder="Enter username" required value="{{ $user->username }}"
                                                readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="subject" class="form-label">Subject</label>
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                placeholder="Enter subject" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control" id="message" name="message" rows="4"
                                                placeholder="Type your message here" required></textarea>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn"
                                                style="background-color: #FF6600 !important; color: white;">Send
                                                Message</button>
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
