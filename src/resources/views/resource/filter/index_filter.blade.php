<div class="collapse border p-1 filters{{ $resourceName }} text-start" id="collapse{{ $resourceName }}">
    <div class="row">
        {{-- Add To Filter In Fields method from resource --}}
        @foreach ($filterHtmlElements as $filterElementHtml)
            {!! $filterElementHtml !!}
        @endforeach
        {{-- Add To Filter In Fields method from resource --}}

        @foreach ($filters as $filter)
            @foreach ($filter['options'] as $key => $value)
                @php
                    $column = $key;
                    $options = $value;
                    $field = searchInFields($column, $fields);
                    if ($field == false) {
                        $field['name'] = $column;
                    }
                @endphp
                <div class="col-md-3 col-xs-12 col-sm-12">
                    <div class="form-group text-start">
                        <label for="{{ $column }}"
                            id="{{ $column }}">{{ $filter['label'] ?? $field['name'] }}</label>
                        <select attribute="{{ $column }}" id="{{ $column }}" name="{{ $column }}"
                            class="form-select form-select-sm select2 p-2 filter{{ $resourceName }}">
                            <option value="" disabled selected>{{ $filter['label'] ?? $field['name'] }}</option>
                            <option value="">{{ __('dash::dash.all') }}</option>
                            @foreach ($options as $optkey => $optvalue)
                                <option value="{{ $optkey }}">{{ $optvalue }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
