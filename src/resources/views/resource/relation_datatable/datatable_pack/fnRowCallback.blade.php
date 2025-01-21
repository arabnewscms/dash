$('.dataTables_filter input').attr('placeholder','@lang('dash::dash.search')');

$('.dt-buttons').show();
$('.buttons-excel').attr("title","{{ __('dash::dash.excel') }}").html(`<i class="fa-solid fa-file-excel"></i>`);
$('.buttons-csv').attr('title',"{{ __('dash::dash.csv') }}").html(`<i class="fa-solid fa-file-excel"></i>`);
$('.buttons-print').attr("title","{{ __('dash::dash.print') }}").html(`<i class="fa fa-print"></i>`);
$('.buttons-pdf').attr("title","{{ __('dash::dash.pdf') }}").html(`<span title=" "><i class="fa-solid fa-file-pdf"></i> </span>`);
$('.buttons-copy').attr("title","{{ __('dash::dash.copy') }}").html(`<i class="fa fa-copy"></i>`);

@if(app()->getLocale()=='ar')
$('.dt-buttons button').addClass('m-0');

$('.dataTables_filter').addClass('float-start');
@else
$('.dataTables_length').addClass('float-start');
@endif
{{-- $('.dataTables_length select').select2({
    language: "{{ app()->getLocale() == 'ar'?'ar':'en' }}",
}); --}}
