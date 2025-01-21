 <div class="row">
     <div class="col-12">
         {{ strip_tags($title) ?? '' }}
     </div>
     @foreach ($fields as $field)
         @if ($field['show_rules']['showInShow'])
             {{-- Start Show statement --}}
             @php
                 $col = isset($field['column']) ? $field['column'] : '12';
             @endphp
             <div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 p-2">
                 @php
                     if (isset($field['onShow'])) {
                         $data->{$field['attribute']} = $field['onShow'];
                     }
                 @endphp
                 @if ($field['type'] == 'image')
                     @include('dash::resource.show.media.image')
                 @elseif($field['type'] == 'video')
                     @include('dash::resource.show.media.video')
                 @elseif($field['type'] == 'audio')
                     @include('dash::resource.show.media.audio')
                 @elseif($field['type'] == 'file')
                     @include('dash::resource.show.media.file')
                 @elseif($field['type'] == 'morphTo')
                     @include('dash::resource.show.relationColumn.morphTo')
                 @elseif($field['type'] == 'belongsTo')
                     @include('dash::resource.show.relationColumn.belongsTo')
                 @elseif($field['type'] == 'hasOne')
                     @include('dash::resource.show.relationColumn.hasOne')
                 @elseif($field['type'] == 'morphOne')
                     @include('dash::resource.show.relationColumn.morphOne')
                 @elseif($field['type'] == 'hasOneThrough')
                     @include('dash::resource.show.relationColumn.hasOneThrough')
                 @elseif($field['type'] == 'belongsToMany')
                     @include('dash::resource.show.relationColumn.belongsToMany')
                 @elseif($field['type'] == 'select')
                     <bdi>{{ $field['name'] }}</bdi> : <span>{!! $field['options'][$data->{$field['attribute']}] ?? '-' !!}</span>
                 @elseif($field['type'] == 'ckeditor')
                     @include('dash::resource.show.columnsAndElements.ckeditor')
                 @elseif($field['type'] == 'customHtml')
                     @if (isset($field['view']))
                         @include($field['view'], ['page' => 'show', 'model' => $data])
                     @endif
                 @elseif($field['type'] == 'dropzone')
                     @include('dash::resource.show.dropzone')
                 @elseif($field['type'] == 'text')
                     @include('dash::resource.show.columnsAndElements.text')
                 @elseif($field['type'] == 'textarea')
                     @include('dash::resource.show.columnsAndElements.textarea')
                 @elseif($field['type'] == 'checkbox')
                     <bdi> {{ $field['name'] }} </bdi> :
                     @if (isset($field['trueVal']) && isset($field['falseVal']))
                         @if ($field['trueVal'] == $data->{$field['attribute']})
                             <i class="fa-solid fa-square-check text-success"></i>
                         @else
                             <i class="fa-solid fa-xmark  text-danger"></i>
                         @endif
                     @else
                         {!! $data->{$field['attribute']} !!}
                     @endif
                 @elseif(!in_array($field['type'], $relationTypes))
                     <bdi>{{ $field['name'] }}</bdi> : <span>{!! $data->{$field['attribute']} ?? '-' !!}</span>
                 @endif
             </div>
             {{-- End Show statement --}}
         @endif
     @endforeach
 </div>
