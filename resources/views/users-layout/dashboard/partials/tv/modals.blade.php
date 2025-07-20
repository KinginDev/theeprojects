<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true" role="dialog"
    aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="material-icons-round align-middle me-1" aria-hidden="true">check_circle</i>
                    Purchase Successful
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    data-focus-return="true"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-4">
                    <div class="success-animation">
                        <i class="material-icons-round text-success" style="font-size: 64px;"
                            aria-hidden="true">live_tv</i>
                    </div>
                    <h4 class="mt-3">TV Subscription Complete!</h4>
                    <p class="text-muted">Your subscription has been activated successfully</p>
                </div>

                <div class="tv-info-card">
                    <div class="tv-info-item">
                        <span class="text-gray-600">Transaction ID</span>
                        <span class="text-gray-800 fw-bold" id="transactionId"></span>
                    </div>
                    <div class="tv-info-item">
                        <span class="text-gray-600">Provider</span>
                        <span class="text-gray-800" id="successProvider"></span>
                    </div>
                    <div class="tv-info-item">
                        <span class="text-gray-600">Smart Card/IUC</span>
                        <span class="text-gray-800" id="successSmartCard"></span>
                    </div>
                    <div class="tv-info-item">
                        <span class="text-gray-600">Package</span>
                        <span class="text-gray-800" id="successPackage"></span>
                    </div>
                    <div class="tv-info-item">
                        <span class="text-gray-600">Type</span>
                        <span class="text-gray-800" id="successType"></span>
                    </div>
                    <div class="tv-info-item">
                        <span class="text-gray-600">Amount</span>
                        <span class="text-gray-800" id="successAmount"></span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="downloadReceipt" data-focus-first="true">
                    <i class="material-icons-round align-middle me-1" aria-hidden="true">download</i>
                    Download Receipt
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true"
    role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalLabel">
                    <i class="material-icons-round align-middle me-1" aria-hidden="true">error_outline</i>
                    Transaction Failed
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                    data-focus-return="true"></button>
            </div>
            <div class="modal-body py-4">
                <div class="text-center mb-3">
                    <i class="material-icons-round text-danger" style="font-size: 64px;" aria-hidden="true">error</i>
                    <h5 class="mt-3 mb-2">Sorry, something went wrong</h5>
                </div>
                <p class="error-message text-center">There was an error processing your request. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger" id="retryButton" data-focus-first="true">
                    <i class="material-icons-round align-middle me-1" aria-hidden="true">refresh</i>
                    Try Again
                </button>
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

<style>
    .tv-info-card {
        background: var(--gray-50);
        border-radius: var(--card-border-radius);
        margin-top: 1.5rem;
        overflow: hidden;
    }

    .tv-info-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .tv-info-item:last-child {
        border-bottom: none;
    }

    .success-animation {
        animation: scaleUp 0.5s ease-out;
    }

    @keyframes scaleUp {
        0% {
            transform: scale(0.5);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>
