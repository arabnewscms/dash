@php
	if(!empty($data->{$field['attribute']})){
	$imglink = filter_var($data->{$field['attribute']}, FILTER_VALIDATE_URL)?$data->{$field['attribute']}: Storage::disk(env('FILESYSTEM_DRIVER','public'))->url($data->{$field['attribute']});
	}else{
		$imglink= null;
	}
	@endphp
<bdi>{{ $field['name'] }}</bdi> :
  @if(!empty($imglink))
	<span class="deletable_media_box_{{ $field['attribute'].$data->id }}">
		@if(isset($field['disableDwonloadButton']) && $field['disableDwonloadButton'])
		<a href="{{ $imglink }}" target="_blank"><i class="fa fa-download"></i></a>
		@endif
		@if(isset($field['disablePreviewButton']) && $field['disablePreviewButton'])
		@include('dash::resource.media.image_on_update',[
		'imagePath'=>$imglink,
		'id'=>$data->id
		])
		@endif

		@if(isset($field['deleteable']) && $field['deleteable'])
			@include('dash::resource.media.deleteable_media',[
			'file'=>$data->{$field['attribute']},
			'column'=>$field['attribute'],
			'id'=>$data->id,
			'model'=>get_class($data)
			])
		@endif
	</span>
	@else
	-
	@endif