@extends('users-layout.dashboard.layouts.auth')


@section('title')
    Register
@endsection

@section('content')

<h4 class="text-center font-size-18 text-bold-large"><b>Register to
        {{ Helper::merchant()->name }}</b></h4>

<div class="p-3">
    <form
        action="{{ route('users.registrationAction', [
            'slug' => Helper::merchant()->slug,
        ]) }}"
        method="post">
        @csrf
        <div class="form-group mb-3 row">
                <div class="col-12">
                    <input class="form-control @error('fname') is-invalid @enderror" type="text"
                                required="" placeholder="Full Name" id="fname" name="fname"
                                value="{{ old('fname') }}">
                            @error('fname')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('username') is-invalid @enderror" type="text"
                                required="" placeholder="Username" id="username" name="username"
                                value="{{ old('username') }}">
                            @error('username')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('email') is-invalid @enderror" type="email"
                                required="" placeholder="Email" id="email" name="email"
                                value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input id="user" class="form-control @error('tel') is-invalid @enderror"
                                type="text" required="" placeholder="Phone number" name="tel"
                                value="{{ old('tel') }}">
                            @error('tel')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('address') is-invalid @enderror" type="text"
                                required="" placeholder="Address" id="address" name="address"
                                value="{{ old('address') }}">
                            @error('address')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    @php
                        $referral = request('ref'); // Get the 'ref' parameter from the URL
                    @endphp
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('referral') is-invalid @enderror" type="text"
                                placeholder="Referral username [optional]" id="referral" name="referral"
                                value="{{ old('referral', $referral) }}">
                            @error('referral')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <!-- Set value to the 'ref' parameter if available, or leave it empty -->
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('password') is-invalid @enderror"
                                type="password" required="" placeholder="Password" id="pass"
                                name="password">
                            @error('password')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <input class="form-control @error('password_confirmation') is-invalid @enderror"
                                type="password" required="" placeholder="Confirm password" id="pass"
                                name="password_confirmation">
                            @error('password_confirmation')
                                <span class="invalid-feedback d-block" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mb-3 row">
                        <div class="col-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                    class="custom-control-input @error('terms') is-invalid @enderror"
                                    id="terms" name="terms">
                                <label class="form-label ms-1 fw-normal" for="terms">I accept <a
                                        href="#" class="text-muted">Terms and Conditions</a></label>
                                @error('terms')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-center row mt-3 pt-1">
                        <div class="col-12">
                            <button class="btn btn-org w-100 waves-effect waves-light"
                                type="submit">Register</button>
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-0 row">
                        <div class="col-12 mt-3 text-center">
                            <a href="{{ route('users.login', [
                                'slug' => Helper::merchant()->slug,
                            ]) }}"
                                class="text-muted">Already have an account?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

    @endsection
