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
                                <div class="form-group">
                                    <label class="col-form-label">What is Your Profession?</label>
                                    <select class="form-control" name="profession" required>
                                        <option value="" selected disabled>Choose Profession</option>
                                        <option value="General Audience">General Audience</option>
                                        <option value="Solicitors">Solicitors</option>
                                        <option value="Will writers">Will writers</option>
                                        <option value="Estate planners">Estate planners</option>
                                        <option value="Financial advisers">Financial advisers</option>
                                        <option value="Ifas">Ifas</option>
                                        <option value="Life insurance specialists">Life insurance specialists</option>
                                        <option value="Accountants">Accountants</option>
                                        <option value="Networks">Networks</option>
                                        <option value="Societies">Societies</option>
                                        <option value="Regulatory bodies">Regulatory bodies</option>
                                        <option value="Institutes">Institutes</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Where Did You Hear About Us?</label>
                                    <select class="form-control" name="hear_about_us" required>
                                        <option value="">Choose Option</option>
                                        <option value="Social Media">Social Media</option>
                                        <option value="Email">Email</option>
                                        <option value="Friend & Family">Friend & Family</option>
                                    </select>
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