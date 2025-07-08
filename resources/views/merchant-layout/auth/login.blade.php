@extends('merchant-layout.layouts.auth')

@section('title')
    Merchant Login
@endsection

@section('content')
    <h4 class="text-center font-size-18 text-bold"><b>Sign In as a Merchant</b></h4>

    <div class="p-3">
        <form action="{{ route('merchant.login.submit') }}" method="post">
            @csrf
            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control @error('email') is-invalid @enderror" type="text" required
                        placeholder="Email or Phone number" id="user" name="email" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control @error('password') is-invalid @enderror" type="password" required
                        placeholder="Password" id="pass" name="password">
                    @error('password')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3 row">
                <div class="col-12">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input @error('checkbox') is-invalid @enderror"
                            id="remember" name="checkbox" {{ old('checkbox') ? 'checked' : '' }}>
                        <label class="form-label ms-1" for="remember">Remember me</label>
                    </div>
                    @error('checkbox')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="form-group mb-3 text-center row mt-3 pt-1">
                <div class="col-12">
                    <button class="btn btn-org w-100 waves-effect waves-light" type="submit">Log
                        In</button>
                </div>
            </div>

            <div class="form-group mb-0 row mt-2">
                <div class="col-sm-7 mt-3">
                    <a href="{{ route('merchant.show.password') }}" class="text-muted"><i class="mdi mdi-lock"></i> Forgot
                        your password?</a>
                </div>
                <div class="col-sm-5 mt-3">
                    <a href="{{ route('merchant.register') }}" class="text-muted"><i class="mdi mdi-account-circle"></i>
                        Create an account</a>
                </div>
            </div>
        </form>
    </div>
@endsection
