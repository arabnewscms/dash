<?php
namespace Dash\Controllers\Traits\Supplements;

trait FetchInputs {

	/**
	 * fetch and prepare fields to render in resource when request
	 * by resource segmentaion from uri
	 * @return array
	 */
	public function fields() {
		return $this->resource['fields'][0]::$input;
	}

}