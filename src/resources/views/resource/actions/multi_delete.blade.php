@if($multiSelectRecord  )
<div class="modal fade" id="deleteAll{{ $resourceName }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        <form role="from" class="text-start" action="{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/multi/delete" method="post">
          <div class="input-group input-group-outline my-3">
            <span class="mutliselect_data{{ $resourceName }}"></span>
          </div>
          <div class="p-1">
            <div class="row">
              <div class="col-8">
                @if($pagesRules['destroy'])
                <button type="submit" class="btn btn-danger">{{__('dash::dash.delete')}}</button>
                <button type="button"  data-bs-dismiss="modal" class="btn btn-light">{{__('dash::dash.cancel')}}</button>
                @endif
              </div>
              <div class="col-4">
                @if($pagesRules['forceDelete'] && method_exists($resource['model'],'trashed'))
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" name="forceDelete" value="yes" id="forceDelete">
                  <label class="form-check-label mb-0 ms-3" for="forceDelete">{{ __('dash::dash.forceDelete') }}</label>
                </div>
                @endif
              </div>
            </div>
          </div>
          @csrf
          <input type="hidden" name="lang" value="{{app()->getLocale()}}" />
          <input type="hidden" name="_method" value="delete">
        </form>
      </div>
    </div>
  </div>
</div>
@endif
