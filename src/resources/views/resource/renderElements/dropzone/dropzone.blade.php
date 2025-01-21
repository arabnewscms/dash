@php
 if($type == 'create'){
  $showOrHide = $field['show_rules']['showInCreate']??true;
 }else{
  $showOrHide = $field['show_rules']['showInUpdate']??true;
 }
@endphp


{{-- showOrHide Start --}}
@if($showOrHide)
@php
// Time to temp id
$temp_id = !empty(request('temp_id'))?request('temp_id'):(time()*rand(0000,9999));

// Prepare temp path and id to rename it in store function
 if(!empty($type) && $type == 'create'){
  $path = $path.'/tempfile_'.$temp_id;
  $id = $temp_id;
 }elseif(!empty($type) && $type == 'edit'){
  $path = $path.'/'.$model->id;
  $id = $model->id;
 }else{
  $path = $path.'/tempfile_'.$temp_id;
  $id = $temp_id;
 }


@endphp
<input type="hidden" name="temp_id" value="{{ $temp_id }}">
<input type="hidden" name="dz_path" value="{{ $path }}">
<input type="hidden" name="dz_type" value="{{ $type }}">
<input type="hidden" name="dz_id" value="{{ $id }}">
@php
if($type == 'create'){
    $col = isset($field['columnWhenCreate'])?$field['columnWhenCreate']:$field['column'];
   }else{
    $col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];
   }
@endphp
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute']??'' }}" id="drop_{{ $dz_param }}">
  <div class="card card-default">
    <div class="card-header">
      <h6 class="card-title"> {{ $field['name'] }}</h6>
      @if(isset($field['help']))
        {!! $field['help'] !!}
      @endif
    </div>
    <div class="card-body">
      <div id="actions_{{ $dz_param }}" class="row">
        <div class="col-lg-8">
          <div class="row w-100">
            <span class="btn btn-success col-3 btn-sm m-1 col fileinput-button_{{ $dz_param }} dz-clickable">
              <i class="fas fa-plus"></i>
              <span>{{ __('dash::dash.add_files') }}</span>
            </span>
            <a href="javascript: void(0)" class="btn  col-3 btn-sm m-1 btn-info col start_{{ $dz_param }} hidden">
            <i class="fas fa-upload"></i>
            <span>{{ __('dash::dash.start_upload') }}</span>
            </a>
            <button type="reset" class="btn col-3 btn-sm m-1 btn-warning col cancel_{{ $dz_param }} hidden">
            <i class="fas fa-times-circle"></i>
            <span>{{ __('dash::dash.cancel_upload') }}</span>
            </button>
          </div>
        </div>
        <div class="col-lg-12 p-3 align-items-center">
          <div class="row">
          <div><center>{{ __('dash::dash.drag_drop_files_here') }}</center></div>
          <div class="fileupload-process w-100">


            <div  id="{{ $dz_param }}-total-progress" class="progress progress-md mb-3" style="opacity: 0;">
                <div class="progress-bar bg-primary" style="width: 0%" data-dz-uploadprogress></div>
             </div>

          </div>
          </div>
        </div>
      </div>
      <hr />
      <!--start Previews Template-->
      <div class="dropzone_delete_loader d-none col-12">
        <center><i class="fa-solid fa-spin fa-spinner fa-2x"></i></center>
      </div>
      <div class="table table-striped files" id="previews_{{ $dz_param }}">
        <div id="multi_upload_dropzone_{{ $dz_param }}" class="file-row">
          <!-- This is used as the file preview template -->
          <div>
            <div class="col-md-12">
              <small class="error text-danger" data-dz-errormessage></small>
            </div>
            <div class="col-md-12">
              <div class="row align-items-center h-100">
              <div class="col-md-6">
                  <div class="row align-items-center h-100">
                  <div class="col-md-4">
                    <span class="preview_{{ $dz_param }}">
                    <img data-dz-thumbnail style="width:{{ !empty($thumbnailWidth)?$thumbnailWidth:80 }}px;height: {{ !empty($thumbnailHeight)?$thumbnailHeight:80 }}px;cursor: pointer;" />
                    </span>
                  </div>
                  <div class="col-md-8">
                  <p class="name {{ session('DARK_MODE',config('dash.DARK_MODE'))  == 'on'?'text-white':'text-dark' }}" data-dz-name></p>
                  <p class="size {{ session('DARK_MODE',config('dash.DARK_MODE'))  == 'on'?'text-white':'text-dark' }}" data-dz-size></p>
                  </div>
                  </div>
              </div>
              <div class="col-md-6">
                    <a href="javascript: void(0)" class="btn btn-info start_{{ $dz_param }}">
                      <i class="fa fa-upload"></i>
                      <span>{{ __('dash::dash.start') }}</span>
                    </a>
                    <a href="javascript: void(0)" data-dz-remove class="btn btn-warning cancel_{{ $dz_param }}">
                      <i class="fa fa-ban"></i>
                      <span>{{ __('dash::dash.cancel') }}</span>
                    </a>
                    <a href="javascript: void(0)" data-dz-remove class="btn btn-danger delete_{{ $dz_param }}">
                      <i class="fa fa-trash"></i>
                      <span>{{ __('dash::dash.delete') }}</span>
                    </a>
                    <hr />

                  <div class="progress progress-md mb-3">
                    <div class="progress-bar bg-primary" style="width: 0%" data-dz-uploadprogress></div>
                 </div>

              </div>
              </div>
              <hr />
            </div>

          </div>
        </div>
      </div>
      <!--End Previews Template-->
    </div>
  </div>
