@extends('users-layout.dashboard.layouts.app')

@section('title', 'Data Page')

@section('content')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Buy Data</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Utility</a></li>
                                    <li class="breadcrumb-item active">Data page</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- Preloader -->
                <div id="preloader" class="justify-content-center align-items-center"
                    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                <!-- End Preloader -->

                <!-- Container to hold the main page elements-->
                <div class="container main-tags">
                    <div class="col-lg-8 col-md-12 col-sm-12">
                        <form class="custom-validation" id="dataForm">
                            @csrf
                            <div class="mb-3">
                                <label for="networkSelect" class="form-label">Select network</label>
                                <select class="form-select p-12" id="networkSelect" required name="network">
                                    <option selected disabled value="">Choose network...</option>
                                    @php
                                        $uniqueNetworks = [];
                                    @endphp
                                    @foreach ($networks as $networkType => $plans)
                                        @foreach ($plans as $plan)
                                            @if (!isset($uniqueNetworks[$plan['network']]))
                                                @php
                                                    $uniqueNetworks[$plan['network']] = $plan['plan_network'];
                                                @endphp
                                            @endif
                                        @endforeach
                                    @endforeach

                                    @foreach ($uniqueNetworks as $networkId => $networkName)
                                        <option value="{{ $networkId }}">{{ $networkName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="dataTypeSelect" class="form-label">Select data type</label>
                                <select class="form-select p-12" id="dataTypeSelect" required name="networkType">
                                    <option selected disabled value="">Choose data type...</option>
                                    @foreach ($data_type as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3" id="typeSelectContainer" style="display:none">
                                <label for="serviceVariation" class="form-label">Data bundle</label>
                                <select class="form-select p-12" id="serviceVariation" name="type">
                                    <option selected disabled value="">Data bundle...</option>
                                </select>
                            </div>

                            <div class="mb-3" id="typeSelectContainer2" style="display:none">
                                <label for="serviceVariation" class="form-label">Select Plan</label>
                                <select class="form-select p-12" id="typeSelect" name="plan">
                                    <option selected disabled value="">Data bundle...</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Phone number</label>
                                <input type="number" class="form-control p-12" required
                                    placeholder="Recipient Phone number" name="tel" id="tel" />
                            </div>

                            <div class="mb-3">
                                <label>Amount</label>
                                <div>
                                    <input type="number" class="form-control p-12" required
                                        placeholder="Amount to Recharge" name="amount" id="amountInput" readonly />
                                </div>
                            </div>

                            <div class="mb-0">
                                <div>
                                    <button type="submit" class="btn btn-org w-100 mt-2 waves-effect waves-light p-12"
                                        id="submitForm">
                                        Continue
                                    </button>
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
    <!-- end main content-->

    <script>
        $(document).ready(function() {
            // Define the percentages for different user types
            var userPercentages = @json($percentages);

            // Create a mapping of services to their percentages
            var percentageMap = {};
            userPercentages.forEach(function(item) {
                percentageMap[item.service] = parseFloat(item.percent);
            });

            $('#networkSelect').change(function() {
                var network = $(this).val();
                var options;

                if (network === '1') { // MTN
                    options = ['SME', 'SME 2', 'GIFTING', 'CORPORATE GIFTING'];
                } else { // Other networks
                    options = ['GIFTING', 'CORPORATE GIFTING'];
                }

                // Clear previous options
                $('#dataTypeSelect').empty();

                // Add a default option
                $('#dataTypeSelect').append(
                    '<option selected disabled value="">Choose data type...</option>'
                );

                // Add new options
                options.forEach(function(option) {
                    $('#dataTypeSelect').append('<option value="' + option + '">' + option +
                        '</option>');
                });
            });

            $('#networkSelect, #dataTypeSelect').change(function() {
                var network = $('#networkSelect').val();
                var networkType = $('#dataTypeSelect').val();

                if (network && networkType) {
                    $('#preloader').css('display', 'flex'); // Show preloader
                    console.log(network + " " + networkType);

                    if ((network == 1 && networkType == 'GIFTING') || (network == 4 && networkType ==
                            'GIFTING')) {
                        $('#preloader').css('display', 'flex'); // Show preloader

                        $.ajax({
                            url: '/api/network/get/plans',
                            type: 'GET',
                            data: {
                                network: network,
                                networkType: networkType,
                                _token: $('meta[name="csrf-token"]').attr(
                                    'content') // Ensure CSRF token is correctly passed
                            },
                            success: function(response) {
                                console.log("Response:", response);

                                // Check for success and the presence of variations
                                if (
                                    response.status === "success" &&
                                    response.data &&
                                    response.data.content &&
                                    response.data.content.variations
                                ) {
                                    const variations = response.data.content.variations;
                                    const profitPercentage = response.profitPercentage ||
                                    0; // Default to 0 if undefined

                                    console.log("Variations:", variations);
                                    console.log("Profit Percentage:", profitPercentage);

                                    // Clear previous options
                                    $("#serviceVariation").empty();
                                    $("#typeSelect").empty();

                                    // Add default options
                                    $("#serviceVariation").append(
                                        '<option selected disabled value="">Select Data Bundle...</option>'
                                    );
                                    $("#typeSelect").append(
                                        '<option selected disabled value="">Select Data Type...</option>'
                                    );

                                    // Iterate through variations and process them
                                    variations.forEach((variation) => {
                                        let {
                                            name,
                                            variation_amount,
                                            variation_code
                                        } = variation;

                                        // Parse and calculate the final amount after deducting profit
                                        const amount = parseFloat(variation_amount
                                            .replace(/,/g, "")).toFixed(2);
                                        const profit = (profitPercentage / 100) *
                                        amount;
                                        const finalAmount = Math.ceil(amount - profit);

                                        // Update the name with the calculated final amount
                                        name = name.replace(
                                            /N(\d{1,3}(,\d{3})*|\d+)(\.?\d*)/, // Matches "N<amount>" format
                                            `N${finalAmount}` // Replace with the calculated amount
                                        );

                                        // Append the variation to the dropdown
                                        $("#serviceVariation").append(
                                            $("<option></option>")
                                            .val(variation_code)
                                            .text(name)
                                            .data("amount", finalAmount)
                                        );
                                    });

                                    // Enable the dropdowns and show the container
                                    $("#serviceVariation, #typeSelect").prop("disabled", false);
                                    $("#typeSelectContainer").show();
                                } else {
                                    // Handle errors gracefully
                                    Swal.fire({
                                        title: "Error!",
                                        text: "Failed, Selected network is down. Try again later.",
                                        icon: "error",
                                    });

                                    // Hide the dropdown container
                                    $("#typeSelectContainer").hide();
                                }
                            },



                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed, Selected network is down try again later.",
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                $('#preloader')
                                    .hide(); // Hide preloader after request completes
                            }
                        });
                    } else {
                        // Fetch the plans via AJAX
                        $.ajax({
                            url: '/api/network/plans',
                            type: 'GET',
                            dataType: 'json',
                            success: function(response) {
                                var NETWORK_PLAN = '';
                                switch (parseInt(network)) {
                                    case 1:
                                        NETWORK_PLAN = 'MTN_PLAN';
                                        break;
                                    case 2:
                                        NETWORK_PLAN = 'GLO_PLAN';
                                        break;
                                    case 4:
                                        NETWORK_PLAN = 'AIRTEL_PLAN';
                                        break;
                                    case 6:
                                        NETWORK_PLAN = '9MOBILE_PLAN';
                                        break;
                                    default:
                                        NETWORK_PLAN = 'UNKNOWN_PLAN';
                                        break;
                                }

                                if (NETWORK_PLAN !== 'UNKNOWN_PLAN' && response
                                    .hasOwnProperty(NETWORK_PLAN)) {
                                    var variations = response[NETWORK_PLAN];
                                    console.log(variations);

                                    // Filter variations based on network and plan_type
                                    var filteredVariations = variations.filter(
                                        function(variation) {
                                            return variation.network ==
                                                network && variation
                                                .plan_type == networkType;
                                        });

                                    // Clear previous options
                                    $('#serviceVariation').empty();
                                    $('#typeSelect').empty();

                                    // Add a default option
                                    $('#serviceVariation').append(
                                        '<option selected disabled value="">Data bundle...</option>'
                                    );
                                    $('#typeSelect').append(
                                        '<option selected disabled value="">Data bundle...</option>'
                                    );

                                    // Show the proper container and append options
                                    $.each(filteredVariations, function(index,
                                        variation) {
                                        var baseAmount = parseFloat(
                                            variation.plan_amount);
                                        var serviceKey = getServiceKey(
                                            network, networkType);
                                        var percentage = percentageMap[
                                            serviceKey] || 0;
                                        var finalAmount = baseAmount + (
                                            baseAmount * percentage /
                                            100);

                                        $('#serviceVariation').append(
                                            $('<option></option>')
                                            .val(variation
                                                .id
                                            ) // The value will be the plan's id
                                            .text(
                                                `${variation.plan} ${variation.plan_type} - ₦${Math.ceil(finalAmount)} ${variation.month_validate || ''}`
                                            ) // Properly formats the plan details
                                            .data('amount', Math.ceil(variation
                                                .plan_amount
                                            )) // Rounds to nearest whole number and stores it in data attribute
                                        );


                                    });

                                    $('#serviceVariation, #typeSelect').prop(
                                        'disabled', false);
                                    $('#typeSelectContainer').show();
                                }
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error!",
                                    text: "Failed, Selected network is down try again later.",
                                    icon: "error"
                                });
                            },
                            complete: function() {
                                $('#preloader')
                                    .hide(); // Hide preloader after request completes
                            }
                        });
                    }
                }

            });

            // Update the amount field based on selected plan
            $('#serviceVariation').change(function() {
                var selectedVariationId = $(this).val();

                if (selectedVariationId) {
                    var selectedOption = $(this).find('option:selected');
                    var selectedPlanAmount = selectedOption.data('amount');

                    $('#amountInput').val(
                        selectedPlanAmount); // Set amount based on the selected variation
                }
            });

            // Handle form submission
            $('#dataForm').submit(function(e) {
                e.preventDefault();

                $('#preloader').css('display', 'flex'); // Show preloader during form submission

                var formData = $(this).serialize(); // Serialize the form data
                var network = $("#networkSelect").val();
                var dataTypeSelect = $("#dataTypeSelect").val();


                console.log(formData);
                console.log(network);
                console.log(dataTypeSelect);

                var submitUrl = ((network == 1 && dataTypeSelect == "GIFTING") || (network ==
                        4 &&
                        dataTypeSelect == "GIFTING")) ?
                    '{{ route('data.purchase.mtn.airtel.data') }}' :
                    '{{ route('data.purchase') }}';

                $.ajax({
                    url: submitUrl,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        console.log(response);
                        if (response.status === 'delivered') {
                            Swal.fire({
                                title: "Success!",
                                html: response.message,
                                icon: "success",
                            }).then(() => {
                                window.location.href =
                                    '/transactionview?hash=' +
                                    encodeURIComponent(response.result
                                        .content.transactions.transactionId);
                            });
                        } else if (response.status === 'failed') {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error"
                            });
                        }
                    },
                    error: function(error) {
                        // Log the full error object for detailed debugging
                        console.error("Error object:", error);

                        // Build a detailed error message
                        let errorMessage = `
        <strong>Status:</strong> ${error.status || "N/A"}<br>
        <strong>Status Text:</strong> ${error.statusText || "N/A"}<br>
    `;

                        if (error.responseJSON) {
                            errorMessage += `
            <strong>Response JSON:</strong> ${JSON.stringify(error.responseJSON, null, 2)}<br>
        `;
                        }

                        if (error.responseText) {
                            errorMessage += `
            <strong>Response Text:</strong> ${error.responseText}<br>
        `;
                        }

                        // Show error details in Swal alert
                        Swal.fire({
                            title: "Error Details",
                            html: errorMessage, // Allows HTML content in Swal
                            icon: "error",
                            width: "600px", // Adjust width for better readability
                        });
                    },


                    complete: function() {
                        $('#preloader')
                            .hide(); // Hide preloader after submission completes
                    }
                });
            });

            function getServiceKey(network, type) {
                var serviceKeyMap = {
                    '1': 'MTN',
                    '2': 'GLO',
                    '4': 'Airtel',
                    '6': '9mobile'
                };

                var networkName = serviceKeyMap[network] || '';

                if (type === 'SME 2') {
                    type = 'SME2';
                }
                if (type === 'CORPORATE GIFTING') {
                    type = 'CORPORATE_GIFTING';
                }

                return networkName + '_' + type + '_Data';
            }
        });
    </script>
@endsection
