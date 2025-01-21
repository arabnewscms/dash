<?php
namespace Dash\Extras\Inputs\InputOptions;

trait FlatPicker {
	/**
	 * format flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function format($format) {
		static ::$input[static ::$index-1]['format'] = is_object($format)?
		$format():
		$format;
		return static ::fillData();
	}
	/**
	 * enableTime flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function enableTime($enableTime = true) {
		static ::$input[static ::$index-1]['enableTime'] = is_object($enableTime)?
		$enableTime():
		$enableTime;
		return static ::fillData();
	}

	/**
	 * minDate flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function minDate($minDate = 'today') {
		static ::$input[static ::$index-1]['minDate'] = is_object($minDate)?
		$minDate():
		$minDate;
		return static ::fillData();
	}

	/**
	 * maxDate flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function maxDate($maxDate) {
		static ::$input[static ::$index-1]['maxDate'] = is_object($maxDate)?
		$maxDate():
		$maxDate;
		return static ::fillData();
	}
	/**
	 * disableDates flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function disableDates($disableDates = []) {
		static ::$input[static ::$index-1]['disableDates'] = is_object($disableDates)?
		$disableDates():
		$disableDates;
		return static ::fillData();
	}
	/**
	 * enableDates flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function enableDates($enableDates = []) {
		static ::$input[static ::$index-1]['enableDates'] = is_object($enableDates)?
		$enableDates():
		$enableDates;
		return static ::fillData();
	}

	/**
	 * modeDates flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function modeDates($modeDates = 'multiple') {
		static ::$input[static ::$index-1]['modeDates'] = is_object($modeDates)?
		$modeDates():
		$modeDates;
		return static ::fillData();
	}

	/**
	 * defaultDate flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function defaultDate($defaultDate = []) {
		static ::$input[static ::$index-1]['defaultDate'] = is_object($defaultDate)?
		$defaultDate():
		$defaultDate;
		return static ::fillData();
	}
	/**
	 * conjunction flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function conjunction($conjunction = ',') {
		static ::$input[static ::$index-1]['conjunction'] = is_object($conjunction)?
		$conjunction():
		$conjunction;
		return static ::fillData();
	}

	/**
	 * noCalendar flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function noCalendar($noCalendar = true) {
		static ::$input[static ::$index-1]['noCalendar'] = is_object($noCalendar)?
		$noCalendar():
		$noCalendar;
		return static ::fillData();
	}

	/**
	 * time_24hr flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function time_24hr($time_24hr = true) {
		static ::$input[static ::$index-1]['time_24hr'] = is_object($time_24hr)?
		$time_24hr():
		$time_24hr;
		return static ::fillData();
	}
	/**
	 * inline flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function inline($inline = true) {
		static ::$input[static ::$index-1]['inline'] = is_object($inline)?
		$inline():
		$inline;
		return static ::fillData();
	}
	/**
	 * allowInput flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function allowInput($allowInput = true) {
		static ::$input[static ::$index-1]['allowInput'] = is_object($allowInput)?
		$allowInput():
		$allowInput;
		return static ::fillData();
	}
	/**
	 * altInput flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function altInput($altInput = true) {
		static ::$input[static ::$index-1]['altInput'] = is_object($altInput)?
		$altInput():
		$altInput;
		return static ::fillData();
	}
	/**
	 * wrap flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function wrap($wrap = true) {
		static ::$input[static ::$index-1]['wrap'] = is_object($wrap)?
		$wrap():
		$wrap;
		return static ::fillData();
	}
	/**
	 * weekNumbers flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function weekNumbers($weekNumbers = true) {
		static ::$input[static ::$index-1]['weekNumbers'] = is_object($weekNumbers)?
		$weekNumbers():
		$weekNumbers;
		return static ::fillData();
	}
	/**
	 * maxTime flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function maxTime($maxTime = '') {
		static ::$input[static ::$index-1]['maxTime'] = is_object($maxTime)?
		$maxTime():
		$maxTime;
		return static ::fillData();
	}
	/**
	 * minTime flatpicker
	 * @param string
	 * @return renderable self::data
	 */
	public static function minTime($minTime = '') {
		static ::$input[static ::$index-1]['minTime'] = is_object($minTime)?
		$minTime():
		$minTime;
		return static ::fillData();
	}
}