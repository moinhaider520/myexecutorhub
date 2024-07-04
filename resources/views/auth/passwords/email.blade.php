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
                        <form method="POST" action="{{ route('password.email') }}" class="theme-form">
                            @csrf
                            <h4>{{ __('Reset Password') }}</h4>
                            <p>Enter your email to receive a password reset link</p>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="email" class="col-form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button type="submit" class="btn btn-primary btn-block w-100">{{ __('Send Password Reset Link') }}</button>
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
