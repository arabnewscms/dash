<?php
namespace Dash\Extras\Inputs;

class HTML {

	public static function render($view) {
		return !is_object($view)?$view:$view();
	}
}