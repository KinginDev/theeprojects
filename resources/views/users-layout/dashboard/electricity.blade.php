@extends('users-layout.dashboard.layouts.app')

@section('title', 'Electricity Page')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Buy Electricity</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Electricity</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="col-md-8 col-sm-12">
                        <form class="custom-validation" id="electricityForm">
                            @csrf

                            <div class="mb-3">
                                <label for="distributionCompany" class="form-label">Select your DISCO</label>
                                <select class="form-select p-12" id="distributionCompany" name="distribution_company"
                                    required>
                                    <option selected disabled value="">Select cable provider...</option>
                                    <option class="d-flex" value="ikeja-electric"> Ikeja Electric Payment - IKEDC</option>
                                    <option class="d-flex" value="eko-electric"> Eko Electric Payment - EKEDC</option>
                                    <option class="d-flex" value="abuja-electric"> Abuja Electricity Distribution Company-
                                        AEDC</option>
                                    <option class="d-flex" value="kano-electric"> KEDCO - Kano Electric</option>
                                    <option class="d-flex" value="portharcourt-electric"> PHED - Port Harcourt Electric
                                    </option>
                                    <option class="d-flex" value="jos-electric"> Jos Electric - JED</option>
                                    <option class="d-flex" value="kaduna-electric"> Kaduna Electric - KAEDCO</option>
                                    <option class="d-flex" value="enugu-electric"> Enugu Electric - EEDC</option>
                                    <option class="d-flex" value="ibadan-electric"> IBEDC - Ibadan Electricity Distribution
                                        Company</option>
                                    <option class="d-flex" value="benin-electric"> Benin Electricity - BEDC</option>
                                    <option class="d-flex" value="aba-electric"> Aba Electric Payment - ABEDC</option>
                                    <option class="d-flex" value="yola-electric"> Yola Electric Disco Payment - YEDC
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="meterType" class="form-label">Meter Type</label>
                                <select class="form-select p-12" id="meterType" name="type" required>
                                    <option selected disabled value="">Please select type...</option>
                                    <option class="d-flex" value="prepaid"> Prepaid</option>
                                    <option class="d-flex" value="postpaid"> Postpaid</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Meter number</label>
                                <input type="text" class="form-control p-12" required placeholder="Meter number"
                                    name="meter_number" id="meter_number" />
                            </div>
                            <div class="mb-3">
                                <button type="button" class="btn btn-primary w-100" id="checkBillcode">Continue</button>
                            </div>

                            <div class="hideInnerForm" style="display:none">
                                <div class="mb-3">
                                    <div class="card moni-card electricCard" style="display:none;">
                                        <div class="tran-items">
                                            <div class="d-flex tran-item">
                                                <p class="text-gray">Name</p>
                                                <p class="d-flex"><span class="ms-2" id="customerName">Nnaji
                                                        Christian</span></p>
                                            </div>
                                            <div class="d-flex tran-item">
                                                <p class="text-gray">Current Bouquet(s)</p>
                                                <p class="d-flex"><span class="ms-2" id="currentBouquet">GOTV Jolli
                                                        ₦2,800</span></p>
                                            </div>
                                            <div class="d-flex tran-item">
                                                <p class="text-gray">Due Date</p>
                                                <p class="d-flex"><span class="ms-2" id="dueDate">March 15th,
                                                        2024</span></p>
                                            </div>
                                            <div class="d-flex tran-item">
                                                <p class="text-gray">Renewal Amount</p>
                                                <p class="d-flex"><span class="ms-2" id="renewalAmount">₦3,863</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Phone number</label>
                                    <input type="text" class="form-control p-12" required
                                        placeholder="Recipient Phone number" name="tel" />
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>
                                    <div>
                                        <input type="email" class="form-control p-12" required parsley-type="email"
                                            placeholder="Recipient Email" name="email" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label>Amount</label>
                                    <div>
                                        <input type="number" class="form-control p-12" required parsley-type="amount"
                                            placeholder="Enter Amount" name="amount" />
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div>
                                        <button type="submit"
                                            class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                            id="submitForm">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </form>
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

    <!-- Preloader -->
    <div id="preloader" class="justify-content-center align-items-center" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
    <!-- End Preloader -->

    <script>
        $(document).ready(function() {
            // Show preloader before making the API call
            $('#checkBillcode').on('click', function(event) {
                event.preventDefault();

                var billerCode = $('#meter_number').val();
                var meterType = $('#meterType').val();
                var distributionCompany = $('#distributionCompany').val();

                if (!billerCode || !meterType || !distributionCompany) {
                    Swal.fire({
                        title: "Error",
                        text: "Please fill in all required fields.",
                        icon: "error"
                    });
                    return;
                }

                // Show preloader
                $('#preloader').css('display', 'flex');

                $.ajax({
                    url: '/tv/billcode/electricity',
                    method: 'POST',
                    data: {
                        billerCode: billerCode,
                        meterType: meterType,
                        distributionCompany: distributionCompany,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        console.log(response.result);

                        // Ensure response.data exists
                        if (response && response.result) {
                            if (response.result.content.error) {
                                Swal.fire({
                                    title: "Error",
                                    text: response.message ||
                                        "Invalid Meter Number. Please check and Try Again",
                                    icon: "error"
                                });
                            } else {
                                $('#customerName').text(response.result.content
                                    .Customer_Name);
                                $('#currentBouquet').text(response.result.content.Address);
                                $('#dueDate').text(response.result.content
                                    .Customer_District);
                                $('#renewalAmount').text(response.result.content
                                    .Meter_Number);

                                // Show the inner form and card
                                $('.hideInnerForm').css("display", "block");
                                $('.electricCard').css("display", "block");

                            }

                        } else {
                            Swal.fire({
                                title: "Error",
                                text: response.message ||
                                    "Invalid response structure received.",
                                icon: "error"
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error: ' + error);
                        console.error('Status: ' + status);
                        console.error(xhr.responseText);
                        Swal.fire({
                            title: "An error occurred",
                            text: "Please try again.",
                            icon: "error"
                        });
                    },
                    complete: function() {
                        // Hide preloader after the response
                        $('#preloader').hide();
                    }
                });
            });

            // Handle form submission
            $('#submitForm').click(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Processing...",
                    html: "Please wait...",
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        // Show preloader before submission
                        $('#preloader').css('display', 'flex');
                        var formData = $('#electricityForm').serialize();
                        console.log(formData);

                        $.ajax({
                            url: '{{ route('electricity.purchase') }}',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                console.log(response);
                                if (response.status === 'delivered') {
                                    Swal.fire({
                                        title: "Success!!!",
                                        text: response.message,
                                        icon: "success"
                                    }).then(() => {
                                        window.location.href =
                                            '/success?hash=' +
                                            encodeURIComponent(
                                                response.result
                                                .requestId);
                                    });
                                } else if (response.status === 'failed') {
                                    Swal.fire({
                                        title: "Error, Please try again!!!",
                                        text: response.message,
                                        icon: "error"
                                    });
                                }
                            },
                            error: function(error) {
                                console.log(error);
                                Swal.fire({
                                    title: "An error occurred",
                                    text: "Please try again.",
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                // Hide preloader after form submission is complete
                                $('#preloader').hide();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
