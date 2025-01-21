@if($field['show_rules']['showInUpdate'])
@php
$selected = isset($field['selected'])?$field['selected']:null;
$belongsToAttr = $field['attribute'];
$checkIfNeedChildData = isset($field['fromParent']) && isset($field['fromParent']['parent']) && isset($field['fromParent']['column']);
$col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $belongsToAttr }}">
	@php
	$resource = $field['resource'];
	@endphp
	{{-- Fetch Belongs To Dropdown Select Start--}}
	@php
	$belongsToModal = resourceShortName($resource::$model);
	$belongsToTitle = $field['name']??resourceShortName($resource::$model);
	$placeholder = isset($field['placeholder'])?$field['placeholder']:$field['name'];
	@endphp
    @if(empty(request('create_with_inline')) && isset($field['inlineButton']) && $field['inlineButton'] === true)
    <div class="row">
    <div class="col-3 align-self-center {{ !method_exists($resource::$model, 'trashed')?'mt-4':'' }}">
        @include('dash::resource.inlineButton.inline_create',['field'=>$field])
    </div>
    <div class="col-9">
    @endif

	<div class="form-group my-3 ">
		<label class="text-dark text-capitalize" for="{{ $belongsToAttr }}">
			{{ $belongsToTitle }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>
@if(!$checkIfNeedChildData)
			@php
			if(isset($field['query'])){
				$query  = $field['query']($resource::$model)->get();
			}else{
				$query  = $resource::$model::all();
			}
			@endphp
@endif
		<select id="{{ $belongsToAttr.request('ajax_loading','') }}"

		{{-- search Select2 Query Start --}}
 model="{{ $resource::$model }}"
 query="{{ isset($field['query'])?
		(new SuperClosure\Serializer())->serialize($field['query']):null }}"
 searchKey="{{ $resource::$title }}"

 column = "{{ isset($field['fromParent']) && isset($field['fromParent']['parent']) && isset($field['fromParent']['column'])?$field['fromParent']['column']:null  }}"
 parent="{{ isset($field['fromParent']) && isset($field['fromParent']['parent'])?$field['fromParent']['parent']:null }}"

		{{-- search Select2 Query End --}}

		name="{{ strtolower($belongsToAttr) }}" class="form-control select2-show-search custom-select
			{{ isset($field['hideIf']) && $field['hideIf']?'d-none':'' }}
			{{ strtolower($belongsToAttr) }} {{ $errors->has($belongsToAttr)?'is-invalid':'' }}"
			{{ $checkIfNeedChildData?'disabled':'' }}
			>
			<option selected value>{{ $placeholder }}</option>
			@if(!$checkIfNeedChildData)
			@php
			if(isset($field['query'])){
				$query  = $field['query']($resource::$model)->limit(50);
			}else{
				$query  = $resource::$model::limit(50);
			}
			$query = $query->where(function($q)use($model,$belongsToAttr,$belongsToModal){
				if(!empty($model->{$belongsToAttr})){
					$q->where('id',$model->{$belongsToAttr}->id);
				}elseif(!empty($model->{$belongsToModal}->id)){
					$q->where('id',$model->{$belongsToModal}->id);
				}
			})->get();
			@endphp
			@foreach($query as $rmodel)
			<option value="{{ $rmodel->id }}"
				@if(!empty($model->{$belongsToAttr}) && !empty($model->{$belongsToAttr}?->id))
				{{ $model->{$belongsToAttr}->id == $rmodel->id?'selected':'' }}
			{{-- 	@elseif(!empty($model->{$belongsToModal}) && !empty($model->{$belongsToModal}->id))
				{{ $model->{$belongsToModal}->id == $rmodel->id?'selected':'' }} --}}
				@endif
			>{{ $rmodel->{$resource::$title} }}</option>
			@endforeach
			@endif
		</select>
		{!! isset($field['help'])?$field['help']:'' !!}
		@error($belongsToAttr)
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror
		@if(!isset($field['fromParent']) && !isset($field['fromParent']['parent']) && !isset($field['fromParent']['column']))
		@if(method_exists($resource::$model, 'trashed'))
        <label class="custom-switch" for="withTrashed{{ $belongsToAttr }}">
            <input  type="checkbox" name="withTrashed{{ $belongsToAttr }}" value="yes"
            id="withTrashed{{ $belongsToAttr }}" checked class="custom-switch-input">
            <span class="custom-switch-indicator"></span>
            <span class="custom-switch-description">{{ __('dash::dash.withTrashed') }}</span>
        </label>
		@endif
		@endif
	</div>

    @if(empty(request('create_with_inline')) && isset($field['inlineButton']) && $field['inlineButton'] === true)

    {{--  Col-10 end  --}}
