@extends('merchant-layout.layouts.app')

@section('title', 'Admin Notifications')

@section('content')

    <!-- ============================================================== -->
    <!-- Start Right Content Here -->
    <!-- ============================================================== -->
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <!-- Start Page Title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0" style="color: #FF6600 !important;">Merchant Notifications</h4>
                            <div class="page-title-right">
                                {!!Helper::generateBreadCrumbs( 'Notifications')!!}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Page Title -->

                <!-- Notification List -->
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <!-- Notification Card -->
                        <div class="card">
                            <div class="card-header text-white" style="background-color: #FF6600 !important;">
                                <h5 class="card-title mb-0">Notifications List</h5>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    @foreach ($notifications as $notification)
                                        <a href="#"
                                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-bell-fill text-warning me-3"></i>
                                                <!-- Adjust icon based on type -->
                                                <div>
                                                    <h6 class="mb-1" style="text-transform: capitalize;">
                                                        {{ $notification->username }}</h6>
                                                    <p class="mb-0 text-muted" style="text-transform: capitalize;">
                                                        {{ $notification->message }}</p>
                                                </div>
                                            </div>
                                            <span
                                                class="badge bg-primary rounded-pill">{{ $notification->created_at->diffForHumans() }}</span>
                                        </a>
                                    @endforeach
                                    <!-- No Notifications Message -->
                                    @if($notifications->isEmpty())
                                        <p class="text-center text-muted">No Notifications to Display.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div> <!-- Container-fluid -->
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
    <!-- End Main Content -->
@endsection
