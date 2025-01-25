@extends('dash::app')
@section('content')

    @php
        if (strlen($title) > 100) {
            $new_title = Str::limit($title, 100, '...');
        } else {
            $new_title = $title;
        }
    @endphp


    <div class="col-12">
        <div class="card text-dark">
            <div class="card-header p-2">
                <div class="col-md-8 float-start col-xs-12 col-sm-12">
                    <h6 class="text-dark card-title text-capitalize" title="{{ $title }}">{!! $resource['navigation']['icon'] ?? '' !!}
                        {{ strip_tags($new_title) ?? '' }} </h6>
                </div>
                <div class="col-md-4 float-end  pt-2 col-xs-12 col-sm-12">
                    <div class="float-end">
                        @if ($pagesRules['create'])
                            <a href="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/new') }}"
                                class="btn btn-success btn-sm">
                                <i class="fa fa-plus"></i>
                            </a>
                        @endif
                        @if ($pagesRules['edit'])
                            <a href="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/edit/' . $data->id) }}"
                                class="btn btn-light btn-sm">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endif
                        @if ($pagesRules['destroy'])
                            <a href="#void"
                                action="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/' . $data->id) }}"
                                rowid="{{ $data->id }}" class="btn btn-danger deleteRow{{ $resourceName }} btn-sm">
                                <i class="fa fa-trash"></i>
                            </a>
                            @push('js')
                                @include('dash::resource.relation_datatable.actions.row_delete', [
                                    'resourceName' => $resourceName,
                                ])
                            @endpush
                        @endif
                    </div>
                    @if (count($actions))
                        @include('dash::resource.relation_datatable.actions.show_actions')
                    @endif
                </div>
            </div>
            <div class="card-body p-3 pb-1">

                <div class="row">
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
                                    <bdi> {{ $field['name'] }} </bdi> &nbsp:
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
            </div>
        </div>
    </div>


    @foreach ($fields as $field)
        @if (!empty($field['show_rules']['showInShow']) && $field['show_rules']['showInShow'] === true)
            @php
                $relationManyTypes = array_diff($relationManyTypes, ['belongsToMany']);
            @endphp
            @if (in_array($field['type'], $relationManyTypes))
                @if (in_array($field['type'], ['hasMany', 'hasManyThrough']))
                    @include('dash::resource.show.show_relation_hasMany', [
                        'field' => $field,
                        'subResouce' => resourceShortName($field['resource']),
                    ])
                @elseif($field['type'] == 'morphMany')
                    @include('dash::resource.show.show_relation_morphMany', [
                        'field' => $field,
                        'subResouce' => resourceShortName($field['resource']),
                    ])
                @elseif($field['type'] == 'morphToMany')
                    @php
                        $listColumns = [];
                        foreach ($field['tags'] as $method => $tag) {
                            if (is_string($tag)) {
                                if (class_exists($tag)) {
                                    $listColumns[$tag] = [
                                        'method' => $method,
                                        'column' => $tag::$title,
                                        'label' => $tag::customName() ?? resourceShortName($tag),
                                    ];
                                }
                            } elseif (is_array($tag)) {
                                if (isset($tag['resource']) && class_exists($tag['resource'])) {
                                    // detect label
                                    if (isset($tag['label'])) {
                                        $label = $tag['label'];
                                    } elseif (!empty($tag['resource']::customName())) {
                                        $label = $tag['resource']::customName();
                                    } else {
                                        $label = resourceShortName($tag['resource']);
                                    }
                                    $listColumns[$tag['resource']] = [
                                        'method' => $method,
                                        'column' => $tag['resource']::$title,
                                        'label' => $label,
                                    ];
                                }
                            }
                        }
                    @endphp
                    @foreach ($listColumns as $resource => $array)
                        @php
                            $resourceName = resourceShortName($resource);
                            $method = $array['method'];
                            $column = $array['column'];
                            $label = $array['label'];
                        @endphp
                        @include('dash::resource.show.show_relation_morphToMany', [
                            'method' => $method,
                            'label' => $label,
                            'field' => $field,
                            'subResouce' => resourceShortName($resource),
                        ])
                    @endforeach
                @endif
                {{-- hasMany End --}}
            @endif
        @endif {{--  Show In Show Rule  --}}
    @endforeach
    {{--  Inline Button  --}}
    @include('dash::resource.inlineButton.inline_edit')
    @include('dash::resource.inlineButton.inline_show')
@endsection
