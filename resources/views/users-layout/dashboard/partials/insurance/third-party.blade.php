<div class="tab-pane fade show active" id="third-party" role="tabpanel">
    <div class="insurance-card">
        <h5>Third Party Motor Insurance - Universal Insurance</h5>
        <p class="text-muted mb-4">Protect yourself against third-party liabilities arising from vehicle accidents.</p>

        <form id="thirdPartyInsuranceForm" class="insurance-form">
            @csrf
            <div class="mb-3">
                <label for="ui_insure" class="form-label">Insurance Type</label>
                <select class="form-select" id="ui_insure" name="ui_insure" required>
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
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="state" class="form-label">State</label>
                        <select class="form-select" id="state" name="state" required>
                            <option value="" disabled selected>Select a state</option>
                            @foreach ($resultState['content'] as $state)
                                <option value="{{ $state['StateCode'] }}">
                                    {{ $state['StateName'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="lga" class="form-label">Local Government Area</label>
                        <select class="form-select" id="lga" name="lga" required>
                            <option value="" disabled selected>Select a Local Government Area</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="VehicleMakeCode" class="form-label">Vehicle Make</label>
                        <select class="form-select" id="VehicleMakeCode" name="VehicleMakeCode" required>
                            <option value="" disabled selected>Select a Vehicle Make</option>
                            @foreach ($resultBrand['content'] as $brand)
                                <option value="{{ $brand['VehicleMakeCode'] }}">
                                    {{ $brand['VehicleMakeName'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="model" class="form-label">Vehicle Model</label>
                        <select class="form-select" id="model" name="model" required>
                            <option value="" disabled selected>Select a Vehicle Model</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="VehicleColor" class="form-label">Vehicle Color</label>
                        <select class="form-select" id="VehicleColor" name="VehicleColor" required>
                            <option value="" disabled selected>Select a Vehicle Color</option>
                            @foreach ($resultColor['content'] as $color)
                                <option value="{{ $color['ColourCode'] }}">
                                    {{ $color['ColourName'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="InsuredName" class="form-label">Insured Name</label>
                        <input type="text" class="form-control" id="InsuredName" name="InsuredName" required
                            placeholder="Enter Insured Name" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ChassisNumber" class="form-label">Chassis Number</label>
                        <input type="text" class="form-control" id="ChassisNumber" name="ChassisNumber" required
                            placeholder="Enter Chassis Number" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="PlateNumber" class="form-label">Plate Number</label>
                        <input type="text" class="form-control" id="PlateNumber" name="PlateNumber" required
                            placeholder="Enter Plate Number" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="YearofMake" class="form-label">Year of Make</label>
                        <input type="text" class="form-control" id="YearofMake" name="YearofMake" required
                            placeholder="Enter Year of Make" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phoneNumber" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" required
                            placeholder="Enter Phone Number" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="EmailAddress" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="EmailAddress" name="EmailAddress" required
                            placeholder="Enter Email Address" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount" required
                            placeholder="Amount" readonly />
                    </div>
                </div>
            </div>

            <button type="button" class="btn submit-button btn-lg w-100 mt-3 insurance-submit"
                data-form="thirdPartyInsuranceForm">
                Continue to Purchase
            </button>
        </form>
    </div>
</div>
