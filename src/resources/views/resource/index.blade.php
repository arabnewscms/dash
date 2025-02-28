@extends('dash::app')
@section('content')
    <div class="row row-sm">
        @foreach ($resource['resourceNameFull']::vertex() as $vertex)
            {!! $vertex !!}
        @endforeach
    </div>

    <div class="row row-sm">
        <div class="col-lg-12 mt-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"> {!! $resource['navigation']['icon'] ?? '' !!} {{ $title ?? '' }}</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12 border-bottom mb-2 pb-2">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                @if ($pagesRules['create'])
                                    <a href="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/new') }}"
                                        class="btn btn-light"><i class="fa fa-plus"></i> {{ __('dash::dash.create') }}</a>
                                @endif

                            </div>

                            @if ($multiSelectRecord && method_exists($resource['model'], 'trashed'))
                                <div class="col-md-2">

                                    <div class="custom-toggle-switch d-flex align-items-center mb-4">
                                        <input id="withTrashed{{ $resourceName }}" name="withTrashed" value="yes"
                                            type="checkbox">
                                        <label for="withTrashed{{ $resourceName }}" class="label-dark"></label>
                                        <span class="ms-3 text-dark">{{ __('dash::dash.withTrashed') }}</span>
                                    </div>

                                </div>
                            @endif

                            <div class="col-md-8">

                                @include('dash::resource.actions.index_actions')
                            </div>

                        </div>
                    </div>
                    {{--  <div class="table-responsive">  --}}
                    <table
                        class="table table-bordered text-nowrap key-buttons border-bottom dataTable no-footer datatable_resource{{ $resourceName }}"
                        id="datatable_resource{{ $resourceName }}" role="grid" aria-describedby="file-datatable_info">
                        <thead>
                            <tr>
                                @if ($multiSelectRecord)
                                    <th class="text-xs text-default center" style="width: 15px">
                                        <input class="form-check-input selectAll{{ $resourceName }}" type="checkbox" />
                                    </th>
                                @endif
                                @foreach ($fields as $key => $value)
                                    @if ($value['show_rules']['showInIndex'])
                                        <th class="border-bottom-0">
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
                                                <th class="border-bottom-0">
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
                    {{--  </div>  --}}
                </div>
            </div>
        </div>
    </div>



    @include('dash::resource.datatable')
@endsection
