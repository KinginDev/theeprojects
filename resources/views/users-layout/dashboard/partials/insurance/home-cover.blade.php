<div class="tab-pane fade" id="home-cover" role="tabpanel">
    <div class="insurance-card">
        <h5>Home Cover Insurance</h5>
        <p class="text-muted mb-4">Protect your home and belongings against damage, theft, and other unforeseen events.
        </p>

        <form id="homeCoverInsuranceForm" class="insurance-form">
            @csrf
            <div class="mb-3">
                <label for="homeCoverType" class="form-label">Coverage Type</label>
                <select class="form-select" id="homeCoverType" name="homeCoverType" required>
                    <option value="" disabled selected>Select coverage type</option>
                    <option value="building-only" data-amount3="25000">Building Only - ₦25,000</option>
                    <option value="contents-only" data-amount3="15000">Contents Only - ₦15,000</option>
                    <option value="building-contents" data-amount3="35000">Building & Contents - ₦35,000</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="ownerName" class="form-label">Property Owner Name</label>
                        <input type="text" class="form-control" id="ownerName" name="ownerName" required
                            placeholder="Enter Owner's Full Name" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="propertyAddress" class="form-label">Property Address</label>
                        <input type="text" class="form-control" id="propertyAddress" name="propertyAddress" required
                            placeholder="Enter Property Address" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="propertyState" class="form-label">State</label>
                        <select class="form-select" id="propertyState" name="propertyState" required>
                            <option value="" disabled selected>Select State</option>
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
                        <label for="propertyType" class="form-label">Property Type</label>
                        <select class="form-select" id="propertyType" name="propertyType" required>
                            <option value="" disabled selected>Select Property Type</option>
                            <option value="apartment">Apartment/Flat</option>
                            <option value="detached">Detached House</option>
                            <option value="semi-detached">Semi-Detached House</option>
                            <option value="bungalow">Bungalow</option>
                            <option value="duplex">Duplex</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="constructionYear" class="form-label">Year of Construction</label>
                        <input type="text" class="form-control" id="constructionYear" name="constructionYear"
                            required placeholder="Enter Construction Year" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="buildingMaterial" class="form-label">Building Material</label>
                        <select class="form-select" id="buildingMaterial" name="buildingMaterial" required>
                            <option value="" disabled selected>Select Main Building Material</option>
                            <option value="concrete">Concrete/Cement</option>
                            <option value="brick">Brick</option>
                            <option value="wood">Wood</option>
                            <option value="steel">Steel Frame</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phoneNumber3" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phoneNumber3" name="phoneNumber3" required
                            placeholder="Enter Phone Number" />
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="emailAddress3" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="emailAddress3" name="emailAddress3" required
                            placeholder="Enter Email Address" />
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="amount3" class="form-label">Amount</label>
                <input type="text" class="form-control" id="amount3" name="amount3" required
                    placeholder="Amount" readonly />
            </div>

            <button type="button" class="btn btn-org btn-lg w-100 mt-3 insurance-submit"
                data-form="homeCoverInsuranceForm">
                Continue to Purchase
            </button>
        </form>
    </div>
</div>
