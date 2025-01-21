
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

  var labels = '';
  // URL
  var generateUrl = '{{ url(app('dash')['DASHBOARD_PATH'].'/resource') }}/{{ $resourceName }}';

   for(i=0;i < data.{{ $method }}.length;i++){
    // add ID segment for url
    var fullURL = generateUrl+'/'+data.{{ $method }}[i].id;
      if(data.{{ $method }}[i].{{ $colname }} !== undefined){
        labels += '<li><a href="'+fullURL+'">'+data.{{ $method }}[i].{{ $colname }}+'</a></li>';
      }else{
        labels += '<li><a href="'+fullURL+'">'+data.{{ $method }}[i].id+'</a></li>';
      }
    }
    return `<ol>`+labels+`</ol>`;
  {{-- Render End --}}
    }