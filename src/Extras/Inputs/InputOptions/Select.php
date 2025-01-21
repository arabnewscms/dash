<?php
namespace Dash\Extras\Inputs\InputOptions;

trait Select {

	public static function options($options = []) {
		static::$input[static::$index - 1]['options'] = is_object($options) ?
		$options() :
		$options;
		return static::fillData();
	}

}