@if(!empty($audio))
@if (!empty(request('show_with_inline')))
 <a href="{{$audio}}" target="_blank">
    <i class="fa-solid fa-file-audio" style="font-size: 22px;"></i>
</a>   
@else
@php
$random = Str::random(5);
if(!empty(explode('.',$audio)) && count(explode('.',$audio)) > 1){
$ext =   explode('.',$audio)[1];
}else{
$ext = null;
}
@endphp
@if(!empty($ext))
<div style="margin-top: 5px;display: inline-block;">
  <a href="#void"
    class="m-2"
    data-bs-toggle="modal"
    data-bs-target="#audio_{{ $random }}"
    >
    <i class="fa-solid fa-file-audio" style="font-size: 22px;"></i>
  </a>
</div>

<div class="modal fade" id="audio_{{ $random }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        <audio controls class="audioTrack{{ $random }} d-none" style="width:100%">
          <source src="{{ $audio }}" type="audio/mp4">
          Your browser does not support the audio element.
        </audio>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
$(document).ready(function(){

  $("#audio_{{ $random }}").on('shown.bs.modal', function (e) {
    $('.audioTrack{{ $random }}').removeClass('d-none');
  });

  $("#audio_{{ $random }}").on('hidden.bs.modal', function() {
   $('.audioTrack{{ $random }}')[0].pause();
  });
});
</script>
@endif
@endif
@endif