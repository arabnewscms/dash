@if($field['show_rules']['showInCreate'])
@php
if(isset($field['valueWhenCreate'])){
$value = $field['valueWhenCreate'];
}elseif(isset($field['value'])){
$value = $field['value'];
}else{
$value = '';
}

@endphp
<input type="hidden"
		name="{{ $field['attribute'] }}" id="{{ $field['attribute'] }}"
		value="{{ old($field['attribute'],$value) }}" />

@endif