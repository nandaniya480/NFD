<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                {{ isset($titles['title']) ? $titles['title'] : '' }}</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">

                @if (isset($titles['breadcrumb_item']))
                    @foreach ($titles['breadcrumb_item'] as $k => $data)
                        @if ($data['link'])
                            <li class="breadcrumb-item text-muted">
                                <a class="text-muted text-hover-primary"
                                    href="{{ $data['route'] }}">{{ $data['title'] }}</a>
                            </li>
                        @else
                            <li class="breadcrumb-item text-muted">
                                {{ $data['title'] }}
                            </li>
                        @endif
                    @endforeach
                @endif

            </ul>
        </div>

    </div>
</div>
