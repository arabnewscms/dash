{
    text:'<i class="fa-solid fa-filter"></i>',
    className:'btn btn-primary  {{ $resourceName }}',
    attr:{
        'data-bs-toggle':'collapse',
        'data-bs-target':'#collapse{{$resourceName}}',
        'aria-controls':'#collapse{{$resourceName}}',
        'aria-expanded':'false'
    }
    {{-- action: function(e,dt,node,config){

    } --}}
},
@if($multiSelectRecord)
 {
 	text:'<i class="fa fa-trash"></i> {{ __('dash::dash.delete') }}',
 	className:'btn btn-danger d-none deleteAllBtn{{ $resourceName }}',
 	action: function(e,dt,node,config){
 		//mutliselect_data{{ $resourceName }}
 		   var list = [];
 		   $('.mutliselect_data{{ $resourceName }}').html('');
 		  $(".selectID{{ $resourceName }}").each(function(key,val){
 		  	if($(this).is(':checked')){
	         	var ids = $(this).val();
	         	list.push(ids);
	         	$('.mutliselect_data{{ $resourceName }}').append(`
	         		<input type="hidden" name="ids[]" value="`+ids+`" />
	         		`);
 		  	}
	         //$(this).prop("checked",false);
	       });

 		if(list.length > 0){
 			$('.mutliselect_data{{ $resourceName }}').append(`<p>{{__('dash::dash.are_you_sure_to_delete')}}</p>`);
 			$('#deleteAll{{ $resourceName }}').modal('show');
 		}
 	}
 },
@if($multiSelectRecord && method_exists($resource['model'],'trashed'))
 {
 	text:'<i class="fa fa-trash-restore-alt"></i> {{ __('dash::dash.restore') }}',
 	className:'btn btn-success d-none restoreAllBtn{{ $resourceName }}',
 	action: function(e,dt,node,config){
 		//mutliselect_data{{ $resourceName }}
 		   var list = [];
 		   $('.mutliselect_data{{ $resourceName }}').html('');
 		  $(".selectID{{ $resourceName }}").each(function(key,val){
 		  	if($(this).is(':checked')){
	         	var ids = $(this).val();
	         	list.push(ids);
	         	$('.mutliselect_data{{ $resourceName }}').append(`
	         		<input type="hidden" name="ids[]" value="`+ids+`" />
	         		`);
 		  	}
	         //$(this).prop("checked",false);
	       });

 		if(list.length > 0){
 			$('.mutliselect_data{{ $resourceName }}').append(`<p>{{__('dash::dash.are_you_sure_to_restore')}}</p>`);
 			$('#restoreAll{{ $resourceName }}').modal('show');
 		}
 	}
 },
@endif
// end check trashed
@endif

@foreach($dtButtons as $button)
 @if(is_array($button))
 	{!! json_encode($button,JSON_PRETTY_PRINT) !!},
 @else
 "{{ $button }}",
 @endif
@endforeach
