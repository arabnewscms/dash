{{--
bg-gradient-primary shadow-primary

bg-gradient-success shadow-success

bg-gradient-info shadow-info

bg-gradient-dark shadow-dark

 --}}

<div class="col-lg-{{ $column }} col-sm-6 mb-lg-0 mb-4">
  <div class="card mb-2">
    <div class="card-header p-3 pt-2">
      <div class="icon icon-lg icon-shape bg-gradient-{{ $iconColor }} shadow-{{ $iconColor }} {{ app()->getLocale()=='ar'?'shadow':'' }} text-center border-radius-xl mt-n4 position-absolute">
        <i class="material-icons opacity-10">{!! $icon??'' !!}</i>
      </div>
      <div class="{{ app()->getLocale()=='ar'?'text-start':'text-end' }}  pt-1">
        <p class="text-sm mb-0 text-capitalize">{!! $title??'' !!}</p>
        <h4 class="mb-0">{!! $content??'' !!}</h4>
      </div>
    </div>
    <hr class="{{ $iconColor }} horizontal my-0">
    <div class="card-footer p-3">
      <p class="mb-0 text-start">
           {!! $footer??'' !!}
        {{-- <span class="text-success text-sm font-weight-bolder ms-1">+55% </span>من الأسبوع الماضي --}}
      </p>
    </div>
  </div>
</div>