@extends('merchant-layout.layouts.auth')

@section('title')
    Verify Email
@endsection


@section('content')
    <div class="">
        <div class="text-center mb-4">
            <i class="fas fa-envelope-open-text fa-3x text-primary mb-3"></i>
            <h3 class="font-weight-bold">Verify Your Email Address</h3>
        </div>

        @if (session('resent'))
            <div class="alert alert-success fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <div class="text-center mb-4">
            <p class="text-muted">
                Before proceeding, please check your email for a verification link.
            </p>
        </div>

        <div class="text-center">
            <p class="text-muted mb-0">
                Didn't receive the email?
            </p>
            <form class="d-inline" method="POST"
                action="{{ route('merchant.verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-link text-primary">
                    <i class="fas fa-redo me-1"></i>Resend verification link
                </button>
            </form>
        </div>
    </div>
@endsection
