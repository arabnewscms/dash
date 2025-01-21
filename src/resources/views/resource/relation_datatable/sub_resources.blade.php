 @if (
     $pagesRules['index'] === false &&
         $pagesRules['show'] === false &&
         $pagesRules['create'] === false &&
         $pagesRules['store'] === false &&
         $pagesRules['edit'] === false &&
         $pagesRules['update'] === false &&
         $pagesRules['destroy'] === false &&
         $pagesRules['forceDelete'] === false &&
         $pagesRules['restore'] === false)
     <div class="col-md-12 border-bottom mb-2 pb-2">
         <div class="row align-items-center">
             <div class="card mt-4">
                 <div class="card-header p-3">
                     <h5 class="mb-0">{{ __('dash::dash.attention') }}</h5>
                     <span class="text-lg mb-1">
                         <i class="fa fa-exclamation-triangle fa-2x text-warning"></i>
                         {{ __('dash::dash.need_permission_to_access_page') }}
                     </span>
                 </div>
             </div>
         </div>
     </div>
 @else
     <div class="col-md-12 border-bottom mb-2 pb-2">
         <div class="row align-items-center">
             <div class="col-md-2">
                 @if (isset($pagesRules['create']) && $pagesRules['create'])
                     @include('dash::resource.inlineButton.inline_create', [
                         'field' => [
                             'resource' => $resource['resourceNameFull'],
                             'attribute' => $resource['resourceName'],
                             'name' => $resource['navigation']['customName'],
                         ],
                         'relationField' =>
                             'relationField[' .
                                 $loadByResourceRelation['use_method'] .
                                 ']=' .
                                 $loadByResourceRelation['record_id'] ??
                             '',
                         'placeholder' => $resource['resourceName'],
                         'labelInline' => '<i class="fa fa-plus"></i> ' . __('dash::dash.create'),
                     ])
                 @endif
             </div>
             <div class="col-md-8">
                 <div class="row">
                     @if ($multiSelectRecord && method_exists($resource['model'], 'trashed'))
                         <div class="col-3">
                             <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                 <input id="withTrashed{{ $resourceName }}" name="withTrashed" value="yes"
                                     type="checkbox">
                                 <label for="withTrashed{{ $resourceName }}" class="label-dark"></label>
                                 <span class="ms-3 text-dark">{{ __('dash::dash.withTrashed') }}</span>
                             </div>
                         </div>
                     @endif

                     <div class="col-md-6">
                         @include('dash::resource.relation_datatable.actions.index_actions')
                     </div>
                 </div>

             </div>

         </div>
     </div>




     <table
         class="table d-table table-bordered table-striped table-hover align-items-center mb-0 datatable_resource{{ $resourceName }}"
         id="datatable_resource{{ $resourceName }}" style="width:100%;" data-turbolinks="false">
         <thead>
             <tr>
                 @if ($multiSelectRecord)
                     <th class="col-1 center">
                         <input class="form-check-input selectAll{{ $resourceName }}" type="checkbox" />
                     </th>
                 @endif
                 @foreach ($fields as $key => $value)
                     @if ($value['show_rules']['showInIndex'])
                         <th class=" font-weight-bolder ">
                             {{ $value['name'] }}
                         </th>

                         {{--  Custom View Columns with belongsTo hasOne hasOnethroug etc.. Start  --}}
                         @if (isset($value['viewColumns']))
                             @php
                                 if (is_array($value['viewColumns'][0])) {
                                     $viewColumns = $value['viewColumns'][0];
                                 } elseif (is_string($value['viewColumns'][0])) {
                                     $viewColumns = $value['viewColumns'];
                                 }
                             @endphp
                             @foreach ($viewColumns as $k => $v)
                                 <th class=" font-weight-bolder">
                                     {!! str_replace('_', ' ', $v) !!}
                                 </th>
                             @endforeach
                         @endif
                         {{--  Custom View Columns with belongsTo hasOne hasOnethroug etc.. End  --}}
                     @endif
                 @endforeach
                 <th>@lang('dash::dash.action')</th>
             </tr>
         </thead>
     </table>
     @include('dash::resource.relation_datatable.sub_datatable')
 @endif
