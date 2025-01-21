var formId = $('{{ $element }}').parents('form').attr('id');


var select2Options = {
//theme: 'bootstrap-5',
language: "{{ app()->getLocale() == 'ar' ? 'ar' : 'en' }}",
dir: "{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}",
placeholder:'{{ __('dash::dash.choose_from_list') }}',
width:'100%',
allowClear: true
@if (!empty($dynamic))
    ,ajax: {
    quietMillis: 10,
    cache: true,
    url: '{{ dash('select2/load/data') }}',
    type:'post',
    delay: 250,
    dataType: 'json',
    data: function (params) {

    var model = $('{{ $element }}').attr('model');
    var queryStr = $('{{ $element }}').attr('query');
    var searchKey = $('{{ $element }}').attr('searchKey');
    var withTrashed = $('#withTrashed{{ $attribute }}').is(':checked')?true:false;

    var column = $('{{ $element }}').attr('column');
    var parent = $('{{ $element }}').attr('parent');
    if(parent != ''){
    var parent_value = $('.'+parent+' option:selected').val();
    }else{
    var parent_value = '';
    }

    var query = {
    _token:'{{ csrf_token() }}',
    search: params.term,
    searchKey: searchKey,
    // parent && Child
    column: column,
    parent_value: parent_value,
    // parent && Child End
    lang:"{{ app()->getLocale() }}",
    model: model,
    queryStr: queryStr,
    withTrashed: withTrashed,
    page: params.page || 1
    };

    // Query parameters will be ?search=[term]&type=public
    return query;
    },
    processResults: function (data) {
    return data;
    // return {
    // results: data // id and text
    // };
    },
    initSelection : function (element, callback) {
    var data = {id: 1, text: ''};
    callback(data);
    }
    },
    minimumInputLength: 0,
    maximumSelectionLength: 0
@endif
};

@if (!empty($dropdownParent))
    select2Options.dropdownParent = $('{{ $dropdownParent }}') ,
@else
    var inline_modal_select2_fix_focused = $('select{{ $element }}').parents('.modal').attr('id');
    if(inline_modal_select2_fix_focused != 'undefined' && inline_modal_select2_fix_focused != undefined){
    select2Options.dropdownParent = $('#'+inline_modal_select2_fix_focused);
    }
@endif



$('{{ $element }}').select2(select2Options);

$('{{ $element }}').on('select2:open', function (evt) {
// for multiple select
$('.select2-search.select2-search--inline').css('display','block');
});


@if (isset($field['disabled']) && $field['disabled'] == 'disabled')
    $('{{ $element }}').select2("enable", false);
    $('{{ $element }}').prop("disabled", true);

    $('{{ $element }}').on("click", function () {
    $('{{ $element }}').prop("disabled", true);
    });
@endif
