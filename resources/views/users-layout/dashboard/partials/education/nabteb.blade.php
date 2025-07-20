<div class="tab-pane fade" id="nabteb" role="tabpanel">
    <div class="education-card">
        <form class="custom-validation" id="nabtebForm">
            @csrf
            <div class="mb-3">
                <label for="nabteb_variation" class="form-label">Service Type</label>
                <select class="form-select form-control" id="nabteb_variation" name="examType" required>
                    <option selected disabled value="">Select service type...</option>
                    <option value="nabteb_reg" data-amount="11000.00">NABTEB Registration PIN</option>
                    <option value="nabteb_result" data-amount="1000.00">NABTEB Result Checker</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="nabteb_quantity" class="form-label">Quantity</label>
                <div class="position-relative">
                    <input type="number" class="form-control" id="nabteb_quantity" name="quantity" value="1"
                        min="1" required />
                    <span class="validation-icon material-icons-round">format_list_numbered</span>
                </div>
            </div>

            <div class="mb-4">
                <label for="nabteb_amount" class="form-label">Amount</label>
                <div class="position-relative">
                    <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                    <input type="text" class="form-control ps-4" id="nabteb_amount" name="amount" readonly>
                </div>
            </div>

            <div class="mb-4">
                <label for="nabteb_phone" class="form-label">Phone Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" id="nabteb_phone" name="phoneNumber"
                        placeholder="Enter recipient phone number" required />
                    <span class="validation-icon material-icons-round">phone</span>
                </div>
                <small class="text-muted">You'll receive a confirmation on this number</small>
            </div>

            <div class="mb-3">
                <button type="submit" class="submit-button" id="nabtebSubmit">
                    <span class="material-icons-round me-2">shopping_cart</span>
                    Purchase PIN
                </button>
            </div>
        </form>
    </div>
</div>
