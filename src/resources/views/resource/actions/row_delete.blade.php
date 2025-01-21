@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.deleteRow{{ $resourceName }}', function() {
                $('.rowDeleteForm{{ $resourceName }}').attr('action', $(this).attr('action'));
                var rowid = $(this).attr('rowid');
                $('.rowselect_data{{ $resourceName }}')
                    .html('{{ __('dash::dash.ask_delete') }} ' + (isNaN(rowid) ? '' : rowid));
                $('#rowDelete{{ $resourceName }}').modal('show');
                return false;
            });
        });
    </script>
    <div class="modal fade" id="rowDelete{{ $resourceName }}" tabindex="-1" aria-labelledby="delete_modal{{ $resourceName }}"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i data-bs-dismiss="modal" style="cursor: pointer;" class="fa fa-times"></i>
                </div>
                <div class="modal-body">
                    <form role="from" class="text-start rowDeleteForm{{ $resourceName }}" method="post">
                        <div class="input-group input-group-outline my-3">
                            <span class="rowselect_data{{ $resourceName }}"></span>
                        </div>

                        <div class="p-2">
                            <div class="row">
                                <div class="col-md-8">
                                    @if ($pagesRules['destroy'])
                                        <button type="submit" class="btn btn-danger">{{ __('dash::dash.delete') }}</button>
                                        <button type="button" data-bs-dismiss="modal"
                                            class="btn btn-light">{{ __('dash::dash.cancel') }}</button>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if ($pagesRules['forceDelete'] && method_exists($resource['model'], 'trashed'))
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="forceDelete"
                                                value="yes" id="forceDelete">
                                            <label class="form-check-label mb-0 ms-3"
                                                for="forceDelete">{{ __('dash::dash.forceDelete') }}</label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @csrf
                        <input type="hidden" name="lang" value="{{ app()->getLocale() }}" />
                        <input type="hidden" name="_method" value="delete">
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush
