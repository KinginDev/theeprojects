@extends('admin-layout.layouts.app')

@section('title', 'Dashboard Page')

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
                            <h4 class="mb-sm-0">Empty page</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Starter page</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card moni-card br-2">
                                    <div class="h6">Your wallet summary.</div>

                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Username</th>
                                                    <th>Telephone</th>
                                                    <th>Email</th>
                                                    <th>Account Balance</th>
                                                    <th>Address</th>
                                                    <th>Referral User</th>
                                                    <th>Referral</th>
                                                    <th>Referral Bonus</th>
                                                    <th>Role</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->username }}</td>
                                                        <td>{{ $user->tel }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ '₦'.number_format($user->account_balance, 2) }}</td>
                                                        <td>{{ $user->address }}</td>
                                                        <td>{{ $user->refferal_user }}</td>
                                                        <td>{{ $user->refferal }}</td>
                                                        <td>{{ $user->refferal_bonus }}</td>
                                                        <td>
                                                            @if ($user->role == 0)
                                                                <p class="btn-primary text-center">Admin</p>
                                                            @elseif ($user->role == 1)
                                                            <p class="btn-secondary text-center">Sub Admin</p>
                                                            @else
                                                            <p class="btn-secondary text-center">User</p>
                                                            @endif
                                                        </td>

                                                        <td>{{ $user->created_at }}</td>
                                                        <td>{{ $user->updated_at }}</td>
                                                        <td>
                                                            @if ($user->cal == 0)
                                                                Not active
                                                            @else
                                                                Active
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('manageSubAdmin', $user->id) }}"><button class="btn btn-primary">Manage-))</button></a>

                                                            @if ($user->cal == 0 && $user->role != 0)
                                                            <a href="{{ route('activate', $user->id) }}"><button class="btn btn-secondary">Activate</button></a>
                                                            <a href="{{ route('delete', $user->id) }}"><button class="btn btn-danger">Delete</button></a>
                                                            @elseif ($user->cal == 1 && $user->role != 0)
                                                            <a href="{{ route('deactivate', $user->id) }}"><button class="btn btn-warning">Deactivate</button></a>
                                                            <a href="{{ route('delete', $user->id) }}"><button class="btn btn-danger">Delete</button></a>
                                                            @endif

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody><!-- end tbody -->
                                        </table> <!-- end table -->
                                    </div>
                                </div>
                            </div>
                        </div>
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
