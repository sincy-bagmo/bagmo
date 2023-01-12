<!-- BEGIN: Main Menu-->
<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xxl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="{{ route('user.home') }}">
                        <span class="brand-logo">
{{--                            <img src="{{ asset('images/fav-200.png') }}"></span>--}}
                        </span>
                        <h2 class="brand-text mb-0">{{ config('app.name') }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>

        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="{{ Request::routeIs('user.home') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.home') }}"><i data-feather="home"></i><span data-i18n="Dashboards">Dashboards</span></a></li>

                <!-- Orders -->
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown"><i data-feather='shopping-cart'></i><span data-i18n="Forms &amp; Tables">Orders</span></a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        {{--<li data-menu="" class="{{ Request::routeIs('user.order.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.order.index') }}" data-bs-toggle="" data-i18n="Analytics"><i data-feather="activity"></i><span data-i18n="Analytics">Analytics</span></a>--}}
                        <li data-menu="" class="{{ Request::routeIs('user.order.pending-order.create') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.order.pending-order.create') }}" data-bs-toggle="" data-i18n="Add Request"><i data-feather='plus-circle'></i><span data-i18n="Add Request">Add Request</span></a>
                        <li data-menu="" class="{{ Request::routeIs('user.order.pending-order.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.order.pending-order.index') }}" data-bs-toggle="" data-i18n="Pending Orders<"><i data-feather='shopping-bag'></i><span data-i18n="Pending Orders<">Pending Orders</span></a>
                        <li data-menu="" class="{{ Request::routeIs('user.order.issued-order.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.order.issued-order.index') }}" data-bs-toggle="" data-i18n="Orders Issued To OT"><i data-feather='shield'></i><span data-i18n="Orders Issued To OT">Orders Issued</span></a>
                        <li data-menu="" class="{{ Request::routeIs('user.order.returned-order.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('user.order.returned-order.index') }}" data-bs-toggle="" data-i18n="Completed Orders"><i data-feather='zap'></i><span data-i18n="Completed Orders">Returned Orders</span></a>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- END: Main Menu-->
