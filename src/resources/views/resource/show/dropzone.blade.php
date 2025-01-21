<div class="row">
	<div class="col-3">
		<bdi>{{ $field['name'] }}</bdi>
	</div>
	<div class="col-9">
	<table class="table table-borderd table-striped table-responsive">
		<thead>
			<th>@lang('dash::dash.user_id')</th>
			<th>@lang('dash::dash.full_path')</th>
			<th>@lang('dash::dash.ext')</th>
			<th>@lang('dash::dash.size')</th>
		</thead>
        @if(!empty($data?->{$field['attribute']}))
		@foreach($data?->{$field['attribute']} as $file)
		<tr>
			<td>{{ $file->user()->name }}</td>
			<td>
				@if(preg_match('/video/i', $file->mimtype))
				@include('dash::resource.media.video_on_update',[
                    'theme'=>'fantasy',
                    'video'=>$file->url,
				])
				@elseif(preg_match('/image/i', $file->mimtype))
				@include('dash::resource.media.image_on_update',[
                    'id'=>$data->id,
                    'imagePath'=>$file->url,
				])
				@elseif(preg_match('/audio/i', $file->mimtype))
				@include('dash::resource.media.audio_on_update',[
				'audio'=>$file->url,
				])
				@else
				<a href="{{ $file->url }}"><i class="fa fa-download"></i></a>
				@endif
			</td>
			<td>{{ $file->ext }}</td>
			<td>{{ $file->size }}</td>
		</tr>
		@endforeach
        @endif
	</table>
</div>
</div>
