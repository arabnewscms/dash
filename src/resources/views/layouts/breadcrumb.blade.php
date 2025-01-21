 <!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url($DASHBOARD_PATH) }}/dashboard?lang={{ app()->getLocale() }}">@lang('dash::dash.dashboard')</a>
                </li>
                @if (!empty($breadcrumb) && is_array($breadcrumb) && count($breadcrumb) > 0)
                    @foreach ($breadcrumb as $bread)
                        <li class="breadcrumb-item">
                            <a href="{{ $bread['url'] }}?lang={{ app()->getLocale() }}" title="{{ $bread['name'] }}">
                                @if(strlen($bread['name']) > 100)
                                    @php
                                        $short_message = Str::limit($bread['name'], 100, '...');
                                    @endphp
                                    {{ $short_message }}
                                @else
                                    {{ $bread['name'] }}
                                @endif
                            </a>
                        </li>
                    @endforeach
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $title ?? $APP_NAME }}</li>
            </ol>
        </nav>
    </div>
    <h1 class="page-title fw-semibold fs-18 mb-0">{{ $title ?? $APP_NAME }}</h1>
</div>
<!-- Page Header Close -->
