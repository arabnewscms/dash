<?php
namespace Dash\Extras\Inputs\InputOptions;

trait ContractableAndRules {

	/**
	 * @param string or anonymous function as object
	 * on show method can append default value on show resource data
	 * @return fillData function
	 */
	public function onShow($data) {
		static::$input[static::$index - 1]['onShow'] = is_object($data) ? $data() : $data;
		return static::fillData();
	}
}