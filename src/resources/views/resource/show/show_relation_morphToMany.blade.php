<div class="container-fluid py-1">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header">
                    <h6 class="text-dark text-capitalize {{ app()->getLocale() == 'ar' ? 'px-3' : 'ps-3' }}">
                        {!! $field['resource']::$icon ?? '' !!} {{ $label }}</h6>
                </div>
                <div class="card-body px-3 pb-2">

                    <div class="LoadResourceLoading{{ $subResouce }}"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $.ajax({
                type: 'post',
                url: '{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $subResouce . '/sub/resource') }}',
                dataType: 'html',
                data: {
                    _token: '{{ csrf_token() }}',
                    lang: '{{ request('lang') }}',
                    relation_type: '{{ $field['type'] }}',
                    attribute: '{{ $method }}',
                    model: '{{ str_replace('\\', '._.', $model) }}',
                    record_id: '{{ $record_id }}',
                    main_resource: '{{ request()->segment(3) }}'
                },
                beforeSend: function() {
                    $('.LoadResourceLoading{{ $subResouce }}').html(
                        '<center><i class="fa fa-spin fa-spinner"></i></center>');
                },
                success: function(result) {
                    $('.LoadResourceLoading{{ $subResouce }}').html(result);
                },
                error: function(error) {
                    toastr.error('Error Response please check response from your network');

                }
            })
        });
    </script>
@endpush
