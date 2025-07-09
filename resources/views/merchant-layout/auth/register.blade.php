@extends('merchant-layout.layouts.auth')

@section('title')
    Merchant Registration
@endsection

@section('content')
    <h4 class="text-center font-size-18 text-bold mb-4"><b>Register as a Merchant</b></h4>

    <div class="p-3">
        <form action="{{ route('merchant.register.submit') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Merchant Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-store"></i></span>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" required
                            placeholder="Enter your business name" id="name" name="name" value="{{ old('name') }}">
                    </div>
                    @error('name')
                        <span class="text-danger small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" required
                            placeholder="Enter your email" id="email" name="email" value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <span class="text-danger small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="user" class="form-label">Phone Number</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                        <input id="user" class="form-control @error('tel') is-invalid @enderror" type="text"
                            required placeholder="Enter your phone number" name="tel" value="{{ old('tel') }}">
                    </div>
                    @error('tel')
                        <span class="text-danger small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Business Address</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-map-marker"></i></span>
                    <input class="form-control @error('address') is-invalid @enderror" type="text" required
                        placeholder="Enter your business address" id="address" name="address" value="{{ old('address') }}">
                </div>
                @error('address')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            @php
                $referral = request('ref'); // Get the 'ref' parameter from the URL
            @endphp
            <div class="mb-3">
                <label for="referral" class="form-label">Referral Username (Optional)</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-account-multiple"></i></span>
                    <input class="form-control @error('referral') is-invalid @enderror" type="text"
                        placeholder="Enter referral username if any" id="referral" name="referral"
                        value="{{ old('referral', $referral) }}">
                </div>
                @error('referral')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" required
                            placeholder="Enter your password" id="password" name="password">
                        <button type="button" class="input-group-text" onclick="togglePassword('password')">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="text-danger small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="mdi mdi-lock-check"></i></span>
                        <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                            required placeholder="Confirm your password" id="password_confirmation"
                            name="password_confirmation">
                        <button type="button" class="input-group-text" onclick="togglePassword('password_confirmation')">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <span class="text-danger small mt-1" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input @error('terms') is-invalid @enderror"
                        id="terms" name="terms">
                    <label class="form-check-label ms-2" for="terms">
                        I accept the <a href="#" class="text-primary">Terms and Conditions</a>
                    </label>
                </div>
                @error('terms')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="mb-4">
                <button class="btn btn-org w-100 waves-effect waves-light py-2" type="submit">
                    <i class="mdi mdi-account-plus me-2"></i>Register
                </button>
            </div>
        </form>
    </div>
@endsection

@section('additional_content')
    <div class="mt-3 text-center">
        <div class="card">
            <div class="card-body p-3">
                <p class="mb-0">Already have an account?
                    <a href="{{ route('merchant.login') }}" class="fw-medium text-primary">
                        <i class="mdi mdi-login me-1"></i>Log in here
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
