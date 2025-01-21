<?php
namespace Dash\Extras\Inputs\InputOptions;
use SuperClosure\Serializer;

trait AdditionsToElements {

	/**
	 * using when create or update data and if not set whenCreate,whenUpdate
	 * methods
	 * @param object or string
	 * @return renderable self::data
	 */
	public static

function value($value = null) {
		static ::$input[static ::$index-1]['value'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using when create data
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function valueWhenCreate($value = null) {
		static ::$input[static ::$index-1]['valueWhenCreate'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using when update data
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function valueWhenUpdate($value = null) {
		static ::$input[static ::$index-1]['valueWhenUpdate'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using with select to set options
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function selected($value = null) {
		static ::$input[static ::$index-1]['selected'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using with checkbox to set options
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function default($value = null) {
		static ::$input[static ::$index-1]['default'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using with checkbox to set true value
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function trueVal($value = null) {
		static ::$input[static ::$index-1]['trueVal'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * using with checkbox to set false value
	 * @param object or string
	 * @return renderable self::data
	 */
	public static function falseVal($value = null) {
		static ::$input[static ::$index-1]['falseVal'] = is_object($value)?
		$value():
		$value;
		return static ::fillData();
	}

	/**
	 * accept method use in file,image,video,audio inputs
	 * @param Parameterized | array or string
	 * @return renderable self::data
	 */
	public static function accept(...$accept) {
		static ::$input[static ::$index-1]['accept'] = $accept;
		return static ::fillData();
	}

	/**
	 * path to use with file upload inputs file,image,video,audio
	 * @param string
	 * @return renderable self::data
	 */
	public static function path($path) {
		static ::$input[static ::$index-1]['path'] = [
			'serialize' => is_object($path),
			'source'    => is_object($path)?(new Serializer())->serialize($path):$path,
		];

		return static ::fillData();
	}
	/**
	 * whenStore to use to return custom data for property
	 * @param string
	 * @return renderable self::data
	 */
	public static function whenStore($whenStore) {
		static ::$input[static ::$index-1]['whenStore'] = (new Serializer())->serialize($whenStore);
		return static ::fillData();
	}

	/**
	 * whenStore to use to return custom data for property
	 * @param string
	 * @return renderable self::data
	 */
	public static function whenUpdate($whenUpdate) {
		static ::$input[static ::$index-1]['whenUpdate'] = (new Serializer())->serialize($whenUpdate);
		return static ::fillData();
	}
	/**
	 * rows for textarea
	 * @param string
	 * @return renderable self::data
	 */
	public static function rows($rows) {
		static ::$input[static ::$index-1]['rows'] = is_object($rows)?
		$rows():
		$rows;
		return static ::fillData();
	}

	/**
	 * cols for textarea
	 * @param string
	 * @return renderable self::data
	 */
	public static function cols($cols) {
		static ::$input[static ::$index-1]['cols'] = is_object($cols)?
		$cols():
		$cols;
		return static ::fillData();
	}

	/**
	 * textAlign for textarea,text
	 * @param string
	 * @return renderable self::data
	 */
	public static function textAlign($textAlign) {
		static ::$input[static ::$index-1]['textAlign'] = is_object($textAlign)?
		$textAlign():
		$textAlign;
		return static ::fillData();
	}

	/**
	 * disabled for textarea,text,select
	 * @param string
	 * @return renderable self::data
	 */
	public static function disabled($disabled = "disabled") {
		static ::$input[static ::$index-1]['disabled'] = is_object($disabled)?
		$disabled():
		$disabled;
		return static ::fillData();
	}

	/**
	 * placeholder for textarea,text,select
	 * @param string
	 * @return renderable self::data
	 */
	public static function placeholder($placeholder) {
		static ::$input[static ::$index-1]['placeholder'] = is_object($placeholder)?
		$placeholder():
		$placeholder;
		return static ::fillData();
	}

	/**
	 * help for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function help($help) {
		static ::$input[static ::$index-1]['help'] = is_object($help)?
		$help():
		$help;
		return static ::fillData();
	}

	/**
	 * readonly for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function readonly($readonly = 'readonly') {
		static ::$input[static ::$index-1]['readonly'] = is_object($readonly)?
		$readonly():
		$readonly;
		return static ::fillData();
	}

	/**
	 * showIf for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function showIf($showIf) {
		static ::$input[static ::$index-1]['showIf'] = is_object($showIf)?
		$showIf():
		$showIf;
		return static ::fillData();
	}

	/**
	 * hideIf for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function hideIf($hideIf) {
		static ::$input[static ::$index-1]['hideIf'] = is_object($hideIf)?
		$hideIf():
		$hideIf;
		return static ::fillData();
	}

	/**
	 * checkedIf for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function checkedIf($checkedIf) {
		static ::$input[static ::$index-1]['checkedIf'] = is_object($checkedIf)?
		$checkedIf():
		$checkedIf;
		return static ::fillData();
	}

	/**
	 * readOnlyIf for all inputs
	 * @param string
	 * @return renderable self::data
	 */
	public static function readOnlyIf($readOnlyIf) {
		static ::$input[static ::$index-1]['readOnlyIf'] = is_object($readOnlyIf)?
		$readOnlyIf():
		$readOnlyIf;
		return static ::fillData();
	}

}