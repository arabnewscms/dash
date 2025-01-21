<script type="text/javascript">
  function isValidUrl(urlString){
    let url;
    try {
          url =new URL(urlString);
      }
      catch(e){
        return false;
      }
      return url.protocol === "http:" || url.protocol === "https:";
  }

function getImageURL(image){
  return isValidUrl(image)?image:'{{ url('storage') }}/'+image;
}

function modalImage(imagePath,id,modalbsid){
  var modal =  `
  <!-- Modal -->
<div class="modal fade" id="`+modalbsid+`" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
           <img src="`+imagePath+`" alt="" style="width:100%;height:100%;">
      </div>
    </div>
  </div>
</div>

<!--Modal: Media Image-->
  `;
 $('.imagesModal').append(modal);

}
</script>

<span class="imagesModal"></span>
