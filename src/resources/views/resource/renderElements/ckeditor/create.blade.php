@if ($field['show_rules']['showInCreate'])
    @php
        if (isset($field['valueWhenCreate'])) {
            $value = $field['valueWhenCreate'];
        } elseif (isset($field['value'])) {
            $value = $field['value'];
        } else {
            $value = '';
        }
        $col = isset($field['columnWhenCreate']) ? $field['columnWhenCreate'] : $field['column'];

    @endphp
    @if (isset($field['translatable']) && count($field['translatable']) > 0)
        @include('dash::resource.renderElements.ckeditor.create_translatable')
        @foreach ($field['translatable'] as $key => $value)
            @include('dash::resource.renderElements.ckeditor.ckeditor_js', [
                'editor' => $key . '_' . $field['attribute'] . '_content',
                'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : '',
            ])
        @endforeach
    @else
        <div
            class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
            <div class="form-group my-3 ">
                <label for="{{ $field['attribute'] }}" class="text-dark text-capitalize">{{ $field['name'] }}
                    @if (
                        (isset($field['rule']) && in_array('required', $field['rule'])) ||
                            (isset($field['ruleWhenCreate']) && in_array('required', $field['ruleWhenCreate'])))
                        <span class="text-danger text-sm">*</span>
                    @endif
                </label>
                <textarea class="area_{{ $field['attribute'] }} {{ $field['attribute'] }}" name="{{ $field['attribute'] }}"
                    id="{{ $field['attribute'] }}">{{ old($field['attribute'], $value) }}</textarea>
                {!! isset($field['help']) ? $field['help'] : '' !!}
                @error($field['attribute'])
                    <p class="invalid-feedback">{{ $message }}</p>
                @enderror
            </div>
        </div>
        @include('dash::resource.renderElements.ckeditor.ckeditor_js', [
            'editor' => $field['attribute'],
            'placeholder' => isset($field['placeholder']) ? $field['placeholder'] : '',
        ])
    @endif

@endif
