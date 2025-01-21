@if($multiSelectRecord)
      { "data":null,
        orderable:false,
        searchable:false,
        targets:0,
        render: function(data,type,full,meta){
          return `
         <input class="form-check-input selectID{{ $resourceName }}" type="checkbox" value="`+data.id+`">
          `;
        }
      },
@endif

    @foreach($fields as $field)
    @if($field['show_rules']['showInIndex'])

      @if($field['type'] == 'customHtml')
        {
        "data":null,
        orderable:false,
        searchable:false,
        render: function(data,type,full,meta){
            @if(isset($field['hasOneDatatable']) && !empty($field['hasOneDatatable']))
             return data?.{{ str_replace('.','?.',$field['hasOneDatatable']) }};
            @else
            return '<center>-</center>';
            @endif
        }
      },
      @elseif($field['type'] == 'image')
      {
        "data":null,
        orderable:false,
        searchable:false,
        render: function(data,type,full,meta){
            var imageCol  = data?.{{ $field['attribute'] }};
            if(imageCol?.trim() != null && Object.keys(imageCol?.trim()).length > 0){
            var imageLink = getImageURL(imageCol);
            var modalbsid = "avatar_image_{{$field['attribute']}}_{{ $resourceName }}"+data.id;
            modalImage(imageLink,data.id,modalbsid);
            return `
            <img class="img-fluid rounded-circle img-thumbnail"
             src="`+imageLink+`" alt="image"
             style="cursor: pointer;width:48px;height:48px"
             data-bs-toggle="modal"
             data-bs-target="#`+modalbsid+`">
            `;
          }else{
            return '<center>-</center>';
          }
        }
      },
      @elseif($field['type'] == 'video')
        {
        "data":null,
        orderable:false,
        searchable:false,
        render: function(data,type,full,meta){
          if(data.{{ $field['attribute'] }} != null){
            var videoLink = getVideoURL(data.{{ $field['attribute'] }});
            var modalbsid = "avatar_video_{{$field['attribute']}}_{{ $resourceName }}"+data.id;
            modalVideo(videoLink,data.id,modalbsid);
            return `
            <a href="#void"
            data-bs-toggle="modal"
             data-bs-target="#`+modalbsid+`"
            ><i class="fa fa-video-camera"></i></a>
            `;
          }else{
            return '<center>-</center>';
          }
        }
      },
      @elseif($field['type'] == 'audio')
        {
        "data":null,
        orderable:false,
        searchable:false,
        render: function(data,type,full,meta){
          if(data.{{ $field['attribute'] }} != null){
            var audioLink = getaudioURL(data.{{ $field['attribute'] }});
            var modalbsid = "audio_box_{{$field['attribute']}}_{{ $resourceName }}"+data.id;
            modalAudio(audioLink,data.id,modalbsid);
            return `
            <a href="#void"
            data-bs-toggle="modal"
             data-bs-target="#`+modalbsid+`"
            ><i class="fa-solid fa-file-audio"></i></a>
            `;
          }else{
            return '<center>-</center>';
          }
        }
      },
      @elseif($field['type'] == 'file')
        {
        "data":null,
        orderable:false,
        searchable:false,
        render: function(data,type,full,meta){
          if(data.{{ $field['attribute'] }} != null){
             var audioLink = getaudioURL(data.{{ $field['attribute'] }});
             return `<a href="`+audioLink+`" target="_blank">
                      <i class="fa fa-download"></i>
                    </a>`;
          }else{
            return '<center>-</center>';
          }
        }
      },
      @elseif($field['type'] == 'checkbox')
        {
        "data":null,
        orderable: {{!$field['orderable']?'false':'true'}} ,
        searchable:{{!$field['searchable']?'false':'true' }},
        render: function(data,type,full,meta){
           var field = data.{{ $field['attribute'] }};
           @if(isset($field['trueVal']) && isset($field['falseVal']))
           if('{{ $field['trueVal'] }}' == field){
            return `<i class="fa-solid fa-square-check fa-2x text-success"></i>`;
           }else if('{{ $field['falseVal'] }}' == field){
            return `<i class="fa-solid fa-xmark  fa-2x text-danger"></i>`;
           }else{
            return '<center>-</center>';
           }
           @else
            return '<center>-</center>';
           @endif
        }
      },
      @elseif($field['type'] == 'select')
            {
        "data":null,
        orderable: {{!$field['orderable']?'false':'true'}} ,
        searchable:{{!$field['searchable']?'false':'true' }},
        render: function(data,type,full,meta){
           var options = {!! json_encode($field['options'],JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!};
           var field = data.{{ $field['attribute'] }};
           if(options !== null){
            return options[field]??field;
           }else {
            return field;
           }
        }
      },
      @elseif(in_array($field['type'], $relationTypes))
      {
//Relationship statement Start
@if($field['type'] == 'morphOne')
 @include('dash::resource.datatable_pack.relationColumns.morphOne')
@elseif($field['type'] == 'morphTo')
 @include('dash::resource.datatable_pack.relationColumns.morphTo')
@elseif($field['type'] == 'morphMany')
 @include('dash::resource.datatable_pack.relationColumns.morphMany')
@elseif($field['type'] == 'morphToMany')
 @include('dash::resource.datatable_pack.relationColumns.morphToMany')
@elseif($field['type'] == 'hasMany')
 @include('dash::resource.datatable_pack.relationColumns.hasMany')
@elseif($field['type'] == 'belongsToMany')
 @include('dash::resource.datatable_pack.relationColumns.belongsToMany')
@elseif($field['type'] == 'hasManyThrough')
 @include('dash::resource.datatable_pack.relationColumns.hasManyThrough')
@elseif($field['type'] == 'hasOneThrough')
 @include('dash::resource.datatable_pack.relationColumns.hasOneThrough')
@elseif($field['type'] == 'hasOne')
 @include('dash::resource.datatable_pack.relationColumns.hasOne')
@elseif($field['type'] == 'belongsTo')
 @include('dash::resource.datatable_pack.relationColumns.belongsTo')
@endif


//Relationship statement End
      },
      {{--  ViewColumns To View Other Columns From Relationships Start  --}}
      @if(isset($field['viewColumns']))

      @php
      $method = $field['attribute'];
      $colname = $field['resource']::$title;
      $resourceName = resourceShortName($field['resource']);
      @endphp
      @php
      if(is_array($field['viewColumns'][0])){
        $viewColumns = $field['viewColumns'][0];
      }elseif(is_string($field['viewColumns'][0])){
        $viewColumns = $field['viewColumns'];
      }
      @endphp
        @foreach($viewColumns as $k=>$v)
        {
          "data": null,
          orderable: false,
          searchable:false,
          render: function(data,type,full,meta){
            {{-- Render Start --}}

            // prepare Field
            var field = data.{{ $method }};
            if(field != undefined || field != null){
              return field?.{{ is_string($k)?$k:$v }};
            }else{
              return '<center>-</center>';
            }
            {{-- Render End --}}
          }
        },
        @endforeach
      @endif
      {{--  ViewColumns To View Other Columns From Relationships End  --}}

      @else
      {
           "data": null,
           orderable: {{!$field['orderable']?'false':'true'}},
           searchable:{{!$field['searchable']?'false':'true' }},
           render: function(data,type,full,meta){
              {{-- Render Start --}}

               if(data!=='null'){
                  if(data?.deleted_at != null){
                    return  ' <i class="fa fa-recycle fa-1x" style="color:#c33"></i> ' + data.{{ !empty($field['attribute'])?$field['attribute']:'id' }};
                  }else{
                    return   data.{{ !empty($field['attribute'])?$field['attribute']:'id' }};
                  }
               }else{
                  return  '-';
               }

             {{-- Render End --}}
           }
      },
      @endif
      {{-- End if Column Type --}}
      @endif
      {{-- End if rules show pages to index --}}
      @endforeach
      {

    orderable: false,
    "data": null,
    render:function (data, type, full, meta){
      var buttons = `
      @if($pagesRules['edit'])
      <a href='{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/edit/`+data.id+`?lang={{request('lang',app()->getLocale())}}' class='m-1'><i class='fa-regular fa-pen-to-square'></i></a>
      @endif
      @if($pagesRules['show'])
      <a href='{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/`+data.id+`?lang={{request('lang',app()->getLocale())}}' class='m-1' ><i class='fa-solid fa-eye'></i></a>
      @endif
      @if($pagesRules['destroy'])
      <a href="#" action='{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/`+data.id+`?lang={{request('lang',app()->getLocale())}}' rowid="`+data.id+`" class="m-1 deleteRow{{ $resourceName }}"><i class='fa-solid fa-trash-can'></i></a>
      @endif
      `;
      @if($pagesRules['restore'])
      if(data?.deleted_at != null){
      buttons +=`<a href="#void" action='{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/restore/`+data.id+`?lang={{request('lang',app()->getLocale())}}' rowid="`+data.id+`" class="m-1 restoreRow{{ $resourceName }}"><i class="fa fa-recycle fa-1x" style="color:#c33"></i><a>`;
      }
      @endif
      return buttons;
    },
    "defaultContent": "",
    //"targets": -1

  },
