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
                                    <div class="d-flex justify-content-between">
                                        <div class="h3">AIRTIME TOPUP PERCENTAGE</div>

                                    </div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>SERVICES</th>
                                                    <th>SMART EANERS PERCENTAGE</th>
                                                    <th>TOP USERS PERCENTAGE</th>
                                                    <th>API PERCENTAGE</th>
                                                    <th>CREATED DATE</th>
                                                    <th>UPDATED DATE</th>
                                                    <th>ACTION</th>

                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                @foreach ($airtimes as $airtime)
                                                    <tr>
                                                        <td>
                                                            <div class="transaction-icon">
                                                                <div class="icon-hold">
                                                                    @if ($airtime->service == 'MTN_Airtime_VTU')
                                                                        <img src="/assets/images/brands/Mtn.png"
                                                                            width="35" alt="MTN Logo">
                                                                    @elseif ($airtime->service == 'Airtel_Airtime_VTU')
                                                                        <img src="/assets/images/brands/Airtel.png"
                                                                            width="35" alt="Airtel Logo">
                                                                    @elseif ($airtime->service == 'GLO_Airtime_VTU')
                                                                        <img src="https://img.icons8.com/?size=100&id=d1bmMtlAQFUr&format=png&color=000000"
                                                                            width="35" alt="GLO Logo">
                                                                    @elseif ($airtime->service == '9mobile_Airtime_VTU')
                                                                        <img src="https://img.icons8.com/?size=100&id=e04b5onSXhqL&format=png&color=000000"
                                                                            width="35" alt="9mobile Logo">
                                                                    @endif

                                                                </div>
                                                                <h6 class="mb-0">{{ $airtime->service }}</h6>
                                                            </div>
                                                        </td>
                                                        <td><span></span><span>{{ $airtime->smart_earners_percent }}</span>
                                                        </td>
                                                        <td class="status-pending">
                                                            <span>{{ $airtime->topuser_earners_percent  }}</span>
                                                        </td>
                                                        <td class="status-pending">
                                                            <span>{{ $airtime->api_earners_percent }}</span>
                                                        </td>
                                                        <td class="status-pending">
                                                            <span>{{ $airtime->created_at}}</span>
                                                        </td>
                                                        <td class="status-pending">
                                                            <span>{{ $airtime->updated_at}}</span>
                                                        </td>
                                                        <td class="status-pending">
                                                            <a href="{{ route('add.charge', $airtime->id) }}">
                                                                <button class="btn btn-primary">TOP UP +</button>
                                                            </a>

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
                                    <div class="h3">AIRTIME TOPUP TRANSACTIONS</div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example2">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>USER</th>
                                                    <th>NETWORK</th>
                                                    <th>MOBILE NUMBER</th>
                                                    <th>AMOUNT</th>
                                                    <th>ID</th>
                                                    <th>IDENT</th>
                                                    <th>STATUS</th>
                                                    <th>CREATED DATE</th>
                                                </tr>
                                            </thead><!-- end thead -->
                                            <tbody>
                                                <?php $i = 1; ?>
                                                @foreach ($airtime_transaction as $transaction)
                                                    <tr>
                                                        <td>

                                                            <h6 class="mb-0"><?php echo $i++; ?></h6>
                                    </div>

                                    </td>
                                    <td>{{ $transaction->username }}</td>

                                    <td>{{ $transaction->network }}</td>
                                    <td>{{ $transaction->tel }}</td>
                                    <td>₦{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->reference }}</td>
                                    <td>{{ $transaction->identity }}</td>
                                    <td>{{ $transaction->status }}</td>




                                    <td class="status-pending">{{ $transaction->created_at }}</td>
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
