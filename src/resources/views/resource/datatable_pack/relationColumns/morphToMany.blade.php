"data": null,
orderable: false,
searchable:false,
render: function(data,type,full,meta){
  {{-- Render Start --}}
@php
$listColumns = [];
foreach($field['tags'] as $method=>$tag){
  if(is_string($tag)){
    if(class_exists($tag)){
      $listColumns[$tag] = [
        'method'=>$method,
        'column'=>$tag::$title,
        'label'=>$tag::customName()??resourceShortName($tag)
      ];
    }
  }elseif(is_array($tag)){
    if(isset($tag['resource']) && class_exists($tag['resource'])){
      // detect label
        if(isset($tag['label'])){
          $label = $tag['label'];
        }elseif(!empty($tag['resource']::customName())){
          $label = $tag['resource']::customName();
        }else{
          $label = resourceShortName($tag['resource']);
        }

        $listColumns[$tag['resource']] = [
          'method'=>$method,
          'column'=>$tag['resource']::$title,
          'label'=>$label
        ];
    }
  }
}
@endphp

var labels = '';
@foreach($listColumns as $resource=>$array)
@php
$resourceName = resourceShortName($resource);
@endphp
if(data.{{ $array['method']}} != undefined && data.{{ $array['method']}}.length > 0){

  labels += '<b>{{ $array['label'] }}</b><ol>';
    // get data from releation method in this loop
  for(i=0;i < data.{{ $array['method']}}.length;i++){
    var field = data.{{ $array['method']}}[i];
    var fullURL = '{{ url(app('dash')['DASHBOARD_PATH'].'/resource') }}/{{ $resourceName }}/'+field.id;
      labels  +='<li><a href="'+fullURL+'">'+field.{{ $array['column'] }}+'</a></li>';
  }
      labels +='</ol>';
}
  @endforeach
     return labels != ''?labels:'-';


  {{-- Render End --}}
}