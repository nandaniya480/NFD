@extends('admin.master')
@section('content')
    <x-title :titles="$titles" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-body pt-5">
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <strong>Name:</strong>
                        {{ $role->name }}
                    </div>
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <strong>Permissions:</strong>
                        @if (!empty($rolePermissions))
                            @foreach ($rolePermissions as $v)
                                <label class="label label-success">{{ $v->name }},</label>
                            @endforeach
                        @endif
                    </div>
                    <div class="separator mb-6"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
