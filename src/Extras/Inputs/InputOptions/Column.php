<?php
namespace Dash\Extras\Inputs\InputOptions;

trait Column {
	public static $column = 12;

	public static function column($column = 12) {
		static ::$input[static ::$index-1]['column'] = is_object($column)?
		$column():
		$column;
		return static ::fillData();
	}

	public static function columnWhenCreate($column = 12) {
		static ::$input[static ::$index-1]['columnWhenCreate'] = is_object($column)?
		$column():
		$column;
		return static ::fillData();
	}
	public static function columnWhenUpdate($column = 12) {
		static ::$input[static ::$index-1]['columnWhenUpdate'] = is_object($column)?
		$column():
		$column;
		return static ::fillData();
	}

}