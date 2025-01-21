<?php
namespace Dash\Controllers\Traits\ControllerMethods;

trait FiltersMethods {
	/**
	 * load All Action Class From Resources
	 * @return array;
	 */
	public function prepare_filters() {
		$filters = $this->resource['filters'];
		$options = [];
		foreach ($filters as $filter) {
			$options[] = [
				'label'   => $filter::label(),
				'options' => $filter::options(),
			];
		}
		return $options;
	}

}