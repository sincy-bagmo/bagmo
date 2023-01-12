@foreach($traysLinkedData as $category)
<li class="timeline-item" id="operation-id-{{ $category['TrayCategory']->tray_category_id }}">
    <span class="timeline-point timeline-point-indicator"></span>
    <div class="timeline-event">
        <div class="d-flex justify-content-between flex-sm-row flex-column mb-sm-0 mb-1">
            <h6>Tray:&nbsp;&nbsp;{{ $category['TrayCategory']->category_name }}</h6>
        </div>
        <div class="card card-company-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                <table class="table">
                        <thead>
                            <tr>
                                <th>Instrument</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($category['LinkedData'] as $instrument)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="fw-bolder">{{ Str::limit($instrument->category_name, 20) }}</div>
                                    </div>
                                </td>
                                <td class="text-nowrap">
                                    <div class="d-flex flex-column">{{ $instrument->qty }}</div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</li>
@endforeach