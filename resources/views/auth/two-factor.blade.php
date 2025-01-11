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
                        <form method="POST" action="{{ route('two-factor.verify') }}" class="theme-form">
                            @csrf
                            <h4>Two-Factor Authentication</h4>
                            <p>Enter the code sent to your email to verify your identity.</p>
                            
                            <div class="form-group">
                                <label for="two_factor_code" class="col-form-label">Enter the code sent to your email:</label>
                                <input type="text" id="two_factor_code" name="two_factor_code" class="form-control @error('two_factor_code') is-invalid @enderror" required>
                                
                                @error('two_factor_code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <div class="text-end mt-3">
                                    <button class="btn btn-primary btn-block w-100" type="submit">Verify</button>
                                </div>
                            </div>

                            <div class="mt-3">
                                <a href="{{ route('login') }}">
                                    Back to login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
