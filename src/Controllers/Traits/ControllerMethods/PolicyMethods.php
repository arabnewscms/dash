<?php
namespace Dash\Controllers\Traits\ControllerMethods;
use Illuminate\Support\Facades\Gate;

trait PolicyMethods {

	/**
	 * this method aggregate to all rules using policy with gate
	 * @param $user auth()->guard('dash')->user()
	 */
	public function pagesRules($user) {
		return [
			'index'       => $this->can('viewAny', $user),
			'show'        => $this->can('view', $user),
			'create'      => $this->can('create', $user),
			'store'       => $this->can('create', $user),
			'edit'        => $this->can('update', $user),
			'update'      => $this->can('update', $user),
			'destroy'     => $this->can('delete', $user),
			'forceDelete' => $this->can('forceDelete', $user),
			'restore'     => $this->can('restore', $user),
		];
	}

	/**
	 * Define This Policy method in to construct
	 * @param string $fn
	 * @param admin info $user
	 * @return bool
	 */
	public function can($fn, $user) {
        Gate::policy($this->resource['model'], $this->resource['policy']);
		return class_exists($this->resource['policy'])?$user->can($fn, $this->resource['model']):true;
	}

	/**
	 * Define This Policy method in to construct
	 * @param Policy Class
	 * @return void
	 */
	public function definePolicy($policy) {

		if (class_exists($policy)) {
			// Check If Methods exists in Policy To Initial features
			if (method_exists($policy, 'viewAny')) {
				Gate::define('viewAny', $policy.'@viewAny');
			}

			if (method_exists($policy, 'create')) {
				Gate::define('create', $policy.'@create');
			}

			if (method_exists($policy, 'view')) {
				Gate::define('view', $policy.'@view');
			}

			if (method_exists($policy, 'update')) {
				Gate::define('update', $policy.'@update');
			}

			if (method_exists($policy, 'delete')) {
				Gate::define('delete', $policy.'@delete');
			}
			if (method_exists($policy, 'forceDelete')) {
				Gate::define('forceDelete', $policy.'@forceDelete');
			}
			if (method_exists($policy, 'restore')) {
				Gate::define('restore', $policy.'@restore');
			}
		}
	}
}
