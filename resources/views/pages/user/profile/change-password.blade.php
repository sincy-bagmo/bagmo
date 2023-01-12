@extends('layouts.user-dashboard')
@section('content')
<section class="app-user-view-security">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
        @include('pages.user.profile.includes.user-card')
        </div>
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
        @include('pages.user.profile.includes.head')
            <div class="card">
                <h4 class="card-header">Change Password</h4>
                <div class="card-body">
                    <form id="formChangePassword" action="{{route('user.profile.update-password')}}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="mb-2 col-md-12 form-password-toggle">
                                <label class="form-label" for="newPassword">Current password</label>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" name="current_password" class="form-control" id="inputName" placeholder="Enter Current Password" />
                                    <span class="input-group-text cursor-pointer">
                                       <i data-feather="eye"></i>
                                    </span>
                                </div>
                                @error('current_password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-2 col-md-6 form-password-toggle">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge form-password-toggle">
                                    <input type="password" name="password" class="form-control" id="inputName" placeholder="Enter New Password" />
                                    <span class="input-group-text cursor-pointer">
                                       <i data-feather="eye"></i>
                                    </span>
                                </div>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-2 col-md-6 form-password-toggle">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" name="password_confirmation" class="form-control" id="confirmPassword" placeholder="Confirm New Password"/>
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                                @error('password_confirmation')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Change Password</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
