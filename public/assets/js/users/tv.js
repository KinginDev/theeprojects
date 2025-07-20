/**
 * TVManager - A modular, object-oriented implementation for TV subscription management
 */
class TVManager {
    /**
     * Initialize the TV subscription management module
     */
    constructor() {
        // DOM helper methods
        this.$ = selector => document.querySelector(selector);
        this.$$ = selector => Array.from(document.querySelectorAll(selector));

        // Configuration from the global object
        const { purchaseApiUrl, verifyUrl, userBalance, csrfToken } = window.TVPurchaseConfig || {};

        // Application configuration
        this.config = {
            purchaseApiUrl,
            verifyUrl,
            userBalance,
            csrfToken: csrfToken || document.querySelector('meta[name="csrf-token"]').content,
            providers: {
                dstv: {
                    name: 'DSTV',
                    serviceId: 'dstv'
                },
                gotv: {
                    name: 'GOTV',
                    serviceId: 'gotv'
                },
                startime: {
                    name: 'Startimes',
                    serviceId: 'startimes'
                },
                showmax: {
                    name: 'Showmax',
                    serviceId: 'showmax'
                }
            }
        };

        // Application state
        this.state = {
            loading: false,
            currentProvider: 'dstv',
            customerInfo: {},
            lastVerification: 0,
            currentRequest: null,
            debounceTimer: null,
            selectedBouquet: null,
            selectedBouquetAction: 'renew',
            transactionHistory: []
        };

        // Initialize elements and events
        this.initElements();
        this.initProviderTabs();
        this.initEventListeners();
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
            dstvForm: this.$('#dstvForm'),
            gotvForm: this.$('#gotvForm'),
            startimeForm: this.$('#startimeForm'),
            showmaxForm: this.$('#showmaxForm'),

            // Input fields - DSTV
            dstvbillersCode: this.$('#dstvBillersCode'),
            dstvBouquetSelect: this.$('#validationCustom03'),
            dstvSelectBouquet: this.$('#selectBouquet'),
            dstvAmount: this.$('#amount'),
            dstvPhoneNumber: this.$('input[name="tel"]'),

            // Input fields - GOTV
            gotvbillersCode: this.$('#billersCodeGotvInput'),
            gotvBouquetSelect: this.$('#bouquetGotv'),
            gotvSelectBouquet: this.$('#selectBouquetGotv'),
            gotvAmount: this.$('#amountGotv'),
            gotvPhoneNumber: this.$('input[name="telGotv"]'),

            // Input fields - Startimes
            startimebillersCode: this.$('#billersCodeStartime'),
            startimeSelectBouquet: this.$('#selectBouquetStartime'),
            startimeAmount: this.$('#amountStartime'),
            startimePhoneNumber: this.$('input[name="telStartime"]'),

            // Input fields - Showmax
            showmaxSelectBouquet: this.$('#selectBouquetShowmax'),
            showmaxAmount: this.$('#amountShowmax'),
            showmaxPhoneNumber: this.$('input[name="telShowmax"]'),

            // Buttons
            checkBillCodeButton: this.$('#checkBillCodeButton'),
            checkBillcodeGotv: this.$('#checkBillcodeGotv'),
            checkBillcodeStartime: this.$('#checkBillcodeStartime'),
            submitDstv: this.$('#submitDstv'),
            submitGotv: this.$('#submitGotv'),
            submitStartime: this.$('#submitStartime'),
            submitShowmax: this.$('#submitShowmax'),
            retryButton: this.$('#retryButton'),

            // Information sections
            customerInfoDstv: this.$('#customerName'),
            currentBouquetDstv: this.$('#currentBouquet'),
            dueDateDstv: this.$('#dueDate'),
            renewalAmountDstv: this.$('#renewalAmount'),

            customerInfoGotv: this.$('#customerNameGotv'),
            currentBouquetGotv: this.$('#currentBouquetGotv'),
            dueDateGotv: this.$('#dueDateGotv'),
            renewalAmountGotv: this.$('#renewalAmountGotv'),

            customerInfoStartime: this.$('#customerNameStartime'),
            currentBouquetStartime: this.$('#currentBouquetStartime'),
            renewalAmountStartime: this.$('#renewalAmountStartime'),

            // Hidden sections
            dstvInnerForm: this.$("#dstvInnerForm"),
            gotvInnerForm: this.$("#gotvInnerForm"),
            startimeInnerForm: this.$("#startimeInnerForm"),


            // Modals
            successModal: this.$('#successModal'),
            errorModal: this.$('#errorModal'),
            errorMessage: this.$('#errorMessage'),

            // Loading
            preloader: this.$('#loadingOverlay'),

            // Transaction history
            transactionHistory: this.$('#transactionHistory'),

            get selectedBouquet() {
                return document.querySelector("input[name='bouquet']:selcted")
            }
        };

