@php

$randomAttribute = $field['attribute'].time();
@endphp

<script type="text/javascript">
    $(document).ready(function(){
        var modal_edit = `
        <div class="modal fade inline_modal" id="boxModal_edit{{$randomAttribute}}" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg modal-xl">
             <div class="modal-content">
               <div class="modal-header">
                    <h6 class="modal-title edit_model_label" id="boxModal_edit{{$randomAttribute}}Label"> </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body inline_modal_content content_boxModal_edit{{$randomAttribute}}" style="overflow:hidden;"></div>
           </div>
         </div>
       </div>
        `;


     $(document).on('click','.edit_relation_row',function(){
        var record_id = $(this).attr('record_id');
        var res_name  = $(this).attr('res_name');
        var res_icon  = $(this).attr('res_icon');
        var res_label = $(this).attr('res_label');
        $('.edit_model_label').html(res_icon+' {{ __("dash::dash.edit") }}: '+res_label);
        $('#boxModal_edit{{$randomAttribute}}').modal('show');


       $.ajax({
        url:'{{ dash('resource') }}/'+res_name+'/edit/'+record_id+'?edit_with_inline='+new Date().getTime()+'&lang={{request('lang',app()->getLocale())}}',
        type:'get',
        dataType:'html',
        processData: false,
        contentType: false,
        cache: false,
        data:{lang:'{{request("lang",app()->getLocale())}}'},
        beforeSend:function(){
            $('.content_boxModal_edit{{$randomAttribute}}').empty();

            $('.content_boxModal_edit{{$randomAttribute}}').html(`
            <center>
                <div class="spinner-border text-dark" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </center>
            `);
        },
        success:function(data){
            $('.content_boxModal_edit{{$randomAttribute}}').html(data);

        }
       });
      return false;
     });
     // append in first time
     $('body').append(modal_edit);
    });
</script>
