/**
 * ElectricityPurchase - A modular, object-oriented implementation for electricity purchase
 */
class ElectricityPurchase {
    /**
     * Initialize the electricity purchase module
     */
    constructor() {
        // Cached DOM selectors
        this.$ = selector => document.querySelector(selector);
        this.$$ = selector => Array.from(document.querySelectorAll(selector));

        // Configuration
        const {
            validateMeterUrl,
            purchaseUrl,
            csrfToken,
            chartData,
            chartLabels,
            chartValues
        } = window.ElectricityConfig;

        this.config = {
            validateMeterUrl,
            purchaseUrl,
            csrfToken,
            chartData,
            chartLabels,
            chartValues
        };

        // Application state
        this.state = {
            selectedDisco: '',
            meterInfo: null,
            lastVerification: 0,
            currentRequest: null,
            debounceTimer: null,
            chartData: [],
            chart: null
        };

        // Initialize elements and events
        this.initElements();

        // Early exit if critical elements are missing
        if (!this.elements.meterInput || !this.elements.checkBtn || !this.elements.buyBtn) {
            console.error('Missing critical elements');
            return;
        }

        this.initEventListeners();
        this.initChart();
    }

    /**
     * Initialize DOM elements
     */
    initElements() {
        this.elements = {
            loading: this.$('#loadingOverlay'),
            meterInput: this.$('#meter_number'),
            discoInputs: this.$$('.disco-option'),
            quickAmounts: this.$$('.quick-amount'),
            checkBtn: this.$('#checkBillcode'),
            buyBtn: this.$('#submitPurchase'),
            customAmount: this.$('#customAmount'),
            form: this.$('#electricityForm'),
            recentTransactions: this.$$('.purchase-item'),
            validationDiv: this.$$('.custom-validation')[0],
            retryButton: this.$('#retryButton'),
            downloadReceiptBtn: this.$('#downloadReceipt'),
            meterInfoSection: this.$('#meterInfo'),
            purchaseOptions: this.$('#purchaseOptions'),
            meterTypes: this.$$('input[name="type"]'),

            // Getters for form elements
            get selectedMeterType() {
                return document.querySelector('input[name="type"]:checked')?.value;
            }
        };
    }

    /**
     * Initialize all event listeners
     */
    initEventListeners() {
        // Distribution company selection
        this.elements.discoInputs.forEach(btn =>
            btn.addEventListener('click', () => this.handleDiscoSelection(btn)));

        // Meter type selection
        this.elements.meterTypes.forEach(radio =>
            radio.addEventListener('change', () => this.handleMeterTypeSelection(radio)));

        // Quick amount selection
        this.elements.quickAmounts.forEach(btn =>
            btn.addEventListener('click', () => this.handleQuickAmountSelection(btn)));

        // Recent transactions
        this.elements.recentTransactions.forEach(item =>
            item.addEventListener('click', () => this.handleTransactionClick(item)));

        // Custom amount input
        if (this.elements.customAmount) {
            this.elements.customAmount.addEventListener('input', () => this.handleCustomAmountInput());
        }

        // Meter number validation
        this.elements.meterInput.addEventListener('input', () => this.handleMeterInput());

        // Check button click
        this.elements.checkBtn.addEventListener('click', () => this.handleCheckButtonClick());

        // Buy button click
        this.elements.buyBtn.addEventListener('click', () => this.submitPurchase());

        // Retry button
        if (this.elements.retryButton) {
            this.elements.retryButton.addEventListener('click', () => this.retryPurchase());
        }

        // Download receipt button
        if (this.elements.downloadReceiptBtn) {
            this.elements.downloadReceiptBtn.addEventListener('click', () => this.downloadReceipt());
        }
    }

