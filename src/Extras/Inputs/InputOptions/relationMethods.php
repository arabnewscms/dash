<?php
namespace Dash\Extras\Inputs\InputOptions;

trait relationMethods {

	/**
	 * using with BelongsTo
	 * @return function fillData method
	 */
	public function query($query = null) {
		if (is_object($query)) {
			static ::$input[static ::$index-1]['query'] = $query;
		}
		return static ::fillData();
	}

	/**
	 * using with BelongsTo
	 * @return function fillData method
	 */
	public function fromParent($parent, $column) {
		static ::$input[static ::$index-1]['fromParent'] = [
			'parent' => $parent,
			'column' => $column,
		];
		return static ::fillData();
	}

	/**
	 * using with BelongsTo
	 * @return function fillData method
	 */
	public function child(...$child) {
		static ::$input[static ::$index-1]['child'] = $child;
		return static ::fillData();
	}

    public function inlineButton($bool=true) {
		static ::$input[static ::$index-1]['inlineButton'] = $bool;
		return static ::fillData();
	}
    
	public function viewColumns(...$viewColumns) {
		static ::$input[static ::$index-1]['viewColumns'] = $viewColumns;
		return static ::fillData();
	}
    
	public function use($use) {
		static ::$input[static ::$index-1]['use'] = $use;
		return static ::fillData();
	}

 


}
