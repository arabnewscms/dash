<script type="text/javascript">
    $(document).ready(function() {

        @if ($multiSelectRecord)
            // Check or Uncheck All checkboxes Start
            $(document).on('change', '#selectID{{ $resourceName }}', function() {
                var checked = $(this).is(':checked');
                var checkListSingle = 0;
                if (checked) {
                    $(this).prop("checked", true);
                } else {
                    $(this).prop("checked", false);
                }

                $(".selectID{{ $resourceName }}").each(function() {
                    if ($(this).is(':checked')) {
                        checkListSingle++;
                    } else {
                        checkListSingle - 1;
                    }
                });

                if (checkListSingle > 0) {
                    $('.deleteAllBtn{{ $resourceName }},.restoreAllBtn{{ $resourceName }},.actions_{{ $resourceName }}')
                        .removeClass('d-none');
                } else {
                    $('.deleteAllBtn{{ $resourceName }},.restoreAllBtn{{ $resourceName }},.actions_{{ $resourceName }}')
                        .addClass('d-none');
                }
            });

            $(document).on('change', '.selectAll{{ $resourceName }}', function() {
                var checked = $(this).is(':checked');
                var checkList = 0;
                if (checked) {
                    $(".selectID{{ $resourceName }}").each(function() {
                        $(this).prop("checked", true);
                        checkList++;
                    });
                } else {
                    $(".selectID{{ $resourceName }}").each(function() {
                        $(this).prop("checked", false);
                    });
                }
                if (checkList > 0) {
                    $('.deleteAllBtn{{ $resourceName }},.restoreAllBtn{{ $resourceName }},.actions_{{ $resourceName }}')
                        .removeClass('d-none');
                } else {
                    $('.deleteAllBtn{{ $resourceName }},.restoreAllBtn{{ $resourceName }},.actions_{{ $resourceName }}')
                        .addClass('d-none');
                }
            });
            // Check or Uncheck All checkboxes End
        @endif


        window.table{{ $resourceName }} = $('#datatable_resource{{ $resourceName }}').DataTable({
            "autoWidth": false,
            "searching": {{ $searching ? 'true' : 'false' }},
            "lengthChange": {{ $lengthChange ? 'true' : 'false' }},
            "lengthMenu": [{{ implode(',', $lengthMenu) }}],
            "paging": {{ $paging ? 'true' : 'false' }},
            "pagingType": "{{ $pagingType ?? 'full_numbers' }}",
            //full_numbers,numbers,simple,scrolling
            "bSort": false,
            //"ordering": {{ $ordering ? 'true' : 'false' }},
            "processing": {{ $processing ? 'true' : 'false' }},
            "serverSide": {{ $serverSide ? 'true' : 'false' }},
            "scrollY": '{{ is_int($scrollY) ? $scrollY : ($scrollY ? 'true' : 'false') }}',
            "scrollX": '{{ is_int($scrollX) ? $scrollX : ($scrollX ? 'true' : 'false') }}',
            "scrollCollapse": {{ $scrollCollapse ? 'true' : 'false' }},
            //'Filter': false,

            "ajax": {
                "url": "{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName) }}/sub/datatable",
                draw: parseInt(1),
                start: parseInt(1),
                "type": "post",
                "data": {
                    'lang': '{{ request('lang') }}',
                    _token: '{{ csrf_token() }}',
                    'withTrashed': function() {
                        return $('#withTrashed{{ $resourceName }}').is(':checked');
                    },
                    'filters': function() {
                        var filterList = [];

                        $('.filter{{ $resourceName }}').each(function() {
                            filterList.push({
                                name: $(this).attr('attribute'),
                                value: $("option:selected", this).val()
                            });


                        });
                        // Auto Add Input To Filters Start
                        @foreach ($filterTextElements as $filterElementtext)
                            @if ($filterElementtext['type'] == 'select')
                                var element_name = '{!! $filterElementtext['attribute'] !!}';
                                var element_value = $('#{!! $filterElementtext['attribute'] !!} option:selected')
                                    .val();
                            @elseif (in_array($filterElementtext['type'], ['belongsTo', 'hasOne', 'morphOne']))
                                var element_name = '{!! $filterElementtext['attribute'] !!}_id';
                                var element_value = $('#{!! $filterElementtext['attribute'] !!} option:selected')
                                    .val();
                            @else
                                var element_name = '{!! $filterElementtext['attribute'] !!}';
                                var element_value = $("#{!! $filterElementtext['attribute'] !!}").val();
                            @endif

                            if (element_value !== undefined) {
                                filterList.push({
                                    name: element_name,
                                    value: element_value
                                });
                            }
                        @endforeach
                        // Auto Add Input To Filters Start
                        return JSON.stringify(filterList);
                    },
                    @if (request('loadByResourcehasMany') && is_array(request('loadByResourcehasMany')))
                        @foreach (request('loadByResourcehasMany') as $k => $v)
                            "loadByResourcehasMany[{{ $k }}]": "{{ $v }}",
                        @endforeach
                    @endif
                    @if (!empty($loadByResourceRelation) && is_array($loadByResourceRelation))
                        @foreach ($loadByResourceRelation as $k => $v)
                            "loadByResourceRelation[{{ $k }}]": "{{ $v }}",
                        @endforeach
                    @endif
                    'loadRelationResources': function() {
                        var resources = '';
                        @foreach ($fields as $relationFields)
                            @if (in_array($relationFields['type'], $relationTypes))

                                @if ($relationFields['type'] == 'morphToMany')
                                    resources +=
                                        '{{ implode(',', array_keys($relationFields['tags'])) }},';
                                @else
                                    resources += '{{ $relationFields['attribute'] }},';
                                @endif
                            @endif
                        @endforeach
                        return resources;
                    }
                },
                error: function(xhr, error, code) {
                    if (xhr) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            },
            "destroy": true,
            @if (!empty($datatable_language))
                language: {!! json_encode($datatable_language, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!},
            @endif
            columns: [
                @include('dash::resource.relation_datatable.datatable_pack.columns')
            ],

            fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                @include('dash::resource.relation_datatable.datatable_pack.fnRowCallback')

            },
            drawCallback: function() {
                var a = table{{ $resourceName }}.data().unique();
                //   console.log(a);
            },
            dom: 'Blfrtip',
            buttons: [
                @include('dash::resource.relation_datatable.datatable_pack.buttons')

            ]
        });

        $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
            //console.log(settings, helpPage, message);
        };


        // Append filter Start
        $("#datatable_resource{{ $resourceName }}_filter").removeClass('dataTables_filter').append($(
            ".filters{{ $resourceName }}"));
        $(".filters{{ $resourceName }}").removeClass('d-none');
        // Append Filter End

        var reloadByClassList = '#withTrashed{{ $resourceName }},.filter{{ $resourceName }}';
        @foreach ($filterTextElements as $filterElementtext)
            reloadByClassList += ",#{!! $filterElementtext['attribute'] !!}";
        @endforeach
        $(document).on('change', reloadByClassList, function() {
            table{{ $resourceName }}.ajax.reload();
        });

        {{--  $(document).on('change','#withTrashed{{ $resourceName }}',function(){
     table{{ $resourceName }}.ajax.reload();
   });  --}}

        // window.table{{ $resourceName }} = table{{ $resourceName }};

    });
</script>

@include('dash::resource.filter.index_filter')
@include('dash::resource.relation_datatable.media.image')
@include('dash::resource.relation_datatable.media.video')
@include('dash::resource.relation_datatable.media.audio')
@include('dash::resource.relation_datatable.actions.row_restore')
@include('dash::resource.relation_datatable.actions.row_delete')
@include('dash::resource.relation_datatable.actions.multi_delete')
@include('dash::resource.relation_datatable.actions.multi_restore')
