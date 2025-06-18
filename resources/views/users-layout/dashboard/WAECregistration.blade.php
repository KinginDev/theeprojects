@extends('users-layout.dashboard.layouts.app')

@section('title', 'Education Page')

@section('content')
@php
        $configuration = \App\Models\Setting::first(); // Adjust the model path if necessary
    @endphp
    <!-- Preloader -->
    <div id="preloader">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- End Preloader -->

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- Start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Education</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Education</a></li>
                                    <li class="breadcrumb-item active">Education Page</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End page title -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="col-md-8 col-sm-12">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tabpanel">
                                <li class="nav-item waves-effect waves-light tab-s">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                        <span class="d-block">WAEC Result Checking PIN / Scratch Card</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item waves-effect waves-light tab-s">
                                    <a class="nav-link" data-bs-toggle="tab" href="#profile-1" role="tab">
                                        <span class="d-block"></span>
                                    </a>
                                </li> --}}

                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content text-muted">


                                <div class="tabpanel mt-3" id="home" role="tabpanel">
                                    <form class="custom-validation" id="checkWaecCheckingDetails">
                                        <div class="mb-3">
                                            <label for="waec_variation2" class="form-label">Exam Type</label>
                                            <select class="form-control" name="waec_variation2" id="waec_variation2"
                                                required>
                                                <option value="" disabled selected>Please Select Examtype</option>
                                                @foreach ($resultSandbox['content']['varations'] as $variation)
                                                    <option value="{{ $variation['variation_code'] }}"
                                                        data-amount2="{{ $variation['variation_amount'] }}">
                                                        {{ $variation['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="swap-flight text-center">
                                            <i class="ri-swap-fill"></i>
                                        </div>

                                        <div class="mb-3">
                                            <label for="quantity2" class="form-label">Quantity</label>
                                            <input type="number" class="form-control p-12 mt-3" id="quantity2"
                                                name="quantity2" required placeholder="Quantity" value="1"
                                                min="1" />
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="amount2" class="form-label">Amount</label>
                                                    <input type="text" class="form-control p-12" id="amount2"
                                                        name="amount2" required readonly />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="phone_number2" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control p-12" id="phone_number2"
                                                        name="phone_number2" required placeholder="Phone number" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <button type="submit"
                                                class="btn btn-org w-100 mt-2 waves-effect waves-light p-12">
                                                Continue
                                            </button>
                                        </div>
                                    </form>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container to hold the main page elements ends here-->
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->

        <div class="container main-tags">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="h6">
                        Please Confirm your Transaction Details are as Follows:
                    </div> <br>

                    <div class="card moni-card" id="confirmationSection" style="display: none;">
                        <div class="tran-items">
                            <!-- Placeholder for dynamically added customer name -->
                            <div id="customerNameContainer"></div>

                            <div class="d-flex tran-item">
                                <p class="text-gray">Product Name</p>
                                <p class="d-flex"> <img src="/assets/images/brands/waec.png" width="20"
                                        alt=""> <span class="ms-2" id="networkTransaction">Airtel
                                        Airtime</span></p>
                            </div>

                            <div class="d-flex tran-item">
                                <p class="text-gray">Phone number</p>
                                <p class="d-flex"> <span class="ms-2" id="phoneNumberTransaction">09021233422</span>
                                </p>
                            </div>

                            <div class="d-flex tran-item">
                                <p class="text-gray">Amount</p>
                                <p class="d-flex"> <span class="ms-2" id="amountTransaction">₦2000</span> </p>
                            </div>


                            <div class="d-flex tran-item">
                                <p class="text-gray">Transaction Fee</p>
                                <p class="d-flex"> <span class="ms-2">₦0</span> </p>
                            </div>

                            <div class="d-flex tran-item">
                                <p class="text-gray">Transaction ID </p>
                                <p class="d-flex"> <span class="ms-2">45678987654324562</span></p>
                            </div>

                            <div class="d-flex tran-item">
                                <p class="text-gray">Status</p>
                                <p class="d-flex"> <span class="ms-2">Initiated</span></p>
                            </div>
                        </div>
                        <button class="btn p-12 btn-org" id="submitForm"> Confirm</button>
                    </div>
                </div>
            </div>
        </div>

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

    <!-- CSS for Preloader -->
    <style>
        #preloader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: rgba(255, 255, 255, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>

    <script>
        // Event listener for changes in the variation selection for the first form
        document.getElementById('waec_variation').addEventListener('change', function () {
            updateTotalAmount1();
        });

        // Event listener for changes in the quantity input for the first form
        document.getElementById('quantity').addEventListener('input', function () {
            updateTotalAmount1();
        });

        // Function to update the total amount for the first form
        function updateTotalAmount1() {
            var selectedOption = document.getElementById('waec_variation').selectedOptions[0];
            var selectedAmount = parseFloat(selectedOption.getAttribute('data-amount')) || 0;
            var quantity = parseInt(document.getElementById('quantity').value) || 1;
            var totalAmount = selectedAmount * quantity;
            document.getElementById('amount').value = totalAmount.toFixed(2);
        }
    </script>

    <script>
        // Event listener for changes in the variation selection for the second form
        document.getElementById('waec_variation2').addEventListener('change', function () {
            updateTotalAmount2();
        });

        // Event listener for changes in the quantity input for the second form
        document.getElementById('quantity2').addEventListener('input', function () {
            updateTotalAmount2();
        });

        // Function to update the total amount for the second form
        function updateTotalAmount2() {
            var selectedOption = document.getElementById('waec_variation2').selectedOptions[0];
            var selectedAmount = parseFloat(selectedOption.getAttribute('data-amount2')) || 0;
            var quantity = parseInt(document.getElementById('quantity2').value) || 1;
            var totalAmount = selectedAmount * quantity;
            document.getElementById('amount2').value = totalAmount.toFixed(2);
        }
    </script>

    <script>
        // Event listener for changes in the variation selection for the second form
        document.getElementById('jamb_variation3').addEventListener('change', function () {
            updateTotalAmount3();
        });

        // Function to update the total amount for the second form
        function updateTotalAmount3() {
            var selectedOption = document.getElementById('jamb_variation3').selectedOptions[0];
            var selectedAmount = parseFloat(selectedOption.getAttribute('data-amount3')) || 0;
            var totalAmount = selectedAmount;
            document.getElementById('amount3').value = totalAmount.toFixed(2);
        }
    </script>

    <script>
        $(document).ready(function () {
            // Hide the preloader when the page is fully loaded
            $(window).on('load', function () {
                $('#preloader').fadeOut('slow', function () {
                    $(this).remove();
                });
            });

            // Handle the form submission for the first form
            $('#checkWaecDetails').on('submit', function (event) {
                event.preventDefault();

                var examType = $('#waec_variation').val();
                var quantity = $('#quantity').val();
                var phoneNumber = $('#phone_number').val();
                var amount = $('#amount').val();

                // Validate fields
                if (!examType || !quantity || !phoneNumber || !amount) {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill in all required fields.",
                        icon: "error"
                    });
                    return;
                }

                // Hide the form and show the confirmation section
                $(this).hide();
                $('#confirmationSection').show();

                // Set values in the confirmation section
                $('#networkTransaction').text('WAEC ' + $('#waec_variation option:selected').text());
                $('#phoneNumberTransaction').text(phoneNumber);
                $('#amountTransaction').text('₦' + parseFloat(amount).toFixed(2));

                // Handle the confirm button click for this form
                $('#submitForm').on('click', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: '/waec/check-details', // Ensure this URL is correct
                        method: 'POST',
                        data: {
                            examType: examType,
                            quantity: quantity,
                            phoneNumber: phoneNumber,
                            amount: amount,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log(response.result.requestId);
                            Swal.fire({
                                title: "Success",
                                text: "Your transaction was successful!",
                                icon: "success"
                            }).then(() => {
                                window.location.href = '/success?hash=' +
                                    encodeURIComponent(response.result
                                        .requestId);
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("Error Details:", {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText,
                                error: error
                            });
                            Swal.fire({
                                title: "Error",
                                text: "There was an issue processing your request.",
                                icon: "error"
                            });
                        }
                    });
                });
            });

            // Handle the form submission for the second form (if applicable)
            $('#checkWaecCheckingDetails').on('submit', function (event) {
                event.preventDefault();

                var examType = $('#waec_variation2').val();
                var quantity = $('#quantity2').val();
                var phoneNumber = $('#phone_number2').val();
                var amount = $('#amount2').val();

                // Validate fields
                if (!examType || !quantity || !phoneNumber || !amount) {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill in all required fields.",
                        icon: "error"
                    });
                    return;
                }

                // Hide the form and show the confirmation section
                $(this).hide();
                $('#confirmationSection').show();

                // Set values in the confirmation section
                $('#networkTransaction').text('WAEC ' + $('#waec_variation2 option:selected').text());
                $('#phoneNumberTransaction').text(phoneNumber);
                $('#amountTransaction').text('₦' + parseFloat(amount).toFixed(2));

                // Handle the confirm button click for this form
                $('#submitForm').on('click', function (event) {
                    event.preventDefault();

                    $.ajax({
                        url: '/waec/check-result', // Ensure this URL is correct
                        method: 'POST',
                        data: {
                            examType: examType,
                            quantity: quantity,
                            phoneNumber: phoneNumber,
                            amount: amount,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            console.log(response);
                            Swal.fire({
                                title: "Success",
                                text: "Your transaction was successful!",
                                icon: "success"
                            }).then(() => {
                                window.location.href = '/success?hash=' +
                                    encodeURIComponent(response.result
                                        .requestId);
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("Error Details:", {
                                status: xhr.status,
                                statusText: xhr.statusText,
                                responseText: xhr.responseText,
                                error: error
                            });
                            Swal.fire({
                                title: "Error",
                                text: "There was an issue processing your request.",
                                icon: "error"
                            });
                        }
                    });
                });
            });

            // Handle the form submission for the second form (if applicable)
            $('#checkJambCheckingDetails').on('submit', function (event) {
                event.preventDefault();

                var examType = $('#jamb_variation3').val();
                var billcode = $('#billcode').val(); // This is the Profile ID
                var phoneNumber = $('#phone_number3').val();
                var amount = $('#amount3').val();

                console.log(examType, billcode, phoneNumber, amount);

                // Validate fields
                if (!examType || !billcode || !phoneNumber || !amount) {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill in all required fields.",
                        icon: "error"
                    });
                    return;
                }

                // Verify Profile ID before proceeding
                $.ajax({
                    url: '/jamb/verify', // Use the correct endpoint for production
                    method: 'POST',
                    data: {
                        billcode: billcode, // Profile ID
                        serviceID: 'jamb', // Service ID
                        type: examType, // Variation code
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {
                        console.log(response);
                        if (response.result.code === "000") {
                            // Profile ID is valid, proceed to show confirmation section

                            // Hide the form and show the confirmation section
                            $('#checkJambCheckingDetails').hide();
                            $('#confirmationSection').show();

                            // Set values in the confirmation section
                            $('#networkTransaction').text('jamb ' + $(
                                '#jamb_variation3 option:selected').text());
                            $('#phoneNumberTransaction').text(phoneNumber);
                            $('#amountTransaction').text('₦' + parseFloat(amount).toFixed(2));


                            // Dynamically create the customer name div
                            var customerNameDiv = `
        <div class="d-flex tran-item">
            <p class="text-gray">Customer Name</p>
            <p class="d-flex"> <span class="ms-2" id="customerNameTransaction">` + response.result.content
                                .Customer_Name + `</span></p>
        </div>
    `;

                            // Append the customer name div to the confirmation section
                            $('#customerNameContainer').html(customerNameDiv);

                            // Handle the confirm button click for this form
                            $('#submitForm').on('click', function (event) {
                                event.preventDefault();

                                $.ajax({
                                    url: '/jamb/register', // Ensure this URL is correct
                                    method: 'POST',
                                    data: {
                                        examType: examType,
                                        billcode: billcode,
                                        phoneNumber: phoneNumber,
                                        amount: amount,
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        Swal.fire({
                                            title: "Success",
                                            text: "Your transaction was successful!",
                                            icon: "success"
                                        }).then(() => {
                                            window.location.href =
                                                '/success?hash=' +
                                                encodeURIComponent(
                                                    response.result
                                                    .requestId);
                                        });
                                    },
                                    error: function (xhr, status, error) {
                                        console.error("Error Details:", {
                                            status: xhr.status,
                                            statusText: xhr
                                                .statusText,
                                            responseText: xhr
                                                .responseText,
                                            error: error
                                        });
                                        Swal.fire({
                                            title: "Error",
                                            text: "There was an issue processing your request.",
                                            icon: "error"
                                        });
                                    }
                                });
                            });
                        } else {
                            // Profile ID is invalid, show an error
                            Swal.fire({
                                title: "Error",
                                text: "Invalid Profile ID. Please check and try again.",
                                icon: "error"
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error Details:", {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        Swal.fire({
                            title: "Error",
                            text: "There was an issue verifying the Profile ID.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
@endsection
