<div class="wallet-balance mb-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <p class="text-white mb-1 opacity-90">Wallet Balance</p>
            <h3 class="text-white mb-0">₦{{ number_format(auth()->user()->wallet->balance ?? 0, 2) }}</h3>
        </div>
        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#fundWalletModal">
            <span class="material-icons-round align-middle me-1" style="font-size: 18px;">add</span>
            Fund Wallet
        </button>
    </div>
</div>
