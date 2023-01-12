@extends('layouts.admin-dashboard')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Register Blood Bag</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.blood-bag.store') }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Blood Bag Id<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('blood_bag_name')is-invalid @enderror" id="blood_bag_name" name="blood_bag_name" value="{{ old('blood_bag_name') }}"  placeholder="Enter Blood Bag Name"
                                           @error('blood_bag_name')aria-describedby="refrigerator_name-error" aria-invalid="true" @enderror >
                                    <div id="alert-blood-bag"></div>
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Blood Group<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('blood_group')is-invalid @enderror blood_group" id="blood_group" name="blood_group" placeholder="Enter Blood Group" value="{{ old('blood_group') }}"
                                           @error('blood_group')aria-describedby="blood_group-error" aria-invalid="true" @enderror >
                                    <div id="alert-blood-group"></div>
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Product Id<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('product_id')is-invalid @enderror" id="product_id" name="product_id" placeholder="Enter Product Id" value="{{ old('product_id') }}"
                                           @error('product_id')aria-describedby="product_id-error" aria-invalid="true" @enderror >
                                    <div id="alert-product"></div>
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Expiry Date<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control  flatpickr-human-friendly @error('expiry_date')is-invalid @enderror" id="expiry_date" name="expiry_date" placeholder="Enter Expiry Date" value="{{ old('expiry_date') }}"
                                           @error('expiry_date')aria-describedby="expiry_date-error" aria-invalid="true" @enderror >
                                    <div id="alert-expiry-date"></div>
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Type<span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-select">
                                        @foreach (BloodGroupConstants::TYPE as $key => $item)
                                            <option value="{{ $key }}" {{ (old('type') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <span id="type-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Volume<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('volume')is-invalid @enderror rack-volume" id="volume" name="volume" placeholder="Enter Rack Name" value="{{ old('volume') }}"
                                           @error('volume')aria-describedby="volume-error" aria-invalid="true" @enderror >
                                    @error('volume')
                                    <span id="volume-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Refrigerator<span class="text-danger">*</span></label>
                                    <select name="refrigerator_id" id="refrigerator_id" class="form-select">
                                        <option value="">Select Refrigerator</option>
                                        @foreach ($refrigerator as $key => $item)
                                            <option value="{{ $key }}" {{ (old('refrigerator_id') == $key  ) ? 'selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                    @error('refrigerator_id')
                                    <span id="refrigerator_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12" id="rack-suggestions"></div>
                            <div class="col-md-12  col-12">
                                <div class="mb-1">
                                    <button type="submit" id="submit-btn" class="btn btn-primary me-1">Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>

        var app = {

            initialize: function() {

                $('#expiry_date').flatpickr({
                    dateFormat: 'Y-m-d',
                    minDate: 'today',
                    enableTime: true,
                });
                $('#refrigerator_id').on('change', function() {
                    var url = '{{ route('admin.home') }}';
                    var refrigerator = $(this).val();
                    url =  url + '/blood-bag/get-refrigerator-rack/' + this.value;
                    console.log(url);

                    app.getRefrigeratorRack(url, refrigerator);
                });

            },
            getRefrigeratorRack: function(url, refrigerator) {

                $.ajax({
                    url: url,
                    method : 'GET',
                    data: { "refrigerator_id": refrigerator },
                    success: function(response) {
                        console.log(response);
                        if (response.status) {
                            $("#rack-suggestions").html('');
                            $('#rack-suggestions').append(response.rack);
                        }

                    }
                });
            },
        };

        app.initialize();
    </script>
@endpush
