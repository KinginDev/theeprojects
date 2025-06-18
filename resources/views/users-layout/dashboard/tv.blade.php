@extends('users-layout.dashboard.layouts.app')

@section('title', 'Cable Tv Page')

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
                            <h4 class="mb-sm-0">Tv Subscription</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Tv Subscription</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->

                <div class="container main-tags">

                    <div class="col-md-8 col-sm-12">

                        <div class="card-body m-0 p-0">

                            <!-- Nav tabs -->
                            <ul class="nav nav-pills p-0 m-0" role="tablist">
                                <li class="nav-item waves-effect waves-light tab-s ms-2 ms-md-3 ">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#dstv" role="tab">
                                        <span class="d-block">DSTV</span>
                                    </a>
                                </li>
                                <li class="nav-item waves-effect waves-light tab-s ms-2 ms-md-3">
                                    <a class="nav-link" data-bs-toggle="tab" href="#gotv" role="tab">
                                        <span class="d-block">GOTV</span>

                                    </a>
                                </li>

                                <li class="nav-item waves-effect waves-light tab-s ms-2 ms-md-3">
                                    <a class="nav-link" data-bs-toggle="tab" href="#startime" role="tab">
                                        <span class="d-block">STARTIME</span>

                                    </a>
                                </li>

                                <li class="nav-item waves-effect waves-light tab-s ms-2 ms-md-3">
                                    <a class="nav-link" data-bs-toggle="tab" href="#showmax" role="tab">
                                        <span class="d-block">SHOWMAX</span>

                                    </a>
                                </li>

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                {{-- DSTV section --}}
                                <div class="tab-pane active mt-3" id="dstv" role="tabpanel">
                                    <form class="custom-validation" id="dstvForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Smart Card number</label>
                                            <input type="text" class="form-control p-12" required
                                                placeholder="Enter valid DSTV smartcard number" id="billersCode"
                                                name="billerCode" />
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100"
                                                id="checkBillcode">Continue</button>
                                        </div>
                                        <div class="hideInnerForm" style="display:none">
                                            <div class="mb-3">
                                                <div class="card moni-card dstvCard" style="display:none;">
                                                    <div class="tran-items">
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Name</p>
                                                            <p class="d-flex"> <span class="ms-2" id="customerName">Nnaji
                                                                    Christian</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Current Bouquet(s)</p>
                                                            <p class="d-flex"> <span class="ms-2" id="currentBouquet">GOTV
                                                                    Jolli ₦2,800</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Due Date</p>
                                                            <p class="d-flex"> <span class="ms-2" id="dueDate">March
                                                                    15th, 2024</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Renewal Amount</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="renewalAmount">₦3,863</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label">What do you want to
                                                    do?</label>
                                                <select class="form-select p-12" disabled id="validationCustom03"
                                                    name="bouquet" required>
                                                    <option selected disabled value="">What do you want to do</option>
                                                    <option class="d-flex" value="renew"> Renew Current Bouquet</option>
                                                    <option class="d-flex" value="change"> Change Bouquet</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="selectBouquetContainer" style="display: none;">
                                                <label for="selectBouquet" class="form-label">Select a Bouquet</label>
                                                <select class="form-select p-12" id="selectBouquet" name="selectBouquet"
                                                    required>
                                                    <option selected disabled value="">Please select type...</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="amountContainer" style="display: none;">
                                                <label for="amount" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amount" value=""
                                                    name="amount">
                                            </div>
                                            <div class="mb-3">
                                                <label>Phone number</label>
                                                <input type="text" class="form-control p-12" required
                                                    placeholder="Recipient Phone number" name="tel" />
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                                        id="submitDstv">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                                <!-- Preloader -->
                                <div id="preloader" class="justify-content-center align-items-center"
                                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                <!-- End Preloader -->
                                {{-- GOTV section --}}
                                <div class="tab-pane" id="gotv" role="tabpanel">
                                    <p class="mb-0">
                                    <form class="custom-validation" id="gotvForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Smart Card number</label>
                                            <input type="text" class="form-control p-12" required
                                                placeholder="Enter Valid GOTV IUC NUMBER" id="billerCodeGotv"
                                                name="billerCodeGotv" />
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100"
                                                id="checkBillcodeGotv">Continue</button>
                                        </div>
                                        <div class="hideInnerForm" style="display:none">
                                            <div class="mb-3">
                                                <div class="card moni-card gotvCard" style="display:none;">
                                                    <div class="tran-items">
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Name</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="customerNameGotv">Nnaji
                                                                    Christian</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Current Bouquet(s)</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="currentBouquetGotv">GOTV
                                                                    Jolli ₦2,800</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Due Date</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="dueDateGotv">March
                                                                    15th, 2024</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Renewal Amount</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="renewalAmountGotv">₦3,863</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="bouquet" class="form-label">What do you want to
                                                    do?</label>
                                                <select class="form-select p-12" disabled id="bouquetGotv"
                                                    name="bouquetGotv" required>
                                                    <option selected disabled value="">What do you want to do
                                                    </option>
                                                    <option class="d-flex" value="renew"> Renew Current Bouquet</option>
                                                    <option class="d-flex" value="change"> Change Bouquet</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="selectBouquetContainerGotv" style="display: none;">
                                                <label for="selectBouquet" class="form-label">Select a Bouquet</label>
                                                <select class="form-select p-12" id="selectBouquetGotv"
                                                    name="selectBouquetGotv" required>
                                                    <option selected disabled value="">Please select type...</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="amountContainerGotv" style="display: none;">
                                                <label for="amountGotv" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amountGotv"
                                                    value="" name="amountGotv">
                                            </div>
                                            <div class="mb-3">
                                                <label>Phone number</label>
                                                <input type="text" class="form-control p-12" required
                                                    placeholder="Recipient Phone number" name="telGotv" />
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                                        id="submitGotv">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </p>
                                </div>

                                {{-- STARTIMES section --}}
                                <div class="tab-pane" id="startime" role="tabpanel">
                                    <p class="mb-0">
                                    <form class="custom-validation" id="startimeForm">
                                        @csrf
                                        <div class="mb-3">
                                            <label>Smart Card number</label>
                                            <input type="text" class="form-control p-12" required
                                                placeholder="Enter Startimes Smartcard /ewallet Number"
                                                id="billerCodeStartime" name="billerCodeStartime" />
                                        </div>
                                        <div class="mb-3">
                                            <button type="submit" class="btn btn-primary w-100"
                                                id="checkBillcodeStartime">Continue</button>
                                        </div>
                                        <div class="hideInnerForm" style="display:none">
                                            <div class="mb-3">
                                                <div class="card moni-card startimeCard" style="display:none;">
                                                    <div class="tran-items">
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Name</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="customerNameStartime">Nnaji
                                                                    Christian</span></p>
                                                        </div>
                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Smartcard Number</p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="currentBouquetStartime">GOTV
                                                                    Jolli ₦2,800</span></p>
                                                        </div>

                                                        <div class="d-flex tran-item">
                                                            <p class="text-gray">Balance </p>
                                                            <p class="d-flex"> <span class="ms-2"
                                                                    id="renewalAmountStartime">₦3,863</span></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="mb-3" id="selectBouquetContainerStartime">
                                                <label for="selectBouquet" class="form-label">Select a Bouquet</label>
                                                <select class="form-select p-12" id="selectBouquetStartime"
                                                    name="selectBouquetStartime" required>
                                                    <option selected disabled value="">Please select type...</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="amountContainerStartime" style="display: none;">
                                                <label for="amountStartime" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amountStartime"
                                                    value="" name="amountStartime">
                                            </div>
                                            <div class="mb-3">
                                                <label>Phone number</label>
                                                <input type="text" class="form-control p-12" required
                                                    placeholder="Recipient Phone number" name="telStartime" />
                                            </div>
                                            <div class="mb-3">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                                        id="submitStartime">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </p>
                                </div>

                                {{-- ShowMax section --}}
                                <div class="tab-pane" id="showmax" role="tabpanel">
                                    <p class="mb-0">
                                    <form class="custom-validation" id="showmaxForm">
                                        @csrf

                                        <div>
                                            <div class="mb-3">
                                                <label>Phone number</label>
                                                <input type="text" class="form-control p-12" required
                                                    placeholder="Recipient Phone number" name="telShowmax" />
                                            </div>
                                            <div class="mb-3" id="selectBouquetContainershowmax">
                                                <label for="selectBouquet" class="form-label">Select a Type</label>
                                                <select class="form-select p-12" id="selectBouquetShowmax"
                                                    name="selectBouquetShowmax" required>
                                                    <option selected disabled value="">Please select type...</option>
                                                </select>
                                            </div>
                                            <div class="mb-3" id="amountContainerShowmax">
                                                <label for="amountShowmax" class="form-label">Amount</label>
                                                <input type="text" class="form-control" id="amountShowmax"
                                                    value="" name="amountShowmax" readonly>
                                            </div>

                                            <div class="mb-3">
                                                <div>
                                                    <button type="submit"
                                                        class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                                        id="submitShowmax">Continue</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    </p>
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



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Function to show preloader
        function showPreloader() {
            $('#preloader').show();
        }

        // Function to hide preloader
        function hidePreloader() {
            $('#preloader').hide();
        }

        $(document).ready(function() {
            // DSTV SUBMIT BY JQUERY

            $('#checkBillcode').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader

                var billerCode = $('#billersCode').val();

                $.ajax({
                    url: '/tv/billcode/Dstv', // The route to your Laravel controller
                    method: 'POST',
                    data: {
                        billerCode: billerCode,
                        _token: '{{ csrf_token() }}' // Include the CSRF token for security
                    },
                    success: function(response) {
                        hidePreloader(); // Hide preloader
                        // Handle the response from the server
                        console.log(response);

                        if (response.result && response.result.content) {
                            var content = response.result.content;

                            // Update the card content
                            $('#customerName').text(content.Customer_Name);
                            $('#currentBouquet').text(content
                                .Current_Bouquet
                            ); // Adjust according to your response structure
                            $('#dueDate').text(content.Due_Date);
                            $('#renewalAmount').text('₦' + content
                                .Renewal_Amount); // Adjust according to your response structure

                            // Show the card if it was hidden
                            $('.dstvCard').show();
                            $('.hideInnerForm').show();
                            $('#validationCustom03').prop('disabled', false);

                            // Handle the change event of the main select element
                            $('#validationCustom03').off('change').on('change', function() {
                                var selectedValue = $(this).val();

                                if (selectedValue === 'change') {
                                    $('#selectBouquetContainer').show();
                                    $('#amountContainer').hide();

                                    $.ajax({
                                        url: 'https://vtpass.com/api/service-variations?serviceID=dstv',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response);
                                            if (response && response
                                                .content && response.content
                                                .varations) {
                                                // Access the variations array
                                                var varations = response
                                                    .content.varations;

                                                // Clear previous options
                                                $('#selectBouquet').empty();

                                                // Add default option
                                                $('#selectBouquet').append(
                                                    '<option selected disabled value="">Please select type...</option>'
                                                );

                                                // Iterate through the variations and add options to the select element
                                                $.each(varations, function(
                                                    index, varation
                                                ) {
                                                    $('#selectBouquet')
                                                        .append(
                                                            $(
                                                                '<option></option>'
                                                            )
                                                            .val(
                                                                varation
                                                                .variation_code
                                                            )
                                                            .text(
                                                                varation
                                                                .name
                                                            )
                                                            .attr(
                                                                'data-amount',
                                                                varation
                                                                .variation_amount
                                                            )
                                                        );
                                                });

                                                // Handle the change event for selectBouquet
                                                $('#selectBouquet').off(
                                                    'change').on(
                                                    'change',
                                                    function() {
                                                        // Get the selected option
                                                        var selectedOption =
                                                            $(this)
                                                            .find(
                                                                'option:selected'
                                                            );

                                                        // Retrieve the data-amount attribute
                                                        var amount =
                                                            selectedOption
                                                            .data(
                                                                'amount'
                                                            );

                                                        // Display the amount in the #amount input field
                                                        $('#amountContainer')
                                                            .show();
                                                        $('#amount')
                                                            .val(
                                                                amount);
                                                    });

                                                // Show the selectBouquetContainer after populating options
                                                $('#selectBouquetContainer')
                                                    .show();
                                            }
                                        },
                                        error: function(error) {
                                            hidePreloader
                                                (); // Hide preloader
                                            // Handle the error response
                                            console.log(error);
                                        }
                                    });
                                } else if (selectedValue === 'renew') {
                                    $('#selectBouquetContainer').hide();
                                    $('#amountContainer').show();
                                    $('#amount').val(content.Renewal_Amount);
                                } else {
                                    $('#selectBouquetContainer').hide();
                                    $('#amountContainer').hide();
                                }
                            });
                        } else {
                            alert('Transaction failed');
                        }
                    },
                    error: function(xhr, status, error) {
                        hidePreloader(); // Hide preloader
                        // Handle any errors
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            $('#submitDstv').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader
                var bouquet = $('[name="bouquet"]').val();
                var serviceId = 'dstv';

                if (bouquet == 'change') {
                    // Serialize the form data, including the CSRF token
                    var formData = $('#dstvForm').serialize();
                    console.log(formData);

                    $.ajax({
                        url: '/tv/changeBouquet', // The route to your Laravel controller
                        method: 'POST',
                        data: $.param({
                            serviceId: serviceId
                        }) + '&' + formData, // Directly use the serialized form data
                        success: function(response) {
                            hidePreloader(); // Hide preloader
                            console.log(response);
                            // Handle the successful response
                            if (response.status === 'initiated') {
                                Swal.fire({
                                    title: "Success!",
                                    html: response.message,
                                    icon: "success",

                                }).then(() => {
                                    // Redirect to the success page with a hash parameter
                                    window.location.href = '/transactionview?hash=' +
                                        encodeURIComponent(response.result.requestId);
                                });

                                // Additional handling for success
                            } else if (response.status === 'failed') {
                                Swal.fire({
                                    title: "Error, Please try again!!!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            hidePreloader(); // Hide preloader
                            // Handle any errors
                            console.error('Error: ' + error);
                            console.error('Status: ' + status);
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    // Serialize the form data, including the CSRF token
                    var formData = $('#dstvForm').serialize();
                    console.log(formData);

                    $.ajax({
                        url: '/tv/renewBouquet', // The route to your Laravel controller
                        method: 'POST',
                        data: $.param({
                            serviceId: serviceId
                        }) + '&' + formData, // Directly use the serialized form data
                        success: function(response) {
                            hidePreloader(); // Hide preloader
                            if (response.status === 'initiated') {
                                Swal.fire({
                                    title: "Success!",
                                    html: response.message,
                                    icon: "success",

                                }).then(() => {
                                    // Redirect to the success page with a hash parameter
                                    window.location.href = '/transactionview?hash=' +
                                        encodeURIComponent(response.result.requestId);
                                });

                                // Additional handling for success
                            } else if (response.status === 'failed') {
                                Swal.fire({
                                    title: "Error, Please try again!!!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            hidePreloader(); // Hide preloader
                            // Handle any errors
                            console.error('Error: ' + error);
                            console.error('Status: ' + status);
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // GOTV SUBMIT BY JQUERY

            $('#checkBillcodeGotv').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader

                var billerCode = $('#billerCodeGotv').val();

                $.ajax({
                    url: '/tv/billcode/Gotv', // The route to your Laravel controller
                    method: 'POST',
                    data: {
                        billerCode: billerCode,
                        _token: '{{ csrf_token() }}' // Include the CSRF token for security
                    },
                    success: function(response) {
                        hidePreloader(); // Hide preloader
                        // Handle the response from the server
                        console.log(response);

                        if (response.result && response.result.content) {
                            var content = response.result.content;

                            // Update the card content
                            $('#customerNameGotv').text(content.Customer_Name);
                            $('#currentBouquetGotv').text(content
                                .Current_Bouquet
                            ); // Adjust according to your response structure
                            $('#dueDateGotv').text(content.Due_Date);
                            $('#renewalAmountGotv').text('₦' + content
                                .Renewal_Amount); // Adjust according to your response structure

                            // Show the card if it was hidden
                            $('.gotvCard').show();
                            $('.hideInnerForm').show();
                            $('#bouquetGotv').prop('disabled', false);

                            // Handle the change event of the main select element
                            $('#bouquetGotv').off('change').on('change', function() {
                                var selectedValue = $(this).val();

                                if (selectedValue === 'change') {
                                    $('#selectBouquetContainerGotv').show();
                                    $('#amountContainerGotv').hide();

                                    $.ajax({
                                        url: 'https://vtpass.com/api/service-variations?serviceID=gotv',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(response) {
                                            console.log(response);
                                            if (response && response
                                                .content && response.content
                                                .varations) {
                                                // Access the variations array
                                                var varations = response
                                                    .content.varations;

                                                // Clear previous options
                                                $('#selectBouquetGotv')
                                                    .empty();

                                                // Add default option
                                                $('#selectBouquetGotv')
                                                    .append(
                                                        '<option selected disabled value="">Please select type...</option>'
                                                    );

                                                // Iterate through the variations and add options to the select element
                                                $.each(varations, function(
                                                    index, varation
                                                ) {
                                                    $('#selectBouquetGotv')
                                                        .append(
                                                            $(
                                                                '<option></option>'
                                                            )
                                                            .val(
                                                                varation
                                                                .variation_code
                                                            )
                                                            .text(
                                                                varation
                                                                .name
                                                            )
                                                            .attr(
                                                                'data-amount',
                                                                varation
                                                                .variation_amount
                                                            )
                                                        );
                                                });

                                                // Handle the change event for selectBouquet
                                                $('#selectBouquetGotv').off(
                                                    'change').on(
                                                    'change',
                                                    function() {
                                                        // Get the selected option
                                                        var selectedOption =
                                                            $(this)
                                                            .find(
                                                                'option:selected'
                                                            );

                                                        // Retrieve the data-amount attribute
                                                        var amount =
                                                            selectedOption
                                                            .data(
                                                                'amount'
                                                            );

                                                        // Display the amount in the #amount input field
                                                        $('#amountContainerGotv')
                                                            .show();
                                                        $('#amountGotv')
                                                            .val(
                                                                amount);
                                                    });

                                                // Show the selectBouquetContainer after populating options
                                                $('#selectBouquetContainerGotv')
                                                    .show();
                                            }
                                        },
                                        error: function(error) {
                                            hidePreloader
                                                (); // Hide preloader
                                            // Handle the error response
                                            console.log(error);
                                        }
                                    });
                                } else if (selectedValue === 'renew') {
                                    $('#selectBouquetContainerGotv').hide();
                                    $('#amountContainerGotv').show();
                                    $('#amountGotv').val(content.Renewal_Amount);
                                } else {
                                    $('#selectBouquetContainerGotv').hide();
                                    $('#amountContainerGotv').hide();
                                }
                            });
                        } else {
                            alert('Transaction failed');
                        }
                    },
                    error: function(xhr, status, error) {
                        hidePreloader(); // Hide preloader
                        // Handle any errors
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            $('#submitGotv').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader
                var bouquet = $('[name="bouquetGotv"]').val();
                var serviceId = 'gotv';

                if (bouquet == 'change') {
                    var billerCode = $('[name="billerCodeGotv"]').val();
                    var selectBouquet = $('[name="selectBouquetGotv"]').val();
                    var tel = $('[name="telGotv"]').val();
                    var _token = $('[name="_token"]').val();
                    var amount = $('[name="amountGotv"]').val();
                    // Serialize the form data, including the CSRF token
                    var formData = $('#gotvForm').serialize();
                    console.log(formData);

                    $.ajax({
                        url: '/tv/changeBouquet', // The route to your Laravel controller
                        method: 'POST',
                        data: {
                            _token: _token,
                            billerCode: billerCode,
                            bouquet: bouquet,
                            selectBouquet: selectBouquet,
                            tel: tel,
                            amount: amount,
                            serviceId: serviceId
                        }, // Directly use the serialized form data
                        success: function(response) {
                            hidePreloader(); // Hide preloader
                            // Handle the successful response
                            if (response.status === 'initiated') {
                                Swal.fire({
                                    title: "Success!",
                                    html: response.message,
                                    icon: "success",

                                }).then(() => {
                                    // Redirect to the success page with a hash parameter
                                    window.location.href = '/transactionview?hash=' +
                                        encodeURIComponent(response.result.requestId);
                                });
                                // Additional handling for success
                            } else if (response.status === 'failed') {
                                Swal.fire({
                                    title: "Error, Please try again!!!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            hidePreloader(); // Hide preloader
                            // Handle any errors
                            console.error('Error: ' + error);
                            console.error('Status: ' + status);
                            console.error(xhr.responseText);
                        }
                    });
                } else {
                    var billerCode = $('[name="billerCodeGotv"]').val();
                    var tel = $('[name="telGotv"]').val();
                    var amount = $('[name="amountGotv"]').val();
                    var _token = $('[name="_token"]').val();
                    // Serialize the form data, including the CSRF token
                    var formData = $('#gotvForm').serialize();
                    console.log(formData);

                    $.ajax({
                        url: '/tv/renewBouquet', // The route to your Laravel controller
                        method: 'POST',
                        data: {
                            _token: _token,
                            billerCode: billerCode,
                            bouquet: bouquet,
                            tel: tel,
                            amount: amount,
                            serviceId: serviceId
                        }, // Directly use the serialized form data
                        success: function(response) {
                            hidePreloader(); // Hide preloader
                            console.log(response);
                            if (response.status === 'initiated') {
                                Swal.fire({
                                    title: "Success!",
                                    html: response.message,
                                    icon: "success",

                                }).then(() => {
                                    // Redirect to the success page with a hash parameter
                                    window.location.href = '/transactionview?hash=' +
                                        encodeURIComponent(response.result.requestId);
                                });

                                // Additional handling for success
                            } else if (response.status === 'failed') {
                                Swal.fire({
                                    title: "Error, Please try again!!!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            hidePreloader(); // Hide preloader
                            // Handle any errors
                            console.error('Error: ' + error);
                            console.error('Status: ' + status);
                            console.error(xhr.responseText);
                        }
                    });
                }
            });

            // Startime SUBMIT BY JQUERY

            // STARTIMES SUBMIT BY JQUERY
            $('#checkBillcodeStartime').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader

                var billerCode = $('#billerCodeStartime').val();

                $.ajax({
                    url: '/tv/billcode/Startime', // The route to your Laravel controller
                    method: 'POST',
                    data: {
                        billerCode: billerCode,
                        _token: '{{ csrf_token() }}', // Include the CSRF token for security
                    },
                    success: function(response) {
                        hidePreloader(); // Hide preloader
                        console.log(response);

                        if (response.result && response.result.content) {
                            var content = response.result.content;

                            // Update the card content
                            $('#customerNameStartime').text(content.Customer_Name);
                            $('#currentBouquetStartime').text(content.Smartcard_Number);
                            $('#renewalAmountStartime').text('₦' + content.Balance);

                            // Show the card if it was hidden
                            $('.startimeCard').show();
                            $('.hideInnerForm').show();

                            // Fetch and populate bouquet variations
                            $.ajax({
                                url: 'https://vtpass.com/api/service-variations?serviceID=startimes',
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {
                                    console.log(response);
                                    if (response && response.content && response
                                        .content.varations) {
                                        // Access the variations array
                                        var variations = response.content.varations;

                                        // Clear previous options
                                        $('#selectBouquetStartime').empty();

                                        // Add default option
                                        $('#selectBouquetStartime').append(
                                            '<option selected disabled value="">Please select type...</option>'
                                        );

                                        // Populate the dropdown
                                        $.each(variations, function(index,
                                            variation) {
                                            $('#selectBouquetStartime')
                                                .append(
                                                    $('<option></option>')
                                                    .val(variation
                                                        .variation_code)
                                                    .text(variation.name)
                                                    .attr('data-amount',
                                                        variation
                                                        .variation_amount)
                                                );
                                        });

                                        // Handle the change event for selectBouquetStartime
                                        $('#selectBouquetStartime').off('change')
                                            .on('change', function() {
                                                var selectedOption = $(this)
                                                    .find('option:selected');
                                                var amount = selectedOption
                                                    .data('amount');
                                                $('#amountContainerStartime')
                                                    .show();
                                                $('#amountStartime').val(
                                                    amount);
                                            });

                                        // Show the selectBouquetContainer after populating options
                                        $('#selectBouquetContainerStartime').show();
                                    }
                                },
                                error: function(error) {
                                    console.error(
                                        'Error fetching Startimes bouquet variations:',
                                        error);
                                },
                            });
                        } else {
                            alert('Transaction failed. Please check the Smartcard number.');
                        }
                    },
                    error: function(xhr, status, error) {
                        hidePreloader(); // Hide preloader
                        console.error('Error: ' + error);
                        alert('An error occurred. Please try again.');
                    },
                });
            });


            $('#submitStartime').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader

                var billerCode = parseInt($('[name="billerCodeStartime"]').val(), 10);
                var selectBouquet = $('[name="selectBouquetStartime"]').val();
                var tel = $('[name="telStartime"]').val();
                var _token = $('[name="_token"]').val();
                var amount = $('[name="amountStartime"]').val();
                // Serialize the form data, including the CSRF token
                var formData = $('#startimeForm').serialize();
                console.log(formData);

                $.ajax({
                    url: '/tv/bouquet/Startime', // The route to your Laravel controller
                    method: 'POST',
                    data: {
                        _token: _token,
                        billerCode: billerCode,
                        selectBouquet: selectBouquet,
                        tel: tel,
                        amount: amount
                    }, // Directly use the serialized form data
                    success: function(response) {
                        hidePreloader(); // Hide preloader
                        // Handle the successful response
                        if (response.status === 'initiated') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message,
                                icon: "success",

                            }).then(() => {
                                // Redirect to the success page with a hash parameter
                                window.location.href = '/transactionview?hash=' +
                                    encodeURIComponent(response.result.requestId);
                            });
                            // Additional handling for success
                        } else if (response.status === 'failed') {
                            Swal.fire({
                                title: "Error, Please try again!!!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        hidePreloader(); // Hide preloader
                        // Handle any errors
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                    }
                });
            });

            // Showmax SUBMIT BY JQUERY

            // SHOWMAX SUBMIT BY JQUERY
            $.ajax({
                url: 'https://vtpass.com/api/service-variations?serviceID=showmax',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    hidePreloader(); // Hide preloader
                    console.log(response);

                    if (response && response.content && response.content.varations) {
                        var variations = response.content.varations;

                        // Clear previous options
                        $('#selectBouquetShowmax').empty();

                        // Add default option
                        $('#selectBouquetShowmax').append(
                            '<option selected disabled value="">Please select type...</option>'
                        );

                        // Populate the dropdown
                        $.each(variations, function(index, variation) {
                            $('#selectBouquetShowmax').append(
                                $('<option></option>')
                                .val(variation.variation_code)
                                .text(variation.name)
                                .attr('data-amount', variation.variation_amount)
                            );
                        });

                        // Show the container after populating options
                        $('#selectBouquetContainershowmax').show();
                    } else {
                        alert('Failed to fetch Showmax bouquet variations. Please try again.');
                    }
                },
                error: function(error) {
                    hidePreloader();
                    console.error('Error fetching Showmax bouquet variations:', error);
                    alert('An error occurred while fetching data.');
                },
            });



            $('#submitShowmax').on('click', function(event) {
                event.preventDefault(); // Prevent the default button click action
                showPreloader(); // Show preloader

                var selectBouquet = $('[name="selectBouquetShowmax"]').val();
                var tel = $('[name="telShowmax"]').val();
                var _token = $('[name="_token"]').val();
                var amount = $('[name="amountShowmax"]').val();
                // Serialize the form data, including the CSRF token
                var formData = $('#showmaxForm').serialize();
                console.log(formData);

                $.ajax({
                    url: '/tv/bouquet/Showmax', // The route to your Laravel controller
                    method: 'POST',
                    data: {
                        _token: _token,
                        selectBouquet: selectBouquet,
                        tel: tel,
                        amount: amount
                    }, // Directly use the serialized form data
                    success: function(response) {
                        hidePreloader(); // Hide preloader
                        console.log(response);
                        // Handle the successful response
                        if (response.status === 'initiated') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message,
                                icon: "success",

                            }).then(() => {
                                // Redirect to the success page with a hash parameter
                                window.location.href = '/transactionview?hash=' +
                                    encodeURIComponent(response.result.requestId);
                            });

                            // Additional handling for success
                        } else if (response.status === 'failed') {
                            Swal.fire({
                                title: "Error, Please try again!!!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        hidePreloader(); // Hide preloader
                        // Handle any errors
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        $('#selectBouquetShowmax').off('change').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var amount = selectedOption.data('amount'); // Fetch the data-amount attribute
            $('#amountContainerShowmax').show();
            $('#amountShowmax').val(amount); // Update the input field
        });
    </script>

@endsection