    /**
     * Initialize usage chart
     */
    initChart() {
        const chartEl = this.$('#usageChart');
        if (!chartEl) return;

        // Create loading indicator for the chart
        this.showChartLoading(chartEl);

        const primaryColor = getComputedStyle(document.documentElement)
            .getPropertyValue('--primary-color').trim();

        let data = this.config.chartData || [];

        // Store the data in state for later updates
        this.state.chartData = [...data];

        // Create and store chart instance
        this.state.chart = new ApexCharts(chartEl, {
            series: [{
                name: 'Amount',
                data: data.map(i => parseFloat(i.amount) || 0)
            }],
            chart: {
                type: 'bar',
                height: 300,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'inherit',
                foreColor: 'var(--gray-600)',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: {
                        enabled: true,
                        delay: 150
                    },
                    dynamicAnimation: {
                        enabled: true,
                        speed: 350
                    }
                },
                events: {
                    mounted: () => {
                        this.hideChartLoading(chartEl);
                    },
                    updated: () => {
                        this.hideChartLoading(chartEl);
                    }
                }
            },
            stroke: {
                width: 0,
                colors: [primaryColor]
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '60%',
                    distributed: false,
                    endingShape: 'rounded',
                    dataLabels: {
                        position: 'top'
                    },
                }
            },
            grid: {
                borderColor: 'var(--gray-200)',
                strokeDashArray: 4,
                padding: { left: 20, right: 20 }
            },
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return '₦' + val;
                },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["var(--gray-700)"],
                    fontWeight: 500
                }
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: v => '₦' + v.toLocaleString('en-NG')
                },
                x: {
                    formatter: v => {
                        try {
                            return new Date(v).toLocaleDateString('en-US', {
                                day: 'numeric',
                                month: "short",
                                year: "2-digit"
                            });
                        } catch (e) {
                            return v;
                        }
                    }
                },
                style: {
                    fontSize: '12px'
                },
                marker: {
                    show: false
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 0.3,
                    opacityFrom: 1,
                    opacityTo: 0.9,
                    colorStops: [
                        {
                            offset: 0,
                            color: primaryColor,
                            opacity: 1
                        },
                        {
                            offset: 100,
                            color: primaryColor,
                            opacity: 0.8
                        }
                    ]
                }
            },
            xaxis: {
                categories: data.map(i => i.date),
                labels: {
                    style: { colors: 'var(--gray-500)' },
                    formatter: function (val) {
                        return val; // We're already passing formatted month abbreviations
                    }
                },
                axisBorder: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: v => '₦' + v,
                    style: { colors: 'var(--gray-500)' }
                }
            }
        });

        this.state.chart.render();
    }

    /**
     * Update chart with new data
     * @param {Object} newTransaction - New transaction data
     */
    updateChart(newTransaction) {
        if (!this.state.chart || !newTransaction) return;

        const chartEl = this.$('#usageChart');
        if (chartEl) {
            this.showChartLoading(chartEl);
        }

        // Prepare new data point
        const today = new Date();
        const month = today.toLocaleString('en-US', { month: 'short' });
        const amount = parseFloat(newTransaction.amount) || 0;

        // Get current chart data
        const currentData = [...this.state.chartData];

        // Check if current month exists in the data
        const currentMonth = today.getFullYear() + '-' + String(today.getMonth() + 1).padStart(2, '0');
        let monthExists = false;

        for (let i = 0; i < currentData.length; i++) {
            if (currentData[i].year === today.getFullYear().toString() &&
                currentData[i].date === month) {
                // Update existing month data
                currentData[i].amount += amount;
                monthExists = true;
                break;
            }
        }

        // Add new data point if month doesn't exist
        if (!monthExists) {
            currentData.push({
                date: month,
                amount: amount,
                year: today.getFullYear().toString()
            });

            // Only keep the last 7 data points to avoid overcrowding
            if (currentData.length > 7) {
                currentData.shift();
            }

            // Update internal state
            this.state.chartData = currentData;

            // Update the chart
            this.state.chart.updateOptions({
                series: [{
                    name: 'Amount',
                    data: currentData.map(i => i.amount)
                }],
                xaxis: {
                    categories: currentData.map(i => i.date)
                }
            });

            // Apply a subtle highlight animation
            setTimeout(() => {
                const chartWrapper = this.$('#usageChart');
                if (chartWrapper) {
                    // Create a flash overlay
                    const overlay = document.createElement('div');
                    overlay.style.position = 'absolute';
                    overlay.style.top = '0';
                    overlay.style.left = '0';
                    overlay.style.width = '100%';
                    overlay.style.height = '100%';
                    overlay.style.background = 'rgba(255, 255, 255, 0.2)';
                    overlay.style.borderRadius = 'var(--card-border-radius)';
                    overlay.style.pointerEvents = 'none';
                    overlay.style.zIndex = '10';
                    overlay.style.opacity = '0.8';

                    // Make chart wrapper position relative if not already
                    if (getComputedStyle(chartWrapper).position !== 'relative') {
                        chartWrapper.style.position = 'relative';
                    }

                    // Add overlay and animate it
                    chartWrapper.appendChild(overlay);

                    // Animate opacity
                    let opacity = 0.8;
                    const fadeOut = setInterval(() => {
                        opacity -= 0.1;
                        overlay.style.opacity = opacity;

                        if (opacity <= 0) {
                            clearInterval(fadeOut);
                            chartWrapper.removeChild(overlay);
                        }
                    }, 50);

                    // Traditional animation as fallback
                    chartWrapper.classList.add('success-animation');
                    setTimeout(() => {
                        chartWrapper.classList.remove('success-animation');
                    }, 500);
                }
            }, 300);
        }
    }

    /**
     * Add a new transaction to the recent purchases list
     * @param {Object} transaction - Transaction data
     */
    addTransactionToList(transaction) {
        if (!transaction || !transaction.id) return;

        console.log("Add transaction after purchase:", transaction);
        const recentPurchasesEl = this.$('.recent-purchases');
        if (!recentPurchasesEl) return;

        // Create new transaction item
        const transactionItem = document.createElement('div');
        transactionItem.className = 'purchase-item';
        transactionItem.id = transaction.id;
        transactionItem.dataset.id = transaction.id;
        transactionItem.dataset.token = transaction.purchased_code || '';

        // Format status badge
        const statusClass = transaction.status === 'pending' ? 'bg-warning' :
            (transaction.status === 'delivered' ? 'bg-success' : 'bg-danger');

        // Set inner HTML
        transactionItem.innerHTML = `
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between">
                    <span class="text-gray-600">${window.textToTitleCase(transaction.meter_type)} Purchase</span>
                    <span class="text-gray-800">₦${this.formatNumberWithCommas(transaction.amount)}</span>
                </div>
                <div class="text-muted">Meter: ${transaction.identity || 'N/A'}</div>
            </div>
            <div>
                <span class="badge ${statusClass}">${transaction.status.charAt(0).toUpperCase() + transaction.status.slice(1)}</span>
            </div>
        `;

        // Add click event
        transactionItem.addEventListener('click', () => this.handleTransactionClick(transactionItem));

        // Add to the beginning of the list
        const noTransactionsMsg = recentPurchasesEl.querySelector('.text-muted');
        if (noTransactionsMsg && noTransactionsMsg.textContent.includes('No recent purchases')) {
            recentPurchasesEl.removeChild(noTransactionsMsg);
        }

        // Insert after the heading
        const heading = recentPurchasesEl.querySelector('h5');
        if (heading && heading.nextElementSibling) {
            recentPurchasesEl.insertBefore(transactionItem, heading.nextElementSibling);
        } else {
            recentPurchasesEl.appendChild(transactionItem);
        }

        // Add to tracked elements
        this.elements.recentTransactions = this.$$('.purchase-item');
    }

    /**
     * Handle distribution company selection
     * @param {HTMLElement} btn - The clicked button
     */
    handleDiscoSelection(btn) {
        this.elements.discoInputs.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.state.selectedDisco = btn.dataset.disco;
        this.$('#distributionCompany').value = this.state.selectedDisco;
        this.validateInput();
        this.updateButtonStates();
    }

    handleMeterTypeSelection() {
        this.elements.meterTypes.forEach(radio => {
            if (radio.checked) {
                this.state.selectedMeterType = radio.value;
            }
        });
        this.validateInput();
        this.updateButtonStates();
    }

    /**
     * Handle quick amount selection
     * @param {HTMLElement} btn - The clicked button
     */
    handleQuickAmountSelection(btn) {
        this.elements.customAmount.value = '';
        this.elements.quickAmounts.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        this.elements.customAmount.value = btn.dataset.amount;
        this.updateButtonStates();
    }

    /**
     * Handle transaction item click
     * @param {HTMLElement} item - The clicked transaction item
     */
    handleTransactionClick(item) {
        const token = item.dataset.token || '';

        if (!token) {
            this.showError('No token available for this transaction', false);
            return;
        }

        this.elements.recentTransactions.forEach(i => {
            if (i !== item) i.classList.remove('active');
        });

        //remove Token: from {token}
        let tokenText = RegExp(/Token :\s*/).test(token) ? token.replace(/Token :\s*/, '') : token;

        // Copy token to clipboard
        if (window.copyToClipboard) {
            window.copyToClipboard(tokenText);
        }
    }

    /**
     * Handle custom amount input
     */
    handleCustomAmountInput() {
        this.elements.quickAmounts.forEach(b => b.classList.remove('active'));
        const val = this.elements.customAmount.value.trim();
        this.$('#amount').value = isNaN(val) ? '' : val;
        this.updateButtonStates();
    }

    /**
     * Handle meter input changes
     */
    handleMeterInput() {
        if (!this.validateForm()) return;
        this.validateInput();
        this.updateButtonStates();
    }

    /**
     * Handle check button click
     */
    handleCheckButtonClick() {
        if (!this.validateForm()) return;

        this.toggleLoading(true, 'Verifying meter number...');
        const originalButtonContent = this.elements.checkBtn.innerHTML;
        this.elements.checkBtn.disabled = true;
        this.elements.checkBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Verifying...`;

        this.validateMeter(this.elements.meterInput.value.trim())
            .finally(() => {
                this.elements.checkBtn.innerHTML = originalButtonContent;
                this.elements.checkBtn.disabled = false;
                this.toggleLoading(false);
            });
    }

    /**
     * Validate input with debounce
     */
    validateInput() {
        clearTimeout(this.state.debounceTimer);
        const meterValue = this.elements.meterInput.value.trim();

        // Reset validation state
        const validationIcon = this.$('.validation-icon');
        if (validationIcon) {
            validationIcon.classList.remove('valid', 'invalid');
        }

        this.elements.meterInfoSection.style.display = 'none';
        this.elements.purchaseOptions.style.display = 'none';

        // Show the check button when input changes
        this.elements.checkBtn.style.display = 'block';

        this.elements.meterInput.classList.remove('is-valid', 'is-invalid', 'is-validating');

        if (meterValue.length >= 5) {
            this.elements.meterInput.classList.add('is-validating');
            if (validationIcon) {
                validationIcon.textContent = 'hourglass_empty';
            }
            this.state.debounceTimer = setTimeout(() => {
                this.validateMeter(meterValue);
            }, 300);
        }
    }

    /**
     * Validate meter number with the API
     * @param {string} meterNumber - The meter number to validate
     * @returns {Promise} - The validation promise
     */
    async validateMeter(meterNumber) {
        const verificationId = Date.now();
        this.state.lastVerification = verificationId;
        this.toggleLoading(true);
        this.elements.meterInput.classList.add('is-validating');

        try {
            if (!this.state.selectedDisco) {
                throw new Error('Select distribution company');
            }

            const meterType = this.elements.selectedMeterType;
            if (!meterType) {
                throw new Error('Select meter type');
            }

            if (meterNumber.length < 10) {
                throw new Error('Meter number must be at least 10 digits');
            }

            const response = await fetch(this.config.validateMeterUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.config.csrfToken
                },
                body: JSON.stringify({
                    billerCode: meterNumber,
                    meterType: meterType,
                    distributionCompany: this.state.selectedDisco
                })
            });

            // If this is not the most recent verification request, ignore the response
            if (this.state.lastVerification !== verificationId) return null;


            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message);
            }


            // Check for API error responses
            if (data.status == 'failed') {
                throw new Error(data.message || 'Invalid meter number');
            }

            const meterData = data.data;
            this.elements.meterInput.classList.replace('is-validating', 'is-valid');

            const validationIcon = this.$('.validation-icon');
            if (validationIcon) {
                validationIcon.classList.add('valid');
                validationIcon.textContent = 'check_circle';
            }

            this.displayMeterInfo(meterData);
            this.showNotification('Meter verification successful!');

            return meterData;

        } catch (error) {
            this.elements.meterInput.classList.replace('is-validating', 'is-invalid');

            const validationIcon = this.$('.validation-icon');
            if (validationIcon) {
                validationIcon.classList.add('invalid');
                validationIcon.textContent = 'error';
            }

            this.elements.checkBtn.style.display = 'block';
            this.showError(error.message);
            this.toggleLoading(false);

            return null;

        } finally {
            // If this is not the most recent verification request, don't update UI
            if (this.state.lastVerification !== verificationId) return;

            this.elements.meterInput.classList.remove('is-validating');

            // Only show the button again if we don't have successful meter info
            if (!this.state.meterInfo) {
                this.elements.checkBtn.style.display = 'block';
                this.elements.buyBtn.disabled = false;
            }

            this.updateButtonStates();
            this.toggleLoading(false);
        }
    }

    /**
     * Display meter information in the UI
     * @param {Object} info - The meter information object
     */
    displayMeterInfo(info) {
        this.state.meterInfo = info;

        this.$('#customerName').textContent = info.customerName || info.Customer_Name || '';
        this.$('#customerAddress').textContent = info.customerAddress || info.Address || '';
        this.$('#meterNumberConfirm').textContent = info.meterNumber || this.elements.meterInput.value.trim();

        this.elements.meterInfoSection.style.display = 'block';
        this.elements.purchaseOptions.style.display = 'block';

        // Auto-select the first quick amount option
        const quickAmount = this.$('.quick-amount');
        if (quickAmount) quickAmount.click();

        this.elements.checkBtn.style.display = 'none';
        this.updateButtonStates();
    }

    /**
     * Validate the form inputs
     * @returns {boolean} - Whether the form is valid
     */
    validateForm() {
        let isValid = true;
        let errorMessage = '';

        if (!this.state.selectedDisco) {
            errorMessage = 'Select distribution company';
            this.showError(errorMessage);
            isValid = false;
            return isValid;
        }

        if (!this.elements.selectedMeterType) {
            errorMessage = 'Select meter type';
            this.showError(errorMessage);
            isValid = false;
            return isValid;
        }

        const meterValue = this.elements.meterInput.value.trim();
        if (meterValue.length < 10) {
            errorMessage = 'Enter valid meter number';
            this.showError(errorMessage);
            isValid = false;

            if (isNaN(meterValue)) {
                errorMessage = 'Meter number must be a number';
                this.showError(errorMessage);
            }

            return isValid;
        }

        // Clear previous validation messages if valid
        if (this.elements.validationDiv) {
            this.elements.validationDiv.innerHTML = '';
        }

        return isValid;
    }

    /**
     * Update button states based on form validity
     */
    updateButtonStates() {
        const meterValue = this.elements.meterInput.value.trim();

        // Check button state
        this.elements.checkBtn.disabled = !this.state.selectedDisco ||
            !meterValue ||
            !this.elements.selectedMeterType ||
            meterValue.length < 5;

        // Buy button state
        const meterInfoVisible = this.elements.meterInfoSection.style.display === 'block';
        const amount = this.$('#customAmount')?.value;

        this.elements.buyBtn.disabled = !meterInfoVisible ||
            !amount ||
            parseFloat(amount) <= 0 ||
            this.elements.meterInput.classList.contains('is-invalid');
    }

    /**
     * Submit a purchase request
     * @param {boolean} retry - Whether this is a retry attempt
     */
    async submitPurchase(retry = false) {
        const amount = this.$('#customAmount')?.value;
        const phone = this.$('#phone')?.value.trim();

        if (!phone) {
            return this.showError('Enter phone number');
        }

        if (!amount) {
            return this.showError('Select amount');
        }

        if (!this.state.meterInfo) {
            return this.showError('Verify meter first');
        }

        this.toggleLoading(true, 'Processing payment...');
        const originalButtonContent = this.elements.buyBtn.innerHTML;
        this.elements.buyBtn.disabled = true;
        this.elements.buyBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span> Processing...`;

        try {
            const formData = new FormData();
            formData.append('meter_number', this.elements.meterInput.value.trim());
            formData.append('distribution_company', this.state.selectedDisco);
            formData.append('meter_type', this.elements.selectedMeterType);
            formData.append('amount', amount);
            formData.append('phone', phone);
            formData.append('auto_purchase', +this.$('#autoPurchase')?.checked);
            formData.append('_token', this.config.csrfToken);

            if (retry) {
                formData.append('is_retry', '1');
            }


            const response = await fetch(this.config.purchaseUrl, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });



            const responseData = await response.json();

            if (!response.ok) throw new Error(responseData.message || 'Error processing request');

            if (responseData.status === "failed") {
                throw new Error(responseData.message);
            }

            const data = responseData.data || responseData.result?.content || responseData;

            // Store the transaction data for receipt generation
            window.lastTransaction = {
                id: data.reference || '',
                meterNumber: this.elements.meterInput.value.trim(),
                amount: parseFloat(amount),
                customerName: this.$('#customerName').textContent,
                disco: this.state.selectedDisco,
                date: new Date().toISOString(),
                token: data.token || ''
            };

            // Populate success modal
            this.$('#transactionId').textContent = data.reference || '';
            this.$('#successMeterNumber').textContent = this.elements.meterInput.value.trim();
            this.$('#successAmount').textContent = this.formatCurrency(parseFloat(amount));

            // Show token if available
            if (data.token) {
                this.$('#successToken').textContent = data.token;
                this.$('#successToken').parentElement.style.display = 'flex';
            } else {
                this.$('#successToken').parentElement.style.display = 'none';
            }

            // Show success modal - with proper focus management
            const successModalEl = this.$('#successModal');
            const successModal = new bootstrap.Modal(successModalEl);

            // Store the current active element before showing modal
            const previousFocusElement = document.activeElement;

            // Add a one-time event listener for when modal is shown
            successModalEl.addEventListener('shown.bs.modal', function onShown() {
                // Focus the download button
                const downloadBtn = document.getElementById('downloadReceipt');
                if (downloadBtn) {
                    downloadBtn.focus();
                }
                // Remove the one-time event listener
                successModalEl.removeEventListener('shown.bs.modal', onShown);
            });

            // Show the modal
            successModal.show();

            // Update wallet balance if returned
            if (data.walletBalance) {
                this.$('.wallet-balance h3').textContent = '₦' + this.formatNumberWithCommas(data.walletBalance);
            }

            // Reset the form
            setTimeout(() => this.resetForm(), 2000);

            // Update the chart with the new transaction data
            this.updateChart({
                date: new Date(),
                amount: parseFloat(amount)
            });

            // Add the transaction to recent transactions list
            this.addTransactionToList({
                id: data.reference || '',
                amount: parseFloat(amount),
                status: 'delivered',
                meter_type: this.elements.selectedMeterType,
                customerName: this.$('#customerName').textContent,
                meterNumber: this.elements.meterInput.value.trim(),
                disco: this.state.selectedDisco,
                date: new Date().toISOString(),
                identity: this.elements.meterInput.value.trim(),
                purchased_code: data.token || ''
            });

        } catch (error) {
            console.error(error);
            window.retryData = {
                ...this.state,
                amount
            };

            this.showError(error.message || 'Error processing request');
            this.updateErrorModalMessage(error.message || 'Error processing request');

            // Show error modal - with proper focus management
            const errorModalEl = this.$('#errorModal');
            const errorModal = new bootstrap.Modal(errorModalEl);

            // Store the current active element before showing modal
            const previousFocusElement = document.activeElement;

            // Add a one-time event listener for when modal is shown
            errorModalEl.addEventListener('shown.bs.modal', function onShown() {
                // Focus the retry button
                const retryBtn = document.getElementById('retryButton');
                if (retryBtn) {
                    retryBtn.focus();
                }
                // Remove the one-time event listener
                errorModalEl.removeEventListener('shown.bs.modal', onShown);
            });

            // Show the modal
            errorModal.show();

        } finally {
            this.elements.buyBtn.innerHTML = originalButtonContent;
            this.elements.buyBtn.disabled = false;
            this.toggleLoading(false);
        }
    }

    /**
     * Reset the form to initial state
     */
    resetForm() {
        this.elements.form.reset();
        this.state.meterInfo = null;
        this.elements.meterInfoSection.style.display = 'none';
        this.elements.discoInputs.forEach(b => b.classList.remove('active'));
        this.elements.quickAmounts.forEach(b => b.classList.remove('active'));
        this.elements.meterInput.classList.remove('is-valid', 'is-invalid', 'is-validating');
        this.$('#amount').value = '';
    }

    /**
     * Retry a failed purchase
     */
    retryPurchase() {
        const errorModal = bootstrap.Modal.getInstance(this.$('#errorModal'));
        if (errorModal) {
            errorModal.hide();
        }
        setTimeout(() => this.submitPurchase(true), 300);
    }

    /**
     * Generate and download a receipt
     */
    downloadReceipt() {
        const transaction = window.lastTransaction;
        if (!transaction) return;

        const html = `
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Electricity Receipt - ${transaction.id}</title>
            <style>
                body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
                .receipt { max-width: 600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px; }
                .header { text-align: center; margin-bottom: 20px; }
                .header h1 { color: #2c3e50; margin-bottom: 5px; }
                .logo { max-width: 150px; margin-bottom: 15px; }
                .info-row { display: flex; justify-content: space-between; margin-bottom: 10px; border-bottom: 1px dashed #eee; padding-bottom: 10px; }
                .label { font-weight: bold; color: #555; }
                .value { text-align: right; }
                .token { background-color: #f8f9fa; padding: 15px; text-align: center; border-radius: 4px; margin: 20px 0; font-size: 18px; letter-spacing: 2px; font-weight: bold; }
                .footer { text-align: center; margin-top: 30px; font-size: 12px; color: #777; }
            </style>
        </head>
        <body>
            <div class="receipt">
                <div class="header">
                    <h1>${window.textToTitleCase(transaction.meter_type)} Purchase Receipt</h1>
                    <p>Transaction Successful</p>
                    <p>${new Date(transaction.date).toLocaleString()}</p>
                </div>

                <div class="info-row">
                    <span class="label">Transaction Reference:</span>
                    <span class="value">${transaction.id}</span>
                </div>

                <div class="info-row">
                    <span class="label">Customer Name:</span>
                    <span class="value">${transaction.customerName}</span>
                </div>

                <div class="info-row">
                    <span class="label">Meter Number:</span>
                    <span class="value">${transaction.meterNumber}</span>
                </div>

                <div class="info-row">
                    <span class="label">Distribution Company:</span>
                    <span class="value">${transaction.disco}</span>
                </div>

                <div class="info-row">
                    <span class="label">Amount:</span>
                    <span class="value">₦${this.formatNumberWithCommas(transaction.amount)}</span>
                </div>

                ${transaction.token ? `
                <div class="token">
                    <div class="label">Token:</div>
                    <div>${transaction.token}</div>
                </div>
                ` : ''}

                <div class="footer">
                    <p>Thank you for your purchase.</p>
                    <p>This is a computer-generated receipt and does not require a signature.</p>
                </div>
            </div>
        </body>
        </html>
        `;

        this.downloadHTML(`electricity-receipt-${transaction.id}.html`, html);
    }

    /**
     * Show loading overlay
     * @param {boolean} show - Whether to show or hide the overlay
     * @param {string} message - The message to display
     */
    toggleLoading(show, message = 'Processing...') {
        if (!this.elements.loading) return;

        this.elements.loading.style.display = show ? 'block' : 'none';
        document.body.style.overflow = show ? 'hidden' : '';

        const loadingText = this.$('.loading-text');
        if (loadingText) {
            loadingText.textContent = message;
        }
    }

    /**
     * Show a notification
     * @param {string} text - The notification text
     * @param {string} type - The notification type
     */
    showNotification(text, type = 'success') {
        if (window.Noty) {
            new Noty({
                text,
                type,
                layout: 'topRight',
                theme: 'mint',
                timeout: 3000
            }).show();
        }
    }

    /**
     * Show an error notification and message
     * @param {string} message - The error message
     */
    showError(message, updateDiv = true) {
        this.showNotification(message, 'error');
        if (updateDiv) {
            this.updateErrorDiv(message);
        }
    }

    /**
     * Update the error div with a message
     * @param {string} message - The error message
     */
    updateErrorDiv(message) {
        if (!this.elements.validationDiv || !message) return;

        this.elements.validationDiv.innerHTML = '';

        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger alert-dismissible fade show';
        errorDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        this.elements.validationDiv.prepend(errorDiv);

        return setTimeout(() => {
            if (errorDiv.parentElement) {
                errorDiv.parentElement.removeChild(errorDiv);
            }
        }, 5000);
    }

    updateErrorModalMessage(message) {
        const errorModal = this.$('#errorModal');
        if (errorModal) {
            const errorMessage = errorModal.querySelector('.error-message');
            if (errorMessage) {
                errorMessage.textContent = message;
            }
        }
    }

    /**
     * Format currency
     * @param {number} amount - The amount to format
     * @returns {string} - The formatted currency
     */
    formatCurrency(amount) {
        return new Intl.NumberFormat('en-NG', {
            style: 'currency',
            currency: 'NGN'
        }).format(amount);
    }

    /**
     * Format number with commas
     * @param {number} number - The number to format
     * @returns {string} - The formatted number
     */
    formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ',');
    }

    /**
     * Download HTML content as a file
     * @param {string} filename - The filename
     * @param {string} html - The HTML content
     */
    downloadHTML(filename, html) {
        const blob = new Blob([html], { type: 'text/html' });
        const url = URL.createObjectURL(blob);

        const downloadLink = document.createElement('a');
        downloadLink.href = url;
        downloadLink.download = filename;

        document.body.appendChild(downloadLink);
        downloadLink.click();

        setTimeout(() => {
            document.body.removeChild(downloadLink);
            URL.revokeObjectURL(url);
        }, 100);
    }

    /**
     * Show loading indicator for the chart
     * @param {HTMLElement} chartEl - The chart element
     */
    showChartLoading(chartEl) {
        // First check if parent element position is relative for absolute positioning
        const chartParent = chartEl.parentElement;
        const originalPosition = getComputedStyle(chartParent).position;

        if (originalPosition !== 'relative' && originalPosition !== 'absolute') {
            chartParent.style.position = 'relative';
        }

        // Store original position to restore later if needed
        chartParent.dataset.originalPosition = originalPosition;

        // Create loading overlay
        const loadingOverlay = document.createElement('div');
        loadingOverlay.className = 'chart-loading-overlay';
        loadingOverlay.style.position = 'absolute';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.width = '100%';
        loadingOverlay.style.height = '100%';
        loadingOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.7)';
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.justifyContent = 'center';
        loadingOverlay.style.alignItems = 'center';
        loadingOverlay.style.zIndex = '10';
        loadingOverlay.style.borderRadius = 'var(--card-border-radius)';

        // Create spinner
        const spinner = document.createElement('div');
        spinner.className = 'spinner-border text-primary';
        spinner.style.width = '3rem';
        spinner.style.height = '3rem';
        spinner.setAttribute('role', 'status');

        // Create loading text
        // const loadingText = document.createElement('span');
        // loadingText.className = 'ms-2';
        // loadingText.textContent = 'Loading chart...';
        // loadingText.style.fontWeight = '500';
        // loadingText.style.color = 'var(--gray-700)';

        // Create container for spinner and text
        const loadingContainer = document.createElement('div');
        loadingContainer.style.display = 'flex';
        loadingContainer.style.alignItems = 'center';
        loadingContainer.appendChild(spinner);
        // loadingContainer.appendChild(loadingText);

        loadingOverlay.appendChild(loadingContainer);
        chartParent.appendChild(loadingOverlay);
    }

    /**
     * Hide loading indicator for the chart
     * @param {HTMLElement} chartEl - The chart element
     */
    hideChartLoading(chartEl) {
        const chartParent = chartEl.parentElement;
        const loadingOverlay = chartParent.querySelector('.chart-loading-overlay');

        if (loadingOverlay) {
            // Create fade out animation
            loadingOverlay.style.transition = 'opacity 0.3s ease';
            loadingOverlay.style.opacity = '0';

            // Remove after transition
            setTimeout(() => {
                chartParent.removeChild(loadingOverlay);

                // Restore original position if it was changed
                if (chartParent.dataset.originalPosition &&
                    chartParent.dataset.originalPosition !== 'relative' &&
                    chartParent.dataset.originalPosition !== 'absolute') {
                    chartParent.style.position = chartParent.dataset.originalPosition;
                }
            }, 300);
        }
    }
}

// Initialize the electricity purchase module when the DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    new ElectricityPurchase();
});
