<?php
namespace App\Policies;
use Dash\Policies\Policy;

class UserPolicy extends Policy {
	protected $resource = 'users';
}
