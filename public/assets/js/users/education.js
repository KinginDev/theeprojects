/**
 * EducationManager - A modular, object-oriented implementation for education services management
 */
class EducationManager {
    /**
     * Initialize the education services management module
     */
    constructor() {
        // DOM helper methods
        this.$ = selector => document.querySelector(selector);
        this.$$ = selector => Array.from(document.querySelectorAll(selector));

        // Configuration from the global object
        const {
            purchaseApiUrl,
            jambVerifyUrl,
            waecResultUrl,
            queryTrxUrl,
            variationsUrl,
            userBalance,
            csrfToken
        } = window.EducationConfig || {};

        // Application configuration
        this.config = {
            purchaseApiUrl,
            jambVerifyUrl,
            waecResultUrl,
            queryTrxUrl,
            variationsUrl,
            userBalance,
            csrfToken: csrfToken || document.querySelector('meta[name="csrf-token"]').content,
            providers: {
                waec: {
                    name: 'WAEC',
                    serviceId: 'waec'
                },
                'waec-registration': {
                    name: 'WAEC Registration',
                    serviceId: 'waec-registration'
                },
                jamb: {
                    name: 'JAMB',
                    serviceId: 'jamb'
                },
                neco: {
                    name: 'NECO',
                    serviceId: 'neco'
                },
                nabteb: {
                    name: 'NABTEB',
                    serviceId: 'nabteb'
                }
            }
        };

        // Application state
        this.state = {
            loading: false,
            currentProvider: 'waec',
            currentAction: 'waec', // Track current action (waec or waec-registration)
            lastVerification: 0,
            currentRequest: null,
            debounceTimer: null,
            transactionHistory: [],
            customerInfo: {},
            jambProfile: null,
            variations: {
                waec: [],
                'waec-registration': [],
                jamb: [],
                neco: [],
                nabteb: []
            },
            selectedVariation: null,
            lastTransaction: null
        };

        // Initialize elements and events
        this.initElements();
        this.initProviderTabs();
        this.loadVariations();
        this.initEventListeners();
        this.initFormVisibility();
        this.loadTransactionHistory();
    }

    /**
     * Initialize DOM elements
     */
    initElements() {
        this.elements = {
            // Navigation tabs
            tabLinks: this.$$('.nav-link'),
            tabItems: this.$$('.custom-tab-item'),
            tabContent: this.$$('.tab-pane'),

            // Forms
            waecRegistrationForm: this.$('#waecRegistrationForm'),
            waecResultForm: this.$('#waecResultForm'),
            jambForm: this.$('#jambForm'),
            necoForm: this.$('#necoForm'),
            nabtebForm: this.$('#nabtebForm'),

            // WAEC Type Selector
            waecTypeSelect: this.$('#waecTypeSelect'),

            // WAEC Registration Inner Form
            waecRegInnerForm: this.$('#waecRegInnerForm'),
            waecVariationSelect: this.$('#waecVariationSelect'),
            waecRegQuantity: this.$('#waec_reg_quantity'),
            waecRegAmount: this.$('#waec_reg_amount'),
            waecRegPhone: this.$('#waec_reg_phone'),
            waecRegSubmit: this.$('#waecRegSubmit'),

            // WAEC Result Checker
            waecResultVariation: this.$('#waec_result_variation'),
            waecResultQuantity: this.$('#waec_result_quantity'),
            waecResultAmount: this.$('#waec_result_amount'),
            waecResultPhone: this.$('#waec_result_phone'),
            waecResultSubmit: this.$('#waecResultSubmit'),


            // JAMB elements
            jambProfileId: this.$('#jamb_profile_id'),
            checkJambProfile: this.$('#checkJambProfile'),
            jambInnerForm: this.$('#jambInnerForm'),
            jambCustomerName: this.$('#jambCustomerName'),
            jambProfileIdDisplay: this.$('#jambProfileId'),
            jambVariation: this.$('#jamb_variation'),
            jambAmount: this.$('#jamb_amount'),
            jambPhone: this.$('#jamb_phone'),
            jambSubmit: this.$('#jambSubmit'),

            // NECO elements - keep these for future implementation
            necoType: this.$('#necoType'),
            necoQuantity: this.$('#necoQuantity'),
            necoAmount: this.$('#necoAmount'),
            necoPhoneNumber: this.$('#necoPhoneNumber'),

            // NABTEB elements - keep these for future implementation
            nabtebType: this.$('#nabtebType'),
            nabtebQuantity: this.$('#nabtebQuantity'),
            nabtebAmount: this.$('#nabtebAmount'),
            nabtebPhoneNumber: this.$('#nabtebPhoneNumber'),

            // Modals
            successModal: this.$('#successModal'),
            errorModal: this.$('#errorModal'),
            errorMessage: this.$('#errorMessage'),
            transactionId: this.$('#transactionId'),
            successService: this.$('#successService'),
            successPin: this.$('#successPin'),
            successAmount: this.$('#successAmount'),

            // Preloader
            preloader: this.$('#loadingOverlay'),
            loadingText: this.$('.loading-text'),

            // Transaction history
            transactionHistory: this.$('#transactionHistory'),
            retryButton: this.$('#retryButton'),

            // Buttons
            downloadReceipt: this.$('#downloadReceipt')
        };
    }

    /**
     * Initialize provider tabs
     */
    initProviderTabs() {
        // Handle tab click events
        if (this.elements.tabItems && this.elements.tabItems.length) {
            this.elements.tabItems.forEach(tab => {
                tab.addEventListener('click', () => this.handleTabClick(tab));
            });
        }

        // Load tab from URL hash on initial load
        this.loadTabFromUrlHash();

        // Listen for hash changes to update active tab
        window.addEventListener('hashchange', () => this.loadTabFromUrlHash());
    }

    /**
     * Handle tab click
     * @param {HTMLElement} tab - The clicked tab
     * @param {boolean} updateUrl - Whether to update the URL
     */
    handleTabClick(tab, updateUrl = true) {
        if (!tab) return;

        const provider = tab.dataset.service;
        if (!provider) return;

        // Update state
        this.state.currentProvider = provider;

        // Update URL hash if needed
        if (updateUrl) {
            window.location.hash = provider;
        }

        console.log(`Provider set to: ${provider}`);
    }

