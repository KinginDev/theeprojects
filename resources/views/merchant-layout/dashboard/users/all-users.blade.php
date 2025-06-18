
@extends('merchant-layout.layouts.app')

@section('title', 'Manage Merchant Account')

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
                            <h4 class="mb-sm-0">Manage Users</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ url()->previous() }}">{{ Str::title(basename(parse_url(url()->previous(), PHP_URL_PATH))) }}</a></li>
                                    <li class="breadcrumb-item active">Manage Users</li>
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
                                    <div class="h6">Transaction Flow</div>
                                    @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                @if(session('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif


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


                                                        <td>{{ $user->created_at }}</td>
                                                        <td>{{ $user->updated_at }}</td>
                                                        <td>
                                                            @if ($user->cal == 0)
                                                               <span class="">Not Active</span>
                                                            @else
                                                                <span class=""></span>Active</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('edit.user', $user->id) }}"><button class="btn btn-primary">Edit</button></a>

                                                            @if ($user->cal == 0 )
                                                            <a href="{{ route('activate', $user->id) }}"><button class="btn btn-secondary">Activate</button></a>
                                                            <a href="{{ route('delete', $user->id) }}"><button class="btn btn-danger">Delete</button></a>
                                                            @elseif ($user->cal == 1 )
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
