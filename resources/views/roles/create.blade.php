@extends('admin.master')
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <x-title :titles="$titles" />
        <div id="kt_app_content_container" class="app-container container-xxl">
            <div class="card card-flush py-4">
                <div class="card-body pt-5">
                    {!! Form::open([
                        'route' => 'roles.store',
                        'method' => 'POST',
                        'id' => 'kt_ecommerce_settings_general_form',
                        'class' => 'form fv-plugins-bootstrap5 fv-plugins-framework validate_form_role',
                    ]) !!}
                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">Name</span>

                        </label>
                        {!! Form::text('name', null, [
                            'placeholder' => 'Enter Name',
                            'class' => 'form-control form-control-solid',
                            'id' => 'name',
                            'required data-parsley-pattern' => '^[a-zA-Z_ ]*$',
                            'data-parsley-required-message' => 'Please enter Name.',
                            'data-parsley-pattern-message' => 'Enter a valid Name.',
                            'data-parsley-trigger' => 'keyup',
                            'data-parsley-errors-container' => '#name_error',
                        ]) !!}
                        <span class="text-danger" id="name_error">{{ $errors->first('name') }}</span>
                    </div>

                    <div class="fv-row mb-7 fv-plugins-icon-container">
                        <label class="fs-6 fw-semibold form-label mt-3">
                            <span class="required">Permission</span>

                        </label><br />
                        @foreach ($permission as $value)
                            <label
                                class="mt-3">{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'form-check-input name', 'data-parsley-required' => 'true', 'data-parsley-required-message' => 'Please Select Permission.', 'data-parsley-errors-container' => '#permission_error', 'data-parsley-trigger' => 'click']) }}
                                {{ $value->name }}</label>
                            <br />
                        @endforeach
                        <span class="text-danger" id="permission_error">{{ $errors->first('permission') }}</span>
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
        var roleURL = `{{ route('roles.store') }}`;
        var roleIndexURL = `{{ route('roles.index') }}`;
    </script>
    <script src="{{ asset('assets/js/admin/role.js') }}"></script>
@endsection
