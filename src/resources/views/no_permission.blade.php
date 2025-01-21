@extends('dash::app')
@section('content')
<div class="col-lg-8 col-md-10 mx-auto">
	<div class="card mt-4">
		<div class="card-header p-3">
			<h5 class="mb-0">{{__('dash::dash.attention')}}</h5>
			<span class="text-lg mb-1">
			 <i class="fa fa-exclamation-triangle fa-2x text-warning"></i>	{{ __('dash::dash.need_permission_to_access_page') }}
			</span>
		</div>
	</div>
</div>
@endsection