    /**
     * Load active tab from URL hash
     */
    loadTabFromUrlHash() {
        const hash = window.location.hash.replace('#', '');
        const provider = ['waec', 'jamb', 'neco', 'nabteb'].includes(hash) ? hash : 'waec';

        // Find the tab with matching data-service attribute
        const tab = this.elements.tabItems.find(item => item.dataset.service === provider);

        if (tab) {
            // Simulate click on the tab (without updating URL again)
            this.handleTabClick(tab, false);

            // Find and click the Bootstrap tab link to activate it visually
            const tabLink = tab.querySelector('.nav-link');
            if (tabLink) {
                tabLink.click();
            }
        }
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // WAEC Type Selector to show appropriate form
        if (this.elements.waecTypeSelect) {
            // Set up initial form visibility based on the default selection
            this.updateWaecFormVisibility(this.elements.waecTypeSelect.value);

            this.elements.waecTypeSelect.addEventListener('change', () => {
                const selectedType = this.elements.waecTypeSelect.value;
                this.updateWaecFormVisibility(selectedType);
            });
        }

        /**
         * Helper method to update WAEC form visibility
         */

        // WAEC Registration Form
        if (this.elements.waecRegistrationForm) {
            this.elements.waecRegistrationForm.addEventListener('submit', e => {
                e.preventDefault();
                // This form should only handle registration
                this.submitWaecRegistrationPurchase();
            });
        }

        // WAEC Result Form
        if (this.elements.waecResultForm) {
            this.elements.waecResultForm.addEventListener('submit', e => {
                e.preventDefault();
                // This form should only handle result checking
                this.submitWaecResultPurchase();
            });

            // WAEC Registration variation selector
            if (this.elements.waecVariationSelect) {
                this.elements.waecVariationSelect.addEventListener('change', () => {
                    this.updateWaecRegAmount();
                });
            }

            // WAEC Registration quantity input
            if (this.elements.waecRegQuantity) {
                this.elements.waecRegQuantity.addEventListener('input', () => {
                    this.updateWaecRegAmount();
                });
            }

            // WAEC Result variation selector
            if (this.elements.waecResultVariation) {
                this.elements.waecResultVariation.addEventListener('change', () => {
                    this.updateWaecResultAmount();
                });
            }

            // WAEC Result quantity input
            if (this.elements.waecResultQuantity) {
                this.elements.waecResultQuantity.addEventListener('input', () => {
                    this.updateWaecResultAmount();
                });
            }
        }

        // JAMB Profile Check Button
        if (this.elements.checkJambProfile) {
            this.elements.checkJambProfile.addEventListener('click', () => {
                this.verifyJambProfile();
            });
        }

        // JAMB Form
        if (this.elements.jambForm) {
            this.elements.jambForm.addEventListener('submit', e => {
                e.preventDefault();
                this.submitJambPurchase();
            });

            // JAMB variation selector
            if (this.elements.jambVariation) {
                this.elements.jambVariation.addEventListener('change', () => {
                    const variationCode = this.elements.jambVariation.value;
                    if (variationCode) {
                        // Show profile ID input when a variation is selected
                        const profileIdContainer = this.$('#profileIdContainer');
                        if (profileIdContainer) {
                            profileIdContainer.style.display = 'block';
                        }
                    }
                    this.updateJambAmount();
                });
            }
        }

        // NECO form - keep for future implementation
        if (this.elements.necoForm) {
            this.elements.necoForm.addEventListener('submit', e => {
                e.preventDefault();
                this.submitPurchase('neco');
            });
        }

        // NABTEB form - keep for future implementation
        if (this.elements.nabtebForm) {
            this.elements.nabtebForm.addEventListener('submit', e => {
                e.preventDefault();
                this.submitPurchase('nabteb');
            });
        }

        // Retry button
        if (this.elements.retryButton) {
            this.elements.retryButton.addEventListener('click', () => {
                this.retryPurchase();
            });
        }

        // Download receipt button
        if (this.elements.downloadReceipt) {
            this.elements.downloadReceipt.addEventListener('click', () => {
                this.handleDownloadReceipt();
            });
        }
    }    /**
     * Load service variations for all providers
     */
    loadVariations() {
        this.showPreloader('Loading service options...');

        // For each provider, load their variations
        const providers = ['waec', 'waec-registration', 'jamb', 'neco', 'nabteb'];
        const promises = [];

        providers.forEach(provider => {
            // Make API request to get variations
            // Use the correct serviceID for each provider
            const serviceID = this.config.providers[provider]?.serviceId || provider;
            const url = `${this.config.variationsUrl}?serviceID=${serviceID}`;

            const promise = fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.content && data.content.variations) {
                        // Store variations in state
                        this.state.variations[provider] = data.content.variations;

                        // Update select options if available
                        this.populateVariationOptions(provider);
                    } else {
                        console.error(`Failed to load variations for ${provider}`);
                    }
                })
                .catch(error => {
                    console.error(`Error loading variations for ${provider}:`, error);
                });

