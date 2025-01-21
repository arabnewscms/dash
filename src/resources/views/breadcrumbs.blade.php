<div class="{{ app()->getLocale() != 'ar' ? 'page-rightheader' : 'page-leftheader' }}">
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <ol class="breadcrumb1">
                <li class="breadcrumb-item1"><a href="{{ url($DASHBOARD_PATH) }}">@lang('dash::dash.dashboard')</a></li>
                @if (!empty($breadcrumb) && is_array($breadcrumb) && count($breadcrumb) > 0)
                    @foreach ($breadcrumb as $bread)
                        <li class="breadcrumb-item1">
                            <a href="{{ $bread['url'] }}" title="{{$bread['name']}}">
                                @if(strlen($bread['name']) > 100)
                                @php
                                    $short_message = Str::limit($bread['name'], 100, '...');
                                @endphp
                                {{ $short_message }}
                                @else
                                {{$bread['name']}}
                                @endif

                            </a>
                        </li>
                    @endforeach
                @else
                    {{--  <li class="breadcrumb-item1 active">{{ $breadcrumb ?? $APP_NAME }}</li>  --}}
                @endif
                {{-- <li class="breadcrumb-item1 active"> {{ $title ?? $APP_NAME }}</li> --}}
            </ol>
        </div>
    </div>
</div>
<div class="{{ app()->getLocale() == 'ar' ? 'page-rightheader' : 'page-leftheader' }}  ms-md-auto">
    <div class="page-title">

        {{ $APP_NAME }}
    </div>
</div>
