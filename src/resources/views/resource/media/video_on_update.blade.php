@if(!empty($video))

@if (!empty(request('show_with_inline')))
 <a href="{{$video}}" target="_blank">
    <i class="fa fa-photo-video" style="font-size: 22px;"></i>
</a>   
@else

@php
$random = Str::random(5);
if(!empty(explode('.',$video)) && count(explode('.',$video)) > 1){
$ext = explode('.',$video)[1];
}else{
$ext = null;
}
@endphp
@if(!empty($ext))
<div style="margin-top: 5px;display: inline-block;">
  <a href="#void"
    class="m-2"
    data-bs-toggle="modal"
    data-bs-target="#video_{{ $random }}"
    >
    <i class="fa fa-photo-video" style="font-size: 22px;"></i>
  </a>
</div>
<div class="modal fade" id="video_{{ $random }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        @php
        /*
        style class change vjs-theme-fantasy to
        vjs-theme-sea or
        vjs-theme-forest or
        vjs-theme-city
        */
        @endphp
        <video class="vjs-theme-{{ $theme }} video-js hidden" id="video{{ $random }}" data-setup='{"controls": true, "autoplay": false, "preload": "auto"}' width="465" height="450px" >
          <source src="{{ $video }}" type="video/{{ $ext }}"  >
        </video>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
var mplayer;
$("#video_{{ $random }}").on('shown.bs.modal', function (e) {
mplayer =  videojs('#video{{ $random }}', {
controls: true,
autoplay: false,
preload: 'auto'
});
$('#video{{ $random }}').removeClass('hidden');
});
$("#video_{{ $random }}").on('hidden.bs.modal', function() {
mplayer.pause();
});
});
</script>
@endif
@endif
@endif