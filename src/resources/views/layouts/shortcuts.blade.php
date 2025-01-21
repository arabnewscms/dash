    <!-- Start::header-element -->
    <div class="header-element header-shortcuts-dropdown">
        <!-- Start::header-link|dropdown-toggle -->
        <a href="javascript:void(0);" class="header-link dropdown-toggle" data-bs-toggle="dropdown"
            data-bs-auto-close="outside" id="notificationDropdown" aria-expanded="false">
            <i class="fa-solid fa-paperclip header-link-icon pulse"></i>
        </a>
        <!-- End::header-link|dropdown-toggle -->
        <!-- Start::main-header-dropdown -->
        <div class="main-header-dropdown header-shortcuts-dropdown dropdown-menu pb-0 dropdown-menu-end"
            aria-labelledby="notificationDropdown">
            <div class="p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <p class="mb-0 fs-17 fw-semibold">@lang('dash::dash.quick_action')</p>
                </div>
            </div>
            <div class="dropdown-divider mb-0"></div>
            <div class="main-header-shortcuts p-2" id="header-shortcut-scroll">
                <div class="row g-2">
                    @if (isset($loadInNavigationPagesMenu['top']) && !empty($loadInNavigationPagesMenu['top']))
                        @foreach ($loadInNavigationPagesMenu['top'] as $page)
                            @if ($page['displayInMenu'])
                                <div class="col-4">
                                    <a
                                        href="{{ url($DASHBOARD_PATH . '/page/' . $page['RouteName']) }}?lang={{ request('lang') }}">
                                        <div class="text-center p-3 related-app">
                                            <span class="avatar avatar-sm avatar-rounded">
                                                {!! $page['icon'] ?? '<i class="fas fa-file"></i>' !!}
                                            </span>
                                            <span class="d-block fs-10"><i class="fa fa-plus"></i>
                                                @if (trans()->has($page['pageName']))
                                                    {{ __($page['pageName']) }}
                                                @else
                                                    {{ $page['pageName'] ?? ucfirst($page['RouteName']) }}
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @foreach ($loadInNavigationMenu as $groups)
                        @foreach ($groups as $item)
                            @if (isset($item['displayInMenu']) && $item['displayInMenu'])
                                <div class="col-4">
                                    <a
                                        href="{{ url($DASHBOARD_PATH . '/resource/' . $item['resourceName']) }}/new?lang={{ request('lang') }}">
                                        <div class="text-center p-3 related-app">
                                            <span class="avatar avatar-sm avatar-rounded">
                                                {!! $item['icon'] ?? '' !!}
                                            </span>
                                            <span class="d-block fs-10"><i class="fa fa-plus"></i>
                                                @if (trans()->has($item['customName']))
                                                    {{ __($item['customName']) }}
                                                @else
                                                    {{ $item['customName'] ?? ucfirst($item['group']) }}
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endforeach

                    @if (isset($loadInNavigationPagesMenu['bottom']) && !empty($loadInNavigationPagesMenu['bottom']))
                        @foreach ($loadInNavigationPagesMenu['bottom'] as $page)
                            @if ($page['displayInMenu'])
                                <div class="col-4">
                                    <a
                                        href="{{ url($DASHBOARD_PATH . '/page/' . $page['RouteName']) }}?lang={{ request('lang') }}">
                                        <div class="text-center p-3 related-app">
                                            <span class="avatar avatar-sm avatar-rounded">
                                                {!! $page['icon'] ?? '<i class="fas fa-file"></i>' !!}
                                            </span>
                                            <span class="d-block fs-10"><i class="fa fa-plus"></i>
                                                @if (trans()->has($page['pageName']))
                                                    {{ __($page['pageName']) }}
                                                @else
                                                    {{ $page['pageName'] ?? ucfirst($page['RouteName']) }}
                                                @endif
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    @endif






                </div>
            </div>
            {{-- <div class="p-3 border-top">
    <div class="d-grid">
        <a href="javascript:void(0);" class="btn btn-primary">View All</a>
    </div>
</div> --}}
        </div>
        <!-- End::main-header-dropdown -->
    </div>
    <!-- End::header-element -->
