<?php
namespace App\Dash\Resources;

use App\Dash\Metrics\Values\AllAdmins;
use Dash\Resource;
use Illuminate\Validation\Rule;

class Admins extends Resource {

	public static $model = \App\Models\User::class ;
	//public static $policy = \App\Policies\AdminPolicy::class;
	public static $group              = 'users';
	public static $displayInMenu      = true;
	public static $icon               = '<i class="fa fa-users"></i>';
	public static $title              = 'name';
	public static $appendToMainSearch = false;
	public static $search             = [
		'id',
		'name',
		'email',
	];

	public static function customName() {
		return 'Admins';
	}

    public static $lengthMenu        = [50, 10, 15, 20, 25, 50, 100];

    public static function dtButtons() {
		return [
			'csv',
            'print',
			'pdf',
			'excel',

		];
 }

	public function query($model) {
		return $model->where('account_type', 'admin');
	}

	public static function vertex() {
		return [
            (new AllAdmins)->render(),
		];
	}

	public function fields() {
		return [
			id()   ->make('ID', 'id')->showInShow(),
			text() ->make('User Name', 'name')
			       ->orderable(false)
			       ->ruleWhenCreate('string', 'min:4')
			       ->ruleWhenUpdate('string', 'min:4')
			       ->column(6)
			       ->showInShow(),
			email()->make('Email Address', 'email')
                    ->column(6)
			       ->ruleWhenUpdate(['required',
					'email' => [Rule::unique('users')->ignore($this->id)],
					// 'unique:users,email,'.$this->id,

				])->ruleWhenCreate('unique:users', 'email'),
			password()->make('Password', 'password')
                    ->column(6)
					->whenStore(function(){
						return bcrypt(request('password'));
					})  ->whenUpdate(function(){
						return !empty(request('password'))? bcrypt(request('password')):$this->makeVisible('password')->password;
					})
			        ->hideInShow()
			        ->hideInIndex(),

			select()->make('Account Type', 'account_type')
			        ->selected('user')
			        ->options([
					'user'  => 'User',
					'admin' => 'Admin',
				])  ->column(6),
                image()->make('Photo', 'photo')
                ->path('users/{id}')
                ->column(6)
                ->accept('image/png', 'image/jpeg'),
            belongsTo()->make('Group','admingroup',AdminGroups::class)->rule('required')

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
