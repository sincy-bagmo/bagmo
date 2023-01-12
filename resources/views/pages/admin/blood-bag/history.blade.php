@extends('layouts.admin-dashboard')

@push('styles')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-ecommerce-details.css') }}">
@endpush

@section('content')
    <section class="app-ecommerce-details">
        <div class="card">
            <!-- Instrument History starts -->
            <div class="card-body">
                <div class="row my-2">
                    <div class="col-12 col-md-4 d-flex mb-2 mb-md-0">
                        <div class="">
                            <img
                                    src="{{ BloodBagHelper::getBloodBagImageFromFile($bloodBag->image, FileDestinations::BLOOD_BAG_IMAGES) }}"
                                    class="img-fluid product-img"
                                    alt="product image"
                            />
                        </div>
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="card-header p-0 pb-2">
                            @include('pages.admin.blood-bag.includes.main-nav')
                        </div>
                        <h3 class="item-price">{{$bloodBag->blood_bag_name}}</h3>
                        <p class="card-text">Blood Group :
                            <span class="badge badge-light-danger">
                                 {{ $bloodBag->blood_group }}
				      		</span>
                        </p>
                        <hr>
                        <div class="row mt-2">
                            <div class="table-responsive">
                                <table id="dataTable1" class="invoice-list-table table">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Scan In</th>
                                        <th class="text-center">scan Out</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bloodBagLog as $item)
                                        <tr>
                                            <td class="text-center">{{  BloodGroupConstants::BLOOD_BAG_STATUS [ $item->status] }}</td>
                                            <td class="text-center">{{DateHelper::getCurrentHumanReadableTimeFromDate($item->scan_in) }}</td>
                                            <td class="text-center">{{ DateHelper::getCurrentHumanReadableTimeFromDate($item->scan_out) }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Instrument History ends -->
        </div>
    </section>
@endsection

@push('scripts')

    <script>
        var app = {

            initialize: function () {
                var datatable = $('#dataTable1').DataTable({
                    paging: true,
                    lengthChange: false,
                    searching: true,
                    ordering: false,
                    info: false,
                    autoWidth: false,
                });
            },
        };
        app.initialize();
    </script>
@endpush