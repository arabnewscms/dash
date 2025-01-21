@if($field['show_rules']['showInUpdate'])
@php
// $selected = isset($field['selected'])?$field['selected']:null;
$belongsToMany = $field['attribute'];
$col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];
$selectName = strtolower($belongsToMany);
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

	<div class="form-group my-3  {{ $errors->has($belongsToManyModel)?'is-invalid':'' }}">
		<label class="text-dark text-capitalize" for="{{ $belongsToManyModel }}">
			{{ $belongsToManyTitle }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenUpdate']) && in_array('required',$field['ruleWhenUpdate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>
		@php

		 $fetchSelected = $model->{$selectName}->pluck('id')->toArray();
		@endphp
		<select id="{{ $selectName.request('ajax_loading','') }}"

        {{-- search Select2 Query Start --}}
		query="{{ isset($field['query']) && !empty($field['query'])?(new SuperClosure\Serializer())->serialize($field['query']):null }}"

		model="{{ $resource::$model }}"
		searchKey="{{ $resource::$title }}"
		{{-- search Select2 Query End --}}

         multiple name="{{ $selectName }}[]" class="form-select select2-show-search custom-select

		{{ isset($field['hideIf']) && $field['hideIf']?'d-none':'' }}
		{{ strtolower($selectName) }} {{ $errors->has($selectName)?'is-invalid':'' }}" >
		  @php
			if(isset($field['query'])){
				$query  = $field['query']($resource::$model)->get();
			}else{
				$query  = $resource::$model::all();
			}
			@endphp
			@foreach($query as $rmodel)
			<option value="{{ $rmodel->id }}"
			 {{ !empty($model->{$selectName}->pluck('id')) &&
			 	in_array($rmodel->id,$fetchSelected) ?'selected':'' }}
			 >{{ $rmodel->{$resource::$title} }}</option>
			@endforeach
		</select>
		{!! isset($field['help'])?$field['help']:'' !!}
		@error($selectName)
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror

		@if(method_exists($resource::$model, 'trashed'))
        <label class="custom-switch" for="withTrashed{{ $belongsToMany }}">
            <input  type="checkbox" name="withTrashed{{ $belongsToMany }}" value="yes"
            id="withTrashed{{ $belongsToMany }}" checked class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('dash::dash.withTrashed') }}</span>
        </label>
		@endif

	</div>

<script type="text/javascript">
$(document).ready(function(){
@if(method_exists($resource::$model, 'trashed'))
	function {{ $belongsToMany }}loadonlyTrashed(){
		var model_value =  '{{ str_replace('\\','\\\\',$resource::$model)  }}';
		var model_name  =  '{{ $belongsToManyModel }}';
		var withTrashed = $('#withTrashed{{ $belongsToMany }}').is(':checked')?true:false;
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
				$('.{{ $selectName }}').prop('readonly',true).html('');
			},success: function(data){
				var selectedValue = '{{ old($belongsToManyModel) }}';
				var options = '';
				//console.log(selectedValue);
				$.each(data,function(key,value){
					if(selectedValue == key){
						var selected = 'selected';
					}else{
						var selected = '';
					}
					options += `<option value="`+key+`" `+selected+` >`+value+`</option>`;
				});
				$('.{{ $selectName }}').prop('readonly',false).html(options);
// reSelected multiple valeu from old data
 @if(!empty($fetchSelected))
 var Values = new Array();
  @foreach($fetchSelected as $select)
		Values.push("{{ $select }}");
  @endforeach
  $("#{{ $selectName }}").val(Values).trigger("change");
 @endif
			}
		});
	}
	// auto load withtrashed
	{{ $belongsToMany }}loadonlyTrashed();


$(document).on('change','#withTrashed{{ $belongsToMany }}',function(){
  {{ $belongsToMany }}loadonlyTrashed();
});
@endif



@include('dash::resource.renderElements.select2',[
					'element'=>'#'.$selectName.request('ajax_loading',''),
					'attribute'=>strtolower($belongsToMany),
					'dynamic'=>true,
				])




});
/////////////////////////////////////////


	// reSelected multiple valeu from old data
  @if(!empty($fetchSelected))
   var Values = new Array();
   @foreach($fetchSelected as $select)
	  Values.push("{{ $select }}");
   @endforeach
  $("#{{ $selectName }}").val(Values).trigger("change");
 @endif
</script>

	{{-- Fetch BelongsToMany To Dropdown Select End --}}
</div>
@endif
