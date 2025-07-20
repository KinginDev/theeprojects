<div class="tab-pane fade show active" id="waec" role="tabpanel">
    <div class="education-card">
        <form class="custom-validation" id="waecRegistrationForm">
            @csrf
            <div class="mb-3">
                <label for="waecTypeSelect" class="form-label">Action Type</label>
                <select class="form-select form-control" id="waecTypeSelect" name="waec_type" required>
                    <option selected disabled value="">Please select type...</option>
                    <option value="waec">WAEC Result Checker</option>
                    <option value="waec-registration">WAEC Pin Registration</option>
                </select>
            </div>
            <div class="hiddenInnerForm" id="waecRegInnerForm" style="display: none;">
                <div class="mb-3">
                    <label for="waecVariationSelect" class="form-label">Exam Type</label>
                    <select class="form-select form-control" id="waecVariationSelect" name="examType" required>
                        <option selected disabled value="">Please select exam type...</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="waec_reg_quantity" class="form-label">Quantity</label>
                    <div class="position-relative">
                        <input type="number" class="form-control" id="waec_reg_quantity" name="quantity" value="1"
                            min="1" required />
                        <span class="validation-icon material-icons-round">format_list_numbered</span>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="waec_reg_amount" class="form-label">Amount</label>
                    <div class="position-relative">
                        <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                        <input type="text" class="form-control ps-4" id="waec_reg_amount" name="amount" readonly>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="waec_reg_phone" class="form-label">Phone Number</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" id="waec_reg_phone" name="phoneNumber"
                            placeholder="Enter recipient phone number" required />
                        <span class="validation-icon material-icons-round">phone</span>
                    </div>
                    <small class="text-muted">You'll receive a confirmation on this number</small>
                </div>

                <div class="mb-3">
                    <button type="submit" class="submit-button" id="waecRegSubmit">
                        <span class="material-icons-round me-2">shopping_cart</span>
                        Purchase PIN
                    </button>
                </div>
            </div>
        </form>


        <form class="custom-validation" id="waecResultForm" style="display: none;">
            @csrf
            <div class="mb-3">
                <label for="waec_result_variation" class="form-label">Exam Type</label>
                <select class="form-select form-control" id="waec_result_variation" name="examType" required>
                    <option selected disabled value="">Please select exam type...</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="waec_result_quantity" class="form-label">Quantity</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="waec_result_quantity" name="quantity" value="1"
                        min="1" required />
                    <span class="validation-icon material-icons-round">format_list_numbered</span>
                </div>
            </div>

            <div class="mb-4">
                <label for="waec_result_amount" class="form-label">Amount</label>
                <div class="position-relative">
                    <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                    <input type="text" class="form-control ps-4" id="waec_result_amount" name="amount" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label for="waec_result_phone" class="form-label">Phone Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="waec_result_phone" name="phoneNumber"
                        placeholder="Enter recipient phone number" required />
                    <span class="validation-icon material-icons-round">phone</span>
                </div>
                <small class="text-muted">You'll receive a confirmation on this number</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="submit-button" id="waecResultSubmit">
                    <span class="material-icons-round me-2">shopping_cart</span>
                    Purchase Result Checker
                </button>
            </div>
        </form>

    </div>
</div>
