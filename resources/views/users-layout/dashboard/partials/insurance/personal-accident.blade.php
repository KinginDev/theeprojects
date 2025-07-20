<div class="tab-pane fade" id="personal-accident" role="tabpanel">
    <div class="insurance-card">
        <h5>Personal Accident Insurance</h5>
        <p class="text-muted mb-4">Get coverage for accidental injuries and related expenses, providing financial
            protection 24/7.</p>

        <form id="personalAccidentInsuranceForm" class="insurance-form">
            @csrf
            <div class="mb-3">
                <label for="healthInsurancePlan" class="form-label">Insurance Plan</label>
                <select class="form-select" id="healthInsurancePlan" name="healthInsurancePlan" required>
                    <option value="" disabled selected>Select an insurance plan</option>
                    <option value="individual-plan" data-amount2="15000">Individual Plan - ₦15,000</option>
                    <option value="family-plan" data-amount2="35000">Family Plan - ₦35,000</option>
                    <option value="senior-plan" data-amount2="20000">Senior Citizen Plan - ₦20,000</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" name="fullName" required
                            placeholder="Enter Full Name" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="occupation" class="form-label">Occupation</label>
                        <input type="text" class="form-control" id="occupation" name="occupation" required
                            placeholder="Enter Occupation" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required
                            placeholder="Enter Address" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="nationality" class="form-label">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" required
                            placeholder="Enter Nationality" value="Nigerian" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phoneNumber2" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber2" name="phoneNumber2" required
                            placeholder="Enter Phone Number" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="emailAddress2" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailAddress2" name="emailAddress2" required
                            placeholder="Enter Email Address" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="beneficiaryName" class="form-label">Beneficiary Name</label>
                        <input type="text" class="form-control" id="beneficiaryName" name="beneficiaryName"
                            required placeholder="Enter Beneficiary Name" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="beneficiaryRelationship" class="form-label">Relationship with Beneficiary</label>
                        <input type="text" class="form-control" id="beneficiaryRelationship"
                            name="beneficiaryRelationship" required placeholder="Enter Relationship" />
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="amount2" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount2" name="amount2" required
                    placeholder="Amount" readonly />
            </div>

            <button type="button" class="btn btn-org btn-lg w-100 mt-3 insurance-submit"
                data-form="personalAccidentInsuranceForm">
                Continue to Purchase
            </button>
        </form>
    </div>
</div>
