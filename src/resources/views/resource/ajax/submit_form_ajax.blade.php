@push('js')
<script type="text/javascript">
// Loading For Submit Buttons
var loading = '<span class="ml-2 mr-2 progressPercentageBtn">0%</span> <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';

function scrollTo(IdorClass){
	var element_validate = $(IdorClass+' ');

	if(element_validate.length){
		$('body,html').animate({
	            scrollTop: element_validate.offset().top - 160
	    }, 100,'swing');
    }
}

function showSweetAlertMessage(data,redirect=''){

// redirect to index module if click add btn
 if(redirect == 'add' || redirect == 'edit'){
 	setTimeout(function(){
	 	if(redirect == 'edit'){
			window.location.href = '{{url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName)}}';
	 	}else{
		window.location.href = $('#form').attr('action');
	 	}
 	}, 2000);
 	}else if(redirect == 'add_show'){
 		setTimeout(function(){
			window.location.href = '{{url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName)}}/'+data['id']+"?lang={{request('lang',app()->getLocale())}}";
			}, 2000);
	}else if(redirect == 'add_edit'){
        setTimeout(function(){
           window.location.href = '{{url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName)}}/edit/'+data['id']+"?lang={{request('lang',app()->getLocale())}}";
           }, 2000);
   }else if(redirect == 'edit_show'){
		setTimeout(function(){
			window.location.href = '{{url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName)}}/'+data['id']+"?lang={{request('lang',app()->getLocale())}}";
		}, 2000);
	}else if(redirect == 'edit_add'){
		setTimeout(function(){
			window.location.href = '{{url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName)}}/new';
		}, 2000);
	}
 toastr.success(data['message']);
}

$(document).ready(function(){
 // Save action to redirect
 var btnAction;
 var backupBtnData;
 var backupBtnValue;
 $(document).on('click','button[type="submit"]',function(){
 	backupBtnData = $(this).html();
 	backupBtnValue = $(this).val();
 	btnAction = $(this).attr('name');
 });

 // Prepare Form Data And Button
 var form_id = '#form';
 var buttons = $('button[type="submit"]');
 // Start Ajax Code
	$(document).on('submit',form_id,function(e){
	 var form = $(form_id)[0];
     const formData = new FormData(form);
     formData.append('lang', '{{ request("lang") }}');
	 $.ajax({
	     xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                // Place upload progress bar visibility code here
                if(percentComplete!= null && percentComplete > 0){
                    $('.progressPercentageBtn').text(percentComplete+'%');
                }
            }
        }, false);
        return xhr;
        },
	    url: $(form).attr("action"),
	    type: $(form).attr("method"),
	    dataType: "JSON",
	    data: formData,
	    processData: false,
	    contentType: false,
	    beforeSend: function(){
	       buttons.prop('disabled',true);
	       $('button[value="'+backupBtnValue+'"]').html(loading+backupBtnData);
	       $(form_id+' div.invalid-feedback').remove();
	       $(form_id+' select,'+form_id+' input,'+form_id+' textarea').removeClass('is-invalid').removeClass('border-danger');

           // if has translatable
		   $('.dotted').remove();
	    },success: function (data, status){
	       scrollTo(form_id);
	       $('.spinner-grow').remove();
	       buttons.prop('disabled',false);
	       $('button[value="'+backupBtnValue+'"]').html(backupBtnData);
	       if(backupBtnValue == 'add' || backupBtnValue == 'add_again' || backupBtnValue == 'add_show' || backupBtnValue == 'add_edit'){
	        form.reset();
	        $("select").val('').trigger('change');
            @if(!empty(request('relationField')))
                @foreach(request('relationField') as $kfield=>$vfield)
                 $(".{{ $kfield }}").val('{{ $vfield }}').trigger('change');
                @endforeach
            @endif

	       }
	       showSweetAlertMessage(data,backupBtnValue);
	    },error: function (xhr, desc, err){
	       buttons.prop('disabled',false);
	       $('button[value="'+backupBtnValue+'"]').html(backupBtnData);
	       $('.spinner-grow').remove();
	       if(xhr && xhr.responseJSON && xhr.responseJSON.errors){
	        var errors = xhr.responseJSON.errors;
	        scrollTo(form_id+' .'+Object.keys(errors)[0]);
	         $.each(errors,function(key,value){

	         	 // if has translatable Start
 var key = key.replace('.','_');
 var validationMessage = `<div class="invalid-feedback">`+value[0]+`</div>`;
 var elementID = form_id+' #'+key;
 var elementClass = form_id+' .'+key;
 var getTabRandomName = '#'+$('.'+key+'-tab').attr('id');

 $(getTabRandomName).prepend('<span class="p-1 m-1 bg-danger border dotted rounded-circle"></span>');
 // if has translatable End
 $(elementID).addClass('border-danger is-invalid');
 if($(elementID).attr('type') == 'file'){
    // $(elementClass).append(validationMessage);
     //$(elementID).parent('div').append(validationMessage);
     $(validationMessage).insertAfter(elementID);
 }else if($(elementID).attr('type') == 'text'){
     $(validationMessage).insertAfter(elementID);
 }else if($(elementClass+':has(select)')){
     $(elementClass).append(validationMessage);
     $(elementClass).parent('div').append(validationMessage);
 }else{
     $(elementID).parent('div').append(validationMessage);
 }
  $('.invalid-feedback').show();

	         });
	       }
	    },
	    statusCode: {
        500: function(err) {
       	  toastr.error(err?.responseJSON?.message);
        }
      }
	 });
	 // Stop Form To submition
	 e.preventDefault(e);
	});
	// End Ajax Code
});
</script>
@endpush
