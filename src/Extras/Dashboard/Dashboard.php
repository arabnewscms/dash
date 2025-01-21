<?php
namespace Dash\Extras\Dashboard;

trait Dashboard {

	/**
	 * cards to load data to view in dashboard
	 * @return array data;
	 */
	public static function cards() {
		return [__('dash::dash.none_data')];
	}
}