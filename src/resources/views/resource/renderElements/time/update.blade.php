@if($field['show_rules']['showInUpdate'])
@php
if(isset($field['valueWhenUpdate'])){
$value = $field['valueWhenUpdate'];
}elseif(isset($field['value'])){
$value = $field['value'];
}else{
$value = $model->{$field['attribute']};
}
$col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
	<div class="form-group my-3 ">
		<label for="{{ $field['attribute'] }}"
		class="text-dark form-label text-start text-capitalize">{{ $field['name'] }}
		@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenUpdate']) && in_array('required',$field['ruleWhenUpdate']))
		<span class="text-danger text-sm">*</span>
		@endif
		</label>
		<input type="time"
		name="{{ $field['attribute'] }}"
		placeholder="{{ isset($field['placeholder'])?$field['placeholder']:$field['name'] }}"
		{{ isset($field['textAlign'])?'style="text-align:'.$field['textAlign'].'"':'' }}
		{{ isset($field['readonly'])?'readonly':'' }}
		{{ isset($field['disabled'])?'disabled':'' }}

		{{ isset($field['disabledIf']) && $field['disabledIf']?'disabled':'' }}
		{{ isset($field['readOnlyIf']) && $field['readOnlyIf']?'readonly':'' }}

		class="form-control
		{{ isset($field['hideIf']) && $field['hideIf']?'d-none':'' }}
		{{ $field['attribute'] }} {{ $errors->has($field['attribute'])?'is-invalid':'' }}"
		id="{{ $field['attribute'] }}"
		value="{{ $value }}" />
		@error($field['attribute'])
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror
	</div>
</div>
@include('dash::resource.renderElements.flatpicker',[
	'field'=>$field
	])
@endif
