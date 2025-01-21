<!-- Start::app-sidebar -->
<aside class="app-sidebar sticky" id="sidebar">
    <!-- Start::main-sidebar-header -->
    <div class="main-sidebar-header">
        <a href="{{ dash('dashboard?lang=' . request('lang')) }}" class="header-logo">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="desktop-logo">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="toggle-logo">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="desktop-dark">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="toggle-dark">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="desktop-white">
            <img src="{{ $DASHBOARD_ICON }}" alt="{{ env('APP_NAME') }}" class="toggle-white">
        </a>
    </div>
    <!-- End::main-sidebar-header -->
    <!-- Start::main-sidebar -->
    <div class="main-sidebar" id="sidebar-scroll">
        <!-- Start::nav -->
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <div class="slide-left" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"></path>
                </svg>
            </div>
            <ul class="main-menu">
                <!-- Start::slide__category -->
                {{-- <li class="slide__category"><span class="category-name">Main</span></li> --}}
                <!-- End::slide__category -->

                <!-- عرض Dashboard -->
                <li class="slide">
                    <a href="{{ dash('dashboard') }}?lang={{ request('lang') }}"
                        class="side-menu__item {{ request()->segment(2) == 'dashboard' ? 'active' : '' }}">
                        <i class="fas fa-home side-menu__icon"></i>
                        <span class="side-menu__label ms-2 pt-1"> @lang('dash::dash.dashboard') </span>
                    </a>
                </li>

                <!-- عرض القوائم العلوية (Top Pages) -->
                @if (isset($loadInNavigationPagesMenu['top']) && !empty($loadInNavigationPagesMenu['top']))
                    @foreach ($loadInNavigationPagesMenu['top'] as $page)
                        @if ($page['displayInMenu'])
                            <li class="slide">
                                <a href="{{ url($DASHBOARD_PATH . '/page/' . $page['RouteName']) }}?lang={{ request('lang') }}"
                                    class="side-menu__item {{ request()->segment(3) == $page['RouteName'] ? 'active' : '' }}">
                                    <i class="side-menu__icon">{!! $page['icon'] ?? '<i class="fas fa-file "></i>' !!}</i>
                                    <span class="side-menu__label ms-2 pt-1">
                                        @if (trans()->has($page['pageName']))
                                            {{ __($page['pageName']) }}
                                        @else
                                            {{ $page['pageName'] ?? ucfirst($page['RouteName']) }}
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
                <?php
                $x = 0;
                ?>
                <!-- عرض القوائم الديناميكية -->
                @foreach ($loadInNavigationMenu as $groups)
                    @php
                        $active_group = [];
                        if (array_key_exists($x, $groups) && isset($groups[$x]) && in_array('group', $groups[$x])) {
                            foreach ($groups as $key => $val) {
                                $active_group = array_merge($active_group, $groups);
                            }

                            $parent_menu = explode('.', $groups[$x]['group'])[0];
                        } elseif (!empty($groups[array_keys($groups)[0]][0]['group'])) {
                            foreach (array_keys($groups) as $key => $val) {
                                $active_group = array_merge($active_group, $groups[array_keys($groups)[$key]]);
                            }

                            $parent_menu = explode('.', $groups[array_keys($groups)[0]][0]['group'])[0];
                        } else {
                            $parent_menu = null;
                        }

                        // Load All Groups
                        if (!empty(array_keys($groups)) && count(array_keys($groups)) > 0) {
                            foreach (array_keys($groups) as $key => $val) {
                                $active_group = array_merge($active_group, $groups[array_keys($groups)[$key]]);
                            }
                        }

                    @endphp

                    @if ($parent_menu)
                        <!-- عرض القائمة الرئيسية -->
                        <li class="slide__category"><span
                                class="category-name">{{ trans()->has('dash.' . $parent_menu) ? __('dash.' . $parent_menu) : ucfirst($parent_menu) }}</span>
                        </li>
                        @php
                            $dash_active_collapse = in_array(
                                request()->segment(3),
                                array_column($active_group, 'resourceName'),
                            );
                            $dash_arrow = app()->getLocale() == 'ar' ? 'fa-bars-staggered' : 'fa-bars-staggered';
                        @endphp

                        <!-- عرض العناصر الفرعية -->
                        <li class="slide has-sub {{ $dash_active_collapse ? 'active open' : '' }}">
                            <a class="side-menu__item {{ $dash_active_collapse ? 'active' : '' }}"
                                data-bs-toggle="slide" href="javascript:void(0);">
                                <i class=" side-menu__icon">
                                    {!! $groups[0]['icon'] ?? '<i class="fa-solid fa-bars-staggered fa-xs"></i>' !!}
                                </i>
                                <span class="side-menu__label ms-2 pt-1">
                                    {{ trans()->has('dash.' . $parent_menu) ? trans('dash.' . $parent_menu) : ucfirst($parent_menu) }}
                                </span>
                                <i class="fas fa-chevron-right side-menu__angle"></i>
                            </a>

                            <ul class="slide-menu child1 {{ $dash_active_collapse ? 'active' : '' }}">
                                @foreach ($groups as $group)
                                    @if (isset($group['displayInMenu']) && $group['displayInMenu'])
                                        <li class="slide {{ $dash_active_collapse ? 'active' : '' }}">
                                            <a href="{{ url($DASHBOARD_PATH . '/resource/' . $group['resourceName']) }}?lang={{ request('lang') }}"
                                                class="side-menu__item {{ request()->segment(3) == $group['resourceName'] ? 'active' : '' }}">
                                                <i class=" side-menu__icon">
                                                    {!! $group['icon'] ?? '' !!}
                                                </i>
                                                <span class="side-menu__label ms-2 pt-1">
                                                    @if (trans()->has($group['customName']))
                                                        {{ __($group['customName']) }}
                                                    @else
                                                        {{ $group['customName'] ?? ucfirst($group['group']) }}
                                                    @endif
                                                </span>
                                                <i class="fas fa-chevron-right side-menu__angle"></i>
                                            </a>
                                        </li>
                                    @elseif(!isset($group['displayInMenu']) && empty($group['displayInMenu']))
                                        {{--  Sub Menu Level  --}}
                                        @php
                                            $submenuName =
                                                count(explode('.', $group[$x]['group'])) > 0
                                                    ? explode('.', $group[$x]['group'])[1]
                                                    : $group[$x]['group'];
                                            $active_group = $group;

                                            $dash_active_collapse_sub = in_array(
                                                request()->segment(3),
                                                array_column($active_group, 'resourceName'),
                                            );
                                            $dash_arrow_sub =
                                                app()->getLocale() == 'ar' ? 'fa-bars-staggered' : 'fa-bars-staggered';

                                        @endphp
                                        {{-- Sub Sub Start --}}
                                        <li class="slide has-sub {{ $dash_active_collapse_sub ? 'active open' : '' }}">
                                            <a class="side-menu__item {{ $dash_active_collapse_sub ? 'active' : '' }}"
                                                data-bs-toggle="slide" href="javascript:void(0);">
                                                <i class=" side-menu__icon">
                                                    {!! $group[0]['icon'] ?? '<i class="fa-solid fa-bars-staggered fa-xs"></i>' !!}
                                                </i>

                                                <span class="sub-side-menu__label">
                                                    {{ trans()->has('dash.' . $submenuName) ? trans('dash.' . $submenuName) : ucfirst($submenuName) }}
                                                </span>
                                                <i class="fas fa-chevron-right side-menu__angle"></i>
                                            </a>

                                            {{--  <ul class="list-unstyled {{ app()->getLocale() == 'ar'?'me-1':'ms-1' }} collapse multi-collapse {{ $dash_active_collapse_sub?'show':'' }}" id="{{ str_replace(' ','_',$submenuName) }}">  --}}
                                            <ul class="slide-menu child2">

                                                @foreach ($group as $subgroups)
                                                    @if (isset($subgroups['displayInMenu']) && $subgroups['displayInMenu'])
                                                        <li
                                                            class="slide {{ request()->segment(3) == $subgroups['resourceName'] ? 'active' : '' }}">
                                                            <a href="{{ url($DASHBOARD_PATH . '/resource/' . $subgroups['resourceName']) }}?lang={{ request('lang') }}"
                                                                class="side-menu__item {{ request()->segment(3) == $subgroups['resourceName'] ? 'active' : '' }}">
                                                                <i class="sidemenu_icon">
                                                                    {!! $subgroups['icon'] ?? '' !!}
                                                                </i>
                                                                <span class="side-menu__label ms-1 pt-1">
                                                                    @if (trans()->has($subgroups['customName']))
                                                                        {{ __($subgroups['customName']) }}
                                                                    @else
                                                                        {{ $subgroups['customName'] ?? ucfirst($subgroups['group']) }}
                                                                    @endif
                                                                </span>
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        {{-- Sub Sub End --}}
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach

                <!-- عرض القوائم السفلية (Bottom Pages) -->
                @if (isset($loadInNavigationPagesMenu['bottom']) && !empty($loadInNavigationPagesMenu['bottom']))
                    @foreach ($loadInNavigationPagesMenu['bottom'] as $page)
                        @if ($page['displayInMenu'])
                            <li class="slide">
                                <a href="{{ url($DASHBOARD_PATH . '/page/' . $page['RouteName']) }}?lang={{ request('lang') }}"
                                    class="side-menu__item {{ request()->segment(3) == $page['RouteName'] ? 'active' : '' }}">
                                    <i class="side-menu__icon">{!! $page['icon'] ?? '<i class="fas fa-file"></i>' !!}</i>
                                    <span class="side-menu__label ms-2 pt-1">
                                        @if (trans()->has($page['pageName']))
                                            {{ __($page['pageName']) }}
                                        @else
                                            {{ $page['pageName'] ?? ucfirst($page['RouteName']) }}
                                        @endif
                                    </span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24"
                    viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </nav>
        <!-- End::nav -->
    </div>
    <!-- End::main-sidebar -->
</aside>
<!-- End::app-sidebar -->
