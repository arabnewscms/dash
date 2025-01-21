@php
if(!empty($data->{$field['attribute']})){
$filelink = filter_var($data->{$field['attribute']}, FILTER_VALIDATE_URL)?$data->{$field['attribute']}: Storage::disk(env('FILESYSTEM_DRIVER','public'))->url($data->{$field['attribute']});
}else{
	$filelink= null;
}
@endphp
<bdi>{{ $field['name'] }}</bdi> :
@if(!empty($filelink))
	<span class="deletable_media_box_{{ $field['attribute'].$data->id }}">
	@if(isset($field['disableDwonloadButton']) && $field['disableDwonloadButton'])
	<a href="{{ $filelink }}" target="_blank" class="m-2"><i class="fa fa-download"></i></a>
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