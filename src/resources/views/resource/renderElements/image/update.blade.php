@if($field['show_rules']['showInUpdate'])
@php
$col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
	<div class="row">
	<div class="col-8">
	<div class="form-group">
		<label for="{{ $field['attribute'] }}"
			class="text-dark text-capitalize">{{ $field['name'] }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>
		<input type="file"
		name="{{ $field['attribute'] }}"
		accept="{{ isset($field['accept'])?implode(',',$field['accept']):'' }}"
		placeholder="{{ isset($field['placeholder'])?$field['placeholder']:$field['name'] }}"

		{{ isset($field['textAlign'])?'style="text-align:'.$field['textAlign'].'"':'' }}
		{{ isset($field['readonly'])?'readonly':'' }}
		{{ isset($field['disabled'])?'disabled':'' }}

		{{ isset($field['disabledIf']) && $field['disabledIf']?'disabled':'' }}
		{{ isset($field['readOnlyIf']) && $field['readOnlyIf']?'readonly':'' }}


		class="form-control 
			 {{ isset($field['hideIf']) && $field['hideIf']?'d-none':'' }}

 			{{ $field['attribute'] }} {{ $errors->has($field['attribute'])?'is-invalid':'' }}"
		id="{{ $field['attribute'] }}" />
		{!! isset($field['help'])?$field['help']:'' !!}
		@error($field['attribute'])
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror
	</div>
	</div>
	<div class="col-4 pt-5">
	@php
	if(!empty($model->{$field['attribute']})){

        $link = filter_var($model->{$field['attribute']}, FILTER_VALIDATE_URL)?$model->{$field['attribute']}: Storage::disk(config('dash.FILESYSTEM_DISK'))->url($model->{$field['attribute']});
	}else{
	$link = null;
	}

	@endphp
	@if(!empty($link))
	<div class="deletable_media_box_{{ $field['attribute'].$model->id }}">
		@if(isset($field['disableDwonloadButton']) && $field['disableDwonloadButton'])
		<a href="{{ $link }}" target="_blank"><i class="fa fa-download"></i></a>
		@endif
		@if(isset($field['disablePreviewButton']) && $field['disablePreviewButton'])
		@include('dash::resource.media.image_on_update',[
		'imagePath'=>$link,
		'id'=>$model->id
		])
		@endif

		@if(isset($field['deleteable']) && $field['deleteable'])
			@include('dash::resource.media.deleteable_media',[
			'file'=>$model->{$field['attribute']},
			'column'=>$field['attribute'],
			'id'=>$model->id,
			'model'=>get_class($model)
			])
		@endif
	</div>
	@endif
	</div>
	</div>
</div>
@endif