</div>
{{--  row end  --}}
</div>
@endif
	<script type="text/javascript">
	$(document).ready(function(){


    window["get_{{ $belongsToAttr }}_data"] = function(parent=null,column=null){
		var model_value =  '{{ str_replace('\\','\\\\',$resource::$model)  }}';
			var model_name  =  '{{ $belongsToModal }}';
			var model_query  = $('#{{ $belongsToAttr.request('ajax_loading','') }}').attr('query');
			var withTrashed = $('#withTrashed{{ $belongsToAttr.request('ajax_loading','') }}').is(':checked')?true:false;
			$.ajax({
				url:'{{ url(app('dash')['DASHBOARD_PATH'].'/load/model') }}',
				dataType:'json',
				type:'post',
				data:{
					_token:'{{ csrf_token() }}',
                    lang:'{{ app()->getLocale() }}',
					parent:parent,
					column:column,
					model_name:model_name,
					model_value:model_value,
					model_query:model_query,
					withTrashed:withTrashed,
					stringName:'{{ $resource::$title }}'
				},
				beforeSend: function(){
					$('.{{ $belongsToAttr }}').prop('disabled',true).html('');
				},success: function(data){
					var selectedValue = '{{ !empty($model->{$belongsToAttr}->id)? $model->{$belongsToAttr}->id:'' }}';
					var options = '<option selected value>{{ $placeholder }}</option>';
					$.each(data,function(key,value){
						if(selectedValue == key){
							var selected = 'selected';
						}else{
							var selected = '';
						}
						options += `<option value="`+key+`" `+selected+` >`+value+`</option>`;
					});
					$('#{{ $belongsToAttr.request('ajax_loading','') }}').prop('disabled',false).html(options);

					@include('dash::resource.renderElements.select2',[
						'dynamic'=>true,
						'element'=>'#'.$belongsToAttr.request('ajax_loading','') ,
						'attribute'=>strtolower($belongsToAttr)
					])

                    // Call Same Function if Had Parent //
@if(!empty($field['child']) && isset($field['child']))
@foreach($field['child']  as $child)
var formId = $('.{{ $child }}').parents('form').attr('id');
     $('#{{ $belongsToAttr.request('ajax_loading','') }}').on('select2:select',function(e){
          // console.log(formId);
         var nextColumn = $('#{{ $belongsToAttr.request('ajax_loading','') }}').attr('column');
         var nextParent = $('#{{ $belongsToAttr.request('ajax_loading','') }}').attr('parent');
         var nextParentValue = $(nextParent+' option:selected').val();
        if(nextColumn != '' && nextParentValue != '' ){
             get_{{ $child }}_data(nextParentValue,nextColumn);
         }
      });

    @endforeach
@endif
// Call Same Function if Had Parent End //
				}
			});
	}
	@if($checkIfNeedChildData)
@include('dash::resource.renderElements.select2',[
	'dynamic'=>true,
	'element'=>'#'.$field['fromParent']['parent'].request('ajax_loading','') ,
	'attribute'=>$field['fromParent']['parent']
])

	$('#{{ $field['fromParent']['parent'].request('ajax_loading','') }}').on('select2:select',function(){
			var parentValue = $(this,' option:selected').val();
			if(parentValue != ''){
				// load Data By Parent
				get_{{ $belongsToAttr }}_data(parentValue,'{{ $field['fromParent']['column'] }}');
			}
	});
	@if(!empty(request('relationField')) && !empty(request('relationField.'.$field['fromParent']['parent'])))
		// load Data By Parent
		get_{{ $belongsToAttr }}_data('{{ request('relationField.'.$field['fromParent']['parent']) }}','{{ $field['fromParent']['column'] }}');
	@endif
	// autoload data on edit  Start
	@php
	$parent_column = $field['fromParent']['column'];
	$parent_value  = $model->{$field['fromParent']['column']};
	@endphp
	get_{{ $belongsToAttr }}_data('{{ $parent_value }}','{{ $parent_column }}');
	// autoload data on edit  End
	@endif
	// Here can childe remove old elements or selected values
	@if(isset($field['child']))
@include('dash::resource.renderElements.select2',[
	'dynamic'=>true,
	'element'=>'#'.$belongsToAttr.request('ajax_loading','') ,
	'attribute'=>$belongsToAttr
])

	$('#{{ $belongsToAttr.request('ajax_loading','') }}').on('select2:select',function(){
		@foreach($field['child'] as $child)
		$('.{{ $child }}').prop('disabled',true).html('');
		@endforeach
	});




	@endif


@if(!$checkIfNeedChildData)
	@include('dash::resource.renderElements.select2',[
		'dynamic'=>true,
		'element'=>'#'.$belongsToAttr.request('ajax_loading',''),
		'attribute'=>$belongsToAttr
	])
@endif

	@if(method_exists($resource::$model, 'trashed'))
		// load withtrashed
		@if(old('withTrashed'.$belongsToAttr))
			get_{{ $belongsToAttr }}_data();
		@endif
		$(document).on('change','#withTrashed{{ $belongsToAttr }}',function(){
			get_{{ $belongsToAttr }}_data();
		});
	@endif
	});
	</script>
	{{-- Fetch Belongs To Dropdown Select End --}}
</div>
@endif
