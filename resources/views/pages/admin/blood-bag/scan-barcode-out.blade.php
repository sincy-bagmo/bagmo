@extends('layouts.admin-dashboard')

@section('content')


    <section id="basic-horizontal-layouts">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Scan Barcode To Out Blood Bag</h4>
            </div>
            <div class="row">
                <div class="col-md-4 order-md-0 order-1">
                    <div class="card-body">
                        <form class="form form-horizontal" method="POST" action="{{ route('admin.blood-bag.bag-scan-out') }}">
                            @csrf
                            <div class="mb-2">
                                <label for="blood_bag_id" class="form-label">Scan Blood Bag Barcode</label><span class="text-danger">*</span>
                                <div class="position-relative">
                                    <input type="text" class="form-control @error('blood_bag_id')is-invalid @enderror" id="blood_bag_id" name="blood_bag_id" value="{{ old('blood_bag_id') }}" placeholder="Scan Blood Bag Barcode" @error('blood_bag_id')aria-describedby="blood_bag_id-error" aria-invalid="true" @enderror required>
                                    @error('blood_bag_id')
                                    <span id="blood_bag_id-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div id="append-div"></div>
                            <button type="submit" class="btn btn-primary w-100 waves-effect waves-float waves-light">Blood Bag Out</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-4 order-md-1 order-0">
                    <div class="card-body">
                        <h4 class="fw-bolder">Blood Bag Details:</h4>
                        <p class="fw-bolder">Blood Bag Name: <span class="blood-bag-name">-----</span></p>
                        <p class="fw-bolder">Refrigerator<span class="refrigerator">-----</span></p>
                        <p class="fw-bolder">Storage Rack: <span class="rack">-----</span></p>
                        <p class="fw-bolder">Status : <span class="blood-bag-status">-----</span></p>
                        <p class="fw-bolder">Scan In At:<span class="scan-in-time">-----</span></p>
                    </div>
                </div>
                <div class="col-md-4 order-md-1 order-0">
                    <div class="text-center">
                        <img class="img-fluid text-center" src="{{ asset('app-assets/images/illustration/pricing-Illustration.svg') }}" alt="illustration" width="310">
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script>
        var app = {

            initialize: function() {
                $('#blood_bag_id').focus();
                $(document).on("keyup", "#blood_bag_id", function() {
                    var bloodBag = $(this).val();
                    var scanBarcodeUrl = "{{ route('admin.blood-bag.get-details-on-scan-barcode') }}";
                    $.ajax({
                        url: scanBarcodeUrl,
                        method: 'GET',
                        data: {
                            blood_bag_id: bloodBag,
                        },
                        success: function(data) {
                            if (data.status == 1) {
                                $(".blood-bag-name").html(data.data.blood_bag_name);
                                $(".refrigerator").html(data.data.refrigerator_name);
                                $(".rack").html(data.data.rack_name);
                                $(".scan-in-time").html(data.data.scan_in);
                                $(".blood-bag-status").html(data.data.status);
                                $('#storage_id').focus();
                            } else {
                                $(".blood-bag-name").html("-----");
                                $(".refrigerator").html("-----");
                                $(".rack").html("-----");
                                $(".scan-in-time").html("-----");
                                $(".blood-bag-status").html("-----");
                                toastr.error("Blood Bag Not Found");
                            }
                        }
                    });
                }).change();

                $(window).keydown(function(event) {
                    if (event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });

            },

        };

        app.initialize();
    </script>
@endpush