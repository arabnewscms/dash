<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    data-nav-layout="vertical" data-vertical-style="overlay" data-nav-style="menu-click" data-theme-mode="light"
    data-menu-styles="dark" data-toggled="icon-click-closed">
{{--   data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close" --}}

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ $DASHBOARD_ICON ?? url('dashboard/assets/img/dash/PNG/blue.png') }}">
    <link rel="icon" type="image/png"
        href="{{ $DASHBOARD_ICON ?? url('dashboard/assets/dash/images/dash/PNG/blue.png') }}">
    <title>{{ $title ?? $APP_NAME }}</title>

    @if (app()->getLocale() == 'ar')
        <link href="{{ url('dashboard/assets/dash/libs/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"
            id="style" />
    @else
        <link href="{{ url('dashboard/assets/dash/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
            id="style" />
    @endif

    <link href="{{ url('dashboard/assets/dash/css/styles.css') }}" rel="stylesheet" id="style" />
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/fonts/cairo/style.css') }}" />
    <link href="{{ url('dashboard/assets/dash/css/icons.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="{{ url('dashboard/assets/dash/fonts/fontawesome-free-6.2.0-web/css/all.min.css') }}" />
    <link href="{{ url('dashboard/assets/dash/libs/node-waves/waves.min.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('dashboard/assets/dash/libs/flatpicker/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ url('dashboard/assets/dash/libs/@simonwep/pickr/themes/nano.min.css') }}">

    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/city.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/sea.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/fantasy.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/forest.css') }}" rel="stylesheet">

    @if (!empty($fields))
        <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/dist/video-js.min.css') }}" rel="stylesheet">
        <link href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2.min.css') }}" rel="stylesheet" />

        @if (app()->getLocale() == 'ar')
            <link rel="stylesheet" type="text/css"
                href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2-bootstrap-5-theme.rtl.min.css') }}">
        @else
            <link rel="stylesheet" type="text/css"
                href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2-bootstrap-5-theme.min.css') }}">
        @endif
    @endif

    <link rel="stylesheet" type="text/css"
        href="{{ url('dashboard/assets/dash/libs/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/libs/dropzone/min/basic.css') }}">

    @if (app()->getLocale() == 'ar')
        <link rel="stylesheet" type="text/css"
            href="{{ url('dashboard/assets/dash/libs/datatable/css/dataTables.bootstrap5-rtl.css') }}">
    @else
        <link rel="stylesheet" type="text/css"
            href="{{ url('dashboard/assets/dash/libs/datatable/css/dataTables.bootstrap5.css') }}">
    @endif

    @push('js')
        <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/toastr/toastr.min.js') }}"></script>
        <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/libs/toastr/toastr.min.css') }}">
        <script type="text/javascript">
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": false,
                    "positionClass": "toast-bottom-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "5000",
                    "timeOut": "5000",
                };
                @if (session()->has('success'))
                    toastr.success("{{ session('success') }}");
                @endif
                @if (session()->has('error'))
                    toastr.error("{{ session('error') }}");
                @endif
                @if (session()->has('danger'))
                    toastr.error("{{ session('danger') }}");
                @endif
                @if (session()->has('warning'))
                    toastr.warning("{{ session('warning') }}");
                @endif
                @if (session()->has('info'))
                    toastr.info("{{ session('info') }}");
                @endif
            });
        </script>
    @endpush

    <style>
        .app-sidebar .side-menu__item,
        .side-menu__label {
            font-size: 0.813rem;
            font-family: var(--default-font-family);
        }

        .dataTables_processing {
            color: rgb(var(--dark-rgb)) !important;
        }
    </style>

    <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/datatables/js/jquery.min.js') }}"></script>
    <script src="{{ url('dashboard/assets/dash/js/main.js') }}"></script>

    @if (!empty($fields))
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/super-build/ckeditor.js"
            {{ request('edit_with_inline') ? 'defer' : '' }}></script>
    @endif

    <script src="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/dist/video.min.js') }}"></script>
    <script src="{{ url('dashboard/assets/dash/libs/dropzone/min/dropzone.min.js') }}" type="text/javascript"></script>
</head>

<body>
    @include('dash::layouts.switcher')
    <div class="page">
        @include('dash::layouts.header')
        @include('dash::layouts.sidebar')
        <!-- Start::app-content -->
        <div class="main-content app-content">
            <div class="container-fluid">
                @include('dash::layouts.breadcrumb')
                <!--Content-->
                @yield('content')
                <!--End Content-->
            </div>
        </div>
        <!-- End::app-content -->
        <style>
            .dataTables_processing {
                color: rgb(var(--dark-rgb)) !important;
            }
        </style>


        @include('dash::layouts.footer')


        {{-- Datatable js --}}
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/jquery.dataTables.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/dataTables.bootstrap5.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/dataTables.buttons.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.bootstrap5.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/jszip.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/pdfmake/pdfmake.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/pdfmake/vfs_fonts.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.html5.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.print.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/js/buttons.colVis.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/dataTables.responsive.min.js"></script>
        <script src="{{ url('dashboard/assets/dash') }}/libs/datatable/responsive.bootstrap5.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.dataTables_info,.dataTables_length').addClass('text-dark')
                $('.dataTables_length label').addClass('ms-2')
            });
        </script>
</body>

</html>
