@php
$random = Str::random(6);
@endphp
<script type="text/javascript">
  function isValidaudioUrl(urlString){
    let url;
    try {
          url =new URL(urlString);
      }
      catch(e){
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
  }

function getaudioURL(audio){
  return isValidaudioUrl(audio)?audio:'{{ url('storage') }}/'+audio;
}

function modalAudio(audio,id,modalbsid){
  var modal =  `
  <!-- Modal -->
<div class="modal fade" id="`+modalbsid+`" tabindex="-1" aria-labelledby="audio" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body audio_body_{{ $resourceName }}`+id+`">

      </div>
    </div>
  </div>
</div>
<!--Modal: Media audio-->
  `;
$('.audiosModal{{ $resourceName }}').append(modal);

$( "#audio_box_{{ $resourceName }}"+id ).on('shown.bs.modal', function(){
    $('.audio_body_{{ $resourceName }}'+id).html(`
    <center>
        <audio  controls  width="465">
          <source src="`+audio+`" type="audio/mp4"  >
        </audio>
        </center>
    `);
});

$( "#audio_box_{{ $resourceName }}"+id ).on('hidden.bs.modal', function(){
    $('.audio_body_{{ $resourceName }}'+id).empty();
});


}


</script>

<span class="audiosModal{{ $resourceName }}"></span>
