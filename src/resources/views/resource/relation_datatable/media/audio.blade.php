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

function modalAudio(audio,id){
  var modal =  `
  <!-- Modal -->
<div class="modal fade" id="audio_box_{{ $resourceName }}`+id+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        <center>
        <audio  controls  width="465">
          <source src="`+audio+`" type="audio/mp4"  >
        </audio>
        </center>
      </div>
    </div>
  </div>
</div>
<!--Modal: Media audio-->
  `;
$('.audiosModal{{ $resourceName }}').append(modal);


}


</script>

<span class="audiosModal{{ $resourceName }}"></span>
