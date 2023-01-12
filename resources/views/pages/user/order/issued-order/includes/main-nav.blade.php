<ul class="nav nav-pills mb-2">
    <li class="nav-item">
        <a class="nav-link  {{ request()->is('user/order/issued-order/') ? 'active' : '' }}"
           href="">
            <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Order</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link "
           href="">
           <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Logs</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link "
           href="">
            <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Missing Items</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link "
           href="">
            <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Wash Methods</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link "
           href="">
           <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Returned Items</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link "
           href="">
           <i data-feather="shield" class="font-medium-3 me-50"></i>
            <span class="fw-bold">Damaged Items</span>
        </a>
    </li>
</ul>
