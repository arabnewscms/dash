@php
    $random = rand(0000, 9999);
    $transIndex = 0;
@endphp

<ul class="nav nav-tabs" id="myTab{{ $field['attribute'] }}" role="tablist">
    @foreach ($field['translatable'] as $key => $value)
        @php
            $inputName = $key . '[' . $field['attribute'] . ']';
            $inputID = $key . '_' . $field['attribute'];
        @endphp
        <li class="nav-item" role="tabinput">
            <button class="nav-link p-2 {{ $inputID }}-tab {{ $transIndex == 0 ? 'active' : '' }}"
                id="{{ $inputID . $random }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $inputID . $random }}" type="button"
                role="tab" aria-controls="{{ $inputID . $random }}" aria-selected="true">{{ $value }}</button>
        </li>
        @php $transIndex++; @endphp
    @endforeach
</ul>
<div class="tab-content" id="myTab{{ $field['attribute'] }}Content">
    @php $contenttransIndex = 0; @endphp
    @foreach ($field['translatable'] as $key => $value)
        @php
            $inputName = $key . '[' . $field['attribute'] . ']';
            $inputID = $key . '_' . $field['attribute'];
        @endphp
        <div class="tab-pane fade {{ $contenttransIndex == 0 ? 'show active' : '' }}" id="{{ $inputID . $random }}"
            role="tabpanel" aria-labelledby="{{ $inputID . $random }}-tab">
            <div
                class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
                <div class="form-group my-3 ">
                    <label for="{{ $inputID }}" class="text-dark text-capitalize">{{ $field['name'] }}
                        @if (
                            (isset($field['rule']) && in_array('required', $field['rule'])) ||
                                (isset($field['ruleWhenCreate']) && in_array('required', $field['ruleWhenCreate'])))
                            <span class="text-danger text-sm">*</span>
                        @endif
                    </label>

                    <textarea name="{{ $key }}[{{ $field['attribute'] }}]" rows="{{ isset($field['rows']) ? $field['rows'] : '6' }}"
                        cols="{{ isset($field['cols']) ? $field['cols'] : '' }}"
                        placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : $field['name'] }}"
                        {{ isset($field['textAlign']) ? 'style="text-align:' . $field['textAlign'] . '"' : '' }}
                        {{ isset($field['readonly']) ? 'readonly' : '' }} {{ isset($field['disabled']) ? 'disabled' : '' }}
                        {{ isset($field['disabledIf']) && $field['disabledIf'] ? 'disabled' : '' }}
                        {{ isset($field['readOnlyIf']) && $field['readOnlyIf'] ? 'readonly' : '' }}
                        class="form-control
		{{ isset($field['hideIf']) && $field['hideIf'] ? 'd-none' : '' }}
		{{ $inputID }} {{ $errors->has($inputName) ? 'is-invalid' : '' }}"
                        id="{{ $inputName }}">{{ method_exists($model, 'translate') ? $model->translate($key)->{$field['attribute']} : $model->{$field['attribute']} }}</textarea>


                    {!! isset($field['help']) ? $field['help'] : '' !!}
                    @error($inputName)
                        <p class="invalid-feedback is-invalid">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        @php $contenttransIndex++; @endphp
    @endforeach
</div>
