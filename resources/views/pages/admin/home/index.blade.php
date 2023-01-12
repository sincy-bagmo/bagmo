@extends('layouts.admin-dashboard')
@push('styles')
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/calendars/fullcalendar.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('app-assets/css/pages/app-calendar.css')}}">

    <style>
        .avatar.bg-light-info {
            color: #00cfe8 !important;
            height: 48px !important;
        }

        .avatar.bg-light-success {
            color: #28c76f !important;
            height: 48px !important;
        }
        .avatar.bg-light-primary {
            color: #28c76f !important;
            height: 48px !important;
        }

    </style>
@endpush

@section('content')
    <!-- Dashboard Ecommerce Starts -->
    <section id="dashboard-ecommerce">

        <!-- Statistics -->
        <div class="row match-height">
            <!-- Medal Card -->
            <div class="col-xl-4 col-md-6 col-12">
                <div class="card card-congratulation-medal">
                    <div class="card-body">
                        <h5>Welcome 🎉 {{ ProfileHelper::getFullName(AuthConstants::GUARD_ADMIN) }}!</h5>
                        {!! PositiveQuotesHelper::getQuoteForTheDay() !!}
                        <img src="{{ asset('app-assets/images/illustration/badge.svg') }}" class="congratulation-medal" alt="Medal Pic" />
                    </div>
                </div>
            </div>
            <!--/ Medal Card -->

            <!-- Statistics Card -->
            <div class="col-xl-8 col-md-6 col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Scan Barcode
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.blood-bag.check-bag-details') }}" method="get" id="form-accept" >
                            <div class="mb-1 row">
                                <label class="col-sm-3 col-form-label">Blood Bag Barcode </label>
                                <div class="col-sm-7">
                                    <input type="text" class="form-control blood-bag-id" name="blood_bag_id" placeholder="Scan Your Barcode" class="form-control " id="blood-bag-id" autofocus />
                                </div>
                                <div class="d-inline-block col-sm-2">
                                    <button type="submit" class="btn btn-primary" >Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--/ Statistics Card -->

        </div>
        <!-- Statistics -->


        <div class="row match-height">
            <!-- Support Tracker Card -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">PRC</h4>
                    </div>
                    <div class="card-body">
                        @include('pages.admin.home.includes.prc-graph')
                    </div>
                </div>
            </div>
            <!--/ Support Tracker Card -->

            <!-- Average Sessions Card -->
            <div class="col-lg-6 col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between pb-0">
                        <h4 class="card-title">FFP</h4>
                    </div>
                    <div class="card-body">
                        @include('pages.admin.home.includes.ffp-graph')
                    </div>
                </div>
            </div>
            <!--/ Average Sessions Card -->
        </div>


    </section>
    <!-- Dashboard Ecommerce ends -->
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


            },
        };
        app.initialize();

    </script>



@endpush
