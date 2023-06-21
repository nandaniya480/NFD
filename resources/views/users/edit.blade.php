@extends('admin.master')
@section('content')
    <x-title :titles="$titles" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-body pt-5">
                    {!! Form::model($user, [
                        'method' => 'POST',
                        'route' => ['users.store'],
                        'id' => 'kt_ecommerce_settings_general_form',
                        'class' => 'form fv-plugins-bootstrap5 fv-plugins-framework validate_form_user',
                    ]) !!}
                    <div class="row">
                        {!! Form::hidden('id', $user->id) !!}

                        <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">First Name</span>
                            </label>
                            {!! Form::text('first_name', null, [
                                'placeholder' => 'Enter First Name',
                                'class' => 'form-control form-control-solid',
                                'id' => 'first_name',
                                'required data-parsley-pattern' => '^[a-zA-Z_ ]*$',
                                'data-parsley-required-message' => 'Please enter First Name.',
                                'data-parsley-pattern-message' => 'Enter a valid First Name.',
                                'data-parsley-trigger' => 'keyup',
                                'data-parsley-errors-container' => '#first_name_error',
                            ]) !!}
                            <span class="text-danger" id="first_name_error">{{ $errors->first('first_name') }}</span>
                        </div>

                        <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Last Name</span>
                            </label>
                            {!! Form::text('last_name', null, [
                                'placeholder' => 'Enter Last Name',
                                'class' => 'form-control form-control-solid',
                                'id' => 'last_name',
                                'required data-parsley-pattern' => '^[a-zA-Z_ ]*$',
                                'data-parsley-required-message' => 'Please enter Last Name.',
                                'data-parsley-pattern-message' => 'Enter a valid Last Name.',
                                'data-parsley-trigger' => 'keyup',
                                'data-parsley-errors-container' => '#last_name_error',
                            ]) !!}
                            <span class="text-danger" id="last_name_error">{{ $errors->first('last_name') }}</span>
                        </div>

                        <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Email</span>
                            </label>
                            {!! Form::text('email', null, [
                                'placeholder' => 'Enter Email',
                                'class' => 'form-control form-control-solid',
                                'id' => 'email',
                                'required data-parsley-type' => 'email',
                                'data-parsley-required-message' => 'Please enter Email.',
                                'data-parsley-pattern-message' => 'Enter a valid Email.',
                                'data-parsley-trigger' => 'keyup',
                                'data-parsley-errors-container' => '#email_error',
                            ]) !!}
                            <span class="text-danger" id="email_error">{{ $errors->first('email') }}</span>
                        </div>

                        <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Phone No.</span>
                            </label>
                            {!! Form::text('phone_number', null, [
                                'placeholder' => 'Enter Phone No.',
                                'class' => 'form-control form-control-solid',
                                'id' => 'phone_number',
                                'required data-parsley-pattern' => '^[0-9]{10}',
                                'data-parsley-required-message' => 'Please enter Phone No.',
                                'data-parsley-pattern-message' => 'Enter a valid Phone No.',
                                'data-parsley-trigger' => 'keyup',
                                'data-parsley-errors-container' => '#phone_number_error',
                            ]) !!}
                            <span class="text-danger" id="phone_number_error">{{ $errors->first('phone_number') }}</span>
                        </div>

                        <div class="col-4 fv-row mb-3 fv-plugins-icon-container">
                            <label class="fs-6 fw-semibold form-label mt-3">
                                <span class="required">Role</span>
                            </label>
                            <select name="role[]" aria-label="Select Role" data-control="select2"
                                data-placeholder="Select role..." class="form-control" required
                                data-parsley-required-message="Please select role"
                                data-parsley-errors-container='#role_error'>
                                <option value="">Select Role...</option>
                                @foreach ($roles as $label)
                                    <option value="{{ $label }}" {{ in_array($label, $userRole) ? 'selected' : '' }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger" id="roles_error">{{ $errors->first('roles') }}</span>
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
        var userURL = `{{ route('users.store') }}`;
        var userIndexURL = `{{ route('users.index') }}`;
    </script>
    <script src="{{ asset('assets/js/admin/user.js') }}"></script>
@endsection
