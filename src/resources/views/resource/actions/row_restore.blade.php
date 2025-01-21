@if (method_exists($resource['model'], 'trashed'))
    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.restoreRow{{ $resourceName }}', function() {
                    $('.rowRestoreForm{{ $resourceName }}').attr('action', $(this).attr('action'));
                    var rowid = $(this).attr('rowid');
                    $('.rowselect_data{{ $resourceName }}')
                        .html('{{ __('dash::dash.are_you_sure_to_restore_this_record') }} ' + (isNaN(rowid) ?
                            '' : rowid));
                    $('#rowRestore{{ $resourceName }}').modal('show');
                    return false;
                });
            });
        </script>
        <div class="modal fade" id="rowRestore{{ $resourceName }}" tabindex="-1"
            aria-labelledby="restore_modal{{ $resourceName }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <i data-bs-dismiss="modal" style="cursor: pointer;" class="fa fa-times"></i>
                    </div>
                    <div class="modal-body">
                        <form role="from" class="text-start rowRestoreForm{{ $resourceName }}" method="post">
                            <div class="input-group input-group-outline my-3">
                                <span class="rowselect_data{{ $resourceName }}"></span>
                            </div>

                            <div class="p-1">
                                @if ($pagesRules['restore'])
                                    <button type="submit" class="btn btn-success">{{ __('dash::dash.restore') }}</button>
                                    <button type="button" data-bs-dismiss="modal"
                                        class="btn btn-light">{{ __('dash::dash.cancel') }}</button>
                                @endif
                            </div>
                            @csrf
                            <input type="hidden" name="lang" value="{{ app()->getLocale() }}" />
                            <input type="hidden" name="_method" value="post">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endpush
@endif
