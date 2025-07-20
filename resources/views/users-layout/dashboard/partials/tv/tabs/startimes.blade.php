<div class="tab-pane fade" id="startime" role="tabpanel">
    <div class="tv-card">
        <form class="custom-validation" id="startimeForm">
            @csrf
            <div class="mb-3">
                <label class="form-label">Smart Card Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" required
                        placeholder="Enter Startimes smartcard/ewallet number" id="billersCodeStartime"
                        name="billersCode" />
                    <span class="validation-icon material-icons-round">credit_card</span>
                </div>
                <small class="text-muted">Enter the smartcard/ewallet number printed on your Startimes decoder</small>
            </div>
            <div class="mb-3">
                <button type="button" class="submit-button" id="checkBillcodeStartime">
                    <span class="material-icons-round me-2">search</span>
                    Verify Smart Card
                </button>
            </div>

            <!-- Customer Information (Hidden by default) -->
            <div class="hideInnerForm" style="display:none" id="startimeInnerForm">
                <div class="customer-info-card mb-4">
                    <h5 class="p-3 border-bottom">Customer Information</h5>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Name</span>
                        <span class="text-gray-800 fw-bold" id="customerNameStartime"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Smartcard Number</span>
                        <span class="text-gray-800" id="currentBouquetStartime"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Balance</span>
                        <span class="text-gray-800 fw-bold" id="renewalAmountStartime"></span>
                    </div>
                </div>

                <div class="mb-4" id="selectBouquetContainerStartime">
                    <label class="form-label">Select a Bouquet</label>
                    <select class="form-select form-control" id="selectBouquetStartime" name="selectBouquet" required>
                        <option selected disabled value="">Please select type...</option>
                    </select>
                </div>

                <div id="amountContainerStartime" style="display: none;" class="mb-4">
                    <label class="form-label">Amount</label>
                    <div class="position-relative">
                        <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                        <input type="text" class="form-control ps-4" id="amountStartime" readonly name="amount">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Phone Number</label>
                    <div class="position-relative">
                        <input type="text" class="form-control" required placeholder="Recipient phone number"
                            name="telStartime" />
                        <span class="validation-icon material-icons-round">phone</span>
                    </div>
                    <small class="text-muted">You'll receive a confirmation on this number</small>
                </div>

                <div class="mb-3">
                    <button type="button" class="submit-button" id="submitStartime">
                        <span class="material-icons-round me-2">shopping_cart</span>
                        Complete Payment
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
