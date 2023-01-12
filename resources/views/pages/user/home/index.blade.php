@extends('layouts.user-dashboard')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-calendar.css')}}">

    <style>
        .avatar.bg-light-info {
            color: #00cfe8 !important;
            height: 48px !important;
        }

        .avatar.bg-light-success {
            color: #28c76f !important;
            height: 48px !important;
        }
        .avatar.bg-light-primary {
            color: #28c76f !important;
            height: 48px !important;
        }
    </style>
@endpush

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">

        <!-- Statistics -->
        <div class="row match-height">
            <!-- Medal Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-congratulation-medal">
                    <div class="card-body">
                        <h5>Welcome 🎉 {{ ProfileHelper::getFullName(AuthConstants::GUARD_USER) }}!</h5>
                        {!! PositiveQuotesHelper::getQuoteForTheDay() !!}
                        <img src="{{ asset('app-assets/images/illustration/badge.svg') }}" class="congratulation-medal" alt="Medal Pic" />
                    </div>
                </div>
            </div>
            <!--/ Medal Card -->

            <!-- Statistics Card -->
            <div class="col-xl-8 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-header">
                        <h4 class="card-title">Statistics</h4>
                        <div class="d-flex align-items-center">
                            <p class="card-text font-small-2 me-25 mb-0" id="current-time"></p>
                        </div>
                    </div>
                    <div class="card-body statistics-body">
                        <div class="row">
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="d-flex flex-row">
                                    <a href="#">
                                        <div class="avatar bg-light-info me-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $statisticsOfOrders['ordersRequested'] }}</h4>
                                        <p class="card-text font-small-3 mb-0">Pending Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="d-flex flex-row">
                                    <a href="#">
                                        <div class="avatar bg-light-danger me-2">
                                            <div class="avatar-content">
                                                <i data-feather="box" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $statisticsOfOrders['ordersInOT'] }}</h4>
                                        <p class="card-text font-small-3 mb-0">Orders Issued</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="d-flex flex-row">
                                    <a href="#">
                                        <div class="avatar bg-light-success me-2">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $statisticsOfOrders['ordersReturnedBacked'] }}</h4>
                                        <p class="card-text font-small-3 mb-0">Returned Orders</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6 col-12">
                                <div class="d-flex flex-row">
                                    <a href="#">
                                        <div class="avatar bg-light-success me-2">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                    </a>
                                    <div class="my-auto">
                                        <h4 class="fw-bolder mb-0">{{ $statisticsOfOrders['totalOrders'] }}</h4>
                                        <p class="card-text font-small-3 mb-0">Total Orders</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Statistics Card -->
        </div>
        <!-- Statistics -->

        <!-- OT Requests -->
        <div class="row match-height">
            <!-- Developer Meetup Card -->
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card card-company-table">
                    <div class="card-body p-1">
                        <div class="card-header">
                            <div>
                                <h4 class="card-title">Issued Orders</h4>
                            </div>
                            <div class="dropdown chart-dropdown">
                                <i data-feather="more-vertical" class="font-medium-3 cursor-pointer" data-bs-toggle="dropdown"></i>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a class="dropdown-item" href="{{ route('user.order.issued-order.index') }}">View All Issued</a>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <table id="dataTable1" class="invoice-list-table table">
                                <thead>
                                <tr>
                                    <th class="text-center">Surgery Name</th>
                                    <th class="text-center">Operation Theatres Name</th>
                                    <th class="text-center">Doctor Name</th>
                                    <th class="text-center">Barcode</th>
                                    <th class="text-center">Booked To</th>
                                    <th class="text-center">Booked On</th>
{{--                                    <th class="text-center">Action</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($activeOrders as $item)
                                    <tr>
                                        <td class="text-center">{{ Str::limit($item->operation_name, 20) }}</td>
                                        <td class="text-center">{{ Str::limit($item->ot_name, 20) }}</td>
                                        <td class="text-center">{{ Str::limit($item->doctor_name, 20) }}</td>
                                        <td class="text-center">{{ Str::limit($item->barcode, 20) }}</td>
                                        <td class="text-center">{{ DateHelper::toDateTimePicker($item->booking_date) }}</td>
                                        <td class="text-center">{{ DateHelper::toDateTimePicker($item->created_at) }}</td>
{{--                                        <td class="text-center">--}}
{{--                                            <button data-href="{{route('user.order.issued-order.details', $item->id)}}" data-id="{{$item->id}}" class="btn btn-primary btn-sm return-order" title="Return Order"><i class="fas fa-arrow-circle-left"></i></button>--}}
{{--                                            <a href="{{ route('user.order.issued-order.show', $item->id) }}" class="btn btn-primary btn-sm" title="View Details"><i data-feather='eye'></i></a>--}}
{{--                                        </td>--}}
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- OT Requests  -->

        <!-- Calendar -->
        <div class="row match-height">
            <div class="col-lg-12 col-12">
                <div class="app-calendar overflow-hidden border" id="order-calendar">
                    <div class="row g-0">
                        <!-- Sidebar -->
                        <div class="col app-calendar-sidebar flex-grow-0 overflow-hidden d-flex flex-column" id="app-calendar-sidebar">
                            <div class="sidebar-wrapper">
                                <div class="card-body d-flex justify-content-center">
                                    <a class="btn btn-primary btn-toggle-sidebar w-100" href="#" style="display:none;">
                                        <span class="align-middle">Add Event</span>
                                    </a>
                                </div>
                                <div class="card-body pb-0">
                                    <div class="mt-auto">
                                        <img src="{{asset('app-assets/images/pages/calendar-illustration.png')}}" alt="Calendar illustration" class="img-fluid"/>
                                    </div>
                                    <div class="calendar-events-filter" style="display:none;">
                                        <div class="form-check form-check-danger mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="danger" data-value="danger" checked/>
                                            <label class="form-check-label" for="danger">Danger</label>
                                        </div>
                                        <div class="form-check form-check-primary mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="primary" data-value="primary" checked/>
                                            <label class="form-check-label" for="primary">Primary</label>
                                        </div>
                                        <div class="form-check form-check-warning mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="warning" data-value="warning" checked />
                                            <label class="form-check-label" for="warning">Warning</label>
                                        </div>
                                        <div class="form-check form-check-success mb-1">
                                            <input type="checkbox" class="form-check-input input-filter" id="success" data-value="success" checked/>
                                            <label class="form-check-label" for="success">Success</label>
                                        </div>
                                        <div class="form-check form-check-info">
                                            <input type="checkbox" class="form-check-input input-filter" id="info" data-value="info" checked />
                                            <label class="form-check-label" for="info">Info</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /Sidebar -->

                        <!-- Calendar -->
                        <div class="col position-relative">
                            <div class="card shadow-none border-0 mb-0 rounded-0">
                                <div class="card-body pb-0">
                                    <div id="calendar">
                                    </div>
                                </div>
                            </div>

                            <div class="body-content-overlay">
                                <div class="text-center loader">
                                    <div class="spinner-border text-primary" role="status" style="width: 5rem;height: 5rem;">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- Calendar event modal-->
                <div class="modal event-sidebar fade" id="add-new-sidebar">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content p-0">
                            <div class="modal-header mb-1">
                                <h4 class="modal-title fw-bolder pb-50 text-primary">Event Details</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                            </div>
                            <div class="modal-body flex-grow-1 pb-sm-0 pb-3">
                                <div class="info-container">
                                    <ul class="list-unstyled">
                                        <li class="mb-75">
                                <span class="fw-bolder me-25"> Procedure :
                                    <span id="operation"></span>
                                </span>
                                            <span></span>
                                        </li>
                                        <li class="mb-75">
                                <span class="fw-bolder me-25"> Doctor :
                                    <span id="doctor_name"></span>
                                </span>
                                            <span></span>
                                        </li>
                                        <li class="mb-75">
                                <span class="fw-bolder me-25 text-primary">Booking Date :
                                    <span id="booking_date"></span>
                                </span>
                                            <span></span>
                                        </li>
                                        <li class="mb-75">
                                <span class="fw-bolder me-25">Description :
                                    <span id="description"></span>
                                </span>
                                            <span></span>
                                        </li>
                                        <li class="mb-75">
                                <span class="fw-bolder me-25">Created On :
                                    <span id="created_at"></span>
                                </span>
                                            <span></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary waves-effect waves-float waves-light" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Calendar event modal-->
            </div>
        </div>
        <!-- Calendar  -->

    </section>
    <!-- Dashboard Ecommerce ends -->
@endsection

@push('scripts')

    <script>
        // Display date time dynamic
        // Function to format 1 in 01
        const zeroFill = n => {
            return ('0' + n).slice(-2);
        }

        // Creates interval
        const interval = setInterval(() => {
            // Get current time
            const now = new Date();
            // Format date as in mm/dd/aaaa hh:ii:ss
            const dateTime = zeroFill((now.getMonth() + 1)) + '/' + zeroFill(now.getUTCDate()) + '/' + now.getFullYear() + ' ' + zeroFill(now.getHours()) + ':' + zeroFill(now.getMinutes()) + ':' + zeroFill(now.getSeconds());
            // Display the date and time on the screen using div#date-time
            document.getElementById('current-time').innerHTML = dateTime;
        }, 1000);
    </script>

    <script>
        var app = {
            initialize: function () {
                var datatable = $('#dataTable1').DataTable({
                    paging: true,
                    lengthChange: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    autoWidth: false,
                });
            },
        };
        app.initialize();

    </script>

    <script>
        var currentMonthOrders = {!! $currentMonthOrders !!}
        var events = [];
        $.each(currentMonthOrders, function (key, item) {
            var date = new Date(item.booking_date);
            events.push({
                id: item.id,
                url: '',
                title: item.operation_name,
                start: date,
                end: date,
                allDay: true,
                extendedProps: {
                    calendar: 'Primary',
                    //custom
                    doctor: item.doctor_name,
                    created: new Date(item.created_at),
                    description: item.description,
                },
            });
        });
    </script>

    <script src="{{ asset('app-assets/js/scripts/pages/app-calendar-custom.js') }}"></script>

@endpush
