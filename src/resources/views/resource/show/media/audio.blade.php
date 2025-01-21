@php
	if(!empty($data->{$field['attribute']})){
	$audiolink = filter_var($data->{$field['attribute']}, FILTER_VALIDATE_URL)?$data->{$field['attribute']}: Storage::disk(env('FILESYSTEM_DRIVER','public'))->url($data->{$field['attribute']});
	}else{
		$audiolink= null;
	}
	@endphp
<bdi>{{ $field['name'] }}</bdi> :
 @if(!empty($audiolink))
	<span class="deletable_media_box_{{ $field['attribute'].$data->id }}">
		@if(isset($field['disableDwonloadButton']) && $field['disableDwonloadButton'])
		<a href="{{ $audiolink }}" target="_blank"><i class="fa fa-download"></i></a>
		@endif
		@if(isset($field['disablePreviewButton']) && $field['disablePreviewButton'])
		  @include('dash::resource.media.audio_on_update',[
			  'audio'=>$audiolink,
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