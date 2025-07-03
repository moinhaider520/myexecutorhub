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
                                    src="{{ asset('assets/frontend/images/logo-skyblue.png') }}" alt="loginpage"
                                    style="width:200px;">
                            </a>
                        </div>
                        <div class="login-main">
                            <form method="POST" action="{{ route('partner-registration.store') }}" class="theme-form">
                                @csrf
                                <h4>Sign Up as a Partner</h4>
                                <p>Enter your details to create an account</p>
                                <div class="form-group">
                                    <label class="col-form-label">Name</label>
                                    <input id="name" class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Your Name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Email Address</label>
                                    <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="admin@admin.com">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Password</label>
                                    <div class="form-input position-relative">
                                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                                            type="password" name="password" required autocomplete="new-password"
                                            placeholder="*********">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input id="password-confirm" class="form-control" type="password"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="*********">
                                </div>
                                <!-- Email notifications checkbox -->
                                <div class="form-group">
                                    <div>
                                        <input class="" type="checkbox" name="email_notifications" id="email_notifications"
                                            value="1" {{ old('email_notifications') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="email_notifications">
                                            Opt in to email notifications?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div>
                                        <input class="" type="checkbox" name="privacy_policy" id="privacy_policy" value="1"
                                            {{ old('privacy_policy') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="privacy_policy">
                                            Do you agree with our terms and privacy policy?
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                    </div>
                                    @error('g-recaptcha-response')
                                        <span class="text-danger d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Sign up</button>
                                    </div>
                                </div>
                                <div class=" mt-3">
                                    <a href="{{ route('login') }}">
                                        Already have an account?
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

@endsection