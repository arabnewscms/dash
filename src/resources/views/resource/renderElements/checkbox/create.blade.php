@if($field['show_rules']['showInCreate'])
@php
$default = isset($field['default'])?$field['default']:null;
$value = isset($field['trueVal'])?$field['trueVal']:true;
$col = isset($field['columnWhenCreate'])?$field['columnWhenCreate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
    <div class="custom-toggle-switch d-flex align-items-center mb-4">
        <input  {{ isset($field['readonly']) && $field['readonly']?'readonly':'' }}
		{{ isset($field['checked']) && $field['checked']?'checked':'' }}
        type="checkbox" name="{{ $field['attribute'] }}" value="{{ old($field['attribute'],$value) }}"
        id="{{ $field['attribute'] }}" />
        <label for="{{ $field['attribute'] }}" class="label-secondary"></label><span class="ms-3 text-default">
            {{ $field['name'] }}
            @if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
        </span>
    </div>
	{!! isset($field['help'])?$field['help']:'' !!}
</div>
@endif


