@extends('merchant-layout.layouts.app')

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
                            <h4 class="mb-sm-0">wallet summary</h4>

                            <div class="page-title-right">
                               {!! Helper::generateBreadCrumbs( 'Wallet Summary') !!}

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
                                            id="transactionsTable">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Reference</th>

                                                    <th>Network</th>
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
                                                        <td><b>{{ strtoupper($transaction->owner->name) ?? 'N/A'}}</b></td>
                                                        <td>{{ $transaction->reference ?? 'N/A' }}</td>
                                                        <td>{{ $transaction->network ?? 'N/A' }}</td>
                                                        <!-- Handle 'network' dynamically -->
                                                        <td>₦{{ number_format($transaction->amount, 2) ?? 'N/A' }}</td>
                                                        <td>{{ $transaction->identity ?? 'N/A'}}</td>
                                                        <td>₦{{ $transaction->prev_bal ?? 'N/A' }}</td>
                                                        <td>₦{{ $transaction->current_bal ?? 'N/A' }}</td>
                                                        <td>{{ $transaction->created_at ?? 'N/A'}}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

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
