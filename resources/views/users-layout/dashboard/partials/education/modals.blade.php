<!-- Modals -->
<div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <span class="material-icons-round text-success" style="font-size: 4rem;">check_circle</span>
                </div>
                <h5 class="mb-2">Payment Successful!</h5>
                <p class="text-muted mb-4">Your transaction has been processed successfully.</p>

                <div class="customer-info-card mb-4">
                    <div class="customer-info-item">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="text-gray-800 fw-bold" id="transactionId"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Service</span>
                        <span class="text-gray-800" id="successService"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">PIN/Serial</span>
                        <span class="text-gray-800" id="successPin"></span>
                    </div>
                    <div class="customer-info-item">
                        <span class="text-gray-600">Amount</span>
                        <span class="text-gray-800 fw-bold" id="successAmount"></span>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1"
                        data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary flex-grow-1" id="downloadReceipt">
                        <span class="material-icons-round me-1">download</span> Download Receipt
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="mb-4">
                    <span class="material-icons-round text-danger" style="font-size: 4rem;">error</span>
                </div>
                <h5 class="mb-2">Transaction Failed</h5>
                <p class="text-muted mb-4" id="errorMessage">Unable to process your payment. Please try again.</p>

                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-outline-secondary flex-grow-1"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary flex-grow-1" id="retryButton">
                        <span class="material-icons-round me-1">refresh</span> Retry
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay"
    style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 9999;"
    role="status" aria-live="polite">
    <div
        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: white;">
        <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" aria-hidden="true">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 class="mt-3 loading-text">Processing your request...</h5>
    </div>
</div>