            promises.push(promise);
        });

        // When all providers' variations are loaded
        Promise.all(promises)
            .finally(() => {
                this.hidePreloader();

                // Initialize amounts after loading variations
                this.updateWaecRegAmount();
                this.updateWaecResultAmount();
                this.updateJambAmount();
                // Keep these for future implementation
                // this.updateNecoAmount();
                // this.updateNabtebAmount();
            });
    }

    /**
     * Populate variation options in select elements
     * @param {string} provider - The service provider
     */
    populateVariationOptions(provider) {
        let selectElement;

        // Get the select element for the provider
        switch (provider) {
            case 'waec':
                selectElement = this.elements.waecResultVariation;
                break;
            case 'waec-registration':
                selectElement = this.elements.waecVariationSelect;
                break;
            case 'jamb':
                selectElement = this.elements.jambVariation;
                break;
            case 'neco':
                selectElement = this.elements.necoType;
                break;
            case 'nabteb':
                selectElement = this.elements.nabtebType;
                break;
            default:
                return;
        }

        if (!selectElement || !this.state.variations[provider]?.length) return;

        // Clear existing options except the first one (placeholder)
        while (selectElement.options.length > 1) {
            selectElement.remove(1);
        }

        // Add variation options
        this.state.variations[provider].forEach(variation => {
            const option = document.createElement('option');
            option.value = variation.variation_code;
            option.textContent = variation.name;
            option.dataset.amount = variation.variation_amount;
            selectElement.appendChild(option);
        });
    }

    /**
     * Update WAEC Registration amount based on selected variation and quantity
     */
    updateWaecRegAmount() {
        if (!this.elements.waecVariationSelect || !this.elements.waecRegQuantity || !this.elements.waecRegAmount) return;

        const variationCode = this.elements.waecVariationSelect.value;
        const quantity = parseInt(this.elements.waecRegQuantity.value) || 1;

        // Find the selected variation from state
        const selectedVariation = this.state.variations['waec-registration']?.find(v => v.variation_code === variationCode);

        if (selectedVariation) {
            // Calculate amount based on variation amount
            const unitPrice = parseFloat(selectedVariation.variation_amount);
            const totalAmount = unitPrice * quantity;

            // Update UI
            this.elements.waecRegAmount.value = totalAmount.toFixed(2);
        }
    }

    /**
     * Update WAEC Result Checker amount based on selected variation and quantity
     */
    updateWaecResultAmount() {
        if (!this.elements.waecResultVariation || !this.elements.waecResultQuantity || !this.elements.waecResultAmount) return;

        const variationCode = this.elements.waecResultVariation.value;
        const quantity = parseInt(this.elements.waecResultQuantity.value) || 1;

        // Find the selected variation from state
        const selectedVariation = this.state.variations['waec']?.find(v => v.variation_code === variationCode);

        if (selectedVariation) {
            // Calculate amount based on variation amount
            const unitPrice = parseFloat(selectedVariation.variation_amount);
            const totalAmount = unitPrice * quantity;

            // Update UI
            this.elements.waecResultAmount.value = totalAmount.toFixed(2);
        }
    }

    /**
     * Update JAMB amount based on selected variation
     * Note: JAMB usually doesn't have quantity selection
     */
    updateJambAmount() {
        if (!this.elements.jambVariation || !this.elements.jambAmount) return;

        const variationCode = this.elements.jambVariation.value;

        // For JAMB, use the data-amount attribute directly
        const selectedOption = this.elements.jambVariation.options[this.elements.jambVariation.selectedIndex];
        if (selectedOption && selectedOption.dataset.amount) {
            const amount = parseFloat(selectedOption.dataset.amount);
            this.elements.jambAmount.value = amount.toFixed(2);
            return;
        }

        // Fallback: find the selected variation from state
        const selectedVariation = this.state.variations['jamb']?.find(v => v.variation_code === variationCode);

        if (selectedVariation) {
            // Calculate amount based on variation amount
            const amount = parseFloat(selectedVariation.variation_amount);

            // Update UI
            this.elements.jambAmount.value = amount.toFixed(2);
        }
    }

    /**
     * Update NECO amount based on selected variation and quantity
     * Reserved for future implementation
     */
    updateNecoAmount() {
        if (!this.elements.necoType || !this.elements.necoQuantity || !this.elements.necoAmount) return;

        const variationCode = this.elements.necoType.value;
        const quantity = parseInt(this.elements.necoQuantity.value) || 1;

        // Find the selected variation from state
        const selectedVariation = this.state.variations.neco?.find(v => v.variation_code === variationCode);

        if (selectedVariation) {
            // Calculate amount based on variation amount
            const unitPrice = parseFloat(selectedVariation.variation_amount);
            const totalAmount = unitPrice * quantity;

            // Update UI
            this.elements.necoAmount.value = totalAmount.toFixed(2);
        }
    }

    /**
     * Update NABTEB amount based on selected variation and quantity
     * Reserved for future implementation
     */
    updateNabtebAmount() {
        if (!this.elements.nabtebType || !this.elements.nabtebQuantity || !this.elements.nabtebAmount) return;

        const variationCode = this.elements.nabtebType.value;
        const quantity = parseInt(this.elements.nabtebQuantity.value) || 1;

        // Find the selected variation from state
        const selectedVariation = this.state.variations.nabteb?.find(v => v.variation_code === variationCode);

        if (selectedVariation) {
            // Calculate amount based on variation amount
            const unitPrice = parseFloat(selectedVariation.variation_amount);
            const totalAmount = unitPrice * quantity;

            // Update UI
            this.elements.nabtebAmount.value = totalAmount.toFixed(2);
        }
    }

    /**
     * Submit purchase for education service
     * @param {string} provider - The service provider (waec, jamb, neco, nabteb)
     */
    submitPurchase(provider) {
        let form, serviceId, type, quantity, amount, phone, email;
        let variation = null;

        switch (provider) {
            case 'waec':
                form = this.elements.waecForm;
                serviceId = 'waec';
                type = this.elements.waecType?.value;
                quantity = this.elements.waecQuantity?.value;
                amount = this.elements.waecAmount?.value;
                phone = this.elements.waecPhoneNumber?.value;
                email = this.elements.waecEmail?.value;
                // Find variation
                variation = this.state.variations.waec.find(v => v.variation_code === type);
                break;
            case 'jamb':
                form = this.elements.jambForm;
                serviceId = 'jamb';
                type = this.elements.jambType?.value;
                quantity = this.elements.jambQuantity?.value;
                amount = this.elements.jambAmount?.value;
                phone = this.elements.jambPhoneNumber?.value;
                email = this.elements.jambEmail?.value;
                // Find variation
                variation = this.state.variations.jamb.find(v => v.variation_code === type);
                break;
            case 'neco':
                form = this.elements.necoForm;
                serviceId = 'neco';
                type = this.elements.necoType?.value;
                quantity = this.elements.necoQuantity?.value;
                amount = this.elements.necoAmount?.value;
                phone = this.elements.necoPhoneNumber?.value;
                email = this.elements.necoEmail?.value;
                // Find variation
                variation = this.state.variations.neco.find(v => v.variation_code === type);
                break;
            case 'nabteb':
                form = this.elements.nabtebForm;
                serviceId = 'nabteb';
                type = this.elements.nabtebType?.value;
                quantity = this.elements.nabtebQuantity?.value;
                amount = this.elements.nabtebAmount?.value;
                phone = this.elements.nabtebPhoneNumber?.value;
                email = this.elements.nabtebEmail?.value;
                // Find variation
                variation = this.state.variations.nabteb.find(v => v.variation_code === type);
                break;
        }

        // Validate form data
        if (!this.validatePurchaseForm(provider, type, quantity, amount, phone, email)) {
            return;
        }

        // Show preloader
        this.showPreloader();

        // Disable submit button and show spinner
        const submitButton = form.querySelector('button[type="submit"]');
        if (submitButton) {
            this.state.originalButtonContent = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processing...`;
        }

        // Prepare form data with variation details
        const formData = new FormData();
        formData.append('service', serviceId);
        formData.append('variation_code', type);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
        formData.append('phone', phone);
        formData.append('email', email);
        formData.append('_token', this.config.csrfToken);

        // Include variation details if available
        if (variation) {
            formData.append('variation_name', variation.name);
            formData.append('variation_amount', variation.variation_amount);
        }

        // Make API call
        fetch(this.config.purchaseApiUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                // Store the transaction for verification
                this.state.lastTransaction = {
                    requestId: data.requestId,
                    service: serviceId,
                    provider: provider,
                    type: type,
                    variation_name: variation?.name,
                    quantity: quantity,
                    amount: amount,
                    phone: phone,
                    email: email
                };

                if (data.code === '000' && data.content) {
                    // Success - Process the transaction
                    this.processSuccessfulPurchase(data, provider, type, quantity, amount);
                } else {
                    // Error handling
                    this.hidePreloader();

                    // Re-enable submit button
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = this.state.originalButtonContent;
                    }

                    // Store transaction info for retry
                    this.state.lastTransaction = {
                        provider,
                        type,
                        quantity,
                        amount,
                        phone,
                        billcode,
                        failureReason: data.response_description || 'Unknown error'
                    };

                    // Show detailed error message based on error code
                    let errorMessage = data.response_description || 'Transaction failed. Please try again.';

                    if (data.code === '015') {
                        errorMessage = 'Insufficient wallet balance. Please fund your wallet and try again.';
                    } else if (data.code === '014') {
                        errorMessage = 'Service temporarily unavailable. Please try again later.';
                    } else if (data.code === '024') {
                        errorMessage = 'Invalid profile ID or billcode. Please check and try again.';
                    } else if (data.code === '039') {
                        errorMessage = 'Duplicate transaction detected. Please wait a few minutes before trying again.';
                    }

                    this.showErrorModal(errorMessage);

                    // Log failure for debugging
                    console.error('Transaction failed:', data);
                }
            })
            .catch(error => {
                this.hidePreloader();

                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = this.state.originalButtonContent;
                }

                console.error('Error:', error);
                this.showErrorModal('An error occurred while processing your request. Please try again.');
            });
    }

    /**
     * Submit purchase for WAEC Registration PIN
     */
    submitWaecRegistrationPurchase() {
        if (!this.elements.waecVariationSelect || !this.elements.waecRegQuantity || !this.elements.waecRegAmount || !this.elements.waecRegPhone) return;

        const variationCode = this.elements.waecVariationSelect.value;
        const quantity = parseInt(this.elements.waecRegQuantity.value) || 1;
        const amount = this.elements.waecRegAmount.value;
        const phone = this.elements.waecRegPhone.value;

        // Find the selected variation
        const variation = this.state.variations['waec-registration']?.find(v => v.variation_code === variationCode);
        if (!variation) {
            this.showErrorModal('Please select a valid exam type');
            return;
        }

        // Validate form data
        if (!this.validatePurchaseData('waec-registration', variationCode, quantity, amount, phone)) {
            return;
        }

        // Submit the purchase
        this.processPurchase('waec-registration', variationCode, quantity, amount, phone, variation);
    }

    /**
     * Submit purchase for WAEC Result Checker
     */
    submitWaecResultPurchase() {
        if (!this.elements.waecResultVariation || !this.elements.waecResultQuantity || !this.elements.waecResultAmount || !this.elements.waecResultPhone) return;

        const variationCode = this.elements.waecResultVariation.value;
        const quantity = parseInt(this.elements.waecResultQuantity.value) || 1;
        const amount = this.elements.waecResultAmount.value;
        const phone = this.elements.waecResultPhone.value;

        // Find the selected variation
        const variation = this.state.variations['waec']?.find(v => v.variation_code === variationCode);
        if (!variation) {
            this.showErrorModal('Please select a valid exam type');
            return;
        }

        // Validate form data
        if (!this.validatePurchaseData('waec', variationCode, quantity, amount, phone)) {
            return;
        }

        // Submit the purchase
        this.processPurchase('waec', variationCode, quantity, amount, phone, variation);
    }

    /**
     * Submit purchase for JAMB PIN
     */
    submitJambPurchase() {
        if (!this.elements.jambProfileId || !this.elements.jambVariation || !this.elements.jambAmount || !this.elements.jambPhone) return;

        const billcode = this.elements.jambProfileId.value.trim();
        const variationCode = this.elements.jambVariation.value;
        const amount = this.elements.jambAmount.value;
        const phone = this.elements.jambPhone.value.trim();

        // Find the selected variation
        const variation = this.state.variations['jamb']?.find(v => v.variation_code === variationCode);
        if (!variation) {
            this.showErrorModal('Please select a valid service type');
            return;
        }

        // Store the selected variation type for API submission
        this.state.selectedVariation = variation;

        // Validate JAMB profile ID
        if (!billcode) {
            this.showErrorModal('Please enter a valid JAMB profile ID');
            return;
        }

        // Validate profile verification
        if (!this.state.jambProfile || !this.state.jambProfile.verified) {
            this.showErrorModal('Please verify your JAMB profile ID first');
            return;
        }

        // Check if verification has expired (over 30 minutes old)
        const verificationAge = Date.now() - (this.state.jambProfile.verification_time || 0);
        if (verificationAge > 30 * 60 * 1000) { // 30 minutes in milliseconds
            this.showErrorModal('Your profile verification has expired. Please verify again.');
            return;
        }

        // Ensure the profile ID matches the verified one
        if (billcode !== this.state.jambProfile.profile_id) {
            this.showErrorModal('The profile ID has changed since verification. Please verify again.');
            return;
        }

        // Validate form data (quantity is fixed at 1 for JAMB)
        if (!this.validatePurchaseData('jamb', variationCode, 1, amount, phone)) {
            return;
        }

        // Submit the purchase with the profile ID as billcode
        this.processPurchase('jamb', variationCode, 1, amount, phone, variation, billcode);
    }

    /**
     * Validate purchase data
     * @param {string} provider - The service provider
     * @param {string} type - The variation code
     * @param {number} quantity - The quantity
     * @param {string|number} amount - The total amount
     * @param {string} phone - The phone number
     * @returns {boolean} - Whether the data is valid
     */
    validatePurchaseData(provider, type, quantity, amount, phone) {
        // Check if type is selected
        if (!type) {
            this.showErrorModal('Please select a product type');
            return false;
        }

        // Check quantity (must be 1-5)
        if (!quantity || quantity < 1 || quantity > 5) {
            this.showErrorModal('Please enter a valid quantity (1-5)');
            return false;
        }

        // Check amount
        if (!amount || parseFloat(amount) <= 0) {
            this.showErrorModal('Invalid amount');
            return false;
        }

        // Check if user has enough balance
        if (parseFloat(amount) > this.config.userBalance) {
            this.showErrorModal('Insufficient wallet balance. Please fund your wallet and try again.');
            return false;
        }

        // Check phone number
        if (provider !== 'jamb' && (!phone || phone.length < 10)) {
            this.showErrorModal('Please enter a valid phone number');
            return false;
        }

        return true;
    }

    /**
     * Process a purchase transaction
     * @param {string} provider - The service provider
     * @param {string} type - The variation code
     * @param {number} quantity - The quantity
     * @param {string|number} amount - The total amount
     * @param {string} phone - The phone number
     * @param {object} variation - The variation object
     * @param {string} [billcode] - Optional billcode for services like JAMB
     */
    processPurchase(provider, type, quantity, amount, phone, variation, billcode = null) {
        // Get a user-friendly service name
        const serviceName = this.config.providers[provider]?.name || provider.toUpperCase();

        // Show preloader with context-specific message
        let loadingMessage;
        if (provider === 'waec') {
            loadingMessage = `Processing your WAEC result checker purchase...`;
        } else if (provider === 'waec-registration') {
            loadingMessage = `Processing your WAEC registration PIN purchase...`;
        } else if (provider === 'jamb') {
            loadingMessage = `Processing your JAMB PIN purchase...`;
        } else {
            loadingMessage = `Processing your ${serviceName} purchase...`;
        }

        this.showPreloader(loadingMessage);

        // Determine the form element to get the submit button
        let form;
        if (provider === 'waec') {
            form = this.elements.waecResultForm;
        } else if (provider === 'waec-registration') {
            form = this.elements.waecRegistrationForm;
        } else if (provider === 'jamb') {
            form = this.elements.jambForm;
        } else {
            this.hidePreloader();
            this.showErrorModal('Invalid provider');
            return;
        }

        // Get the submit button and disable it
        const submitButton = form?.querySelector('button[type="submit"]');
        if (submitButton) {
            this.state.originalButtonContent = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processing...`;
        }

        // Prepare form data
        const formData = new FormData();

        // Use the correct serviceID for the provider
        // For JAMB, we need to use 'jamb' as the serviceID regardless of the variation
        const serviceID = provider === 'jamb' ? 'jamb' :
            (this.config.providers[provider]?.serviceId || provider);

        formData.append('service', serviceID);
        formData.append('variation_code', type);
        formData.append('quantity', quantity);
        formData.append('amount', amount);
        formData.append('phone', phone);
        formData.append('_token', this.config.csrfToken);

        // Include billcode if available (for JAMB)
        if (billcode) {
            formData.append('billcode', billcode);
        }

        // Include variation details if available
        if (variation) {
            formData.append('variation_name', variation.name);
            formData.append('variation_amount', variation.variation_amount);

            // For JAMB, include the variation type parameter
            if (provider === 'jamb') {
                formData.append('type', variation.variation_code);
            }
        }

        // Store current transaction info for retry
        this.state.lastTransaction = {
            provider,
            type,
            quantity,
            amount,
            phone,
            billcode
        };

        // Make API call
        fetch(this.config.purchaseApiUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.code === '000' && data.content) {
                    // Store request ID for verification
                    this.state.lastTransaction.requestId = data.requestId;

                    // Success - Process the transaction
                    this.processSuccessfulPurchase(data, provider, type, quantity, amount);
                } else {
                    // Error handling
                    this.hidePreloader();

                    // Re-enable submit button
                    if (submitButton) {
                        submitButton.disabled = false;
                        submitButton.innerHTML = this.state.originalButtonContent;
                    }

                    this.showErrorModal(data.response_description || 'Transaction failed. Please try again.');
                }
            })
            .catch(error => {
                this.hidePreloader();

                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = this.state.originalButtonContent;
                }

                console.error('Error:', error);
                this.showErrorModal('An error occurred while processing your request. Please try again.');
            });
    }

    /**
     * Process a successful purchase transaction
     */
    processSuccessfulPurchase(data, provider, type, quantity, amount) {
        const requestId = data.requestId || this.state.lastTransaction?.requestId;

        if (!requestId) {
            this.hidePreloader();
            this.showErrorModal('Invalid transaction reference');
            return;
        }

        // Get a user-friendly service name
        const serviceName = this.config.providers[provider]?.name || provider.toUpperCase();

        // Update preloader text with context-specific message
        this.showPreloader(`Verifying your ${serviceName} transaction...`);

        // Verify transaction
        this.verifyTransaction(requestId)
            .then(verificationData => {
                this.hidePreloader();

                // Get transaction data from verification or original response
                const transactionData = verificationData || data;

                // Determine the pins/cards from the response
                let pins = [];

                if (transactionData.content?.cards) {
                    // If cards array is present (WAEC result checker format)
                    pins = transactionData.content.cards.map(card => ({
                        pin: card.Pin,
                        serial: card.Serial
                    }));
                } else if (transactionData.content?.tokens) {
                    // If tokens array is present (WAEC registration format)
                    pins = transactionData.content.tokens.map(token => ({
                        pin: token,
                        serial: 'N/A'
                    }));
                } else if (transactionData.content?.purchased_code) {
                    // If only purchased_code is available
                    const codeParts = transactionData.content.purchased_code.split(':');
                    if (codeParts.length > 1) {
                        pins = [{
                            pin: codeParts[1].trim(),
                            serial: 'N/A'
                        }];
                    } else {
                        pins = [{
                            pin: transactionData.content.purchased_code,
                            serial: 'N/A'
                        }];
                    }
                }

                // Update success modal
                this.updateSuccessModal(
                    requestId,
                    provider,
                    type,
                    quantity,
                    transactionData.amount || amount,
                    pins
                );

                // Add to transaction history
                this.addTransactionToHistory({
                    provider,
                    type,
                    product_name: transactionData.content?.transactions?.product_name || this.formatTypeLabel(type),
                    quantity,
                    amount: transactionData.amount || amount,
                    transaction_id: requestId,
                    status: 'completed',
                    created_at: transactionData.transaction_date || new Date(),
                    pins
                });

                // Reset forms based on provider
                let form, submitButton;

                if (provider === 'waec') {
                    form = this.elements.waecResultForm;
                    submitButton = this.elements.waecResultSubmit;
                } else if (provider === 'waec-registration') {
                    form = this.elements.waecRegistrationForm;
                    submitButton = this.elements.waecRegSubmit;
                } else if (provider === 'jamb') {
                    form = this.elements.jambForm;
                    submitButton = this.elements.jambSubmit;
                    // Reset JAMB profile state
                    this.state.jambProfile = null;
                    // Hide the inner form and profile ID container
                    if (this.elements.jambInnerForm) {
                        this.elements.jambInnerForm.style.display = 'none';
                    }
                    // Hide the profile ID container as well
                    const profileIdContainer = document.querySelector('#profileIdContainer');
                    if (profileIdContainer) {
                        profileIdContainer.style.display = 'none';
                    }
                }

                if (form) {
                    form.reset();

                    // Reset WAEC type selector to default
                    if (provider.startsWith('waec') && this.elements.waecTypeSelect) {
                        this.elements.waecTypeSelect.selectedIndex = 0;
                        if (this.elements.waecRegInnerForm) {
                            this.elements.waecRegInnerForm.style.display = 'none';
                        }
                        if (this.elements.waecResultForm) {
                            this.elements.waecResultForm.style.display = 'none';
                        }
                    }
                }

                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = this.state.originalButtonContent;
                }
            })
            .catch(error => {
                this.hidePreloader();

                // Re-enable submit button based on provider
                let submitButton;

                if (provider === 'waec') {
                    submitButton = this.elements.waecResultSubmit;
                } else if (provider === 'waec-registration') {
                    submitButton = this.elements.waecRegSubmit;
                } else if (provider === 'jamb') {
                    submitButton = this.elements.jambSubmit;
                }

                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = this.state.originalButtonContent;
                }

                console.error('Error verifying transaction:', error);
                // Still show success if verification fails but we have the original data
                this.updateSuccessModal(
                    requestId,
                    provider,
                    type,
                    quantity,
                    data.amount || amount,
                    []
                );
            });
    }

    /**
     * Verify transaction status
     * @param {string} requestId - The transaction request ID
     * @returns {Promise} - Promise resolving to verification data
     */
    /**
     * Verify transaction status
     * @param {string} requestId - The transaction request ID
     * @returns {Promise} - Promise resolving to verification data
     */
    verifyTransaction(requestId) {
        if (!requestId || !this.config.queryTrxUrl) {
            return Promise.reject(new Error('Invalid requestId or verification URL'));
        }

        const formData = new FormData();
        formData.append('request_id', requestId);
        formData.append('_token', this.config.csrfToken);

        return fetch(this.config.queryTrxUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.code === '000') {
                    return data;
                }

                // If verification didn't return success code, log the issue but don't fail
                console.warn('Transaction verification returned non-success code:', data.code, data.response_description);

                // For specific error codes, we might want to throw an error
                if (['004', '005'].includes(data.code)) {
                    throw new Error(`Transaction verification failed: ${data.response_description || 'Unknown error'}`);
                }

                // For other codes, return null to continue with original data
                return null;
            })
            .catch(error => {
                console.error('Transaction verification error:', error);
                // Return null instead of rejecting to allow fallback to original data
                return null;
            });
    }

    /**
     * Update the success modal with transaction data
     */
    updateSuccessModal(transactionId, provider, type, quantity, amount, pins) {
        if (!this.elements.successModal) return;

        // Set basic transaction details
        if (this.elements.transactionId) {
            this.elements.transactionId.textContent = transactionId || 'N/A';
        }

        if (this.elements.successService) {
            const serviceName = this.config.providers[provider]?.name || provider.toUpperCase();
            const typeName = this.formatTypeLabel(type);
            this.elements.successService.textContent = `${serviceName} - ${typeName}`;
        }

        if (this.elements.successAmount) {
            this.elements.successAmount.textContent = '₦' + this.formatAmount(amount);
        }

        // Set PIN/Serial details
        let pinSerialHtml = 'N/A';
        if (pins && pins.length) {
            if (pins.length === 1) {
                // For a single PIN, show it directly
                const pin = pins[0];
                pinSerialHtml = pin.serial && pin.serial !== 'N/A'
                    ? `<strong>PIN:</strong> ${pin.pin} <br><strong>Serial:</strong> ${pin.serial}`
                    : `<strong>PIN:</strong> ${pin.pin}`;
            } else {
                // For multiple PINs, show them all in a list
                pinSerialHtml = pins.map((pin, index) => {
                    if (pin.serial && pin.serial !== 'N/A') {
                        return `<div class="mb-2">
                            <strong>${index + 1}.</strong>
                            <strong>PIN:</strong> ${pin.pin}
                            <br><strong>Serial:</strong> ${pin.serial}
                        </div>`;
                    } else {
                        return `<div class="mb-2">
                            <strong>${index + 1}.</strong>
                            <strong>PIN:</strong> ${pin.pin}
                        </div>`;
                    }
                }).join('');
            }
        }

        if (this.elements.successPin) {
            this.elements.successPin.innerHTML = pinSerialHtml; // Use innerHTML to support HTML formatting
        }

        // Show modal
        const successModal = new bootstrap.Modal(this.elements.successModal);
        successModal.show();
    }

    /**
     * Format type label for display
     */
    formatTypeLabel(type) {
        if (!type) return 'N/A';

        // First check if we have a variation with this code
        for (const provider in this.state.variations) {
            const variation = this.state.variations[provider]?.find(v => v.variation_code === type);
            if (variation) {
                return variation.name;
            }
        }

        // Otherwise format the code directly
        return type
            .replace(/_/g, ' ')
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
    }

    /**
     * Retry a failed purchase
     */
    retryPurchase() {
        // Close error modal
        if (this.elements.errorModal) {
            const errorModal = bootstrap.Modal.getInstance(this.elements.errorModal);
            if (errorModal) errorModal.hide();
        }

        const lastTx = this.state.lastTransaction;
        if (!lastTx || !lastTx.provider) {
            this.showErrorModal('No transaction to retry');
            return;
        }

        // Submit the appropriate purchase based on provider
        setTimeout(() => {
            if (lastTx.provider === 'waec') {
                this.submitWaecResultPurchase();
            } else if (lastTx.provider === 'waec-registration') {
                this.submitWaecRegistrationPurchase();
            } else if (lastTx.provider === 'jamb') {
                this.submitJambPurchase();
            } else {
                this.showErrorModal('Invalid transaction type for retry');
            }
        }, 300);
    }

    /**
     * Verify JAMB profile
     */
    /**
     * Verify JAMB profile
     */
    verifyJambProfile() {
        const profileId = this.elements.jambProfileId?.value?.trim();

        // Get the selected variation from the select element
        const variationCode = this.elements.jambVariation?.value;
        const variation = this.state.variations['jamb']?.find(v => v.variation_code === variationCode);

        if (!profileId) {
            this.showErrorModal('Please enter a valid JAMB profile ID');
            return;
        }

        // Save the selected variation for use in the form submission
        if (variation) {
            this.state.selectedVariation = variation;
        }

        this.showPreloader('Verifying JAMB profile...');

        // Disable verify button and show spinner
        const verifyButton = this.elements.checkJambProfile;
        if (verifyButton) {
            this.state.originalVerifyButtonContent = verifyButton.innerHTML;
            verifyButton.disabled = true;
            verifyButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Verifying...`;
        }

        // Create form data for verification
        const formData = new FormData();
        formData.append('profile_id', profileId);
        formData.append('service', 'jamb'); // Ensure we're using 'jamb' as the service ID
        formData.append('variation', variation.variation_code); // Ensure we're using 'jamb' as the variation ID
        formData.append('_token', this.config.csrfToken);

        // Track when this verification was performed
        this.state.lastVerification = Date.now();

        fetch(this.config.jambVerifyUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                this.hidePreloader();

                // Re-enable verify button
                if (verifyButton) {
                    verifyButton.disabled = false;
                    verifyButton.innerHTML = this.state.originalVerifyButtonContent;
                }

                if (data.status === 'success' && data.data) {
                    // Create profile object from API response
                    const profile = {
                        name: data.data.content.Customer_Name || data.data.content.customer_name || 'N/A',
                        profile_id: profileId,
                        exam_year: new Date().getFullYear().toString(),
                        verified: true,
                        verification_time: this.state.lastVerification
                    };

                    // Store profile data
                    this.state.jambProfile = profile;

                    // Display profile info
                    this.displayJambProfile(profile);

                    // Log success
                    console.log('JAMB profile verified successfully:', profile);
                } else {
                    // Handle verification failure
                    const errorMessage = data.response_description || 'Could not verify JAMB profile. Please check the ID and try again.';

                    this.showErrorModal(errorMessage);

                    // Log the error details
                    console.error('JAMB verification failed:', data);

                    // Clear any previous profile data
                    this.state.jambProfile = null;
                }
            })
            .catch(error => {
                this.hidePreloader();

                // Re-enable verify button
                if (verifyButton) {
                    verifyButton.disabled = false;
                    verifyButton.innerHTML = this.state.originalVerifyButtonContent;
                }

                console.error('JAMB verification error:', error);
                this.showErrorModal('An error occurred while verifying the JAMB profile. Please try again.');

                // Clear any previous profile data
                this.state.jambProfile = null;
            });
    }

    /**
     * Display JAMB profile information
     */
    displayJambProfile(profile) {
        // Show the inner form now that the profile is verified
        if (this.elements.jambInnerForm) {
            this.elements.jambInnerForm.style.display = 'block';
        }

        // Update customer name display
        if (this.elements.jambCustomerName) {
            this.elements.jambCustomerName.textContent = profile.name || 'N/A';
        }

        // Update profile ID display
        if (this.elements.jambProfileIdDisplay) {
            this.elements.jambProfileIdDisplay.textContent = profile.profile_id || 'N/A';
        }

        // Scroll to make the form visible
        setTimeout(() => {
            if (this.elements.jambInnerForm) {
                this.elements.jambInnerForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }, 300);
    }

    /**
     * Check WAEC result with PIN
     */
    checkWaecResult() {
        const pin = this.elements.waecPinField?.value?.trim();
        const examYear = this.elements.waecExamYear?.value;
        const examType = this.elements.waecExamType?.value;

        if (!pin) {
            this.showErrorModal('Please enter a valid WAEC PIN');
            return;
        }

        if (!examYear) {
            this.showErrorModal('Please select an exam year');
            return;
        }

        if (!examType) {
            this.showErrorModal('Please select an exam type');
            return;
        }

        this.showPreloader();

        // Disable check button and show spinner
        const checkButton = this.elements.checkWaecResult;
        if (checkButton) {
            this.state.originalCheckButtonContent = checkButton.innerHTML;
            checkButton.disabled = true;
            checkButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Checking...`;
        }

        const formData = new FormData();
        formData.append('pin', pin);
        formData.append('exam_year', examYear);
        formData.append('exam_type', examType);
        formData.append('_token', this.config.csrfToken);

        fetch(this.config.waecResultUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                this.hidePreloader();

                // Re-enable check button
                if (checkButton) {
                    checkButton.disabled = false;
                    checkButton.innerHTML = this.state.originalCheckButtonContent;
                }

                if (data.code === '000' && data.content) {
                    // Create mock result structure for display
                    // In a real implementation, the API would return the actual result data
                    const mockResult = {
                        student: {
                            name: "John Doe",
                            exam_number: "1234567890",
                            center: "Lagos Center",
                            exam_year: examYear
                        },
                        subjects: [
                            { name: "Mathematics", grade: "A1", remark: "Excellent" },
                            { name: "English Language", grade: "B2", remark: "Very Good" },
                            { name: "Physics", grade: "B3", remark: "Good" },
                            { name: "Chemistry", grade: "A1", remark: "Excellent" },
                            { name: "Biology", grade: "C4", remark: "Credit" }
                        ],
                        summary: {
                            total_subjects: 5,
                            passed_subjects: 5,
                            failed_subjects: 0
                        }
                    };

                    // Display result in modal
                    this.displayResultModal(mockResult);
                } else {
                    this.showErrorModal(data.response_description || 'Could not check result. Please verify your PIN and try again.');
                }
            })
            .catch(error => {
                this.hidePreloader();

                // Re-enable check button
                if (checkButton) {
                    checkButton.disabled = false;
                    checkButton.innerHTML = this.state.originalCheckButtonContent;
                }

                console.error('Error:', error);
                this.showErrorModal('An error occurred while checking the result. Please try again.');
            });
    }

    /**
     * Display result in modal
     */
    displayResultModal(result) {
        if (!this.elements.resultModal || !this.elements.resultContent) return;

        // Format and display result
        let resultHtml = '';

        if (result.student) {
            resultHtml += `
                <div class="student-info mb-4">
                    <h5 class="border-bottom pb-2">Student Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> ${result.student.name || 'N/A'}</p>
                            <p><strong>Exam Number:</strong> ${result.student.exam_number || 'N/A'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Center:</strong> ${result.student.center || 'N/A'}</p>
                            <p><strong>Exam Year:</strong> ${result.student.exam_year || 'N/A'}</p>
                        </div>
                    </div>
                </div>
            `;
        }

        if (result.subjects && result.subjects.length > 0) {
            resultHtml += `
                <div class="subjects-table">
                    <h5 class="border-bottom pb-2">Examination Results</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Grade</th>
                                    <th>Remark</th>
                                </tr>
                            </thead>
                            <tbody>
            `;

            result.subjects.forEach(subject => {
                resultHtml += `
                    <tr>
                        <td>${subject.name || 'N/A'}</td>
                        <td>${subject.grade || 'N/A'}</td>
                        <td>${subject.remark || 'N/A'}</td>
                    </tr>
                `;
            });

            resultHtml += `
                            </tbody>
                        </table>
                    </div>
                </div>
            `;
        }

        if (result.summary) {
            resultHtml += `
                <div class="result-summary mt-4">
                    <h5 class="border-bottom pb-2">Summary</h5>
                    <p><strong>Total Subjects:</strong> ${result.summary.total_subjects || 'N/A'}</p>
                    <p><strong>Passed Subjects:</strong> ${result.summary.passed_subjects || 'N/A'}</p>
                    <p><strong>Failed Subjects:</strong> ${result.summary.failed_subjects || 'N/A'}</p>
                </div>
            `;
        }

        // Set content and show modal
        this.elements.resultContent.innerHTML = resultHtml;
        const resultModal = new bootstrap.Modal(this.elements.resultModal);
        resultModal.show();
    }

    /**
     * Load transaction history from window.EducationConfig
     */
    loadTransactionHistory() {
        try {
            // Get transaction history from window.EducationConfig instead of API
            const transactions = window.EducationConfig?.transactionHistory || [];

            if (Array.isArray(transactions)) {
                this.state.transactionHistory = transactions;
                this.renderTransactionHistory();
            }
        } catch (error) {
            console.error('Error loading transaction history:', error);
        }
    }

    /**
     * Render transaction history
     */
    renderTransactionHistory() {
        if (!this.elements.transactionHistory) return;

        // Clear existing content
        this.elements.transactionHistory.innerHTML = '';

        // Show a message if no transactions
        if (!this.state.transactionHistory?.length) {
            const emptyState = document.createElement('div');
            emptyState.className = 'text-center p-3';
            emptyState.innerHTML = `
                <p class="text-muted">No transaction history available</p>
            `;
            this.elements.transactionHistory.appendChild(emptyState);
            return;
        }

        // Render each transaction
        this.state.transactionHistory.forEach(transaction => {
            const item = document.createElement('div');
            item.className = 'recent-transaction';

            const statusClass = transaction.status === 'pending' ? 'bg-warning' :
                (transaction.status === 'completed' || transaction.status === 'delivered' ? 'bg-success' : 'bg-danger');

            const statusText = transaction.status === 'delivered' ? 'Completed' :
                transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1);

            // Get proper provider name
            const providerName = transaction.provider ?
                (this.config.providers[transaction.provider]?.name || transaction.provider.toUpperCase()) :
                transaction.product_name || 'Education Service';

            // Get variation name/type if available
            const typeLabel = transaction.type ?
                this.formatTypeLabel(transaction.type) :
                '';

            // Format date
            const date = transaction.created_at ?
                new Date(transaction.created_at).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                }) :
                new Date().toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });

            const amount = transaction.amount || 0;

            item.innerHTML = `
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">${providerName} ${typeLabel}</span>
                        <span class="text-gray-800">₦${this.formatNumberWithCommas(amount)}</span>
                    </div>
                    <div class="text-muted">${date}</div>
                </div>
                <div>
                    <span class="badge ${statusClass}">${statusText}</span>
                </div>
            `;

            this.elements.transactionHistory.appendChild(item);
        });
    }

    /**
     * Add a transaction to the history
     * @param {Object} transaction - Transaction data
     */
    addTransactionToHistory(transaction) {
        if (!transaction) return;

        // Format transaction data
        const formattedTransaction = {
            provider: transaction.provider,
            type: transaction.type,
            product_name: transaction.product_name,
            quantity: transaction.quantity,
            amount: transaction.amount,
            transaction_id: transaction.transaction_id,
            status: transaction.status || 'completed',
            created_at: transaction.created_at || new Date(),
            pins: transaction.pins || []
        };

        // Add to state
        if (!this.state.transactionHistory) {
            this.state.transactionHistory = [];
        }
        this.state.transactionHistory.unshift(formattedTransaction);

        // Update the cached transactions in window.EducationConfig if available
        if (window.EducationConfig) {
            if (!Array.isArray(window.EducationConfig.transactionHistory)) {
                window.EducationConfig.transactionHistory = [];
            }
            window.EducationConfig.transactionHistory.unshift(formattedTransaction);
        }

        // If transaction history element exists, update the UI
        if (this.elements.transactionHistory) {
            // If this is the first transaction, clear the "no transactions" message
            if (this.state.transactionHistory.length === 1) {
                this.elements.transactionHistory.innerHTML = '';
            }

            // Create new transaction element
            const item = document.createElement('div');
            item.className = 'recent-transaction';

            const statusClass = formattedTransaction.status === 'pending' ? 'bg-warning' :
                (formattedTransaction.status === 'completed' || formattedTransaction.status === 'delivered' ? 'bg-success' : 'bg-danger');

            const statusText = formattedTransaction.status === 'delivered' ? 'Completed' :
                formattedTransaction.status.charAt(0).toUpperCase() + formattedTransaction.status.slice(1);

            const providerName = this.config.providers[formattedTransaction.provider]?.name ||
                formattedTransaction.provider.toUpperCase();

            const productName = formattedTransaction.product_name || this.formatTypeLabel(formattedTransaction.type);

            const date = new Date(formattedTransaction.created_at).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });

            item.innerHTML = `
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">${providerName} ${productName}</span>
                        <span class="text-gray-800">₦${this.formatNumberWithCommas(formattedTransaction.amount)}</span>
                    </div>
                    <div class="text-muted">${date}</div>
                </div>
                <div>
                    <span class="badge ${statusClass}">${statusText}</span>
                </div>
            `;

            // Add to the beginning of the list
            if (this.elements.transactionHistory.firstChild) {
                this.elements.transactionHistory.insertBefore(item, this.elements.transactionHistory.firstChild);
            } else {
                this.elements.transactionHistory.appendChild(item);
            }
        }
    }

    /**
     * Retry a failed purchase
     */
    retryPurchase() {
        // Close error modal
        if (this.elements.errorModal) {
            const errorModal = bootstrap.Modal.getInstance(this.elements.errorModal);
            if (errorModal) errorModal.hide();
        }

        // Submit the current provider's form again
        setTimeout(() => {
            this.submitPurchase(this.state.currentProvider);
        }, 300);
    }

    /**
     * Show error modal
     * @param {string} message - The error message to display
     */
    showErrorModal(message) {
        if (!this.elements.errorModal || !this.elements.errorMessage) {
            alert(message);
            return;
        }

        this.elements.errorMessage.textContent = message || 'An error occurred. Please try again.';
        const errorModal = new bootstrap.Modal(this.elements.errorModal);
        errorModal.show();
    }

    /**
     * Show preloader with optional message
     * @param {string} [message] - Optional message to display in the preloader
     */
    showPreloader(message) {
        this.state.loading = true;
        if (this.elements.preloader) {
            this.elements.preloader.style.display = 'flex';

            // Update message if provided and element exists
            if (message && this.elements.loadingText) {
                this.elements.loadingText.textContent = message;
            }
        }
    }

    /**
     * Hide preloader
     */
    hidePreloader() {
        this.state.loading = false;
        if (this.elements.preloader) {
            this.elements.preloader.style.display = 'none';

            // Reset message to default
            if (this.elements.loadingText) {
                this.elements.loadingText.textContent = 'Processing your request...';
            }
        }
    }

    /**
     * Format number with commas
     */
    formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    /**
     * Format amount for display
     */
    formatAmount(amount) {
        const numAmount = parseFloat(amount);
        if (isNaN(numAmount)) return '0.00';
        return this.formatNumberWithCommas(numAmount.toFixed(2));
    }

    /**
     * Handle download receipt button click
     */
    handleDownloadReceipt() {
        // Get transaction details from the modal
        const transactionId = this.elements.transactionId?.textContent || 'N/A';
        const provider = this.elements.successService?.textContent || 'N/A';
        const pinInfo = this.elements.successPin?.textContent || 'N/A';
        const amount = this.elements.successAmount?.textContent || 'N/A';

        // Get the transaction from history if available
        const transaction = this.state.lastTransaction ||
            this.state.transactionHistory?.find(tx => tx.transaction_id === transactionId);

        // Get more details from transaction if available
        const quantity = transaction?.quantity || '1';
        const pins = transaction?.pins || [];

        // Create receipt content
        const receiptTitle = `Education Service Receipt - ${provider}`;
        const receiptDate = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

        // Generate PIN details HTML if available
        let pinsHtml = '';
        if (pins && pins.length > 0) {
            pinsHtml = `
                <h4 class="mt-4 mb-3">PIN Details</h4>
                <div class="pins-section">
            `;

            pins.forEach((pin, index) => {
                pinsHtml += `
                    <div class="receipt-pin-item">
                        <h5>PIN ${index + 1}</h5>
                        <div class="receipt-item">
                            <strong>PIN:</strong>
                            <span>${pin.pin || 'N/A'}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Serial:</strong>
                            <span>${pin.serial || 'N/A'}</span>
                        </div>
                    </div>
                `;
            });

            pinsHtml += `</div>`;
        } else if (pinInfo !== 'N/A') {
            // If we don't have detailed pin info but have a summary
            pinsHtml = `
                <h4 class="mt-4 mb-3">PIN Details</h4>
                <div class="pins-section">
                    <div class="receipt-pin-item">
                        <div class="receipt-item">
                            <strong>PIN/Serial:</strong>
                            <span>${pinInfo}</span>
                        </div>
                    </div>
                </div>
            `;
        }

        // Create a new window for the receipt
        const receiptWindow = window.open('', '_blank');

        // Write receipt HTML
        receiptWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <title>${receiptTitle}</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333;
                        max-width: 800px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .receipt {
                        border: 1px solid #ddd;
                        padding: 20px;
                        border-radius: 10px;
                        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                    }
                    .receipt-header {
                        text-align: center;
                        padding-bottom: 20px;
                        border-bottom: 2px solid #eee;
                    }
                    .receipt-body {
                        margin-top: 20px;
                    }
                    .receipt-item {
                        display: flex;
                        justify-content: space-between;
                        margin-bottom: 10px;
                        padding: 8px 0;
                        border-bottom: 1px solid #eee;
                    }
                    .receipt-item:last-child {
                        border-bottom: none;
                    }
                    .receipt-footer {
                        margin-top: 30px;
                        text-align: center;
                        font-size: 14px;
                        color: #666;
                    }
                    .success-icon {
                        color: #28a745;
                        font-size: 48px;
                        margin-bottom: 10px;
                    }
                    .receipt-pin-item {
                        background-color: #f8f9fa;
                        padding: 15px;
                        margin-bottom: 15px;
                        border-radius: 8px;
                    }
                    .pins-section {
                        margin-top: 20px;
                        border-top: 2px solid #eee;
                        padding-top: 20px;
                    }
                    @media print {
                        body {
                            padding: 0;
                        }
                        .receipt {
                            border: none;
                            box-shadow: none;
                        }
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <div class="receipt">
                    <div class="receipt-header">
                        <div class="success-icon">✓</div>
                        <h2>${receiptTitle}</h2>
                        <p>${receiptDate}</p>
                    </div>

                    <div class="receipt-body">
                        <div class="receipt-item">
                            <strong>Transaction ID:</strong>
                            <span>${transactionId}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Provider:</strong>
                            <span>${provider}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Quantity:</strong>
                            <span>${quantity}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Amount:</strong>
                            <span>${amount}</span>
                        </div>
                    </div>

                    ${pinsHtml}

                    <div class="receipt-footer">
                        <p>Thank you for using our service!</p>
                        <p>This is an electronic receipt. No signature is required.</p>
                        <button class="no-print" onclick="window.print()">Print Receipt</button>
                    </div>
                </div>
            </body>
            </html>
        `);

        // Close the document
        receiptWindow.document.close();

        // Auto-print
        setTimeout(() => {
            receiptWindow.print();
        }, 500);
    }

    /**
     * Update WAEC form visibility based on selected type
     * @param {string} selectedType - The selected form type ('waec' or 'waec-registration')
     */
    updateWaecFormVisibility(selectedType) {
        // Default to 'waec' if no valid selection
        if (selectedType !== 'waec' && selectedType !== 'waec-registration') {
            selectedType = 'waec';
        }

        // Update state
        this.state.currentAction = selectedType;

        // Toggle form visibility based on selection
        if (selectedType === 'waec') {
            // Show Result Checker form, hide Registration form
            if (this.elements.waecResultForm) {
                this.elements.waecResultForm.style.display = 'block';
            }
            if (this.elements.waecRegInnerForm) {
                this.elements.waecRegInnerForm.style.display = 'none';
            }
        } else if (selectedType === 'waec-registration') {
            // Show Registration form, hide Result Checker form
            if (this.elements.waecResultForm) {
                this.elements.waecResultForm.style.display = 'none';
            }
            if (this.elements.waecRegInnerForm) {
                this.elements.waecRegInnerForm.style.display = 'block';
            }
        }
    }

    /**
     * Initialize form visibility on page load
     */
    initFormVisibility() {
        // Set up initial WAEC form visibility
        if (this.elements.waecTypeSelect) {
            // If no option is selected or default is selected, default to first option
            if (!this.elements.waecTypeSelect.value || this.elements.waecTypeSelect.selectedIndex === 0) {
                // Initially hide both forms if no selection
                if (this.elements.waecResultForm) {
                    this.elements.waecResultForm.style.display = 'none';
                }
                if (this.elements.waecRegInnerForm) {
                    this.elements.waecRegInnerForm.style.display = 'none';
                }
            } else {
                // Otherwise update visibility based on current selection
                this.updateWaecFormVisibility(this.elements.waecTypeSelect.value);
            }
        }

        // Initialize JAMB form visibility
        if (this.elements.jambInnerForm) {
            this.elements.jambInnerForm.style.display = 'none';
        }

        // Hide the profile ID container by default until a variation is selected
        const profileIdContainer = document.querySelector('#profileIdContainer');
        if (profileIdContainer) {
            profileIdContainer.style.display = 'none';
        }
    }
}

// Initialize the Education manager when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new EducationManager();
});
