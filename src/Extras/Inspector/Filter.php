<?php
namespace Dash\Extras\Inspector;

abstract class Filter {
	public static function label() {
		return null;
	}

	public static function options() {
		return [];
	}
}