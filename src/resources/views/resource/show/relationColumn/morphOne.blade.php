@php
$relationMethod = $field['attribute'];
$columnName     = $field['resource']::$title??'id';
$resourceName   = resourceShortName($field['resource']);

	$OneRelationData =  $data->{ $relationMethod};
@endphp
<bdi>{{ $field['name'] }}</bdi> :
@if(!empty($resourceName) && !empty($OneRelationData))
<a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'. $resourceName.'/'.$OneRelationData->id) }}">
	# {{ $OneRelationData->{$columnName} }}
</a>
@elseif(!empty($OneRelationData))
{{ $OneRelationData->{$columnName} }}
@endif