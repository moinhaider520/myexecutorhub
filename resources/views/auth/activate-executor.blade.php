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
                            <form method="POST" action="{{ route('executor.activate.store', $token) }}" class="theme-form">
                                @csrf
                                <h4>Activate Executor Access</h4>
                                <p>Set your password to activate your Executor Hub account for {{ $user->email }}.</p>

                                <div class="form-group">
                                    <label class="col-form-label">Create Password</label>
                                    <input id="password" class="form-control @error('password') is-invalid @enderror"
                                        type="password" name="password" required autocomplete="new-password"
                                        placeholder="*********">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Confirm Password</label>
                                    <input id="password-confirm" class="form-control" type="password"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="*********">
                                </div>

                                <div class="form-group mb-0">
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Activate Account</button>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <a href="{{ route('login') }}">Back to sign in</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
