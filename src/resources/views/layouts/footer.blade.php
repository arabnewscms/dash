<!--Search Modal Popup-->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="input-group">
                    <a href="javascript:void(0);" class="input-group-text" id="Search-Grid">
                        <i class="fas fa-search header-link-icon fs-18"></i>
                    </a>
                    <input type="search" class="form-control border-0 px-2" placeholder="Search" aria-label="Username">
                    <a href="javascript:void(0);" class="input-group-text" id="voice-search">
                        <i class="fas fa-microphone header-link-icon"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-light btn-icon" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-ellipsis-v"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                    </ul>
                </div>
                <div class="mt-4">
                    <p class="font-weight-semibold text-muted mb-2">Are You Looking For...</p>
                    <span class="search-tags alert">
                        <i class="fas fa-user me-2"></i>People
                        <a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <span class="search-tags alert">
                        <i class="fas fa-file-alt me-2"></i>Pages
                        <a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <span class="search-tags alert">
                        <i class="fas fa-align-left me-2"></i>Articles
                        <a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                    <span class="search-tags alert">
                        <i class="fas fa-tags me-2"></i>Tags
                        <a href="javascript:void(0)" class="tag-addon" data-bs-dismiss="alert">
                            <i class="fas fa-times"></i>
                        </a>
                    </span>
                </div>
                <div class="my-4">
                    <p class="font-weight-semibold text-muted mb-2">Recent Search :</p>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                        <a href="notifications.html"><span>Notifications</span></a>
                        <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times text-muted"></i>
                        </a>
                    </div>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-2 alert">
                        <a href="alerts.html"><span>Alerts</span></a>
                        <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times text-muted"></i>
                        </a>
                    </div>
                    <div class="p-2 border br-5 d-flex align-items-center text-muted mb-0 alert">
                        <a href="mail.html"><span>Mail</span></a>
                        <a class="ms-auto lh-1" href="javascript:void(0);" data-bs-dismiss="alert" aria-label="Close">
                            <i class="fas fa-times text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btn-group ms-auto">
                    <button type="button" class="btn btn-sm btn-primary-light">Search</button>
                    <button type="button" class="btn btn-sm btn-primary">Clear Recents</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Search Modal Popup-->

@if (!empty($DASHBOARD_LANGUAGES) && count($DASHBOARD_LANGUAGES) > 1)
    <!--language Modal Popup-->
    <div class="modal fade" id="change_language_dash" tabindex="-1" aria-labelledby="change_language_dash"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                {{-- <div class="modal-header">
                    <h3> {{ $DASHBOARD_LANGUAGES[app()->getLocale()] }} </h3>
                </div> --}}
                <div class="modal-body p-4">
                    @php $langi = count($DASHBOARD_LANGUAGES); @endphp
                    @foreach ($DASHBOARD_LANGUAGES as $key => $value)
                        <a href="{{ url($DASHBOARD_PATH . '/change/language/' . $key) }}?lang={{ $key }}">
                            {{ $value }}
                        </a> {{ $langi >= count($DASHBOARD_LANGUAGES) ? ',' : '' }}
                        @php $langi--; @endphp
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bt-xs btn-primary-light"
                        data-bs-dismiss="modal">@lang('dash::dash.cancel')</button>
                </div>
            </div>
        </div>
    </div>
    <!--language Modal Popup-->
@endif

<!-- Footer Start -->
<footer class="footer mt-auto py-3 bg-white text-center">
    <div class="container">

        @if (!empty(config('dash.copyright')))
        <a href="{{ config('dash.copyright.link') }}"
            class="font-weight-bold"
            target="_blank">{!! config('dash.copyright.copyright_text') !!}</a>
    @else
    <span class="text-muted">   Copyright © <span id="year"></span> ,
        Dashboard <span class="fa fa-heart text-danger"></span> by
        <a href="https://phpdash.com" class="font-weight-bold"
            target="_blank">
            <span class="fw-semibold text-primary text-decoration-underline"> phpdash.com </span>
        </a>
    </span>
    @endif

    </div>
</footer>
<!-- Footer End -->

</div>


<!-- Scroll To Top -->
<div class="scrollToTop">
    <span class="arrow"><i class="fa-solid fa-chevron-up fs-20"></i></span>
</div>
<div id="responsive-overlay"></div>
<!-- Scroll To Top -->

<!-- Popper JS -->
<script src="{{ url('dashboard/assets/dash/libs/@popperjs/core/umd/popper.min.js') }}"></script>

<!-- Bootstrap JS -->
<script src="{{ url('dashboard/assets/dash/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Defaultmenu JS -->
<script src="{{ url('dashboard/assets/dash/js/defaultmenu.min.js') }}"></script>

<!-- Node Waves JS-->
<script src="{{ url('dashboard/assets/dash/libs/node-waves/waves.min.js') }}"></script>

<!-- Sticky JS -->
<script src="{{ url('dashboard/assets/dash/js/sticky.js') }}"></script>

<!-- Simplebar JS -->
<script src="{{ url('dashboard/assets/dash/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ url('dashboard/assets/dash/js/simplebar.js') }}"></script>

<!-- Color Picker JS -->
<script src="{{ url('dashboard/assets/dash/libs/@simonwep/pickr/pickr.es5.min.js') }}"></script>

<!-- Custom-Switcher JS -->
<script src="{{ url('dashboard/assets/dash/js/custom-switcher.min.js') }}"></script>

<!-- Custom JS -->
<script src="{{ url('dashboard/assets/dash/js/custom.js') }}"></script>

<script src="{{ url('dashboard/assets/dash/libs/select2-4-1-0/js/select2_4.0.13.min.js') }}" defer></script>

<script>
    @if (!empty(request('relationField')))
        @foreach (request('relationField') as $rk => $rv)
            $('.{{ $rk }}').val('{{ $rv }}').trigger('change');
        @endforeach
    @endif
</script>

{{-- <style type="text/css">
    @if (app()->getLocale() == 'ar')
        .dt-buttons {
            display: none;
        }
    @endif
    @if (session('DARK_MODE', config('dash.DARK_MODE')) == 'on')
        .select2-search__field {
            background-color: #25274a;
        }

        .select2-search__field input {
            background-color: #25274a;
        }

        .select2-results {
            background-color: #25274a;
        }

        .select2-container--bootstrap-5 .select2-selection {
            background-color: #25274a !important;
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-selection:hover {
            background-color: #25274a !important;
            color: #fff;
        }
    @endif

    .select2-search .select2-search--inline {
        display: block;
    }
</style> --}}
@stack('js')

<script>
    $(document).ready(function() {
        {{--  This belong to fix the select2 when active search input  --}}
        $.fn.modal.Constructor.prototype.enforceFocus = function() {
            var that = this;
            $(document).on('focusin.modal', function(e) {
                if ($(e.target).hasClass('select2-input')) {
                    return true;
                }

                //console.log('focusin worked');
                if (that.$element[0] !== e.target && !that.$element.has(e.target).length) {
                    that.$element.focus();
                }
            });
        };
    });
</script>
