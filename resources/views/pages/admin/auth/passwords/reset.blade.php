@extends('layouts.admin-pasword-reset')

@section('content')

    <div class="auth-wrapper auth-basic px-2">
        <div class="auth-inner my-2">
            <div class="card mb-0">
                <div class="card-body">
                    <a href="{{ route('admin.login') }}" class="brand-logo">
                        <img src="{{ asset('images/eduwizz.svg') }}">

                    </a>
                    <h4 class="card-title mb-1">Reset Password ! 🔒</h4>
                    <form class="auth-reset-password-form mt-2" method="POST" action="{{ route('admin.password.request') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') error @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus aria-describedby="email" tabindex="1" />
                            @error('email')
                            <span id="email-error" class="error" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') error @enderror" id="password" name="password" placeholder="Enter New Password" value="" required autofocus aria-describedby="password" tabindex="2" />
                            @error('password')
                            <span id="password-error" class="error" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-1">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') error @enderror" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" value="" required autofocus aria-describedby="password" tabindex="3" />
                            @error('password_confirmation')
                            <span id="password-error" class="error" style="display: block;">{{ $message }}</span>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100" tabindex="4">{{ __('Reset Password') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
