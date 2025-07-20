<div class="tab-pane fade" id="jamb" role="tabpanel">
    <div class="education-card">
        <form class="custom-validation" id="jambForm">
            @csrf

            <!-- Customer Information (Hidden by default) -->
            <div class="mb-4">
                <label for="jamb_variation" class="form-label">Service Type</label>
                <select class="form-select form-control" id="jamb_variation" name="examType" required>
                    <option selected disabled value="">Select service type...</option>

                </select>
            </div>

            <!-- Profile ID input field (will be shown after variation is selected) -->
            <div class="mb-4" id="profileIdContainer" style="display:none">
                <label for="jamb_profile_id" class="form-label">JAMB Profile ID</label>
                <div class="input-group">
                    <input type="text" class="form-control" id="jamb_profile_id" name="profile_id"
                        placeholder="Enter your JAMB profile ID" required />
                    <button class="btn btn-primary submit-button" type="button" id="checkJambProfile">
                        <span class="material-icons-round me-1">search</span>
                        Verify
                    </button>
                </div>
                <small class="text-muted">Enter your JAMB profile ID to verify your details</small>
            </div>

            <div class="hideInnerForm" id="jambInnerForm" style="display:none">
                <div class="customer-info-card mb-4">
                    <h5 class="p-3 border-bottom">Profile Information</h5>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Name</span>
                        <span class="text-gray-800 fw-bold" id="jambCustomerName"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Profile ID</span>
                        <span class="text-gray-800" id="jambProfileId"></span>
                    </div>
                </div>


                <div class="mb-4">
                    <label for="jamb_amount" class="form-label">Amount</label>
                    <div class="position-relative">
                        <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                        <input type="text" class="form-control ps-4" id="jamb_amount" name="amount" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="jamb_phone" class="form-label">Phone Number</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="jamb_phone" name="phoneNumber"
                            placeholder="Enter recipient phone number" required />
                        <span class="validation-icon material-icons-round">phone</span>
                    </div>
                    <small class="text-muted">You'll receive a confirmation on this number</small>
                </div>

                <div class="mb-3">
                    <button type="submit" class="submit-button" id="jambSubmit">
                        <span class="material-icons-round me-2">shopping_cart</span>
                        Purchase PIN
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
