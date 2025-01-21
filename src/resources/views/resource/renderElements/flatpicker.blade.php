<script type="text/javascript">
$(document).ready(function(){
var inputDate = $('#{{ $field['attribute'] }}').parents('form').attr('id');
if(inputDate != undefined){
    var inputflatpicker = "#"+inputDate+ "  #{{ $field['attribute'] }}";
}else{
    var inputflatpicker = "#{{ $field['attribute'] }}";

}

$(inputflatpicker).flatpickr({
    "locale": "ar",
	@if(isset($field['modeDates']))
	mode: {!! json_encode($field['modeDates']) !!},
	@endif
	@if(isset($field['conjunction']))
	conjunction: "{{ $field['conjunction'] }}",
	@endif
	@if(isset($field['disableDates']))
	disable: {!! json_encode($field['disableDates']) !!},
	@endif
	@if(isset($field['defaultDate']))
	defaultDate: {!! json_encode($field['defaultDate']) !!},
	@elseif(!empty($model) && !empty($model->{$field['attribute']}))
	defaultDate: '{{ $model->{$field['attribute']} }}',
	@endif
	@if(isset($field['enableDates']))
	enable: {!! json_encode($field['enableDates']) !!},
	@endif
	@if(isset($field['minDate']))
	minDate: "{{ $field['minDate'] }}",
	@endif
	@if(isset($field['maxDate']))
    maxDate: new Date().fp_incr('{{ $field['maxDate'] > 0?$field['maxDate']:0 }}'),
	@endif
	@if(isset($field['enableTime']))
	enableTime: '{{ $field['enableTime'] == true?'true':'false' }}',
	@endif
	@if(isset($field['noCalendar']))
	noCalendar: '{{ $field['noCalendar']?'true':'false' }}',
	@endif
	@if(isset($field['time_24hr']))
	time_24hr: '{{ $field['time_24hr']?'true':'false' }}',
	@endif
	@if(isset($field['minTime']) && is_string($field['minTime']))
	minTime: '{{ $field['minTime'] }}',
	@endif
	@if(isset($field['maxTime'])  && is_string($field['maxTime']))
	maxTime: '{{ $field['maxTime'] }}',
	@endif
	@if(isset($field['inline']))
	inline: '{{ $field['inline']?'true':'false' }}',
	@endif
	@if(isset($field['weekNumbers']))
	weekNumbers: '{{ $field['weekNumbers']?'true':'false' }}',
	@endif
	@if(isset($field['wrap']))
	wrap: '{{ $field['wrap']?'true':'false' }}',
	@endif
	@if(isset($field['allowInput']))
	allowInput: '{{ $field['allowInput']?'true':'false' }}',
	@endif
	@if(isset($field['altInput']))
	altInput: '{{ $field['altInput']?'true':'false' }}',
	@endif
	@if(isset($field['format']))
	dateFormat: "{{ $field['format'] }}",
	@endif
});
});
</script>
