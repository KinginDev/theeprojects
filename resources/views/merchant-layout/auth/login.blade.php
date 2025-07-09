@extends('merchant-layout.layouts.auth')

@section('title')
    Merchant Login
@endsection

@section('content')
    <h4 class="text-center font-size-18 text-bold mb-4"><b>Sign In as a Merchant</b></h4>

    <div class="p-3">
        <form action="{{ route('merchant.login.submit') }}" method="post">
            @csrf
            <div class="form-group mb-4">
                <label for="user" class="form-label">Email or Phone number</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                    <input class="form-control @error('email') is-invalid @enderror" type="text" required
                        placeholder="Enter your email or phone number" id="user" name="email" value="{{ old('email') }}">
                </div>
                @error('email')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <label for="pass" class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                    <input class="form-control @error('password') is-invalid @enderror" type="password" required
                        placeholder="Enter your password" id="pass" name="password">
                    <button type="button" class="input-group-text" onclick="togglePassword('pass')">
                        <i class="bi bi-eye-slash"></i>
                    </button>
                </div>
                @error('password')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <div class="d-flex align-items-center">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('checkbox') is-invalid @enderror"
                            id="remember" name="checkbox" {{ old('checkbox') ? 'checked' : '' }}>
                        <label class="form-check-label ms-2" for="remember">Remember me</label>
                    </div>
                </div>
                @error('checkbox')
                    <span class="text-danger small mt-1" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-4">
                <button class="btn btn-org w-100 waves-effect waves-light py-2" type="submit">
                    <i class="mdi mdi-login me-2"></i>Log In
                </button>
            </div>

            <div class="mt-4 text-center">
                <div class="row">
                    <div class="col-12 mb-3">
                        <a href="{{ route('merchant.show.password') }}" class="text-muted">
                            <i class="mdi mdi-lock me-1"></i> Forgot your password?
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('additional_content')
    <div class="mt-3 text-center">
        <div class="card">
            <div class="card-body p-3">
                <p class="mb-0">Don't have an account?
                    <a href="{{ route('merchant.register') }}" class="fw-medium text-primary">
                        <i class="mdi mdi-account-plus me-1"></i>Register now
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
