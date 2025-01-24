@if ($field['show_rules']['showInUpdate'])
    @php
        if (isset($field['valueWhenUpdate'])) {
            $value = $field['valueWhenUpdate'];
        } elseif (isset($field['attribute'])) {
            $value = $field['attribute'];
        } else {
            $value = $model->{$field['name']};
        }

    @endphp
    <input type="hidden" name="{{ $field['name'] }}" id="{{ $field['name'] }}" value="{{ $value }}" />
@endif