</div>


<script type="text/javascript">
  // DropzoneJS Demo Code Start
  Dropzone.autoDiscover = false

  // Get the template HTML and remove it from the doumenthe template HTML and remove it from the doument
  var previewNode{{$dz_param}} = document.querySelector("#multi_upload_dropzone_{{ $dz_param }}")
  previewNode{{$dz_param}}.id = ""
  var previewTemplate = previewNode{{$dz_param}}.parentNode.innerHTML
  previewNode{{$dz_param}}.parentNode.removeChild(previewNode{{$dz_param}})

  var myDropzone{{$dz_param}} = new Dropzone(
    "#drop_{{ $dz_param }}",

     { // Make the whole body a dropzone
    timeout: "999999",
    url: "{{ url($route.'/upload/multi') }}?lang={{app()->getLocale()}}", // Set the url
    paramName:"{{ $dz_param }}",
    // crossDomain: true,
    // format: "json",
    thumbnailWidth: '{{ !empty($thumbnailWidth)?$thumbnailWidth:80 }}',
    thumbnailHeight: '{{ !empty($thumbnailHeight)?$thumbnailHeight:80 }}',
    parallelUploads: '{{ isset($field['parallelUploads'])?$field['parallelUploads']:20 }}',
    maxFiles: '{{ isset($field['maxFiles'])?$field['maxFiles']:2000 }}' ,
    maxFileSize: '{{ isset($field['maxFileSize'])?$field['maxFileSize']:30 }}' ,
    //addRemoveLinks: true,
    dictRemoveFileConfirmation:  "{{ __('dash::dash.ask_delete_file_dz') }}",
    previewTemplate: previewTemplate,
    @if(isset($field["autoQueue"]) && $field["autoQueue"] == true)
    autoQueue: 'true' , // Make sure the files aren't queued until manually added
    @else
    autoQueue: 'false' , // Make sure the files aren't queued until manually added
    @endif
    previewsContainer: "#previews_{{ $dz_param }}", // Define the container to display the previews
    clickable: ".fileinput-button_{{ $dz_param }}", // Define the element that should be used as click trigger to select files.
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'X-XSRF-TOKEN': '{{ csrf_token() }}',
        'x-csrftoken': '{{ csrf_token() }}',
    },

    @if(isset($field['acceptedMimeTypes']))
    acceptedMimeTypes:"{{ implode(',',$field['acceptedMimeTypes']) }}",
    @endif
  });

  function resetProgress(){
    document.querySelector("#{{ $dz_param }}-total-progress .progress-bar").style.width = "0%";
    document.querySelector("#{{ $dz_param }}-total-progress").style.opacity = "0";
  }


  function findMimeTypeImage(type){
    if(new RegExp("\\b"+"video"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/video.png') }}';
      }else if(new RegExp("\\b"+"wordprocessingml"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/word.png') }}';
      }else if(new RegExp("\\b"+"spreadsheetml"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/xls.jpeg') }}';
      }else if(new RegExp("\\b"+"presentationml"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/power_point.png') }}';
      }else if(new RegExp("\\b"+"audio"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/audio.jpeg') }}';
      }else if(new RegExp("\\b"+"zip"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/zip.jpeg') }}';
      }else if(new RegExp("\\b"+"pdf"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/pdf.png') }}';
      }else if(new RegExp("\\b"+"text"+"\\b").test(type)) {
        return '{{ url('dashboard/assets/img/text.png') }}';
      }else{
        return '{{ url('dashboard/assets/img/file.png') }}';
      }
  }

// Generate Random Id String//
function makeid(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

      $(document).on('click','.preview_{{ $dz_param }}',function(){
      $('.dz_viewer_{{ $dz_param }}').html('');
      var mimtype_{{ $dz_param }} = $(this).attr('mimtype');
      var url = $(this).attr('url');
      // Image
        if(mimtype_{{ $dz_param }}.match('image.*')){
          var image = `<center>
                        <img src="`+url+`" style="width:100%;height:100%;" />
                       </center>`;
           $('.dz_viewer_{{ $dz_param }}').html(image);
           $("#dz_viewer_{{ $dz_param }}").modal('show');
        }else if(mimtype_{{ $dz_param }}.match('video.*')){
         var random_video{{ $dz_param }} = makeid(10);
         var video = `
            <video class="vjs-theme-fantasy video-js" id="dz_video_viewer`+random_video{{ $dz_param }}+`" data-setup='{"controls": true, "autoplay": false, "preload": "auto"}' width="762px" height="450px" >
              <source src="`+url+`"   >
            </video>`;
           $('.dz_viewer_{{ $dz_param }}').html(video);
           $("#dz_viewer_{{ $dz_param }}").modal('show');
           // Video Player Code //

            var mplayer{{ $dz_param }} = videojs('#dz_video_viewer'+random_video{{ $dz_param }}, {
                controls: true,
                autoplay: false,
                preload: 'auto'
               });
            $("#dz_viewer_{{ $dz_param }}").on('hidden.bs.modal', function() {
             mplayer{{ $dz_param }}.pause();
            });
           // Video Player Code //
        }else if(mimtype_{{ $dz_param }}.match('audio.*')){
          var audio_{{ $dz_param }} = `
          <audio controls style="width:100%">
            <source src="`+url+`">
          </audio>`;
           $('.dz_viewer_{{ $dz_param }}').html(audio_{{ $dz_param }});
           $("#dz_viewer_{{ $dz_param }}").modal('show');
           // Audio Player Code //
           $("#dz_viewer_{{ $dz_param }}").on('hidden.bs.modal', function() {
             $('audio')[0].pause();
           });
           // Audio Player Code //
        }else{
          var win_{{ $dz_param }} = window.open(url, '_blank');
          if (win_{{ $dz_param }}) {
              win_{{ $dz_param }}.focus();
          } else {
              alert('Please allow popups for this website');
          }
        }
      });




    //Add existing files into dropzone
@php

$dz_files = \Dash\Models\FileManagerModel::orderBy('id','asc');
    // if(isset($field['acceptedMimeTypes']) && count($field['acceptedMimeTypes']) > 0){
    //    foreach($field['acceptedMimeTypes'] as $mime){
    //       if(preg_match('/^image/i',implode('|',$field['acceptedMimeTypes']))){
    //         $extract_name = explode('/',$mime);
    //          $dz_files->where('mimtype','LIKE','%'.$extract_name[0].'%');
    //       }
    //     }
    // }
$get_dz_files = $dz_files->where('file_type',strval(get_class($model)))->where('file_id',$id)->get();
$mimetypes = isset($field['acceptedMimeTypes'])? array_filter($field['acceptedMimeTypes']):'';
// || preg_match('/^image/i',$field['acceptedMimeTypes'])
//@if(in_array($file->mimtype,explode('|',$field['acceptedMimeTypes'])))
//@endif
@endphp
    var i=0;
        @foreach($get_dz_files as $file)

        var mockFile = {
          name: '{{ $file->name }}',
          size: '{{ $file->size_bytes }}',
          type: '{{ $file->mimtype }}',
          serverID: '{{ $file->id }}',
          accepted: true
        }; // use actual id server uses to identify the file (e.g. DB unique identifier)

        myDropzone{{$dz_param}}.emit("addedfile", mockFile);
        @if(preg_match('/image/i',$file->mimtype))
         myDropzone{{$dz_param}}.emit('thumbnail', mockFile, '{{ $file->url }}');

        @else
         myDropzone{{$dz_param}}.emit('thumbnail', mockFile, findMimeTypeImage('{{ $file->mimtype }}'));
        @endif
        myDropzone{{$dz_param}}.emit("success", mockFile);
        myDropzone{{$dz_param}}.emit("complete", mockFile);
        myDropzone{{$dz_param}}.files.push(mockFile);

        $('.start_{{ $dz_param }},.cancel_{{ $dz_param }},.progress').addClass('d-none');
        // Put File Information To Delete it
        $(myDropzone{{$dz_param}}.files[i].previewTemplate).find('.preview_{{ $dz_param }}')
        .attr("fid",'{{ $file->id }}')
        .attr("mimtype",'{{ $file->mimtype }}')
        .attr("url",'{{ $file->url }}')
        .attr("file_id",'{{ $file->file_id }}')
        .attr("file_type",'{{ str_replace('\\','\\\\',$file->file_type) }}');

        i++;

        @endforeach



    $('.start_{{ $dz_param }},.cancel_{{ $dz_param }}').addClass('d-none');
  myDropzone{{$dz_param}}.on("addedfile", function(file) {
    // Hookup the start button
    $('.start_{{ $dz_param }},.cancel_{{ $dz_param }}').removeClass('d-none');
    file.previewElement.querySelector(".start_{{ $dz_param }}").onclick = function() {
      myDropzone{{$dz_param}}.enqueueFile(file);
    }
  });



  // Update the total progress bar
  myDropzone{{$dz_param}}.on("totaluploadprogress", function(progress) {
    document.querySelector("#{{ $dz_param }}-total-progress .progress-bar").style.width = progress + "%";
    $(".progress-bar").text(Math.round(progress) + "%");
  })

  myDropzone{{$dz_param}}.on("sending", function(file, xhr, formData) {
    @if(isset($field['maxFileSize']))
    if (file.size > {{ $field['maxFileSize'] }}*1024*1024) {
      myDropzone{{$dz_param}}.removeFile(file);

       toastr.error("{{ __('dash::dash.file_too_big',['size'=>$field['maxFileSize']]) }}");

        return false;
    }
    @endif


    formData.append("dz_attach_param_name", "{{ $dz_param }}");
    formData.append("dz_path", "{{ $path }}");
    formData.append("dz_type", "{{ $type }}");
    formData.append("dz_id", "{{ $id }}");
    formData.append("_token", "{{ csrf_token() }}");
    // Show the total progress bar when upload starts
    document.querySelector("#{{ $dz_param }}-total-progress").style.opacity = "1";
    $('.progress').removeClass('d-none');
    // And hidden the start button
    $(file.previewElement).find('.start').addClass('d-none');

  });

  // Hide the total progress bar when nothing's uploading anymore
  myDropzone{{$dz_param}}.on("queuecomplete", function(progress) {
    document.querySelector("#{{ $dz_param }}-total-progress").style.opacity = "0";
    $('.start_{{ $dz_param }},.cancel_{{ $dz_param }}').addClass('d-none');
  });

//  myDropzone{{$dz_param}}.confirm = function(question, accepted, rejected) {
    // Ask the question, and call accepted() or rejected() accordingly.
    // CAREFUL: rejected might not be defined. Do nothing in that case.
 // };

  // On Delete File must be remove from server also
   myDropzone{{$dz_param}}.on("removedfile", function(file) {
       resetProgress();

   // console.log(file);
    // Delete From Server by type file and type id if temp or real id

      var fid = $(file.previewElement).find('.preview_{{ $dz_param }}').attr("fid");
      var file_id = $(file.previewElement).find('.preview_{{ $dz_param }}').attr("file_id");
      var file_type = $(file.previewElement).find('.preview_{{ $dz_param }}').attr("file_type");

    if(file_id !== undefined && fid !== undefined && file_type !== undefined){
      //Ajax Delete Request
      $.ajax({
        url:'{{ url($route.'/delete/file') }}',
        dataType:'json',
        type:'post',
        data:{_token:'{{ csrf_token() }}',file_id:file_id,file_type:file_type,id:fid,lang:'{{request("lang")}}'},
        beforeSend:function(){
            $('.dropzone_delete_loader').removeClass('d-none');
        },
        success:function(){
            toastr.success("{{ __('dash::dash.file_deleted') }}");
            $('.dropzone_delete_loader').addClass('d-none');
        }
      });
    }
  });

  // myDropzone{{$dz_param}}.on("complete", function(file, response) {
  //   //maxFiles

  // });

  myDropzone{{$dz_param}}.on("error", function(file, response) {
    if(response && response.errors){
      var msg = response.errors.{{ $dz_param }}[0];

      $(file.previewElement).find('.error').text(msg);
    }
  });

  // on success and uploaded files set ids
  myDropzone{{$dz_param}}.on("success", function(file, response) {
     resetProgress();
     if(response && response.status == true){

      $(file.previewTemplate).find('.preview_{{ $dz_param }}')
      .attr("fid",response.file.id)
      .attr("file_id",response.file.file_id)
      .attr("mimtype",response.file.mimtype)
      .attr("url",response.file.url)
      .attr("file_type",response.file.file_type);
     }


     $(file.previewElement).find('.cancel_{{ $dz_param }}').addClass('d-none');
    if(!file.type.match('image.*')){
    file.previewElement.querySelector("img").src = findMimeTypeImage(file.type);
    }

  });

  // Setup the buttons for all transfers
  // The "add files" button doesn't need to be setup because the config
  // `clickable` has already been specified.
  document.querySelector("#actions_{{ $dz_param }} .start_{{ $dz_param }}").onclick = function() {
    myDropzone{{$dz_param}}.enqueueFiles(myDropzone{{$dz_param}}.getFilesWithStatus(Dropzone.ADDED));
  }

  document.querySelector("#actions_{{ $dz_param }} .cancel_{{ $dz_param }}").onclick = function() {
     $('.start_{{ $dz_param }},.cancel_{{ $dz_param }}').addClass('d-none');
    document.querySelector("#{{ $dz_param }}-total-progress").style.opacity = "0";
    myDropzone{{$dz_param}}.removeAllFiles(true);
    return false;
  }


  // DropzoneJS Code End
</script>

<!--View Image Modal -->
<div id="dz_viewer_{{ $dz_param }}" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="">
        <button type="button" class="btn btn-light btn-sm float-left" data-dismiss="modal">x</button>
      </div>
      <div class="modal-body">
        <span class="dz_viewer_{{ $dz_param }}">

        </span>
      </div>
    </div>
  </div>
</div>
<!--View Image Modal End-->
@endif
{{-- showOrHide End --}}
