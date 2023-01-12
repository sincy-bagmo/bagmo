@extends('layouts.user-dashboard')


@push('styles')
<!-- Page css files -->
<link rel="stylesheet" href="{{ asset('app-assets/vendors/css/forms/wizard/bs-stepper.min.css') }}">
<link rel="stylesheet" href="{{ asset('app-assets/css/plugins/forms/form-wizard.css') }}">
@endpush

@section('content')

<div class="col-xl-12 col-md-12 col-12">
    <div class="card card-statistics">
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

<div class="col-xl-12 col-lg-12 col-md-12 order-0 order-md-1 mt-2">
    <form action="{{ route('user.order.issued-order.return', $orders->id) }}" method="POST">
        @csrf
        <section class="vertical-wizard">
            <div class="bs-stepper vertical vertical-wizard-example">
                <div class="bs-stepper-header">
                    @foreach($trayDetails as $key => $item)
                    <div class="step" data-target="#tray-details{{ $item['tray_details']->id }}" role="tab" id="account-details-vertical-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box"><i data-feather="inbox"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">{{ $item['tray_details']->tray_name }}</span>
                                <span class="bs-stepper-subtitle">{{ $item['tray_details']->barcode }}</span>
                            </span>
                        </button>
                    </div>
                    @endforeach
                    @if(!empty($instrumentDetails))
                    <div class="step" data-target="#instrument-details" role="tab" id="account-details-vertical-trigger">
                        <button type="button" class="step-trigger">
                            <span class="bs-stepper-box"><i data-feather="scissors"></i></span>
                            <span class="bs-stepper-label">
                                <span class="bs-stepper-title">Additional<br>Instruments</span>
                                <span class="bs-stepper-subtitle"></span>
                            </span>
                        </button>
                    </div>
                    @endif
                </div>
                <div class="bs-stepper-content">
                    @foreach($trayDetails as $key => $item)
                    <div id="tray-details{{ $item['tray_details']->id }}"class="content"role="tabpanel" aria-labelledby="account-details-vertical-trigger">
                        <div class="content-header">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <h5 class="mb-0">Tray Instruments</h5>
                                </div>
                                <div class="col-sm-12 col-md-6">
                                    <div class="row">
                                        <label class="col-md-6 form-label-lg mt-1 fw-bold ps-5 text-end">Weight:</label>
                                        <div class="col-sm-6 col-md-6">
                                            <input type="text" class="form-control mb-2 " placeholder="Tray Weight" name="tray-weight-{{ $item['tray_details']->id }}" value=" {{ $item['tray_details']->stockWeight }}"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Instrument</th>
                                            <th>Returnable</th>
                                            <th>Missing</th>
                                            <th>Damaged</th>
                                            <th>Damage Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($item['items'] as $instrument)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">{{ Str::limit($instrument->category_name, 20) }}</div>
                                                </td>
                                                <td>
                                                    @if($instrument->returnable == InventoryConstants::CATEGORY_RETURNABLE_YES)
                                                        <span class="badge badge-light-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-light-danger">No</span>
                                                    @endif
                                                </td>
                                                @if($instrument->returnable == InventoryConstants::CATEGORY_RETURNABLE_YES)
                                                <input type="hidden" name="order_item[{{$instrument->id}}][tray_id]" value="{{$instrument->tray_id}}">
                                                <td class="text-nowrap">
                                                <div class="form-check form-switch form-check-primary">
                                                        <input type="checkbox" class="form-check-input tray-instrument-missing" value="1"
                                                        name="order_item[{{$instrument->id}}][missing]"/>
                                                            <label class="form-check-label" for="missing">
                                                                <span class="switch-icon-right"></span>
                                                                <span class="switch-icon-left"></span>
                                                            </label>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                <div class="form-check form-switch form-check-primary">
                                                        <input type="checkbox" class="form-check-input tray-damaged-item" value="1"
                                                        name="order_item[{{$instrument->id}}][damaged]" />
                                                            <label class=" form-check-label" for="damaged">
                                                                <span class="switch-icon-right"></span>
                                                                <span class="switch-icon-left"></span>
                                                            </label>
                                                    </div>
                                                </td>
                                                <td class="text-nowrap">
                                                    <div class="col-12 mb-1 mb-md-0">
                                                        <input type="text" class="form-control form-control-sm tray-damaged-reason" name="order_item[{{$instrument->id}}][damaged_reason]" readonly />
                                                    </div>
                                                </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn @if ($key === array_key_first($trayDetails))btn-outline-secondary @else btn-primary @endif btn-prev" @if ($key === array_key_first($trayDetails)) disabled @endif>
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button type="button" class="btn btn-primary btn-next">
                                <span class="align-middle d-sm-inline-block d-none">Next</span>
                                <i data-feather="arrow-right" class="align-middle ms-sm-25 ms-0"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                    <div id="instrument-details" class="content"role="tabpanel" aria-labelledby="account-details-vertical-trigger">
                        <div class="content-header">
                            <h5 class="mb-0">Additional Instruments</h5>
                            <small class="text-muted">Please scan instruments</small>
                        </div>
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Instrument</th>
                                            <th>Returnable</th>
                                            <th>Missing</th>
                                            <th>Damaged</th>
                                            <th>Damage Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($instrumentDetails as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">{{ $item->category_name }}</div>
                                                    <small>{{ $item->barcode }}</small>
                                                </td>
                                                <td>
                                                    @if($item->returnable == InventoryConstants::CATEGORY_RETURNABLE_YES)
                                                        <span class="badge badge-light-success">Yes</span>
                                                    @else
                                                        <span class="badge badge-light-danger">No</span>
                                                    @endif
                                                </td>
                                                @if($item->returnable == InventoryConstants::CATEGORY_RETURNABLE_YES)
                                                    <td class="text-nowrap">
                                                    <div class="form-check form-switch form-check-primary">
                                                            <input type="checkbox" class="form-check-input tray-instrument-missing" value="1"
                                                                   name="order_item_instrument[{{ $item->instrument_item_id}} ][missing]"/>
                                                            <label class="form-check-label" for="missing">
                                                                <span class="switch-icon-right"></span>
                                                                <span class="switch-icon-left"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">
                                                    <div class="form-check form-switch form-check-primary">
                                                            <input type="checkbox" class="form-check-input tray-damaged-item" value="1"
                                                                   name="order_item_instrument[{{ $item->instrument_item_id }}][damaged]" />
                                                            <label class=" form-check-label" for="damaged">
                                                                <span class="switch-icon-right"></span>
                                                                <span class="switch-icon-left"></span>
                                                            </label>
                                                        </div>
                                                    </td>
                                                    <td class="text-nowrap">
                                                        <div class="col-12 mb-1 mb-md-0">
                                                        <input type="text" class="form-control form-control-sm tray-damaged-reason" type="text" name="order_item_instrument[{{ $item->instrument_item_id }}][damaged_reason]" readonly />
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary btn-prev">
                                <i data-feather="arrow-left" class="align-middle me-sm-25 me-0"></i>
                                <span class="align-middle d-sm-inline-block d-none">Previous</span>
                            </button>
                            <button type="submit" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#large">
                            <i data-feather='navigation' class="align-middle me-sm-25 me-0"></i>
                                Return To Washing
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

@endsection

@push('scripts')
<script src="{{ asset('app-assets/vendors/js/forms/wizard/bs-stepper.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-wizard.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/components/components-popovers.js')}}"></script>

<script>
    var app = {

        initialize: function () {
            feather.replace();

            $('.tray-instrument-missing').each(function(){
                if($(this).is(':checked')) {
                    $(this).css('pointer-events', 'none');
                    $(this).closest('tr').find('td .tray-damaged-item').css('pointer-events', 'none');
                }
            });
            $('.tray-damaged-item').each(function(){
                if($(this).is(':checked')) {
                    $(this).css('pointer-events', 'none');
                    $(this).closest('tr').find('td .tray-instrument-missing').css('pointer-events', 'none');
                }
            });

            $('.tray-instrument-missing').on('click', function(){
                if($(this).is(':checked')) {
                    $(this).closest('tr').find('td .tray-damaged-item').css('pointer-events', 'none');
                    $(this).closest('tr').find('td .tray-damaged-reason').val('');
                }
                else {
                    $(this).closest('tr').find('td .tray-damaged-item').css('pointer-events', 'auto');
                }
            });

            $('.tray-damaged-item').on('click', function(){
                if($(this).is(':checked')) {
                    $(this).closest('tr').find('td .tray-instrument-missing').css('pointer-events', 'none');
                    $(this).closest('tr').find('td .tray-damaged-reason').attr('readonly', false);
                    $(this).closest('tr').find('td .tray-damaged-reason').focus();
                }
                if(!$(this).is(':checked')) {
                    $(this).closest('tr').find('td .tray-instrument-missing').css('pointer-events', 'auto');
                    $(this).closest('tr').find('td .tray-damaged-reason').val('');
                    $(this).closest('tr').find('td .tray-damaged-reason').attr('readonly', true);
                }
            });
        },
    };

    app.initialize();
</script>

@endpush
