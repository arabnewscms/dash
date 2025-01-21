<div class="sticky">
    <aside class="app-sidebar">
        <div class="app-sidebar__logo">
            <a class="header-brand" href="{{ dash('/') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img desktop-lgo" style="max-height:41px" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img dark-logo" style="max-height:41px" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img mobile-logo" style="max-height:41px" alt="{{ env('APP_NAME') }}">
                <img src="{{ $DASHBOARD_ICON }}" class="header-brand-img darkmobile-logo" style="max-height:41px" alt="{{ env('APP_NAME') }}">
            </a>
        </div>
        <div class="app-sidebar3">
            <div class="main-menu">
                <div class="app-sidebar__user d-none">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src="{{ admin()?->photo??url('dashboard/assets/img/admin.png') }}" alt="user-img" class="avatar-xxl rounded-circle mb-1">
                        </div>
                        <div class="user-info">
                            <h5 class=" mb-2">{{ admin()?->name }}</h5>
                            <span class="text-muted app-sidebar__user-name text-sm">{{ admin()?->admingroup?->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
                <ul class="side-menu">

<li class="slide">
    <a href="{{ dash('dashboard') }}?lang={{request('lang')}}" class="side-menu__item   {{ request()->segment(2) == 'dashboard'?'active':'' }}">
    <i class="fa fa-dashboard sidemenu_icon"></i>
     <span class="side-menu__label">@lang('dash::dash.dashboard')</span>
    </a>
</li>


@if(isset($loadInNavigationPagesMenu['top']) && !empty($loadInNavigationPagesMenu['top']))
<!-- Pages top Start  -->
@foreach($loadInNavigationPagesMenu['top'] as $page)
@if($page['displayInMenu'])
      <li class="slide">
        <a href="{{ url($DASHBOARD_PATH.'/page/'.$page['RouteName']) }}?lang={{request('lang')}}" class="side-menu__item {{ request()->segment(3) == $page['RouteName']?'active':'' }}">
           <i class="sidemenu_icon">
               {!! $page['icon'] !!}
            </i>
            <span class="side-menu__label">
            @if(trans()->has($page['pageName']))
            {{ __($page['pageName']) }}
            @else
            {{ $page['pageName']??ucfirst($page['RouteName']) }}
            @endif
        </span>
        </a>
    </li>
@endif
@endforeach
<!-- Pages top End-->
@endif


<?php
$x = 0;

?>
@foreach($loadInNavigationMenu as $groups)
@php
 $active_group = [];
if(array_key_exists($x,$groups) && isset($groups[$x]) && in_array('group',$groups[$x])){

  foreach($groups as $key=>$val){
    $active_group  = array_merge($active_group,$groups);
   }

  $parent_menu = explode('.',$groups[$x]['group'])[0];
}elseif(!empty($groups[array_keys($groups)[0]][0]['group'])){

  foreach(array_keys($groups) as $key=>$val){
   $active_group = array_merge($active_group,$groups[array_keys($groups)[$key]]);
  }

  $parent_menu = explode('.',$groups[array_keys($groups)[0]][0]['group'])[0];
}else{
  $parent_menu = null;
}

// Load All Groups
if(!empty(array_keys($groups)) && count(array_keys($groups)) > 0){
    foreach(array_keys($groups) as $key=>$val){
        $active_group = array_merge($active_group,$groups[array_keys($groups)[$key]]);
    }
}


@endphp

@if(!is_null($parent_menu))
<li class="side-item side-item-category mt-4">
    {{ trans()->has('dash.'.$parent_menu)? __('dash.'.$parent_menu): ucfirst($parent_menu) }}
</li>
@php
$dash_active_collapse =  in_array(request()->segment(3),array_column($active_group,'resourceName'));
$dash_arrow = app()->getLocale()=='ar'?'fa-bars-staggered':'fa-bars-staggered';
@endphp
<li class="slide {{ $dash_active_collapse?'is-expanded':'' }}">
    <a class="side-menu__item {{ $dash_active_collapse?'active':'' }}" data-bs-toggle="slide"  href="javascript:void(0);">
        <i class="sidemenu_icon">
            {!! array_column($groups,'icon')[0]??'<i class="fa-solid '.$dash_arrow.' fa-xs"></i>' !!}
        </i>
    <span class="side-menu__label">
        {{ trans()->has('dash.'.$parent_menu)?
        trans('dash.'.$parent_menu):
        ucfirst($parent_menu) }}
    </span><i class="angle fa {{ app()->getLocale() != 'en'?'fa-angle-left':'fa-angle-right' }}"></i>
    </a>

    <ul class="slide-menu {{ $dash_active_collapse?'open':'' }}">
        <li class="side-menu-label1"><a href="javascript:void(0);">Dashboards</a></li>


   @foreach($groups as $group)
    @if(isset($group['displayInMenu']) && $group['displayInMenu'])
    <li class="sub-slide {{ request()->segment(3) == $group['resourceName']?'is-expanded':'' }}">
        <a href="{{ url($DASHBOARD_PATH.'/resource/'.$group['resourceName']) }}?lang={{request('lang')}}" class="sub-side-menu__item
        {{ request()->segment(3) == $group['resourceName']?'active is-expanded':'' }}">

            <i class="sidemenu_icon">
                {!! $group['icon']??'' !!}
            </i>

        @if(trans()->has($group['customName']))
        {{ __($group['customName']) }}
        @else
        {{ $group['customName']??ucfirst($group['group']) }}
        @endif
        </a>
    </li>

    @elseif(!isset($group['displayInMenu']) && empty($group['displayInMenu']))
    {{--  Sub Menu Level  --}}
    @php
    $submenuName = count(explode('.',$group[$x]['group'])) > 0?explode('.',$group[$x]['group'])[1]:$group[$x]['group'];
    $active_group = $group;

    $dash_active_collapse_sub =  in_array(request()->segment(3),array_column($active_group,'resourceName'));
    $dash_arrow_sub = app()->getLocale()=='ar'?'fa-bars-staggered':'fa-bars-staggered';

    @endphp
    <li class="sub-slide {{ $dash_active_collapse_sub?'is-expanded':'' }}">
        <a class="sub-side-menu__item {{ $dash_active_collapse_sub?'active is-expanded':'' }}" data-bs-toggle="sub-slide"  href="javascript:void(0);">
            <i class="sidemenu_icon">
                {!! array_column($group,'icon')[0]??'<i class="fa-solid '.$dash_arrow_sub.' fa-xs"></i>' !!}
            </i>

         <span class="sub-side-menu__label"> {{ trans()->has('dash.'.$submenuName)?
            trans('dash.'.$submenuName):
            ucfirst($submenuName) }}
        </span>
        <i class="sub-angle fa {{ app()->getLocale() != 'en'?'fa-angle-left':'fa-angle-right' }}"></i>
        </a>

    {{--  <ul class="list-unstyled {{ app()->getLocale() == 'ar'?'me-1':'ms-1' }} collapse multi-collapse {{ $dash_active_collapse_sub?'show':'' }}" id="{{ str_replace(' ','_',$submenuName) }}">  --}}
        <ul class="sub-slide-menu">
        @foreach($group as $subgroups)
        @if(isset($subgroups['displayInMenu']) && $subgroups['displayInMenu'])
        <li>
            <a href="{{ url($DASHBOARD_PATH.'/resource/'.$subgroups['resourceName']) }}?lang={{request('lang')}}" class="sub-slide-item {{ request()->segment(3) == $subgroups['resourceName']?'active':'' }}">
                <i class="sidemenu_icon">
                    {!! $subgroups['icon']??'' !!}
                </i>

            @if(trans()->has($subgroups['customName']))
            {{ __($subgroups['customName']) }}
            @else
            {{ $subgroups['customName']??ucfirst($subgroups['group']) }}
            @endif
        </a></li>


        @endif
    @endforeach
       </li>
    </ul>
    {{--  Sub Menu Level  --}}
    @endif

    @endforeach
</ul>
</li>

<?php $x = 0;?>
@endif
    {{-- endif not Null statement menu   --}}


@endforeach


@if(isset($loadInNavigationPagesMenu['bottom']) && !empty($loadInNavigationPagesMenu['bottom']))
<!-- Pages bottom Start  -->
@foreach($loadInNavigationPagesMenu['bottom'] as $page)
@if($page['displayInMenu'])
      <li class="slide">
        <a href="{{ url($DASHBOARD_PATH.'/page/'.$page['RouteName']) }}" class="side-menu__item {{ request()->segment(3) == $page['RouteName']?'active':'' }}">
            <i class="sidemenu_icon">
                {!! $page['icon'] !!}
             </i>
            <span class="side-menu__label">
            @if(trans()->has($page['pageName']))
            {{ __($page['pageName']) }}
            @else
            {{ $page['pageName']??ucfirst($page['RouteName']) }}
            @endif
            </span>
        </a>
    </li>
@endif
@endforeach
<!-- Pages bottom End-->
@endif
 </ul>

                <div class="slide-right" id="slide-right">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg>

                </div>
                @include('dash::dash_update_checker')
            </div>
        </div>
    </aside>
</div>
