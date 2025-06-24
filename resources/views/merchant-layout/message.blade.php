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

                {{-- <div class="container main-tags">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card moni-card br-2">
                                    <div class="d-flex justify-content-between">
                                        <div class="h3">AIRTIME TOPUP PERCENTAGE</div>
                                        <a href="{{ route('add.charge') }}"><button class="btn btn-primary">ADD TOPUP PERCENTAGE +</button></a>
                                      </div>


                                    <div class="table-responsive">
                                        <table
                                            class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>NETWORK</th>
                                                    <th>PERCENT</th>
                                                    <th>ID</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <div class="transaction-icon">
                                                            <div class="icon-hold">
                                                                <i class="bi bi-wallet-fill"></i>
                                                            </div>
                                                            <h6 class="mb-0">Wallet</h6>
                                                        </div>

                                                    </td>
                                                    <td><span>₦</span><span>3,000.00</span></td>

                                                    <td class="status-pending"><span>Pending</span></td>
                                                </tr>

                                            </tbody><!-- end tbody -->
                                        </table> <!-- end table -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <!-- Container to hold the main page elements ends here-->

                <div class="container main-tags">
                    <div class="row">
                        <div class="col-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card moni-card br-2">
                                    <div class="h3">DATA TOPUP TRANSACTIONS</div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>FULLNAME</th>
                                                    <th>USERNAME</th>

                                                    <th>ACTION</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($message_user as $transaction)
                                                    <tr>
                                                        <td>

                                                            <h6 class="mb-0"><?php echo $i++; ?></h6>
                                    </div>

                                    </td>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->username }}</td>



                                    <td class="status-pending"><a href="message/user/{{ $transaction->id }}"><button class="btn btn-primary">Message User</button></a></td>
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
