<?php
namespace Dash\Extras\Inputs\InputOptions;

trait ValidationRules {

	public static function rule(...$rule) {
		static ::$input[static ::$index-1]['rule'] = $rule;
		return static ::fillData();
	}

	public static function ruleWhenCreate(...$ruleWhenCreate) {
		static ::$input[static ::$index-1]['ruleWhenCreate'] = $ruleWhenCreate;
		return static ::fillData();
	}

	public static function ruleWhenUpdate(...$ruleWhenUpdate) {
		static ::$input[static ::$index-1]['ruleWhenUpdate'] = $ruleWhenUpdate;
		return static ::fillData();
	}

}