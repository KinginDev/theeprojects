@extends('admin-layout.layouts.app')

@section('title', 'Dashboard Page')

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
                            <h3 class="mb-sm-0">Hey {{ $user->username }} , Welcome</h4>

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
                                    <div class="quick mb-3">
                                        <div class="h6">Quick Action</div><br>
                                        <div class="row">
                                            <div class="card p-3">
                                                <p class="fw-bolder">Account Balance:
                                                    ₦{{ number_format($totalUserBalance, 2) }}</p>
                                            </div>

                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminAirtime') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-phone-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Airtime</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminData') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class=" ri-wifi-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Data</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>


                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminElectricity') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class=" ri-lightbulb-flash-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Electricity</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>


                                        </div>

                                        <div class="row">
                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminTv') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-tv-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Tv</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminInsurance') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class="ri-dribbble-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Insurance</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>


                                            <div class="col-4">
                                                <div class="card p-2 br-2">
                                                    <a href="{{ route('adminEducation') }}" class="qbox">
                                                        <div class="item-box">
                                                            <i class=" ri-plane-line"></i>
                                                        </div>
                                                        <div class="text mt-2">
                                                            <p class="text-dark">Education</p>
                                                        </div>

                                                    </a>
                                                </div>
                                            </div>






                                        </div>




                                    </div>

                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <div class="quick mb-3">
                                        <div class="h6">Quick Action</div><br>
                                        <img src="{{ asset('/assets/images/img2.png') }}" alt="" width="100%">
                                    </div>

                                </div>


                            </div>
                        </div>


                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <div class="row flex-column">
                                <div class="col-md-12 col-sm-12">
                                    <div class="card p-4 br-2">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12 mt-md-3">
                                                <div class="box">
                                                    <div class="ico">
                                                        <i class="ri-exchange-dollar-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total Users</div>
                                                    <div class="h4 mt-3"><span>{{ $userCount }}</span></div>
                                                    <div class="mt-3"><i class="bi bi-arrow-up text-success"></i> Users
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-3">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total Users Fund</div>
                                                    <div class="h4 mt-3">
                                                        <span>₦</span><span>{{ number_format($totalUserBalance, 2) }}
                                                        </span>
                                                    </div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> Users
                                                        Fund</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-3">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total Credited amount</div>
                                                    <div class="h4 mt-3">
                                                        <span>₦</span><span>{{ number_format($totalCreditedAmount, 2) }}</span>
                                                    </div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> From
                                                        Installed Date</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-3">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total debited amount</div>
                                                    <div class="h4 mt-3">
                                                        <span>₦</span><span>{{ number_format($totalDebitedAmount, 2) }}</span>
                                                    </div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> From
                                                        Installed Date</div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="box">
                                                    <div class="ico">
                                                        <i class="ri-exchange-dollar-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">To</div>
                                                    <div class="h4 mt-3"><span>₦</span><span>280,000.00</span></div>
                                                    <div class="mt-3"><i class="bi bi-arrow-up text-success"></i> From last month</div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-0">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total debited amount</div>
                                                    <div class="h4 mt-3"><span>₦</span><span>70,000.00</span></div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> From last month</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-0">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total debited amount</div>
                                                    <div class="h4 mt-3"><span>₦</span><span>70,000.00</span></div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> From last month</div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12 mt-sm-4 mt-md-0">
                                                <div class="box">
                                                    <div class="ico re">
                                                        <i class="ri-wallet-line"></i>
                                                    </div>
                                                    <div class="h6 text-gray">Total debited amount</div>
                                                    <div class="h4 mt-3"><span>₦</span><span>70,000.00</span></div>
                                                    <div class="mt-3"><i class="bi bi-arrow-down text-danger"></i> From last month</div>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>


                            </div>
                        </div>


                    </div>
                </div>
                @php
                    // Retrieve active pages for the authenticated user
                    $pages = \App\Models\merchants::where('action', 1)->get(); // Adjust the model path if necessary
                @endphp
                @foreach ($pages as $page)
                    @if ($page->id == 35 && $page->action == 1)
                        <div class="container my-5">
                            <!-- Card container for the admin action -->
                            <div class="card shadow-sm rounded">
                                <div class="card-body">
                                    <h5 class="card-title mb-4">Generate CSV of All User Emails</h5>

                                    <!-- Description -->
                                    <p class="text-muted">Click the button below to download a CSV file containing all
                                        email
                                        addresses of users in the system.</p>

                                    <!-- Generate CSV Button -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button class="btn shadow-sm text-white" id="generate-csv-btn"
                                            style="background-color: {{ $configuration->template_color }};">
                                            <i class="bi bi-file-earmark-arrow-down"></i> Generate CSV
                                        </button>
                                        <p class="text-success" id="success-message" style="display: none;">CSV file
                                            generated
                                            successfully!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <script>
                    $(document).ready(function() {
                        $('#generate-csv-btn').on('click', function() {
                            // Send a request to generate the CSV file
                            $.ajax({
                                url: '{{ route('admin.generateUserEmailsCSV') }}', // Ensure this points to the correct route
                                method: 'GET',
                                xhrFields: {
                                    responseType: 'blob' // This ensures the browser handles the download
                                },
                                success: function(response, status, xhr) {
                                    // Handle download
                                    var filename = xhr.getResponseHeader('Content-Disposition').split(
                                        'filename=')[1].replace(/"/g, '');
                                    var blob = new Blob([response], {
                                        type: 'text/csv'
                                    });
                                    var link = document.createElement('a');
                                    link.href = window.URL.createObjectURL(blob);
                                    link.download = filename;
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                    $('#success-message').show(); // Show success message
                                },
                                error: function(err) {
                                    alert('Error generating CSV. Please try again.');
                                }
                            });
                        });
                    });
                </script>




                <!-- Container to hold the main page elements ends here-->

            </div> <!-- container-fluid -->
            @foreach ($pages as $page)
                @if ($page->id == 34 && $page->action == 1)
                    <div class="container my-5">
                        <!-- Card container for the form -->
                        <div class="card shadow-sm rounded">
                            <div class="card-body">
                                <h5 class="card-title mb-4">Sales & Accounting</h5>

                                <!-- Form Row -->
                                <form id="calculate-form">
                                    <div class="row mb-3">
                                        <!-- Start Date -->
                                        <div class="col-md-4">
                                            <label for="startDate" class="form-label">Start Date</label>
                                            <div class="input-group rounded">
                                                <span class="input-group-text bg-primary text-white"><i
                                                        class="bi bi-calendar"></i></span>
                                                <input type="date" class="form-control border-0" id="startDate"
                                                    placeholder="Select start date" required>
                                            </div>
                                        </div>

                                        <!-- End Date -->
                                        <div class="col-md-4">
                                            <label for="endDate" class="form-label">End Date</label>
                                            <div class="input-group rounded">
                                                <span class="input-group-text bg-primary text-white"><i
                                                        class="bi bi-calendar"></i></span>
                                                <input type="date" class="form-control border-0" id="endDate"
                                                    placeholder="Select end date" required>
                                            </div>
                                        </div>

                                        <!-- Calculate Button -->
                                        <div class="col-md-4 d-flex align-items-end">
                                            <button type="submit" class="btn w-100 text-white rounded shadow-sm"
                                                style="background-color: {{ $configuration->template_color }};">
                                                <i class="bi bi-calculator"></i> Calculate
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Transaction Summary Section (Hidden by default) -->
                        <div class="container my-5" id="transaction-summary" style="display: none;">
                            <div class="row text-center">
                                <div class="col-md-6">
                                    <div class="p-3 mb-3 bg-light shadow-sm rounded">
                                        <h3 class="text-success" id="credit-transaction">Credit Transaction: ₦0.00</h3>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 mb-3 bg-light shadow-sm rounded">
                                        <h3 class="text-danger" id="debit-transaction">Debit Transaction: ₦0.00</h3>
                                    </div>
                                </div>
                            </div>

                            <!-- Transaction Cards -->
                            <div class="row mt-4 g-4">
                                <div class="col-md-3">
                                    <div class="card shadow-sm rounded h-100">
                                        <div class="card-body">
                                            <p>MTN Data Sold</p>
                                            <p class="text-primary" id="mtn-data-sold">₦0.00 (0GB)</p>
                                            <p>MTN Airtime Sold</p>
                                            <p class="text-success" id="mtn-airtime-sold">₦0.00</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card shadow-sm rounded h-100">
                                        <div class="card-body">
                                            <p>GLO Data Sold</p>
                                            <p class="text-primary" id="glo-data-sold">₦0.00 (0GB)</p>
                                            <p>GLO Airtime Sold</p>
                                            <p class="text-success" id="glo-airtime-sold">₦0.00</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card shadow-sm rounded h-100">
                                        <div class="card-body">
                                            <p>9MOBILE Data Sold</p>
                                            <p class="text-primary" id="9mobile-data-sold">₦0.00 (0GB)</p>
                                            <p>9MOBILE Airtime Sold</p>
                                            <p class="text-success" id="9mobile-airtime-sold">₦0.00</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="card shadow-sm rounded h-100">
                                        <div class="card-body">
                                            <p>AIRTEL Data Sold</p>
                                            <p class="text-primary" id="airtel-data-sold">₦0.00 (0GB)</p>
                                            <p>AIRTEL Airtime Sold</p>
                                            <p class="text-success" id="airtel-airtime-sold">₦0.00</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
            <script>
                $(document).ready(function() {
                    $('#calculate-form').on('submit', function(e) {
                        e.preventDefault(); // Prevent form submission

                        // Validate both dates are filled
                        const startDate = $('#startDate').val();
                        const endDate = $('#endDate').val();

                        console.log('startDate ' + startDate);
                        console.log('endDate ' + endDate);

                        if (startDate && endDate) {
                            // Fetch the transaction summary via AJAX
                            $.ajax({
                                url: '/calculate-transactions',
                                method: 'POST',
                                data: {
                                    _token: '{{ csrf_token() }}',
                                    startDate: startDate,
                                    endDate: endDate
                                },
                                success: function(response) {
                                    console.log(response);
                                    if (response.status === 'success') {
                                        const data = response.data;

                                        // Update the DOM with the transaction summary
                                        $('#credit-transaction').text('Credit Transaction: ₦' + data
                                            .totalCreditedAmount.toFixed(2));
                                        $('#debit-transaction').text('Debit Transaction: ₦' + data
                                            .totalDebitedAmount.toFixed(2));

                                        // Update individual cards
                                        $('#mtn-data-sold').text('₦' + data.airtime.mtn_data_sold
                                            .toFixed(2));
                                        $('#mtn-airtime-sold').text('₦' + data.airtime.mtn_airtime_sold
                                            .toFixed(2));

                                        $('#glo-data-sold').text('₦' + data.airtime.glo_data_sold
                                            .toFixed(2));
                                        $('#glo-airtime-sold').text('₦' + data.airtime.glo_airtime_sold
                                            .toFixed(2));

                                        $('#9mobile-data-sold').text('₦' + data.airtime[
                                            '9mobile_data_sold'].toFixed(2));
                                        $('#9mobile-airtime-sold').text('₦' + data.airtime[
                                            '9mobile_airtime_sold'].toFixed(2));

                                        $('#airtel-data-sold').text('₦' + data.airtime.airtel_data_sold
                                            .toFixed(2));
                                        $('#airtel-airtime-sold').text('₦' + data.airtime
                                            .airtel_airtime_sold.toFixed(2));

                                        // Show the transaction summary
                                        $('#transaction-summary').fadeIn();
                                    }
                                },
                                error: function(err) {
                                    // Log the error to the console for debugging
                                    console.error('Error:', err);

                                    // Extract and display detailed error message
                                    let errorMessage =
                                        'Error calculating transactions. Please try again.';
                                    if (err.responseJSON && err.responseJSON.message) {
                                        errorMessage = err.responseJSON.message;
                                    } else if (err.statusText) {
                                        errorMessage = `${err.status}: ${err.statusText}`;
                                    }
                                    alert(errorMessage);
                                }
                            });
                        } else {
                            alert('Please select both start and end dates.');
                        }
                    });
                });
            </script>
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
