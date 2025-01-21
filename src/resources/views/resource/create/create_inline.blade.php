@php
$rname = $resourceName.'_'.time();
@endphp
<form id="form_{{ $rname }}" action="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName) }}"
    method="post" enctype="multipart/form-data">
    <div class="row">
        @csrf
        <input type="hidden" name="_method" value="post">
        @foreach ($fields as $field)
            {!! $field !!}
        @endforeach
    </div>
    <button type="button" name="add_inline_btn{{ $rname }}" value="add_inline_btn{{ $rname }}" class="btn add_inline_btn{{ $rname }} btn-light">
        <i class="fa-solid fa-plus"></i> {{ __('dash::dash.add') }}
    </button>
</form>

@include('dash::resource.ajax.submit_form_ajax_inline', [
    'resourceName' => $rname,
    'form' => 'form_' . $rname,
    'add_inline_btn'=>'add_inline_btn'.$rname,
])
