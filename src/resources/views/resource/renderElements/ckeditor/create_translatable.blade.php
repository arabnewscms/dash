@php
    $transIndex = 0;
@endphp
<ul class="nav nav-tabs" id="myTab{{ $field['attribute'] }}" role="tablist">
    @foreach ($field['translatable'] as $key => $value)
        @php
            $inputName = $key . '[' . $field['attribute'] . ']';
            $inputID = $key . '_' . $field['attribute'];
        @endphp
        <li class="nav-item" role="tabinput">
            <button class="nav-link p-2 {{ $transIndex == 0 ? 'active' : '' }}" id="{{ $inputID }}-tab"
                data-bs-toggle="tab" data-bs-target="#{{ $inputID }}" type="button" role="tab"
                aria-controls="{{ $inputID }}" aria-selected="true">{{ $value }}</button>
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
        <div class="tab-pane fade {{ $contenttransIndex == 0 ? 'show active' : '' }}" id="{{ $inputID }}"
            role="tabpanel" aria-labelledby="{{ $inputID }}-tab">
            <div
                class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12 box_{{ $field['attribute'] }}">
                <div class="form-group my-3 ">
                    <label for="{{ $inputID }}_content" class="text-dark text-capitalize">{{ $field['name'] }}
                        @if (
                            (isset($field['rule']) && in_array('required', $field['rule'])) ||
                                (isset($field['ruleWhenCreate']) && in_array('required', $field['ruleWhenCreate'])))
                            <span class="text-danger text-sm">*</span>
                        @endif
                    </label>
                    <textarea name="{{ $inputName }}" rows="{{ isset($field['rows']) ? $field['rows'] : '6' }}"
                        cols="{{ isset($field['cols']) ? $field['cols'] : '' }}"
                        placeholder="{{ isset($field['placeholder']) ? $field['placeholder'] : $field['name'] }}"
                        {{ isset($field['textAlign']) ? 'style="text-align:' . $field['textAlign'] . '"' : '' }}
                        {{ isset($field['readonly']) ? 'readonly' : '' }} {{ isset($field['disabled']) ? 'disabled' : '' }}
                        class="form-control border p-2 {{ $inputID }} {{ $errors->has($inputName) ? 'is-invalid' : '' }}"
                        id="{{ $inputID }}_content">{{ old($inputName) }}</textarea>
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
