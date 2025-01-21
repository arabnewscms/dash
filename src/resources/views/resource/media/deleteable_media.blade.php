<a href="#void" target="_blank" data-bs-toggle="modal"
data-bs-target="#deleteable{{ $column.$id }}" ><i class="fa fa-trash" style="font-size: 22px;"></i></a>

<div class="modal fade" id="deleteable{{ $column.$id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body deleteableContent{{ $column.$id }}">

        {{ __('dash::dash.are_you_sure_delete') }}

      </div>
      <div class="modal-footer justify-content-between">

        <div class="w-100">
        <a class="btn btn-danger delete_file{{ $column.$id }}"><i class="fa fa-trash"></i> {{ __('dash::dash.delete') }}</a>
        <a class="btn btn-light" data-bs-dismiss="modal"><i class="fa fa-times-circle"></i> {{ __('dash::dash.cancel') }}</a>
        </div>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
  $(document).on('click','.delete_file{{ $column.$id }}',function(){
    $.ajax({
      url:'{{ url(app('dash')['DASHBOARD_PATH'].'/deletable/by/model') }}',
      dataType:'json',
      type:'post',
      data:{
            _token:'{{ csrf_token() }}',
            column:'{{ $column }}',
            id:'{{ $id }}',
            model:'{{ str_replace('\\','\\\\',$model) }}',
            file:'{{ $file }}',
            lang:'{{request("lang")}}'
           },
      beforeSend: function(){
        $('.deleteableContent{{ $column.$id }}').html('{{ __('dash::dash.deletable') }} <i class="fa fa-spinner fa-spin"></i>');
      },success: function(data){
        if(data.status){
          $('#deleteable{{ $column.$id }}').modal('hide');
          $('.deletable_media_box_{{ $column.$id }}').remove();
        }else{
          $('.deleteableContent{{ $column.$id }}').html('{{ __('dash::dash.unknown_error') }}');
        }
      }
    });

  });
});
</script>
