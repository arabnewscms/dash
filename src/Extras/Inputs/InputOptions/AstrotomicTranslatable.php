<?php
namespace Dash\Extras\Inputs\InputOptions;

trait AstrotomicTranslatable {

	/**
	 * video js player theme choose between (sea,forest,city,fantasy) style
	 * @return function fillData method
	 */
	public static function translatable($translatable = []) {
		static ::$input[static ::$index-1]['translatable'] = $translatable;
		return static ::fillData();
	}

}