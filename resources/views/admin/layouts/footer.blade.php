<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
            <div>
                ©
                <script>
                    document.write(new Date().getFullYear())
                </script>
                <a href="#" target="_blank" class="fw-semibold">Next Food Delivery</a>
            </div>
            <div>
            </div>
        </div>
    </div>
</footer>
<div class="content-backdrop fade"></div>
</div>
</div>
</div>
<div class="layout-overlay layout-menu-toggle"></div>
<div class="drag-target"></div>
</div>
@yield('js')
{{-- <script>
    $("#form_submit").submit(function() {
        var form = $(this);
        form.parsley().validate();
        if (form.parsley().isValid()) {
            $("#submit").prop("disabled", true);
        }
    });
</script> --}}
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>
<script src="{{ asset('assets/js/pages-auth.js') }}"></script>
<script src="{{ asset('assets/js/parsley/parsley.js') }}"></script>
<script src="{{ asset('assets/js/parsley/parsley.min.js') }}"></script>
<script src="{{ asset('assets/js/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
</body>

</html>

@if (Session::has('success'))
    <script>
        Command: toastr["success"]('<?php echo Session::get('success'); ?>')
    </script>
@endif
@if (Session::has('error'))
    <script>
        Command: toastr["error"]('<?php echo Session::get('error'); ?>')
    </script>
@endif
@if (Session::has('warning'))
    <script>
        Command: toastr["warning"]('<?php echo Session::get('warning'); ?>')
    </script>
@endif
@if (Session::has('info'))
    <script>
        Command: toastr["info"]('<?php echo Session::get('info'); ?>')
    </script>
@endif
