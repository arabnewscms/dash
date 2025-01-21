<div class="fixed-plugin d-none">
  <a class="fixed-plugin-button text-dark position-fixed px-3 py-2">
    <i class="fa fa-cogs py-2"></i>
  </a>
  <div class="card shadow-lg">
    <div class="card-header pb-0 pt-3">
      <div class="float-end">
        <h5 class="mt-3 mb-0">@lang('dash::dash.dashboard_colors')</h5>
        <p></p>
      </div>
      <div class="float-start mt-4">
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
        <i class="material-icons">clear</i>
        </button>
      </div>
      <!-- End Toggle Button -->
    </div>
    <hr class="horizontal dark my-1">
    <div class="card-body pt-sm-3 pt-0">
      <!-- Sidebar Backgrounds -->
      <div>
        <h6 class="mb-0">@lang('dash::dash.SidebarColors')</h6>
      </div>
      <a href="javascript:void(0)" class="switch-trigger background-color">
        <div class="badge-colors my-2 text-end">
          <span class="badge filter bg-gradient-primary active" data-color="primary" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-dark" data-color="dark" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-info" data-color="info" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-success" data-color="success" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-warning" data-color="warning" onclick="sidebarColor(this)"></span>
          <span class="badge filter bg-gradient-danger" data-color="danger" onclick="sidebarColor(this)"></span>
        </div>
      </a>
      <!-- Sidenav Type -->
      <div class="mt-3">
        <h6 class="mb-0">@lang('dash::dash.SidenavType')</h6>
        <p class="text-sm">@lang('dash::dash.SidenavType_')</p>
      </div>
      <div class="d-flex">
        <button class="btn bg-gradient-dark px-3 mb-2 active" data-class="bg-gradient-dark" onclick="sidebarType(this)">@lang('dash::dash.Dark')</button>
        <button class="btn bg-gradient-dark px-3 mb-2 {{ app()->getLocale() == 'ar'?'me-2':'ms-2' }}" data-class="bg-transparent" onclick="sidebarType(this)">@lang('dash::dash.Transparent')</button>
        <button class="btn bg-gradient-dark px-3 mb-2 {{ app()->getLocale() == 'ar'?'me-2':'ms-2' }}" data-class="bg-white" onclick="sidebarType(this)">@lang('dash::dash.White')</button>
      </div>
      <p class="text-sm d-xl-none d-block mt-2">You can change the sidenav type just on desktop view.</p>
      <!-- Navbar Fixed -->
      <div class="mt-3 d-flex">
        <h6 class="mb-0">@lang('dash::dash.NavbarFixed')</h6>
        <div class="form-check form-switch me-auto my-auto">
          <input class="form-check-input mt-1 float-end me-auto" type="checkbox" id="navbarFixed" onclick="navbarFixed(this)">
        </div>
      </div>
      <hr class="horizontal dark my-3">
      <div class="mt-2 d-flex">
        <h6 class="mb-0">@lang('dash::dash.LightDark')</h6>
        <div class="form-check form-switch me-auto my-auto">
          <input class="form-check-input mt-1 float-end me-auto" type="checkbox" id="dark-version" onclick="darkMode(this)">
        </div>
      </div>
      <hr class="horizontal dark my-sm-4">

    </div>
  </div>
</div>
@push('js')
<script type="text/javascript">
 function updateUi(data){
  data._token = '{{ csrf_token() }}';
  data.lang = '{{ request('lang') }}';
  $.ajax({
      url:'{{ url($DASHBOARD_PATH.'/ui') }}',
      dataType:'json',
      type:'post',
      data:data
    });
 }

$(document).ready(function(){

  $(document).on('change','#navbarFixed',function(){
    var nf = $(this).is(':checked')?'yes':'no';
    updateUi({navbarFixed:nf});
  });

  $(document).on('change','#dark-version',function(){
    var dv = $(this).is(':checked')?'yes':'no';
    updateUi({darkVersion:dv});
  });

  var buttons = 'button[data-class="bg-transparent"],button[data-class="bg-gradient-dark"],button[data-class="bg-white"]';

  $(document).on('click',buttons,function(){
    var btn = $(this);

    updateUi({bg:btn.attr('data-class')});
  });

  var datacolor = 'span[data-color="dark"],span[data-color="primary"],span[data-color="info"],span[data-color="success"],span[data-color="warning"],span[data-color="danger"]';

  $(document).on('click',datacolor,function(){
    var dc = $(this);
    updateUi({color:dc.attr('data-color')});
  });

  @if(session('ui.navbarFixed') == 'no' || !session()->has('ui.navbarFixed'))
   //$('#navbarFixed').trigger('click');
  @endif

  @if(session('ui.darkVersion') == 'yes')
   $('#dark-version').trigger('click');
  @endif

  @if(session('ui.bg') != '')
  $('button[data-class="{{ session('ui.bg') }}"]').trigger('click');
  @endif

  @if(session('ui.color') != '')
  $('span[data-color="{{ session('ui.color') }}"]').trigger('click');
  @endif

});
</script>
@endpush
