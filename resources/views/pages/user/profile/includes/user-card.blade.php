<div class="card">
    <div class="card-body">
        <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <img class="img-fluid rounded mt-3 mb-2" src="{{ ProfileHelper::getProfileImageFromFile(Auth::guard(AuthConstants::GUARD_USER)->user()->profile_image, AuthConstants::GUARD_USER) }}" height="110" width="110" alt="User avatar" />
                <div class="user-info text-center">
{{--                    <h4>{{ Str::limit(ProfileHelper::getFullName(AuthConstants::GUARD_USER), 10) }}</h4>--}}
                    <h4>{{ ProfileHelper::getFullName(AuthConstants::GUARD_USER) }}</h4>
                    <span class="badge bg-light-secondary">User</span>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-around my-2 pt-75">
            <div class="d-flex align-items-start me-2">
                <span class="badge bg-light-primary p-75 rounded">
                    <i data-feather="check" class="font-medium-2"></i>
                </span>
                <div class="ms-75">
                    <h4 class="mb-0"></h4>
                    <small>Active Devices</small>
                </div>
            </div>
            <div class="d-flex align-items-start">
                <span class="badge bg-light-primary p-75 rounded">
                    <i data-feather="briefcase" class="font-medium-2"></i>
                </span>
                <div class="ms-75">
                    <h4 class="mb-0"></h4>
                    <small>In Active Devices</small>
                </div>
            </div>
        </div>
        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
        <div class="info-container">
            <ul class="list-unstyled">
                <li class="mb-75">
                    <span class="fw-bolder me-25">Username:</span>
                    <span>{{ ProfileHelper::getFullName(AuthConstants::GUARD_USER) }}</span>
                </li>
                <li class="mb-75">
                    <span class="fw-bolder me-25">Email:</span>
                    <span>{{ Auth::guard(AuthConstants::GUARD_USER)->user()->email }}</span>
                </li>
                <li class="mb-75">
                    <span class="fw-bolder me-25">Status:</span>
                    {!! ProfileHelper::getUserStatus(Auth::guard(AuthConstants::GUARD_USER)->user()->status) !!}
                </li>
                <li class="mb-75">
                    <span class="fw-bolder me-25">Role:</span>
                    <span>User</span>
                </li>
            </ul>
        </div>
    </div>
</div>
