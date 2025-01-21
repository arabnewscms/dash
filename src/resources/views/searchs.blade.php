<div class="form-inline">
    <div class="search-element">
        <input type="search" class="form-control search header-search" placeholder="@lang('dash::dash.search')" aria-label="Search" tabindex="1">
        <div id="output_main_search"
        class="dropdown-menu border border-top-0 border-dark p-0"
        style="width: 26%;max-height: 300px;overflow: auto;position: fixed;top: 64px;  {{app()->getLocale() == 'ar'?'right:24%':'left:25%' }} ">
        </div>
    </div>
</div>


@push('js')
<script type="text/javascript">
$(document).ready(function(){
  var keytimer;
  $(document).on('keydown keyup','.search',function(){
      $("#output_main_search").empty().removeClass('show');
       clearTimeout(keytimer);
      keytimer = setTimeout(doSearch, 500);
  });

function doSearch() {
  var search = $('.search').val();
  if(search != ''){
  $.ajax({
    url:'{{ url(app('dash')['DASHBOARD_PATH'].'/main/search') }}',
    dataType:'html',
    type:'post',
    data:{_token:'{{ csrf_token() }}',search:search,lang:"{{request("lang")}}"},
    beforeSend:function(){
      $('#output_main_search').addClass('show');
      $("#output_main_search").html(`<center><span class="spinner-border text-primary" role="status"></span></center>`);
    },success: function(data){
      $("#output_main_search").html(data).css('height: 195px;');
    }
  });
  }
}

$(document).on('click','body',function(){
 $("#output_main_search").empty().removeClass('show');
});

});
</script>
@endpush
