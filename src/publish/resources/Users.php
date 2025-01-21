<?php
namespace App\Dash\Resources;

use App\Dash\Metrics\Values\AllUsers;
use Dash\Resource;
use Illuminate\Validation\Rule;

class Users extends Resource {

	public static $model         = \App\Models\User::class ;
	public static $group         = 'users';
	public static $displayInMenu = true;
	public static $icon          = '<i class="fa fa-users"></i>';
	public static $title         = 'name';
	public static $search        = [
		'id',
		'name',
		'email',
	];
	public static $searchWithRelation = [];

    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];


    public static function dtButtons() {
		return [
			'csv',
            'print',
			'pdf',
			'excel',

		];
 }

	public static function customName() {
		return __('dash.users');
	}

	public function query($model) {
		return $model->where('account_type', 'user');
	}

	public static function vertex() {
		return [
            (new AllUsers)->render(),
		];
	}

	public function fields() {
		return [
			id()   ->make('ID', 'id')->showInShow(),
			text() ->make('User Name', 'name')
			       ->ruleWhenCreate('string', 'min:4')
			       ->ruleWhenUpdate('string', 'min:4')
			       ->columnWhenCreate(6)
			       ->showInShow(),
			email()->make('Email Address', 'email')
			       ->ruleWhenUpdate(['required',
					'email' => [Rule::unique('users')->ignore($this->id)],
					// 'unique:users,email,'.$this->id,

				])->ruleWhenCreate('unique:users', 'email'),
			password()
			->make('Password', 'password')
			->whenStore(function(){
                return bcrypt(request('password'));
            })  ->whenUpdate(function(){
                return !empty(request('password'))? bcrypt(request('password')):$this->makeVisible('password')->password;
            })
			->hideInShow()
			->hideInIndex(),
            image()->make('Photo', 'photo')
            ->path('users/{id}')
            ->column(6)
            ->accept('image/png', 'image/jpeg'),

		];
	}

	public function actions() {
		return [

		];
	}

	public function filters() {
		return [
		];
	}

}
