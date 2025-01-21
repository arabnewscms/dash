<?php
namespace Dash\Policies;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class Policy {
	use HandlesAuthorization;
	protected $resource;

	public function rule($rule_name) {
		$group = admin()->admingroup()->first();
		if (!empty($group) && !empty($this->resource)) {
			$roles = $group->roles()->where('resource', $this->resource)->first();
			if (!empty($roles)) {
				return $roles->{$rule_name} == 'yes';
			}
		}
		return false;
	}

	public function viewAny() {
		return $this->rule('show');
	}

	public function view() {
		return $this->rule('show');
	}

	public function create() {
		return $this->rule('create');
	}

	public function update() {
		return $this->rule('update');
	}

	public function delete() {
		return $this->rule('delete');
	}

	public function forceDelete() {
		return $this->rule('force_delete');
	}

	public function restore() {
		return $this->rule('restore');
	}
}
