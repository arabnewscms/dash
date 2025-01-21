@extends('dash::app')
@section('content')
<div class="page responsive-log error-bg">
    <div class="page-content m-0">
        <div class="container text-center">
            <div class="display-1 text-primary mb-5 font-weight-bold">4<span class="fa-regular fa-face-frown"></span>4</div>
            <h1 class="h3  mb-3 font-weight-semibold">Sorry, an error has occured, Requested Page not found!</h1>
            <p class="h5 font-weight-normal mb-7 leading-normal">You may have mistyped the address or the page may have moved.</p>
            <a class="btn btn-primary" href="{{dash('/')}}"><i class="fe fe-arrow-left-circle me-1"></i>Back to Home</a>
        </div>
    </div>
</div>
@endsection
