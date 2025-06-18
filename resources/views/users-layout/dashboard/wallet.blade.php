@extends('users-layout.dashboard.layouts.app')

@section('title', 'Wallet Summary Page')

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
                                    <div class="h6">Your wallet summary.</div>


                                    <div class="table-responsive">
                                        <table class="table table-centered mb-0 align-middle table-hover table-nowrap"
                                            id="example">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Reference</th>

                                                    <th>Amount</th>

                                                    <th>Product</th>

                                                    <th>Previous Balance</th>

                                                    <th>New Balance</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allTransactions as $transaction)
                                                    <tr>
                                                        <td>{{ $transaction->transaction_id }}</td>
                                                        <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                        <td>{{ $transaction->identity }}</td>
                                                        <td>₦{{ $transaction->prev_bal }}</td>
                                                        <td>₦{{ $transaction->current_bal }}</td>
                                                        <td>{{ $transaction->created_at }}</td>
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
