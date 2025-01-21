@extends('dash::app')
@section('content')
<div class="page responsive-log error-bg">
    <div class="page-content m-0">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <img src="{{ url('dashboard/assets/dashtemplate/images/png/error.png') }}" alt="img" class="mt-7">
                </div>
                <div class="col-md-7 mt-6">
                    <div class="display-1 text-primary  mb-2 font-weight-semibold"> 403</div>
                    <h1 class="h3  mb-3 font-weight-semibold">{{__('dash::dash.attention')}}</h1>
                    <p class="h5 font-weight-normal mb-7 leading-normal"> {{ __('dash::dash.need_permission_to_access_page') }} </p>
                    <a class="btn btn-primary" href="{{ dash('/') }}"><i class="fe fe-arrow-left-circle me-1"></i>{{ __('dash::dash.dashboard') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
