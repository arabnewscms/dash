@php
    $col = '12';//isset($field['column']) ? $field['column'] : '6';

@endphp
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-2"><bdi>{{ $field['name'] }} :</bdi></div>
    <div class="col-lg-{{ $col }} col-md-{{ $col }} col-sm-12 col-xs-12">
        @if (isset($field['translatable']) && !empty($field['translatable']))
            <ul class="nav nav-tabs" id="{{ $field['attribute'] }}" role="tablist">
                @php
                    $i = 0;
                @endphp
                @foreach ($field['translatable'] as $key => $value)
                    <li class="nav-item">
                        <button class="nav-link p-2 {{ $i == 0 ? 'active' : '' }}" id="{{ $key . $field['attribute'] }}-tab"
                            data-bs-toggle="tab" data-bs-target="#{{ $key . $field['attribute'] }}" type="button"
                            role="tab" aria-controls="{{ $key }}"
                            aria-selected="true">{{ $value }}</button>
                    </li>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </ul>
            <div class="tab-content" id="{{ $field['attribute'] }}Content">
                @php
                    $i = 0;
                @endphp
                @foreach ($field['translatable'] as $key => $value)
                    <div class="tab-pane fade p-2 {{ $i == 0 ? 'show active' : '' }}" id="{{ $key . $field['attribute'] }}"
                        role="tabpanel" aria-labelledby="{{ $key . $field['attribute'] }}-tab">
                        @if (method_exists($data, 'translate'))
                            {{ $data?->translate($key)?->{$field['attribute']} ?? '' }}
                        @else
                            {{ $data->{$field['attribute']} }}
                        @endif
                    </div>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </div>
        @else
            <span>{!! $data->{$field['attribute']} ?? '-' !!}</span>
        @endif
    </div>
</div>
