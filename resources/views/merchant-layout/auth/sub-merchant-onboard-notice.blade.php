@extends('merchant-layout.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Merchant Onboarding Status</h4>
                    </div>
                    <div class="card-body">
                        @if (isset($merchant) && $merchant->onboarded_at)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle mr-2"></i>
                                <strong>Successfully Onboarded!</strong>
                                <p class="mt-2">Your merchant account has been successfully onboarded. You can now access
                                    all features of the platform.</p>
                            </div>
                            <div class="text-center mt-4">
                                <a href="{{ route('merchant.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
                            </div>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <strong>Onboarding Incomplete</strong>
                                <p class="mt-2">Your merchant account has not been fully onboarded yet. Please complete
                                    the onboarding process to access all features.</p>
                            </div>

                            <div class="mt-4">
                                <h5>Onboarding Steps:</h5>
                                <ul class="list-group mt-3">
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Complete Profile Information
                                        @if (isset($merchant) && $merchant->profile_complete)
                                            <span class="badge bg-success rounded-pill"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Pending</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Verify Business Details
                                        @if (isset($merchant) && $merchant->business_verified)
                                            <span class="badge bg-success rounded-pill"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Pending</span>
                                        @endif
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        Set Up Payment Methods
                                        @if (isset($merchant) && $merchant->payment_setup)
                                            <span class="badge bg-success rounded-pill"><i class="fas fa-check"></i></span>
                                        @else
                                            <span class="badge bg-secondary rounded-pill">Pending</span>
                                        @endif
                                    </li>
                                </ul>
                            </div>

                            <div class="text-center mt-4">
                                <a href="{{ route('merchant.onboarding.page', $merchant->token) }}"
                                    class="btn btn-primary">Complete
                                    Onboarding</a>
                                <a href="{{ route('merchant.dashboard') }}" class="btn btn-outline-secondary ml-2">Back to
                                    Dashboard</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .badge {
            padding: 8px;
        }

        .ml-2 {
            margin-left: 0.5rem;
        }

        .mr-2 {
            margin-right: 0.5rem;
        }
    </style>
@endpush
