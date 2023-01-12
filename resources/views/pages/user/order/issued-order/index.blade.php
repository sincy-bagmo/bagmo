@extends('layouts.user-dashboard')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <p>Orders approved and allocated list</p>
                    </div>
                    <div id="buttons">
                        <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#filter-form" aria-expanded="false" aria-controls="filter-form">Filter</button>
                        <a class="btn btn-primary me-1" href="{{ route('user.order.pending-order.create') }}">
                            <span class="fw-bold d-none d-md-block">Add Request</span>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="collapse mb-2" id="filter-form">
                        <h5 class="card-title">Filter By</h5>
                        <form id="form-filter" class="dt_adv_search" method="GET">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-3">
                                    <label class="form-label">Barcode:</label>
                                    <input type="text"
                                           value="{{ Request::get('barcode') != null ? Request::get('barcode') : '' }}"
                                           name="barcode" id="barcode" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Barcode" data-column-index="0" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Surgery:</label>
                                    <div class="col-md-12 mb-2">
                                        <select name="operation" id="operation" class="form-select" id="">
                                            <option value="">Select Surgery</option>
                                            @foreach ($operations as $key => $item)
                                                <option value="{{ $key }}" {{ isset($_GET['operation']) && $_GET['operation'] != '' && $_GET['operation'] == $key?'selected':'' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Requested Date:</label>
                                    <div class="mb-0">
                                        <div class="flatpickr input-group mb-2">
                                            <input type="text" class="form-control dt-date flatpickr-range dt-input" placeholder="Select Date" name="requested_date"  id="requested_date"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Surgery Date:</label>
                                    <div class="mb-0">
                                        <div class="flatpickr input-group mb-2">
                                            <input type="text" class="form-control dt-date flatpickr-range dt-input" placeholder="Select Date" name="surgery_date" id="surgery_date"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="resetForm" class="btn btn-sm btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i>Submit</button>
                        </form>
                    </div>
                    <div class="table-responsive row">
                        <table id="dataTable1" class="invoice-list-table table">
                            <thead>
                                <tr>
                                    <th class="text-center">Surgery Name</th>
                                    <th class="text-center">Doctor Name</th>
                                    <th class="text-center">Barcode</th>
                                    <th class="text-center">Request Date</th>
                                    <th class="text-center">Surgery Date</th>
                                    <th class="text-center">Issued On</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $item)
                                <tr>
                                    <td class="text-center">{{ Str::limit($item->operation_name, 20) }}</td>
                                    <td class="text-center">{{ Str::limit($item->doctor_name, 20) }}</td>
                                    <td class="text-center">{{ Str::limit($item->barcode, 20) }}</td>
                                    <td class="text-center">{{ Str::limit($item->booking_date, 20) }}</td>
                                    <td class="text-center">{{ DateHelper::toDateTimePicker($item->created_at) }}</td>
                                    <td class="text-center">{{ DateHelper::getCurrentHumanReadableTimeFromDate($item->order_send_to_ot_at) }}</td>
                                    <td class="text-center">{{ OrderConstants::STATUS[$item->status] }}</td>
                                    <td class="text-center">
                                        <a href="{{route('user.order.issued-order.details', $item->id)}}"  class="btn btn-primary btn-sm " title="Return Order"><i class="fas fa-arrow-circle-left"></i></a>
                                        <a href="{{ route('user.order.issued-order.show', $item->id) }}" class="btn btn-primary btn-sm" title="View Details"><i data-feather='eye'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Return Form -->
    <form action="" method="POST" id="return-form">
        @csrf
        <!-- Modal Content-->
        <div class="scrolling-inside-modal">
            <!-- Button trigger modal -->
            <button type="button" id="modal-button" class="btn btn-outline-primary waves-effect" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable" style="display: none;">
            </button>
            <!-- Modal -->
            <div class="modal fade show" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalScrollableTitle" aria-modal="true" role="dialog">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('scripts')

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
                $('#resetForm').on('click', app.resetFilterForm);
                $('.flatpickr-range').flatpickr({
                    dateFormat: 'Y-m-d',
                });

                $('.return-order').on('click', function(event){
                    event.preventDefault();
                    var url = $(this).data('href');
                    var id = $(this).data('id');
                    app.orderDetails(url, id);
                    var formUrl = "{{ route('user.order.issued-order.return') }}";
                    formUrl = formUrl + '/' + id;
                    $('#return-form').attr('action', formUrl);
                });

                $('#return-form').submit(function(){
                    $('#modal-submit').css('pointer-events', 'none');
                    $('#modal-submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="ms-25 align-middle">Processing...</span>');
                });
            },

            resetFilterForm: function() {
                $('#barcode').val('');
                $('#operation').val('');
                $('#surgery_date').val('');
                $('#requested_date').val('');
            },

            orderDetails: function(url, id) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    success : function(data) {
                        if(data.status) {
                            $('.modal-content').html(data.html);
                            $('#modal-button').trigger('click');
                        }
                    }
                });
            },
        };
        app.initialize();
    </script>
@endpush

