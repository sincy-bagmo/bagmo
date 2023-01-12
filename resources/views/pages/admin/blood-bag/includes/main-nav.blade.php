<ul class="nav nav-tabs card-header-tabs ms-0" id="nav-tabs" role="tablist">
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/blood-bag/show/' . $bloodBag->id) ? 'active' : '' }}" href="{{ route('admin.blood-bag.show', $bloodBag->id) }}">
            <i data-feather='info'></i>
            <span class="fw-bold">Details</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->is('admin/blood-bag/history/' . $bloodBag->id) ? 'active' : '' }}" href="{{ route('admin.blood-bag.history', $bloodBag->id) }}">
            <i data-feather='activity'></i>
            <span class="fw-bold">History</span>
        </a>
    </li>
</ul>