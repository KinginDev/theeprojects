@extends('users-layout.dashboard.layouts.app')

@section('title', 'Dashboard Page')

@section('content')
    @if (isset($hideModal) && $hideModal)
        <script>
            $(document).ready(function() {
                $('.bs-example-modal-center1').modal('hide');
            });
        </script>
    @elseif(isset($showModal) && $showModal)
        <script>
            $(document).ready(function() {
                $('.bs-example-modal-center1').modal('show');
            });
        </script>
    @endif
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
                            <h3 class="mb-sm-0">Hey {{ $userData->username }}, Welcome</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                        <li class="breadcrumb-item active">Dashboard page</li>
                                    </ol>
                                </div>



                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->

                <div class="container main-tags p-0">
                    <div class="row">
                        <div class=" col-lg-4 col-md-12 col-sm-12">
                            <div class="row flex-column">

                                <div class="col-md-12 col-sm-12">
                                    <div class="card moni-card br-2 shadow-sm border-0 rounded-4">
                                        <div class="card-header d-flex justify-content-between align-items-center p-3 rounded-top-4"
                                            style="background-color: {{ $configuration->template_color }} !important; color: white;">
                                            <h6 class="mb-0">Total Balance</h6>
                                            <a href="{{ route('usertransactions') }}" class="text-white small">Transaction
                                                History</a>
                                        </div>
                                        <div class="card-body p-4">
                                            <div class="amt-balance d-flex align-items-center justify-content-between mb-3">
                                                <div class="h4 mb-0 text-success fw-bold">
                                                    <span>₦</span><span>{{ number_format($userData->account_balance, 2) }}</span>
                                                </div>
                                            </div>

                                            <div class="send-rec mt-4 d-flex flex-wrap gap-2">
                                                <a href="#"
                                                    class="btn w-100 d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-center1"
                                                    style="border: 2px solid {{ $configuration->template_color }} !important; color: {{ $configuration->template_color }} !important;">
                                                    <i class="bi bi-box-arrow-in-up-right me-2"></i>
                                                    <span>ATM/Transfer Funding</span>
                                                </a>
                                                {{-- <a href="#"
                                                    class="btn w-100 d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target=".bs-example-modal-center"
                                                    style="border: 2px solid {{ $configuration->template_color }} !important; color: {{ $configuration->template_color }} !important;">
                                                    <i class="ri-wallet-3-line bi bi-box-arrow-in-down-right me-2"></i>
                                                    <span>Automated Bank Funding</span>
                                                </a> --}}
                                                <a href="#"
                                                    class="btn w-100 d-flex align-items-center justify-content-center"
                                                    data-bs-toggle="modal" data-bs-target=".mySmallModalfund"
                                                    style="border: 2px solid {{ $configuration->template_color }} !important; color: {{ $configuration->template_color }} !important;">
                                                    <i class="bi bi-box-arrow-in-up-right me-2"></i>
                                                    <span>Manual Bank Funding</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="col-md-12 col-sm-12">
                                    <div class="quick mb-3">
                                        <div class="h6">Quick Action</div><br>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('airtime') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-phone-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Airtime</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('data') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class=" ri-wifi-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Data</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>


                                            <div class="col-6">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('electricity') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class=" ri-lightbulb-flash-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Electricity</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>




                                            <div class="col-6">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('tv') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-tv-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Tv</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>

                                        </div>






                                    </div>

                                </div>

                            </div>
                        </div>


                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="row flex-column">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card p-4 br-2">
                                        <div class="row">


                                            <div class="col-md-6 col-sm-12">
                                                <div class="box">
                                                    <div class="ico">
                                                        <i class="ri-exchange-dollar-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total credited amount</div>
                                                    <div class="h4 mt-3">
                                                        <span>₦</span><span>{{ number_format($totalCreditedAmount, 2) }}</span>
                                                    </div>
                                                    <div class="mt-3"><i class="bi bi-arrow-up text-success"></i> Total
                                                        Transaction(s) <span
                                                            class="text-warning">{{ $totalCreditedTransactions }}</span>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-0">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total debited amount</div>
                                                    <div class="h4 mt-3">
                                                        <span>₦</span><span>{{ number_format($totalDebitedAmount, 2) }}</span>
                                                    </div>
                                                    <div class="mt-3">
                                                        <i class="bi bi-arrow-down text-danger"></i> Total Transaction(s)
                                                        <span class="text-warning">{{ $totalTransactions }}</span>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-12 col-sm-12">
                                    <div class="ref mb-3">
                                        <div class="h6">Referrals</div><br>
                                        <div class="row">


                                            <div class="col-lg-6 col-md-12 col-sm-12">
                                                <div class="card br-2 moni-card">
                                                    <div class="d-flex">
                                                        <div class="link">
                                                            <i class="bi bi-link"></i>
                                                        </div>
                                                        <div class="text-ref">
                                                            <span>Referral
                                                                Balance</span><br><span>{{ number_format($userData->refferal_bonus, 2) }}
                                                                NGN
                                                            </span>
                                                        </div>
                                                    </div>

                                                    {{-- <form action="" class="mt-3">
                                                        <button class="btn btn-outline-org p-2 w-50">Withdraw</button>
                                                    </form> --}}

                                                    <div class="d-flex mt-3">
                                                        <div class="d-flex h5"><i class="bi bi-people"></i> <span
                                                                class="ms-2">Total Referrals
                                                                <b>{{ $userData->refferal }}</b></span></div>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <div class="card p-2 br-2">

                                                    <div class="text mt-2">
                                                        <h5
                                                            style="color: {{ $configuration->template_color }} !important;">
                                                            Refer people to
                                                            {{ $configuration->site_name }} and get {{ $configuration->bonus }}% of the referees
                                                            first funding and also get ₦500 when the referee upgrades to
                                                            topuser(note, it's capped at 1,500 naira)</h5>
                                                        @php
                                                            $accountLevel = '';

                                                            // Check which field has a value of 1 and assign the corresponding account level name
                                                            if ($userData->topuser_earners == 1) {
                                                                $accountLevel = 'Top User Earners';
                                                            } elseif ($userData->api_earners == 1) {
                                                                $accountLevel = 'API Earners';
                                                            } elseif ($userData->smart_earners == 1) {
                                                                $accountLevel = 'Smart Earners';
                                                            }
                                                        @endphp

                                                        <p class="mt-3">
                                                            Account Level: <span
                                                                class="text-primary fw-bolder">{{ $accountLevel ?: 'user' }}</span>
                                                        </p>

                                                        @if (isset($userData) && $userData->topuser_earners == 0)
                                                            <button class="btn btn-secondary upgradeTopUser">Upgrade
                                                                Now!</button>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @if (isset($userData) && $userData->topuser_earners == 0)
                                                <div class="col-6">
                                                    <div class="card p-2 br-2 bg-dark">
                                                        <a href="javascript:void(0);" class="qbox"
                                                            class="upgradeTopUser">
                                                            <div class="item-box">
                                                                <i class="ri-man-line"></i>
                                                            </div>
                                                            <div class="text mt-2">
                                                                <p class="text-white">Click To</p>
                                                                <p class="text-white">Upgrade to Topuser(₦1500)</p>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-6">
                                                <div class="card p-2 br-2 bg-dark">
                                                    <a href="{{ route('usertransactions') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-phon-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-white">
                                                                Click To View</p>
                                                            <p class="text-white">
                                                                Transactions</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card p-2 br-2 bg-dark">
                                                    <a href="{{ route('usersupport') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-phon-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-white">
                                                                Click To View</p>
                                                            <p class="text-white">
                                                                Support</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>
                                            @php
                                                // Retrieve active pages for the authenticated user
                                                $pages = \App\Models\merchants::where('action', 1)->get(); // Adjust the model path if necessary
                                            @endphp

                                            @foreach ($pages as $page)
                                                @if ($page->id == 33 && $page->action == 1)
                                                    <div class="col-6">
                                                        <div class="card p-2 br-2 bg-dark">
                                                            <a href="{{ route('walletSummary') }}" class="qbox">
                                                                <div class="item-box">
                                                                    <i class="ri-phone-line"></i>
                                                                    <!-- Use the appropriate icon class -->
                                                                </div>
                                                                <div class="text mt-2">
                                                                    <p class="text-white">
                                                                        Click To View
                                                                    </p>
                                                                    <p class="text-white">
                                                                        Wallet Summary
                                                                    </p>
                                                                </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach


                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card br-2 moni-card text-center">
                                <div class="h5">Invite and Earn</div>
                                <p>Earn for inviting a friend with your referral code or
                                    referral link</p>

                                <div class="h6 mt-3">Share your referral link</div>
                                <form class="form-group d-flex mb-3">
                                    <!-- Dynamically set the referral link using the user's user_id -->
                                    <input type="text" name="referral_link" id="referral_link" disabled
                                        class="form-control"
                                        value="{{ url('/registration') . '?ref=' . (auth()->user()->user_id ?? 'defaultID') }}">
                                    <button type="button" id="copy_link_btn" class="btn btn-org ms-2"
                                        onclick="copyToClipboard('referral_link', 'copy_link_btn')">Copy
                                        Link</button>
                                </form>

                                <div class="h6 mt-3">Copy your referral code</div>
                                <form class="form-group d-flex">
                                    <!-- Dynamically display the user's referral code -->
                                    <input type="text" name="referral_code" id="referral_code" disabled
                                        class="form-control" value="{{ auth()->user()->user_id ?? 'defaultID' }}">
                                    <button type="button" id="copy_code_btn" class="btn btn-org ms-2"
                                        onclick="copyToClipboard('referral_code', 'copy_code_btn')">Copy
                                        Code</button>
                                </form>
                            </div>
                        </div>




                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card moni-card br-2">
                                <div class="h6">Transaction Flow</div>
                                <div class="table-responsive">
                                    <table class="table table-centered mb-0 align-middle table-hover table-nowrap">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Recipient</th>
                                                <th>Amount</th>
                                                <th>Type</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td>
                                                        <div class="transaction-icon">
                                                            <div class="icon-hold">
                                                                @if ($transaction->type === 'Airtime')
                                                                    <img src="{{ asset('assets/images/brands/Mtn.png') }}"
                                                                        width="35" alt="">
                                                                @elseif($transaction->type === 'Data')
                                                                    <img src="{{ asset('assets/images/brands/data.png') }}"
                                                                        width="35" alt="">
                                                                @elseif($transaction->type === 'Education')
                                                                    <img src="{{ asset('assets/images/brands/education.png') }}"
                                                                        width="35" alt="">
                                                                @elseif($transaction->type === 'Electricity')
                                                                    <img src="{{ asset('assets/images/brands/electricity.png') }}"
                                                                        width="35" alt="">
                                                                @elseif($transaction->type === 'Fund')
                                                                    <i class="bi bi-wallet-fill"></i>
                                                                @elseif($transaction->type === 'Insurance')
                                                                    <img src="{{ asset('assets/images/brands/insurance.png') }}"
                                                                        width="35" alt="">
                                                                @elseif($transaction->type === 'TV')
                                                                    <img src="{{ asset('assets/images/brands/tv.png') }}"
                                                                        width="35" alt="">
                                                                @endif
                                                            </div>
                                                            <h6 class="mb-0">{{ $transaction->recipient }}</h6>
                                                        </div>
                                                    </td>
                                                    <td><span>₦</span><span>{{ number_format($transaction->amount, 2) }}</span>
                                                    </td>
                                                    <td>{{ $transaction->type }}</td>
                                                    <td>{{ $transaction->created_at->format('d M, Y') }}</td>
                                                    <td
                                                        class="{{ $transaction->status === 'Successful' ? 'status-success' : ($transaction->status === 'Pending' ? 'status-pending' : 'status-fail') }}">
                                                        <span>{{ $transaction->status }}</span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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


    <div class="modal fade bs-example-modal-center1" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Fund account with Monnify(ATM / BANK TRANSFER)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="monnifyForm">
                        @csrf
                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Account Username:</b> {{ $userData->username }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Amount</label>
                            <div>
                                <input type="number" class="form-control p-12" required parsley-type="amount"
                                    placeholder="Enter amount" name="amount" id="amount" />
                            </div>
                        </div>

                        <div class="mb-3 d-flex justify-content-between">
                            <span>Transaction charge</span>
                            <span class="text-primary" id="transactionCharge">₦0</span>
                        </div>
                        <hr>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Total</span>
                            <span class="text-primary" id="total">₦0</span>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <button type="button" class="btn btn-org w-100 p-2"
                                onclick="payWithMonnify()">Continue</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade mySmallModalfund" tabindex="-1" role="dialog" aria-labelledby="mySmallModalfund"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content p-3">
                <div class="modal-header">
                    <h5 class="modal-title">Fund Account Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="fundForm">
                        @csrf

                        <!-- Bank Information Display -->
                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Bank Name:</b> {{ $configuration->site_bank_name }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Bank Account Username:</b>
                                    {{ $configuration->site_bank_account_name }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Bank Account Number:</b>
                                    {{ $configuration->site_bank_account_account }}</span>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="p-3" style="background-color:rgba(255, 102, 0,0.2); color: rgb(255, 102, 0);">
                                <span class="account-name"><b>Comment:</b> {{ $configuration->site_bank_comment }}</span>
                            </div>
                        </div>

                        <div class="container my-5">
                            <div class="card shadow-sm border-0 rounded">
                                <div class="card-body text-center">
                                    <h4 class="card-title mb-4">Notice!</h4>
                                    <p class="card-text text-muted">If you have any questions or need further assistance,
                                        feel free to chat with us on WhatsApp.</p>
                                    <p class="text-muted mb-4">Click the button below to chat directly with our support
                                        team.</p>

                                    <!-- WhatsApp Button -->
                                    <a href="https://wa.me/{{ $configuration->whatsapp_number ?? '00000000000' }}?text={{ urlencode($configuration->welcome_message ?? 'Hello! I have just made a manual funding request.') }}"
                                        class="btn btn-success btn-lg d-flex justify-content-center align-items-center mx-auto"
                                        style="width: fit-content;">
                                        <i class="bi bi-whatsapp me-2"></i> Chat on WhatsApp
                                    </a>

                                    <!-- Success Message -->
                                    <p class="mt-3 text-success">We’re here to assist you!</p>
                                </div>
                            </div>
                        </div>

                        <!-- Bootstrap Icons (for WhatsApp icon) -->
                        <link rel="stylesheet"
                            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css">

                        <!-- Form Fields for Manual Funding -->
                        {{-- <div class="mb-3">
                            <label>Bank Paid To</label>
                            <input type="text" class="form-control p-12" required placeholder="Bank paid to"
                                name="bankTo" id="bankTo" />
                            <p class="text-danger" id="error1"></p>
                        </div>

                        <div class="mb-3">
                            <label>Reference or Narration*</label>
                            <input type="text" class="form-control p-12" required placeholder="Narration"
                                name="narrate" id="narrate" />
                            <p class="text-danger" id="error2"></p>
                        </div>

                        <div class="mb-3">
                            <label>Amount*</label>
                            <input type="number" class="form-control p-12" required placeholder="Enter amount"
                                name="amountTo" id="amountTo" />
                            <p class="text-danger" id="error3"></p>
                        </div>

                        <!-- Calculations -->
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Transaction Charge</span>
                            <span class="text-primary" id="transactionChargeTo">₦0</span>
                        </div>
                        <hr>
                        <div class="mb-3 d-flex justify-content-between">
                            <span>Total</span>
                            <span class="text-primary" id="totalTo">₦0</span>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <button type="button" class="btn btn-org w-100 p-2" id="manualFunding">Continue</button>
                        </div> --}}
                    </form>

                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <script>
        $(document).ready(function() {
            $('#amountTo').on('input', function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount) && amount > 0) {
                    var transactionCharge = 50;
                    var total = amount + transactionCharge;

                    $('#transactionChargeTo').text('₦' + transactionCharge.toFixed(2));
                    $('#totalTo').text('₦' + total.toFixed(2));
                } else {
                    $('#transactionChargeTo').text('₦0');
                    $('#totalTo').text('₦0');
                }
            });

            $('#manualFunding').on('click', function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Clear previous error messages
                $('#error1').text('');
                $('#error2').text('');
                $('#error3').text('');

                // Validate form fields
                var isValid = true;
                var bankTo = $('#bankTo').val().trim();
                var narrate = $('#narrate').val().trim();
                var amountTo = $('#amountTo').val().trim();

                if (!bankTo) {
                    $('#error1').text('Bank paid to is required.');
                    isValid = false;
                }

                if (!narrate) {
                    $('#error2').text('Reference or Narration is required.');
                    isValid = false;
                }

                if (!amountTo || isNaN(amountTo) || parseFloat(amountTo) <= 0) {
                    $('#error3').text('Valid amount is required.');
                    isValid = false;
                }

                if (isValid) {
                    // Get form data
                    var formData = {
                        _token: $('input[name=_token]').val(), // CSRF token
                        bankTo: bankTo,
                        narrate: narrate,
                        amountTo: amountTo
                    };

                    $.ajax({
                        url: '/user/fundmanual', // Your form submission URL
                        type: 'POST',
                        data: formData,
                        success: function(response) {
                            $('.mySmallModalfund').modal('hide');
                            // Handle the success response
                            if (response.status === 'success') {
                                Swal.fire({
                                    title: "Success!",
                                    html: response.message +
                                        '<br><br><a href="/dashboard" class="btn btn-primary">View Reflect Balance</a>',
                                    icon: "success",
                                    showConfirmButton: false // Hide the default OK button
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            // Handle the error response
                            Swal.fire({
                                title: "Failed!",
                                text: 'Something went wrong, please try again.',
                                icon: "error"
                            });
                            console.error('Submission failed:', error);
                        }
                    });
                }
            });
        });
    </script>



    <script>
        function copyToClipboard(elementId, buttonId) {
            // Get the input and button elements
            const inputElement = document.getElementById(elementId);
            const buttonElement = document.getElementById(buttonId);

            // Temporarily enable the input to select text
            inputElement.disabled = false;
            inputElement.select();
            inputElement.setSelectionRange(0, 99999); // For mobile devices
            document.execCommand("copy");
            inputElement.disabled = true;

            // Change button text to 'Copied'
            buttonElement.textContent = 'Copied!';

            // Revert button text back to 'Copy' after 3 seconds
            setTimeout(() => {
                buttonElement.textContent = buttonId === 'copy_link_btn' ? 'Copy Link' : 'Copy Code';
            }, 3000);
        }
    </script>

    <script>
        $(document).ready(function() {
            let monnifyFee;

            // Fetch the Monnify fee from the server
            $.get('/admin/monnify-fee', function(response) {
                if (response.fee) {
                    monnifyFee = parseFloat(response.fee); // Set the fee dynamically from the response
                } else {
                    alert("Unable to fetch Monnify fee. Please try again later.");
                }
            }).fail(function() {
                alert("Failed to fetch Monnify fee. Check your connection or contact support.");
            });

            // Update transaction charge and total dynamically on input
            $('#amount').on('input', function() {
                var amount = parseFloat($(this).val());
                if (!isNaN(amount) && monnifyFee !== undefined) {
                    // Calculate transaction charge and total amount
                    var transactionCharge = (amount * monnifyFee) / 100;
                    var total = amount + transactionCharge;

                    // Update the transaction charge and total in the UI
                    $('#transactionCharge').text('₦' + transactionCharge.toFixed(2));
                    $('#total').text('₦' + total.toFixed(2));
                } else {
                    $('#transactionCharge').text('₦0');
                    $('#total').text('₦0');
                }
            });

            // Initialize Monnify payment
            function payWithMonnify() {
                var amount = parseFloat($('#amount').val()); // Parse the amount as a float
                if (!amount || isNaN(amount)) {
                    alert("Please enter a valid amount.");
                    return;
                }

                if (monnifyFee === undefined) {
                    alert("Transaction fee is not set. Please try again later.");
                    return;
                }

                // Calculate total amount including Monnify fee
                var transactionCharge = (amount * monnifyFee) / 100;
                var totalAmount = amount + transactionCharge; // Total to be sent to Monnify

                MonnifySDK.initialize({
                    amount: totalAmount.toFixed(2), // Include the Monnify fee
                    currency: "NGN",
                    reference: String((new Date()).getTime()),
                    customerFullName: "{{ $userData->username }}",
                    customerEmail: "{{ $userData->email }}",
                    apiKey: "{{ $configuration->monnify_api_key }}", // Replace with your actual API key
                    contractCode: "{{ $configuration->monnify_contract_code }}", // Replace with your actual contract code
                    paymentDescription: "Payment for ...",
                    metadata: {
                        "name": "{{ $userData->name }}", // Use dynamic data
                    },
                    onLoadStart: () => {
                        console.log("loading has started");
                    },
                    onLoadComplete: () => {
                        console.log("SDK is UP");
                    },
                    onComplete: function(response) {
                        $('.bs-example-modal-center1').modal('hide');
                        $.ajax({
                            url: '/fund/monnify',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                authorizedAmount: response
                                .authorizedAmount, // Amount Monnify processed
                                originalAmount: amount, // Original amount entered by the user
                                message: response.message,
                                paymentReference: response.paymentReference,
                                status: response.status,
                                transactionReference: response.transactionReference
                            },
                            success: function(result) {
                                if (result.status === "success") {
                                    Swal.fire({
                                        title: "Success!",
                                        html: response.message +
                                            '<br><br><a href="{{ route('dashboard') }}" class="btn btn-primary">View Reflect Balance</a>',
                                        icon: "success",
                                        text: response.message,
                                        showConfirmButton: false
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Cancelled!!!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(err) {
                                console.log(err);
                                alert('An error occurred, please try again.');
                            }
                        });
                    },
                    onClose: function(data) {
                        console.log(data);
                    }
                });
            }

            // Attach event handler to the button
            $('.btn-org').on('click', function(e) {
                e.preventDefault();
                payWithMonnify();
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('.upgradeTopUser').on('click', function(e) {
                e.preventDefault();

                // Show the confirmation alert
                Swal.fire({
                    title: 'Upgrade to Topuser',
                    text: 'Are you sure you want to upgrade to Topuser for ₦1500?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, upgrade!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user clicks OK, submit the request via AJAX
                        $.ajax({
                            url: '{{ route('upgradeTopuser') }}',
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}', // CSRF token
                                upgrade_type: 'Topuser', // Send the type of upgrade
                                amount: 1500 // Send the upgrade fee
                            },
                            success: function(response) {
                                // Handle the success response
                                if (response.status === 'success') {
                                    Swal.fire(
                                        'Upgraded!',
                                        'Your account has been upgraded to Topuser.',
                                        'success'
                                    );
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message ||
                                        'An error occurred while upgrading.',
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr, status, error) {
                                // Handle the error response
                                Swal.fire(
                                    'Failed!',
                                    'Something went wrong, please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>



@endsection
