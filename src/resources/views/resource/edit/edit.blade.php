@extends('dash::app')
@section('content')


		<div class="col-12">
			<div class="card">
				<div class="card-header">
                 <h6 class="text-dark card-title float-start text-capitalize ">{!! $resource['navigation']['icon']??'' !!} {{ $title??'' }} </h6>

				</div>
				<div class="card-body px-3 pb-2">
                    <div class="float-end">
                        @if($pagesRules['create'])
                        <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/new') }}" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i>
                        </a>
                        @endif
                        @if($pagesRules['show'])
                        <a href="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/'.$model->id) }}" class="btn btn-light btn-sm">
                            <i class="fa fa-eye"></i>
                        </a>
                        @endif
                        @if($pagesRules['destroy'])
                        <a href="#void" action="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/'.$model->id) }}" rowid="{{ $model->id }}"  class="btn btn-danger deleteRow{{ $resourceName }} btn-sm">
                            <i class="fa fa-trash"></i>
                        </a>
                        @push('js')
                        @include('dash::resource.relation_datatable.actions.row_delete',[
                        'resourceName'=>$resourceName
                        ])
                        @endpush
                        @endif
                     </div>
                     <div class="clearfix"></div>

					<form id="form" action="{{ url(app('dash')['DASHBOARD_PATH'].'/resource/'.$resourceName.'/'.$model->id) }}" method="post" enctype="multipart/form-data">
						<div class="row">
							@csrf
							<input type="hidden" name="_method" value="put">
							@foreach($fields as $field)
							{!! $field !!}
							@endforeach
						</div>
						<button type="submit" name="save" value="edit" class="btn add btn-light"><i class="fa fa-save"></i> {{ __('dash::dash.save') }}</button>
						<button type="submit" name="save" value="edit_again" class="btn save_and_edit btn-light"><i class="fa fa-edit"></i> {{ __('dash::dash.save') }} & {{ __('dash::dash.and_edit') }}</button>

						<button type="submit" name="save" value="edit_show" class="btn save_and_edit btn-light">
							<i class="fa-solid fa-eye"></i>  {{ __('dash::dash.edit_show') }}
						</button>
                        <button type="submit" name="save" value="edit_add" class="btn save_and_edit btn-light">
							<i class="fa-solid fa-plus"></i>  {{ __('dash::dash.edit_add') }}
						</button>
					</form>
				</div>
			</div>
		</div>

@push('js')
@include('dash::resource.ajax.submit_form_ajax')
@endpush
@endsection
