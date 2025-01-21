@php
$random = Str::random(6);
@endphp
<script type="text/javascript">
  function isValidVideoUrl(urlString){
    let url;
    try {
          url =new URL(urlString);
      }
      catch(e){
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
  }

function getVideoURL(video){
  return isValidVideoUrl(video)?video:'{{ url('storage') }}/'+video;
}

function modalVideo(video,id,modalbsid){
  var modal =  `
  <!-- Modal -->
<div class="modal fade" id="`+modalbsid+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body video_body_{{ $resourceName }}`+id+`"></div>
    </div>
  </div>
</div>
<!--Modal: Media Video-->
  `;
$('.videosModal{{ $resourceName }}').append(modal);



$( "#video_box_{{ $resourceName }}"+id ).on('shown.bs.modal', function(){
    $('.video_body_{{ $resourceName }}'+id).html(`
      <video  controls  width="465">
        <source src="`+video+`" type="video/mp4"  >
      </video>
    `);
});

$( "#video_box_{{ $resourceName }}"+id ).on('hidden.bs.modal', function(){
    $('.video_body_{{ $resourceName }}'+id).empty();
});


}


</script>

<span class="videosModal{{ $resourceName }}"></span>
