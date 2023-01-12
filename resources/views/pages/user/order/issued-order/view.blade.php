@extends('layouts.user-dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-ecommerce.css') }}">
    <style type="text/css">
        .ecommerce-application .list-view .ecommerce-card {
            grid-template-columns: 1fr 3fr;
        }
        .custom-table {
            font-family: "Montserrat", Helvetica, Arial, serif;
            border-collapse: collapse;
            width: 100%;
            overflow: auto;
        }

        .custom-table td, th {
            text-align: left;
            padding: 8px;
        }

        .custom-table tr th {
            background-color: #dddddd;
        }
    </style>
@endpush

@section('content')
    <div class="content-body">
        <div class="bs-stepper checkout-tab-steps">
            <!-- Wizard starts -->
            <div class="bs-stepper-header">
                <div class="step" data-target="#step-cart" role="tab" id="step-cart-trigger" style="display:none;">
                    <button type="button" class="step-trigger"><span class="bs-stepper-box"><i data-feather="shopping-cart" class="font-medium-3"></i></span></button>
                </div>
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card card-statistics" style="margin-bottom: 0;">
                        <div class="card-body statistics-body">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <a href="#">
                                            <div class="avatar bg-light-primary me-2" >
                                                <div class="avatar-content">
                                                    <i data-feather="activity" class="activity-icon"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="my-auto">
                                            <h5 class="fw-bolder mb-0">Surgery</h5>
                                                <p class="card-text font-small-3 mb-0">{{ ucfirst($surgeryDetails->operation_name) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <a href="#">
                                            <div class="avatar bg-light-primary me-2" >
                                                <div class="avatar-content">
                                                    <i data-feather="shopping-cart" class="shopping-cart-icon"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="my-auto">
                                            <h5 class="fw-bolder mb-0">Order</h5>
                                                <p class="card-text font-small-3 mb-0">{{ $orders->barcode }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <a href="#">
                                            <div class="avatar bg-light-primary me-2" >
                                                <div class="avatar-content">
                                                    <i data-feather="calendar" class="calendar-icon"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="my-auto">
                                            <h5 class="fw-bolder mb-0">Booking Date</h5>
                                                <p class="card-text font-small-3 mb-0">
                                                    {{ DateHelper::format($orders->booking_date, 'd-m-Y') }}
                                                </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="d-flex flex-row">
                                        <a href="#">
                                            <div class="avatar bg-light-primary me-2" >
                                                <div class="avatar-content">
                                                    <i data-feather="pen-tool" class="pen-tool-icon"></i>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="my-auto">
                                            <h5 class="fw-bolder mb-0">Requested On</h5>
                                                <p class="card-text font-small-3 mb-0">
                                                    {{ DateHelper::format($orders->created_on, 'd-m-Y') }}
                                                </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Wizard ends -->

            <div class="bs-stepper-content">
                <!-- Checkout Place order starts -->
                <div id="step-cart" class="content">
                    <div id="place-order" class="list-view product-checkout">
                        <!-- Checkout Place Order Left starts -->
                        <div class="checkout-items">
                            @foreach($trayDetails as $item)
                            <div class="card ecommerce-card">
                                <div class="item-img">
                                  <a href="javascript:;">
                                    <img src="{{ InstrumentHelper::getTrayImageFromFile($item['tray_details']->image, FileDestinations::TRAY_IMAGES) }}" alt="img-placeholder" />
                                  </a>
                                </div>
                                <div class="card-body" style="border-right: 0px;">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <div class="d-flex flex-row">
                                            <div class="user-info">
                                                <h4 class="mb-0 text-primary">{{ ucfirst($item['tray_details']->tray_name) }}</h4>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                                            <div class="content-body">
                                                <h6 class="mb-0">Last Washed : {{ DateHelper::getCurrentHumanReadableTimeFromDate($item['tray_details']->last_wash_cycle) }}</h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                                            <div class="content-body">
                                                <h6 class="mb-0">Weight : {{ $item['tray_details']->weight }}</h6>
                                            </div>
                                        </div>
                                    </div><br>
                                    <div class="row">
                                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                                            <div class="content-body">
                                                <h6 class="mb-0">Barcode :
                                                    <a href="{{ route('user.order.tray-barcode', [$item['tray_details']->id, $orders->id]) }}" class="company-name" target="_blank">{{ $item['tray_details']->barcode }}</a>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                                            <div class="content-body">
                                                <h6 class="mb-0">No. of Intruments :
                                                    {{ count($item['items']) }}
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    @if(count($item['items']) > 0)
                                        <div class="col-md-6 col-sm-12 col-lg-6 col-xl-6">
                                            <a class="btn btn-sm btn-primary me-1 waves-effect waves-float waves-light collapsed more-info" data-bs-toggle="collapse" href="#collapseExample{{ $item['tray_details']->id }}" role="button" aria-expanded="false" aria-controls="collapseExample">More Info<i data-feather="chevrons-down" style="margin-left:5px"></i></a>
                                        </div><br>
                                    @endif
                                    <div class="row instrument-row">
                                        <div class="collapse" id="collapseExample{{ $item['tray_details']->id }}" style="">
                                            <table class="custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>Instrument</th>
                                                        <th>Weight</th>
                                                        <th>Barcode</th>
                                                        <th>Expiry</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($item['items'] as $instrument)
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="fw-bolder">{{  Str::limit($instrument->category_name, 20) }}</div>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <div class="d-flex flex-column">{{ $instrument->weight }}</div>
                                                                </div>
                                                            </td>
                                                            <td class="text-nowrap">
                                                                <div class="d-flex flex-column">{{ $instrument->barcode }}</div>
                                                            </td>
                                                            <td>
                                                                <div class="d-flex align-items-center">{{ DateHelper::getDateFromDateTime($instrument->expiry) }}</div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Additional Instruments</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row mt-2">
                                        <table id="dataTable1" class="invoice-list-table table">
                                            <thead>
                                            <tr>
                                                <th>Instrument</th>
                                                <th>Barcode</th>
                                                <th>Weight</th>
                                                <th>Returnable</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($instrumentDetails as $item)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex flex-row">
                                                            <div class="avatar me-75">
                                                                <img src="{{ InstrumentHelper::getTrayImageFromFile($item->image, FileDestinations::INSTRUMENT_IMAGES) }}" class="rounded" width="42" height="42" alt="img-placeholder">
                                                            </div>
                                                            <div class="my-auto">
                                                                <h6 class="mb-0">{{ ucfirst($item->category_name) }}</h6>
                                                                <small></small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $item->barcode }}</td>
                                                    <td>{{ $item->weight }}</td>
                                                    <td>
                                                        @if($item->returnable == InventoryConstants::CATEGORY_RETURNABLE_YES)
                                                            <span class="badge badge-light-success">Yes</span>
                                                        @else
                                                            <span class="badge badge-light-danger">No</span>
                                                        @endif
                                                    </td>
                                                </tr> 
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Checkout Place Order Left ends -->

                        <!-- Checkout Place Order Right starts -->
                        <div class="checkout-options">
                            @include('pages.user.order.issued-order.includes.sidebar')
                            <!-- Checkout Place Order Right ends -->
                        </div>
                    </div>
                    <!-- Checkout Place order Ends -->
                </div>
            </div>
        </div>

    </div>
@endsection


@push('scripts')
<script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/pages/app-ecommerce-checkout.js') }}"></script>
<script>
    var app = {
            initialize: function() {
                var datatable = $('#dataTable1').DataTable({
                    paging: false,
                    lengthChange: true,
                    searching: false,
                    ordering: false,
                    info: false,
                    autoWidth: false,
                });
            }
        }

    $('.more-info').click(function(){
        if($(this).text() == 'More Info') {
            $(this).html('Less Info<i data-feather="chevrons-up" style="margin-left:5px"></i>');
            feather.replace();
        }
        else {
            $(this).html('More Info<i data-feather="chevrons-down" style="margin-left:5px"></i>');
            feather.replace();
        }
    });
    app.initialize();
</script>
@endpush
