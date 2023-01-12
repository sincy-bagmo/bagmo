@extends('layouts.admin-dashboard')

@push('styles')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-ecommerce-details.css') }}">
@endpush

@section('content')
    <section class="app-ecommerce-details">
        <div class="card">
            <!-- Instrument Details starts -->
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
                        <div class="row">

                        </div>
                        <p class="card-text">Blood Group :
                            <span class="badge badge-light-danger">
                                 {{ $bloodBag->blood_group }}
				      		</span>
                        </p>
                        <hr>
                        <div class="row">
                            <ul class="product-features list-unstyled col-md-6">
                                <li>
                                    <i data-feather='activity'></i>
                                    <span>Type : {{ BloodGroupConstants::TYPE[$bloodBag->type] }}</span>
                                </li>
                                <li>
                                    <i data-feather="rotate-cw"></i>
                                    <span> Status :{{ BloodGroupConstants::BLOOD_BAG_STATUS [ $bloodBag->status] }}</span>
                                </li>
                                <li>
                                    <i data-feather='calendar'></i>
                                    <span>Expiry : {{ DateHelper::format($bloodBag->expiry_date, DateHelper::DATE_PICKER_FORMAT) }}</span>
                                </li>
                                <li>
                                    <i data-feather='calendar'></i>
                                    <span>Created On :
										{{ DateHelper::getCurrentHumanReadableTimeFromDate($bloodBag->created_at) }}
									</span>
                                </li>
                            </ul>
                            <ul class="product-features list-unstyled col-md-6">
                                <li>
                                    <i data-feather='award'></i>
                                    <span>Refrigerator Name : {{ $bloodBagDetails->refrigerator_name }}</span>
                                </li>
                                <li>
                                    <i data-feather='hard-drive'></i>
                                    <span> Rack : {{ $bloodBagDetails->rack_name }}</span>
                                </li>
                                <li>
                                    <i data-feather='framer'></i>
                                    <span> Last In Time : {{ DateHelper::getCurrentHumanReadableTimeFromDate($bloodBagLog->scan_in) }}</span>
                                </li>
                            </ul>
                            <hr>
                            <p class="card-text">
                                {!! BarCodeHelper::generateBarcodePng($bloodBag->blood_bag_name) !!}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
            <!-- Instrument Details ends -->
        </div>
    </section>
@endsection