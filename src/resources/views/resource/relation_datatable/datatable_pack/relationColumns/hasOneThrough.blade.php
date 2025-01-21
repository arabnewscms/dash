"data": null,
orderable: false,
searchable:false,
render: function(data,type,full,meta){
  {{-- Render Start --}}
@php
$method = $field['attribute'];
$colname = $field['resource']::$title;
$resourceName = resourceShortName($field['resource']);
@endphp
  // prepare Field
  var field = data.{{ $method }};
  if(field != undefined || field != null){
  var fullURL = '{{ url(app('dash')['DASHBOARD_PATH'].'/resource') }}/{{ $resourceName }}/'+field.id;
    return '<a href="'+fullURL+'">'+field.{{ $colname }}+'</a>';
  }else{
   return  '-';
  }
  {{-- Render End --}}
}