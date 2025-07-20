<div class="wallet-balance mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <p class="text-white mb-1 opacity-90">Wallet Balance</p>
            <h3 class="text-white mb-0">₦{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</h3>
        </div>
        <a href="{{ route('users.dashboard', ['action' => 'showModal']) }}" class="btn btn-light" style="z-index: 100 !important;">
            <span class="material-icons-round align-middle me-1" style="font-size: 18px;">add</span>
            Fund Wallet
        </a>
    </div>
</div>

@push('after_styles')
<style>

    .wallet-balance {
        background: linear-gradient(135deg, var(--primary-color) 0%, color-mix(in srgb, var(--primary-color) 60%, black) 100%);
        border-radius: var(--card-border-radius);
        padding: 1.5rem;
        color: white;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .wallet-balance::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("data:image/svg+xml,%3Csvg width='20' height='20' viewBox='0 0 20 20' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h20L0 20z' fill='%23fff' fill-opacity='.05'/%3E%3C/svg%3E") repeat;
        opacity: 0.5;
    }

    </style>
@endpush
