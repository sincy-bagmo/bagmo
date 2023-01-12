@extends('layouts.admin-dashboard')
@section('content')


    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Refrigerator</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.refrigerator.update', $refrigerator->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Refrigerator name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('refrigerator_name')is-invalid @enderror" id="refrigerator_name" name="refrigerator_name" value="{{ old('refrigerator_name', $refrigerator->refrigerator_name) }}"  placeholder="Enter Refrigerator Name"
                                           @error('refrigerator_name')aria-describedby="refrigerator_name-error" aria-invalid="true" @enderror >
                                    @error('refrigerator_name')
                                    <span id="refrigerator_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Company Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('company')is-invalid @enderror" id="company" name="company" value="{{ old('company', $refrigerator->company) }}"  placeholder="Enter Company Name"
                                           @error('company')aria-describedby="company-error" aria-invalid="true" @enderror >
                                    @error('company')
                                    <span id="company-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Type<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('type')is-invalid @enderror" id="type" name="type" placeholder="Enter type" value="{{ old('type', $refrigerator->type) }}"
                                           @error('type')aria-describedby="type-error" aria-invalid="true" @enderror >
                                    @error('type')
                                    <span id="type-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Remarks<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('remarks')is-invalid @enderror" id="remarks" name="remarks" placeholder="Enter Remarks" value="{{ old('remarks', $refrigerator->remarks) }}"
                                           @error('remarks')aria-describedby="remarks-error" aria-invalid="true" @enderror >
                                    @error('remarks')
                                    <span id="remarks-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Indication Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('indication_name')is-invalid @enderror" id="indication_name" name="indication_name" placeholder="Enter Indication Name" value="{{ old('indication_name', $refrigerator->indication_name) }}"
                                           @error('indication_name')aria-describedby="indication_name-error" aria-invalid="true" @enderror >
                                    @error('indication_name')
                                    <span id="indication_name-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6  col-12">
                                <div class="mb-1">
                                    <label  class="form-label">Reference Number<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('reference_number')is-invalid @enderror" id="reference_number" name="reference_number" placeholder="Enter Reference Number" value="{{ old('reference_number', $refrigerator->reference_number) }}"
                                           @error('reference_number')aria-describedby="reference_number-error" aria-invalid="true" @enderror >
                                    @error('reference_number')
                                    <span id="reference_number-error" class="error invalid-feedback" style="display: block;">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12  col-12">
                                <div class="mb-1">
                                    <button type="submit" class="btn btn-primary me-1">Submit</button>
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
        $(document).ready(function () {
            var App = {
                initialize: function () {

                }
            };
            App.initialize();
        })
    </script>
@endpush
