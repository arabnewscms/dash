@if($multiSelectRecord && method_exists($resource['model'],'trashed'))
<div class="modal fade" id="restoreAll{{ $resourceName }}" tabindex="-1" aria-labelledby="restoremodal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <i data-bs-dismiss="modal"  style="cursor: pointer;" class="fa fa-times"></i>
      </div>
      <div class="modal-body">
        <form role="from" class="text-start" action="{{ url($DASHBOARD_PATH.'/resource/'.$resource['resourceName']) }}/multi/restore" method="post">
          <div class="input-group input-group-outline my-3">
            <span class="mutliselect_data{{ $resourceName }}"></span>
          </div>

          <div class="modal-footer">
            <button type="submit" class="btn btn-success">{{__('dash::dash.restore')}}</button>
            <button type="button"  data-bs-dismiss="modal" class="btn btn-light">{{__('dash::dash.cancel')}}</button>
          </div>
          @csrf
          <input type="hidden" name="lang" value="{{app()->getLocale()}}" />
          <input type="hidden" name="_method" value="post">
        </form>
      </div>
    </div>
  </div>
</div>
@endif
