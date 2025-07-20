<div class="tab-pane fade" id="showmax" role="tabpanel">
    <div class="tv-card">
        <form class="custom-validation" id="showmaxForm">
            @csrf
            <div class="mb-4">
                <label class="form-label">Phone Number</label>
                <div class="position-relative">
                    <input type="text" class="form-control" required placeholder="Recipient phone number"
                        name="telShowmax" />
                    <span class="validation-icon material-icons-round">phone</span>
                </div>
                <small class="text-muted">You'll receive a confirmation on this number</small>
            </div>

            <div class="mb-4" id="selectBouquetContainershowmax">
                <label class="form-label">Select a Plan Type</label>
                <select class="form-select form-control" id="selectBouquetShowmax" name="selectBouquet" required>
                    <option selected disabled value="">Please select plan type...</option>
                </select>
            </div>

            <div class="mb-4" id="amountContainerShowmax">
                <label class="form-label">Amount</label>
                <div class="position-relative">
                    <span class="position-absolute start-0 top-50 translate-middle-y ps-3">₦</span>
                    <input type="text" class="form-control ps-4" id="amountShowmax" name="amount">
                </div>
            </div>

            <div class="mb-3">
                <button type="submit" class="submit-button" id="submitShowmax">
                    <span class="material-icons-round me-2">shopping_cart</span>
                    Complete Payment
                </button>
            </div>
        </form>
    </div>
</div>
