<script type="text/javascript">
    $(document).ready(function() {
        var modal_show = `
        <div class="modal fade inline_modal" id="boxModal_show" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
           <div class="modal-dialog modal-lg modal-xl">
             <div class="modal-content">
               <div class="modal-header">
                   <h6 class="modal-title show_model_label" id="boxModal_showLabel"> </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <div class="modal-body inline_modal_content content_boxModal_show"></div>
           </div>
         </div>
       </div>
        `;


        $(document).on('click', '.show_relation_row', function() {
            var record_id = $(this).attr('record_id');
            var res_name = $(this).attr('res_name');
            var res_icon = $(this).attr('res_icon');
            var res_label = $(this).attr('res_label');
            $('.show_model_label').html(res_icon + ' {{ __('dash::dash.show') }}: ' + res_label);
            $('#boxModal_show').modal('show');

            $.ajax({
                url: '{{ dash('resource') }}/' + res_name + '/' + record_id +
                    '?show_with_inline=' + new Date().getTime() +
                    '&lang={{ request('lang', app()->getLocale()) }}',
                type: 'get',
                dataType: 'html',
                processData: false,
                contentType: false,
                cache: false,
                data: {
                    lang: '{{ request('lang') }}'
                },
                beforeSend: function() {
                    $('.content_boxModal_show').empty();
                    $('.content_boxModal_show').html(`
            <center>
                <div class="spinner-border text-dark" role="status">
                <span class="sr-only">Loading...</span>
              </div>
            </center>
            `);
                },
                success: function(data) {
                    $('.content_boxModal_show').html(data);
                }
            });
            return false;
        });
        // append in first time
        $('body').append(modal_show);
    });
</script>
