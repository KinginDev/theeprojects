<style>
    :root {
        --primary-color: {{ $configuration->template_color ?? '#4F46E5' }};
        --primary-hover:
            {{ $configuration->template_color ? 'color-mix(in srgb, ' . $configuration->template_color . ' 80%, black)' : '#4338CA' }};
        --surface-color: #FFFFFF;
        --gray-50: #F9FAFB;
        --gray-100: #F3F4F6;
        --gray-200: #E5E7EB;
        --gray-300: #D1D5DB;
        --gray-400: #9CA3AF;
        --gray-500: #6B7280;
        --gray-600: #4B5563;
        --gray-700: #374151;
        --gray-800: #1F2937;
        --success-color: #10B981;
        --warning-color: #F59E0B;
        --error-color: #EF4444;
        --card-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        --input-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
        --card-border-radius: 16px;
        --input-border-radius: 12px;
        --button-border-radius: 12px;
    }

    .education-page {
        padding: 2rem;
        background-color: var(--gray-50);
    }

    .provider-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin: 0px 0.5rem;
    }

    .education-card {
        background: var(--surface-color);
        border-radius: var(--card-border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .education-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    .form-control {
        border: 2px solid var(--gray-200);
        border-radius: var(--input-border-radius);
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: var(--input-shadow);
        outline: none;
    }

    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
    }

    .provider-select {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .provider-option {
        flex: 1 0 calc(33.333% - 1rem);
        min-width: 100px;
        padding: 1rem;
        border: 2px solid var(--gray-200);
        border-radius: var(--card-border-radius);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .provider-option:hover {
        border-color: var(--primary-color);
        background: var(--gray-50);
    }

    .provider-option.active {
        border-color: var(--primary-color);
        background: rgba(var(--primary-color-rgb), 0.05);
    }

    .provider-logo {
        height: 40px;
        width: auto;
        margin-bottom: 0.5rem;
    }

    .nav-pills {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0;
        flex-wrap: wrap;
    }

    .nav-pills .nav-link {
        border-radius: var(--button-border-radius);
        padding: 0.75rem 1.25rem;
        color: var(--gray-700);
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .nav-pills .nav-link:hover {
        background-color: var(--gray-100);
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
    }

    .submit-button {
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--button-border-radius);
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        cursor: pointer;
    }

    .submit-button:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
    }

    .submit-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent);
        transform: translateX(-100%);
    }

    .submit-button:hover::before {
        transform: translateX(100%);
        transition: transform 0.5s ease;
    }

    .submit-button:disabled {
        background-color: var(--gray-300);
        cursor: not-allowed;
        transform: none;
    }

    .validation-icon {
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        transition: all 0.3s ease;
    }

    .validation-icon.valid {
        color: var(--success-color);
    }

    .validation-icon.invalid {
        color: var(--error-color);
    }

    .is-valid {
        border-color: var(--success-color) !important;
    }

    .is-invalid {
        border-color: var(--error-color) !important;
    }

    .customer-info-card {
        background: var(--gray-50);
        border-radius: var(--card-border-radius);
        overflow: hidden;
    }

    .customer-info-item {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
    }

    .customer-info-item:last-child {
        border-bottom: none;
    }

    #preloader {
        position: fixed;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    #preloader .spinner-border {
        width: 3rem;
        height: 3rem;
        margin-bottom: 1rem;
    }

    .tab-content {
        padding-top: 1rem;
    }

    .recent-transaction {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        border-bottom: 1px solid var(--gray-200);
        transition: all 0.3s ease;
    }

    .recent-transaction:hover {
        background: var(--gray-50);
    }

    .recent-transaction:last-child {
        border-bottom: none;
    }

    /* Responsive improvements */
    @media (max-width: 768px) {
        .education-page {
            padding: 1rem;
        }

        .education-card {
            padding: 1.25rem;
        }

        .nav-pills {
            overflow-x: auto;
            flex-wrap: nowrap;
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE and Edge */
        }

        .nav-pills::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .provider-option {
            flex: 1 0 calc(50% - 0.5rem);
        }
    }

    /* Animation improvements */
    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Tab transition improvements */
    .tab-pane.fade {
        transition: opacity 0.3s ease-in-out;
    }

    /* Form interaction improvements */
    .form-control:focus+.validation-icon {
        color: var(--primary-color);
    }
</style>
