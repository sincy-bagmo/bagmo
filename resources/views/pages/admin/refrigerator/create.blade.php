@extends('layouts.admin-dashboard')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Register Refrigerator</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.refrigerator.store') }}" enctype="multipart/form-data" >
                        @csrf
                        <div class="row">
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Refrigerator name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('refrigerator_name')is-invalid @enderror" id="refrigerator_name" name="refrigerator_name" value="{{ old('refrigerator_name') }}"  placeholder="Enter Refrigerator Name"
                                           @error('refrigerator_name')aria-describedby="refrigerator_name-error" aria-invalid="true" @enderror >
                                    @error('refrigerator_name')
                                    <span id="refrigerator_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Company Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company')is-invalid @enderror" id="company" name="company" value="{{ old('company') }}"  placeholder="Enter Company Name"
                                           @error('company')aria-describedby="company-error" aria-invalid="true" @enderror >
                                    @error('company')
                                    <span id="company-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Type<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('type')is-invalid @enderror" id="type" name="type" placeholder="Enter type" value="{{ old('type') }}"
                                           @error('type')aria-describedby="type-error" aria-invalid="true" @enderror >
                                    @error('type')
                                    <span id="type-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Remarks<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('remarks')is-invalid @enderror" id="remarks" name="remarks" placeholder="Enter Remarks" value="{{ old('remarks') }}"
                                           @error('remarks')aria-describedby="remarks-error" aria-invalid="true" @enderror >
                                    @error('remarks')
                                    <span id="remarks-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Indication Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('indication_name')is-invalid @enderror" id="indication_name" name="indication_name" placeholder="Enter Indication Name" value="{{ old('indication_name') }}"
                                           @error('indication_name')aria-describedby="indication_name-error" aria-invalid="true" @enderror >
                                    @error('indication_name')
                                    <span id="indication_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Reference Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('reference_number')is-invalid @enderror" id="reference_number" name="reference_number" placeholder="Enter Reference Number" value="{{ old('reference_number') }}"
                                           @error('reference_number')aria-describedby="reference_number-error" aria-invalid="true" @enderror >
                                    @error('reference_number')
                                    <span id="reference_number-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Rack Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('rack_name')is-invalid @enderror rack-name" id="rack_name" name="rack_name[]" placeholder="Enter Rack Name" value="{{ old('rack_name') }}"
                                           @error('rack_name')aria-describedby="rack_name-error" aria-invalid="true" @enderror >
                                    @error('rack_name')
                                    <span id="rack_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12 mt-2">
                                <button type="button" class="btn btn-flat-danger remove-field">&nbsp;<span>Delete</span></button>
                            </div>
                            <div id="append-div"></div>
                            <div class="col-md-12  col-12">
                                <button type="button" class="btn btn-flat-success add-button"><i data-feather='plus-circle'></i>&nbsp;<span>Add</span></button>
                            </div>
                                <hr />
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
                $('#refrigerator_name').focus();


                $(document).ready(function() {
                    $('#expiry').flatpickr({
                        dateFormat: 'Y-m-d',
                        minDate: 'today',
                    });
                });

                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                        event.preventDefault();
                        return false;
                    }
                });

                $('.add-button').click( function(e) {
                    var selected = [];
                    var flag = 0;
                    var rack = $('.rack-name').val();
                    $('.rack-name').each(function () {
                        selected.push($(this).val());
                    });
                    var temp = [];
                    selected.forEach(function (value, key) {
                        if (value == '') {
                            flag = 1;
                        } else if (jQuery.inArray(value, temp) !== -1) {
                            flag = 2;
                        } else {
                            temp.push(value);
                        }
                    });

                    if (flag == 1) {
                        toastr.error('Please Fill An Option Before Adding Next Option');
                        $('#submit-btn').attr('disabled', true);
                        e.preventDefault();
                    } else if (flag == 2) {
                        toastr.error('Rack Already Exists');
                        $('#submit-btn').attr('disabled', true);
                        e.preventDefault();
                    } else {
                        appendInput();
                    }
                });
                function appendInput() {
                    var html = '<div class="row"><div class="col-md-6  col-12"><div class="mb-1"><label  class="form-label">Rack Name<span class="text-danger">*</span></label><input type="text" class="form-control rack-name" id="rack_name" name="rack_name[]" placeholder="Enter Rack Name" value="{{ old('rack_name') }}"@error('rack_name')aria-describedby="rack_name-error" aria-invalid="true" @enderror ></div></div>  <div class="col-md-6  col-12 mt-2"> <button type="button" class="btn btn-flat-danger remove-field"><span>Delete</span></button></div></div>';
                    $('#append-div').append(html);
                    $('#submit-btn').attr('disabled', false);
                    $('.rack-name').focus();
                }
                $('body').on('click', '.remove-field', function (){
                    $(this).parent().prev('label.label-remove ').remove();
                    $(this).parent().parent().remove();
                    $('#submit-btn').attr('disabled', false);
                });
            },
        };

        app.initialize();
    </script>
@endpush
