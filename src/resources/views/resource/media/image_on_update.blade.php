@php
$rand = rand(0000,9999);
@endphp
@if (!empty(request('show_with_inline')))
 <a href="{{$imagePath}}" target="_blank">
    <img class="img-fluid rounded-circle img-thumbnail"
src="{{ $imagePath  }}" alt="image"
style="cursor: pointer;width:48px;height:48px"
data-bs-toggle="modal"
data-bs-target="#avatar_image_show{{ $rand.$id }}">
</a>   
@else
<img class="img-fluid rounded-circle img-thumbnail"
src="{{ $imagePath  }}" alt="image"
style="cursor: pointer;width:48px;height:48px"
data-bs-toggle="modal"
data-bs-target="#avatar_image_show{{ $rand.$id }}">

<div class="modal fade" id="avatar_image_show{{ $rand.$id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        <img src="{{ $imagePath }}" alt="" style="width:100%;height:100%;">
      </div>
    </div>
  </div>
</div>
@endif
