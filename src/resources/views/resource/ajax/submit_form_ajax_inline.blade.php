<script type="text/javascript">
// inline{{ $resourceName }}_Loading For Submit Button_inline{{ $resourceName }}
var inline{{ $resourceName }}_loading = '<span class="ml-2 mr-2 progressPercentageBtn{{ $resourceName }}">0%</span> <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';
function scrollToInline(IdorClass){
	var inline{{ $resourceName }}_element_validate = $(IdorClass+' ');
	if(inline{{ $resourceName }}_element_validate.length){
		$('.inline_modal').animate({
	            scrollTop: inline{{ $resourceName }}_element_validate.offset().top - 160
	    }, 100,'swing');
    }
}

function showSweetAlertMessageInline{{ $resourceName }}(data,redirect=''){
    $('.inline_modal').modal('hide');
    $('.inline_modal_content').empty();
 toastr.success(data['message']);
}


 // Save action to redirect
 var btnAction_inline{{ $resourceName }};
 var backupBtnData_inline{{$resourceName}};
 var backupBtnValue_inline{{ $resourceName }};
 $(document).on('click','.{{ $add_inline_btn }}',function(){
 	backupBtnData_inline{{$resourceName}} = $(this).html();
 	backupBtnValue_inline{{ $resourceName }} = $(this).val();
 	btnAction_inline{{ $resourceName }} = $(this).attr('name');
 });

 // Prepare Form Data And Button

 var form_id_inline{{ $resourceName }} = '#{{ $form }}';
 var button_inline{{ $resourceName }} = $('.{{ $add_inline_btn }}');

// Start Ajax Code
$(document).on('click','.{{ $add_inline_btn }}',function(e){
    {{--  for (instance in CKEDITOR.instances) {
        CKEDITOR.instances[instance].updateElement();
    }  --}}
    var form{{ $resourceName }} = $(form_id_inline{{ $resourceName }})[0];
     const formData = new FormData(form{{ $resourceName }});
     formData.append('lang', '{{ request("lang",app()->getLocale()) }}');

    $.ajax({
        xhr: function() {
        var xhr = new window.XMLHttpRequest();
        xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
                var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                // Place upload progress bar visibility code here
                if(percentComplete!= null && percentComplete > 0){
                    $('.progressPercentageBtn{{ $resourceName }}').text(percentComplete+'%');
                }
            }
        }, false);
        return xhr;
        },
       url: $(form{{ $resourceName }}).attr("action")+'?refresh='+new Date().getTime(),
       type: $(form{{ $resourceName }}).attr("method"),
       dataType: "JSON",
       data: formData,
       processData: false,
       contentType: false,
       cache: false,
       beforeSend: function(){

          button_inline{{ $resourceName }}.prop('disabled',true);
          $('button[value="'+backupBtnValue_inline{{ $resourceName }}+'"]').html(inline{{ $resourceName }}_loading+backupBtnData_inline{{$resourceName}});
          $(form_id_inline{{ $resourceName }}+' div.invalid-feedback').remove();
          $(form_id_inline{{ $resourceName }}+ ' select, '+form_id_inline{{ $resourceName }}+ ' textarea, '+form_id_inline{{ $resourceName }}+' input').removeClass('is-invalid').removeClass('border-danger');
          // if has translatable
          $(form_id_inline{{ $resourceName }}+' .dotted').remove();

       },success: function (data, status){
          scrollToInline(form_id_inline{{ $resourceName }});
          $('.spinner-grow').remove();
          button_inline{{ $resourceName }}.prop('disabled',false);
            $('button[value="'+backupBtnValue_inline{{ $resourceName }}+'"]').html(inline{{ $resourceName }}_loading+backupBtnData_inline{{$resourceName}});
          showSweetAlertMessageInline{{ $resourceName }}(data,backupBtnValue_inline{{ $resourceName }});


          // refresh database if inline work in hasMany when show Records
           if(window.table{{ explode('_',$resourceName)[0] }}){
            table{{ explode('_',$resourceName)[0] }}.ajax.reload();
           }



       },error: function (xhr, desc, err){
          button_inline{{ $resourceName }}.prop('disabled',false);
          $('button[value="'+backupBtnValue_inline{{ $resourceName }}+'"]').html(backupBtnData_inline{{$resourceName}});
          $('.spinner-grow').remove();
          if(xhr && xhr.responseJSON && xhr.responseJSON.errors){
           var inline_errors = xhr.responseJSON.errors;
           scrollToInline(form_id_inline{{ $resourceName }}+' .'+Object.keys(inline_errors)[0]);
            $.each(inline_errors,function(key_inline,inline_value){
                // if has translatable Start
                var key_inline = key_inline.replace('.','_');
                var validationMessage = `<div class="invalid-feedback">`+inline_value[0]+`</div>`;
                var elementID = form_id_inline{{ $resourceName }}+' #'+key_inline;
                var elementClass = form_id_inline{{ $resourceName }}+' .'+key_inline;
                var getTabRandomName = '#'+$(form_id_inline{{ $resourceName }}+' .'+key_inline+'-tab').attr('id');

                $(getTabRandomName).prepend('<span class="p-1 m-1 bg-danger border dotted rounded-circle"></span>');
                // if has translatable End
                $(elementID).addClass('border-danger is-invalid');
                if($(elementID).attr('type') == 'file'){
                    $(elementClass).append(validationMessage);
                    $(elementID).parent('div').append(validationMessage);
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

</script>
