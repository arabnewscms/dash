@php
$searchIndex = 0;
@endphp
<div style="text-align: {{ app()->getLocale() == 'ar'?'right':'left' }};">

  @foreach($output as $key=>$value)


    @if(!empty($value['data']) && count($value['data']) > 0)
  <div class="border-bottom m-2 p-1">
    <h6><i class="material-icons-round opacity-10" style="font-size: 17px;">{!! $value['icon'] !!}</i> {{ $value['stringName'] }} </h6>
    @foreach($value['data'] as $dataKey=>$dataValue)

     @if($value['hasTranslate'] == 'yes')
     <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$key.'/'.$dataValue->id) }}?lang={{request('lang')}}" class = "list-group-item">
      {{ $dataValue->{$value['title']} }}
      </a>
      @else
      <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$key.'/'.$dataKey) }}?lang={{request('lang')}}" class = "list-group-item">
        {{ $dataValue }}
      </a>
     @endif
    @php
$searchIndex++;
@endphp
    @endforeach
  </div>


  @endif
  @endforeach

  @if($searchIndex == 0)
   <center><i class="fa fa-search"></i> {{ __('dash::dash.search_not_found') }}</center>
  @endif
</div>
