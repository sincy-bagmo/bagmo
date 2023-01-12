@extends('layouts.admin-dashboard')

@push('styles')

@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <p>List Refrigerator</p>
                    </div>
                    <div id="buttons">
                        <button class="btn btn-primary me-1" type="button" data-bs-toggle="collapse" data-bs-target="#filter-form" aria-expanded="false" aria-controls="filter-form">Filter</button>
                        <a class="btn btn-primary me-1" href="{{ route('admin.refrigerator.create') }}">
                            <span class="fw-bold d-none d-md-block">Add Refrigerator</span>
                        </a>
                    </div>
                </div>
                <div class="card-body mt-2">
                    <div class="collapse" id="filter-form">
                        <h5 class="card-title">Filter By</h5>
                        <form id="form-filter" class="dt_adv_search" method="GET">
                            <div class="row g-1 mb-md-1">
                                <div class="col-md-3">
                                    <label class="form-label">Refrigerator Name:</label>
                                    <input type="text"
                                           value="{{ Request::get('refrigerator_name') != null ? Request::get('refrigerator_name') : '' }}"
                                           name="refrigerator_name" id="refrigerator_name" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Refrigerator Name" data-column-index="0" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Company:</label>
                                    <input type="text"
                                           value="{{ Request::get('company') != null ? Request::get('company') : '' }}"
                                           name="company" id="company" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Company Name" data-column-index="0" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Type:</label>
                                    <input type="text"
                                           value="{{ Request::get('type') != null ? Request::get('type') : '' }}"
                                           name="type" id="type" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Type Name" data-column-index="0" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Reference Number:</label>
                                    <input type="text"
                                           value="{{ Request::get('reference_number') != null ? Request::get('reference_number') : '' }}"
                                           name="reference_number" id="reference_number" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Reference Number" data-column-index="0" />
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Indication Name:</label>
                                    <input type="text"
                                           value="{{ Request::get('indication_name') != null ? Request::get('indication_name') : '' }}"
                                           name="indication_name" id="indication_name" class="form-control dt-input dt-first_name" data-column="1"
                                           placeholder="Indication Name" data-column-index="0" />
                                </div>
                            </div>
                            <br />
                            <button type="button" id="resetForm" class="btn btn-sm btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-filter"></i>Submit</button>
                        </form>
                    </div>
                    <div class="row mt-2">
                        <table id="dataTable1" class="invoice-list-table table">
                            <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Barcode</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Reference No</th>
                                <th class="text-center">Indication Name</th>
                                <th class="text-center">Remarks</th>
                                <th class="text-center">Registered Date</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($refrigerator as $item)
                                <tr>
                                    <td class="text-center">{{ Str::limit($item->refrigerator_name, 50) }}</td>
                                    <td class="text-center">{{ Str::limit($item->barcode, 50) }}</td>
                                    <td class="text-center">{{ Str::limit($item->company, 20) }}</td>
                                    <td class="text-center">{{ Str::limit($item->type, 50) }}</td>
                                    <td class="text-center">{{ Str::limit($item->reference_number, 50) }}</td>
                                    <td class="text-center">{{ Str::limit($item->indication_name, 50) }}</td>
                                    <td class="text-center">{{ Str::limit($item->remarks, 20) }}</td>
                                    <td class="text-center">{{ DateHelper::getCurrentHumanReadableTimeFromDate($item->created_at) }}</td>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{route('admin.refrigerator.edit', $item->id)}}" class="btn btn-primary btn-sm" title="Edit"><i class="fas fa-edit"></i></a>&nbsp;
                                            <a href="{{ route('admin.refrigerator.show', $item->id) }}" class="btn btn-primary btn-sm" title="Show"><i class="fas fa-eye"></i></a>&nbsp;
                                            <a href="{{ route('admin.refrigerator.refrigerator-barcode', $item->id) }}" class="btn btn-primary btn-sm" title="Barcode"><i class="fas fa-barcode"></i></a>
                                        </div>
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
                $('#dataTable1').on('click', '.delete', function(e) {
                    e.preventDefault();
                    var row = datatable.rows( $(this).parents('tr') );
                    var url = $(this).data('href');
                    app.deleteItem(row, url);
                });
                $('#resetForm').on('click', app.resetFilterForm);
                $('#filter-by-date').flatpickr({
                    defaultDate: "{{ Request::has('expiry') ? Request::get('expiry') : 'today' }}",
                    dateFormat: 'Y-m-d',
                });
            },

            deleteItem: function(row, url) {
                if (confirm('Are you sure you want to remove this item?')) {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        success : function(data) {
                            row.remove().draw();
                            toastr.success(data.success);
                        }
                    });
                }
            },

            resetFilterForm: function() {
                $('#name').val('');
                $('#email').val('');
                $('#mobile').val('');
                $('#department').val('');
            }

        };
        app.initialize();
    </script>
@endpush

