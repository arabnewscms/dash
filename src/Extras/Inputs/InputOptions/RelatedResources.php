<?php
namespace Dash\Extras\Inputs\InputOptions;

trait RelatedResources {

	/**
	 * Append Resource Class with relations
	 * @return function fillData method
	 */
	public function resource($resource) {
		static::$input[static::$index - 1]['resource'] = $resource;
		return static::fillData();
	}

	/**
	 * using with MorphTo
	 * @return function fillData method
	 */
	public function types($types = []) {
		static::$input[static::$index - 1]['types'] = $types;
		return static::fillData();
	}

	/**
	 * using with MorphToMany
	 * @return function fillData method
	 */
	public function tags($tags = []) {
		static::$input[static::$index - 1]['tags'] = $tags;
		return static::fillData();
	}

}