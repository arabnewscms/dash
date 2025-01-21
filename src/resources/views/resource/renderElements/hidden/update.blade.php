@if($field['show_rules']['showInUpdate'])
@php
if(isset($field['valueWhenUpdate'])){
$value = $field['valueWhenUpdate'];
}elseif(isset($field['value'])){
$value = $field['value'];
}else{
$value = $model->{$field['attribute']};
}

@endphp
<input type="hidden"
		name="{{ $field['attribute'] }}"
		{{ isset($field['readonly'])?'readonly':'' }}
		{{ isset($field['disabled'])?'disabled':'' }}
		id="{{ $field['attribute'] }}"
		value="{{ $value }}" />

@endif