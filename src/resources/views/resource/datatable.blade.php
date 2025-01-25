@push('js')

    <script type="text/javascript">
        $(document).ready(function() {

            @if ($multiSelectRecord)
                // Check or Uncheck All checkboxes Start
                $(document).on('change', '.selectID{{ $resourceName }}', function() {
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
                "ajax": {
                    "url": "{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName) }}/datatable",
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


                            return JSON.stringify(filterList);
                        },
                        // Prepare data by one to Many from Datatable
                        @if (request('loadByResourcehasMany') && is_array(request('loadByResourcehasMany')))
                            @foreach (request('loadByResourcehasMany') as $k => $v)
                                "loadByResourcehasMany[{{ $k }}]": "{{ $v }}",
                            @endforeach
                        @endif

                        // Prepare data by Many to Many From Datatable
                        @if (request('loadByResourceToMany') && is_array(request('loadByResourceToMany')))
                            @foreach (request('loadByResourceToMany') as $k => $v)
                                "loadByResourceToMany[{{ $k }}]": "{{ $v }}",
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
                    @include('dash::resource.datatable_pack.columns')
                ],

                fnRowCallback: function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    @include('dash::resource.datatable_pack.fnRowCallback')

                },
                initComplete: function() {

                },
                dom: 'Blfrtip',
                buttons: [
                    @include('dash::resource.datatable_pack.buttons')

                ]
            });

            $.fn.dataTable.ext.errMode = function(settings, helpPage, message) {
                //console.log(settings, helpPage, message);
            };




            // Append filter Start
            $("#datatable_resource{{ $resourceName }}_filter.dataTables_filter").append($(
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



        });
    </script>

    @include('dash::resource.filter.index_filter')
    @include('dash::resource.media.image')
    @include('dash::resource.media.video')
    @include('dash::resource.media.audio')
    @include('dash::resource.actions.row_restore')
    @include('dash::resource.actions.row_delete')
    @include('dash::resource.actions.multi_delete')
    @include('dash::resource.actions.multi_restore')
@endpush
