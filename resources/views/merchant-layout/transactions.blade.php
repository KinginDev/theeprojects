@extends('merchant-layout.layouts.app')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid py-4">
                <div class="row">
                    <div class="col-12">
                        <div class="card mb-4">
                            <div class="card-header pb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>Transactions</h6>
                                    <div class="d-flex gap-3">
                                        <select class="form-select w-auto" id="transactionType">
                                            <option value="all">All Transactions</option>
                                            @foreach(\App\Enums\ProductTypes::cases() as $type)
                                                <option value="{{ strtolower($type->name) }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pt-0 pb-2">
                                <div class="table-responsive p-0">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    User</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Transaction ID</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Type</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Amount</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Status</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Date</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($airtimeTransactions as $transaction)
                                                <tr class="transaction-row airtime-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{$transaction->owner?->name}}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-primary">Airtime</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="airtime" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-network="{{ $transaction->network }}"
                                                            data-phone="{{ $transaction->tel }}" data-bs-toggle="modal"
                                                            data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($dataTransactions as $transaction)
                                                <tr class="transaction-row data-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm"></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-info">Data</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="data" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-network="{{ $transaction->network }}"
                                                            data-phone="{{ $transaction->tel }}"
                                                            data-plan="{{ $transaction->plan }}" data-bs-toggle="modal"
                                                            data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($electricityTransactions as $transaction)
                                                <tr class="transaction-row electricity-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm"></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-warning">Electricity</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="electricity" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-meter-number="{{ $transaction->meter_number }}"
                                                            data-disco="{{ $transaction->disco }}" data-bs-toggle="modal"
                                                            data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($tvTransactions as $transaction)
                                                <td>
                                                    <div class="d-flex px-3 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm"></h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <tr class="transaction-row tv-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-secondary">TV</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="tv" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-smart-card="{{ $transaction->smart_card_number }}"
                                                            data-package="{{ $transaction->package }}" data-bs-toggle="modal"
                                                            data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($educationTransactions as $transaction)
                                                <tr class="transaction-row education-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm"></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-success">Education</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="education" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-institution="{{ $transaction->institution }}"
                                                            data-student-id="{{ $transaction->student_id }}"
                                                            data-bs-toggle="modal" data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach

                                            @foreach($insuranceTransactions as $transaction)

                                                <tr class="transaction-row insurance-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm"></h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-dark">Insurance</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->status === 'success' ? 'success' : ($transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="insurance" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-policy-number="{{ $transaction->policy_number }}"
                                                            data-insurance-type="{{ $transaction->insurance_type }}"
                                                            data-bs-toggle="modal" data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @foreach($walletTransactions as $transaction)

                                                <tr class="transaction-row data-transaction">
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{$transaction->owner?->name}}</h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-3 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $transaction->transaction_ref }}
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><span class="badge bg-info">Wallet</span></td>
                                                    <td>₦{{ number_format($transaction->amount, 2) }}</td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $transaction->transaction->status === 'success' ? 'success' : ($transaction->transaction->status === 'pending' ? 'warning' : 'danger') }}">
                                                            {{ ucfirst($transaction->status) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $transaction->created_at->format('M d, Y H:i') }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-info view-transaction"
                                                            data-transaction-id="{{ $transaction->transaction_id }}"
                                                            data-type="data" data-amount="{{ $transaction->amount }}"
                                                            data-status="{{ $transaction->status }}"
                                                            data-date="{{ $transaction->created_at->format('M d, Y H:i') }}"
                                                            data-bs-toggle="modal" data-bs-target="#transactionModal">
                                                            View
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="transactionModalLabel">Transaction Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="transactionDetails">
                    <!-- Details will be populated dynamically -->
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const transactionType = document.getElementById('transactionType');
            const rows = document.querySelectorAll('.transaction-row');

            function updateTransactionView(selectedType) {
                let visibleCount = 0;
                rows.forEach(row => {
                    if (selectedType === 'all') {
                        row.style.display = 'table-row';
                        visibleCount++;
                    } else {
                        // Get the actual transaction type from the badge text
                        const badge = row.querySelector('.badge');
                        const rowType = badge.textContent.toLowerCase();

                        if (rowType === selectedType.toLowerCase()) {
                            row.style.display = 'table-row';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    }
                });

                // Handle no results message
                const tbody = document.querySelector('tbody');
                const existingMessage = tbody.querySelector('.no-transactions');
                if (existingMessage) {
                    existingMessage.remove();
                }

                if (visibleCount === 0) {
                    const noTransactionsRow = document.createElement('tr');
                    noTransactionsRow.className = 'no-transactions';
                    noTransactionsRow.innerHTML = `
                                                                                                                                                                                            <td colspan="6" class="text-center py-4">
                                                                                                                                                                                                <p class="text-muted mb-0">No ${selectedType === 'all' ? '' : selectedType} transactions found</p>
                                                                                                                                                                                            </td>
                                                                                                                                                                                        `;
                    tbody.appendChild(noTransactionsRow);
                }
            }

            // Initial state
            updateTransactionView('all');

            // Handle dropdown change
            transactionType.addEventListener('change', function (e) {


                updateTransactionView(this.value);
            });

            // Handle transaction detail view
            const viewButtons = document.querySelectorAll('.view-transaction');
            viewButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const data = this.dataset;
                    let detailsHtml = `
                                                                                                                                                                                            <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                <strong>Transaction ID:</strong>
                                                                                                                                                                                                <p class="mb-0">${data.transactionId}</p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                <strong>Type:</strong>
                                                                                                                                                                                                <p class="mb-0">${data.type.charAt(0).toUpperCase() + data.type.slice(1)}</p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                <strong>Amount:</strong>
                                                                                                                                                                                                <p class="mb-0">₦${parseFloat(data.amount).toLocaleString('en-US', { minimumFractionDigits: 2 })}</p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                <strong>Status:</strong>
                                                                                                                                                                                                <p class="mb-0">${data.status.charAt(0).toUpperCase() + data.status.slice(1)}</p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                            <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                <strong>Date:</strong>
                                                                                                                                                                                                <p class="mb-0">${data.date}</p>
                                                                                                                                                                                            </div>
                                                                                                                                                                                        `;

                    // Add type-specific details
                    switch (data.type.toLowerCase()) {
                        case 'airtime':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Network:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.network}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Phone Number:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.phone}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        case 'data':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Network:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.network}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Phone Number:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.phone}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Plan:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.plan}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        case 'electricity':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Meter Number:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.meterNumber}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Disco:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.disco}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        case 'tv':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Smart Card Number:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.smartCard || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Package:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.package || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        case 'education':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Institution:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.institution || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Student ID:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.studentId || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        case 'insurance':
                            detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Policy Number:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.policyNumber || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Insurance Type:</strong>
                                                                                                                                                                                                        <p class="mb-0">${data.insuranceType || 'N/A'}</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                            break;
                        default:
                            $detailsHtml += `
                                                                                                                                                                                                    <div class="transaction-detail-item mb-3">
                                                                                                                                                                                                        <strong>Details:</strong>
                                                                                                                                                                                                        <p class="mb-0">No additional details available for this transaction type.</p>
                                                                                                                                                                                                    </div>
                                                                                                                                                                                                `;
                    }

                    document.getElementById('transactionDetails').innerHTML = detailsHtml;
                });
            });
        });
    </script>
@endsection

@section('styles')
    <style>
        .table thead th {
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge {
            font-size: 0.75rem;
            padding: 0.5em 0.75em;
        }

        .transaction-row:hover {
            background-color: #f8f9fa;
            cursor: pointer;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: white;
        }

        .form-select {
            padding: 0.375rem 2.25rem 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 0.25rem;
        }

        .transaction-detail-item strong {
            display: block;
            color: #6c757d;
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
        }

        .transaction-detail-item p {
            font-size: 1rem;
            color: #344767;
        }
    </style>
@endsection
