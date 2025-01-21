<?php
namespace Dash\Controllers\Traits\Supplements;

trait BreadCrumbs {
	/**
	 * breadcrumbs method can make a sublinks in dashboard
	 * @return array
	 */
	public function breadcrumb(array $data = []) {
		$link[] = [
			'name' => $this->title,
			'url'  => url(app('dash')['DASHBOARD_PATH'].'/resource/'.request()->segment(3)),
		];
		if (!empty($data)) {
			$link[] = $data;
		}
		return $link;
	}
}