@if($field['show_rules']['showInCreate'])
@php
$selected = isset($field['selected'])?$field['selected']:null;
$belongsToManyName = $field['attribute'];
$col = isset($field['columnWhenCreate'])?$field['columnWhenCreate']:$field['column'];
$selectName = strtolower($belongsToManyName);
@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $selectName }}">
	 @php
 	 	$resource = $field['resource'];
	 @endphp
	{{-- Fetch BelongsToMany To Dropdown Select Start --}}
	@php
	$belongsToManyModel = resourceShortName($resource::$model);
	$belongsToManyTitle = $field['name']??resourceShortName($resource::$model);
	@endphp

	<div class="form-group my-3  {{ $errors->has($selectName)?'is-invalid':'' }}">
		<label class="text-dark text-capitalize" for="{{ $belongsToManyModel }}">
			{{ $belongsToManyTitle }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>

		<select id="{{ $selectName }}{{ request('ajax_loading','') }}"
    	{{-- search Select2 Query Start --}}
		query="{{ isset($field['query']) && !empty($field['query'])?(new SuperClosure\Serializer())->serialize($field['query']):null }}"

		model="{{ $resource::$model }}"
		searchKey="{{ $resource::$title }}"
		{{-- search Select2 Query End --}}
		multiple

		name="{{ $selectName }}[]" class="form-control select2-show-search custom-select {{ $selectName }} {{ $errors->has($selectName)?'is-invalid':'' }} " >

			@php
			if(isset($field['query'])){
				$query  = $field['query']($resource::$model)->get();
			}else{
				$query  = $resource::$model::all();
			}

			@endphp
			@foreach($query as $model)
			<option value="{{ $model->id }}"
			 {{ !empty(old($selectName)) && in_array($model->id,old($selectName)) ?'selected':'' }}
			 >{{ $model->{$resource::$title} }}</option>
			@endforeach
		</select>
		{!! isset($field['help'])?$field['help']:'' !!}
		@error(strtolower($belongsToManyModel))
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror

		@if(method_exists($resource::$model, 'trashed'))
		<label class="custom-switch" for="withTrashed{{ $belongsToManyName }}">
            <input  type="checkbox" name="withTrashed{{ $belongsToManyName }}" value="yes"
            id="withTrashed{{ $belongsToManyName }}" {{ old('withTrashed'.$belongsToManyName)?'checked':'' }} class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('dash::dash.withTrashed') }}</span>
        </label>
		@endif
	</div>

<script type="text/javascript">
$(document).ready(function(){
@if(method_exists($resource::$model, 'trashed'))
	function {{ $belongsToManyName }}loadonlyTrashed(){
		var model_value =  '{{ str_replace('\\','\\\\',$resource::$model)  }}';
		var model_name  =  '{{ $belongsToManyModel }}';
		var withTrashed = $('#withTrashed{{ $belongsToManyName }}').is(':checked')?true:false;
		$.ajax({
			url:'{{ url(app('dash')['DASHBOARD_PATH'].'/load/model') }}',
			dataType:'json',
			type:'post',
			data:{
				_token:'{{ csrf_token() }}',
                lang:'{{ app()->getLocale() }}',
				model_name:model_name,
				model_value:model_value,
				withTrashed:withTrashed,
				locale:'{{ app()->getLocale() }}',
				stringName:'{{ $resource::$title }}'
			},
			beforeSend: function(){
				$('.{{ strtolower($belongsToManyModel) }}').prop('readonly',true).html('');
			},success: function(data){
				var selectedValue = '{{ old($belongsToManyModel) }}';
				var options = '';

				$.each(data,function(key,value){
					if(selectedValue == key){
						var selected = 'selected';
					}else{
						var selected = '';
					}
					options += `<option value="`+key+`" `+selected+` >`+value+`</option>`;
				});

				$('.{{ strtolower($belongsToManyModel) }}').prop('readonly',false).html(options);
// reSelected multiple valeu from old data
 	@if(!empty(old($selectName)))
				var Values = new Array();
				@foreach(old($selectName) as $select)
						Values.push("{{ $select }}");
				@endforeach
				$("#{{ $belongsToManyModel }}").val(Values).trigger("change");
				@endif
	}
		});
	}


		$(document).on('change','#withTrashed{{ $belongsToManyName }}',function(){
			{{ $belongsToManyName }}loadonlyTrashed();
		});
	@endif



@include('dash::resource.renderElements.select2',[
	'element'=>'#'.$selectName.request('ajax_loading',''),
	'attribute'=>strtolower($belongsToManyName),
	'dynamic'=>true,
  ])

});


/////////////////////////////////////////



	// reSelected multiple valeu from old data
  @if(!empty(old($selectName)))
   var Values = new Array();
   @foreach(old($selectName) as $select)
	  Values.push("{{ $select }}");
   @endforeach
  $("#{{ $selectName }}").val(Values).trigger("change");
 @endif
</script>

	{{-- Fetch BelongsToMany To Dropdown Select End --}}
</div>
@endif