        console.log("MODALS:", {
            successModal: this.elements.successModal,
            errorModal: this.elements.errorModal,
        })

    }

    /**
     * Handle tab click
     * @param {HTMLElement} tab - The clicked tab
     * @param {boolean} updateUrl - Whether to update the URL
     */
    handleTabClick(tab, updateUrl = true) {
        const provider = tab.dataset.biller;
        this.state.currentProvider = provider;

        // Update active state visually
        this.elements.tabItems.forEach(item => {
            item.querySelector('.nav-link').classList.remove('active');
        });
        tab.querySelector('.nav-link').classList.add('active');

        // Show the right tab content
        this.elements.tabContent.forEach(content => {
            content.classList.remove('show', 'active');
            if (content.id === provider) {
                content.classList.add('show', 'active');
            }
        });

        // Update URL hash if needed
        if (updateUrl) {
            window.location.hash = provider;
        }

        console.log(`Current provider set to: ${provider}`);

        // If it's Showmax, load the bouquets
        if (provider === 'showmax' && this.elements.showmaxSelectBouquet && !this.elements.showmaxSelectBouquet.options.length) {
            this.loadBouquets('showmax');
        }
    }

    /**
     * Initialize provider tabs
     */
    initProviderTabs() {
        // Create the tab navigation items
        const tabNav = this.$('.nav-pills');
        if (tabNav) {
            tabNav.innerHTML = '';

            Object.entries(this.config.providers).forEach(([key, provider], index) => {
                const icon = key === 'showmax' ? 'showmax.png' : `${key}.png`;
                const isActive = index === 0;

                const tabItem = document.createElement('li');
                tabItem.className = 'nav-item custom-tab-item';
                tabItem.setAttribute('role', 'presentation');
                tabItem.dataset.biller = key;

                tabItem.innerHTML = `
                    <a class="nav-link ${isActive ? 'active' : ''}" data-bs-toggle="tab" href="#${key}" role="tab">
                        <img src="/assets/images/brands/${icon}" alt="${provider.name}" class="provider-icon">

                    </a>
                `;

                tabNav.appendChild(tabItem);
            });

            // Update the tabs reference after creating them
            this.elements.tabItems = this.$$('.custom-tab-item');
            this.elements.tabLinks = this.$$('.nav-link');

            // Check for URL hash to set active tab
            this.loadTabFromUrlHash();
        }
    }

    /**
     * Load active tab from URL hash
     */
    loadTabFromUrlHash() {
        const hash = window.location.hash.substring(1); // Remove the # character

        if (hash && this.config.providers[hash]) {
            // Find the tab with the matching provider
            const tabToActivate = this.elements.tabItems.find(tab => tab.dataset.biller === hash);

            if (tabToActivate) {
                // Activate the tab without updating URL (to prevent recursive changes)
                this.handleTabClick(tabToActivate, false);

                // Scroll to the tab content to ensure it's visible
                setTimeout(() => {
                    const tabContent = document.getElementById(hash);
                    if (tabContent) {
                        tabContent.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 100);
            }
        }
    }

    /**
     * Initialize event listeners
     */
    initEventListeners() {
        // Provider tab selection
        this.elements.tabItems.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                this.handleTabClick(tab, true);
            });
        });

        // Listen for hash changes
        window.addEventListener('hashchange', () => {
            this.loadTabFromUrlHash();
        });

        // DSTV form events
        if (this.elements.dstvForm) {
            this.elements.dstvForm.addEventListener('submit', e => {
                e.preventDefault();
                this.verifySmartCard('dstv');
            });

            console.log("DSTV", this.elements.dstvbillersCode)
            console.log("DSTV Form", this.elements.dstvForm)

            if (this.elements.dstvbillersCode) {
                this.elements.dstvbillersCode.addEventListener('input', () => {
                    this.validateInput('dstv');
                });

                // Add focusin event to show helpful instruction
                this.elements.dstvbillersCode.addEventListener('focusin', () => {
                    const small = this.elements.dstvbillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Type your DSTV smart card number and we will verify it automatically';
                    }
                });

                // Add focusout event to restore original help text
                this.elements.dstvbillersCode.addEventListener('focusout', () => {
                    const small = this.elements.dstvbillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Enter the smartcard number printed on your DSTV decoder';
                    }
                });
            }

            if (this.elements.dstvBouquetSelect) {
                this.elements.dstvBouquetSelect.addEventListener('change', () => {
                    this.handleBouquetSelectionChange('dstv');
                });
            }

            if (this.elements.submitDstv) {
                this.elements.submitDstv.addEventListener('click', e => {
                    e.preventDefault();
                    this.submitPurchase('dstv');
                });
            }
        }

        // GOTV form events
        if (this.elements.gotvForm) {
            this.elements.gotvForm.addEventListener('submit', e => {
                e.preventDefault();
                console.log("Submitting GOTV form");
                this.verifySmartCard('gotv');
            });
            console.log("GOTV", this.elements.gotvbillersCode)
            console.log("GOTV Form", this.elements.gotvForm)

            if (this.elements.gotvbillersCode) {
                this.elements.gotvbillersCode.addEventListener('input', () => {
                    console.log("Validating GOTV input");
                    this.validateInput('gotv');
                });

                // Add focusin event to show helpful instruction
                this.elements.gotvbillersCode.addEventListener('focusin', () => {
                    const small = this.elements.gotvbillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Type your GOTV IUC number and we will verify it automatically';
                    }
                });

                // Add focusout event to restore original help text
                this.elements.gotvbillersCode.addEventListener('focusout', () => {
                    const small = this.elements.gotvbillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Enter the IUC number printed on your GOTV decoder';
                    }
                });
            }

            if (this.elements.gotvBouquetSelect) {
                this.elements.gotvBouquetSelect.addEventListener('change', () => {
                    this.handleBouquetSelectionChange('gotv');
                });
            }

            if (this.elements.submitGotv) {
                this.elements.submitGotv.addEventListener('click', e => {
                    e.preventDefault();
                    this.submitPurchase('gotv');
                });
            }
        }

        // Startimes form events
        if (this.elements.startimeForm) {
            this.elements.startimeForm.addEventListener('submit', e => {
                e.preventDefault();
                this.verifySmartCard('startime');
            });

            if (this.elements.startimebillersCode) {
                this.elements.startimebillersCode.addEventListener('input', () => {
                    this.validateInput('startime');
                });

                // Add focusin event to show helpful instruction
                this.elements.startimebillersCode.addEventListener('focusin', () => {
                    const small = this.elements.startimebillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Type your Startimes smart card number and we will verify it automatically';
                    }
                });

                // Add focusout event to restore original help text
                this.elements.startimebillersCode.addEventListener('focusout', () => {
                    const small = this.elements.startimebillersCode.parentElement.nextElementSibling;
                    if (small && small.tagName.toLowerCase() === 'small') {
                        small.textContent = 'Enter the smartcard number printed on your Startimes decoder';
                    }
                });
            }

            if (this.elements.startimeSelectBouquet) {
                this.elements.startimeSelectBouquet.addEventListener('change', () => {
                    this.handleBouquetChange('startime');
                });
            }

            if (this.elements.submitStartime) {
                this.elements.submitStartime.addEventListener('click', e => {
                    e.preventDefault();
                    this.submitPurchase('startime');
                });
            }
        }

        // Showmax form events
        if (this.elements.showmaxForm) {
            this.elements.showmaxForm.addEventListener('submit', e => {
                e.preventDefault();
                this.submitPurchase('showmax');
            });

            if (this.elements.showmaxSelectBouquet) {
                this.elements.showmaxSelectBouquet.addEventListener('change', () => {
                    this.handleBouquetChange('showmax');
                });
            }
        }

        // Load Showmax bouquets on page load
        this.loadBouquets('showmax');

        // Retry button
        if (this.elements.retryButton) {
            this.elements.retryButton.addEventListener('click', () => {
                this.retryPurchase();
            });
        }

        // Download receipt button in success modal
        const downloadReceiptButton = document.getElementById('downloadReceipt');
        if (downloadReceiptButton) {
            downloadReceiptButton.addEventListener('click', () => this.handleDownloadReceipt());
        }
    }

    /**
     * Verify a smart card number
     * @param {string} provider - The TV provider
     */
    verifySmartCard(provider) {
        let billersCodeInput;
        let checkButton;
        let serviceId;

        switch (provider) {
            case 'dstv':
                billersCodeInput = this.elements.dstvbillersCode;
                checkButton = this.elements.checkBillCodeButton;
                serviceId = 'dstv';
                break;
            case 'gotv':
                billersCodeInput = this.elements.gotvbillersCode;
                checkButton = this.elements.checkBillcodeGotv;
                serviceId = 'gotv';
                break;
            case 'startime':
                billersCodeInput = this.elements.startimebillersCode;
                checkButton = this.elements.checkBillcodeStartime;
                serviceId = 'startimes';
                break;
        }

        if (!billersCodeInput || !checkButton) return;

        const billersCode = billersCodeInput.value.trim();

        if (!billersCode) {
            this.showErrorModal('Please enter a valid smart card number');
            return;
        }

        this.showPreloader();

        // Store the original button content
        const originalButtonContent = checkButton.innerHTML;
        checkButton.disabled = true;
        checkButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Verifying...`;

        const formData = new FormData();
        formData.append('billersCode', billersCode);
        formData.append('service_name', serviceId); // Add service_name as per the requirement
        formData.append('_token', this.config.csrfToken);

        console.log("Post Form Data:", formData.values)

        // Make the API call
        fetch(this.config.verifyUrl, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                this.hidePreloader();
                checkButton.disabled = false;
                checkButton.innerHTML = originalButtonContent;

                // Remove the validating state
                billersCodeInput.classList.remove('is-validating');

                // Get validation icon
                const validationIcon = billersCodeInput.parentElement.querySelector('.validation-icon');

                if (data.status === 'success' && data.data) {
                    // Update validation state to success
                    if (validationIcon) {
                        validationIcon.classList.remove('invalid');
                        validationIcon.classList.add('valid');
                        validationIcon.textContent = 'check_circle';
                    }

                    // Store customer info in state
                    this.state.customerInfo[provider] = data.data;
                    console.log("--Customer Info for", provider, ":", this.state.customerInfo[provider]);
                    // Display customer info
                    this.displayCustomerInfo(provider, data.data);

                    // Update check button to show verification success
                    if (checkButton) {
                        checkButton.innerHTML = `<span class="material-icons-round me-2">check_circle</span> Verified Successfully`;
                        checkButton.classList.add('verified-button');

                        // Hide the button after 2 seconds
                        setTimeout(() => {
                            checkButton.style.display = 'none';
                        }, 2000);
                    }

                    // Load bouquet options if it's not showmax (showmax is loaded differently)
                    if (provider !== 'showmax') {
                        this.loadBouquets(provider);
                    }
                } else {
                    // Update validation state to error
                    if (validationIcon) {
                        validationIcon.classList.remove('valid');
                        validationIcon.classList.add('invalid');
                        validationIcon.textContent = 'error';
                    }
                    billersCodeInput.classList.remove('is-valid');
                    billersCodeInput.classList.add('is-invalid');

                    console.log(data.message)
                    this.showErrorModal(data.message || 'Failed to verify smart card. Please check the number and try again.');
                }
            })
            .catch(error => {
                this.hidePreloader();
                checkButton.disabled = false;
                checkButton.innerHTML = originalButtonContent;

                // Remove the validating state and update to error state
                billersCodeInput.classList.remove('is-validating', 'is-valid');
                billersCodeInput.classList.add('is-invalid');

                // Update validation icon
                const validationIcon = billersCodeInput.parentElement.querySelector('.validation-icon');
                if (validationIcon) {
                    validationIcon.classList.remove('valid');
                    validationIcon.classList.add('invalid');
                    validationIcon.textContent = 'error';
                }

                console.error('Error:', error);
                this.showErrorModal('An error occurred while verifying your smart card. Please try again.');
            });
    }

    /**
     * Display customer information
     * @param {string} provider - The TV provider
     * @param {Object} info - Customer information
     */
    displayCustomerInfo(provider, info) {
        let customerNameEl, currentBouquetEl, dueDateEl, renewalAmountEl, innerForm, submitButton;

        switch (provider) {
            case 'dstv':
                customerNameEl = this.elements.customerInfoDstv;
                currentBouquetEl = this.elements.currentBouquetDstv;
                dueDateEl = this.elements.dueDateDstv;
                renewalAmountEl = this.elements.renewalAmountDstv;
                innerForm = this.elements.dstvInnerForm;
                submitButton = this.elements.submitDstv;
                break;
            case 'gotv':
                customerNameEl = this.elements.customerInfoGotv;
                currentBouquetEl = this.elements.currentBouquetGotv;
                dueDateEl = this.elements.dueDateGotv;
                renewalAmountEl = this.elements.renewalAmountGotv;
                innerForm = this.elements.gotvInnerForm;
                submitButton = this.elements.submitGotv;
                break;
            case 'startime':
                customerNameEl = this.elements.customerInfoStartime;
                currentBouquetEl = this.elements.currentBouquetStartime;
                renewalAmountEl = this.elements.renewalAmountStartime;
                innerForm = this.elements.startimeInnerForm;
                submitButton = this.elements.submitStartime;
                break;
        }

        if (customerNameEl) customerNameEl.textContent = info.Customer_Name || 'N/A';
        if (currentBouquetEl) currentBouquetEl.textContent = info.Current_Bouquet || info.Smartcard_Number || 'N/A';
        if (dueDateEl) dueDateEl.textContent = info.Due_Date || 'N/A';
        if (renewalAmountEl) renewalAmountEl.textContent = '₦' + (info.Renewal_Amount || info.Balance || '0');

        // Show customer info and inner form
        if (innerForm) {
            innerForm.style.display = 'block';

            // Scroll to make the customer info visible
            setTimeout(() => {
                innerForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }, 300);
        }

        // Store the verification status in state
        this.state.verificationStatus = this.state.verificationStatus || {};
        this.state.verificationStatus[provider] = true;

        // Enable the bouquet selection
        this.enableBouquetSelection(provider);
    }

    /**
     * Enable bouquet selection
     * @param {string} provider - The TV provider
     */
    enableBouquetSelection(provider) {
        let bouquetSelect;

        switch (provider) {
            case 'dstv':
                bouquetSelect = this.elements.dstvBouquetSelect;
                break;
            case 'gotv':
                bouquetSelect = this.elements.gotvBouquetSelect;
                break;
        }

        if (bouquetSelect) {
            bouquetSelect.disabled = false;
        }
    }

    /**
     * Handle bouquet selection change
     * @param {string} provider - The TV provider
     */
    handleBouquetSelectionChange(provider) {
        let bouquetSelect, selectBouquetContainer, amountContainer, amountField, renewalAmount;

        switch (provider) {
            case 'dstv':
                bouquetSelect = this.elements.dstvBouquetSelect;
                selectBouquetContainer = this.$('#selectBouquetContainer');
                amountContainer = this.$('#amountContainer');
                amountField = this.elements.dstvAmount;
                renewalAmount = this.elements.renewalAmountDstv;
                break;
            case 'gotv':
                bouquetSelect = this.elements.gotvBouquetSelect;
                selectBouquetContainer = this.$('#selectBouquetContainerGotv');
                amountContainer = this.$('#amountContainerGotv');
                amountField = this.elements.gotvAmount;
                renewalAmount = this.elements.renewalAmountGotv;
                break;
        }

        if (!bouquetSelect) return;

        const selectedValue = bouquetSelect.value;

        // Store the selected bouquet action in state
        this.state.selectedBouquetAction = selectedValue;
        console.log(`Selected bouquet action set to: ${selectedValue}`);

        if (selectedValue === 'change') {
            if (selectBouquetContainer) selectBouquetContainer.style.display = 'block';
            if (amountContainer) amountContainer.style.display = 'none';

            // Load bouquet options
            this.loadBouquets(provider, true);
        } else if (selectedValue === 'renew') {
            if (selectBouquetContainer) selectBouquetContainer.style.display = 'none';
            if (amountContainer) amountContainer.style.display = 'block';

            // Set amount to renewal amount from customer info
            if (amountField) {
                let amount = '0';

                // Try to get amount from customer info first
                if (this.state.customerInfo && this.state.customerInfo[provider]) {
                    const info = this.state.customerInfo[provider];
                    amount = info.Renewal_Amount || info.Balance || '0';
                    console.log(`Found renewal amount from customer info: ${amount}`);
                }
                // Fallback to the renewal amount element
                else if (renewalAmount) {
                    amount = renewalAmount.textContent.replace('₦', '');
                    console.log(`Using renewal amount from element: ${amount}`);
                }

                // Ensure we have a valid amount
                if (!amount || amount === '0' || amount === 'undefined') {
                    console.warn('No valid amount found, checking alternative sources');

                    // Try to get it from the displayed renewal amount as a last resort
                    if (renewalAmount) {
                        amount = renewalAmount.textContent.replace('₦', '');
                    }

                    // If still not valid, check if there's a fixed amount we could use
                    if (!amount || amount === '0' || amount === 'undefined') {
                        const customerInfo = this.state.customerInfo[provider];
                        if (customerInfo && customerInfo.Current_Bouquet) {
                            console.log('Trying to determine amount from bouquet name:', customerInfo.Current_Bouquet);
                            // This would require a mapping of bouquet names to amounts
                            // For now, we'll log this for debugging purposes
                        }
                    }
                }

                amountField.value = amount;
                console.log(`Setting renewal amount to: ${amount}`);
            }
        }
    }

    /**
     * Handle bouquet change for direct selection (Startimes and Showmax)
     * @param {string} provider - The TV provider
     */
    handleBouquetChange(provider) {
        let selectBouquet, amountContainer, amountField;

        switch (provider) {
            case 'startime':
                selectBouquet = this.elements.startimeSelectBouquet;
                amountContainer = this.$('#amountContainerStartime');
                amountField = this.elements.startimeAmount;
                break;
            case 'showmax':
                selectBouquet = this.elements.showmaxSelectBouquet;
                amountContainer = this.$('#amountContainerShowmax');
                amountField = this.elements.showmaxAmount;
                break;
        }

        if (!selectBouquet) return;

        const selectedOption = selectBouquet.options[selectBouquet.selectedIndex];
        if (!selectedOption) return;

        const amount = selectedOption.dataset.amount;
        const selectedValue = selectedOption.value;

        // Store the selected bouquet in state
        this.state.selectedBouquet = selectedValue;
        console.log(`Selected bouquet set to: ${selectedValue} with amount: ${amount}`);

        if (amountContainer) amountContainer.style.display = 'block';

        // Ensure we have a valid amount
        if (amountField && amount) {
            amountField.value = amount;
            console.log(`Setting amount field to: ${amount}`);
        } else {
            console.warn('No amount data found for the selected bouquet');
        }
    }

    /**
     * Load bouquet options from VTPass API
     * @param {string} provider - The TV provider
     * @param {boolean} changeOnly - Whether this is for changing bouquet only
     */
    loadBouquets(provider, changeOnly = false) {
        let serviceId, selectElement;

        switch (provider) {
            case 'dstv':
                serviceId = 'dstv';
                selectElement = this.elements.dstvSelectBouquet;
                break;
            case 'gotv':
                serviceId = 'gotv';
                selectElement = this.elements.gotvSelectBouquet;
                break;
            case 'startime':
                serviceId = 'startimes';
                selectElement = this.elements.startimeSelectBouquet;
                break;
            case 'showmax':
                serviceId = 'showmax';
                selectElement = this.elements.showmaxSelectBouquet;
                break;
        }

        if (!selectElement) return;

        // Show preloader if this is a user-initiated action
        if (changeOnly) this.showPreloader();

        fetch(`https://sandbox.vtpass.com/api/service-variations?serviceID=${serviceId}`)
            .then(response => response.json())
            .then(data => {
                if (changeOnly) this.hidePreloader();

                if (data && data.content && data.content.variations) {
                    const variations = data.content.variations;

                    // Clear the select
                    selectElement.innerHTML = '';

                    // Add default option
                    const defaultOption = document.createElement('option');
                    defaultOption.value = '';
                    defaultOption.disabled = true;
                    defaultOption.selected = true;
                    defaultOption.textContent = 'Please select type...';
                    selectElement.appendChild(defaultOption);

                    // Add the bouquets
                    variations.forEach(variation => {
                        const option = document.createElement('option');
                        option.value = variation.variation_code;
                        option.textContent = variation.name;
                        option.dataset.amount = variation.variation_amount;
                        selectElement.appendChild(option);
                    });

                    // Show the container
                    const container = selectElement.closest('.mb-4');
                    if (container) container.style.display = 'block';

                    // Add change event listener to all bouquet select dropdowns
                    selectElement.addEventListener('change', () => {
                        const selectedOption = selectElement.options[selectElement.selectedIndex];
                        if (selectedOption) {
                            const bouquetValue = selectedOption.value;
                            const bouquetAmount = selectedOption.dataset.amount;

                            // Store selected bouquet in state
                            this.state.selectedBouquet = bouquetValue;
                            console.log(`Selected bouquet set to: ${this.state.selectedBouquet} with amount: ${bouquetAmount}`);

                            // For direct selection providers, handle the bouquet change
                            if (provider === 'startime' || provider === 'showmax') {
                                this.handleBouquetChange(provider);
                            } else if ((provider === 'dstv' || provider === 'gotv') && this.state.selectedBouquetAction === 'change') {
                                // For DSTV/GOTV when changing bouquet, set the amount field
                                const amountField = provider === 'dstv' ? this.elements.dstvAmount : this.elements.gotvAmount;
                                if (amountField && bouquetAmount) {
                                    amountField.value = bouquetAmount;
                                    console.log(`Setting amount for ${provider} change to: ${bouquetAmount}`);

                                    // Show the amount container
                                    const amountContainer = provider === 'dstv' ?
                                        this.$('#amountContainer') :
                                        this.$('#amountContainerGotv');
                                    if (amountContainer) amountContainer.style.display = 'block';
                                }
                            }
                        }
                    });
                } else {
                    console.error('Invalid bouquet data structure:', data);
                }
            })
            .catch(error => {
                if (changeOnly) this.hidePreloader();
                console.error('Error fetching bouquets:', error);
            });
    }

    /**
     * Submit a purchase
     * @param {string} provider - The TV provider
     */
    submitPurchase(provider) {
        let form, serviceId, endpoint;

        switch (provider) {
            case 'dstv':
                form = this.elements.dstvForm;
                serviceId = 'dstv';
                break;
            case 'gotv':
                form = this.elements.gotvForm;
                serviceId = 'gotv';
                break;
            case 'startime':
                form = this.elements.startimeForm;
                serviceId = 'startimes';
                break;
            case 'showmax':
                form = this.elements.showmaxForm;
                serviceId = 'showmax';
                break;
        }

        endpoint = this.config.purchaseApiUrl;

        if (!form) return;

        // Validate form data
        const isValid = this.validateForm(provider);
        if (!isValid) return;

        // Show preloader
        this.showPreloader();

        // Disable submit button and show spinner
        const submitButton = form.querySelector('button[type="submit"]') || form.querySelector('button');
        if (submitButton) {
            this.state.originalButtonContent = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processing...`;
        }

        // Get amount field value
        const amountField = form.querySelector('input[name="amount"]');
        const amountValue = amountField ? amountField.value.trim() : '';

        // Log amount value for debugging
        console.log(`Amount value for ${provider}: ${amountValue}`);

        // Prepare form data
        const formData = new FormData(form);
        formData.append('service_name', serviceId);

        // Get the phone number based on the provider
        let phoneNumber = '';
        if (provider === 'dstv') {
            phoneNumber = form.querySelector('input[name="tel"]')?.value.trim() || '';
        } else if (provider === 'gotv') {
            phoneNumber = form.querySelector('input[name="telGotv"]')?.value.trim() || '';
        } else if (provider === 'startime') {
            phoneNumber = form.querySelector('input[name="telStartime"]')?.value.trim() || '';
        } else if (provider === 'showmax') {
            phoneNumber = form.querySelector('input[name="telShowmax"]')?.value.trim() || '';
        }

        formData.append('tel', phoneNumber);
        formData.append('_token', this.config.csrfToken);

        // Ensure amount is added
        if (amountValue) {
            formData.append('amount', amountValue);
        }

        // Add the bouquet action if applicable (for DSTV and GOTV)
        if ((provider === 'dstv' || provider === 'gotv') && this.state.selectedBouquetAction) {
            formData.append('bouquetAction', this.state.selectedBouquetAction);
            console.log(`Adding bouquet action to request: ${this.state.selectedBouquetAction}`);

            // If it's a change action and we have a selected bouquet from the dropdown, include it
            if (this.state.selectedBouquetAction === 'change' && this.state.selectedBouquet) {
                formData.append('selectedBouquet', this.state.selectedBouquet);
                console.log(`Adding selected bouquet to request: ${this.state.selectedBouquet}`);
            }
        }
        // For direct selection providers (Startimes and Showmax)
        else if ((provider === 'startime' || provider === 'showmax') && this.state.selectedBouquet) {
            formData.append('selectedBouquet', this.state.selectedBouquet);
            console.log(`Adding selected bouquet to request: ${this.state.selectedBouquet}`);
        }

        // Log all form data for debugging
        console.log('Form data being sent:');
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }

        // Make the API call
        fetch(endpoint, {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then((data) => {
                this.hidePreloader();

                // Re-enable submit button
                if (submitButton) {
                    submitButton.disabled = false;
                    submitButton.innerHTML = this.state.originalButtonContent;
                }

                if (data.status === 'success') {
                    // Update success modal details
                    console.log("Response Data:", data);
                    if (this.elements.successModal) {
                        // Update transaction details in the modal
                        const transactionIdEl = this.elements.successModal.querySelector('#transactionId');
                        const providerEl = this.elements.successModal.querySelector('#successProvider');
                        const smartCardEl = this.elements.successModal.querySelector('#successSmartCard');
                        const packageEl = this.elements.successModal.querySelector('#successPackage');
                        const amountEl = this.elements.successModal.querySelector('#successAmount');
                        const successTypeEl = this.elements.successModal.querySelector('#successType');

                        if (transactionIdEl) transactionIdEl.textContent = data.content?.requestId || 'N/A';


                        if (providerEl) providerEl.textContent = this.state.currentProvider.toUpperCase() || 'N/A';

                        if (smartCardEl) smartCardEl.textContent = data.billers_code || 'N/A';

                        if (packageEl) packageEl.textContent = this.state.selectedBouquet || 'N/A';
                        if (amountEl) amountEl.textContent = '₦' + this.formatAmount(data?.amount || 0);

                        if (successTypeEl) successTypeEl.textContent = this.state.selectedBouquetAction === 'change' ? 'Change Bouquet' : 'Renewal';

                        // Show the modal
                        const successModal = new bootstrap.Modal(this.elements.successModal);
                        successModal.show();
                    }

                    // Add to transaction history
                    this.addTransactionToHistory(data?.content);

                } else {
                    this.showErrorModal(data.message || 'Transaction failed. Please try again.');
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
                this.showErrorModal(error.message || 'An error occurred while processing your request. Please try again.');
            });
    }

    /**
     * Validate form data before submission
     * @param {string} provider - The TV provider
     * @returns {boolean} - Whether the form is valid
     */
    validateForm(provider) {
        let form, billersCode, phoneNumber, amount;

        switch (provider) {
            case 'dstv':
                form = this.elements.dstvForm;
                billersCode = this.elements.dstvbillersCode;
                phoneNumber = this.elements.dstvPhoneNumber;
                amount = this.elements.dstvAmount;
                break;
            case 'gotv':
                form = this.elements.gotvForm;
                billersCode = this.elements.gotvbillersCode;
                phoneNumber = this.elements.gotvPhoneNumber;
                amount = this.elements.gotvAmount;
                break;
            case 'startime':
                form = this.elements.startimeForm;
                billersCode = this.elements.startimebillersCode;
                phoneNumber = this.elements.startimePhoneNumber;
                amount = this.elements.startimeAmount;
                break;
            case 'showmax':
                form = this.elements.showmaxForm;
                phoneNumber = this.elements.showmaxPhoneNumber;
                amount = this.elements.showmaxAmount;
                break;
        }

        if (!form) return false;

        // For all providers except Showmax, validate biller code and verification
        if (provider !== 'showmax') {
            // Check if smart card number is provided
            if (!billersCode || !billersCode.value.trim()) {
                this.showErrorModal('Please enter a valid smart card number');
                return false;
            }

            // Check if smart card has been verified
            const isVerified = this.state.verificationStatus && this.state.verificationStatus[provider];
            if (!isVerified) {
                this.showErrorModal('Please verify your smart card number first');

                // Highlight the input field and scroll to it
                billersCode.classList.add('is-invalid');
                billersCode.scrollIntoView({ behavior: 'smooth', block: 'center' });

                return false;
            }
        }

        // For all providers, validate phone number
        if (!phoneNumber || !phoneNumber.value.trim()) {
            this.showErrorModal('Please enter a valid phone number');
            return false;
        }

        // Validate phone number format (Nigeria)
        const phoneRegex = /^(0|\+?234)[789][01]\d{8}$/;
        if (!phoneRegex.test(phoneNumber.value.trim())) {
            this.showErrorModal('Please enter a valid Nigerian phone number');
            return false;
        }

        // For all providers, validate amount
        if (!amount || !amount.value || parseFloat(amount.value) <= 0) {
            console.warn('Invalid amount detected:', amount?.value);

            // Check if this is a change bouquet action where amount might come from selection
            if ((provider === 'dstv' || provider === 'gotv') &&
                this.state.selectedBouquetAction === 'change' &&
                this.state.selectedBouquet) {

                // For change action, we should have a selected bouquet which has an amount
                const selectElement = provider === 'dstv' ?
                    this.elements.dstvSelectBouquet :
                    this.elements.gotvSelectBouquet;

                if (selectElement) {
                    const selectedOption = Array.from(selectElement.options).find(
                        option => option.value === this.state.selectedBouquet
                    );

                    if (selectedOption && selectedOption.dataset.amount) {
                        // We have an amount from the selected bouquet, set it to the amount field
                        if (amount) {
                            amount.value = selectedOption.dataset.amount;
                            console.log(`Setting amount from selected bouquet: ${amount.value}`);
                            // Continue with submission
                            return true;
                        }
                    }
                }
            }

            // For direct selection providers, check if we have a selected bouquet
            if ((provider === 'startime' || provider === 'showmax') && this.state.selectedBouquet) {
                const selectElement = provider === 'startime' ?
                    this.elements.startimeSelectBouquet :
                    this.elements.showmaxSelectBouquet;

                if (selectElement) {
                    const selectedOption = Array.from(selectElement.options).find(
                        option => option.value === this.state.selectedBouquet
                    );

                    if (selectedOption && selectedOption.dataset.amount) {
                        // We have an amount from the selected bouquet, set it to the amount field
                        if (amount) {
                            amount.value = selectedOption.dataset.amount;
                            console.log(`Setting amount from selected bouquet: ${amount.value}`);
                            // Continue with submission
                            return true;
                        }
                    }
                }
            }

            // If we get here, we don't have a valid amount
            this.showErrorModal('Please select a valid subscription amount');

            // Highlight the amount field if it exists
            if (amount) {
                amount.classList.add('is-invalid');
                amount.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            return false;
        }

        // Check if user has enough balance
        const userBalance = this.config.userBalance || 0;
        if (parseFloat(amount.value) > userBalance) {
            this.showErrorModal('Insufficient wallet balance. Please fund your wallet and try again.');
            return false;
        }

        return true;
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
     * Load transaction history
     */
    loadTransactionHistory() {
        // This would typically fetch from an API
        // For demonstration, we're just using the static content already in the HTML

        // Example of how you'd implement this:
        /*
        fetch('/api/transactions/tv')
            .then(response => response.json())
            .then(data => {
                this.state.transactionHistory = data;
                this.renderTransactionHistory();
            })
            .catch(error => {
                console.error('Error fetching transaction history:', error);
            });
        */
    }

    /**
     * Render transaction history
     */
    renderTransactionHistory() {
        if (!this.elements.transactionHistory || !this.state.transactionHistory.length) return;

        this.elements.transactionHistory.innerHTML = '';

        this.state.transactionHistory.forEach(transaction => {
            const item = document.createElement('div');
            item.className = 'recent-transaction';

            const statusClass = transaction.status === 'pending' ? 'bg-warning' :
                (transaction.status === 'delivered' ? 'bg-success' : 'bg-danger');

            item.innerHTML = `
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between">
                        <span class="text-gray-600">${transaction.provider} ${transaction.bouquet}</span>
                        <span class="text-gray-800">₦${this.formatNumberWithCommas(transaction.amount)}</span>
                    </div>
                    <div class="text-muted">${transaction.date}</div>
                </div>
                <div>
                    <span class="badge ${statusClass}">${transaction.status}</span>
                </div>
            `;

            this.elements.transactionHistory.appendChild(item);
        });
    }

    /**
     * Add a transaction to the history
     * @param {Object} transaction - The transaction data
     */
    addTransactionToHistory(transaction) {
        if (!this.elements.transactionHistory || !transaction) return;

        // Format transaction data
        const formattedTransaction = {
            provider: this.config.providers[this.state.currentProvider].name,
            bouquet: transaction.bouquet || 'Subscription',
            amount: transaction.amount || 0,
            date: new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            }),
            status: 'Processing'
        };

        // Add to state
        this.state.transactionHistory.unshift(formattedTransaction);

        // Create and add the element
        const item = document.createElement('div');
        item.className = 'recent-transaction';

        item.innerHTML = `
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    <span class="text-gray-600">${formattedTransaction.provider} ${formattedTransaction.bouquet}</span>
                    <span class="text-gray-800">₦${this.formatNumberWithCommas(formattedTransaction.amount)}</span>
                </div>
                <div class="text-muted">${formattedTransaction.date}</div>
            </div>
            <div>
                <span class="badge bg-warning">Processing</span>
            </div>
        `;

        // Add to the beginning of the list (before existing transactions)
        if (this.elements.transactionHistory.firstChild) {
            this.elements.transactionHistory.insertBefore(item, this.elements.transactionHistory.firstChild);
        } else {
            this.elements.transactionHistory.appendChild(item);
        }
    }

    /**
     * Show error modal
     * @param {string} message - The error message
     */
    showErrorModal(message) {
        if (!this.elements.errorModal) {
            alert(message);
            return;
        }

        const errorModalEl = this.elements.errorModal;
        // Update the error message
        if (errorModalEl) {
            const errorMessageEl = errorModalEl.querySelector('.error-message');
            if (errorMessageEl) {
                errorMessageEl.textContent = message || 'An error occurred. Please try again.';
            } else {
                console.warn('Error message element not found in error modal');
            }
        }

        // Get the modal instance
        const errorModal = new bootstrap.Modal(this.elements.errorModal);

        // Add a one-time event listener for when modal is shown
        this.elements.errorModal.addEventListener('shown.bs.modal', function onShown() {
            // Focus the retry button
            const retryBtn = document.getElementById('retryButton');
            if (retryBtn) {
                retryBtn.focus();
            }
            // Remove the one-time event listener
            this.removeEventListener('shown.bs.modal', onShown);
        });

        // Show the modal
        errorModal.show();
    }

    /**
     * Show preloader
     */
    showPreloader() {
        this.state.loading = true;
        if (this.elements.preloader) {
            this.elements.preloader.style.display = 'flex';
        }
    }

    /**
     * Hide preloader
     */
    hidePreloader() {
        this.state.loading = false;
        if (this.elements.preloader) {
            this.elements.preloader.style.display = 'none';
        }
    }

    /**
     * Format number with commas
     * @param {number} number - The number to format
     * @returns {string} - The formatted number
     */
    formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    formatSlugToTitle(slug) {
        // Convert slug to title case
        return slug
            .split('-')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }

    /**
     * Format amount for display
     * @param {number|string} amount - The amount to format
     * @returns {string} - The formatted amount with commas
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
        const transactionId = this.$('#transactionId')?.textContent || 'N/A';
        const provider = this.$('#successProvider')?.textContent || 'N/A';
        const smartCard = this.$('#successSmartCard')?.textContent || 'N/A';
        const packageName = this.$('#successPackage')?.textContent || 'N/A';
        const amount = this.$('#successAmount')?.textContent || 'N/A';

        // Create receipt content
        const receiptTitle = `TV Subscription Receipt - ${provider}`;
        const receiptDate = new Date().toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });

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
                            <strong>Smart Card/IUC:</strong>
                            <span>${smartCard}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Package:</strong>
                            <span>${packageName}</span>
                        </div>
                        <div class="receipt-item">
                            <strong>Amount:</strong>
                            <span>${amount}</span>
                        </div>
                    </div>

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
}

// Initialize the TV manager when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new TVManager();
});
