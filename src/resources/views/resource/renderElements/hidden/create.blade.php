@if ($field['show_rules']['showInCreate'])
    @php
        if (isset($field['valueWhenCreate'])) {
            $value = $field['valueWhenCreate'];
        } elseif (isset($field['attribute'])) {
            $value = $field['attribute'];
        } else {
            $value = '';
        }

    @endphp
    <input type="hidden" name="{{ $field['name'] }}" id="{{ $field['name'] }}"
        value="{{ old($field['attribute'], $value) }}" />
@endif
