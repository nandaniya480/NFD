@extends('admin.master')
@section('content')
    <x-title :titles="$titles" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-body pt-5">
                    <form method="POST" action="{{ route('product.store') }}" id="kt_ecommerce_settings_general_form"
                        class="form fv-plugins-bootstrap5 fv-plugins-framework validate_form_user">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $product->id }}">

                            <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Product Name</span>
                                </label>

                                <input type="text" name="name" placeholder="Enter Product Name"
                                    class="form-control form-control-solid" id="name" required
                                    data-parsley-pattern="^[a-zA-Z_ ]*$"
                                    data-parsley-required-message="Please enter Product Name."
                                    data-parsley-pattern-message="Enter a valid Product Name." data-parsley-trigger="keyup"
                                    data-parsley-errors-container="#name_error"
                                    value="{{ old('name', isset($product) ? $product->name : '') }}">

                                <span class="text-danger" id="name_error">{{ $errors->first('name') }}</span>
                            </div>

                            <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Price</span>
                                </label>
                                <input type="text" name="price" placeholder="Enter Price"
                                    class="form-control form-control-solid" id="price" required pattern="^[0-9]+$"
                                    data-parsley-required-message="Please enter Price"
                                    data-parsley-pattern-message="Enter a valid Price" data-parsley-trigger="keyup"
                                    data-parsley-errors-container="#price_error"
                                    value="{{ old('price', isset($product) ? $product->price : '') }}">

                                <span class="text-danger" id="price_error">{{ $errors->first('price') }}</span>
                            </div>
                        </div>
                        <div class="separator mb-6"></div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" id="submit" data-kt-contacts-type="submit" class="btn btn-primary">
                                <span class="indicator-label">Save</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page-js')
    <script>
        var productURL = `{{ route('product.store') }}`;
        var productIndexURL = `{{ route('product.index') }}`;
    </script>
    <script src="{{ asset('assets/js/admin/product.js') }}"></script>
@endsection
