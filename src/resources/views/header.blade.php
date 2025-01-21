<div class="app-header header sticky">
    <div class="container-fluid main-container">
        <div class="d-flex">
            <a class="header-brand" href="{{ dash('/') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img desktop-lgo" style="width:131px;" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img dark-logo" style="width:131px;" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img mobile-logo" style="width:131px;" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img darkmobile-logo" style="width:131px;" alt="{{ env('APP_NAME') }}">
            </a>
            <div class="app-sidebar__toggle" data-bs-toggle="sidebar">
                <a class="open-toggle" mode="open" href="javascript:void(0);">
                    <i class="feather feather-menu"></i>
                </a>
                <a class="close-toggle" mode="close" href="javascript:void(0);">
                    <i class="feather feather-x"></i>
                </a>
            </div>
            @push('js')
            <script>
                $(document).on('click','.close-toggle,.open-toggle',function(){
                    var sidenavtoggle = $(this).attr('mode');
                    if(sidenavtoggle != ''){
                        var full_width = $(window).outerWidth() <= 1024;
                        var sidenavtoggle = !full_width?sidenavtoggle:'close';
                        $.ajax({
                            url:'{{ dash("sidenav/toggled") }}/'+sidenavtoggle,
                            type:'get',
                            data:{
                                lang:"{{request('lang')}}"
                            }
                        });
                    }
                });
            </script>
        @endpush
            <div class="mt-0">
                @include('dash::searchs')

            </div><!-- SEARCH -->
            <div class="d-flex order-lg-2 my-auto ms-auto">
                <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
                </button>
                <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0" style="z-index: 99;">
                    <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                        <div class="d-flex ms-auto">
                            <a class="nav-link  icon p-0 nav-link-lg d-lg-none navsearch"  href="javascript:void(0);" data-bs-toggle="search">
                                <i class="feather feather-search search-icon header-icon"></i>
                            </a>

                            @if (!empty($DASHBOARD_LANGUAGES) && count($DASHBOARD_LANGUAGES) > 1)
                            <div class="dropdown header-flags">
                                <a class="nav-link border" data-bs-toggle="dropdown">
                                    <small class="fs-6 p-2">
                                        {{ $DASHBOARD_LANGUAGES[app()->getLocale()] }}
                                    </small>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                @foreach ($DASHBOARD_LANGUAGES as $key => $value)
                                    <a href="{{ url($DASHBOARD_PATH . '/change/language/' . $key) }}?lang={{$key}}" class="dropdown-item d-flex">
                                        <div class="d-flex">
                                            <span class="my-auto">{{ $value }}</span>
                                        </div>
                                    </a>
                                @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="dropdown  d-flex">
                                <a class="nav-link icon theme-layout nav-link-bg layout-setting">
                                    <span class="dark-layout" mode="on"><i class="fe fe-moon"></i></span>
                                    <span class="light-layout" mode="off"><i class="fe fe-sun"></i></span>
                                </a>
                                @push('js')
                                    <script>
                                        $(document).on('click','.dark-layout,.light-layout',function(){
                                            var dark_mode = $(this).attr('mode');
                                            if(dark_mode != ''){
                                                $.ajax({
                                                    url:'{{ dash("darkmode") }}/'+dark_mode,
                                                    type:'get',
                                                    lang:"{{request("lang")}}"
                                                });
                                            }
                                        });
                                    </script>
                                @endpush
                            </div>

                            <div class="dropdown header-fullscreen">
                                <a class="nav-link icon full-screen-link">
                                    <i class="feather feather-maximize fullscreen-button fullscreen header-icons"></i>
                                    <i class="feather feather-minimize fullscreen-button exit-fullscreen header-icons"></i>
                                </a>
                            </div>
                            {{--  <div class="dropdown header-message">
                                <a class="nav-link icon" data-bs-toggle="dropdown">
                                    <i class="feather feather-mail header-icon"></i>
                                    <span class="badge badge-success side-badge">5</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow  animated">
                                    <div class="header-dropdown-list message-menu" id="message-menu">
                                        <a class="dropdown-item border-bottom" href="chat.html">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <span class="avatar avatar-md brround align-self-center cover-image" data-bs-image-src="{{ url('dashboard/assets/dashtemplate') }}/images/users/1.jpg"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="ps-3 text-wrap text-break">
                                                        <h6 class="mb-1">Jack Wright</h6>
                                                        <p class="fs-13 mb-1">All the best your template awesome</p>
                                                        <div class="small text-muted">
                                                            3 hours ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item border-bottom" href="chat.html">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <span class="avatar avatar-md brround align-self-center cover-image" data-bs-image-src="{{ url('dashboard/assets/dashtemplate') }}/images/users/2.jpg"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="ps-3 text-wrap text-break">
                                                        <h6 class="mb-1">Lisa Rutherford</h6>
                                                        <p class="fs-13 mb-1">Hey! there   available</p>
                                                        <div class="small text-muted">
                                                            5 hour ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item border-bottom" href="chat.html">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <span class="avatar avatar-md brround align-self-center cover-image" data-bs-image-src="{{ url('dashboard/assets/dashtemplate') }}/images/users/3.jpg"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="ps-3 text-wrap text-break">
                                                        <h6 class="mb-1">Blake Walker</h6>
                                                        <p class="fs-13 mb-1">Just created a new blog post</p>
                                                        <div class="small text-muted">
                                                            45 mintues ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item border-bottom" href="chat.html">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <span class="avatar avatar-md brround align-self-center cover-image" data-bs-image-src="{{ url('dashboard/assets/dashtemplate') }}/images/users/4.jpg"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="ps-3 text-wrap text-break">
                                                        <h6 class="mb-1">Fiona Morrison</h6>
                                                        <p class="fs-13 mb-1">Added new comment on your photo</p>
                                                        <div class="small text-muted">
                                                            2 days ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        <a class="dropdown-item border-bottom" href="chat.html">
                                            <div class="d-flex align-items-center">
                                                <div class="">
                                                    <span class="avatar avatar-md brround align-self-center cover-image" data-bs-image-src="{{ url('dashboard/assets/dashtemplate') }}/images/users/6.jpg"></span>
                                                </div>
                                                <div class="d-flex">
                                                    <div class="ps-3 text-wrap text-break">
                                                        <h6 class="mb-1">Stewart Bond</h6>
                                                        <p class="fs-13 mb-1">Your payment invoice is generated</p>
                                                        <div class="small text-muted">
                                                            3 days ago
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                    <div class=" text-center p-2">
                                        <a href="chat.html" class="">See All Messages</a>
                                    </div>
                                </div>
                            </div>  --}}
                            @if(!empty($dash_notifications) && count($dash_notifications))
                             @php
    $DashtotalCount=0;
    foreach($dash_notifications as $dash_count){
    $DashtotalCount = $DashtotalCount + $dash_count::unreadCount();
    }
    @endphp

                            <div class="dropdown header-notify">
                                <a class="nav-link icon" data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right">
                                    <i class="feather feather-bell header-icon"></i>
                                    {{--  <span class="bg-dot"></span>  --}}
                                    <span class="badge badge-danger side-badge {{ $DashtotalCount == 0 ?'d-none':'' }}">{{ $DashtotalCount }}</span>
                                </a>
                            </div>
                            @endif
                            <div class="dropdown profile-dropdown">
                                <a  href="javascript:void(0);" class="nav-link pe-1 ps-0 leading-none" data-bs-toggle="dropdown">
                                    <span>
                                        <img src="{{ admin()?->photo??url('dashboard/assets/img/admin.png') }}" alt="img" class="avatar avatar-md bradius">
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow animated">
                                    <div class="p-3 text-center border-bottom">
                                        <a href="{{dash('admin/profile')}}" class="text-center user pb-0 font-weight-bold">{{ admin()?->name }}</a>
                                        <p class="text-center user-semi-title">{{ admin()?->admingroup?->name }}</p>
                                    </div>
                                    {{--  <a class="dropdown-item d-flex" href="profile-1.html">
                                        <i class="feather feather-user me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Profile</div>
                                    </a>  --}}
                                    {{--  <a class="dropdown-item d-flex" href="editprofile.html">
                                        <i class="feather feather-settings me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Settings</div>
                                    </a>  --}}
                                    {{--  <a class="dropdown-item d-flex" href="chat.html">
                                        <i class="feather feather-mail me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Messages</div>
                                    </a>  --}}

                                    {{--  <a class="dropdown-item d-flex"  href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#changepasswordnmodal">
                                        <i class="feather feather-edit-2 me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">Change Password</div>
                                    </a>  --}}

                                    <a class="dropdown-item d-flex" href="{{ dash('logout') }}?lang={{request('lang')}}">
                                        <i class="feather feather-power me-3 fs-16 my-auto"></i>
                                        <div class="mt-1">@lang('dash::dash.logout')</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
