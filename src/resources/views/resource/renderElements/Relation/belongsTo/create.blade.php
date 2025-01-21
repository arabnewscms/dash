@if($field['show_rules']['showInCreate'])
@php
$selected = isset($field['selected'])?$field['selected']:null;
$belongsToAttr = $field['attribute'];

$checkIfNeedChildData = isset($field['fromParent']) && isset($field['fromParent']['parent']) && isset($field['fromParent']['column']);
$col = isset($field['columnWhenCreate'])?$field['columnWhenCreate']:$field['column'];

@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $belongsToAttr }}">
	 @php
 	 	$resource = $field['resource'];
	 @endphp
	{{-- Fetch Morph To Dropdown Select Start--}}
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

	<div class="form-group my-3">
		<label class="text-dark text-capitalize" for="{{ $belongsToAttr }}">
			{{ $belongsToTitle }}
			@if(isset($field['rule']) && in_array('required',$field['rule']) || isset($field['ruleWhenCreate']) && in_array('required',$field['ruleWhenCreate']))
			<span class="text-danger text-sm">*</span>
			@endif
		</label>
		{{--  {{dd(request('relationField'),$field['attribute'])}}  --}}

		<select id="{{ $belongsToAttr }}{{ request('ajax_loading','') }}"
		{{-- search Select2 Query Start --}}
            model="{{ $resource::$model }}"

            query="{{ isset($field['query'])?
                    (new SuperClosure\Serializer())->serialize($field['query']):null }}"

            searchKey="{{ $resource::$title }}"

            column="{{ isset($field['fromParent']) && isset($field['fromParent']['parent']) && isset($field['fromParent']['column'])?$field['fromParent']['column']:null  }}"

            parent="{{ isset($field['fromParent']) && isset($field['fromParent']['parent'])?$field['fromParent']['parent']:null }}"

 		{{-- search Select2 Query End --}}

		name="{{ strtolower($belongsToAttr) }}"

		{{--  {{!empty(request('relationField.'.$field['attribute']))?'disabled':''}}  --}}

		class="form-control select2-show-search custom-select {{ strtolower($belongsToAttr) }} {{ $errors->has($belongsToAttr)?'is-invalid':'' }}"
			{{ $checkIfNeedChildData?'disabled':'' }}
			>
			{{-- <option selected value>{{ $placeholder }}</option> --}}
			@if(!empty(request('relationField.'.$field['attribute'])))
			@foreach($resource::$model::where('id',request('relationField.'.$field['attribute']))->get() as $model)
			<option value="{{ $model->id }}"
			 selected >{{ $model->{$resource::$title} }}</option>
			@endforeach

			@endif
		</select>
		{!! isset($field['help'])?$field['help']:'' !!}
		@error($belongsToModal)
		<p class="invalid-feedback">{{ $message }}</p>
		@enderror

		@if(empty(request('relationField.'.$field['attribute'])) && !isset($field['fromParent']) && !isset($field['fromParent']['parent']) && !isset($field['fromParent']['column']))
		@if(method_exists($resource::$model, 'trashed'))
        <label class="custom-switch" for="withTrashed{{ $belongsToAttr }}">
            <input  type="checkbox" name="withTrashed{{ $belongsToAttr }}" value="yes"
            id="withTrashed{{ $belongsToAttr }}" {{ old('withTrashed'.$belongsToAttr)?'checked':'' }} class="custom-switch-input">
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

    window["get_{{ $belongsToAttr }}_data"] = function(parent_id=null,column=null){

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
				parent:parent_id,
				column:column,
				model_name:model_name,
				model_value:model_value,
				model_query:model_query,
				withTrashed:withTrashed,
				stringName:'{{ $resource::$title }}'
			},
			beforeSend: function(){
 				$('#{{ $belongsToAttr.request('ajax_loading','') }}').prop('disabled',true).html('');
			},success: function(data){
				var selectedValue = '{{ old($belongsToModal) }}';
				var options = '<option selected value>{{ $placeholder }}</option>';

				$.each(data,function(key,value){
					if(selectedValue == key){
						var selected = 'selected';
					}else{
						var selected = '';
					}
					options += `<option value="`+key+`" `+selected+` >`+value+`</option>`;
				});

                //var parentForm = $('.{{ strtolower($belongsToAttr) }}').parent('form').attr('id');
                 // console.log(parentForm);
				$('#{{ $belongsToAttr.request('ajax_loading','') }}').prop('disabled',false).html(options);
// pre child
//console.log('#{{ $belongsToAttr.request('ajax_loading','') }}');
@include('dash::resource.renderElements.select2',[
					'element'=>'#'.$belongsToAttr.request('ajax_loading','') ,
					'attribute'=>strtolower($belongsToAttr),
					'dynamic'=>true
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
	'element'=>'#'.$field['fromParent']['parent'].request('ajax_loading',''),
	'attribute'=>$field['fromParent']['parent'],
	'dynamic'=>true
])

     $('#{{ $field['fromParent']['parent'].request('ajax_loading','') }}').on('select2:select',function(e){
        var parentSelect = '#{{ $field['fromParent']['parent'].request('ajax_loading','') }}';
        var parentValue = $(parentSelect+' option:selected').val();

    if(parentValue != ''){
        // load Data By Parent
         get_{{ $belongsToAttr }}_data(parentValue,'{{ $field['fromParent']['column'] }}');
        }
	});

@if(!empty(request('relationField')) && !empty(request('relationField.'.$field['fromParent']['parent'])))
	// load Data By Parent
			get_{{ $belongsToAttr }}_data('{{ request('relationField.'.$field['fromParent']['parent']) }}','{{ $field['fromParent']['column'] }}');
@endif



@else

@include('dash::resource.renderElements.select2',[
	'element'=>'#'.$belongsToAttr.request('ajax_loading',''),
	'attribute'=>$belongsToAttr,
	// 'parent'=>$field['fromParent']['parent'],
	// 'column'=>$field['fromParent']['column'],
	'dynamic'=>true
])

@endif

 // Here can childe remove old elements or selected values
 @if(isset($field['child']))

 @include('dash::resource.renderElements.select2',[
	'element'=>'#'.$belongsToAttr.request('ajax_loading',''),
	'attribute'=>$belongsToAttr,
	'dynamic'=>true,
	//'hadChild'=>$child
])
var formId3 = $('.{{ $belongsToAttr }}').parents('form').attr('id');
//console.log('#'+formId3+' .{{ $belongsToAttr }}');
$('#{{ $belongsToAttr.request('ajax_loading','') }}').on('select2:select',function(){
  	 @foreach($field['child'] as $child)
  	  $('#{{ $child.request('ajax_loading','') }}').prop('disabled',true).html('');
  	 @endforeach
  });
 @endif


@if(method_exists($resource::$model, 'trashed'))
	// load withtrashed
	@if(old('withTrashed'.$belongsToAttr))
		get_{{ $field['attribute'] }}_data();
	@endif

	$(document).on('change','#withTrashed{{ $belongsToAttr }}',function(){
		get_{{ $field['attribute'] }}_data();
	});
@endif



});
</script>
	{{-- Fetch Morph To Dropdown Select End --}}
</div>


@endif
