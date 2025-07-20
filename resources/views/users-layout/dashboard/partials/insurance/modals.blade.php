<!-- Preloader -->
<div id="preloader" class="justify-content-center align-items-center"
    style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:9999;">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>

<!-- Confirmation Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Your Insurance Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="confirmation-details">
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Insurance Type:</div>
                        <div class="col-7" id="confirmInsuranceType"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Phone Number:</div>
                        <div class="col-7" id="confirmPhoneNumber"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Email Address:</div>
                        <div class="col-7" id="confirmEmail"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-5 fw-bold">Amount:</div>
                        <div class="col-7" id="confirmAmount"></div>
                    </div>
                    <div id="additionalDetails"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmSubmitButton" class="btn btn-org">Confirm & Pay</button>
            </div>
        </div>
    </div>
</div>

<!-- Transaction Details Modal -->
<div class="modal fade" id="transactionDetailsModal" tabindex="-1" aria-labelledby="transactionDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="transactionDetailsModalLabel">Transaction Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="transactionDetailsBody">
                <!-- Transaction details will be inserted here dynamically -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
