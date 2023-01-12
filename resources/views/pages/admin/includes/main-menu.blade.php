<!-- BEGIN: Main Menu-->
<div class="horizontal-menu-wrapper">
    <div class="header-navbar navbar-expand-sm navbar navbar-horizontal floating-nav navbar-light navbar-shadow menu-border container-xxl" role="navigation" data-menu="menu-wrapper" data-menu-type="floating-nav">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item me-auto"><a class="navbar-brand" href="{{ route('admin.home') }}">
                        <span class="brand-logo">
                            {{-- <img src="{{ asset('images/fav-200.png') }}"></span>--}}
                        </span>
                        <h2 class="brand-text mb-0">{{ config('app.name') }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>

        <div class="navbar-container main-menu-content" data-menu="menu-container">
            <ul class="nav navbar-nav" id="main-menu-navigation" data-menu="menu-navigation">
                <li class="{{ Request::routeIs('admin.home') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.home') }}"><i data-feather="home"></i><span data-i18n="Dashboards">Dashboards</span></a></li>


                <!-- Refrigerator -->
                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown"><i data-feather="settings"></i><span data-i18n="settings">Refrigerator</span></a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="" class="{{ Request::routeIs('admin.refrigerator.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.refrigerator.index') }}" data-bs-toggle="" data-i18n="Email"><i data-feather='package'></i><span data-i18n="Department Management">Add Refrigerator</span></a></li>
                    </ul>
                </li>

                <li class="dropdown nav-item" data-menu="dropdown"><a class="dropdown-toggle nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown"><i data-feather="layers"></i><span data-i18n="Forms &amp; Tables">Blood Bag</span></a>
                    <ul class="dropdown-menu" data-bs-popper="none">
                        <li data-menu="" class="{{ Request::routeIs('admin.blood-bag.index') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.blood-bag.index') }}" data-bs-toggle="" data-i18n="Input"><i data-feather="circle"></i><span data-i18n="Input">Blood Bag</span></a>
                        <li data-menu="" class=" {{ Request::routeIs('admin.blood-bag.scan-barcode-out') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.blood-bag.scan-barcode-out') }}" data-bs-toggle="" data-i18n="Input"><i data-feather="circle"></i><span data-i18n="Input">Scan Blood Bag Out</span></a></li>
                        <li data-menu="" class=" {{ Request::routeIs('admin.blood-bag.scan-barcode-in') ? 'active' : '' }}"><a class="dropdown-item d-flex align-items-center" href="{{ route('admin.blood-bag.scan-barcode-in') }}" data-bs-toggle="" data-i18n="Input"><i data-feather="circle"></i><span data-i18n="Input">Scan Blood Bag In</span></a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- END: Main Menu-->
