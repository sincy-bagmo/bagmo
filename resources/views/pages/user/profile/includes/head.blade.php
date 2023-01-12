<ul class="nav nav-pills mb-2">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/profile') || request()->is('user/profile') ? 'active' : '' }}" href="{{ route('user.profile.index') }}">
            <i data-feather="user" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Account</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/profile/change-password') || request()->is('user/profile/change-password/*') ? 'active' : '' }}" href="{{ route('user.profile.change-password') }}">
            <i data-feather="lock" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Change Password</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('user/profile/recent-login') || request()->is('user/profile/recent-login/*') ? 'active' : '' }}" href="{{ route('user.profile.recent-login') }}">
            <i data-feather="bookmark" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Recent Logins</span>
        </a>
    </li>
</ul>
