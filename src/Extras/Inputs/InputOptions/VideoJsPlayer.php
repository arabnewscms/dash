<?php
namespace Dash\Extras\Inputs\InputOptions;

trait VideoJsPlayer {

	/**
	 * video js player theme choose between (sea,forest,city,fantasy) style
	 * @return function fillData method
	 */
	public static function playerTheme($playerTheme = true) {
		static ::$input[static ::$index-1]['playerTheme'] = is_object($playerTheme)?
		$playerTheme():
		$playerTheme;
		return static ::fillData();
	}

}