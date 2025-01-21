@if ($field['show_rules']['showInUpdate'])
    @php
        $selected = isset($field['selected']) ? $field['selected'] : null;
        $morphName = $field['attribute'];
        $selectedClass = !empty($model->{$field['attribute']})? get_class($model->{$field['attribute']}):null;
        $selectedClassName = !empty($selectedClass)? resourceShortName($selectedClass):null;
        $mainResModel = $model;
        $col = isset($field['columnWhenUpdate'])?$field['columnWhenUpdate']:$field['column'];
    @endphp
    <div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $morphName }}">
        <div class="form-group my-3 ">
            <label class="text-dark text-capitalize" for="{{ $morphName }}">
                {{ $field['name'] }}
                @if (
                    (isset($field['rule']) && in_array('required', $field['rule'])) ||
                        (isset($field['ruleWhenUpdate']) && in_array('required', $field['ruleWhenUpdate'])))
                    <span class="text-danger text-sm">*</span>
                @endif
            </label>
            <select id="{{ $morphName }}" name="{{ $morphName }}"
                class="form-control select2-show-search custom-select {{ strtolower($morphName) }} {{ $errors->has($morphName) ? 'is-invalid' : '' }}">
                <option selected value>{{ $field['name'] }}</option>
                @if (isset($field['types']))
                    @foreach ($field['types'] as $type)
                        @php
                            $res_type = is_array($type) ? $type[0] : $type;
                            $morphTitle = resourceShortName($res_type::$model) ?? $field['name'];
                        @endphp
                        <option value="{{ $res_type::$model }}" model_name="{{ resourceShortName($res_type::$model) }}"
                            {{ $selected == $res_type::$model ? 'selected' : '' }}
                            {{ $selectedClass == $res_type::$model ? 'selected' : '' }}>
                            {{ $res_type::customName() ?? $field['name'] }}</option>
                    @endforeach
            </select>
            @error($morphName)
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
@endif
</div>
</div>
<div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12">
    {{-- Fetch Morph To Dropdown Select Start --}}
    @foreach ($field['types'] as $res_type)
        @php
            $resource = is_array($res_type) ? $res_type[0] : $res_type;
            $query = is_array($res_type) ? $res_type[1] ?? null : null;
            $morphNameModel = resourceShortName($resource::$model);
            $morphTitleModel = $resource::customName() ?? resourceShortName($resource::$model);
        @endphp

        <div
            class="form-group my-3 box_{{ $morphNameModel }} box_{{ $morphName }}_select {{ $errors->has($morphNameModel) || old($morphNameModel) ? '' : 'd-none' }}">
            <label class="form-check-label text-dark" for="{{ $morphNameModel }}">
                {{ $morphTitleModel }}
                @if (
                    (isset($field['rule']) && in_array('required', $field['rule'])) ||
                        (isset($field['ruleWhenUpdate']) && in_array('required', $field['ruleWhenUpdate'])))
                    <span class="text-danger text-sm">*</span>
                @endif
            </label>

            <select id="{{ $morphNameModel }}" model="{{ $resource::$model }}"
                query="{{ isset($query) ? (new SuperClosure\Serializer())->serialize($query) : null }}"
                searchKey="{{ $resource::$title }}" name="{{ $morphNameModel }}"
                class="form-select ps-2 {{ $morphNameModel }}
{{ isset($field['hideIf']) && $field['hideIf'] ? 'd-none' : '' }}
		 {{ strtolower($morphNameModel) }} {{ $errors->has($morphNameModel) ? 'is-invalid' : '' }}">
                <option selected value>{{ $morphTitleModel }}</option>
                {{--  Get selected value from selected morph this query not get all data just one value  --}}
                @if ($selectedClass == $resource::$model)
                    @foreach ($resource::$model::where('id', $mainResModel?->{$field['attribute']}?->id)->get() as $model)
                        <option value="{{ $model->id }}"
                            {{ $mainResModel?->{$field['attribute']}?->id == $model->id ? 'selected' : '' }}>
                            {{ $model->{$resource::$title} }}</option>
                    @endforeach
                @endif

            </select>
            {!! isset($field['help']) ? $field['help'] : '' !!}

            @if (method_exists($resource::$model, 'trashed'))
                <label class="custom-switch" for="withTrashed{{ $morphNameModel }}">
                    <input  type="checkbox" name="withTrashed{{ $morphNameModel }}" value="yes"
                    id="withTrashed{{ $morphNameModel }}" checked class="custom-switch-input">
                    <span class="custom-switch-indicator"></span>
                    <span class="custom-switch-description">{{ __('dash::dash.withTrashed') }}</span>
                </label>
            @endif

        </div>
        <script type="text/javascript">
            $(document).ready(function() {


                @include('dash::resource.renderElements.select2', [
                    'element' => '.' . $morphName,
                    'attribute' => $morphName,
                ])

                @include('dash::resource.renderElements.select2', [
                    'element' => '.' . $morphNameModel,
                    'attribute' => $morphNameModel,
                    'dynamic' => true,
                ])

                $('.{{ $morphName }}').on('select2:select', function() {
                    var model_value = $('.{{ $morphName }} option:selected').val();
                    var model_name = $('.{{ $morphName }} option:selected').attr('model_name');

                    $('.box_{{ $morphName }}_select').addClass('d-none');
                    $('.box_' + model_name).removeClass('d-none');

                });

                $('.box_{{ $morphName }}_select').addClass('d-none');
                $('.box_{{ $selectedClassName }}').removeClass('d-none');
            });
        </script>
    @endforeach
    {{-- Fetch Morph To Dropdown Select End --}}
</div>


@endif
