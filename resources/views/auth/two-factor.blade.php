@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card login-dark">
                <div>
                    <div>
                        <a class="logo" href="{{ url('/') }}">
                            <img class="img-fluid for-light"
                                src="{{ asset('assets/frontend/images/logo-skyblue.png') }}"
                                alt="loginpage"
                                style="width:200px;">
                        </a>
                    </div>

                    <div class="login-main">

                        {{-- Alerts --}}
                        @if (session('status'))
                        <div class="alert alert-info">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if ($errors->has('sms'))
                        <div class="alert alert-danger">
                            {{ $errors->first('sms') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('two-factor.verify') }}" class="theme-form">
                            @csrf

                            <h4 class="mb-1">Two-Factor Authentication</h4>
                            <p class="text-muted mb-3">Enter the code sent to your email to verify your identity.</p>

                            <div class="form-group">
                                <label for="two_factor_code" class="col-form-label">Verification code</label>
                                <input
                                    type="text"
                                    id="two_factor_code"
                                    name="two_factor_code"
                                    inputmode="numeric"
                                    autocomplete="one-time-code"
                                    maxlength="6"
                                    class="form-control @error('two_factor_code') is-invalid @enderror"
                                    placeholder="Enter 6-digit code"
                                    required>

                                @error('two_factor_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            {{-- Primary action --}}
                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary w-100" type="submit">
                                        Verify & Continue
                                    </button>
                                </div>
                            </div>
                        </form>

                        {{-- Secondary actions --}}
                        <div class="mt-3">
                            <div class="d-flex gap-2">
                                <form method="POST" action="{{ route('two-factor.resend') }}" class="w-50">
                                    @csrf
                                    <button type="submit" class="btn btn-light w-100">
                                        Resend via Email
                                    </button>
                                </form>

                                <form method="POST" action="{{ route('two-factor.sms') }}" class="w-50">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-primary w-100">
                                        Send via SMS
                                    </button>
                                </form>
                            </div>

                            <small class="d-block text-muted mt-2">
                                If you didn’t receive a code, resend via email or request an SMS.
                            </small>
                        </div>

                        {{-- Tertiary link --}}
                        <div class="mt-4 text-center">
                            <a href="{{ route('login') }}" class="text-decoration-none">
                                ← Back to login
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection