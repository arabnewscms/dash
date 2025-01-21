<?php
namespace Dash\Extras\Inputs\InputOptions;

trait CustomHtml {

	public static function view($view) {
		static ::$input[static ::$index-1]['view'] = is_object($view)?
		$view():
		$view;
		return static ::fillData();
	}

	public function assign($fields = []) {
		static ::$input[static ::$index-1]['assign_fields'] = $fields;
		return static ::fillData();
	}

}