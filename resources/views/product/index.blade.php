@extends('admin.master')
@section('content')
    <x-title :titles="$titles" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="card-header"></h5>
                    <a href="{{ route('product.create') }}" class="btn btn-primary" style="width: 15%; margin-right: 15px; margin-top: 15px;">
                        Add Product
                    </a>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="table product-table">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th width="25%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script>
        var productURL = "{{ route('product.store') }}";
        var productIndexURL = "{{ route('product.index') }}";
    </script>
    <script src="{{ asset('assets/js/admin/product.js') }}"></script>
@endsection
