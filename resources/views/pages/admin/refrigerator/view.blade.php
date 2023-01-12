@extends('layouts.admin-dashboard')

@push('styles')
    <!-- Page css files -->
    <link rel="stylesheet" href="{{ asset('app-assets/css/pages/app-ecommerce-details.css') }}">
@endpush

@section('content')
    <section class="app-ecommerce-details">
        <div class="card">
            <!-- Instrument History starts -->
            <div class="card-header">
                <h3 class="item-price">{{$refrigerator->refrigerator_name}}</h3>
                <div id="buttons">
                    <a class="btn btn-primary me-1" href="{{ route('admin.refrigerator.rack-barcode', $refrigerator->id) }}">
                        <span class="fw-bold d-none d-md-block">Print Barcode</span>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row my-2">
                    <hr>
                    <div class="row mt-2">
                        <div class="table-responsive">
                            <table id="dataTable1" class="invoice-list-table table">
                                <thead>
                                <tr>
                                    <th class="text-center">Rack</th>
                                    <th class="text-center">Barcode</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($rack as $item)
                                    <tr>
                                        <td class="text-center">{{ Str::limit($item->rack_name, 60) }}</td>
                                        <td class="text-center">{{$item->rack_barcode }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
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