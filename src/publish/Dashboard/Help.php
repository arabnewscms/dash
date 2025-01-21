<?php
namespace App\Dash\Dashboard;
use App\Dash\Metrics\Values\AllAdminGroupRoles;
use App\Dash\Metrics\Values\AllAdminGroups;
use App\Dash\Metrics\Values\AllAdmins;
use App\Dash\Metrics\Values\AllUsers;
//use Dash\Extras\Inputs\HTML;
use Dash\Resource;


class Help extends Resource {

	/**
	 * add your card here by Card , HTML Class
	 * or by view instnance render blade file
	 * @return array
	 */
	public static function cards() {
		return [
            (new AllAdmins)->render(),
            (new AllUsers)->render(),
            (new AllAdminGroups)->render(),
            (new AllAdminGroupRoles)->render(),
			view('dash::help')	->render(),
			//HTML::render('<h1>Some HTML</h1>'),

		];
	}

}
