@if(!empty($dash_notifications) && count($dash_notifications))
<li class="nav-item dropdown px-2 d-flex align-items-center mr-3">
  <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fa fa-bell fa-2x cursor-pointer"></i>
    @php
    $DashtotalCount=0;
    foreach($dash_notifications as $dash_count){
    $DashtotalCount = $DashtotalCount + $dash_count::unreadCount();
    }
    @endphp


<div class="sidebar sidebar-right sidebar-animate">
    <div class="card-header border-bottom pb-5">
        <h4 class="card-title"> <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/page/Notifications') }}?lang={{request('lang')}}">
            {{ __('dash::dash.Show_All_Notifications') }}
        - ({{ $DashtotalCount }})
        </a> </h4>
        <div class="card-options">
            <a  href="javascript:void(0);" class="btn btn-sm btn-icon btn-light text-primary"  data-bs-toggle="sidebar-right" data-bs-target=".sidebar-right"><i class="feather feather-x"></i> </a>
        </div>
    </div>
    <div class="">
     @foreach($dash_notifications as $dash_notify)
      {!! $dash_notify::content() !!}
     @endforeach
    </div>
</div>


@push('js')
<script type="text/javascript">
var dashUrl  = '{{ url('') }}';
var dashPath = '{{ app('dash')['DASHBOARD_PATH'] }}';
var _token   = '{{ csrf_token() }}';
</script>

@foreach($dash_notifications as $dash_notify)
  @foreach($dash_notify::stack() as $key=>$value)
    @if($key == 'blade')
      @foreach($value as $stackBlade)
        @includeIf($stackBlade)
      @endforeach
    @endif
    @if($key == 'js')
      @foreach($value as $stackJs)
      <script type="text/javascript" src="{{ $stackJs }}"></script>
      @endforeach
    @endif

  @endforeach
@endforeach

@endpush

@endif

