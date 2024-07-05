@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card login-dark">
                <div>
                    <div>
                        <a class="logo" href="{{ url('/') }}">
                            <img class="img-fluid for-light" src="{{ asset('assets/frontend/images/logo-skyblue.png') }}" alt="loginpage" style="width:200px;">
                        </a>
                    </div>
                    <div class="login-main">
                        <form method="POST" action="{{ route('password.update') }}" class="theme-form">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <h4>{{ __('Reset Password') }}</h4>

                            <div class="form-group">
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>

                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-block w-100">{{ __('Reset Password') }}</button>
                                </div>
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('login') }}">Sign in</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
