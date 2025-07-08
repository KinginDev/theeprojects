@extends('users-layout.dashboard.layouts.auth')

@section('title')
    Login
@endsection

@section('content')
<h4 class="text-center font-size-18 text-bold"><b>Sign In</b></h4>

<div class="p-3">
    <form
        action="{{ route('users.loginAction', [
            'slug' => Helper::merchant()->slug,
        ]) }}"
        method="post">
        @csrf
        <div class="form-group mb-3 row">
            <div class="col-12">
                <input class="form-control @error('emailTel') is-invalid @enderror" type="text" required
                    placeholder="Email or Phone number" id="user" name="emailTel" value="{{old('emailTel')}}">
                @error('emailTel')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-12">
            <div class="input-group">
                <input class="form-control @error('password') is-invalid @enderror" type="password" required placeholder="Password"
                    id="pass" name="password">
                        <button class="btn btn-outline-secondary" type="button"  onclick="togglePassword('pass')">
                    <i class="bi bi-eye"></i>
                        </button>
            </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>

        <div class="form-group mb-3 row">
            <div class="col-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember"
                        name="remember">
                    <label class="form-label ms-1" for="customCheck1">Remember me</label>
                </div>
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
                <a href="{{ route('users.forget.password', [
                    'slug' => Helper::merchant()->slug,
                ]) }}"
                    class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
            </div>
            <div class="col-sm-5 mt-3">
                <a href="{{ route('users.registration', [
                    'slug' => Helper::merchant()->slug,
                ]) }}"
                    class="text-muted"><i class="mdi mdi-account-circle"></i> Create an account</a>
            </div>
        </div>
    </form>
</div>
@endsection
