<?php
namespace App\Providers;

use App\Dash\Dashboard\Help;
use Dash\DashServiceProviderInit;


class DashServiceProvider extends DashServiceProviderInit {

	/**
	 * put your dashboard to rendering in home page
	 * @return array
	 */
	public static function dashboards() {
		return [
			Help::class,
		];
	}

	/**
	 * Put Your Resources Here to register in Dashboard
	 * @return array
	 */
	public function resources() {
		return include_once(app_path('Dash/DashResources.php'));
	}

	/**
	 * put notification class
	 * @return array
	 */
	public static function notifications() {
		return [
		];
	}

	/**
	 * Custom Blank Pages
	 * @return array
	 */
	public static function blankPages() {
		return [
		];
	}

	/**
	 * boot method
	 * please dont make any change here
	 */
	public function boot() {
		parent::boot();
	}
}
