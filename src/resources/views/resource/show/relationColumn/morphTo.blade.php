@php
    $method = $field['attribute'];
    $types = $field['types'];
    $listColumns = [];
    foreach ($types as $restype) {
        $type = is_array($restype) ? $restype[0] : $restype;
        if (class_exists($type)) {
            $listColumns[$type] = $type::$title;
        }
    }
@endphp
<bdi>{{ $field['name'] }}</bdi> :
@foreach ($listColumns as $resource => $colname)
    @if (!empty($data->{$method . '_type'}) && $data->{$method . '_type'} == $resource::$model)
        @php
            $resourceName = resourceShortName($resource);
        @endphp
        <a href="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/' . $data?->{$method}?->id) }}">
            # {{ $resource::customName() ?? null }} - {{ $data?->{$method}?->{$colname} }}
        </a>
    @endif
@endforeach
