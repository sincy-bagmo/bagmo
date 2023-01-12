
    <div class="card">
        <div class="card-body">
            <div class="user-avatar-section">
                <div class="d-flex align-items-center flex-column">
                    <div class="user-info text-center">
                        <h4>Surgery Name</h4>
                    </div>
                    <div class=" badge"><h4></h4></div>
                </div>
            </div>
            <div class="d-flex justify-content-around my-2 pt-75">
                <div class="d-flex align-items-start me-2">
                    <span class="badge bg-light-primary p-75 rounded">
                        <i data-feather='layers'></i>
                    </span>
                    <div class="ms-75">
                        <h4 class="mb-0">{{ $trayCount }}</h4>
                        <small>Trays</small>
                    </div>
                </div>
                <div class="d-flex align-items-start">
                    <span class="badge bg-light-primary p-75 rounded">
                        <i data-feather="briefcase" class="font-medium-2"></i>
                    </span>
                    <div class="ms-75">
                        <h4 class="mb-0">{{ $instrumentCount }}</h4>
                        <small>Instruments</small>
                    </div>
                </div>
            </div>
            <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
            <div class="info-container">
                <ul class="list-unstyled">
                    <li class="mb-75">
                        <span class="fw-bolder me-25"> Doctor:</span>
                        <span>{{ ucfirst($orders->doctor_name) }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Theatre:</span>
                        <span>{{ Auth::user()->ot_name }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Requested On:</span>
                        <span>{{ DateHelper::getCurrentHumanReadableTimeFromDate($orders->created_at) }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Booked For:</span>
                        <span>{{ $orders->booking_date }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Order Issued :</span>
                        <span>{{ DateHelper::getCurrentHumanReadableTimeFromDate($orders->order_send_to_ot_at) }}</span>
                    </li>
                    <li class="mb-75">
                        <span class="fw-bolder me-25">Order Barcode :</span>
                        <span><a href="{{ route('user.order.order-barcode', $orders->id) }}" class="company-name" target="_blank">{{ $orders->barcode }}</a></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

