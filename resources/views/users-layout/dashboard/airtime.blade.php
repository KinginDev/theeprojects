@extends('users-layout.dashboard.layouts.app')

@section('title', 'Airtime Page')

@section('content')

<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<form class="custom-validation" id="airtimeForm">
    @csrf
    <div class="main-content" id="isSubmitForm">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Buy Airtime</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Airtime page</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->

                <div class="container main-tags">

                    <div class="col-lg-8 col-md-12 col-sm-12">

                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12"></div>
                        </div>
                        <div class="mb-3">
                            <label for="validationCustom03" class="form-label">Select Network</label>
                            <select class="form-select p-12" id="validationCustom03" required name="network">
                                <option selected disabled value="">Choose network...</option>
                                <option class="d-flex" value="mtn"> MTN </option>
                                <option class="d-flex" value="airtel"> Airtel</option>
                                <option class="d-flex" value="glo"> Glo </option>
                                <option class="d-flex" value="etisalat"> 9Mobile</option>
                            </select>

                        </div>
                        <div class="mb-3">
                            <label>Phone number</label>
                            <input type="text" class="form-control p-12" required
                                placeholder="Recipient Phone number" name="tel" id="tel" />
                        </div>

                        <div class="mb-3">
                            <label>Amount</label>
                            <div>
                                <input type="number" class="form-control p-12" required parsley-type="amount"
                                    placeholder="Amount to Recharge" name="amount" id="amount" />
                            </div>
                        </div>

                        <div class="mb-0">
                            <div>
                                <button type="button" class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                    id="showTransaction">
                                    Continue
                                </button>

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



    <div class="main-content" id="transactions" style="display:none">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Transaction View</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Transaction view</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->

                <div class="container main-tags">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="h6">
                                Please Confirm your Transaction Details are as Follows:
                            </div> <br>

                            <div class="card moni-card">
                                <div class="tran-items">

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Product Name</p>
                                        <p class="d-flex"> <span class="ms-2" id="networkTransaction">Airtel
                                                Airtime</span></p>
                                    </div>

                                    <div class="d-flex tran-item">
                                        <p class="text-gray">Phone number</p>
                                        <p class="d-flex"> <span class="ms-2"
                                                id="phoneNumberTransaction">09021233422</span></p>
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
</form>
<!-- end main content-->

<!-- Preloader -->
<div id="preloader" class="justify-content-center align-items-center" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<!-- End Preloader -->

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to show the SweetAlert2 alert
        function showAutoCloseAlert() {
            Swal.fire({
                title: "Processing...",
                html: "Please wait for the process to finish...",
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const timer = Swal.getPopup().querySelector("b");
                    timerInterval = setInterval(() => {
                        timer.textContent = `${Swal.getTimerLeft()}`;
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                }
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log("I was closed by the timer");
                }
            });
        }

        // Function to validate form inputs
        function validateForm() {
            var isValid = true;
            $('#airtimeForm input[required]').each(function () {
                if ($(this).val() === '') {
                    isValid = false;
                    return false;
                }
            });
            return isValid;
        }

        // Function to populate transaction details
        function populateTransactionDetails() {
            $('#transactions').show(); // Show transaction details section
            $('#isSubmitForm').hide(); // Show transaction details section

            // Get form inputs
            var network = $('#validationCustom03 option:selected').text();
            var phoneNumber = $('#tel').val();
            var amount = $('#amount').val();

            // Populate transaction details with form inputs
            $('#networkTransaction').text(network);
            $('#phoneNumberTransaction').text(phoneNumber);
            $('#amountTransaction').text('₦' + amount);
        }

        // Handle click event for showing transaction details
        $('#showTransaction').click(function (e) {
            e.preventDefault();
            if (validateForm()) {
                populateTransactionDetails();
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill all required fields.",
                    icon: "error"
                });
            }
        });

        // Handle form submission
        $('#submitForm').click(function (e) {
            e.preventDefault();
            if (validateForm()) {
                $('#preloader').css('display', 'flex'); // Show preloader
                var formData = $('#airtimeForm').serialize();
                $.ajax({
                    url: '{{ route('airtime.purchase') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        console.log(response);
                        if (response.status === 'delivered') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message +
                                    '<br><br><a href="{{ route('airtime') }}" class="btn btn-primary">Return To Airtime Page</a>',
                                icon: "success",
                                showConfirmButton: false // Hide the default OK button
                            });
                        } else if (response.status === 'failed') {
                            if(response.result.code == "018") { // Low wallet balance
                                Swal.fire({
                                    title: "Error!",
                                    text: "Insufficient balance. Please fund your account.",
                                    icon: "error"
                                });
                            } else {
                                Swal.fire({
                                    title: "Error!",
                                    text: response.message,
                                    icon: "error"
                                });
                            }
                        }
                    },
                    error: function (xhr, status, error) {
                        // Log the complete error response in the console
                        console.log('XHR:', xhr);
                        console.log('Status:', status);
                        console.log('Error:', error);
                        Swal.fire({
                            title: "Error!",
                            text: "Failed to submit form data. Please try again.",
                            icon: "error"
                        });
                    },
                    complete: function () {
                        $('#preloader').hide(); // Hide preloader after form submission is complete
                    }
                });
            } else {
                Swal.fire({
                    title: "Error!",
                    text: "Please fill all required fields.",
                    icon: "error"
                });
            }
        });
    });
</script>

@endsection
