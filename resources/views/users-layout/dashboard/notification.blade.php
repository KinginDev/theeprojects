@extends('users-layout.dashboard.layouts.app')

@section('title', 'User Notifications')

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
                        <h4 class="mb-sm-0">Notifications</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                <li class="breadcrumb-item active">Notifications</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <!-- Notifications list -->
            <div class="row">
                <div class="col-12">
                    @if($notifications->isEmpty())
                        <div class="alert alert-info">No notifications found.</div>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <ul class="list-group">
                                    @foreach($notifications as $notification)
                                        <li class="list-group-item">
                                            <h5 class="card-title">{{ ucfirst($notification->msghead) }}</h5>

                                            <p>{{ ucfirst($notification->msgbody) }}</p>
                                            <small class="text-muted">{{ $notification->created_at->format('F j, Y, g:i a') }}</small>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <!-- End notifications list -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12 col-md-12 text-center">
                    <script>document.write(new Date().getFullYear())</script> © {{ $configuration->site_name }}.
                </div>
            </div>
        </div>
    </footer>

</div>
@endsection
