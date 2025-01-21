@php
$method = $field['attribute'];
$column = $field['resource']::$title??'id';
$resourceName = resourceShortName($field['resource']);
$loadData = $data->{$method};
@endphp
<div class="row">
	<div class="col-3">  {{ $field['name'] }} :</div>
	<div class="col-7 border p-2">
		@if(!empty($loadData) && count($loadData))
		@foreach($loadData as $ToMany)
		<p><a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/'.$ToMany->id) }}">{{ $ToMany->{$column} }}</a></p>
		@endforeach
		@endif
	</div>
</div>