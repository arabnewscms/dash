@if($field['show_rules']['showInCreate'])
@php
$selected = isset($field['selected'])?$field['selected']:null;
$col = isset($field['columnWhenCreate'])?$field['columnWhenCreate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
	<div class="form-group my-3 ">
		<label class="text-dark text-capitalize" for="{{ $field['attribute'] }}">
			{{ $field['name'] }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>
		<select id="{{ $field['attribute'] }}"
		{{ isset($field['disabled'])?'disabled':'' }}
		 name="{{ $field['attribute'] }}" class="form-control select2-show-search custom-select {{ $field['attribute'] }} {{ $errors->has($field['attribute'])?'is-invalid':'' }}" >
			<option selected disabled value>{{ $field['name'] }}</option>
			@if(isset($field['options']))
			@foreach($field['options'] as $key=>$value)
			<option value="{{ $key }}"
			{{ $selected == $key?'selected':'' }}
			{{ old($field['attribute']) == $key?'selected':'' }}

			>{{ $value }}</option>
			@endforeach
			@endif
		</select>
		{!! isset($field['help'])?$field['help']:'' !!}
	</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
@include('dash::resource.renderElements.select2',[
	'element'=>'.'.$field['attribute'],
	'attribute'=>$field['attribute']
])
});
</script>
@endif
