@extends('merchant-layout.layouts.app')

@section('title', 'Credit user account')

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
                                    <div class="h6">Transaction Flow</div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>

                                                    <th>Username</th>

                                                    <th>Account Balance</th>

                                                    <th>Role</th>

                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>

                                                        <td>{{ $user->username }}</td>

                                                        <td>{{ '₦' . number_format($user->account_balance, 2) }}</td>

                                                        <td>
                                                            @if ($user->role == 0)
                                                                <p class="btn-primary text-center">Admin</p>
                                                            @elseif ($user->role == 1)
                                                                <p class="btn-secondary text-center">Sub Admin</p>
                                                            @else
                                                                <p class="btn-secondary text-center">User</p>
                                                            @endif
                                                        </td>


                                                        <td>
                                                            @if ($user->cal == 0)
                                                                Not active
                                                            @else
                                                                Active
                                                            @endif
                                                        </td>
                                                        <td>

                                                            <a href="{{ route('merchant.add.fund', $user->id) }}"><button
                                                                    class="btn btn-primary">Add Fund</button></a>


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

                <div class="container main-tags">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card moni-card br-2">
                                    <div class="h6">Manual Funding Approval</div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>

                                                    <th>Username</th>

                                                    <th>Tel</th>

                                                    <th>Transaction ID</th>

                                                    <th>Amount</th>


                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($fundAccount as $fund)
                                                    <tr>
                                                        <td>{{ $i++ }}</td>

                                                        <td>{{ $fund->username }}</td>
                                                        <td>{{ $fund->tel }}</td>
                                                        <td>{{ $fund->reference }}</td>

                                                        <td>{{ '₦' . number_format($fund->amount, 2) }}</td>





                                                        <td>{{ $fund->status }}</td>
                                                        <td>

                                                            <a href="{{ route('merchant.approve.fund', $fund->id) }}"><button
                                                                    class="btn btn-primary">Approve Fund</button></a>
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