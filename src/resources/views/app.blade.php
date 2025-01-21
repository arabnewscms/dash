<!DOCTYPE html>
<html lang="{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}"
    data-nav-layout="vertical" data-vertical-style="overlay">
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
    <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/datatables/js/jquery.min.js') }}"></script>

    <!-- Choices JS -->
    <script src="{{ url('dashboard/assets/dash/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <!-- Main Theme Js -->
    <script src="{{ url('dashboard/assets/dash/js/main.js') }}"></script>

    <!-- CSS Files -->
    <!-- Bootstrap css -->
    @if (app()->getLocale() == 'ar')
        <link href="{{ url('dashboard/assets/dash/libs/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"
            id="style" />
    @else
        <link href="{{ url('dashboard/assets/dash/libs/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet"
            id="style" />
    @endif

    <link href="{{ url('dashboard/assets/dash/css/styles.css') }}" rel="stylesheet" id="style" />



    <!--  Fonts and icons  -->
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/fonts/cairo/style.css') }}" />

    <!-- Icons Css -->
    <link href="{{ url('dashboard/assets/dash/css/icons.css') }}" rel="stylesheet">


    <!--fontawesome-free-6.2.0 Css Start-->
    <link rel="stylesheet"
        href="{{ url('dashboard/assets/dash/fonts/fontawesome-free-6.2.0-web/css/all.min.css') }}" />
    <!--fontawesome-free-6.2.0 Css End-->

    <!--fontawesome-free-6.2.0 Js Start-->
    <script src="{{ url('dashboard/assets/dash/fonts/fontawesome-free-6.2.0-web/js/all.min.js') }}"></script>
    <!--fontawesome-free-6.2.0 Js End-->

    <!-- Node Waves Css -->
    <link href="{{ url('dashboard/assets/dash/libs/node-waves/waves.min.css') }}" rel="stylesheet">

    <!-- Simplebar Css -->
    <link href="{{ url('dashboard/assets/dash/libs/simplebar/simplebar.min.css') }}" rel="stylesheet">

    <!-- Color Picker Css -->
    <link rel="stylesheet" href="{{ url('dashboard/assets/dash/libs/flatpicker/dist/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ url('dashboard/assets/dash/libs/@simonwep/pickr/themes/nano.min.css') }}">

    {{--  If Call Ajax Request Start  --}}
    <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/flatpicker/dist/flatpickr.min.js') }}" defer>
    </script>
    @if (app()->getLocale() != 'en')
        <script type="text/javascript"
            src="{{ url('dashboard/assets/dash/libs/flatpicker/dist/l10n/' . app()->getLocale() . '.js') }}" defer></script>
    @endif

    <!-- Video Js Themes -->
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/city.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/sea.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/fantasy.css') }}" rel="stylesheet">
    <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/theme/forest.css') }}" rel="stylesheet">

    @if (!empty($fields))
        <!-- Video.js base CSS -->
        <link href="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/dist/video-js.min.css') }}" rel="stylesheet">
        <!--select2 Start-->
        <link href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2.min.css') }}" rel="stylesheet" />
        <script src="{{ url('dashboard/assets/dash/libs/select2-4-1-0/js/select2.min.js') }}"></script>

        @if (app()->getLocale() == 'ar')
            <script src="{{ url('dashboard/assets/dash/libs/select2-4-1-0/js/i18n/ar.js') }}"></script>
            <link rel="stylesheet" type="text/css"
                href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2-bootstrap-5-theme.rtl.min.css') }}">
        @else
            @if (app()->getLocale() != 'en')
                <script src="{{ url('dashboard/assets/dash/libs/select2-4-1-0/js/i18n/' . app()->getLocale() . '.js') }}"></script>
            @endif

            <link rel="stylesheet" type="text/css"
                href="{{ url('dashboard/assets/dash/libs/select2-4-1-0/css/select2-bootstrap-5-theme.min.css') }}">
        @endif
    @endif

    <!--select2 End-->
    <script src="{{ url('dashboard/assets/dash/libs/video.js-7.11.4/dist/video.min.js') }}"></script>
    @if (!empty($fields))
        <!-- Video Js End -->
        <script src="https://cdn.ckeditor.com/ckeditor5/35.1.0/super-build/ckeditor.js"
            {{ request('edit_with_inline') ? 'defer' : '' }}></script>
    @endif
    {{--  If not Call Ajax Request Start  --}}
    <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/flatpicker/dist/flatpickr.min.js') }}"></script>
    @if (app()->getLocale() != 'en')
        <script type="text/javascript"
            src="{{ url('dashboard/assets/dash/libs/flatpicker/dist/l10n/' . app()->getLocale() . '.js') }}"></script>
    @endif
    {{--  If not Call Ajax Request End  --}}

    <link rel="stylesheet" type="text/css"
        href="{{ url('dashboard/assets/dash/libs/dropzone/min/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/libs/dropzone/min/basic.css') }}">
    <script src="{{ url('dashboard/assets/dash/libs/dropzone/min/dropzone.min.js') }}" type="text/javascript"></script>

    <!-- system message and notifications -->
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
                    // "extendedTimeOut": "1000",
                    // "showEasing": "swing",
                    // "hideEasing": "linear",
                    // "showMethod": "fadeIn",
                    // "hideMethod": "fadeOut"
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
    <!-- system message and notifications End-->
    <style>
        .app-sidebar .side-menu__item,
        .side-menu__label {
            font-size: 0.813rem;
            font-family: var(--default-font-family);
        }

    </style>

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
            .dataTables_processing{
                color: rgb(var(--dark-rgb)) !important;
            }
        </style>


        @include('dash::layouts.footer')

</body>

</html>
