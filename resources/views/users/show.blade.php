@extends('admin.master')
@section('content')
    <x-title :titles="$titles" />
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="card">
                <div class="card-body pt-5">
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <span class="fw-semibold me-1">Username:</span>
                                <span> {{ $user->name }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Email:</span>
                                <span> {{ $user->email }}</span>
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Role:</span>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <span> {{ $v }}</span>
                                    @endforeach
                                @endif
                            </li>
                            <li class="mb-2 pt-1">
                                <span class="fw-semibold me-1">Contact:</span>
                                <span> {{ $user->phone_number }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
