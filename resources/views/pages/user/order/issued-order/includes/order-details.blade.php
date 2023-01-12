<div class="modal-header">
    <h5 class="modal-title" id="exampleModalScrollableTitle">Return Order</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-header">
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-12">
          <div class="card" style="margin-bottom:10px;">
            <div class="card-header" style="padding: 10px 1.5rem;">
                <div>
                    <h6 class="fw-bolder mb-0">Surgery</h6>
                    <p class="card-text">{{ ucfirst($surgeryDetails->operation_name) }}</p>
                </div>
                <div class="avatar bg-light-primary rounded">
                    <div class="avatar-content">
                        <i data-feather="activity"></i>
                    </div>
                </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="card" style="margin-bottom:10px;">
                <div class="card-header" style="padding: 10px 1.5rem;">
                    <div>
                        <h6 class="fw-bolder mb-0">Order</h6>
                        <p class="card-text">{{ $orders->barcode }}</p>
                    </div>
                    <div class="avatar bg-light-success rounded">
                        <div class="avatar-content">
                            <i data-feather="shopping-cart"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="card" style="margin-bottom:10px;">
                <div class="card-header" style="padding: 10px 1.5rem;">
                    <div>
                        <h6 class="fw-bolder mb-0">Booking Date</h6>
                        <p class="card-text">{{ DateHelper::format($orders->booking_date, 'd-m-Y') }}</p>
                    </div>
                    <div class="avatar bg-light-danger rounded">
                        <div class="avatar-content">
                            <i data-feather="calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-12">
            <div class="card" style="margin-bottom:10px;">
                <div class="card-header" style="padding: 10px 1.5rem;">
                    <div>
                        <h6 class="fw-bolder mb-0">Requested On</h6>
                        <p class="card-text">{{ DateHelper::format($orders->created_on, 'd-m-Y') }}</p>
                    </div>
                    <div class="avatar bg-light-warning rounded">
                        <div class="avatar-content">
                            <i data-feather="pen-tool"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal-body">
    <section id="accordion">
        <div class="row">
            <div class="col-sm-12">
                <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">
                    <div class="accordion" id="accordionExample" data-toggle-hover="true">
                    @foreach($trayDetails as $item)
                        <div class="accordion-item mb-1 border border-bottom-2">
                            <h2 class="accordion-header" id="headingOne{{$item['tray_details']->id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOne{{$item['tray_details']->id}}" aria-expanded="false" aria-controls="accordionOne{{$item['tray_details']->id}}">
                                    {{ ucfirst($item['tray_details']->tray_name) }}
                                </button>
                            </h2>
                            <div id="accordionOne{{$item['tray_details']->id}}" class="accordion-collapse collapse" aria-labelledby="headingOne{{$item['tray_details']->id}}" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <th>Instrument</th>
                                                <th>Returnable</th>
                                                <th>Missing</th>
                                                <th>Damaged</th>
                                                <th>Damage Reason</th>
                                            </tr>
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
                                        </table>
                                        <hr class="invoice-spacing" />
                                        <table>
                                        <tr>
                                            <th class="col-4">Weight</th>
                                                <td colspan="2">
                                                    <div class="col-12 mb-4 mb-md-0">
                                                        <input type="text" class="form-control tray-weight" name="weight-{{ $item['tray_details']->id }}" placeholder="Tray Weight" data-barcode="" value=" {{ $item['tray_details']->stockWeight }}">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($instrumentDetails as $item)
                        <div class="accordion-item mb-1 border border-bottom-2">
                            <h2 class="accordion-header" id="headingOne-instrument{{$item->instrument_item_id}}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#accordionOne-instrument{{ $item->instrument_item_id }}" aria-expanded="false" aria-controls="accordionOne-instrument{{ $item->instrument_item_id }}">
                                    {{ ucfirst($item->category_name) }}
                                </button>
                            </h2>
                            <div id="accordionOne-instrument{{ $item->instrument_item_id }}" class="accordion-collapse collapse" aria-labelledby="headingOne-instrument{{ $item->instrument_item_id }}" data-bs-parent="#accordionExample" style="">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-borderless table-sm">
                                            <tr>
                                                <th>Instrument</th>
                                                <th>Returnable</th>
                                                <th>Missing</th>
                                                <th>Damaged</th>
                                                <th>Damage Reason</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">{{ $item->barcode }}</div>
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
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="modal-footer">
    <button type="submit" id="modal-submit" class="btn btn-primary waves-effect waves-float waves-light">Return</button>
</div>

<script>
    var modal = {

        initialize: function () {
            feather.replace();

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
                else {
                    $(this).closest('tr').find('td .tray-instrument-missing').css('pointer-events', 'auto');
                    $(this).closest('tr').find('td .tray-damaged-reason').val('');
                    $(this).closest('tr').find('td .tray-damaged-reason').attr('readonly', true);
                }
            });
        },
    };

    modal.initialize();
</script>
