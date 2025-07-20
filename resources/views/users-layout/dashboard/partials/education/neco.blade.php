<div class="tab-pane fade" id="neco" role="tabpanel">
    <div class="education-card">
        <form class="custom-validation" id="necoForm">
            @csrf
            <div class="mb-3">
                <label for="neco_variation" class="form-label">Service Type</label>
                <select class="form-select form-control" id="neco_variation" name="examType" required>
                    <option selected disabled value="">Select service type...</option>
                    <option value="neco_reg" data-amount="12000.00">NECO Registration PIN</option>
                    <option value="neco_result" data-amount="1000.00">NECO Result Checker</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="neco_quantity" class="form-label">Quantity</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="neco_quantity" name="quantity" value="1"
                        min="1" required />
                    <span class="validation-icon material-icons-round">format_list_numbered</span>
                </div>
            </div>

            <div class="mb-4">
                <label for="neco_amount" class="form-label">Amount</label>
                <div class="position-relative">
                    <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                    <input type="text" class="form-control ps-4" id="neco_amount" name="amount" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label for="neco_phone" class="form-label">Phone Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="neco_phone" name="phoneNumber"
                        placeholder="Enter recipient phone number" required />
                    <span class="validation-icon material-icons-round">phone</span>
                </div>
                <small class="text-muted">You'll receive a confirmation on this number</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="submit-button" id="necoSubmit">
                    <span class="material-icons-round me-2">shopping_cart</span>
                    Purchase PIN
                </button>
            </div>
        </form>
    </div>
</div>
