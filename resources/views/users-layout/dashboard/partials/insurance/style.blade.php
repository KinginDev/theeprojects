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

    .insurance-page {
        padding: 2rem;
        background-color: var(--gray-50);
    }

    .insurance-card {
        background: var(--surface-color);
        border-radius: var(--card-border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .insurance-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
    }

    .provider-icon {
        width: 32px;
        height: 32px;
        object-fit: cover;
        margin-right: 0.5rem;
    }

    .form-control,
    .form-select {
        border: 2px solid var(--gray-200);
        border-radius: var(--input-border-radius);
        padding: 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: var(--surface-color);
        box-shadow: var(--input-shadow);
        width: 100%;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(255, 107, 0, 0.15);
        outline: none;
    }

    .form-label {
        font-weight: 500;
        color: var(--gray-700);
        margin-bottom: 0.5rem;
        display: block;
    }

    .nav-pills {
        background: var(--surface-color);
        border-radius: var(--card-border-radius);
        padding: 0.5rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 1.5rem;
        display: flex;
        overflow-x: auto;
    }

    .nav-pills .nav-link {
        border-radius: var(--input-border-radius);
        padding: 1rem 1.5rem;
        margin: 0 0.25rem;
        font-weight: 500;
        color: var(--gray-700);
        transition: all 0.3s ease;
        white-space: nowrap;
        display: flex;
        align-items: center;
    }

    .nav-pills .nav-link:hover {
        color: var(--primary-color);
        background-color: var(--gray-50);
        transform: translateY(-2px);
    }

    .nav-pills .nav-link.active {
        background-color: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .btn-org,
    .submit-button {
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: var(--button-border-radius);
        padding: 1.25rem;
        width: 100%;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn-org:hover,
    .submit-button:hover {
        background: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: var(--card-shadow);
        color: white;
    }

    .btn-org::before,
    .submit-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent);
        transform: translateX(-100%);
    }

    .btn-org:hover::before,
    .submit-button:hover::before {
        transform: translateX(100%);
        transition: transform 0.5s ease;
    }

    .customer-info-card {
        background: var(--surface-color);
        border-radius: var(--card-border-radius);
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
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

    .purchase-item {
        padding: 12px;
        border-bottom: 1px solid var(--gray-200);
        transition: background-color 0.2s;
    }

    .purchase-item:hover {
        background-color: var(--gray-50);
    }

    .purchase-item .time {
        color: var(--gray-500);
        font-size: 0.8rem;
    }

    .purchase-item .amount {
        font-weight: 600;
        color: var(--gray-800);
    }

    .transaction-success {
        color: var(--success-color);
    }

    .transaction-pending {
        color: var(--warning-color);
    }

    .transaction-failed {
        color: var(--error-color);
    }

    .sidebar-card {
        background: var(--surface-color);
        border-radius: var(--card-border-radius);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: var(--card-shadow);
    }

    #preloader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    #preloader .spinner-border {
        width: 3rem;
        height: 3rem;
        margin-bottom: 1rem;
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

    @media (max-width: 768px) {
        .insurance-page {
            padding: 1rem;
        }

        .nav-pills {
            overflow-x: auto;
        }
    }

    .btn-org {
        background-color: #FF6B00;
        border-color: #FF6B00;
        color: white;
    }

    .btn-org:hover {
        background-color: #E05E00;
        border-color: #E05E00;
        color: white;
    }

    .purchase-item {
        padding: 12px;
        border-bottom: 1px solid #E5E7EB;
        transition: background-color 0.2s;
    }

    .purchase-item:hover {
        background-color: #F9FAFB;
    }

    .purchase-item .time {
        color: #6B7280;
        font-size: 0.8rem;
    }

    .purchase-item .amount {
        font-weight: 600;
        color: #1F2937;
    }

    .transaction-success {
        color: #059669;
    }

    .transaction-pending {
        color: #D97706;
    }

    .transaction-failed {
        color: #DC2626;
    }

    .sidebar-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 16px;
        margin-bottom: 20px;
    }
</style>
