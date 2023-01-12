@extends('layouts.admin-login')

@section('content')
    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <!-- Login basic -->
            <div class="card mb-0">
                <div class="card-body">
                    <a href="javascript:;" class="brand-logo">
                        <img src="{{ asset('images/logo.svg') }}" width="250px;" 
                            style="max-width:250px;">
                        <!-- <h2 class="brand-text text-primary ms-1">{{ env('APP_NAME') }}</h2> -->
                    </a>
                    <h4 class="card-title mb-1">Welcome to {{ config('app.name') }}! 👋</h4>

                    <form class="auth-login-form mt-2" action="{{ route('admin.login') }}" method="POST">
                        @csrf
                        <div class="mb-1">
                            <label for="login-email" class="form-label">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email"  tabindex="1" autofocus placeholder="email">
                            @error('email')
                            <span id="email-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-1">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="login-password">Password</label>
                                <a href="{{ route('admin.password.request') }}">
                                    <small>Forgot Password?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input id="password" type="password" class="form-control form-control-merge @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" aria-describedby="login-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;">
                                <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                            </div>
                            @error('password')
                            <span id="email-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" tabindex="3" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" tabindex="4">Sign in</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
