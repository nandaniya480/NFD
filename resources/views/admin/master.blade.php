@include('admin.layouts.header')
<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('admin.layouts.sidebar')
            <div class="layout-page">
                @include('admin.layouts.top-content')
                <div class="content-wrapper">
                    @yield('content')
                    @include('admin.layouts.footer')
                    @yield('page-js')
