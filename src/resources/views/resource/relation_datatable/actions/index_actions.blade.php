@if (count($actions))

    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.DoAction{{ $resourceName }}', function() {
                var action = $('.action{{ $resourceName }} option:selected').val();
                $('.action_input{{ $resourceName }}').val(action);
                if (action == 'none') {
                    $('.mutliselect_data{{ $resourceName }}').html(
                        `<p>{{ __('dash::dash.choose_action_first') }}</p>`);
                    $('#manage_actions{{ $resourceName }}').modal('show');
                    $('.actionbtn{{ $resourceName }}').addClass('d-none');
                } else {
                    $('.actionbtn{{ $resourceName }}').removeClass('d-none');
                }
                if (action != 'none') {
                    var list = [];
                    $('.mutliselect_data{{ $resourceName }}').html('');
                    $(".selectID{{ $resourceName }}").each(function(key, val) {
                        if ($(this).is(':checked')) {
                            var ids = $(this).val();
                            list.push(ids);
                            $('.mutliselect_data{{ $resourceName }}').append(`
                <input type="hidden" name="ids[]" value="` + ids + `" />
                `);
                        }
                        //$(this).prop("checked",false);
                    });

                    if (list.length > 0) {
                        $('.mutliselect_data{{ $resourceName }}').append(
                            `<p>{{ __('dash::dash.are_you_sure_to_do_this') }}</p>`);
                        $('#manage_actions{{ $resourceName }}').modal('show');
                    }
                }

            });
        });
    </script>
    <div class="modal fade" id="manage_actions{{ $resourceName }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <i data-bs-dismiss="modal" style="cursor: pointer;" class="fa fa-times"></i>
                </div>
                <div class="modal-body">
                    <form action="{{ url(app('dash')['DASHBOARD_PATH'] . '/resource/' . $resourceName . '/action') }}"
                        method="post">
                        <div class="input-group input-group-outline my-3">
                            <span class="mutliselect_data{{ $resourceName }}"></span>
                        </div>

                        <div class="p-1 actionbtn{{ $resourceName }}">
                            <button type="submit" class="btn btn-info">{{ __('dash::dash.yes') }}</button>
                            <button type="button" data-bs-dismiss="modal"
                                class="btn btn-light">{{ __('dash::dash.cancel') }}</button>
                        </div>
                        @csrf
                        <input type="hidden" name="lang" value="{{ app()->getLocale() }}" />
                        <input type="hidden" name="_method" value="post">
                        <input type="hidden" name="action" class="action_input{{ $resourceName }}">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row d-none actions_{{ $resourceName }}">
        <div class="col-8">

            <select name="action{{ $resourceName }}"
                class="action{{ $resourceName }} form-select {{ app()->getLocale() == 'en' ? 'ps-2' : '' }} form-select-md ">
                @foreach ($actions as $key => $value)
                    @php
                        $column = array_keys($value)[0];
                        $options = array_values($value)[0];
                        $field = searchInFields($column, $fields);
                    @endphp
                    {{-- {{ dd($column,$value[$column],$field['options'],$options) }} --}}
                    <option value="none" selected disabled>{{ __('dash::dash.action') }}</option>

                    <optgroup label="{{ isset($field['name']) ? $field['name'] : '' }}">
                        @foreach ($options as $key => $value)
                            <option
                                value="{{ json_encode([
                                    'column' => $column,
                                    'value' => $key,
                                ]) }}">
                                @if (isset($value['label']))
                                    {{ $value['label'] }}
                                @elseif(isset($field['options']) && isset($field['options'][$key]))
                                    {{ $field['options'][$key] }}
                                @else
                                    {{ $key }}
                                @endif
                            </option>
                        @endforeach

                    </optgroup>
                @endforeach
            </select>
        </div>
        <div class="col-2">
            <button type="button" class="DoAction{{ $resourceName }} btn btn-light btn-md"><i
                    class="fa fa-play"></i></button>
        </div>
    </div>
@endif
