<?php
namespace App\Dash\Resources;
use App\Dash\Metrics\AdminGroupRoleMetric;
use App\Dash\Resources\AdminGroups;
use Dash\Resource;
use Illuminate\Validation\Rule;

class AdminGroupRoles extends Resource {

	/**
	 * define Model of resource
	 * @param Model Class
	 */
	public static $model = \App\Models\AdminGroupRole::class ;

	/**
	 * Policy Permission can handel
	 * (viewAny,view,create,update,delete,forceDelete,restore) methods
	 * @param static property as Policy Class
	 */
	//public static $policy = \App\Policies\UserPolicy::class ;

	/**
	 * define this resource in group to show in navigation menu
	 * if you need to translate a dynamic name
	 * define dash.php in /resources/views/lang/en/dash.php
	 * and add this key directly users
	 * @param static property
	 */
	public static $group = 'users';

	/**
	 * show or hide resouce In Navigation Menu true|false
	 * @param static property string
	 */
	public static $displayInMenu = true;

	/**
	 * change icon in navigation menu
	 * you can use font awesome icons LIKE (<i class="fa fa-users"></i>)
	 * @param static property string
	 */
	public static $icon = '<i class="fa fa-users"></i>';// put <i> tag or icon name

	/**
	 * title static property to labels in Rows,Show,Forms
	 * @param static property string
	 */
	public static $title = 'resource';

	/**
	 * defining column name to enable or disable search in main resource page
	 * @param static property array
	 */
	public static $search = [
		'id',
		'resource',
	];

    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];


    public static function dtButtons() {
		return [
			'csv',
            'print',
			'pdf',
			'excel',

		];
 }

	/**
	 *  if you want define relationship searches
	 *  one or Multiple Relations
	 * 	Example: method=> 'invoices'  => columns=>['title'],
	 * @param static array
	 */
	public static $searchWithRelation = [];

	/**
	 * if you need to custom resource name in menu navigation
	 * @return string
	 */
	public static function customName() {

		return __('dash.admin_group_roles');
	}

	/**
	 * you can define vertext in header of page like (Card,HTML,view blade)
	 * @return array
	 */
	public static function vertex() {
		return [

        ];
	}

	/**
	 * define fields by Helpers
	 * @return array
	 */
	public function fields() {
		return [
			id()       ->make('ID', 'id'),
			belongsTo()->make('group name', 'admingroup')
			           ->resource(AdminGroups::class )
			           ->rule('required', 'integer'),
			select()   ->make('resource', 'resource')
			           ->rule('required', 'string'

			)->ruleWhenCreate(
				Rule::unique('admin_group_roles')->where(function ($q) {
						$q->where('resource', request('resource'));
						$q->where('admin_group_id', request('admingroup'));
					})
			)->options([
					'users'            => 'Users',
					'admin_groups'     => 'AdminGroups',
					'admin_group_role' => 'AdminGroupRoles',
				]),
			checkbox()
				->make(' add ', 'create')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
			checkbox()
				->make(' show ', 'show')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
			checkbox()
				->make(' edit ', 'update')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
			checkbox()
				->make(' delete ', 'delete')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
			checkbox()
				->make(' force delete ', 'force_delete')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
			checkbox()
				->make(' restore ', 'restore')
				->column(2)
				->trueVal('yes')
				->falseVal('no'),
		];
	}

	/**
	 * define the actions To Using in Resource (index,show)
	 * php artisan dash:make-action ActionName
	 * @return array
	 */
	public function actions() {
		return [];
	}

	/**
	 * define the filters To Using in Resource (index)
	 * php artisan dash:make-filter FilterName
	 * @return array
	 */
	public function filters() {
		return [];
	}

}
