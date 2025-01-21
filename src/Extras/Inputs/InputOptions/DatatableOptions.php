<?php
namespace Dash\Extras\Inputs\InputOptions;

trait DatatableOptions {

	public static function orderable($orderable = true) {
		static::$input[static::$index - 1]['orderable'] = is_object($orderable) ?
		$orderable() :
		$orderable;
		return static::fillData();
	}

	public static function searchable($searchable = true) {
		static::$input[static::$index - 1]['searchable'] = is_object($searchable) ?
		$searchable() :
		$searchable;
		return static::fillData();
	}

	public static function hasOneDatatable($HasOneDatatable = true) {
		static::$input[static::$index - 1]['hasOneDatatable'] = is_object($HasOneDatatable) ?
		$HasOneDatatable() :
		$HasOneDatatable;
		return static::fillData();
	}

}