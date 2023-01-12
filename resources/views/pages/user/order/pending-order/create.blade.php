@extends('layouts.user-dashboard')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css') }}">
@endpush


@section('content')
    <section class="content">
        <div class="container-fluid">
            <form method="POST" action="{{ route('user.order.pending-order.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-7 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Create an order request</h4>
                            </div>
                            <div class="card-body">
                                <div class="mb-1 row">
                                    <div class="col-md-12  col-12">
                                        <div class="mb-1">
                                            <label  class="form-label">Procedure <span class="text-danger">*</span></label>
                                            <select name="operation_id" id="operation_id" class="form-select" >
                                                <option value="">Select Procedure</option>
                                                @foreach ($operations as $key => $item)
                                                    <option value="{{ $key }}" {{ (old('operation_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                            @error('operation_id')
                                            <span id="operation_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-md-12  col-12">
                                        <div class="mb-1">
                                            <label  class="form-label">Doctor Name<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('doctor_name')is-invalid @enderror" id="doctor_name" name="doctor_name" value="{{ old('doctor_name') }}"  placeholder="Enter Doctor Name"
                                                   @error('doctor_name')aria-describedby="doctor_name-error" aria-invalid="true" @enderror >
                                            @error('doctor_name')
                                            <span id="doctor_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-md-12  col-12">
                                        <div class="mb-1">
                                            <label  class="form-label">Required Date <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('booking_date')is-invalid @enderror" id="booking_date" name="booking_date" placeholder="Select required date" value="{{ old('booking_date') }}"
                                                   @error('booking_date')aria-describedby="booking_date-error" aria-invalid="true" @enderror autocomplete="off" required>
                                            @error('booking_date')
                                            <span id="booking_date-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12  col-12">
                                    <div class="mb-1">
                                        <label  class="form-label">Description</label>
                                        <input type="text" class="form-control @error('description')is-invalid @enderror" id="description" name="description" value="{{ old('description') }}"  placeholder="Enter description"
                                               @error('description')aria-describedby="id_card_number-error" aria-invalid="true" @enderror>
                                        @error('description')
                                        <span id="description-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-md-12  col-12">
                                        <div class="mb-1">
                                            <label  class="form-label">Add Additional Trays From Category</label>
                                            <select name="tray_category_id[]" id="tray_category_id" class="form-select select2" multiple="multiple" >
                                                @foreach ($trayCategory as $key => $item)
                                                    <option value="{{ $key }}" {{ (old('tray_category_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                            @error('tray_category_id')
                                            <span id="tray_category_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-1 row">
                                    <div class="col-md-12  col-12">
                                        <div class="mb-1">
                                            <label  class="form-label">Add Additional Instruments From Category</label>
                                            <select name="instrument_category_id[]" id="instrument_category_id" class="form-select select2" multiple="multiple">
                                                @foreach ($instruments as $key => $item)
                                                    <option value="{{ $key }}" {{ (old('instrument_category_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
                                                @endforeach
                                            </select>
                                            @error('instrument_category_id')
                                            <span id="instrument_category_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <i data-feather='shopping-cart'></i>&nbsp;
                                            <h4 class="card-title">Cart Additional Instruments Items</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Instrument</th>
                                                        <th>Code</th>
                                                        <th>Qty</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="additional-instruments"></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12  col-12">
                                    <div class="mb-1">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 col-12">
                        <div class="card card-user-timeline">
                            <div class="card-header">
                                <div class="d-flex align-items-center">
                                    <i data-feather='shopping-cart'></i>&nbsp;
                                    <h4 class="card-title">Cart Tray Items</h4>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="timeline ms-50 tray-items"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
    <script>
        var app = {
            initialize: function () {
                $('#booking_date').flatpickr({
                    dateFormat: 'Y-m-d H:i',
                    minDate: 'today',
                    enableTime: true,
                });

                $('#operation_id').on('change', function() {
                    var url = '{{ route('user.home') }}';
                    url =  url + '/order/surgery-details/' + this.value;
                    app.addSurgeryTraysToCart(url);
                });

                $('#tray_category_id').select2({
                    allowClear: true,
                    placeholder: 'Select Additional Trays',
                    minimumResultsForSearch: Infinity
                }).on("select2:select", function(e) {
                    var trayId = e.params.data.id;
                    var url = '{{ route('user.home') }}';
                    url =  url + '/order/tray-details/' + trayId;
                    app.addAdditionalTraysToCart(url)
                }).on("select2:unselect", function (e) {
                    $("#tray-id-" + e.params.data.id).remove();
                    $(".no-tray-items").remove();
                });

                $('#instrument_category_id').select2({
                    allowClear: true,
                    placeholder: 'Select Additional Instruments',
                    minimumResultsForSearch: Infinity
                }).on("select2:select", function(e) {
                    var trayId = e.params.data.id;
                    var url = '{{ route('user.home') }}';
                    url =  url + '/order/instrument-details/' + trayId;
                    app.addAdditionalInstrumentsToCart(url)
                }).on("select2:unselect", function (e) {
                    $("#tray-id-" + e.params.data.id).remove();
                    $('#remove-instrument-' + e.params.data.id).remove();
                });


            },

            addSurgeryTraysToCart:function(url) {
                $.ajax({
                    url: url,
                    method : 'GET',
                    success: function(response) {
                        if (response.status) {
                            app.resetCartItems();
                            $('.tray-items').append(response.tray_item);
                        }
                    }
                });
            },

            addAdditionalTraysToCart: function(url) {
                $.ajax({
                    url: url,
                    method : 'GET',
                    success: function(response) {
                        if (response.status) {
                            $('.tray-items').append(response.tray_item);
                        }
                    }
                });
            },

            addAdditionalInstrumentsToCart: function(url) {
                $.ajax({
                    url: url,
                    method : 'GET',
                    success: function(response) {
                        if (response.status) {
                            $('.additional-instruments').append(response.instrument_item);
                            $(".touchspin-cart").TouchSpin({
                                min: 0,
                                max: 100,
                                step: 1,
                                decimals: 0,
                            }).on('change', function(){
                                //maybe optional
                            });
                        }
                    }
                });
            },

            resetCartItems: function() {
                $("#tray_category_id").val('').trigger("change");
                $("#instrument_category_id").val('').trigger("change");
                $('.additional-instruments').html('');
                $('.tray-items').html('');
            },
        };
        app.initialize();
    </script>
@endpush
