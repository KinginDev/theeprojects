<div class="tab-pane fade show active" id="dstv" role="tabpanel">
    <div class="tv-card">
        <form class="custom-validation" id="dstvForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Smart Card Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" required placeholder="Enter valid DSTV smartcard number"
                        id="dstvBillersCode" name="billersCode" />
                    <span class="validation-icon material-icons-round">credit_card</span>
                </div>
                <small class="text-muted">Enter the smartcard number printed on your DSTV decoder</small>
            </div>
            <div class="mb-3">
                <button type="submit" class="submit-button" id="checkBillCodeButton">
                    <span class="material-icons-round me-2">search</span>
                    Verify Smart Card
                </button>
            </div>

            <!-- Customer Information (Hidden by default) -->
            <div class="hideInnerForm" id="dstvInnerForm" style="display:none">
                <div class="customer-info-card mb-4">
                    <h5 class="p-3 border-bottom">Customer Information</h5>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Name</span>
                        <span class="text-gray-800 fw-bold" id="customerName"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Current Bouquet</span>
                        <span class="text-gray-800" id="currentBouquet"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Due Date</span>
                        <span class="text-gray-800" id="dueDate"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Renewal Amount</span>
                        <span class="text-gray-800 fw-bold" id="renewalAmount"></span>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">What do you want to do?</label>
                    <select class="form-select form-control" disabled id="validationCustom03" name="bouquet" required>
                        <option selected disabled value="">Select an option</option>
                        <option value="renew">Renew Current Bouquet</option>
                        <option value="change">Change Bouquet</option>
                    </select>
                </div>

                <div id="selectBouquetContainer" style="display: none;" class="mb-4">
                    <label class="form-label">Select a Bouquet</label>
                    <select class="form-select form-control" id="selectBouquet" name="selectBouquet" required>
                        <option selected disabled value="">Please select type...</option>
                    </select>
                </div>

                <div id="amountContainer" style="display: none;" class="mb-4">
                    <label class="form-label">Amount</label>
                    <div class="position-relative">
                        <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                        <input type="text" class="form-control ps-4" id="amount" name="amount">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Phone Number</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" required placeholder="Recipient phone number"
                            name="tel" />
                        <span class="validation-icon material-icons-round">phone</span>
                    </div>
                    <small class="text-muted">You'll receive a confirmation on this number</small>
                </div>

                <div class="mb-3">
                    <button type="button" class="submit-button" id="submitDstv">
                        <span class="material-icons-round me-2">shopping_cart</span>
                        Complete Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
