@php
    $rname = $resourceName . '_' . time();
@endphp
<form id="form_{{ $rname }}" action="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/' . $model->id) }}"
    method="post" enctype="multipart/form-data">
    <div class="col-12">
        {{ $title??'' }}
    </div>
    <div class="row">
        @csrf
        <input type="hidden" name="_method" value="put">
        @foreach ($fields as $field)
            {!! $field !!}
        @endforeach
    </div>
    <button type="button" name="edit_inline_btn{{ $rname }}" value="edit_inline_btn{{ $rname }}"
        class="btn edit_inline_btn{{ $rname }} btn-light">
        <i class="fa fa-edit"></i> {{ __('dash::dash.save') }}
    </button>
</form>
@include('dash::resource.ajax.submit_form_ajax_inline', [
    'resourceName' => $rname,
    'form' => 'form_' . $rname,
    'add_inline_btn' => 'edit_inline_btn' . $rname,
])
