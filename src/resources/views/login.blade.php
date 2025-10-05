<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}" data-nav-layout="vertical"
    data-vertical-style="overlay" data-theme-mode="{{ config('dash.DARK_MODE') == 'on' ? 'dark' : 'light' }}"
    data-header-styles="{{ config('dash.DARK_MODE') == 'on' ? 'dark' : 'light' }}"
    data-menu-styles="{{ config('dash.DARK_MODE') == 'on' ? 'dark' : 'light' }}" data-toggled="close">

<head>

    <!-- Meta Data -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@lang('dash::dash.login')</title>
    <script type="text/javascript" src="{{ url('dashboard/assets/dash/libs/datatables/js/jquery.min.js') }}"></script>
    <!-- Favicon -->
    <link rel="icon" href="{{ $DASHBOARD_ICON ?? url('dashboard/assets/img/dash/PNG/blue.png') }}"
        type="image/x-icon">
    <link rel="apple-touch-icon" sizes="76x76"
        href="{{ $DASHBOARD_ICON ?? url('dashboard/assets/img/dash/PNG/blue.png') }}">
    <link rel="icon" type="image/png"
        href="{{ $DASHBOARD_ICON ?? url('dashboard/assets/dash/images/dash/PNG/blue.png') }}">

    <!-- Main Theme Js -->
    {{-- <script src="{{ url('dashboard/assets/dash') }}/js/authentication-main.js"></script> --}}
    @if (app()->getLocale() == 'ar')
        <link href="{{ url('dashboard/assets/dash/libs/bootstrap/css/bootstrap.rtl.min.css') }}" rel="stylesheet"
            id="style" />
    @else
        <!-- Bootstrap Css -->
        <link id="style" href="{{ url('dashboard/assets/dash') }}/libs/bootstrap/css/bootstrap.min.css"
            rel="stylesheet" />
    @endif
    <link rel="stylesheet" type="text/css" href="{{ url('dashboard/assets/dash/fonts/cairo/style.css') }}" />
    <!-- Style Css -->
    <link href="{{ url('dashboard/assets/dash') }}/css/styles.css" rel="stylesheet" />

    <!-- Icons Css -->
    <link href="{{ url('dashboard/assets/dash') }}/css/icons.css" rel="stylesheet" />
    <!--fontawesome-free-6.2.0 Css Start-->
    <link rel="stylesheet"
        href="{{ url('dashboard/assets/dash/fonts/fontawesome-free-6.2.0-web/css/all.min.css') }}" />
    <!--fontawesome-free-6.2.0 Css End-->

    <!--fontawesome-free-6.2.0 Js Start-->
    <script src="{{ url('dashboard/assets/dash/fonts/fontawesome-free-6.2.0-web/js/all.min.js') }}"></script>
    <!--fontawesome-free-6.2.0 Js End-->
    <style>
        .authentication .desktop-logo,
        .authentication .desktop-dark {
            height: 16rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
            <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">

                <div class="card custom-card">
                    <div class="card-body p-3">
                        @if (session()->has('error'))
                            <div class="alert alert-warning">
                                {{ session('error') }}
                            </div>
                        @endif
                        <div class="d-flex justify-content-center">
                            <a href="{{ dash('login') }}?lang={{ request('lang') }}">
                                <img src="{{ $DASHBOARD_ICON }}" style="max-height:70px" alt="{{ env('APP_NAME') }}"
                                    class="desktop-logo" />
                                <img src="{{ $DASHBOARD_ICON }}" style="max-height:70px" alt="{{ env('APP_NAME') }}"
                                    class="desktop-dark" />
                            </a>
                        </div>
                        <p class="h5 fw-semibold mb-2 text-center mt-2">@lang('dash::dash.login')</p>
                        {{-- <p class="mb-4 text-muted op-7 fw-normal text-center">Welcome back Jhon !</p> --}}

                        @php
                            $dashboardPath = trim(str_replace('.', '/', app('dash')['DASHBOARD_PATH']), '/');
                        @endphp
                        <form class="card-body pt-3" id="login" method="post"
                            action="{{ url($dashboardPath . '/login') }}">
                            @csrf
                            <input type="hidden" name="lang" value="{{ request('lang') }}" />
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">@lang('dash::dash.email')</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control form-control-lg {{ !empty($errors) && $errors->has('email') ? 'is-invalid' : '' }}"
                                        value="{{ old('email') }}" placeholder="@lang('dash::dash.email')" />
                                    @error('email')
                                        <p class="invalid-feedback">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-xl-12 mb-2">
                                    <label for="password"
                                        class="form-label text-default d-block">@lang('dash::dash.password')</label>
                                    <div class="input-group">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-lg {{ !empty($errors) && $errors->has('password') ? 'is-invalid' : '' }}"
                                            id="password" placeholder="@lang('dash::dash.password')">
                                        <button class="btn btn-light" type="button" id="Password-toggle">
                                            <i class="fa-solid fa-eye-slash"></i></button>
                                        @error('password')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" name="remember_me" type="checkbox"
                                                value="yes" id="defaultCheck1">
                                            <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                @lang('dash::dash.remember_me')
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 d-grid mt-2">
                                    <button class="btn btn-lg btn-primary" type="submit">@lang('dash::dash.signin')</button>

                                </div>
                            </div>
                            {{-- <div class="text-center">
                                <p class="fs-12 text-muted mt-3">Dont have an account? <a href="sign-up-basic.html"
                                        class="text-primary">Sign Up</a></p>
                            </div> --}}
                            <div class="text-center my-3 authentication-barrier">
                                <span><i class="fa-solid fa-language"></i></span>
                            </div>

                            <div class="text-center">
                                @if (!empty($DASHBOARD_LANGUAGES) && count($DASHBOARD_LANGUAGES) > 1)
                                    @php $i=1; @endphp
                                    @foreach ($DASHBOARD_LANGUAGES as $key => $value)
                                        <a
                                            href="{{ url($DASHBOARD_PATH . '/change/language/' . $key) }}?lang={{ request('lang') }}">
                                            <span>{{ $value }}</span>
                                        </a> {{ count($DASHBOARD_LANGUAGES) > $i ? ',' : '' }}
                                        @php $i++; @endphp
                                    @endforeach
                                    <br />
                                    {{-- <hr /> --}}
                                    <p class="pt-4">
                                        @if (!empty(config('dash.copyright')))
                                            <a href="{{ config('dash.copyright.link') }}" class="font-weight-bold"
                                                target="_blank">{!! config('dash.copyright.copyright_text') !!}</a>
                                        @else
                                            Copyright © {{ date('Y') }},
                                            Dashboard <span class="fa fa-heart text-danger"></span> by
                                            <a href="https://phpdash.com" class="font-weight-bold" target="_blank">
                                                phpdash.com
                                            </a>
                                        @endif
                                    </p>
                                @endif
                            </div>

                            {{-- <div class="btn-list text-center">
                                <button class="btn btn-icon btn-light">
                                    <i class="ri-facebook-line fw-bold text-dark op-7"></i>
                                </button>
                                <button class="btn btn-icon btn-light">
                                    <i class="ri-google-line fw-bold text-dark op-7"></i>
                                </button>
                                <button class="btn btn-icon btn-light">
                                    <i class="ri-twitter-x-line fw-bold text-dark op-7"></i>
                                </button>
                            </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="{{ url('dashboard/assets/dash') }}/libs/bootstrap/js/bootstrap.bundle.min.js"></script>

    {{-- <!-- Show Password JS --> --}}
    {{-- <script src="{{ url('dashboard/assets/dash') }}/js/show-password.js"></script> --}}

    <script>
        $(document).ready(function() {
            $('#Password-toggle').on('click', function(e) {
                e.preventDefault(); // منع السلوك الافتراضي للزر

                const passwordInput = $('#password'); // تحديد حقل إدخال كلمة المرور
                const icon = $(this).find('svg'); // تحديد عنصر <svg> داخل الزر

                // تبديل رؤية كلمة المرور
                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text'); // تغيير نوع الإدخال إلى نص
                    icon.removeClass('fa-eye-slash').addClass('fa-eye'); // تغيير الأيقونة إلى عين مفتوحة
                } else {
                    passwordInput.attr('type', 'password'); // تغيير نوع الإدخال إلى كلمة مرور
                    icon.removeClass('fa-eye').addClass('fa-eye-slash'); // تغيير الأيقونة إلى عين مغلقة
                }
            });
        });
    </script>
</body>

</html>
