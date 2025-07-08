@extends('merchant-layout.layouts.app')

@section('title', 'Fund User Account')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Fund User Account</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('merchant.credit.user') }}">Users</a>
                                    </li>
                                    <li class="breadcrumb-item active">Fund Account</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-0">
                                    <div class="col-md-4 border-end">
                                        <div class="p-4 text-center">
                                            <div class="avatar-xl mx-auto mb-4">
                                                <span
                                                    class="avatar-title bg-soft-primary text-primary display-5 rounded-circle">
                                                    {{ strtoupper(substr($user->username, 0, 1)) }}
                                                </span>
                                            </div>
                                            <h5 class="fs-17 mb-1">{{ $user->name }}</h5>
                                            <p class="text-muted mb-4">{{ $user->username }}</p>
                                            <div class="d-flex justify-content-center gap-3">
                                                <button type="button" class="btn btn-soft-info btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="User ID: {{ $user->id }}">
                                                    <i class="ri-user-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-soft-danger btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $user->tel }}">
                                                    <i class="ri-phone-line"></i>
                                                </button>
                                                <button type="button" class="btn btn-soft-warning btn-sm"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $user->email }}">
                                                    <i class="ri-mail-line"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="p-4">
                                            <div class="row mb-4">
                                                <div class="col-sm-6">
                                                    <div class="p-3 bg-soft-primary rounded">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <div class="avatar-sm">
                                                                    <span
                                                                        class="avatar-title bg-primary rounded-circle fs-18">
                                                                        <i class="ri-wallet-3-line"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p class="text-uppercase fw-medium text-muted mb-1">User
                                                                    Balance</p>
                                                                <h4 class="fs-16 mb-0">
                                                                    ₦{{ number_format($user->wallet->balance, 2) }}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="p-3 bg-soft-success rounded">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <div class="avatar-sm">
                                                                    <span
                                                                        class="avatar-title bg-success rounded-circle fs-18">
                                                                        <i class="ri-funds-line"></i>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3">
                                                                <p class="text-uppercase fw-medium text-muted mb-1">Your
                                                                    Balance</p>
                                                                <h4 class="fs-16 mb-0" id="merchantBalance">
                                                                    ₦{{ number_format($merchantBalance, 2) }}
                                                                </h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <form id="fundForm" class="mt-4">
                                                @csrf
                                                <div class="mb-4">
                                                    <label for="amount" class="form-label">Amount to Fund (₦)</label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text bg-light">₦</span>
                                                        <input type="number" class="form-control form-control-lg"
                                                            id="amount" name="amount" min="0.01" step="0.01" required
                                                            placeholder="Enter amount to fund">
                                                    </div>
                                                    <div class="invalid-feedback" id="amountError"></div>
                                                </div>

                                                <div class="d-flex justify-content-end gap-2">
                                                    <a href="{{ route('merchant.add.fund', $user->id) }}"
                                                        class="btn btn-light btn-lg">
                                                        <i class="ri-arrow-left-line align-middle me-1"></i>Cancel
                                                    </a>
                                                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                                                        <i class="ri-money-dollar-circle-line align-middle me-1"></i>
                                                        Fund Account
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title mb-0">
                                    <i class="ri-information-line align-middle me-1"></i>
                                    Important Information
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="ri-checkbox-circle-line text-success fs-17"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="text-muted mb-0">Funds will be transferred instantly to the user's account
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="ri-error-warning-line text-warning fs-17"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="text-muted mb-0">You must have sufficient balance in your merchant wallet
                                        </p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="ri-shield-check-line text-info fs-17"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-2">
                                        <p class="text-muted mb-0">Transaction will be recorded and can be tracked in wallet
                                            history</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                const fundForm = $('#fundForm');
                const submitBtn = $('#submitBtn');
                const merchantBalance = parseFloat('{{ Auth::user()->wallet->balance ?? 0 }}');

                // Validate amount on input
                $('#amount').on('input', function () {
                    const amount = parseFloat($(this).val());
                    const amountError = $('#amountError');

                    if (!amount || amount <= 0) {
                        amountError.html('Please enter a valid amount').show();
                        submitBtn.prop('disabled', true);
                        return;
                    }

                    if (amount > merchantBalance) {
                        amountError.html('Insufficient merchant balance').show();
                        submitBtn.prop('disabled', true);
                        return;
                    }

                    amountError.hide();
                    submitBtn.prop('disabled', false);
                });

                fundForm.on('submit', function (event) {
                    event.preventDefault();
                    submitBtn.prop('disabled', true).html(
                        '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Processing...'
                    );

                    $.ajax({
                        url: '{{ route("merchant.fund.user", $user->id) }}',
                        method: 'POST',
                        data: {
                            _token: $('input[name="_token"]').val(),
                            amount: $('#amount').val()
                        },
                        success: function (response) {
                            Swal.fire({
                                title: "Success!",
                                text: response.message,
                                icon: "success",
                                showCancelButton: false,
                                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                                buttonsStyling: false,
                            }).then(function () {
                                // Update displayed merchant balance
                                $('#merchantBalance').text('₦' + parseFloat(response.merchantBalance).toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                }));

                                // Redirect back to users list
                                window.location.href = '{{ route("merchant.credit.user") }}';
                            });
                        },
                        error: function (xhr) {
                            let message = 'An error occurred while processing your request';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                message = xhr.responseJSON.message;
                            }

                            Swal.fire({
                                title: "Error!",
                                text: message,
                                icon: "error",
                                showCancelButton: false,
                                confirmButtonClass: "btn btn-primary w-xs me-2 mt-2",
                                buttonsStyling: false,
                            });

                            submitBtn.prop('disabled', false).html(
                                '<i class="ri-money-dollar-circle-line align-middle me-1"></i> Fund Account'
                            );
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
