@extends('users-layout.dashboard.layouts.app')

@section('title', 'Insurance Page')

@section('content')

    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Insurance</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Insurance</a></li>
                                    <li class="breadcrumb-item active">Insurance page</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="col-md-8 col-sm-12">
                        <div class="card-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light tab-s">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#home-1" role="tab">
                                        <span class="d-block">Third Party Insurance</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item waves-effect waves-light tab-s">
                                    <a class="nav-link" data-bs-toggle="tab" href="#healthInsuranceForm-1" role="tab">
                                        <span class="d-block">Personal Accident Insurance</span>
                                    </a>
                                </li> --}}
                                {{-- <li class="nav-item waves-effect waves-light tab-s">
                                    <a class="nav-link" data-bs-toggle="tab" href="#personal-1" role="tab">
                                        <span class="d-block">Home Cover Insurance</span>
                                    </a>
                                </li> --}}
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content text-muted">
                                <div class="tab-pane active mt-3" id="home-1" role="tabpanel">
                                    <form class="custom-validation" id="insuranceForm">
                                        @csrf
                                        <h5>Third Party Motor Insurance - Universal Insurance</h5>
                                        <p>Third Party Motor Insurance - Universal Insurance</p>

                                        <div class="mb-3">
                                            <label for="ui_insure" class="form-label">Insurance Type</label>
                                            <select class="form-select p-12" id="ui_insure" name="ui_insure" required>
                                                <option value="" disabled selected>Select an insurance type</option>
                                                @foreach ($resultui_insure['content']['varations'] as $variation)
                                                    <option value="{{ $variation['variation_code'] }}"
                                                        data-amount="{{ $variation['variation_amount'] }}">
                                                        {{ $variation['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="state" class="form-label">State</label>
                                                    <select class="form-select p-12" id="state" name="state" required>
                                                        <option value="" disabled selected>Select a state</option>
                                                        @foreach ($resultState['content'] as $state)
                                                            <option value="{{ $state['StateCode'] }}">
                                                                {{ $state['StateName'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="lga" class="form-label">Local Government Area</label>
                                                    <select class="form-select p-12" id="lga" name="lga" required>
                                                        <option value="" disabled selected>Select a Local Government Area</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="VehicleMakeCode" class="form-label">Vehicle Make</label>
                                                    <select class="form-select p-12" id="VehicleMakeCode"
                                                        name="VehicleMakeCode" required>
                                                        <option value="" disabled selected>Select a Vehicle Make</option>
                                                        @foreach ($resultBrand['content'] as $brand)
                                                            <option value="{{ $brand['VehicleMakeCode'] }}">
                                                                {{ $brand['VehicleMakeName'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="model" class="form-label">Vehicle Model</label>
                                                    <select class="form-select p-12" id="model" name="model" required>
                                                        <option value="" disabled selected>Select a Vehicle Model</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="VehicleColor" class="form-label">Vehicle Color</label>
                                                    <select class="form-select p-12" id="VehicleColor" name="VehicleColor"
                                                        required>
                                                        <option value="" disabled selected>Select a Vehicle Color</option>
                                                        @foreach ($resultColor['content'] as $color)
                                                            <option value="{{ $color['ColourCode'] }}">
                                                                {{ $color['ColourName'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="InsuredName" class="form-label">Insured Name</label>
                                                    <input type="text" class="form-control p-12" id="InsuredName"
                                                        name="InsuredName" required placeholder="Enter Insured Name" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="ChassisNumber" class="form-label">Chassis Number</label>
                                                    <input type="text" class="form-control p-12" id="ChassisNumber"
                                                        name="ChassisNumber" required placeholder="Enter Chassis Number" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="PlateNumber" class="form-label">Plate Number</label>
                                                    <input type="text" class="form-control p-12" id="PlateNumber"
                                                        name="PlateNumber" required placeholder="Enter Plate Number" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="YearofMake" class="form-label">Year of Make</label>
                                                    <input type="text" class="form-control p-12" id="YearofMake"
                                                        name="YearofMake" required placeholder="Enter Year of Make" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="phoneNumber" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control p-12" id="phoneNumber"
                                                        name="phoneNumber" required placeholder="Enter Phone Number" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="EmailAddress" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control p-12" id="EmailAddress"
                                                        name="EmailAddress" required placeholder="Enter Email Address" />
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="mb-3">
                                                    <label for="amount" class="form-label">Amount</label>
                                                    <input type="text" class="form-control p-12" id="amount"
                                                        name="amount" required placeholder="Enter Amount" readonly />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-0">
                                            <button type="button" id="insuranceSubmitButton"
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

        <!-- Preloader -->
        <div id="preloader" class="justify-content-center align-items-center"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <!-- End Preloader -->

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Insurance Type:</strong> <span id="confirmInsuranceType"></span></p>
                        <p><strong>Phone Number:</strong> <span id="confirmPhoneNumber"></span></p>
                        <p><strong>Email Address:</strong> <span id="confirmEmail"></span></p>
                        <p><strong>Amount:</strong> <span id="confirmAmount"></span></p>
                        <!-- Additional fields can be added here as needed -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" id="confirmSubmitButton" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Confirmation Modal -->

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

    <script>
        $(document).ready(function () {
            // Preloader functions
            function showPreloader() {
                $('#preloader').css('display', 'flex');
            }

            function hidePreloader() {
                $('#preloader').hide();
            }

            // Function to update the total amount for the first form
            $('#ui_insure').on('change', function () {
                updateTotalAmount('#ui_insure', '#amount', 'data-amount');
            });

            // Function to update the total amount for the second form
            $('#healthInsurancePlan').on('change', function () {
                updateTotalAmount('#healthInsurancePlan', '#amount2', 'data-amount2');
            });

            function updateTotalAmount(selectElementId, amountElementId, dataAttribute) {
                var selectedOption = $(selectElementId).find('option:selected');
                var selectedAmount = parseFloat(selectedOption.attr(dataAttribute)) || 0;
                $(amountElementId).val(selectedAmount.toFixed(2));
            }

            // Show confirmation modal on submit button click
            $('#insuranceSubmitButton, #healthInsuranceSubmitButton').on('click', function () {
                var formId = this.id === 'insuranceSubmitButton' ? '#insuranceForm' : '#healthInsuranceForm';
                var formData = new FormData($(formId)[0]);

                $('#confirmInsuranceType').text($('#ui_insure option:selected').text());
                $('#confirmPhoneNumber').text(formData.get('phoneNumber') || formData.get('phoneNumber2'));
                $('#confirmEmail').text(formData.get('EmailAddress') || formData.get('emailAddress2'));
                $('#confirmAmount').text('₦' + (formData.get('amount') || formData.get('amount2')));

                $('#confirmationModal').modal('show');
            });

            // Handle the submission of the form after confirmation
            $('#confirmSubmitButton').on('click', function () {
                var formId = $('#insuranceSubmitButton').is(':visible') ? '#insuranceForm' : '#healthInsuranceForm';
                $(formId).submit();
                $('#confirmationModal').modal('hide');
            });

            // Function to handle form submission with preloader
            function handleFormSubmission(formId, url) {
                $(formId).on('submit', function (event) {
                    event.preventDefault();
                    showPreloader();

                    var formData = new FormData(this);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            Swal.fire({
                                title: "Success",
                                text: "Your transaction was successful!",
                                icon: "success"
                            }).then(() => {
                                window.location.href = '/success?hash=' + encodeURIComponent(response.result.requestId);
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
                        },
                        complete: function () {
                            hidePreloader();
                        }
                    });
                });
            }

            // Handle form submissions
            handleFormSubmission('#insuranceForm', '/insurance/ui_insure');
            handleFormSubmission('#healthInsuranceForm', '/insurance/healthInsurance');

            // Update LGA dropdown based on state selection
            $('#state').on('change', function () {
                var stateCode = $(this).val();
                updateLgaDropdown(stateCode, '#lga');
            });

            function updateLgaDropdown(stateCode, lgaElementId) {
                if (stateCode) {
                    showPreloader();
                    $.ajax({
                        url: 'https://api-service.vtpass.com/api/universal-insurance/options/lga/' + stateCode,
                        type: 'GET',
                        success: function (response) {
                            var lgOptions = '<option value="" disabled selected>Select an LGA</option>';
                            if (response.data.content.original) {
                                $.each(response.data.content.original, function (index, lga) {
                                    lgOptions += '<option value="' + lga.LGACode + '">' + lga.LGAName + '</option>';
                                });
                            }
                            $(lgaElementId).html(lgOptions);
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                        },
                        complete: function () {
                            hidePreloader();
                        }
                    });
                }
            }

            // Update Vehicle Model dropdown based on Vehicle Make selection
            $('#VehicleMakeCode').on('change', function () {
                var vehicleMakeCode = $(this).val();
                updateVehicleModelDropdown(vehicleMakeCode, '#model');
            });

            function updateVehicleModelDropdown(vehicleMakeCode, modelElementId) {
                if (vehicleMakeCode) {
                    showPreloader();
                    $.ajax({
                        url: 'https://vtpass.com/api/universal-insurance/options/model/' + vehicleMakeCode,
                        type: 'GET',
                        success: function (response) {
                            var modelOptions = '<option value="" disabled selected>Select a Vehicle Model</option>';
                            if (response.content) {
                                $.each(response.content, function (index, model) {
                                    modelOptions += '<option value="' + model.VehicleModelCode + '">' + model.VehicleModelName + '</option>';
                                });
                            }
                            $(modelElementId).html(modelOptions);
                        },
                        error: function (xhr, status, error) {
                            console.error('AJAX Error:', status, error);
                        },
                        complete: function () {
                            hidePreloader();
                        }
                    });
                }
            }
        });
    </script>
@endsection
