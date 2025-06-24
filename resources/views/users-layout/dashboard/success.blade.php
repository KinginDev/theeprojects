@extends('users-layout.dashboard.layouts.app')

@section('title', 'Transaction Success')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Transaction View</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Transaction View</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="h6">
                                Your Transaction Details are as Follows:
                            </div> <br>

                            <div class="card moni-card">
                                <div class="tran-items">
                                    <div class="d-flex tran-item">
                                        <p class="text-success">Tokens</p>
                                        <p class="d-flex text-success"><span class="ms-2">{{ implode(', ', $tokens) }}</span></p>
                                    </div>
                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Phone number</p>
                                        <p class="d-flex"><span class="ms-2">{{ $phoneNumber }}</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Amount</p>
                                        <p class="d-flex"><span class="ms-2">₦{{ $amount }}</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Transaction ID</p>
                                        <p class="d-flex"><span class="ms-2">{{ $transactionId }}</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Code</p>
                                        <p class="d-flex"><span class="ms-2">{{ $code }}</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Purchased Code</p>
                                        <p class="d-flex"><span class="ms-2">{{ $purchased_code }}</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Response Description</p>
                                        <p class="d-flex"><span class="ms-2">{{ $response_description }}</span></p>
                                    </div>



                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Transaction Date</p>
                                        <p class="d-flex"><span class="ms-2">{{ $transaction_date }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container to hold the main page elements ends here-->
            </div>
            <!-- End Page-content -->
        </div>
    @endsection
